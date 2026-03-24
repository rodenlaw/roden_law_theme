# Schema Auditor — Heartbeat Protocol

**Cadence:** Weekly, every Tuesday
**Cron:** `0 7 * * 2`
**Estimated runtime:** 30–45 minutes per cycle
**Data store:** `agents/data/schema-coverage.json`

---

## Pre-Flight: Identity and Context Check

Before running any checks, confirm your operational context.

1. Read `AGENTS.md` to confirm your role, scope, and severity definitions.
2. Read `SOUL.md` to confirm your voice and assessment framework.
3. Read `agents/data/schema-coverage.json` — identify the last cycle timestamp, current coverage scores, rotation state (which page was last sampled per type), and any open issues.
4. Read `inc/schema-helpers.php` — note the 25 function names and which schema types each handles. This is the source of all schema output.
5. Confirm site URL: `https://rodenlawdev1.wpenginepowered.com/`
6. Log cycle start timestamp.

---

## Step 1: Live Schema Extraction and Validation

**Why:** The PHP source may generate schema conditionally. The only authoritative source of what schema actually renders is the live page output.

**Page rotation — one page per type per cycle:**

| Page Type | Rotation | This Cycle's Page |
|-----------|----------|-------------------|
| Homepage | Fixed (no rotation) | `https://rodenlawdev1.wpenginepowered.com/` |
| Pillar practice area | Rotate through 22 pillars | Read rotation state from schema-coverage.json |
| Intersection page | Rotate through 5 offices × multiple PAs | Read rotation state |
| Sub-type page | Rotate through ~69 sub-types | Read rotation state |
| Location page | Rotate through 5 locations | Read rotation state |
| Attorney page | Rotate through 8 attorneys | Read rotation state |
| Blog post | Use most recent published post | Fetch from `/blog/` or `/` and identify latest |

**Actions for each page:**
1. Fetch the page via WebFetch.
2. Extract all `<script type="application/ld+json">` blocks from the HTML.
3. Parse each JSON-LD block and confirm it is valid JSON. If not valid: **P0 — Paperclip issue immediately.**
4. For each schema block, identify the `@type` value.
5. Record all `@type` values found on the page. Compare to expected schema types for that page type (see AGENTS.md).
6. For each schema block, validate required and recommended fields (see Step 2 field checklists below).

---

## Step 2: Field-Level Compliance Checklists

Assess each schema block against Google's required and recommended properties.

### Organization / LawFirm (Homepage)
**Required (Google rich result eligibility):**
- [ ] `@type`: `["LegalService", "LocalBusiness"]` or `LawFirm`
- [ ] `name`
- [ ] `url`

**Recommended (coverage tracking):**
- [ ] `description`
- [ ] `telephone`
- [ ] `address` (with `streetAddress`, `addressLocality`, `addressRegion`, `postalCode`, `addressCountry`)
- [ ] `geo` (with `latitude`, `longitude`)
- [ ] `openingHours`
- [ ] `logo` (with `url`)
- [ ] `image`
- [ ] `sameAs` (array of profile URLs)
- [ ] `aggregateRating` (linked or inline)
- [ ] `priceRange`
- [ ] `areaServed`

### LegalService (Practice Area pages)
**Required:**
- [ ] `@type`: `LegalService`
- [ ] `name`
- [ ] `url`

**Recommended:**
- [ ] `description`
- [ ] `provider` (linking to the firm)
- [ ] `areaServed`
- [ ] `serviceType`
- [ ] `availableChannel`
- [ ] `telephone`
- [ ] `address`
- [ ] `jurisdiction`
- [ ] `knowsAbout`

### LocalBusiness (Location pages + Intersection pages)
**Required:**
- [ ] `@type`: `LocalBusiness` (or more specific subtype)
- [ ] `name`
- [ ] `address.streetAddress`
- [ ] `address.addressLocality`
- [ ] `address.addressRegion`
- [ ] `address.postalCode`

**Recommended:**
- [ ] `telephone`
- [ ] `url`
- [ ] `geo.latitude`
- [ ] `geo.longitude`
- [ ] `openingHours`
- [ ] `image`
- [ ] `sameAs`
- [ ] `aggregateRating`
- [ ] `priceRange`
- [ ] `description`
- [ ] `areaServed`

### Person / Attorney (Attorney pages + author attribution)
**Required:**
- [ ] `@type`: `Person`
- [ ] `name`

**Recommended:**
- [ ] `jobTitle`
- [ ] `url` (attorney profile page)
- [ ] `image`
- [ ] `description`
- [ ] `worksFor` (linking to firm)
- [ ] `alumniOf`
- [ ] `knowsAbout`
- [ ] `sameAs` (Avvo, Martindale, Super Lawyers, LinkedIn)
- [ ] `hasCredential` (bar admissions)
- [ ] `memberOf`

### FAQPage (Pillar practice area pages)
**Required:**
- [ ] `@type`: `FAQPage`
- [ ] `mainEntity` (array of Question objects)
- [ ] Each Question: `@type: Question`, `name` (the question text)
- [ ] Each Question: `acceptedAnswer` with `@type: Answer`, `text`

**Recommended:**
- [ ] Minimum 5 questions per page (Google considers 3+ but 5–8 is the target)
- [ ] Each answer is > 50 characters (substantive, not stub)
- [ ] Answers include statute citations where applicable
- [ ] Answers are jurisdiction-specific (GA vs SC where relevant)

### HowTo (Resource pages)
**Required:**
- [ ] `@type`: `HowTo`
- [ ] `name`
- [ ] `step` (array with at least 1 HowToStep)
- [ ] Each HowToStep: `@type: HowToStep`, `text`

**Recommended:**
- [ ] `description`
- [ ] `totalTime` (ISO 8601 duration)
- [ ] `estimatedCost`
- [ ] `image`
- [ ] Each step has `name` and `url`

### BreadcrumbList (All pages)
**Required:**
- [ ] `@type`: `BreadcrumbList`
- [ ] `itemListElement` (array of ListItem)
- [ ] Each ListItem: `@type: ListItem`, `position` (integer), `name`, `item` (URL)
- [ ] First item: Home (`/`)
- [ ] Last item: Current page (with correct URL)

**Recommended:**
- [ ] Position values are sequential integers starting at 1
- [ ] Breadcrumb depth matches URL depth (3 levels for intersection/sub-type pages)

### Speakable (Homepage + Pillar pages)
**Required:**
- [ ] `@type`: `SpeakableSpecification` (within a `speakable` property)
- [ ] `cssSelector` or `xPath` targeting relevant content sections

**Recommended:**
- [ ] Selectors target hero section text
- [ ] Selectors target FAQ answers
- [ ] Selectors are specific enough to avoid boilerplate (nav, footer)

### AggregateRating (Homepage)
**Required:**
- [ ] `ratingValue`
- [ ] `reviewCount`
- [ ] `bestRating`

**Values to verify (from firm stats):**
- `ratingValue`: 4.9
- `reviewCount`: 500+ (minimum; confirm against current actual count)
- `bestRating`: 5

### WebSite (Homepage)
**Required (Sitelinks Searchbox):**
- [ ] `@type`: `WebSite`
- [ ] `url`
- [ ] `potentialAction` with `@type: SearchAction`
- [ ] `potentialAction.target` with correct search URL template
- [ ] `potentialAction.query-input`

---

## Step 3: FAQ AI-Citation Readiness Audit

**Why:** FAQPage schema is the primary mechanism for Roden Law content to appear in AI-generated responses. Generic answers are invisible to AI citation. Specific, factual, statute-cited answers are citable.

**Scope:** Assess all FAQ answers on the pillar page sampled in Step 1.

**For each FAQ answer, evaluate:**

1. **Self-containment** — Can the answer be understood without reading the question or the surrounding page? An answer that begins "As mentioned above..." or "This depends on your case..." fails.
2. **Specificity** — Does the answer include specific facts, figures, timeframes, or dollar amounts relevant to the question?
3. **Statute citation** — For any answer touching legal deadlines, liability rules, or compensation limits: does it cite the specific statute? (O.C.G.A. § for Georgia, S.C. Code § for South Carolina)
4. **Jurisdictional accuracy** — If the answer involves GA or SC-specific law, does it correctly distinguish between the two? Does it avoid making one jurisdiction's rule sound universal?
5. **Length and completeness** — Is the answer substantive (50+ words preferred)? Does it actually answer the question?

**Scoring:** Rate each answer as: Excellent / Adequate / Needs Improvement / Failing.

**Failure action:**
- Any answer rated "Failing": **P2** — Log with specific rewrite guidance.
- If majority of answers (4+) are "Needs Improvement" or "Failing": **P1** — Paperclip issue.

---

## Step 4: Competitor Schema Comparison

**Why:** Competitors may implement schema types or properties we have not considered. This is intelligence gathering, not compliance checking.

**Scope:** One practice area per cycle. Rotate through practice areas over time.

**Actions:**
1. Read rotation state from `schema-coverage.json` to identify which practice area to compare this cycle.
2. Search for the top 3 competitor pages ranking for that practice area in Georgia or South Carolina. Use WebSearch: `"[practice area] lawyer Georgia" site:[competitor domain]` or similar.
3. For each competitor page:
   a. Fetch the page via WebFetch.
   b. Extract all JSON-LD schema blocks.
   c. Note `@type` values present.
   d. Note any properties Roden Law does not use but could.
   e. Note any schema types present that Roden Law lacks entirely for that page type.
4. Summarize findings as opportunities (not deficiencies).

**Examples of what to look for:**
- Do competitors include `hasOfferCatalog` on LegalService?
- Do competitors include `serviceArea` with `GeoCircle` on LocalBusiness?
- Do competitors mark up individual attorney bios with `knowsAbout` arrays?
- Do competitors use `Speakable` on FAQ sections specifically?
- Do competitors include `Video` schema on pages with embedded videos?

**Log:** Record competitor URLs, their schema types, and any opportunity findings. Classify as P3 (informational/opportunity).

---

## Step 5: AggregateRating Verification

**Why:** Inaccurate `aggregateRating` values can trigger Google manual review or user trust issues. The schema must reflect the actual review count and rating, which change over time.

**Actions:**
1. Fetch the homepage via WebFetch if not already fetched.
2. Extract `aggregateRating` values from the JSON-LD.
3. Verify: `ratingValue` is 4.9, `reviewCount` is accurate to current actual count (500+ minimum).
4. Cross-reference with `inc/firm-data.php` or `functions.php` to see where the hard-coded value lives in the PHP source.
5. If the value in schema diverges from the known actual count by more than 10%: **P1** — Paperclip issue.
6. Record the current claimed review count for trending across cycles.

---

## Step 6: Rich Results Test Verification

**Why:** Google's Rich Results Test confirms whether a page's schema meets eligibility criteria for rich SERP features. It surfaces warnings and errors that may not be visible in raw JSON-LD inspection.

**Scope:** 2–3 pages per cycle. Prioritize:
- Homepage (AggregateRating, LegalService, WebSite)
- The pillar page sampled in Step 1 (FAQPage)
- One location or attorney page (LocalBusiness or Person)

**Actions:**
1. Use the Rich Results Test API or tool reference for each page:
   - API endpoint: `https://searchconsole.googleapis.com/v1/urlTestingTools/mobileFriendlyTest:run` (note: Rich Results Test does not have a fully public API; use WebFetch on the tool or report from GSC rich result reports)
   - Alternative: Query GSC API for rich result status on these URLs.
2. Record:
   - Rich result types detected
   - Any errors (required field missing from Google's perspective)
   - Any warnings (recommended field missing)
3. Any errors: **P1** — Paperclip issue.
4. Warnings: **P2** — Log.

**Note:** If the Rich Results Test API is unavailable or rate-limited, use WebSearch for `site:rodenlawdev1.wpenginepowered.com` rich result status signals as a fallback. GSC rich results report data accessed via the GSC API is the preferred alternative.

---

## Step 7: Update schema-coverage.json

**Actions:**
1. Open `agents/data/schema-coverage.json`.
2. Append a new cycle entry with the following structure:

```json
{
  "cycle_id": "<ISO timestamp>",
  "cycle_number": <integer>,
  "status": "complete",
  "pages_audited": {
    "homepage": {
      "url": "https://rodenlawdev1.wpenginepowered.com/",
      "schema_types_found": [],
      "required_fields": { "pass": [], "fail": [] },
      "recommended_fields": { "present": [], "absent": [] },
      "issues": []
    },
    "pillar": {
      "url": "",
      "schema_types_found": [],
      "faq_count": 0,
      "faq_ai_citation_scores": [],
      "required_fields": { "pass": [], "fail": [] },
      "issues": []
    },
    "intersection": {
      "url": "",
      "schema_types_found": [],
      "required_fields": { "pass": [], "fail": [] },
      "issues": []
    },
    "subtype": {
      "url": "",
      "schema_types_found": [],
      "required_fields": { "pass": [], "fail": [] },
      "issues": []
    },
    "location": {
      "url": "",
      "schema_types_found": [],
      "required_fields": { "pass": [], "fail": [] },
      "issues": []
    },
    "attorney": {
      "url": "",
      "schema_types_found": [],
      "sameAs_count": 0,
      "required_fields": { "pass": [], "fail": [] },
      "issues": []
    },
    "blog": {
      "url": "",
      "schema_types_found": [],
      "required_fields": { "pass": [], "fail": [] },
      "issues": []
    }
  },
  "aggregate_rating_check": {
    "rating_value": null,
    "review_count": null,
    "status": "pass|fail"
  },
  "competitor_analysis": {
    "practice_area": "",
    "competitors_analyzed": [],
    "opportunities_identified": []
  },
  "rich_results_test": {
    "pages_tested": [],
    "errors": [],
    "warnings": []
  },
  "issues_created": [],
  "rotation_state": {
    "pillar_index": 0,
    "intersection_index": 0,
    "subtype_index": 0,
    "location_index": 0,
    "attorney_index": 0,
    "competitor_pa_index": 0
  },
  "summary": ""
}
```

3. Update `overall_coverage` summary metrics if tracked (e.g., "% of pillar pages with complete FAQPage schema" — calculated from cumulative cycle data).
4. Update rotation state for next cycle.
5. Save the file.

**Initialize the file if it does not exist:**
```json
{
  "created": "<ISO timestamp>",
  "cycles": [],
  "rotation_state": {
    "pillar_index": 0,
    "intersection_index": 0,
    "subtype_index": 0,
    "location_index": 0,
    "attorney_index": 0,
    "competitor_pa_index": 0
  },
  "coverage_summary": {
    "schema_types_confirmed": [],
    "known_gaps": [],
    "open_issues": []
  }
}
```

---

## Step 8: Create Paperclip Issues

For every P0 and P1 finding identified during this cycle:

1. Create a Paperclip issue with:
   - **Title:** Concise description (e.g., "P1: Missing BreadcrumbList schema on sub-type pages")
   - **Label:** `schema`
   - **Priority:** `P0` or `P1`
   - **Body:** Include:
     - Affected page URL(s)
     - Schema type affected
     - Missing or malformed field(s)
     - Google spec reference (link or quote)
     - Recommended fix (which function in `inc/schema-helpers.php` to update)
     - Detected in cycle: [cycle_number] ([timestamp])
2. Record the issue ID in the cycle log under `issues_created`.

P2 and P3 findings are logged only — no Paperclip issue required.

---

## Step 9: Report to SEO Strategist

Compose a structured report and deliver it to the SEO Strategist agent.

**Report format:**

```
SCHEMA AUDITOR — WEEKLY CYCLE REPORT
Cycle: [cycle_number] | Date: [YYYY-MM-DD]
Site: rodenlawdev1.wpenginepowered.com

SUMMARY: [1–2 sentence overall schema health assessment]

PAGES AUDITED THIS CYCLE:
- Homepage: [schema types found, key issues]
- Pillar ([page URL]): [schema types, FAQ count, AI-citation summary]
- Intersection ([page URL]): [schema types, key issues]
- Sub-type ([page URL]): [schema types, key issues]
- Location ([page URL]): [schema types, key issues]
- Attorney ([page URL]): [schema types, sameAs count, key issues]
- Blog ([page URL]): [schema types, key issues]

FAQ AI-CITATION SUMMARY:
[Per-answer ratings: Excellent / Adequate / Needs Improvement / Failing]
[Any answers flagged for rewrite — describe the deficiency and recommended content]

AGGREGATE RATING CHECK:
[ratingValue, reviewCount — pass or flag]

COMPETITOR SCHEMA ANALYSIS ([practice area]):
[Competitor 1 URL]: schema types found, opportunities noted
[Competitor 2 URL]: schema types found, opportunities noted
[Competitor 3 URL]: schema types found, opportunities noted
[Summary of opportunities]

RICH RESULTS TEST:
[Page: result / errors / warnings]
[Page: result / errors / warnings]

ISSUES CREATED THIS CYCLE:
[Paperclip issue IDs and one-line summaries, or "None"]

OPEN ISSUES FROM PREVIOUS CYCLES:
[List any unresolved P0/P1 issues, or "None"]

COVERAGE TREND:
[Brief note on whether schema coverage is improving, stable, or degrading based on cumulative cycle data]

RECOMMENDED ACTIONS FOR SEO STRATEGIST:
[Prioritized list — include which function in inc/schema-helpers.php needs updating for each fix]
```

---

## Step 10: Fact Extraction and Exit

Before closing the session, extract any new facts that should persist to memory:

- "Attorney [name] schema at [URL] is missing `sameAs` — confirmed [date]"
- "FAQPage on /practice-areas/[slug]/ confirmed [N] questions, all with statute citations"
- "Competitor [domain] uses `hasOfferCatalog` on LegalService pages — opportunity identified [date]"
- "AggregateRating review count updated to [N] as of [date]"
- "Sub-type pages confirmed to have no BreadcrumbList schema — P1 issue #[id] created"

Write these to the appropriate memory file if they represent durable knowledge.

Then: close the session. The cycle is complete.
