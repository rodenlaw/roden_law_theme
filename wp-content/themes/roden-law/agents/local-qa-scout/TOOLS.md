# Local Q&A Scout — Tool Inventory

This document lists every tool this agent is authorized to use, how to use it, and any constraints or rate-limit considerations.

---

## WebSearch

**Purpose:** Execute Google searches to find PAA boxes, autocomplete suggestions, featured snippets, and AI overviews for practice area × city query combinations.

**Usage pattern:**
```
Query: "car accident lawyer Savannah Georgia"
→ Capture: PAA questions, featured snippet text, AI overview presence, related searches
```

**Constraints:**
- Do not execute more than 15 searches per cycle (5 queries × 3 combos).
- If a query returns no results or an error, log it as `search_unavailable` in the discovery record.
- Do not fabricate search results. If PAA is not present, record that honestly.

**Key query templates:**
- `[practice area] lawyer [city]`
- `[practice area] [city] [state full name]`
- `[practice area] attorney [city] [state abbreviation]`
- `how much does a [practice area] lawyer cost in [city]`
- `do I need a lawyer for [injury type] [city]`

---

## WebFetch

**Purpose:** Retrieve content from specific URLs, including Reddit threads, legal Q&A sites, and competitor pages surfaced in search results.

**Usage pattern:**
```
URL: https://www.reddit.com/r/legaladvice/search/?q=car+accident+savannah&restrict_sr=1
→ Extract: question text, upvotes, top answer summary, thread date
```

**Authorized sources:**
- Reddit subreddits: r/legaladvice, r/savannah, r/charleston, r/columbia_sc, r/MyrtleBeach, r/Georgia, r/southcarolina
- Legal Q&A sites: Avvo community Q&A, Justia Ask a Lawyer (read only, no posting)
- Google autocomplete JSON endpoint (if accessible)

**Constraints:**
- Do not fetch competitor law firm pages to extract their FAQ content. Observing SERP presence is fine; scraping their content is not.
- Maximum 10 WebFetch calls per cycle.
- If a Reddit thread is older than 12 months, note the age in the discovery record.

---

## Read

**Purpose:** Read local theme files to understand existing FAQ coverage, seeder data, and firm configuration.

**Key files to read:**

| File | Purpose |
|------|---------|
| `agents/data/qa-discoveries.json` | Current Q&A discovery data store |
| `memory/rotation-state.json` | Tracks which PA × city combos have been covered |
| `memory/cycle-log.json` | Historical cycle records |
| `inc/firm-data.php` | Canonical office data, city slugs, phone numbers |
| `CLAUDE.md` | Practice area slugs, jurisdiction law data, firm stats |
| `agents/content-director/memory/inbox.md` | Content Director's inbox (append-only) |

---

## Grep

**Purpose:** Search existing theme files for FAQ content to determine coverage status before flagging a question as a gap.

**Usage pattern:**
```
Pattern: "statute of limitations"
Path: inc/
→ Find all files where SOL is mentioned to check for existing answers
```

**Key search patterns:**

| Pattern | Purpose |
|---------|---------|
| `_roden_faqs` | Find all FAQ meta field usage in seeder scripts |
| `O.C.G.A.` | Find all Georgia statute citations |
| `S.C. Code` | Find all South Carolina statute citations |
| `[practice area slug]` | Find all content related to a specific practice area |
| `how long` | Find existing deadline/SOL-related FAQ entries |
| `statute of limitations` | Find existing SOL coverage |
| `comparative fault` | Find existing fault rule coverage |

**Constraints:**
- Search `inc/`, `templates/`, and the root PHP files.
- Do not search `node_modules`, `assets/`, or binary files.

---

## Paperclip API

**Purpose:** Create issues for high-value Q&A gaps (score 6+) so the Content Director and content writers can act on them.

**Issue creation:**
```
POST /issues
{
  "title": "[Q&A Gap] Car Accident × Savannah: 'How long after accident can I sue in GA?'",
  "labels": ["qa-discovery", "car-accident-lawyers", "savannah-ga", "georgia"],
  "body": "[Full issue body per HEARTBEAT.md Step 8 template]"
}
```

**Labels to apply:**

| Label | When to apply |
|-------|--------------|
| `qa-discovery` | Always, on every issue created by this agent |
| `[pa-slug]` | The practice area slug (e.g., `car-accident-lawyers`) |
| `[city-slug]` | The city slug (e.g., `savannah-ga`) |
| `georgia` or `south-carolina` | State jurisdiction |
| `high-priority` | Score 8–10 |
| `ai-citation-potential` | AI overview or featured snippet present |

**Constraints:**
- Do not create duplicate issues. Before creating an issue, search existing issues for the question text.
- Maximum 10 issues per cycle. If more than 10 qualify, create the 10 highest-scoring and note the rest in the Content Director report.

---

## Semrush / Ahrefs API (Reference)

**Purpose:** Validate search volume estimates and keyword difficulty for discovered questions. Used to refine scoring when API access is available.

**Note:** These are reference integrations. If API credentials are not available in the environment, skip this step and rely on PAA presence as the volume proxy.

**Semrush endpoint (if available):**
```
GET https://api.semrush.com/
?type=phrase_this
&key=[API_KEY]
&phrase=[encoded question]
&database=us
```

**Ahrefs endpoint (if available):**
```
GET https://apiv2.ahrefs.com/
?from=keywords_explorer
&target=[encoded question]
&mode=exact
&token=[API_TOKEN]
```

**How to use in scoring:**
- Monthly search volume 1,000+: add 1 bonus point to score
- Monthly search volume 100–999: no adjustment
- Monthly search volume < 100: subtract 1 point from score (unless AI-citation potential is high)

---

## Data Store: qa-discoveries.json

**Location:** `agents/data/qa-discoveries.json`

**Purpose:** Persistent record of all discovered questions across all cycles. This is the single source of truth for Q&A gap tracking.

**File structure:**
```json
{
  "last_updated": "2026-03-20T09:00:00Z",
  "total_records": 0,
  "records": []
}
```

**Record schema:**
```json
{
  "id": "qa-[timestamp]-[sequence]",
  "question": "string — verbatim or lightly cleaned question text",
  "pa_slug": "string — practice area slug",
  "city_slug": "string — city slug (savannah-ga, etc.) or 'all' for statewide",
  "state": "GA | SC | both",
  "jurisdiction": "georgia | south-carolina | both",
  "intent": "informational | investigational | transactional",
  "source": "PAA | Reddit | Autocomplete | RelatedSearch | Manual",
  "source_url": "string — URL of the SERP or thread",
  "coverage_status": "new_gap | partial | covered",
  "score": "number 1–10",
  "issue_id": "string — Paperclip issue ID if created, else null",
  "cycle": "number — cycle number when discovered",
  "discovered_date": "YYYY-MM-DD",
  "notes": "string — jurisdiction notes, recommended action, context"
}
```

**Write rules:**
- Always read the current file before writing to preserve existing records.
- Append new records to the `records` array. Never delete or overwrite existing records.
- Update `last_updated` and `total_records` on every write.
- If the file does not exist, initialize it with the structure above and an empty records array.
