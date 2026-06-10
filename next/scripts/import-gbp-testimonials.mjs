/**
 * Import the strongest Google Business reviews (synced via PostPlanify) into
 * Sanity as FEATURED testimonials, so the redesigned testimonials section +
 * Review JSON-LD populate with real client reviews.
 *
 *   node --env-file=.env.local scripts/import-gbp-testimonials.mjs          # dry run
 *   node --env-file=.env.local scripts/import-gbp-testimonials.mjs --write  # apply
 *
 * Source: the saved PostPlanify list_comments page dumps (pages 1-3 = 150 reviews).
 * Selects 10 five-star reviews with substantive text, spread across locations.
 */
import { createClient } from "@sanity/client";
import { readFileSync } from "fs";

const WRITE = process.argv.includes("--write");
const TOKEN = process.env.SANITY_API_TOKEN;
if (!TOKEN) { console.error("Missing SANITY_API_TOKEN"); process.exit(1); }
const COUNT = 10;

const TR = `${process.env.HOME}/.claude/projects/-Users-brianhaas-Library-CloudStorage-GoogleDrive-brian-blueskystud-io-Shared-drives-Blue-Sky-Studio-Roden-Law-Roden-Law-Project-Folder-roden-law/1bee72f9-088f-41d9-ba32-81dc22830b08/tool-results`;
const FILES = [
  `${TR}/mcp-postplanify-list_comments-1781024986148.txt`,
  `${TR}/mcp-postplanify-list_comments-1781025197336.txt`,
  `${TR}/mcp-postplanify-list_comments-1781025206510.txt`,
];

const client = createClient({
  projectId: process.env.NEXT_PUBLIC_SANITY_PROJECT_ID || "wz6c0wck",
  dataset: process.env.NEXT_PUBLIC_SANITY_DATASET || "production",
  apiVersion: "2026-04-26",
  token: TOKEN,
  useCdn: false,
});

// Gather reviews from the saved page dumps (dedupe by id).
const byId = new Map();
for (const f of FILES) {
  let arr = [];
  try { arr = (JSON.parse(readFileSync(f, "utf8")).data) || []; }
  catch (e) { console.warn("skip", f, e.message); continue; }
  for (const r of arr) if (r?.id) byId.set(r.id, r);
}
const reviews = [...byId.values()];
console.log(`Loaded ${reviews.length} unique reviews from ${FILES.length} pages.`);

const cityOf = (t = "", acctId = "") => {
  if (/north charleston|spruill/i.test(t)) return "North Charleston, SC";
  if (/charleston|king street|mount pleasant|west ashley|james island|johns island|daniel island|folly|ravenel/i.test(t)) return "Charleston, SC";
  if (/myrtle beach|murrells|conway|surfside|pawleys|grand strand/i.test(t)) return "Myrtle Beach, SC";
  if (/columbia|lexington|irmo/i.test(t)) return "Columbia, SC";
  if (/savannah|pooler|richmond hill|chatham/i.test(t)) return "Savannah, GA";
  if (/darien|brunswick|mcintosh|simons|jekyll/i.test(t)) return "Darien, GA";
  const map = {
    "530e12f0-52fe-4a79-9207-c5f1199b0725": "Darien, GA",
    "b525cde1-0863-419b-ae98-7a41fd388e79": "Myrtle Beach, SC",
    "c79a996c-c52d-48a2-bc8d-2fd108e0f691": "Charleston, SC",
    "7e73b2f6-a8f1-4daf-bdf9-df04275e3a10": "Columbia, SC",
    "3a4a2ec0-4274-4217-bfeb-cdbc2ca4188b": "North Charleston, SC",
  };
  return map[acctId] || null;
};
const caseOf = (t = "") => {
  if (/truck|tractor.?trailer|18.?wheeler|semi\b/i.test(t)) return "Truck Accident";
  if (/motorcycle|motorbike/i.test(t)) return "Motorcycle Accident";
  if (/wrongful death|killed|passed away/i.test(t)) return "Wrongful Death";
  if (/dog bite|dog attack|bitten|dog injury/i.test(t)) return "Dog Bite";
  if (/workers.?comp|work injury|on.the.job/i.test(t)) return "Workers' Compensation";
  if (/slip|trip|fall|premises/i.test(t)) return "Slip & Fall";
  if (/car (accident|crash|wreck)|auto (accident|crash)|rear.?end|t.?bone|collision|motor vehicle|car accident/i.test(t)) return "Car Accident";
  return null;
};
const slugify = (s) => s.toLowerCase().replace(/[^a-z0-9]+/g, "-").replace(/(^-|-$)/g, "");
const tokenOf = (id) => (id.split("/reviews/")[1] || id).replace(/[^a-zA-Z0-9]/g, "").slice(0, 28);

// Candidate pool: 5★, substantive, not too long.
const seenName = new Set();
const pool = reviews
  .filter((r) => r.rating === 5 && r.text && r.text.trim().length >= 140)
  .map((r) => {
    const text = r.text.replace(/\s+/g, " ").trim();
    const city = cityOf(r.text, r.socialAccount?.id);
    const caseType = caseOf(r.text);
    const len = text.length;
    const score = (city ? 2 : 0) + (caseType ? 2 : 0) + (len >= 160 && len <= 330 ? 3 : len <= 430 ? 1 : 0);
    return { r, text, city, caseType, len, score };
  })
  .sort((a, b) => b.score - a.score);

// Greedy pick: dedupe by client name, cap 2 per city, until COUNT.
const perCity = {};
const picked = [];
for (const cap of [2, 99]) { // first pass cap 2/city for spread, then fill
  for (const c of pool) {
    if (picked.length >= COUNT) break;
    const nameKey = (c.r.username || "").toLowerCase().trim();
    if (!nameKey || seenName.has(nameKey)) continue;
    const ck = c.city || "_";
    if ((perCity[ck] || 0) >= cap) continue;
    seenName.add(nameKey);
    perCity[ck] = (perCity[ck] || 0) + 1;
    picked.push(c);
  }
  if (picked.length >= COUNT) break;
}

console.log(`\nSelected ${picked.length} testimonials:\n`);
const docs = picked.map((c) => {
  const excerpt = c.text.length > 320 ? c.text.slice(0, 317).replace(/\s+\S*$/, "") + "…" : c.text;
  const id = `testimonial-gbp-${tokenOf(c.r.id)}`;
  const dateOf = (c.r.timestamp || "").slice(0, 10) || undefined;
  console.log(`  ${c.r.username.padEnd(22)} ${(c.city||"—").padEnd(20)} ${(c.caseType||"—").padEnd(22)} ${c.len}c`);
  const doc = {
    _id: id,
    _type: "testimonial",
    clientName: c.r.username,
    slug: { _type: "slug", current: `${slugify(c.r.username)}-${tokenOf(c.r.id).slice(0, 6)}` },
    excerpt,
    reviewBody: [{ _type: "block", _key: "b0", style: "normal", markDefs: [], children: [{ _type: "span", _key: "s0", text: c.text, marks: [] }] }],
    rating: 5,
    source: "google",
    featured: true,
    language: "en",
  };
  if (c.city) doc.city = c.city;
  if (c.caseType) doc.caseType = c.caseType;
  if (dateOf) doc.dateOf = dateOf;
  // Link to the firm's Google Business listing for that location (Google's
  // synced reviews don't expose a per-review permalink, so we link the GBP).
  const q = c.city ? `Roden Law ${c.city}` : "Roden Law personal injury Georgia South Carolina";
  doc.sourceUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(q)}`;
  return doc;
});

if (!WRITE) {
  console.log(`\nDRY RUN — would createOrReplace ${docs.length} featured testimonials. Re-run with --write.`);
  process.exit(0);
}
const txn = client.transaction();
docs.forEach((d) => txn.createOrReplace(d));
const res = await txn.commit();
console.log(`\n✓ Wrote ${res.results.length} featured testimonials.`);
const n = await client.fetch(`count(*[_type=="testimonial" && featured==true && defined(excerpt)])`);
console.log(`featured testimonials with excerpt now: ${n}`);
