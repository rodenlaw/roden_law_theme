/**
 * WordPress → Sanity Content Migration
 *
 * Usage:
 *   1. SSH into WP Engine and run the export:
 *      wp eval-file wp-content/themes/roden-law/inc/wp-export.php
 *   2. SCP the export file locally:
 *      scp rodenlawprod@rodenlawprod.ssh.wpengine.net:/tmp/roden-export.json ./scripts/
 *   3. Run this script:
 *      node scripts/migrate-wp-to-sanity.mjs
 */

import { createClient } from "@sanity/client";
import { readFileSync } from "fs";
import { resolve, dirname } from "path";
import { fileURLToPath } from "url";

const __dirname = dirname(fileURLToPath(import.meta.url));

// --- Config ---
const PROJECT_ID = process.env.NEXT_PUBLIC_SANITY_PROJECT_ID || "wz6c0wck";
const DATASET = process.env.NEXT_PUBLIC_SANITY_DATASET || "production";
const TOKEN = process.env.SANITY_API_TOKEN;

if (!TOKEN) {
  console.error("Missing SANITY_API_TOKEN. Set it via env or .env.local");
  process.exit(1);
}

const client = createClient({
  projectId: PROJECT_ID,
  dataset: DATASET,
  apiVersion: "2026-04-26",
  token: TOKEN,
  useCdn: false,
});

// --- Load export ---
const EXPORT_PATH = resolve(__dirname, "roden-export.json");
let data;
try {
  data = JSON.parse(readFileSync(EXPORT_PATH, "utf-8"));
} catch (e) {
  console.error(`Cannot read ${EXPORT_PATH}. Run the WP export first.`);
  process.exit(1);
}

// --- Helpers ---
const OFFICE_SLUGS = new Set([
  "savannah-ga", "darien-ga", "charleston-sc",
  "north-charleston-sc", "columbia-sc", "myrtle-beach-sc",
]);

function htmlToBlocks(html) {
  if (!html || !html.trim()) return [];
  // Simple HTML → Portable Text conversion
  // Strips tags and creates basic block structure
  // For production, use @sanity/block-tools with JSDOM
  const text = html
    .replace(/<br\s*\/?>/gi, "\n")
    .replace(/<\/p>/gi, "\n\n")
    .replace(/<[^>]+>/g, "")
    .replace(/&amp;/g, "&")
    .replace(/&lt;/g, "<")
    .replace(/&gt;/g, ">")
    .replace(/&quot;/g, '"')
    .replace(/&#039;/g, "'")
    .replace(/&rsquo;/g, "\u2019")
    .replace(/&lsquo;/g, "\u2018")
    .replace(/&rdquo;/g, "\u201D")
    .replace(/&ldquo;/g, "\u201C")
    .replace(/&mdash;/g, "\u2014")
    .replace(/&ndash;/g, "\u2013")
    .replace(/&nbsp;/g, " ")
    .trim();

  if (!text) return [];

  return text.split(/\n\n+/).filter(Boolean).map((para, i) => ({
    _type: "block",
    _key: `block_${i}`,
    style: "normal",
    markDefs: [],
    children: [{ _type: "span", _key: `span_${i}`, text: para.trim(), marks: [] }],
  }));
}

function slugify(str) {
  return str.toLowerCase().replace(/[^a-z0-9]+/g, "-").replace(/(^-|-$)/g, "");
}

// Map WP post IDs to Sanity document IDs for references
const wpIdToSanityId = new Map();

function sanityId(type, wpId) {
  const id = `imported-${type}-${wpId}`;
  wpIdToSanityId.set(`${type}-${wpId}`, id);
  return id;
}

function sanityRef(type, wpId) {
  const id = wpIdToSanityId.get(`${type}-${wpId}`) || `imported-${type}-${wpId}`;
  return { _type: "reference", _ref: id };
}

// --- Migrate Taxonomies ---
async function migrateTaxonomies() {
  console.log("\n=== Migrating Taxonomies ===");
  const txn = client.transaction();

  for (const term of data.taxonomy) {
    if (term.taxonomy === "practice_category") {
      txn.createOrReplace({
        _id: `imported-practiceCategory-${slugify(term.slug)}`,
        _type: "practiceCategory",
        title: term.name,
        slug: { _type: "slug", current: term.slug },
      });
    } else if (term.taxonomy === "location_served") {
      txn.createOrReplace({
        _id: `imported-locationServed-${slugify(term.slug)}`,
        _type: "locationServed",
        title: term.name,
        slug: { _type: "slug", current: term.slug },
      });
    }
  }

  const result = await txn.commit();
  console.log(`  Created ${result.results.length} taxonomy documents`);
}

// --- Migrate Attorneys ---
async function migrateAttorneys() {
  console.log("\n=== Migrating Attorneys ===");
  const txn = client.transaction();

  for (const post of data.attorney) {
    const m = post.meta;
    const education = [];
    if (m._roden_education && Array.isArray(m._roden_education)) {
      for (const edu of m._roden_education) {
        education.push({
          _type: "education",
          _key: `edu_${education.length}`,
          degree: edu.degree || "",
          institution: edu.institution || "",
        });
      }
    }

    const awards = [];
    if (m._roden_awards && Array.isArray(m._roden_awards)) {
      for (const aw of m._roden_awards) {
        awards.push({
          _type: "award",
          _key: `award_${awards.length}`,
          name: aw.award || aw.name || "",
          year: aw.year || "",
        });
      }
    }

    const sameAs = [];
    if (m._roden_avvo_url) sameAs.push(m._roden_avvo_url);
    if (m._roden_linkedin_url) sameAs.push(m._roden_linkedin_url);

    txn.createOrReplace({
      _id: sanityId("attorney", post.id),
      _type: "attorney",
      name: post.title,
      slug: { _type: "slug", current: post.slug },
      jobTitle: m._roden_atty_title || m._roden_title || "",
      officeKey: m._roden_atty_office_key || m._roden_office_key || "",
      barAdmissions: m._roden_bar_admissions || "",
      education: education.length ? education : undefined,
      awards: awards.length ? awards : undefined,
      sameAs: sameAs.length ? sameAs : undefined,
      body: htmlToBlocks(post.content),
      seoMetaDescription: post.excerpt?.slice(0, 160) || "",
      language: "en",
    });
  }

  const result = await txn.commit();
  console.log(`  Created ${result.results.length} attorney documents`);
}

// --- Migrate Practice Areas ---
async function migratePracticeAreas() {
  console.log("\n=== Migrating Practice Areas ===");

  // First pass: create all documents (need IDs for parent refs)
  // Build parent map
  const parentMap = new Map();
  for (const post of data.practice_area) {
    parentMap.set(post.id, post);
  }

  // Determine page type
  function getPageType(post) {
    if (!post.parent) return "pillar";
    const officeKey = post.meta._roden_pa_office_key || post.meta._roden_office_key || "";
    if (officeKey || OFFICE_SLUGS.has(post.slug)) return "intersection";
    return "subtype";
  }

  const txn = client.transaction();

  for (const post of data.practice_area) {
    const m = post.meta;
    const pageType = getPageType(post);

    const faqs = [];
    if (m._roden_faqs && Array.isArray(m._roden_faqs)) {
      for (const faq of m._roden_faqs) {
        if (faq.question && faq.answer) {
          faqs.push({
            _type: "faq",
            _key: `faq_${faqs.length}`,
            question: faq.question,
            answer: faq.answer,
          });
        }
      }
    }

    const commonCauses = [];
    if (m._roden_common_causes && Array.isArray(m._roden_common_causes)) {
      for (const c of m._roden_common_causes) {
        if (typeof c === "string") commonCauses.push(c);
        else if (c.cause) commonCauses.push(c.cause);
      }
    }

    const commonInjuries = [];
    if (m._roden_common_injuries && Array.isArray(m._roden_common_injuries)) {
      for (const inj of m._roden_common_injuries) {
        commonInjuries.push({
          _key: `inj_${commonInjuries.length}`,
          name: inj.name || inj.injury || (typeof inj === "string" ? inj : ""),
          description: inj.description || "",
        });
      }
    }

    const doc = {
      _id: sanityId("practiceArea", post.id),
      _type: "practiceArea",
      title: post.title,
      slug: { _type: "slug", current: post.slug },
      pageType,
      officeKey: m._roden_pa_office_key || m._roden_office_key || "",
      jurisdiction: m._roden_jurisdiction || "both",
      solGa: m._roden_sol_ga || "",
      solSc: m._roden_sol_sc || "",
      heroIntro: m._roden_hero_intro || post.excerpt || "",
      expertQuote: m._roden_expert_quote || "",
      faqs: faqs.length ? faqs : undefined,
      commonCauses: commonCauses.length ? commonCauses : undefined,
      commonInjuries: commonInjuries.length ? commonInjuries : undefined,
      body: htmlToBlocks(post.content),
      whyHire: m._roden_why_hire ? htmlToBlocks(m._roden_why_hire) : undefined,
      seoMetaDescription: post.excerpt?.slice(0, 160) || "",
      language: "en",
    };

    // Parent reference
    if (post.parent) {
      doc.parent = sanityRef("practiceArea", post.parent);
    }

    // Author reference
    const authorId = m._roden_author_attorney;
    if (authorId) {
      doc.authorAttorney = sanityRef("attorney", authorId);
    }

    // Practice categories
    if (post.practice_category?.length) {
      doc.practiceCategories = post.practice_category.map((slug, i) => ({
        _type: "reference",
        _ref: `imported-practiceCategory-${slugify(slug)}`,
        _key: `pc_${i}`,
      }));
    }

    txn.createOrReplace(doc);
  }

  const result = await txn.commit();
  console.log(`  Created ${result.results.length} practice area documents`);
}

// --- Migrate Locations ---
async function migrateLocations() {
  console.log("\n=== Migrating Locations ===");
  const txn = client.transaction();

  for (const post of data.location) {
    const m = post.meta;
    const isNeighborhood = !!m._roden_is_neighborhood;

    const faqs = [];
    if (m._roden_faqs && Array.isArray(m._roden_faqs)) {
      for (const faq of m._roden_faqs) {
        if (faq.question && faq.answer) {
          faqs.push({ _type: "faq", _key: `faq_${faqs.length}`, question: faq.question, answer: faq.answer });
        }
      }
    }

    const doc = {
      _id: sanityId("location", post.id),
      _type: "location",
      title: post.title,
      slug: { _type: "slug", current: post.slug },
      isNeighborhood,
      officeKey: m._roden_office_key || "",
      parentOfficeKey: m._roden_parent_office_key || "",
      population: m._roden_neighborhood_population || "",
      court: m._roden_neighborhood_court || m._roden_court || "",
      roads: m._roden_neighborhood_roads || "",
      hospitals: m._roden_neighborhood_hospitals || "",
      landmarks: m._roden_neighborhood_landmarks || "",
      serviceArea: m._roden_neighborhood_service_area || m._roden_service_area || "",
      mapEmbed: m._roden_map_embed || "",
      faqs: faqs.length ? faqs : undefined,
      body: htmlToBlocks(post.content),
      seoMetaDescription: post.excerpt?.slice(0, 160) || "",
      language: "en",
    };

    if (post.parent) {
      doc.parentLocation = sanityRef("location", post.parent);
    }

    txn.createOrReplace(doc);
  }

  const result = await txn.commit();
  console.log(`  Created ${result.results.length} location documents`);
}

// --- Migrate Case Results ---
async function migrateCaseResults() {
  console.log("\n=== Migrating Case Results ===");
  const txn = client.transaction();

  for (const post of data.case_result) {
    const m = post.meta;
    const doc = {
      _id: sanityId("caseResult", post.id),
      _type: "caseResult",
      title: post.title,
      slug: { _type: "slug", current: post.slug },
      amount: m._roden_case_amount || "",
      resultType: m._roden_case_type || "",
      description: m._roden_description || "",
      body: htmlToBlocks(post.content),
      language: "en",
    };

    if (m._roden_attorney) {
      doc.leadAttorney = sanityRef("attorney", m._roden_attorney);
    }

    if (post.practice_category?.length) {
      doc.practiceCategories = post.practice_category.map((slug, i) => ({
        _type: "reference",
        _ref: `imported-practiceCategory-${slugify(slug)}`,
        _key: `pc_${i}`,
      }));
    }

    txn.createOrReplace(doc);
  }

  const result = await txn.commit();
  console.log(`  Created ${result.results.length} case result documents`);
}

// --- Migrate Testimonials ---
async function migrateTestimonials() {
  console.log("\n=== Migrating Testimonials ===");
  const txn = client.transaction();

  for (const post of data.testimonial) {
    txn.createOrReplace({
      _id: sanityId("testimonial", post.id),
      _type: "testimonial",
      clientName: post.title,
      slug: { _type: "slug", current: post.slug },
      reviewBody: htmlToBlocks(post.content),
      rating: 5,
      language: "en",
    });
  }

  const result = await txn.commit();
  console.log(`  Created ${result.results.length} testimonial documents`);
}

// --- Migrate Resources ---
async function migrateResources() {
  console.log("\n=== Migrating Resources ===");
  const txn = client.transaction();

  for (const post of data.resource) {
    const m = post.meta;
    const faqs = [];
    if (m._roden_faqs && Array.isArray(m._roden_faqs)) {
      for (const faq of m._roden_faqs) {
        if (faq.question && faq.answer) {
          faqs.push({ _type: "faq", _key: `faq_${faqs.length}`, question: faq.question, answer: faq.answer });
        }
      }
    }

    const doc = {
      _id: sanityId("resource", post.id),
      _type: "resource",
      title: post.title,
      slug: { _type: "slug", current: post.slug },
      jurisdiction: m._roden_jurisdiction || "both",
      keyTakeaways: m._roden_key_takeaways || "",
      body: htmlToBlocks(post.content),
      faqs: faqs.length ? faqs : undefined,
      seoMetaDescription: post.excerpt?.slice(0, 160) || "",
      language: "en",
    };

    if (m._roden_author_attorney) {
      doc.authorAttorney = sanityRef("attorney", m._roden_author_attorney);
    }

    txn.createOrReplace(doc);
  }

  const result = await txn.commit();
  console.log(`  Created ${result.results.length} resource documents`);
}

// --- Migrate Blog Posts ---
async function migrateBlogPosts() {
  console.log("\n=== Migrating Blog Posts ===");
  const txn = client.transaction();

  for (const post of data.post) {
    const m = post.meta;
    const faqs = [];
    if (m._roden_faqs && Array.isArray(m._roden_faqs)) {
      for (const faq of m._roden_faqs) {
        if (faq.question && faq.answer) {
          faqs.push({ _type: "faq", _key: `faq_${faqs.length}`, question: faq.question, answer: faq.answer });
        }
      }
    }

    const doc = {
      _id: sanityId("blogPost", post.id),
      _type: "blogPost",
      title: post.title,
      slug: { _type: "slug", current: post.slug },
      publishedAt: new Date(post.date).toISOString(),
      excerpt: post.excerpt || "",
      keyTakeaways: m._roden_key_takeaways || "",
      body: htmlToBlocks(post.content),
      faqs: faqs.length ? faqs : undefined,
      seoMetaDescription: post.excerpt?.slice(0, 160) || "",
      language: "en",
    };

    if (m._roden_author_attorney) {
      doc.authorAttorney = sanityRef("attorney", m._roden_author_attorney);
    }

    txn.createOrReplace(doc);
  }

  const result = await txn.commit();
  console.log(`  Created ${result.results.length} blog post documents`);
}

// --- Run ---
async function main() {
  console.log("=== Roden Law: WordPress → Sanity Migration ===");
  console.log(`Project: ${PROJECT_ID} / Dataset: ${DATASET}`);
  console.log(`Export file: ${EXPORT_PATH}`);
  console.log(`\nContent counts:`);
  for (const [type, posts] of Object.entries(data)) {
    if (Array.isArray(posts)) console.log(`  ${type}: ${posts.length}`);
  }

  // Order matters: taxonomies and attorneys first (referenced by others)
  await migrateTaxonomies();
  await migrateAttorneys();
  await migratePracticeAreas();
  await migrateLocations();
  await migrateCaseResults();
  await migrateTestimonials();
  await migrateResources();
  await migrateBlogPosts();

  console.log("\n=== Migration Complete ===");
}

main().catch((err) => {
  console.error("Migration failed:", err);
  process.exit(1);
});
