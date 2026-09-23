import fs from 'node:fs';
import { createAdapter } from '/Users/brianhaas/Code/blue-sky-studio/internal-ai-scripts/scripts/local-seo/lib/content-adapter.mjs';
const mode = process.argv[2];
const adapter = await createAdapter({ client: 'roden', fresh: mode === '--fresh' || mode === '--apply' });
const docs = await adapter.readAll();
const WRONG = ['18442737858', '18442377858'];  // 844-273-7858 and 844-237-7858; RESULTS = 737-8587
const RIGHT = '18447378587';
const re = /tel:(\+?)(1?8442737858|1?8442377858)/g;
const edits = []; const visible = [];
for (const d of docs) {
  const surfaces = [['content', d.surfaces.body], ['excerpt', d.surfaces.excerpt], ...(d.surfaces.faqs || []).map((f, i) => [`faq:${i}:answer`, f.answer])];
  for (const [surface, text] of surfaces) {
    if (!text) continue;
    const hits = [...text.matchAll(re)];
    if (!hits.length) continue;
    // one edit per distinct href string; the patcher requires exactly-once, so require that here
    const distinct = [...new Set(hits.map(h => h[0]))];
    for (const before of distinct) {
      const occ = text.split(before).length - 1;
      const after = before.replace(/1?8442737858|1?8442377858/, RIGHT);
      if (occ !== 1) { console.error(`SKIP ${d.id} ${surface}: "${before}" occurs ${occ} times`); continue; }
      edits.push({ id: d.id, surface, before, after, url: d.url });
    }
    for (const m of text.matchAll(/844[-.\s]?2[37][37][-.\s]?7858/g)) visible.push({ id: d.id, url: d.url, surface, text: m[0] });
  }
}
console.log(`edits: ${edits.length} across ${new Set(edits.map(e => e.id)).size} documents; visible wrong-number text occurrences: ${visible.length}`);
if (visible.length) console.log(JSON.stringify(visible.slice(0, 10), null, 0));
fs.writeFileSync('/private/tmp/claude-501/-Users-brianhaas-Code-blue-sky-studio-client-rodenlaw-website/90f6f2a0-95e5-4007-9a11-40fd8bb2e049/scratchpad/fresh/phone/edits.json', JSON.stringify(edits, null, 1));
for (const e of edits.slice(0, 40)) console.log(`  ${e.id} ${e.surface.padEnd(14)} ${e.before} -> ${e.after}  ${e.url}`);
if (mode === '--dry-run' || mode === '--apply') {
  const r = await adapter.write(edits.map(({ id, surface, before, after }) => ({ id, surface, before, after })), { apply: mode === '--apply' });
  console.log(r.stdout); if (r.stderr) console.error(r.stderr);
}
