/**
 * Import the 14 mass-tort / class-action sub-pages scraped from rodenlaw.com
 * (.firecrawl/ca-<slug>.json — clean .entry-content HTML + metadata) into Sanity
 * as `classAction` documents.
 *
 *   node --env-file=.env.local scripts/import-class-actions.mjs          # dry run
 *   node --env-file=.env.local scripts/import-class-actions.mjs --write  # apply
 */
import { createClient } from "@sanity/client";
import { readFileSync } from "fs";
import { parse } from "node-html-parser";
import { htmlToBlocks } from "./html-to-portable-text.mjs";

const WRITE = process.argv.includes("--write");
const TOKEN = process.env.SANITY_API_TOKEN;
if (!TOKEN) { console.error("Missing SANITY_API_TOKEN"); process.exit(1); }

// slug → card label, in the order they appear on the WP hub.
const CASES = [
  ["afff-firefighting-foam-lawsuits", "AFFF / PFAS Foam"],
  ["camp-lejeune-lawsuits", "Camp Lejeune"],
  ["hair-relaxer-cancer-lawsuits", "Hair Relaxer"],
  ["invokana", "Invokana"],
  ["ivc-filter", "IVC Filter"],
  ["onglyza", "Onglyza"],
  ["ozempic-lawsuits", "Ozempic"],
  ["paraquat-lawsuit", "Paraquat"],
  ["roundup", "Roundup"],
  ["stryker-hip-replacement", "Stryker Hip Replacement"],
  ["talcum-powder", "Talcum Powder"],
  ["troubled-teen-industry-abuse", "Troubled Teen Industry Abuse"],
  ["truvada", "Truvada"],
  ["uloric", "Uloric"],
];

const client = createClient({
  projectId: process.env.NEXT_PUBLIC_SANITY_PROJECT_ID || "wz6c0wck",
  dataset: process.env.NEXT_PUBLIC_SANITY_DATASET || "production",
  apiVersion: "2026-04-26",
  token: TOKEN,
  useCdn: false,
});

const cleanTitle = (t = "") => t.replace(/\s*[–|-]\s*Roden Law\s*$/i, "").trim();
// Keep links internal: drop the absolute rodenlaw.com origin.
const relativize = (html) => html.replace(/https?:\/\/(www\.)?rodenlaw\.com/gi, "");
// Firecrawl wraps content in <html><body><div><article>…; the converter wants
// the article's inner HTML, not the document wrapper.
const innerArticle = (html) => {
  const root = parse(html);
  const el = root.querySelector(".entry-content") || root.querySelector("article") || root.querySelector("body");
  return el ? el.innerHTML : html;
};

const docs = [];
for (let i = 0; i < CASES.length; i++) {
  const [slug, label] = CASES[i];
  const raw = JSON.parse(readFileSync(`.firecrawl/ca-${slug}.json`, "utf8"));
  const data = raw.data || raw;
  const meta = data.metadata || {};
  const html = data.html || "";
  const stats = {};
  const body = htmlToBlocks(relativize(innerArticle(html)), stats);
  const title = cleanTitle(meta.title) || label;
  const desc = (meta.description || "").trim();
  docs.push({
    slug,
    blocks: body.length,
    dropped: stats.droppedImages || 0,
    doc: {
      _id: `classAction-${slug}`,
      _type: "classAction",
      title,
      slug: { _type: "slug", current: slug },
      shortLabel: label,
      displayOrder: (i + 1) * 10,
      jurisdiction: "both",
      summary: desc || undefined,
      seoMetaDescription: desc ? desc.slice(0, 160) : undefined,
      body,
      language: "en",
    },
  });
}

console.log(`Prepared ${docs.length} classAction docs:\n`);
docs.forEach((d) =>
  console.log(`  ${d.slug.padEnd(34)} ${String(d.blocks).padStart(3)} blocks  (${d.doc.title})${d.dropped ? `  [${d.dropped} img dropped]` : ""}`)
);

if (!WRITE) {
  console.log(`\nDRY RUN — re-run with --write to createOrReplace in the production dataset.`);
  process.exit(0);
}
const tx = client.transaction();
docs.forEach((d) => tx.createOrReplace(d.doc));
const res = await tx.commit();
console.log(`\n✓ Wrote ${res.results.length} classAction docs.`);
const n = await client.fetch(`count(*[_type=="classAction" && language=="en"])`);
console.log(`classAction docs now: ${n}`);
