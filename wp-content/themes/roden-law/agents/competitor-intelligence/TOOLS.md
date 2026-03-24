# Tools: Competitor Intelligence Agent

## Available Tools

### WebSearch

Use for live SERP queries and discovery.

**Common patterns:**
```
WebSearch("personal injury lawyer Savannah GA")
WebSearch("car accident attorney Charleston SC site:avvo.com")
WebSearch("truck accident lawyer Columbia SC")
WebSearch('"Roden Law" avvo')
WebSearch('site:morganandmorgan.com savannah')
```

**Best practices:**
- Use quotes for exact-match competitor names
- Use `site:` operator to check competitor directory presence
- Use location-qualified queries for local pack and organic results
- Vary query phrasing to surface both local pack and organic top 10

---

### WebFetch

Use to inspect competitor pages, competitor sitemaps, and Roden Law pages for comparison.

**Common patterns:**
```
WebFetch("https://[competitor].com/sitemap.xml")
WebFetch("https://[competitor].com/practice-areas/")
WebFetch("https://rodenlawdev1.wpenginepowered.com/practice-areas/car-accident-lawyers/")
WebFetch("https://[competitor].com/car-accident-lawyer-savannah/")
```

**What to look for when fetching competitor pages:**
- Approximate word count (scroll to bottom, estimate)
- FAQ section presence and depth (number of questions)
- Schema markup signals (check page source for `application/ld+json`)
- Internal linking patterns
- Heading structure (H1, H2, H3 hierarchy)
- Breadcrumb navigation
- Attorney attribution / E-E-A-T signals

**Note:** Do NOT fetch the live production site to verify Roden Law changes. Use the dev site URL or read local files directly.

---

### Paperclip API

Use to create issues for all actionable findings.

**Issue labels used by this agent:**
- `quick-win` — keyword optimization to improve existing ranking
- `content` — new page to build or existing page to expand
- `local-seo` — directory listing, citation, or backlink opportunity

**Issue creation template:**
```
Title: [Label Type] Action description — specific keyword or page
Body:
- Current state: [Roden Law position / missing page / missing listing]
- Competitor example: [URL of competitor doing this well]
- Gap: [specific what is missing or weaker]
- Recommended action: [specific implementation step]
- Estimated value: [high / medium / low based on keyword volume and competition]
Assign to: [Founding Engineer for implementation | SEO Strategist for strategy decisions]
Labels: [quick-win | content | local-seo]
```

---

### Semrush API (when available)

If Semrush API credentials are configured, use for:

- **Keyword position tracking:** `domain_ranks` endpoint for specific keyword positions
- **Competitor keyword gap:** `phrase_related` to find keywords competitors rank for but Roden Law doesn't
- **Backlink comparison:** `backlinks_overview` for competitor vs. Roden Law backlink counts

**API reference:**
- Base URL: `https://api.semrush.com/`
- Key endpoints: `domain_ranks`, `phrase_organic`, `phrase_related`, `backlinks_overview`
- Authentication: API key via header or query param (check environment config)

**Fallback:** If Semrush API is not available, use WebSearch to approximate SERP positions manually.

---

### Ahrefs API (when available)

If Ahrefs API credentials are configured, use for:

- **Keyword rankings:** Site Explorer → Organic keywords
- **Content gap:** Content Gap tool (domain vs. domain)
- **Backlink gap:** Link Intersect tool

**API reference:**
- Base URL: `https://api.ahrefs.com/v3/`
- Key endpoints: `/site-explorer/organic-keywords`, `/site-explorer/backlinks`, `/content-gap`
- Authentication: Bearer token

**Fallback:** If Ahrefs API is not available, combine WebSearch + WebFetch for manual approximation.

---

### Read (File System)

Use to read local theme files for context.

**Key files:**
- `/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/inc/firm-data.php` — canonical office data, practice area list
- `/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/CLAUDE.md` — full architecture context
- `/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/agents/data/competitive-rankings.json` — persistent data store

---

## Data Store: competitive-rankings.json

**Location:** `agents/data/competitive-rankings.json`

This is the persistent memory of the Competitor Intelligence Agent. It must be read at the start of every session and written before exit.

**Full schema:**

```json
{
  "last_run": "ISO 8601 timestamp",
  "session_log": [
    {
      "date": "ISO 8601 timestamp",
      "markets_checked": ["savannah", "charleston"],
      "keywords_tracked": 12,
      "issues_created": 4,
      "notes": "free text"
    }
  ],
  "competitors": {
    "savannah": [
      {
        "name": "Firm Name",
        "url": "https://example.com",
        "markets": ["savannah"],
        "last_verified": "ISO 8601 date",
        "notes": "strongest for car accident queries"
      }
    ],
    "darien": [],
    "charleston": [],
    "columbia": [],
    "myrtle-beach": []
  },
  "keyword_positions": [
    {
      "keyword": "car accident lawyer Savannah",
      "market": "savannah",
      "roden_position": 4,
      "roden_url": "https://...",
      "top_competitor_url": "https://...",
      "top_competitor_position": 1,
      "checked_date": "ISO 8601 date",
      "week_group": "A"
    }
  ],
  "quick_wins": [
    {
      "keyword": "slip and fall lawyer Savannah",
      "roden_position": 6,
      "roden_url": "https://...",
      "gap": "Competitor has 8 FAQs, Roden has 3. Competitor word count ~2800, Roden ~1100.",
      "paperclip_issue_id": "123",
      "status": "open"
    }
  ],
  "content_gaps": [
    {
      "topic": "Rideshare accident lawyer Savannah",
      "competitor_example": "https://...",
      "recommended_url": "/rideshare-accident-lawyers/savannah-ga/",
      "tier": "intersection",
      "paperclip_issue_id": "124",
      "status": "open"
    }
  ],
  "backlink_gaps": [
    {
      "directory": "Super Lawyers",
      "directory_url": "https://www.superlawyers.com/",
      "competitor_listing": "https://...",
      "roden_listed": false,
      "office": "savannah",
      "paperclip_issue_id": "125",
      "status": "open"
    }
  ],
  "ai_overview_status": [
    {
      "query": "what to do after a car accident in Georgia",
      "checked_date": "ISO 8601 date",
      "ai_overview_present": true,
      "roden_cited": false,
      "cited_domains": ["nolo.com", "avvo.com"],
      "content_type_cited": "guide",
      "paperclip_issue_id": "126"
    }
  ]
}
```

**Rules:**
- Never delete prior session data — append to `session_log` and `keyword_positions` arrays
- Update `last_run` on every session
- Mark resolved issues by updating `status` from `open` to `resolved`
- Keep the file valid JSON at all times
