/**
 * One-off cleanup: remove inline JSON-LD blocks that leaked into Portable Text
 * `body` fields during the WP import (the old converter didn't skip <script>).
 * The converter is now fixed (html-to-portable-text.mjs skips SCRIPT/STYLE), so
 * this only repairs already-imported docs.
 *
 *   node --env-file=.env.local scripts/strip-jsonld-from-body.mjs          # dry run
 *   node --env-file=.env.local scripts/strip-jsonld-from-body.mjs --write  # apply
 */
import { createClient } from "@sanity/client";

const WRITE = process.argv.includes("--write");
const TOKEN = process.env.SANITY_API_TOKEN;
if (!TOKEN) { console.error("Missing SANITY_API_TOKEN"); process.exit(1); }

const client = createClient({
  projectId: process.env.NEXT_PUBLIC_SANITY_PROJECT_ID || "wz6c0wck",
  dataset: process.env.NEXT_PUBLIC_SANITY_DATASET || "production",
  apiVersion: "2026-04-26",
  token: TOKEN,
  useCdn: false,
});

const blockText = (b) => (b?.children || []).map((c) => c?.text || "").join("").trim();
const isJsonLd = (b) =>
  b?._type === "block" && blockText(b).startsWith("{") && blockText(b).includes('"@context"');

// All docs whose body contains at least one JSON-LD-looking block.
const docs = await client.fetch(
  `*[defined(body) && count(body[_type=="block" && string(children[0].text) match "*@context*"]) > 0]{_id, _type, "slug": slug.current, body}`,
);
console.log(`${docs.length} docs have a JSON-LD block in body.`);

const txn = client.transaction();
let patched = 0, removed = 0;
for (const d of docs) {
  const cleaned = (d.body || []).filter((b) => !isJsonLd(b));
  const dropped = (d.body || []).length - cleaned.length;
  if (!dropped) continue;
  removed += dropped;
  patched++;
  console.log(`  ${d._type} ${d.slug || d._id}: removing ${dropped} block(s)`);
  if (WRITE) txn.patch(d._id, (p) => p.set({ body: cleaned }));
}

if (!WRITE) {
  console.log(`\nDRY RUN — would patch ${patched} docs, removing ${removed} blocks. Re-run with --write.`);
  process.exit(0);
}
const res = await txn.commit();
console.log(`\n✓ Patched ${res.results.length} docs (${removed} JSON-LD blocks removed).`);
