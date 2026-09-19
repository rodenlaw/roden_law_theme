// Measure the doorway ratio from the live sitemap in seconds, without the crawl.
//
// `node vendor/site-health/site-health.mjs --live doorway` fetches every sitemap
// page before running any check — half an hour under WP Engine's throttling —
// but the doorway ratio and the granularity floor need only the sitemap and the
// classifier. This reads exactly what the check reads, with the vendored
// classifier, so the number is the number CI will report.
//
//   node bin/doorway-ratio-now.mjs                 # summary
//   node bin/doorway-ratio-now.mjs rows.json       # also write every URL's classification
//
// Used 2026-09-17..19 to take the site from 40.6% to 24.87% one batch at a time;
// see RECOVERY-LOG.md and data/site-health/doorway-audit-2026-09-18.md.
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { fetchSitemap } from '../vendor/site-health/lib/sitemap.mjs';
import { loadContext } from '../vendor/site-health/lib/config.mjs';
import { classifyPath } from '../vendor/site-health/checks/doorway-ratio.mjs';

const repo = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');
const base = 'https://rodenlaw.com';
const ctx = await loadContext({ repo, base, _: [] });
const sm = await fetchSitemap(base, {});
const rows = sm.paths.map((p) => { const c = classifyPath(p, ctx.geo.classify); return { url: p, geo: c.isGeo, belowFloor: c.belowFloor, place: c.place ?? null, hits: c.hits }; });
const geo = rows.filter((r) => r.geo).length;
const pct = (geo / rows.length) * 100;
const max = ctx.cfg.doorwayMaxPct || 25;
console.log(JSON.stringify({ at: new Date().toISOString(), total: rows.length, geo, pct: Number(pct.toFixed(2)), ceiling: max, pass: pct <= max, belowFloor: rows.filter((r) => r.belowFloor).length }, null, 1));
if (process.argv[2]) fs.writeFileSync(process.argv[2], JSON.stringify(rows, null, 1));
