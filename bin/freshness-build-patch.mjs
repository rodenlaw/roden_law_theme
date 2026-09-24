#!/usr/bin/env node
// Turn a refreshed run dir (body.html + meta.json vs their .before twins) into
// exact-match adapter edits, run the Tier B provenance checks on the diff, and
// optionally dry-run or apply them through the WordPress content adapter.
//
//   node build-patch.mjs <runDir> <postId> [--dry-run | --apply]
//
// Blocks are top-level HTML elements; a changed block becomes one edit whose
// `before` must occur exactly once in the live body (the patcher aborts
// otherwise). Numeric tokens added anywhere must exist in the pre-edit text,
// the facts pack, or data/statistics.json. Added outbound hosts must be on the
// allowlist, in the facts pack, or already linked by the post.
import fs from 'node:fs';
import path from 'node:path';
import { createAdapter } from '/Users/brianhaas/Code/blue-sky-studio/internal-ai-scripts/scripts/local-seo/lib/content-adapter.mjs';

const [runDir, postId, mode] = process.argv.slice(2);
if (!runDir || !postId) { console.error('usage: build-patch.mjs <runDir> <postId> [--dry-run|--apply]'); process.exit(1); }
const rd = (f) => fs.readFileSync(path.join(runDir, f), 'utf8');
const before = rd('body.before.html'); let after = rd('body.html');
const metaB = JSON.parse(rd('meta.before.json')), metaA = JSON.parse(rd('meta.json'));
const packFile = fs.readdirSync(runDir).find(f => /^facts-.*\.json$/.test(f));
const pack = packFile ? JSON.parse(rd(packFile)) : {};
const registry = JSON.parse(fs.readFileSync('/Users/brianhaas/Code/blue-sky-studio/client-rodenlaw-website/data/statistics.json', 'utf8'));

// --- block split: top-level elements of the body -------------------------------
// Top-level elements, plus any bare text between them (WordPress stores some
// paragraphs unwrapped and autop wraps them at render time). Inline elements
// at the top level (<strong>, <a>, <em>) are merged into the surrounding text
// run so a paragraph never splits into "bold phrase" + "rest of sentence".
const INLINE = /^(a|strong|em|b|i|span|code|sup|sub|u|small|abbr|cite|q|mark|time)$/i;
function blocks(html) {
  const out = []; let depth = 0, start = 0, cursor = 0, run = null;
  const tagRe = /<\/?([a-zA-Z][a-zA-Z0-9]*)[^>]*?(\/?)>/g; let m;
  const flushRun = () => { if (run !== null) { const t = html.slice(run.start, run.end); if (t.trim()) out.push(t); run = null; } };
  while ((m = tagRe.exec(html))) {
    const closing = m[0].startsWith('</'), selfClose = m[2] === '/' || /^(br|img|hr|input|meta|link)$/i.test(m[1]);
    if (depth === 0 && INLINE.test(m[1])) {
      // inline at top level: part of a bare text run
      if (run === null) run = { start: cursor, end: cursor };
      if (!closing && !selfClose) { depth++; run.inline = true; }
      continue;
    }
    if (depth > 0 && run && run.inline) {
      if (closing) { depth--; if (depth === 0) { run.end = m.index + m[0].length; run.inline = false; cursor = run.end; } }
      else if (!selfClose) depth++;
      continue;
    }
    if (!closing && !selfClose) {
      if (depth === 0) { if (run !== null) { run.end = m.index; flushRun(); } else { const t = html.slice(cursor, m.index); if (t.trim()) out.push(t); } start = m.index; }
      depth++;
    } else if (closing) {
      depth--; if (depth === 0) { out.push(html.slice(start, m.index + m[0].length)); cursor = m.index + m[0].length; }
    }
  }
  if (run !== null) { run.end = html.length; flushRun(); } else { const t = html.slice(cursor); if (t.trim()) out.push(t); }
  return out;
}
const bB = blocks(before), bA = blocks(after);

// --- LCS alignment of blocks ---------------------------------------------------
function align(a, b) {
  const n = a.length, m = b.length, L = Array.from({ length: n + 1 }, () => new Array(m + 1).fill(0));
  for (let i = n - 1; i >= 0; i--) for (let j = m - 1; j >= 0; j--) L[i][j] = a[i] === b[j] ? L[i + 1][j + 1] + 1 : Math.max(L[i + 1][j], L[i][j + 1]);
  const ops = []; let i = 0, j = 0;
  while (i < n && j < m) {
    if (a[i] === b[j]) { ops.push({ type: 'eq' }); i++; j++; }
    else if (L[i + 1][j] >= L[i][j + 1]) { ops.push({ type: 'del', i }); i++; }
    else { ops.push({ type: 'add', j }); j++; }
  }
  while (i < n) ops.push({ type: 'del', i: i++ });
  while (j < m) ops.push({ type: 'add', j: j++ });
  return ops;
}
const ops = align(bB, bA);
// pair adjacent del/add runs into replacements; lone adds attach to the previous unchanged block.
// 'eq' ops mark unchanged blocks so two change runs separated by untouched text are never
// merged into one edit (2026-09-24: a modified list and a paragraph inserted six blocks later
// became one edit whose 'after' re-included the six blocks between them; the simulation caught it).
const edits = [];
let k = 0;
while (k < ops.length) {
  if (ops[k].type === 'eq') { k++; continue; }
  const dels = [], adds = [];
  while (k < ops.length && ops[k].type === 'del') dels.push(bB[ops[k++].i]);
  while (k < ops.length && ops[k].type === 'add') adds.push(bA[ops[k++].j]);
  if (dels.length && adds.length) edits.push({ id: postId, surface: 'content', delBlocks: dels, addBlocks: adds });
  else if (dels.length) edits.push({ id: postId, surface: 'content', delBlocks: dels, addBlocks: [] });
  else if (adds.length) {
    // insertion: anchor on the block that precedes it in the AFTER text
    const firstAdded = adds[0]; const idx = bA.indexOf(firstAdded); const anchor = idx > 0 ? bA[idx - 1] : null;
    if (!anchor || !before.includes(anchor)) { console.error('cannot anchor insertion:', firstAdded.slice(0, 80)); process.exit(2); }
    edits.push({ id: postId, surface: 'content', delBlocks: [anchor], addBlocks: [anchor, ...adds] });
  }
}
// the joined 'before' must match the live text exactly once; the blocks are
// separated in the source by whatever whitespace WordPress stored, so re-derive
// each 'before' from the source slice instead of joining with '\n'.
const sliceOf = (src, blocksArr) => {
  const s = src.indexOf(blocksArr[0]); if (s < 0) throw new Error('block not found: ' + blocksArr[0].slice(0, 80));
  const last = blocksArr[blocksArr.length - 1]; const e = src.indexOf(last, s); if (e < 0) throw new Error('last block not found');
  // trailing whitespace belongs to the gap between blocks, not to the edit: a bare-text run
  // captured with its trailing newline would otherwise double the line break on insertion
  return src.slice(s, e + last.length).replace(/\s+$/, '');
};
for (const e of edits) {
  if (e.surface !== 'content') continue;
  e.before = sliceOf(before, e.delBlocks);
  e.after = e.addBlocks.length ? sliceOf(after, e.addBlocks) : '';
  delete e.delBlocks; delete e.addBlocks;
  const occ = before.split(e.before).length - 1;
  if (occ !== 1) { console.error(`'before' occurs ${occ} times:`, e.before.slice(0, 100)); process.exit(2); }
}
// --- simulate the body patch exactly as the patcher applies it (sequentially on a
// working copy) and require the result to equal the refreshed file byte for byte.
{
  let sim = before;
  edits.filter(e => e.surface === 'content').forEach((e, i) => {
    const occ = sim.split(e.before).length - 1;
    if (occ !== 1) { console.error(`simulation: edit ${i + 1} 'before' occurs ${occ} times in the working copy:`, e.before.slice(0, 120)); process.exit(2); }
    sim = sim.replace(e.before, () => e.after);
  });
  const nl = (t) => t.replace(/\r\n/g, '\n');
  if (nl(sim) !== nl(after)) {
    const a2 = nl(sim), b2 = nl(after); let k = 0; while (k < a2.length && a2[k] === b2[k]) k++; sim = a2; after = b2;
    console.error(`simulation: patched body differs from body.html at offset ${k}:\n  sim:   ${JSON.stringify(sim.slice(k, k + 120))}\n  after: ${JSON.stringify(after.slice(k, k + 120))}`);
    process.exit(2);
  }
}
// meta surfaces
if (metaA.excerpt !== metaB.excerpt) edits.push({ id: postId, surface: 'excerpt', before: metaB.excerpt, after: metaA.excerpt });
if (metaA.keyTakeaways !== metaB.keyTakeaways) edits.push({ id: postId, surface: 'meta:_roden_key_takeaways', before: metaB.keyTakeaways, after: metaA.keyTakeaways });
if (metaA.metaDescription !== metaB.metaDescription) edits.push({ id: postId, surface: 'meta:_roden_meta_description', before: metaB.metaDescription, after: metaA.metaDescription });
(metaA.faqs || []).forEach((f, i) => {
  const b = metaB.faqs[i]; if (!b) { console.error('FAQ added at', i, '— not supported by the patcher'); process.exit(2); }
  if (f.answer !== b.answer) edits.push({ id: postId, surface: `faq:${i}:answer`, before: b.answer, after: f.answer });
  if (f.question !== b.question) edits.push({ id: postId, surface: `faq:${i}:question`, before: b.question, after: f.question });
});
if ((metaA.faqs || []).length !== (metaB.faqs || []).length) { console.error('FAQ count changed — not supported'); process.exit(2); }

// --- provenance checks ---------------------------------------------------------
const strip = (h) => h.replace(/<[^>]+>/g, ' ').replace(/&nbsp;|&#8217;|&#8211;|&#038;|&amp;/g, ' ');
const numTok = (t) => new Set((strip(t).match(/\d[\d,.]*/g) || []).map(x => x.replace(/[.,]$/, '')));
const allowedNums = new Set([...numTok(before + JSON.stringify(metaB)), ...numTok(JSON.stringify(pack)), ...numTok(JSON.stringify(registry))]);
const addedText = edits.map(e => e.after).join('\n');
const violations = [];
for (const t of numTok(addedText)) if (!allowedNums.has(t)) violations.push(`numeric token "${t}" added without provenance`);
const hosts = (t) => new Set((t.match(/https?:\/\/([^/"'\s>]+)/g) || []).map(u => u.replace(/^https?:\/\//, '').toLowerCase()));
const ALLOW = ['nhtsa.gov', 'iihs.org', 'fmcsa.dot.gov', 'cdc.gov', 'gahighwaysafety.org', 'scdps.sc.gov', 'law.cornell.edu', 'ecfr.gov', 'osha.gov', 'bls.gov', 'cpsc.gov', 'nsc.org', 'sbwc.georgia.gov', 'law.justia.com', 'scstatehouse.gov', 'rodenlaw.com'];
const beforeHosts = hosts(before), packHosts = hosts(JSON.stringify(pack));
for (const h of hosts(addedText)) {
  const ok = beforeHosts.has(h) || packHosts.has(h) || ALLOW.some(d => h === d || h.endsWith('.' + d));
  if (!ok) violations.push(`outbound host "${h}" not allowlisted`);
}
for (const u of (addedText.match(/https:\/\/law\.justia\.com\/[^"'\s>]+/g) || [])) {
  if (u.includes("/codes/") && /\/\d{4}\//.test(u)) violations.push(`Justia URL not year-less: ${u}`);
  if (!before.includes(u) && !JSON.stringify(pack).includes(u)) violations.push(`Justia URL not from pack or pre-edit text: ${u}`);
}
const growth = (strip(after).split(/\s+/).length / strip(before).split(/\s+/).length - 1) * 100;
// the refresher's mandate is 'about 15%'; a post whose facts pack corrects several legal rules
// legitimately runs over. Warn past 15, refuse past 20.
const warnings = [];
if (growth > 20) violations.push(`body grew ${growth.toFixed(0)}% (>20%)`); else if (growth > 15) warnings.push(`body grew ${growth.toFixed(0)}% (over the ~15% mandate, under the 20% stop)`);
const idsB = (before.match(/id="[^"]+"/g) || []), idsA = (after.match(/id="[^"]+"/g) || []);
for (const id of idsB) if (!idsA.includes(id)) violations.push(`heading anchor removed: ${id}`);
for (const l of (before.match(/href="\/[^"]*"/g) || [])) if (!after.includes(l)) violations.push(`internal link removed: ${l}`);
if (/last reviewed/i.test(strip(after)) && !/last reviewed/i.test(strip(before))) violations.push('visible "Last reviewed" line added to the body (the theme renders it from meta)');

const report = { postId, edits: edits.length, warnings, bySurface: edits.reduce((a, e) => (a[e.surface.split(':')[0]] = (a[e.surface.split(':')[0]] || 0) + 1, a), {}), growthPct: +growth.toFixed(1), violations };
fs.writeFileSync(path.join(runDir, 'edits.json'), JSON.stringify(edits, null, 1));
fs.writeFileSync(path.join(runDir, 'verify.json'), JSON.stringify(report, null, 1));
console.log(JSON.stringify(report, null, 1));
if (violations.length) process.exit(3);
if (mode === '--dry-run' || mode === '--apply') {
  const adapter = await createAdapter({ client: 'roden' });
  const r = await adapter.write(edits, { apply: mode === '--apply' });
  console.log(r.stdout); if (r.stderr) console.error(r.stderr);
}
