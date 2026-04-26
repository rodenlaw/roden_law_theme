# Content Refresher — Tool Inventory

This document lists every tool this agent is authorized to use, how to use it, and any constraints or rate-limit considerations.

---

## Read

**Purpose:** Read local theme files to inspect page content, template structure, seeder data, and configuration.

**Key files to read:**

| File | Purpose |
|------|---------|
| `agents/data/content-health.json` | Current content health data store |
| `memory/rotation-state.json` | Tracks which cluster was audited and what is next |
| `memory/cycle-log.json` | Historical cycle records |
| `inc/firm-data.php` | Canonical office data, phone numbers, city slugs |
| `CLAUDE.md` | Practice area slugs, jurisdiction law, firm stats, architecture |
| `inc/meta-boxes.php` | Custom field definitions — especially `_roden_faqs`, `_roden_jurisdiction`, `_roden_author_attorney` |
| `templates/template-practice-area.php` | Pillar page template — check for stat references, internal link structure |
| `templates/template-intersection.php` | Intersection template — check for local content tokens, jurisdiction logic |
| `templates/template-subtype.php` | Sub-type template — check for differentiation |
| `agents/content-director/memory/inbox.md` | Content Director inbox — append reports here |
| `agents/data/qa-discoveries.json` | Q&A discoveries from Local Q&A Scout — cross-reference FAQ gaps |

**Usage notes:**
- Always read `content-health.json` before writing to it. Preserve all existing records.
- Read seeder scripts in `inc/` when you need to verify FAQ content that is seeded into the database rather than hardcoded in templates.

---

## Grep

**Purpose:** Search theme files for specific content patterns — statute citations, stat references, internal links, FAQ data, and post slugs.

**Key search patterns:**

| Pattern | Purpose |
|---------|---------|
| `O.C.G.A.` | Find all Georgia statute citations across the theme |
| `S.C. Code` | Find all South Carolina statute citations |
| `§ 9-3-33` | Verify the exact Georgia personal injury SOL section |
| `§ 15-3-530` | Verify the exact South Carolina personal injury SOL section |
| `§ 51-12-33` | Verify Georgia comparative fault section |
| `\$250M` or `250 million` | Find firm stat references (recovery amount) |
| `500\+.*review` or `reviews` near count | Find review count stat references |
| `5,000\+.*case` | Find case count stat references |
| `62 years` | Find experience stat references |
| `4\.9` near `star` or `rating` | Find rating stat references |
| `_roden_faqs` | Find FAQ repeater data in seeder scripts |
| `_roden_author_attorney` | Find attorney attribution assignments |
| `[pa-slug]` | Find all mentions of a practice area across templates and posts |
| `href.*[city-slug]` | Find internal links to a specific city intersection page |
| `[city-slug]` near `href` | Find links pointing to a page in a specific city |

**Directories to search:**
- `inc/` — Seeder scripts, firm data, meta box definitions
- `templates/` — All template files and parts
- Root PHP files — `functions.php`, `single-practice_area.php`, etc.

**Directories to exclude:**
- `node_modules/`
- `assets/` (CSS/JS — not content)
- `.git/`

---

## WebSearch

**Purpose:** Supplement the audit with SERP data — check ranking positions, identify competing pages, verify that a cluster page is indexed and ranking as expected.

**Usage pattern:**
```
Query: "car accident lawyer Savannah GA"
→ Check: Is Roden Law ranking? What position? Are any other Roden Law pages cannibalizing?
```

**Key query types:**

| Query Template | Purpose |
|----------------|---------|
| `[practice area] lawyer [city] [state]` | Check ranking position for primary target query |
| `site:rodenlaw.com [pa-slug]` | Find all indexed pages for a practice area (cannibalization check) |
| `[practice area] [city] site:rodenlaw.com` | Confirm intersection page is indexed |
| `"Roden Law" [pa-slug]` | Branded + practice area query |

**Constraints:**
- Maximum 10 searches per cycle.
- Do not use search results to assess competitor content quality — only for understanding SERP structure and Roden Law's indexed pages.
- If a page is not appearing in results for its target query, log this as a potential decay signal even if GSC data is unavailable.

---

## WebFetch

**Purpose:** Retrieve external data when needed — primarily for verifying statute accuracy against official sources.

**Authorized external sources:**
- `law.justia.com` — Verify O.C.G.A. and S.C. Code sections
- `law.co.ga.us` or official Georgia General Assembly site — Verify GA statute text
- `scstatehouse.gov` — Verify SC statute text

**Usage in practice:**
If a page cites O.C.G.A. § 9-3-33, fetch the official statute page to confirm:
1. The section number is correct
2. The limitation period stated on the Roden Law page matches the actual statute
3. The statute has not been amended to change the limitation period

**Constraints:**
- Maximum 5 WebFetch calls per cycle. Use primarily for statute verification when you have a specific concern.
- Do not fetch the live Roden Law site to read page content. Use theme files directly.

---

## Paperclip API

**Purpose:** Create content refresh issues for findings with severity 3 or higher.

**Issue creation:**
```
POST /issues
{
  "title": "[Content Refresh] Pillar — car-accident-lawyers: Missing SC statute citation",
  "labels": ["content-refresh", "car-accident-lawyers", "pillar", "severity-4"],
  "body": "[Full issue body per HEARTBEAT.md Step 11 template]"
}
```

**Labels to apply:**

| Label | When to apply |
|-------|--------------|
| `content-refresh` | Always, on every issue created by this agent |
| `[pa-slug]` | The practice area slug (e.g., `car-accident-lawyers`) |
| `pillar` / `intersection` / `sub-type` | The page type |
| `severity-[N]` | The severity level of the primary finding |
| `critical` | Severity 5 findings |
| `high-priority` | Severity 4 findings |
| `stat-accuracy` | Outdated firm stats |
| `statute-accuracy` | Missing or incorrect statute citation |
| `thin-content` | Word count failures |
| `internal-linking` | Inbound link count failures |
| `cannibalization` | Keyword cannibalization findings |
| `content-decay` | GSC decline signals |
| `orphaned-page` | Pages with 0 inbound internal links |

**Constraints:**
- Do not create duplicate issues. Search existing issues for the page slug and finding type before creating.
- Maximum 15 issues per cycle (see HEARTBEAT.md Step 11).

---

## GSC API (Google Search Console)

**Purpose:** Retrieve impression, click, and position data for pages in the audited cluster to detect content decay.

**Note:** This is a reference integration. If GSC API credentials are not available in the environment, skip Steps 7 decay checks and note the data gap in the report. The remainder of the audit proceeds without GSC data.

**Endpoint (if available):**
```
POST https://www.googleapis.com/webmasters/v3/sites/{siteUrl}/searchAnalytics/query
Authorization: Bearer [ACCESS_TOKEN]

{
  "startDate": "[28 days ago]",
  "endDate": "[today]",
  "dimensions": ["page"],
  "dimensionFilterGroups": [
    {
      "filters": [
        {
          "dimension": "page",
          "operator": "contains",
          "expression": "[page slug]"
        }
      ]
    }
  ]
}
```

**How to compare periods:**
Run the same query twice with different date ranges:
- Current period: last 28 days
- Prior period: 29–56 days ago

Calculate percentage change in impressions and clicks. Apply decay thresholds from HEARTBEAT.md Step 7.

---

## Data Store: content-health.json

**Location:** `agents/data/content-health.json`

**Purpose:** Persistent record of all page health audits across all cycles. Single source of truth for content quality tracking.

**File structure:**
```json
{
  "last_updated": "2026-03-20T08:00:00Z",
  "total_pages_audited": 0,
  "records": []
}
```

**Record schema:**
```json
{
  "page_slug": "string — WordPress post slug",
  "page_url_pattern": "string — URL pattern (e.g., /practice-areas/car-accident-lawyers/)",
  "page_type": "pillar | intersection | sub-type | location | attorney | blog | resource",
  "pa_cluster": "string — parent practice area slug",
  "last_audited": "YYYY-MM-DD",
  "audit_cycle": "number",
  "overall_health_score": "number 0–100",
  "findings": [
    {
      "check": "string — check name",
      "result": "pass | warning | fail",
      "evidence": "string — specific evidence",
      "severity": "number 1–5",
      "recommendation": "string — recommended action"
    }
  ],
  "word_count": "number | null",
  "faq_count": "number | null",
  "inbound_internal_links": "number | null",
  "gsc_impressions_28d": "number | null",
  "gsc_impressions_prior_28d": "number | null",
  "gsc_clicks_28d": "number | null",
  "gsc_avg_position_28d": "number | null",
  "has_attorney_attribution": "boolean",
  "statute_citations_present": ["array of citation strings found"],
  "issue_ids": ["array of Paperclip issue IDs created for this page"]
}
```

**Write rules:**
- Always read the current file before writing. Load all existing records.
- Upsert: if a record with the same `page_slug` already exists, replace it with the new audit data. Do not create duplicates.
- Update `last_updated` and `total_pages_audited` on every write.
- If the file does not exist, initialize it with the structure above and an empty records array.
