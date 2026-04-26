# TOOLS.md -- Content Director

---

## Paperclip API

Your primary coordination tool. Use it for all task creation, checkout, status updates, and cross-agent communication.

**Common endpoints:**

```
GET  /api/agents/me                                         -- confirm identity and budget
GET  /api/companies/{companyId}/issues?assigneeAgentId=...  -- get your assignments
POST /api/companies/{companyId}/issues                      -- create new task or subtask
POST /api/issues/{id}/checkout                              -- claim a task before working (never retry 409)
PUT  /api/issues/{id}                                       -- update status or fields
POST /api/issues/{id}/comments                              -- comment with progress or completion notes
```

**Rules:**
- Always checkout before working. Never retry a 409 — that task belongs to someone else.
- Always include `X-Paperclip-Run-Id` header on mutating calls.
- Comment in concise markdown: status line + bullets + links.
- When creating tasks for the Founding Engineer, always set `parentId` and `goalId`.
- Self-assign via checkout only when explicitly @-mentioned.

---

## WebSearch

Use for keyword research, competitor content analysis, and verifying real user search intent.

**Primary uses:**
- Research keyword volume and search intent for content brief targets
- Analyze competitor pages ranking for target keywords (what do they cover that we must match or exceed?)
- Find People Also Ask (PAA) questions for specific practice area + location combinations
- Verify current statute law (cross-reference GA and SC legal codes)
- Check legal news and case law updates that might require content refreshes

**Search patterns:**
- `"car accident lawyer Savannah GA" site:competitordomain.com` -- competitor content analysis
- `"O.C.G.A. § 9-3-33" statute of limitations personal injury` -- statute verification
- `"drunk driving accident attorney South Carolina" PAA questions` -- question mining

---

## Read / Grep

Use for analyzing existing site content, checking FAQ coverage, and auditing internal linking.

**Read:** Access any file by absolute path. Use to read content briefs, editorial calendar, memory files, and theme template files.

**Grep:** Search file contents with regex. Use to:
- Check if a specific question is already answered anywhere in the theme or content files
- Find all pages referencing a specific statute (e.g., `grep "9-3-33"` across templates)
- Audit internal link targets (find all pages linking to a specific URL)
- Check which practice area pages have `_roden_faqs` populated vs. empty

**Example patterns:**
```
# Check if "drunk driver accident" has FAQ coverage on any practice area page
grep -r "drunk driver" /path/to/theme/templates/

# Find all pages with SC statute citation
grep -r "15-3-530" /path/to/theme/

# Check which pillar templates are missing attorney attribution
grep -rL "_roden_author_attorney" /path/to/theme/templates/template-practice-area.php
```

---

## Data Stores (Read Access)

These JSON files are maintained by your direct reports. Read them on every heartbeat.

### `agents/data/qa-discoveries.json`

Written by the **Local Q&A Scout**. Contains new user questions discovered from Google PAA, Reddit, legal forums, and search intent analysis.

**Expected shape:**
```json
[
  {
    "id": "uuid",
    "discovered_at": "ISO-8601",
    "question": "How long do I have to file a car accident claim in Georgia?",
    "source": "google-paa | reddit | forum | serp-intent",
    "related_practice_area": "car-accident-lawyers",
    "related_location": "savannah-ga | null",
    "jurisdiction": "georgia | south-carolina | both",
    "status": "new | triaged | actioned | duplicate",
    "action_taken": "faq-addition | content-gap | blog-topic | null"
  }
]
```

### `agents/data/content-health.json`

Written by the **Content Refresher**. Contains pages flagged for staleness, outdated statutes, thin content, broken links, or missing E-E-A-T attribution.

**Expected shape:**
```json
[
  {
    "id": "uuid",
    "flagged_at": "ISO-8601",
    "page_url": "/practice-areas/car-accident-lawyers/",
    "post_id": 3604,
    "page_type": "pillar | intersection | subtype | blog | location",
    "flags": ["outdated-statute", "thin-content", "missing-attribution", "broken-internal-link"],
    "severity": "urgent | standard | monitor",
    "notes": "Statute citation uses old 2020 code reference",
    "status": "new | triaged | actioned | resolved"
  }
]
```

### `agents/data/competitive-rankings.json`

Maintained by the SEO Strategist and Competitor Intelligence agents. Contains keyword rank snapshots and competitor SERP data.

**Use for:** Identifying which target keywords are underperforming so you can prioritize content briefs accordingly. Cross-reference with your Q&A triage to find gaps with actual search volume.

---

## Semrush / Ahrefs API (Reference)

If API credentials are available in environment variables (`SEMRUSH_API_KEY`, `AHREFS_API_KEY`), these can supplement WebSearch for keyword volume and difficulty data.

**Semrush keyword overview endpoint:**
```
GET https://api.semrush.com/?type=phrase_this&key={key}&phrase={keyword}&database=us&export_columns=Ph,Nq,Cp,Co
```

**Ahrefs keyword difficulty:**
```
GET https://apiv2.ahrefs.com/?from=keywords_info&target={keyword}&country=us&output=json&token={token}
```

Use these to validate keyword volume estimates in content briefs before handing off to implementation. Do not create briefs for keywords with zero search volume unless they serve a clear topical authority or internal linking purpose.

---

## para-memory-files Skill

Use for all memory operations: storing facts, writing daily notes, creating entities, running synthesis, and managing plans. Invoke it whenever you need to remember, retrieve, or organize anything across heartbeats.

---
