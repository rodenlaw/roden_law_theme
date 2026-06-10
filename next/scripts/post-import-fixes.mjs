/**
 * Idempotent fix-ups to apply AFTER every WordPress → Sanity re-import.
 *
 * The importer faithfully reproduces WordPress data, including a couple of
 * known-bad records. Re-run this after migrate-wp-to-sanity.mjs:
 *   node --env-file=.env.local scripts/post-import-fixes.mjs
 *
 * Currently fixes:
 *   - North Charleston: imported as a neighborhood with no officeKey, which
 *     makes /locations/south-carolina/north-charleston/ 404. Promote it to a
 *     real office page (officeKey="north-charleston", isNeighborhood=false).
 *
 * NOT handled here (needs human selection): featuring 4–6 testimonials
 * (set `featured = true`) so ReviewsBlock and Review schema populate.
 */
import { createClient } from "@sanity/client";

const TOKEN = process.env.SANITY_API_TOKEN;
if (!TOKEN) {
  console.error("Missing SANITY_API_TOKEN (use: node --env-file=.env.local …)");
  process.exit(1);
}

const client = createClient({
  projectId: process.env.NEXT_PUBLIC_SANITY_PROJECT_ID || "wz6c0wck",
  dataset: process.env.NEXT_PUBLIC_SANITY_DATASET || "production",
  apiVersion: "2026-04-26",
  token: TOKEN,
  useCdn: false,
});

async function fixNorthCharleston() {
  const docs = await client.fetch(
    `*[_type == "location" && slug.current == "north-charleston"]{_id, officeKey, isNeighborhood}`,
  );
  if (!docs.length) {
    console.log("• north-charleston: no doc found (skipped)");
    return;
  }
  for (const d of docs) {
    if (d.officeKey === "north-charleston" && d.isNeighborhood === false) {
      console.log(`• north-charleston (${d._id}): already correct`);
      continue;
    }
    await client.patch(d._id).set({ officeKey: "north-charleston", isNeighborhood: false }).commit();
    console.log(`• north-charleston (${d._id}): fixed → officeKey="north-charleston", isNeighborhood=false`);
  }
}

async function main() {
  console.log("=== Post-import fix-ups ===");
  await fixNorthCharleston();
  const featured = await client.fetch(`count(*[_type == "testimonial" && featured == true])`);
  if (featured === 0) {
    console.log(
      "\n⚠  0 featured testimonials. ReviewsBlock + Review schema will be empty until\n" +
        "   4–6 testimonials are flagged `featured = true` in Studio (≥2 cities, 3 case types).",
    );
  }
  console.log("\nDone.");
}

main().catch((e) => {
  console.error("Failed:", e.message);
  process.exit(1);
});
