# Tools: Citation & GBP Monitor Agent

## Available Tools

### WebSearch

Use to locate directory listings and confirm whether Roden Law is listed on a given platform.

**Common patterns:**
```
WebSearch('"Roden Law" avvo savannah')
WebSearch('"Roden Law" martindale charleston SC')
WebSearch('"Roden Law" site:yelp.com')
WebSearch('"Roden Law" site:bbb.org')
WebSearch('"Roden Law" justia columbia SC')
WebSearch('personal injury lawyer Savannah GA')
WebSearch('car accident attorney Charleston SC')
```

**Best practices:**
- Use quotes around "Roden Law" for exact-match searches
- Use `site:` operator to check specific directories
- Combine firm name + city + state for precise location matching
- If a search returns no results, that likely means the listing is missing — but always attempt a WebFetch to confirm

---

### WebFetch

Use to retrieve the actual content of a directory listing page for NAP verification.

**Common patterns:**
```
WebFetch("https://www.avvo.com/law_firm/...")
WebFetch("https://www.martindale.com/organization/...")
WebFetch("https://lawyers.findlaw.com/...")
WebFetch("https://justia.com/lawyers/firm/...")
WebFetch("https://www.superlawyers.com/organization/...")
WebFetch("https://www.yelp.com/biz/...")
WebFetch("https://www.bbb.org/us/...")
```

**What to look for when fetching a directory listing:**
- Firm name — exact text as displayed
- Street address — full address including suite/unit number
- City, State, ZIP — each field separately
- Phone number — exact format
- Website URL — does it point to rodenlaw.com?
- Practice areas listed — are they accurate?

**Note:** Some directories may block automated fetching. If a fetch fails or returns minimal content, log the failure in `citation-inventory.json` → `session_log` and move on.

---

### Read (File System)

Use to read local theme files for canonical NAP data and persistent state.

**Key files:**

`/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/inc/firm-data.php`
- **This is the single source of truth for all NAP data**
- Read this file at the start of every session before checking any directory
- The `roden_firm_data()` function returns the canonical data for all 5 offices
- If a directory conflicts with this file, the directory is wrong — not the PHP file

`/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/agents/data/citation-inventory.json`
- Persistent audit state: last audited office, prior week results, review counts, local pack positions
- Read at session start; write updated data before exit

`/Users/brianhaas/Projects/rodenlaw_site/wp-content/themes/roden-law/CLAUDE.md`
- Architecture context, full office data, firm stats

---

### Paperclip API

Use to create issues for every discrepancy, missing listing, and local pack change.

**Issue severity and labels used by this agent:**

| Severity | When to Use | Label |
|----------|-------------|-------|
| P0 | Wrong address, wrong phone, wrong city/state/zip | `local-seo` |
| P1 | Missing suite/unit, name variant, local pack drop | `local-seo` |
| P2 | Missing listing entirely, incomplete profile, stalled reviews | `local-seo` |
| P3 | Minor formatting variant ("St." vs "Street") | `local-seo` |

**Issue creation template:**

```
Title: [NAP Fix P0] Correct [field] on [directory] for [office city]
Body:
- Directory: [name + URL of the listing]
- Canonical value: [exact value from inc/firm-data.php]
- Current incorrect value: [exactly what the directory shows]
- Severity: P0 / P1 / P2 / P3
- Correction steps: [self-service URL | requires owner verification | contact directory support]
- Impact: [why this matters for local pack rankings]
Assign to: SEO Strategist (for directory corrections) | Founding Engineer (if firm-data.php needs updating)
Labels: local-seo
```

**Assign to Founding Engineer when:**
- `inc/firm-data.php` may itself contain outdated data (rare — always flag explicitly)
- The fix requires a code change or theme update

**Assign to SEO Strategist when:**
- The fix is a directory correction (self-service or support ticket)
- A new directory listing needs to be created

---

## Data Store: citation-inventory.json

**Location:** `agents/data/citation-inventory.json`

This is the persistent memory of the Citation & GBP Monitor Agent. It must be read at the start of every session and written before exit. It is the source for rotation tracking — without it, the agent cannot determine which office to audit next.

**Full schema:**

```json
{
  "last_run": "ISO 8601 timestamp",
  "last_audited_office": "savannah",
  "rotation_order": ["savannah", "darien", "charleston", "columbia", "myrtle-beach"],
  "session_log": [
    {
      "date": "ISO 8601 timestamp",
      "office_audited": "savannah",
      "directories_checked": 8,
      "discrepancies_found": 2,
      "issues_created": 3,
      "notes": "Avvo missing suite number. Google Maps phone matches."
    }
  ],
  "citation_audits": {
    "savannah": {
      "last_audited": "ISO 8601 date",
      "overall_health": "good | at-risk | critical",
      "directories": [
        {
          "name": "Avvo",
          "url": "https://...",
          "status": "MATCH | DISCREPANCY | MISSING | ERROR",
          "last_checked": "ISO 8601 date",
          "discrepancies": [
            {
              "field": "address",
              "canonical": "333 Commercial Dr., Savannah, GA 31406",
              "found": "333 Commercial Drive, Savannah, GA 31406",
              "severity": "P3",
              "paperclip_issue_id": "201",
              "status": "open | resolved"
            }
          ]
        }
      ]
    },
    "darien": {
      "last_audited": null,
      "directories": []
    },
    "charleston": {
      "last_audited": null,
      "directories": []
    },
    "columbia": {
      "last_audited": null,
      "directories": []
    },
    "myrtle-beach": {
      "last_audited": null,
      "directories": []
    }
  },
  "local_pack_positions": {
    "savannah": [],
    "darien": [],
    "charleston": [],
    "columbia": [],
    "myrtle-beach": []
  },
  "review_data": {
    "savannah": {
      "google": {
        "count": null,
        "rating": null,
        "last_review_date": null,
        "last_checked": null
      },
      "avvo": {
        "count": null,
        "rating": null,
        "last_checked": null
      }
    },
    "darien": {},
    "charleston": {},
    "columbia": {},
    "myrtle-beach": {}
  }
}
```

**Rules:**
- `last_audited_office` MUST be updated every session — this drives the rotation
- Never delete prior audit results — append new results alongside historical data with `last_checked` timestamps
- Mark resolved discrepancies by updating `status` from `open` to `resolved`
- Log every session in `session_log` even if no discrepancies are found
- Keep the file valid JSON at all times — invalid JSON will break next session's rotation tracking

## Canonical NAP Reference (from inc/firm-data.php)

Always verify against the file directly, but quick reference:

| Office Key | Address | City | State | ZIP | Phone |
|------------|---------|------|-------|-----|-------|
| savannah | 333 Commercial Dr. | Savannah | GA | 31406 | (912) 303-5850 |
| darien | 1108 North Way | Darien | GA | 31305 | (912) 303-5850 |
| charleston | 127 King Street, Suite 200 | Charleston | SC | 29401 | (843) 790-8999 |
| columbia | 1545 Sumter St., Suite B | Columbia | SC | 29201 | (803) 219-2816 |
| myrtle-beach | 631 Bellamy Ave., Suite C-B | Murrells Inlet | SC | 29576 | (843) 612-1980 |

**Firm name canonical form:** `Roden Law`
