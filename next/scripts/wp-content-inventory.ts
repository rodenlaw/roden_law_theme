/**
 * WP Content Inventory Script
 *
 * Pulls every published piece of content from the WordPress REST API
 * and writes it to wp-content-inventory.json.
 *
 * Usage:  npx tsx scripts/wp-content-inventory.ts
 */

const BASE = "https://rodenlaw.com/wp-json/wp/v2";

interface WPItem {
  id: number;
  slug: string;
  title: { rendered: string };
  link: string;
  status: string;
  type: string;
}

interface InventoryItem {
  id: number;
  type: string;
  slug: string;
  title: string;
  url: string;
}

// All content-bearing post types and their REST bases
const POST_TYPES: Record<string, string> = {
  post: "posts",
  page: "pages",
  attorney: "attorney",
  "case-result": "case-result",
  "class-action": "class-action",
  "practice-area": "practice-area",     // legacy CPT
  practice_area: "practice_area",       // new CPT
  location: "location",
  resource: "resource",
  staff: "staff",
};

async function fetchAll(restBase: string, typeName: string): Promise<InventoryItem[]> {
  const items: InventoryItem[] = [];
  let page = 1;
  const perPage = 100;

  while (true) {
    const url = `${BASE}/${restBase}?per_page=${perPage}&page=${page}&status=publish`;
    const res = await fetch(url);

    if (res.status === 400) {
      // WP returns 400 when page exceeds total — done
      break;
    }
    if (!res.ok) {
      // Some CPTs may not be exposed or may be empty
      if (res.status === 404 || res.status === 401 || res.status === 403) {
        console.log(`  [${typeName}] Not accessible (${res.status}), skipping.`);
        break;
      }
      throw new Error(`Failed to fetch ${restBase} page ${page}: ${res.status}`);
    }

    const data: WPItem[] = await res.json();
    if (data.length === 0) break;

    for (const item of data) {
      items.push({
        id: item.id,
        type: typeName,
        slug: item.slug,
        title: item.title.rendered,
        url: item.link,
      });
    }

    // Check total pages from header
    const totalPages = parseInt(res.headers.get("X-WP-TotalPages") || "1", 10);
    if (page >= totalPages) break;
    page++;
  }

  return items;
}

async function main() {
  console.log("WordPress Content Inventory");
  console.log("===========================\n");

  const allItems: InventoryItem[] = [];
  const summary: Record<string, number> = {};

  for (const [typeName, restBase] of Object.entries(POST_TYPES)) {
    console.log(`Fetching ${typeName} (${restBase})...`);
    const items = await fetchAll(restBase, typeName);
    allItems.push(...items);
    summary[typeName] = items.length;
    console.log(`  Found ${items.length} published items.\n`);
  }

  // Write inventory
  const fs = await import("node:fs");
  const path = await import("node:path");
  const filePath = path.default.resolve(process.cwd(), "..", "wp-content-inventory.json");

  fs.writeFileSync(filePath, JSON.stringify({ summary, items: allItems }, null, 2));

  console.log("\n=== SUMMARY ===");
  let total = 0;
  for (const [type, count] of Object.entries(summary)) {
    console.log(`  ${type}: ${count}`);
    total += count;
  }
  console.log(`  ──────────────`);
  console.log(`  TOTAL: ${total} published items`);
  console.log(`\nWritten to: ${filePath}`);

  // Also extract just URLs for easy comparison
  const urlsPath = filePath.replace(".json", "-urls.txt");
  const urls = allItems.map((i) => i.url).sort();
  fs.writeFileSync(urlsPath, urls.join("\n"));
  console.log(`URL list written to: ${urlsPath}`);
}

main().catch((err) => {
  console.error("Error:", err);
  process.exit(1);
});
