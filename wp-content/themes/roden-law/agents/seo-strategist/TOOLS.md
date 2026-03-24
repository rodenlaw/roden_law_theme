# TOOLS.md -- SEO Strategist Tools

Tools available for SEO analysis, issue triage, monitor coordination, and reporting.

---

## Paperclip API

Primary coordination tool. Use for all task management, issue triage, and agent communication.

**Key endpoints:**
- `GET /api/agents/me` — identity and context check on every heartbeat
- `GET /api/companies/{companyId}/issues` — pull issues by assignee, status, or parent
- `POST /api/companies/{companyId}/issues` — create implementation tasks for Founding Engineer or directives for monitors
- `POST /api/issues/{id}/checkout` — lock an issue before working on it
- `PATCH /api/issues/{id}` — update status, priority, or assignee
- `POST /api/issues/{id}/comments` — post triage decisions, findings, or handoffs
- `GET /api/issues/{id}` — read a specific issue with full context

**Usage rules:**
- Always checkout before working (`POST /api/issues/{id}/checkout`). Never retry a 409.
- Always include `X-Paperclip-Run-Id` on mutating calls.
- Comment triage decisions in markdown: `**P1 — High Revenue Impact**` + bullets + links.
- When creating tasks for Founding Engineer, always set `parentId` and `goalId`.

---

## WebSearch

Use for SERP analysis, competitive monitoring, and local search landscape research.

**Primary use cases:**
- Check current SERP features for target keywords (AI Overviews, map pack, featured snippets, PAA boxes)
- Identify which competitors are ranking for priority PI keywords in GA and SC markets
- Monitor for new competitor content or site changes that affect the competitive landscape
- Research jurisdiction-specific search intent differences (e.g., "car accident lawyer Savannah" vs. "Charleston car accident attorney")
- Find authoritative sources for statute citations, court information, and local legal news

**Query patterns:**
- `"[practice area] lawyer [city] [state]"` — baseline competitive SERP check
- `site:[competitor-domain]` — assess competitor content volume and structure
- `"O.C.G.A. § [section]"` / `"S.C. Code § [section]"` — statute verification
- `"[city] personal injury" intitle:lawyer` — local competitor discovery

**Notes:**
- Always include state abbreviation (GA/SC) in geo-targeted queries to control for jurisdiction.
- For AI Overview research, note whether the query triggers an Overview and what sources are cited.
- Do not use WebSearch to verify live site behavior — analyze locally via Read/Grep.

---

## WebFetch

Use for page-level analysis, schema extraction, and competitor page inspection.

**Primary use cases:**
- Fetch competitor practice area pages to analyze content structure, word count, schema usage, and internal linking
- Extract and inspect JSON-LD from any live URL to compare against our expected schema output
- Analyze SERP feature source pages to understand what content signals are triggering AI Overviews or featured snippets
- Pull Google Search Console performance data endpoints if GSC API access is configured
- Check Google's Rich Results Test URL for a specific page (fetch the result page, not the live site)

**Usage rules:**
- Never fetch the Roden Law live or dev site to verify code changes. Use Read/Grep to analyze locally.
- Use WebFetch for external URLs only — competitor pages, schema validators, SERP analysis tools.
- When extracting schema from a competitor page, copy the JSON-LD block and compare schema type coverage against `inc/schema-helpers.php`.

---

## Read

Use for local codebase analysis, schema output review, and template inspection.

**Primary use cases:**
- Read `inc/schema-helpers.php` to verify schema types, output conditions, and coverage gaps
- Read `templates/template-practice-area.php`, `template-intersection.php`, `template-subtype.php` to understand page structure
- Read `inc/firm-data.php` for office data, jurisdiction settings, and helper functions
- Read `inc/meta-boxes.php` to understand what custom fields are available per post type
- Read `single-practice_area.php` to understand the pillar/intersection/sub-type routing logic

**Key files to know:**
- `/inc/schema-helpers.php` — all 12 JSON-LD schema output functions
- `/inc/firm-data.php` — office data, statute of limitations, comparative fault rules
- `/templates/template-practice-area.php` — pillar page template
- `/templates/template-intersection.php` — intersection (PA × city) template
- `/templates/template-subtype.php` — sub-type specialization template
- `/agents/data/schema-coverage.json` — Schema Auditor's running coverage data
- `/agents/data/technical-seo-log.json` — Technical SEO Monitor's crawl health log
- `/agents/data/competitive-rankings.json` — rank tracking data for priority keywords

---

## Grep

Use for pattern-based codebase searches — faster than reading individual files when you need to find where something is implemented or missing.

**Primary use cases:**
- Find all locations where a specific schema type is output: `grep -r "FAQPage" inc/`
- Find all practice area templates that do or do not include attorney attribution
- Search for jurisdiction-specific content (O.C.G.A. references, S.C. Code references) across templates
- Find all `_roden_` meta field references to understand what data is captured per post type
- Identify which templates call specific template parts (e.g., `faq-accordion.php`)

**Useful patterns:**
- `roden_output_.*schema` — find all schema output function calls
- `_roden_office_key` — find all places office key is used for jurisdiction detection
- `O\.C\.G\.A\.|S\.C\. Code` — find statute citations in templates
- `get_template_part.*faq` — find all FAQ accordion inclusions

---

## Data Store Access

Read-only access to shared JSON data files maintained by the monitor agents. These are the primary inputs for weekly synthesis and triage decisions.

**Files:**

| File | Owner | Contents |
|------|-------|---------|
| `agents/data/schema-coverage.json` | Schema Auditor | Schema type coverage rate per page type, missing schema flags, last audit timestamp |
| `agents/data/technical-seo-log.json` | Technical SEO Monitor | Crawl errors, 404s, redirect chains, indexation status, Core Web Vitals flags |
| `agents/data/competitive-rankings.json` | Competitor Intelligence | Rank positions for priority keywords across GA and SC markets, SERP feature presence |
| `agents/data/content-health.json` | Content Director | Word count, internal link count, E-E-A-T compliance flags, thin content warnings |
| `agents/data/citation-inventory.json` | Citation/GBP Monitor | NAP consistency across directories, GBP status per office, citation gap flags |
| `agents/data/qa-discoveries.json` | Local QA Scout | Local Q&A signals, GBP Q&A coverage, neighborhood-level content gaps |

**Usage rules:**
- Read these files during every heartbeat triage cycle — they are the primary data inputs.
- Do not write to these files directly — they are owned by their respective monitor agents.
- When a data file has not been updated in more than 48 hours, flag it as a blocker for the responsible monitor.

---

## GSC API Reference

The SEO Strategist does not directly access Google Search Console — that is routed through the Technical SEO Monitor. However, you should be aware of what data the monitor can pull and how to direct it.

**Direct the Technical SEO Monitor to pull:**
- Performance data: impressions, clicks, CTR, average position by URL and query
- Coverage report: indexed vs. excluded pages, crawl errors by type
- Core Web Vitals: CWV status by URL group
- Rich results: schema validation status for structured data types

**When requesting GSC data:**
- Specify the date range (e.g., "last 28 days vs. prior 28 days")
- Specify the dimension (page, query, country, device)
- Specify the filter (e.g., URLs matching `/practice-areas/` or queries containing "personal injury lawyer")
- Specify the metric threshold (e.g., "pages with impressions > 100 and CTR < 2%")

**Prioritize GSC requests by:**
1. Revenue-critical pages first: pillar pages, intersection pages for top 5 markets
2. Pages with recent code changes (schema updates, template modifications)
3. New pages published in the last 30 days (indexation confirmation)
