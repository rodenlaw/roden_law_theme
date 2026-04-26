# Technical SEO Monitor — Tools Reference

## Available Tools

### WebFetch
**Purpose:** Fetch live page content, HTTP headers, robots.txt, sitemaps, and API responses.

**Primary uses:**
- `robots.txt` — `GET https://rodenlawdev1.wpenginepowered.com/robots.txt`
- Sitemap index — `GET https://rodenlawdev1.wpenginepowered.com/wp-sitemap.xml`
- Individual CPT sitemaps — `GET https://rodenlawdev1.wpenginepowered.com/wp-sitemap-posts-practice_area-1.xml`
- Internal link verification — HEAD or GET on internal URLs to check HTTP status
- PageSpeed Insights API — `GET https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=[URL]&strategy=mobile&key=[API_KEY]`
- Live page fetch for internal link extraction

**Usage notes:**
- For HTTP status checks, a HEAD request is preferred when you only need the status code.
- For page content extraction (internal link audit), a full GET is required.
- The site URL is `https://rodenlawdev1.wpenginepowered.com/`. All internal links should be prefixed with this base when checking status.
- robots.txt fetches should be done every cycle — do not cache the response.

---

### WebSearch
**Purpose:** Supplementary research when diagnosing unfamiliar issues. Not used in standard checklist execution.

**Appropriate uses:**
- Looking up current Google documentation on a crawl error type
- Confirming whether a specific robots.txt directive syntax is valid
- Researching a PageSpeed Insights metric interpretation
- Investigating a WP Engine infrastructure issue

**Not appropriate for:**
- Verifying site-specific data (use WebFetch for live site checks)
- Checking competitor sites (that is Competitor Intelligence's scope)

---

### Read
**Purpose:** Read local theme files for audit reference.

**Primary uses:**
- `inc/legacy-redirects.php` — Read all 122 redirect rules for redirect chain audit
- `inc/rewrite-rules.php` — Reference URL rewrite structure when diagnosing 404 patterns
- `inc/firm-data.php` — Reference office data (slugs, URLs) for intersection page audit
- `agents/data/technical-seo-log.json` — Read previous cycle logs and rotation state
- `AGENTS.md`, `SOUL.md` — Identity and context check at session start

**File paths (absolute):**
```
/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/inc/legacy-redirects.php
/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/inc/rewrite-rules.php
/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/inc/firm-data.php
/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/agents/data/technical-seo-log.json
/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/agents/technical-seo-monitor/AGENTS.md
/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/agents/technical-seo-monitor/SOUL.md
/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/CLAUDE.md
```

---

### Grep
**Purpose:** Search within local files for specific patterns.

**Primary uses:**
- Find all `wp_redirect` or `header('Location:')` calls in `inc/legacy-redirects.php`
- Search for a specific source URL across redirect rules
- Find all internal links referencing a specific practice area slug in template files
- Identify which redirect rules reference a specific destination URL

**Example patterns:**
```
# Find redirect rule by source path
pattern: "'/old-slug'"
file: inc/legacy-redirects.php

# Find all redirect destinations pointing to a practice area slug
pattern: "car-accident-lawyers"
file: inc/legacy-redirects.php

# Find internal links in templates
pattern: "href=\"/practice-areas/"
path: templates/
```

---

### Paperclip API
**Purpose:** Create and manage issues for P0 and P1 findings.

**When to use:**
- Immediately after identifying any P0 finding (before continuing the checklist)
- At the end of Step 8 (log) and before Step 10 (report) for all P1 findings

**Issue structure:**
```
title:    "P[0|1]: [Concise description]"
label:    "technical-seo"
priority: "P0" | "P1"
body:     Structured description including:
          - Affected URL(s)
          - Measured value vs expected value
          - Severity rationale
          - Recommended fix
          - Detected in cycle: [cycle_number] ([timestamp])
```

**Do not create Paperclip issues for P2 or P3 findings.** Those are logged only.

---

### GSC API (Google Search Console API)
**Purpose:** Pull indexation coverage data and crawl error reports.

**Endpoints used:**

**URL Inspection API** — Check indexation status of specific URLs:
```
POST https://searchconsole.googleapis.com/v1/urlInspection/index:inspect
{
  "inspectionUrl": "[full URL]",
  "siteUrl": "https://rodenlawdev1.wpenginepowered.com/"
}
```

**Search Analytics API** — Coverage report data:
```
POST https://www.googleapis.com/webmasters/v3/sites/[site]/searchAnalytics/query
```

**Sitemaps API** — Sitemap submission status and indexed counts:
```
GET https://www.googleapis.com/webmasters/v3/sites/[site]/sitemaps
```

**Authentication:** OAuth 2.0 or service account credentials. API key stored in agent secrets — do not hardcode in logs or issue bodies.

**Rate limits:** GSC API has per-day quotas. For coverage checks, query aggregated data rather than checking individual URLs (reserve URL Inspection API for targeted diagnostics on specific 404 suspects).

---

### PageSpeed Insights API
**Purpose:** Core Web Vitals measurement for pillar and location pages.

**Endpoint:**
```
GET https://www.googleapis.com/pagespeedonline/v5/runPagespeed
  ?url=[ENCODED_URL]
  &strategy=mobile
  &category=performance
  &key=[API_KEY]
```

**Strategy:** Always use `strategy=mobile`. Mobile CWV is the primary ranking signal.

**Key response fields:**
```json
{
  "lighthouseResult": {
    "audits": {
      "largest-contentful-paint": { "numericValue": 2100 },
      "cumulative-layout-shift": { "numericValue": 0.04 },
      "interactive": { "numericValue": 3200 }
    }
  },
  "loadingExperience": {
    "metrics": {
      "LARGEST_CONTENTFUL_PAINT_MS": { "percentile": 2100, "category": "FAST" },
      "CUMULATIVE_LAYOUT_SHIFT_SCORE": { "percentile": 0.04, "category": "FAST" },
      "INTERACTION_TO_NEXT_PAINT": { "percentile": 180, "category": "FAST" }
    }
  }
}
```

**Prefer `loadingExperience` (field data) over `lighthouseResult` (lab data) when available.** Field data reflects real user experience. Lab data is a fallback for low-traffic pages.

**Thresholds:**
| Metric | Good | Needs Improvement | Poor |
|--------|------|-------------------|------|
| LCP | < 2.5s | 2.5–4.0s | > 4.0s |
| CLS | < 0.1 | 0.1–0.25 | > 0.25 |
| INP | < 200ms | 200–500ms | > 500ms |

---

### Data Store — technical-seo-log.json

**Location:** `agents/data/technical-seo-log.json`
**Absolute path:** `/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/agents/data/technical-seo-log.json`

**Purpose:** Persistent log of all cycle findings, rotation state, and open issues.

**Access pattern:**
1. Read at session start to load previous state and rotation offsets.
2. Write at Step 8 (log findings) to append the new cycle entry.
3. The Write tool is used for all updates — read the full file, modify the JSON, write back.

**Rotation state fields tracked:**
- `internal_link_set` — Current rotation set (A, B, C, or D)
- `redirect_rule_offset` — Which block of 15 rules was last sampled (0, 15, 30, 45, ... 120)
- `cwv_page_offset` — Which block of 9 pages was last audited (0, 9, 18)

**Initialize the file if it does not exist:**
```json
{
  "created": "[ISO timestamp]",
  "cycles": [],
  "rotation_state": {
    "internal_link_set": "A",
    "redirect_rule_offset": 0,
    "cwv_page_offset": 0
  },
  "open_issues": []
}
```
