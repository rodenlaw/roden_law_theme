/**
 * Diff the LIVE WordPress site (firecrawl map → .firecrawl/rodenlaw-map.json)
 * against the Next.js preview's actual coverage: a live URL is OK if it either
 * matches a current Next route or is caught by the redirect resolver; otherwise
 * it would 404 after cutover.
 *
 *   node_modules/.bin/tsx scripts/diff-live-vs-preview.ts
 */
import { readFileSync } from "fs";
import { resolve, dirname } from "path";
import { fileURLToPath } from "url";
import { resolveLegacyRedirect } from "../lib/legacy-redirects.ts";
import { getPracticeAreaSlugs, getOfficeSlugs } from "../lib/firm-data.ts";

const __dirname = dirname(fileURLToPath(import.meta.url));
const map = JSON.parse(readFileSync(resolve(__dirname, "../.firecrawl/rodenlaw-map.json"), "utf-8"));
const PA = new Set(getPracticeAreaSlugs());
const OFFICES = new Set(getOfficeSlugs());

const RESERVED_TOP = new Set([
  "", "about", "contact", "testimonials", "case-results", "attorneys", "blog",
  "locations", "practice-areas", "class-action-lawyers", "resources",
  "georgia-car-accident-lawyer", "south-carolina-car-accident-lawyer",
  "south-carolina-rear-end-accident-lawyer", "truck-accident-lawyers-columbia-sc",
  "truck-accident-lawyers-near-me", "privacy-policy",
]);

function isRoute(path: string): boolean {
  const clean = path.replace(/\/+$/, "") || "/";
  if (clean === "/") return true;
  const s = clean.replace(/^\//, "").split("/");
  if (s.length === 1) return RESERVED_TOP.has(s[0]);
  if (s.length === 2) {
    if (["blog", "attorneys", "resources", "case-results"].includes(s[0])) return true;
    if (s[0] === "locations") return true; // state landing
    if (s[0] === "practice-areas") return PA.has(s[1]);
    if (PA.has(s[0])) return true; // intersection/subtype
  }
  if (s.length === 3 && s[0] === "locations") return true;
  if (s.length === 4 && s[0] === "locations") return true;
  return false;
}

const urls: string[] = map.data.links.map((l: { url: string }) => l.url);
const paths = urls.map((u) => { try { return new URL(u).pathname; } catch { return u; } });

let route = 0, redirected = 0;
const uncovered: string[] = [];
for (const p of paths) {
  if (isRoute(p)) route++;
  else if (resolveLegacyRedirect(p)) redirected++;
  else uncovered.push(p);
}

const byPrefix: Record<string, number> = {};
for (const p of uncovered) {
  const k = p.replace(/\/+$/, "").split("/")[1] || "(home)";
  byPrefix[k] = (byPrefix[k] || 0) + 1;
}

console.log(`\n=== LIVE rodenlaw.com (${paths.length} URLs) vs preview coverage ===`);
console.log(`  matches a Next route:  ${route}`);
console.log(`  caught by redirects:   ${redirected}`);
console.log(`  UNCOVERED (404):       ${uncovered.length}`);
console.log(`\n--- uncovered by path prefix ---`);
for (const [k, n] of Object.entries(byPrefix).sort((a, b) => b[1] - a[1])) console.log(`  /${k}: ${n}`);
console.log(`\n--- sample uncovered (first 25) ---`);
uncovered.slice(0, 25).forEach((p) => console.log(`  ${p}`));
