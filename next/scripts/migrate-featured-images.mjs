/**
 * Migrate WordPress images into Sanity that the main importer skipped:
 *   - blog post featured images  → blogPost.featuredImage
 *   - attorney headshots         → attorney.headshot
 * (both come from each WP post's _thumbnail_id → featured_image URL).
 *
 *   node --env-file=.env.local scripts/migrate-featured-images.mjs          # dry run
 *   node --env-file=.env.local scripts/migrate-featured-images.mjs --write  # apply
 *
 * Idempotent + resumable: skips docs that already have the image field.
 * Sanity dedupes identical assets by content hash. Re-run AFTER any future
 * migrate-wp-to-sanity.mjs (a full re-import clears these fields again).
 */
import { createClient } from "@sanity/client";
import { readFileSync } from "fs";
import { resolve, dirname, basename } from "path";
import { fileURLToPath } from "url";

const WRITE = process.argv.includes("--write");
const TOKEN = process.env.SANITY_API_TOKEN;
if (!TOKEN) { console.error("Missing SANITY_API_TOKEN"); process.exit(1); }

const __dirname = dirname(fileURLToPath(import.meta.url));
const client = createClient({
  projectId: process.env.NEXT_PUBLIC_SANITY_PROJECT_ID || "wz6c0wck",
  dataset: process.env.NEXT_PUBLIC_SANITY_DATASET || "production",
  apiVersion: "2026-04-26",
  token: TOKEN,
  useCdn: false,
});

const data = JSON.parse(readFileSync(resolve(__dirname, "roden-export.json"), "utf-8"));

const TARGETS = [
  { exportKey: "post", type: "blogPost", idPrefix: "imported-blogPost-", field: "featuredImage" },
  { exportKey: "attorney", type: "attorney", idPrefix: "imported-attorney-", field: "headshot" },
];

let grandUploaded = 0, grandFailed = 0;

for (const t of TARGETS) {
  const items = (data[t.exportKey] || []).filter((p) => p.featured_image && String(p.featured_image).trim());
  const existing = new Set(await client.fetch(`*[_type==$type && defined(${t.field})]._id`, { type: t.type }));
  const todo = items.filter((p) => !existing.has(`${t.idPrefix}${p.id}`));
  console.log(`\n[${t.type}.${t.field}] export=${items.length} alreadySet=${existing.size} toDo=${todo.length}`);

  if (!WRITE) continue;

  for (const p of todo) {
    const docId = `${t.idPrefix}${p.id}`;
    const url = String(p.featured_image).trim();
    try {
      const res = await fetch(url);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const buf = Buffer.from(await res.arrayBuffer());
      const asset = await client.assets.upload("image", buf, {
        filename: basename(new URL(url).pathname) || `${p.slug}.jpg`,
        contentType: res.headers.get("content-type") || undefined,
      });
      await client
        .patch(docId)
        .set({ [t.field]: { _type: "image", asset: { _type: "reference", _ref: asset._id } } })
        .commit();
      grandUploaded++;
    } catch (e) {
      grandFailed++;
      console.warn(`  ✗ ${t.type} ${p.slug}: ${e.message}  (${url})`);
    }
  }
}

if (WRITE) {
  console.log(`\nDone. uploaded=${grandUploaded} failed=${grandFailed}`);
  for (const t of TARGETS) {
    const n = await client.fetch(`count(*[_type==$type && defined(${t.field})])`, { type: t.type });
    console.log(`  ${t.type}.${t.field} now: ${n}`);
  }
} else {
  console.log("\nDRY RUN — re-run with --write to apply.");
}
