/**
 * One-off: migrate the 14 blog posts that exist only in the `v2` dataset into
 * `production` (the canonical dataset). See project_sanity_dataset_divergence.md.
 *
 *   node --env-file=.env.local scripts/migrate-v2-blog-posts.mjs          # dry run
 *   node --env-file=.env.local scripts/migrate-v2-blog-posts.mjs --write  # apply
 *
 * Transforms on copy:
 *   - set language:"en" (v2 docs have no language; the app filters language=="en")
 *   - drop `category` ref (v2 uses a `category` type that doesn't exist in
 *     production, which uses `practiceCategory`) → would be a broken ref
 *   - drop `featuredImage` (Sanity assets are per-dataset; the v2 asset ref
 *     wouldn't resolve in production) and any body image blocks for the same reason
 *   - strip system fields (_rev/_createdAt/_updatedAt); keep _id (blogPost.{slug},
 *     no collision with production's imported-blogPost-* ids)
 */
import { createClient } from "@sanity/client";

const WRITE = process.argv.includes("--write");
const TOKEN = process.env.SANITY_API_TOKEN;
if (!TOKEN) { console.error("Missing SANITY_API_TOKEN"); process.exit(1); }

const mk = (dataset) =>
  createClient({ projectId: "wz6c0wck", dataset, apiVersion: "2026-04-26", token: TOKEN, useCdn: false });
const v2 = mk("v2");
const prod = mk("production");

const SLUGS = [
  "darien-office-opening", "diminished-value-south-carolina", "first-72-hours-tractor-trailer",
  "fmcsa-hours-of-service-document-chain", "helmet-defense-rebuttal-sc", "jones-act-vs-lhwca-cooper",
  "mmi-does-not-mean-what-adjuster-says", "my-claim-got-denied-georgia", "porch-breakfasts-whitemarsh",
  "publix-slip-and-fall-sc", "read-a-settlement-offer-letter", "seven-things-first-hour",
  "talking-to-police-at-the-scene", "who-can-bring-wrongful-death-ga",
];

function bodyText(body) {
  if (!Array.isArray(body)) return "";
  return body
    .filter((b) => b._type === "block")
    .map((b) => (b.children || []).map((c) => c.text || "").join(""))
    .join(" ");
}

const docs = await v2.fetch(`*[_type == "blogPost" && slug.current in $slugs]`, { slugs: SLUGS });
console.log(`Fetched ${docs.length}/${SLUGS.length} from v2.\n`);

// These are seed STUBS (body is a "TODO: author…" placeholder), so import them
// as DRAFTS — preserves the planned title/excerpt in Studio without putting
// thin "TODO" pages on the live site / sitemap / queries.
// These are seed stubs with TODO/empty bodies. To avoid any cross-dataset
// broken references (category, featuredImage, authorAttorney, refs in body),
// whitelist only ref-free scalar fields. The team authors the body fresh.
const txn = prod.transaction();
let queued = 0;
for (const d of docs) {
  const draftId = d._id.startsWith("drafts.") ? d._id : `drafts.${d._id}`;
  const doc = {
    _id: draftId,
    _type: "blogPost",
    title: d.title,
    slug: d.slug,
    language: "en",
  };
  if (d.excerpt) doc.excerpt = d.excerpt;
  if (d.publishedAt) doc.publishedAt = d.publishedAt;
  if (d.seoMetaDescription) doc.seoMetaDescription = d.seoMetaDescription;
  if (d.keyTakeaways) doc.keyTakeaways = d.keyTakeaways;
  const chars = bodyText(d.body).length;
  console.log(`  ${d.slug.current}  | v2 body ${chars} chars (stub) → ${draftId} (title+excerpt only)`);
  txn.createOrReplace(doc);
  queued++;
}

if (!WRITE) {
  console.log(`\nDRY RUN — ${queued} posts would be written to production AS DRAFTS. Re-run with --write to apply.`);
  process.exit(0);
}

const res = await txn.commit();
console.log(`\n✓ Wrote ${res.results.length} DRAFT posts to production (language:"en"). They will NOT appear live until published in Studio.`);
const published = await prod.fetch(`count(*[_type=="blogPost" && language=="en" && !(_id in path("drafts.**"))])`);
console.log(`production published blogPost(en) unchanged at: ${published}`);
