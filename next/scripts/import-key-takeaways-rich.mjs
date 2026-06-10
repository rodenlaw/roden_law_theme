/**
 * Backfill resource.keyTakeawaysRich (Portable Text w/ bold) from the live WP
 * .key-takeaways-box markup scraped to .firecrawl/kt/<slug>.json. The plain
 * keyTakeaways field (machine copy) is left untouched.
 *
 *   node --env-file=.env.local scripts/import-key-takeaways-rich.mjs          # dry run
 *   node --env-file=.env.local scripts/import-key-takeaways-rich.mjs --write
 */
import { createClient } from "@sanity/client";
import { readFileSync, readdirSync } from "fs";
import { parse } from "node-html-parser";
import { htmlToBlocks } from "./html-to-portable-text.mjs";

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

const relativize = (html) => html.replace(/https?:\/\/(www\.)?rodenlaw\.com/gi, "");

const files = readdirSync(".firecrawl/kt").filter((f) => f.endsWith(".json"));
const idBySlug = new Map(
  (await client.fetch(`*[_type=="resource"]{ "slug": slug.current, _id }`)).map((d) => [d.slug, d._id])
);

let prepared = 0, skipped = 0;
const tx = client.transaction();
for (const f of files) {
  const slug = f.replace(/\.json$/, "");
  const id = idBySlug.get(slug);
  if (!id) { console.warn("no doc for", slug); skipped++; continue; }
  const raw = JSON.parse(readFileSync(`.firecrawl/kt/${f}`, "utf8"));
  const html = (raw.data || raw).html || "";
  const box = parse(html).querySelector(".key-takeaways-box");
  if (!box) { console.warn("no box for", slug); skipped++; continue; }
  box.querySelector(".key-takeaways-title")?.remove();
  const blocks = htmlToBlocks(relativize(box.innerHTML), {});
  if (!blocks.length) { console.warn("no blocks for", slug); skipped++; continue; }
  const strongSpans = blocks.flatMap((b) => b.children || []).filter((s) => (s.marks || []).length).length;
  console.log(`  ${slug.padEnd(40)} ${blocks.length} block(s), ${strongSpans} emphasized span(s)`);
  tx.patch(id, { set: { keyTakeawaysRich: blocks } });
  prepared++;
}

console.log(`\nPrepared ${prepared}, skipped ${skipped}.`);
if (!WRITE) { console.log("DRY RUN — re-run with --write."); process.exit(0); }
const res = await tx.commit();
console.log(`✓ Patched ${res.results.length} resource docs with keyTakeawaysRich.`);
