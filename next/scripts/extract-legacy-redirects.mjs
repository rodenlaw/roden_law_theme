/**
 * Extracts the static redirect map from the WordPress theme's
 * inc/legacy-redirects.php and writes it to lib/legacy-redirect-map.ts.
 *
 * Only pairs whose KEY starts with "/" are taken — that uniquely identifies the
 * roden_get_legacy_redirect_map() entries and excludes the pa_slug_map /
 * city_dest helper arrays (whose keys are bare slugs). `=> false` (410 Gone in
 * WP) is mapped to /practice-areas/ so the URL never 404s on the Next side.
 *
 * Re-run after editing the PHP:  node scripts/extract-legacy-redirects.mjs
 */
import { readFileSync, writeFileSync } from "fs";
import { resolve, dirname } from "path";
import { fileURLToPath } from "url";

const __dirname = dirname(fileURLToPath(import.meta.url));
const PHP = resolve(
  __dirname,
  "../../wordpress/wp-content/themes/roden-law/inc/legacy-redirects.php",
);
const OUT = resolve(__dirname, "../lib/legacy-redirect-map.ts");

const src = readFileSync(PHP, "utf-8");

const map = {};
let dropped410 = 0;

// '/old/path/' => '/new/path/'   |   '/old/' => false
const re = /'(\/[^']*)'\s*=>\s*(?:'([^']*)'|(false))/g;
let m;
while ((m = re.exec(src)) !== null) {
  const from = m[1];
  if (m[3] === "false") {
    map[from] = "/practice-areas/"; // WP returned 410; redirect to relevant index instead of 404
    dropped410++;
    continue;
  }
  map[from] = m[2];
}

const entries = Object.entries(map).sort(([a], [b]) => a.localeCompare(b));

const body = `/**
 * AUTO-GENERATED from wordpress/.../inc/legacy-redirects.php by
 * scripts/extract-legacy-redirects.mjs — do not edit by hand.
 * ${entries.length} exact-match legacy redirects. Re-run the script to refresh.
 */
export const STATIC_REDIRECTS: Record<string, string> = {
${entries.map(([from, to]) => `  ${JSON.stringify(from)}: ${JSON.stringify(to)},`).join("\n")}
};
`;

writeFileSync(OUT, body, "utf-8");
console.log(`Wrote ${entries.length} redirects to ${OUT} (${dropped410} former 410 → /practice-areas/)`);
