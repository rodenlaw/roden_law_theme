# Technical SEO Monitor — Heartbeat Protocol

**Cadence:** Every 48 hours
**Cron:** `0 6 */2 * *`
**Estimated runtime:** 20–30 minutes per cycle
**Data store:** `agents/data/technical-seo-log.json`

---

## Pre-Flight: Identity and Context Check

Before running any checks, confirm your operational context.

1. Read `AGENTS.md` to confirm your role, scope, and severity definitions.
2. Read `SOUL.md` to confirm your voice and decision-making framework.
3. Read `agents/data/technical-seo-log.json` — identify the timestamp of the last cycle, any open P0/P1 issues, and page rotation state (which pillar pages were last audited for Core Web Vitals, which page sample was last used for internal link checks).
4. Confirm site URL: `https://rodenlawdev1.wpenginepowered.com/`
5. Log cycle start timestamp.

---

## Step 1: robots.txt AI Crawler Directives

**Why:** AI crawlers (GPTBot, ClaudeBot, PerplexityBot) must remain unblocked for AI citation strategy. Any accidental block is a P0 site-level issue.

**Actions:**
1. Fetch `https://rodenlawdev1.wpenginepowered.com/robots.txt` via WebFetch.
2. Check for `User-agent: GPTBot` — confirm no `Disallow: /` or broad disallow rule.
3. Check for `User-agent: ClaudeBot` — confirm no `Disallow: /` or broad disallow rule.
4. Check for `User-agent: PerplexityBot` — confirm no `Disallow: /` or broad disallow rule.
5. Check for any `Disallow: /wp-admin/` (expected, not a concern).
6. Check for any `Disallow: /` under `User-agent: *` that would catch AI crawlers (P0 if found).
7. Verify `Sitemap:` directive is present and points to `/wp-sitemap.xml`.

**Pass criteria:** GPTBot, ClaudeBot, PerplexityBot are explicitly allowed OR not mentioned (which defaults to allowed). No broad block exists.

**Failure actions:**
- Any AI crawler blocked: **P0** → Create Paperclip issue (label: `technical-seo`, priority: `P0`) → Alert SEO Strategist immediately before proceeding.

**Log:** Record full robots.txt content hash or last-modified date for change detection across cycles.

---

## Step 2: GSC Indexation Coverage

**Why:** The site targets 450+ indexed pages. Drops in coverage mean content is being excluded, which directly impacts ranking potential.

**Actions:**
1. Query GSC API for the current indexed page count (Inspection API or Coverage report).
2. Query for pages in "Excluded" states:
   - "Crawled — currently not indexed"
   - "Discovered — currently not indexed"
   - "Duplicate without canonical tag"
   - "Redirect error"
   - "Not found (404)"
3. Compare indexed count to last cycle's count. Flag any drop > 5 pages as P1. Flag any drop > 20 pages as P0.
4. Note the top 3 exclusion reasons by page count.
5. If available, pull the list of newly excluded URLs since last cycle.

**Pass criteria:** Indexed count >= 450, no single exclusion reason accounts for > 20 pages.

**Log:** Record indexed count, exclusion breakdown, and delta from last cycle.

---

## Step 3: GSC Crawl Errors

**Why:** Server errors and redirect issues in GSC indicate broken infrastructure. 404s on previously indexed pages signal content that was deleted or moved without proper redirects.

**Actions:**
1. Query GSC API for crawl errors over the last 7 days:
   - 404 (Not Found)
   - 5xx (Server Errors)
   - Redirect errors (redirect loop, too many redirects)
2. For each category, record:
   - Total error count
   - Top 5 URLs by error frequency
   - First detected / last detected dates
3. Cross-reference 404 URLs against `inc/legacy-redirects.php` — check whether a redirect rule exists but is broken, or whether no rule exists at all.
4. Any 5xx errors: P1 immediately. 10+ 404s: P1. 1–9 new 404s: P2.

**Failure actions:**
- 5xx errors: **P1** → Paperclip issue.
- New 404s on practice area, location, or attorney pages: **P1** → Paperclip issue.
- New 404s on blog/resource pages: **P2** → Log.

**Log:** Record error counts by type, top offending URLs, comparison to last cycle.

---

## Step 4: Internal Link 404 Audit

**Why:** Internal links that 404 waste crawl budget, damage PageRank flow, and create poor user experience. With 450+ pages and 8–13 internal links per practice area page, the total internal link graph is large and needs ongoing sampling.

**Actions:**
1. Read the rotation state from `technical-seo-log.json` to determine which page set to sample this cycle.
2. Rotation order (repeat after completing full cycle):
   - Cycle A: 5 pillar practice area pages
   - Cycle B: 5 intersection pages (one per office city)
   - Cycle C: 5 sub-type pages
   - Cycle D: 5 attorney or location pages
3. Fetch each page via WebFetch. Extract all `href` values from `<a>` tags that are internal links (matching `rodenlawdev1.wpenginepowered.com` or root-relative).
4. For each extracted URL, perform a HEAD request (or full fetch) to check HTTP status.
5. Flag any 4xx response as an internal link 404.
6. Record: source page URL, broken href, HTTP status returned.

**Sample size:** 20 pages per cycle (approximately). Prioritize pages with high internal link counts (pillar pages typically have 8–13 internal links).

**Failure actions:**
- Any 404 on an attorney, practice area, or location URL: **P1** → Paperclip issue with source page and broken URL.
- Any 404 on blog/resource URL: **P2** → Log.

**Log:** Record pages sampled, total links checked, broken link count, specific broken URLs.

---

## Step 5: Legacy Redirect Chain Audit

**Why:** `inc/legacy-redirects.php` contains 122 redirect rules accumulated over the site's history. Chains (A → B → C) waste crawl budget and dilute link equity. Rules that point to 404 destinations are effectively deleted pages.

**Actions:**
1. Read `inc/legacy-redirects.php` (use the Read tool on the local file).
2. From the rotation state in `technical-seo-log.json`, identify which 15 rules to sample this cycle (rotate through all 122 over ~8 cycles).
3. For each sampled rule:
   a. Identify the source URL and destination URL.
   b. Fetch the destination URL — confirm it returns 200.
   c. If the destination is itself a redirect (301/302), follow the chain and count hops.
   d. Flag any chain with 2+ hops as P2. Flag any destination returning 404 as P1.
4. Record rule line number, source, destination, final destination, hop count, final HTTP status.

**Failure actions:**
- Destination 404: **P1** → Paperclip issue citing line number in `inc/legacy-redirects.php`.
- Chain 2+ hops: **P2** → Log with consolidation recommendation.
- Chain 3+ hops: **P1** → Paperclip issue.

**Log:** Record sampled rule count, issues found, specific rules affected.

---

## Step 6: Core Web Vitals — PageSpeed Insights

**Why:** Core Web Vitals are a Google ranking factor. LCP, CLS, and INP on pillar practice area pages and location pages are the highest priority.

**Page list (27 total — rotate through over ~3 cycles, ~9 pages per cycle):**

Pillar pages (22):
- `/practice-areas/car-accident-lawyers/`
- `/practice-areas/truck-accident-lawyers/`
- `/practice-areas/slip-and-fall-lawyers/`
- `/practice-areas/motorcycle-accident-lawyers/`
- `/practice-areas/medical-malpractice-lawyers/`
- `/practice-areas/wrongful-death-lawyers/`
- `/practice-areas/workers-compensation-lawyers/`
- `/practice-areas/dog-bite-lawyers/`
- `/practice-areas/brain-injury-lawyers/`
- `/practice-areas/spinal-cord-injury-lawyers/`
- `/practice-areas/maritime-injury-lawyers/`
- `/practice-areas/product-liability-lawyers/`
- `/practice-areas/boating-accident-lawyers/`
- `/practice-areas/burn-injury-lawyers/`
- `/practice-areas/construction-accident-lawyers/`
- `/practice-areas/nursing-home-abuse-lawyers/`
- `/practice-areas/premises-liability-lawyers/`
- `/practice-areas/pedestrian-accident-lawyers/`
- `/practice-areas/bicycle-accident-lawyers/`
- `/practice-areas/electric-scooter-accident-lawyers/`
- `/practice-areas/atv-side-by-side-accident-lawyers/`
- `/practice-areas/golf-cart-accident-lawyers/`

Location pages (5):
- `/locations/georgia/savannah/`
- `/locations/georgia/darien/`
- `/locations/south-carolina/charleston/`
- `/locations/south-carolina/columbia/`
- `/locations/south-carolina/myrtle-beach/`

**Actions:**
1. Read rotation state from `technical-seo-log.json` — identify which 9 pages to audit this cycle.
2. For each page, call the PageSpeed Insights API (mobile strategy, field data preferred over lab data when available):
   - LCP: record value in seconds. Threshold: Good < 2.5s, NI 2.5–4.0s, Poor > 4.0s.
   - CLS: record value. Threshold: Good < 0.1, NI 0.1–0.25, Poor > 0.25.
   - INP: record value in ms. Threshold: Good < 200ms, NI 200–500ms, Poor > 500ms.
3. Flag any "Poor" metric as P1. Flag any "Needs Improvement" metric as P2.
4. Record Performance Score (0–100) as a secondary signal.

**Failure actions:**
- Any "Poor" CWV on pillar or location page: **P1** → Paperclip issue with metric value and page URL.
- Any "Needs Improvement" CWV: **P2** → Log.

**Log:** Record page URL, LCP, CLS, INP, Performance Score, pass/NI/fail status for each metric.

---

## Step 7: Sitemap Completeness

**Why:** WordPress generates sitemaps automatically, but custom post types must be included. If any CPT is excluded from the sitemap, those pages are deprioritized for crawling.

**Actions:**
1. Fetch `https://rodenlawdev1.wpenginepowered.com/wp-sitemap.xml` via WebFetch.
2. Verify the sitemap index includes entries for:
   - `wp-sitemap-posts-practice_area-1.xml` (and -2, -3 if paginated)
   - `wp-sitemap-posts-location-1.xml`
   - `wp-sitemap-posts-attorney-1.xml`
   - `wp-sitemap-posts-case_result-1.xml`
   - `wp-sitemap-posts-resource-1.xml`
   - `wp-sitemap-posts-post-1.xml` (blog posts)
   - `wp-sitemap-pages-1.xml`
3. Fetch the `practice_area` sitemap and count URLs. Compare to expected ~177 (18 pillar + 90 intersection + 69 sub-type).
4. Fetch the `location` sitemap and confirm 5 entries.
5. Fetch the `attorney` sitemap and confirm 8+ entries.
6. Flag any missing CPT sitemap as P1. Flag URL count significantly below expected as P2.

**Failure actions:**
- Missing CPT sitemap: **P1** → Paperclip issue.
- Practice area count < 150: **P1** → Paperclip issue.
- Practice area count 150–176: **P2** → Log.

**Log:** Record each sitemap section, URL counts, comparison to expected values.

---

## Step 8: Log Findings

**Actions:**
1. Open `agents/data/technical-seo-log.json`.
2. Append a new cycle entry with the following structure:

```json
{
  "cycle_id": "<ISO timestamp>",
  "cycle_number": <integer>,
  "status": "complete",
  "steps": {
    "robots_txt": {
      "status": "pass|warn|fail",
      "ai_crawlers": {
        "GPTBot": "allowed|blocked",
        "ClaudeBot": "allowed|blocked",
        "PerplexityBot": "allowed|blocked"
      },
      "sitemap_directive": "present|missing",
      "notes": ""
    },
    "gsc_coverage": {
      "indexed_count": null,
      "previous_count": null,
      "delta": null,
      "top_exclusion_reasons": [],
      "status": "pass|warn|fail",
      "notes": ""
    },
    "gsc_crawl_errors": {
      "errors_404": 0,
      "errors_5xx": 0,
      "errors_redirect": 0,
      "top_404_urls": [],
      "status": "pass|warn|fail",
      "notes": ""
    },
    "internal_link_audit": {
      "pages_sampled": [],
      "links_checked": 0,
      "broken_links": [],
      "rotation_set": "A|B|C|D",
      "status": "pass|warn|fail"
    },
    "redirect_chain_audit": {
      "rules_sampled": [],
      "chain_issues": [],
      "destination_404s": [],
      "rotation_offset": 0,
      "status": "pass|warn|fail"
    },
    "core_web_vitals": {
      "pages_audited": [],
      "results": [],
      "rotation_offset": 0,
      "status": "pass|warn|fail"
    },
    "sitemap": {
      "cpts_present": [],
      "cpts_missing": [],
      "practice_area_count": null,
      "location_count": null,
      "attorney_count": null,
      "status": "pass|warn|fail"
    }
  },
  "issues_created": [],
  "rotation_state": {
    "internal_link_set": "A|B|C|D",
    "redirect_rule_offset": 0,
    "cwv_page_offset": 0
  },
  "summary": ""
}
```

3. Update the rotation state fields for the next cycle.
4. Save the file.

---

## Step 9: Create Paperclip Issues

For every P0 and P1 finding identified during this cycle:

1. Create a Paperclip issue with:
   - **Title:** Concise description of the problem (e.g., "P1: Internal link 404 on /attorneys/eric-roden/ → /practice-areas/maritime-lawyers/")
   - **Label:** `technical-seo`
   - **Priority:** `P0` or `P1`
   - **Body:** Include the exact URL(s), measured values, expected values, severity rationale, and recommended fix.
2. Record the issue ID in the cycle log under `issues_created`.

P2 and P3 findings are logged only — no Paperclip issue required.

---

## Step 10: Report to SEO Strategist

Compose a structured report and deliver it to the SEO Strategist agent.

**Report format:**

```
TECHNICAL SEO MONITOR — CYCLE REPORT
Cycle: [cycle_number] | Timestamp: [ISO timestamp]
Site: rodenlawdev1.wpenginepowered.com

SUMMARY: [1–2 sentence overall health assessment]

FINDINGS BY STEP:
1. robots.txt: [PASS / WARN / FAIL] — [1 sentence]
2. GSC Coverage: [PASS / WARN / FAIL] — [indexed count, delta, key exclusions]
3. GSC Crawl Errors: [PASS / WARN / FAIL] — [error counts, notable URLs]
4. Internal Link Audit: [PASS / WARN / FAIL] — [pages sampled, broken links found]
5. Redirect Chain Audit: [PASS / WARN / FAIL] — [rules sampled, issues found]
6. Core Web Vitals: [PASS / WARN / FAIL] — [pages audited, metric summary]
7. Sitemap: [PASS / WARN / FAIL] — [CPT presence, URL counts]

ISSUES CREATED THIS CYCLE:
[List Paperclip issue IDs and one-line summaries, or "None"]

OPEN ISSUES FROM PREVIOUS CYCLES:
[List any P0/P1 issues still unresolved, or "None"]

RECOMMENDED ACTIONS FOR SEO STRATEGIST:
[Prioritized action list for any issues requiring strategy decisions]
```

---

## Step 11: Fact Extraction and Exit

Before closing the session, extract any new facts discovered this cycle that should persist to memory. Examples:

- "New robots.txt rule detected: [rule content]"
- "practice_area sitemap now contains [X] URLs (was [Y])"
- "Average LCP across pillar pages this cycle: [X]s"
- "Redirect rule at inc/legacy-redirects.php line [N] confirmed as 2-hop chain"

Write these facts to the appropriate memory file if they represent durable knowledge.

Then: close the session. No lingering. No speculative follow-up tasks. The cycle is complete.
