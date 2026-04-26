# Schema Auditor — Tools Reference

## Available Tools

### WebFetch
**Purpose:** Fetch live page HTML to extract rendered JSON-LD schema blocks, and call external APIs for validation.

**Primary uses:**
- Page fetch for schema extraction — `GET https://rodenlawdev1.wpenginepowered.com/[path]`
- Competitor page fetch — `GET https://[competitor-domain]/[path]`
- Rich Results Test API reference (see below)
- PageSpeed API (if needed as secondary signal)

**Schema extraction workflow:**
1. Fetch the full page HTML.
2. Locate all `<script type="application/ld+json">` tags.
3. Extract the text content of each tag.
4. Parse as JSON. Invalid JSON = P0 issue.
5. Inspect `@type`, required fields, recommended fields.

**Usage notes:**
- Fetch both mobile and desktop when testing, as WordPress may output different schema based on device detection (rare but possible).
- For competitor pages, note that some competitors use third-party schema plugins that inject schema after page load via JavaScript. If a competitor page shows no JSON-LD in the HTML, note this — it does not mean they have no schema.
- The site URL is `https://rodenlawdev1.wpenginepowered.com/`. Confirm all absolute URLs in schema blocks use this base (not a staging URL or non-canonical URL).

---

### Read
**Purpose:** Read local theme source files to understand how schema is generated and to cross-reference rendered output against PHP logic.

**Primary uses:**
- `inc/schema-helpers.php` — The authoritative source of all 25 schema functions. Read at session start and reference when diagnosing why a field is missing or incorrect.
- `inc/firm-data.php` — Office addresses, phone numbers, lat/lng coordinates. Cross-reference against `address` and `geo` fields in rendered LocalBusiness schema.
- `CLAUDE.md` — Architecture reference: which schema types are expected on which page types, firm stats (AggregateRating values), attorney list.
- `agents/data/schema-coverage.json` — Previous cycle data, rotation state, open issues.
- `agents/schema-auditor/AGENTS.md`, `SOUL.md` — Identity and context check at session start.

**File paths (absolute):**
```
/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/inc/schema-helpers.php
/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/inc/firm-data.php
/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/CLAUDE.md
/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/agents/data/schema-coverage.json
/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/agents/schema-auditor/AGENTS.md
/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/agents/schema-auditor/SOUL.md
```

**When to read schema-helpers.php:**
- When a required field is missing from rendered schema — find the generating function and diagnose whether the field is absent from the PHP or being suppressed by a conditional.
- When assessing whether a fix is straightforward (adding a property to an existing function) vs complex (requires new function or new hook).
- Always read the file to understand function names and line ranges before referencing them in Paperclip issue bodies.

---

### WebSearch
**Purpose:** Look up current Google schema specifications, schema.org type definitions, and competitor ranking pages.

**Primary uses:**
- Verify current Google required/recommended fields for a schema type: `"Google LegalService structured data requirements"`
- Find schema.org property definitions: `"schema.org LegalService properties"`
- Identify competitors ranking for a practice area: `"car accident lawyer Georgia site:domain.com"` or `"car accident lawyer Savannah"`
- Research a schema feature: `"Google FAQPage rich results 2025 requirements"`

**Usage notes:**
- Always verify that you are looking at current Google documentation (2024–2025). Schema requirements change. Use WebSearch to confirm before marking a property as "required" or "recommended."
- For competitor searches, target specific geographic markets: `"car accident lawyer Savannah GA"`, `"personal injury lawyer Charleston SC"`.
- Do not use WebSearch to verify site-specific data — use WebFetch for that.

---

### Paperclip API
**Purpose:** Create and manage issues for P0 and P1 findings.

**When to use:**
- Immediately after identifying any P0 finding (malformed JSON-LD, required field missing from schema type that affects rich result eligibility).
- At Step 8, after logging, for all P1 findings accumulated during the cycle.

**Issue structure:**
```
title:    "P[0|1]: [Schema type] — [Concise description of issue]"
label:    "schema"
priority: "P0" | "P1"
body:     Structured description including:
          - Affected page URL(s)
          - Schema @type affected
          - Missing or malformed field name(s)
          - Google spec reference or schema.org link
          - Recommended fix:
            - Function name in inc/schema-helpers.php
            - Approximate line number if known
            - What property to add and with what value source
          - Detected in cycle: [cycle_number] ([ISO timestamp])
```

**Example Paperclip issue body:**
```
Affected page: https://rodenlawdev1.wpenginepowered.com/practice-areas/car-accident-lawyers/

Schema @type: FAQPage
Issue: acceptedAnswer.text on Q4 is empty string.

Q4 text: "How long do I have to file a car accident claim in Georgia?"
Rendered answer: ""

Google spec: https://developers.google.com/search/docs/appearance/structured-data/faqpage
Requirement: "The answer must not be empty."

Recommended fix:
- Function: roden_output_faq_schema() in inc/schema-helpers.php (~line 380)
- The function appears to pull answer text from the _roden_faqs meta field.
  Check whether the meta value for this FAQ item is saved correctly in the database.
  If the meta is populated, the issue is in the PHP rendering logic.

Detected in cycle: 4 (2026-03-25T07:00:00Z)
```

Do not create Paperclip issues for P2 or P3 findings. Those are logged only.

---

### Google Rich Results Test — API Reference

**Purpose:** Verify that Google's schema parser correctly interprets the site's JSON-LD and that pages are eligible for rich results.

**Official documentation:** https://developers.google.com/search/docs/appearance/structured-data/

**Rich Results Test tool:** https://search.google.com/test/rich-results
(This is a browser-based tool. For programmatic access, use GSC rich results report via the API.)

**GSC Rich Results API (preferred for programmatic access):**
```
GET https://www.googleapis.com/webmasters/v3/sites/[SITE]/richResults
```

**Validator.schema.org (for schema.org compliance, separate from Google):**
```
GET https://validator.schema.org/
```

**Google's Search Console rich results report:**
- Accessible via GSC API under `searchAppearance` dimension
- Shows: Detected rich result types, errors (disqualifying), warnings (non-disqualifying), valid pages

**Key rich result types enabled by Roden Law's schema:**
| Schema Type | Rich Result |
|------------|-------------|
| FAQPage | FAQ rich result (expandable questions in SERP) |
| LocalBusiness | Knowledge Panel / Map Pack enrichment |
| BreadcrumbList | Breadcrumb in SERP snippet |
| AggregateRating | Star rating in SERP snippet |
| HowTo | How-to rich result (step cards) |
| Speakable | Google Assistant / AI voice citations |
| WebSite (SearchAction) | Sitelinks Searchbox |

---

### Data Store — schema-coverage.json

**Location:** `agents/data/schema-coverage.json`
**Absolute path:** `/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/agents/data/schema-coverage.json`

**Purpose:** Persistent audit log across all cycles. Tracks:
- Which pages were audited and when
- Field-level pass/fail for each schema type
- FAQ AI-citation scores
- AggregateRating values over time
- Competitor schema observations
- Open issues and their resolution status
- Rotation state for page sampling

**Access pattern:**
1. Read at session start to load rotation state and previous findings.
2. Write at Step 7 to append the new cycle entry and update rotation state.
3. Use the Write tool to update — read full file, modify, write back.
4. Never truncate previous cycle data — append only.

**Coverage summary metrics to maintain (cumulative across cycles):**
- `pillar_pages_with_faqpage`: count of pillar pages confirmed to have FAQPage schema
- `pages_with_breadcrumb`: count of pages per type confirmed to have BreadcrumbList
- `attorney_pages_with_sameas`: count of attorney pages with at least 3 sameAs links
- `faq_answers_ai_citation_ready`: percentage rated "Excellent" or "Adequate"
- `schema_types_confirmed_live`: list of @types confirmed in rendered output (not just PHP source)
