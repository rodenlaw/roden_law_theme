import fs from 'node:fs';
import { createAdapter } from '/Users/brianhaas/Code/blue-sky-studio/internal-ai-scripts/scripts/local-seo/lib/content-adapter.mjs';
const mode = process.argv[2];
const MAP = JSON.parse(fs.readFileSync('/private/tmp/claude-501/-Users-brianhaas-Code-blue-sky-studio-client-rodenlaw-website/90f6f2a0-95e5-4007-9a11-40fd8bb2e049/scratchpad/fresh/links/map.json', 'utf8')); // {badUrl: goodUrl}
const adapter = await createAdapter({ client: 'roden', fresh: mode === '--apply' });
const docs = await adapter.readAll();
const edits = [];
for (const d of docs) {
  const surfaces = [['content', d.surfaces.body], ['excerpt', d.surfaces.excerpt], ['meta:_roden_key_takeaways', d.surfaces.keyTakeaways], ...(d.surfaces.faqs || []).map((f, i) => [`faq:${i}:answer`, f.answer])];
  for (const [surface, text] of surfaces) {
    if (!text) continue;
    for (const [bad, good] of Object.entries(MAP)) {
      const occ = text.split(bad).length - 1; if (!occ) continue;
      if (surface === 'content' || surface === 'excerpt') {
        if (occ !== 1) { console.error(`SKIP ${d.id} ${surface}: "${bad}" occurs ${occ} times`); continue; }
        edits.push({ id: d.id, surface, before: bad, after: good, url: d.url });
      } else {
        // meta surfaces are whole-value replacements
        edits.push({ id: d.id, surface, before: text, after: text.split(bad).join(good), url: d.url });
      }
    }
  }
}
console.log(`edits: ${edits.length} across ${new Set(edits.map(e => e.id)).size} documents`);
fs.writeFileSync('/private/tmp/claude-501/-Users-brianhaas-Code-blue-sky-studio-client-rodenlaw-website/90f6f2a0-95e5-4007-9a11-40fd8bb2e049/scratchpad/fresh/links/edits.json', JSON.stringify(edits, null, 1));
if (mode === '--dry-run' || mode === '--apply') {
  const r = await adapter.write(edits.map(({ id, surface, before, after }) => ({ id, surface, before, after })), { apply: mode === '--apply' });
  console.log(r.stdout.split('\n').filter(l => /^(DRY RUN|APPLY|ABORT|skip)/.test(l)).join('\n') + '\n' + (r.stdout.match(/^(would|wrote)/gm) || []).length + ' would/wrote lines'); if (r.stderr) console.error(r.stderr);
}
