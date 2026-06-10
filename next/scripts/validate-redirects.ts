/**
 * Validates legacy-redirect coverage against redirects.csv (the list of old
 * URLs crawled before cutover — every one must redirect or map to a real route,
 * never 404).
 *
 * Run:  node scripts/validate-redirects.ts        (Node 23+ strips types)
 *   or: node_modules/.bin/tsx scripts/validate-redirects.ts
 *
 * Reports:
 *   1. UNCOVERED sources — CSV paths that neither redirect nor match a current
 *      route shape → must be added to the static map before cutover.
 *   2. SUSPECT destinations — redirect targets that don't look like a current
 *      route (e.g. root-level blog slugs that now live under /blog/).
 *   3. CHAINS — a destination that itself still redirects (double hop).
 *
 * Route checks are heuristic (no Sanity access here); treat the lists as a
 * to-verify queue, not gospel.
 */
import { readFileSync } from "fs";
import { resolve, dirname } from "path";
import { fileURLToPath } from "url";
import { resolveLegacyRedirect } from "../lib/legacy-redirects.ts";
import { getPracticeAreaSlugs, getOfficeSlugs } from "../lib/firm-data.ts";

const __dirname = dirname(fileURLToPath(import.meta.url));
const CSV = resolve(__dirname, "../../redirects.csv");

const PA = new Set(getPracticeAreaSlugs());
const OFFICES = new Set(getOfficeSlugs());

// Reserved top-level routes that exist as real pages.
const RESERVED_TOP = new Set([
  "", "about", "contact", "testimonials", "case-results", "attorneys",
  "blog", "locations", "practice-areas", "class-action-lawyers", "resources",
  // hardcoded SEO/landing pages in app/(site)
  "georgia-car-accident-lawyer", "south-carolina-car-accident-lawyer",
  "south-carolina-rear-end-accident-lawyer", "truck-accident-lawyers-columbia-sc",
  "truck-accident-lawyers-near-me", "privacy-policy",
]);

function looksLikeCurrentRoute(path: string): boolean {
  const clean = path === "/" ? "/" : path.replace(/\/+$/, "");
  if (clean === "/" || clean === "") return true;
  const segs = clean.replace(/^\//, "").split("/");

  if (segs.length === 1) return RESERVED_TOP.has(segs[0]);
  if (segs.length === 2) {
    if (segs[0] === "blog") return true;            // /blog/[slug]/
    if (segs[0] === "attorneys") return true;       // /attorneys/[slug]/
    if (segs[0] === "resources") return true;       // /resources/[slug]/
    if (segs[0] === "practice-areas") return PA.has(segs[1]); // pillar
    if (PA.has(segs[0])) return true;               // /[pa]/[child] intersection/subtype
  }
  if (segs.length === 3 && segs[0] === "locations") return true;     // /locations/[state]/[city]/
  if (segs.length === 4 && segs[0] === "locations") return true;     // .../[neighborhood]/
  // /[pa]/[office]/ intersection explicitly
  if (segs.length === 2 && PA.has(segs[0]) && OFFICES.has(segs[1])) return true;
  return false;
}

function pathOf(url: string): string {
  try {
    return new URL(url).pathname;
  } catch {
    return url.startsWith("/") ? url : `/${url}`;
  }
}

const lines = readFileSync(CSV, "utf-8").trim().split("\n").slice(1); // drop header
const paths = lines.map((l) => pathOf(l.split(",")[0].trim())).filter(Boolean);

let redirected = 0;
let current = 0;
const uncovered: string[] = [];
const suspectDest: { from: string; to: string }[] = [];
const chains: { from: string; to: string; then: string }[] = [];

for (const p of paths) {
  const dest = resolveLegacyRedirect(p);
  if (dest) {
    redirected++;
    if (!looksLikeCurrentRoute(dest)) suspectDest.push({ from: p, to: dest });
    const then = resolveLegacyRedirect(dest);
    if (then && then !== dest) chains.push({ from: p, to: dest, then });
  } else if (looksLikeCurrentRoute(p)) {
    current++;
  } else {
    uncovered.push(p);
  }
}

const uniq = <T,>(a: T[]) => Array.from(new Set(a.map((x) => JSON.stringify(x)))).map((s) => JSON.parse(s) as T);

console.log(`\n=== Redirect coverage vs redirects.csv (${paths.length} URLs) ===`);
console.log(`  redirected:          ${redirected}`);
console.log(`  already a route:     ${current}`);
console.log(`  UNCOVERED (→ 404):   ${uncovered.length}`);

if (uncovered.length) {
  console.log(`\n--- UNCOVERED sources (add to static map) ---`);
  uniq(uncovered).slice(0, 100).forEach((p) => console.log(`  ${p}`));
}
const sd = uniq(suspectDest);
if (sd.length) {
  console.log(`\n--- SUSPECT destinations (target may 404 in Next) [${sd.length}] ---`);
  sd.slice(0, 100).forEach(({ from, to }) => console.log(`  ${from}  →  ${to}`));
}
if (chains.length) {
  console.log(`\n--- REDIRECT CHAINS (double hop) [${chains.length}] ---`);
  uniq(chains).slice(0, 50).forEach(({ from, to, then }) => console.log(`  ${from} → ${to} → ${then}`));
}

console.log(
  `\nGATE: ${uncovered.length === 0 && sd.length === 0 && chains.length === 0 ? "PASS ✅" : "NEEDS WORK ⚠️"}\n`,
);
