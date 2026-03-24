# Heartbeat: Citation & GBP Monitor Agent

**Schedule:** Every Saturday at 7:00 AM (`cron: 0 7 * * 6`)

---

## Pre-Flight: Identity and Context Check

Before doing any work, confirm your operating context:

- [ ] Read `AGENTS.md` — confirm role, reporting structure, working rules, office rotation
- [ ] Read `SOUL.md` — re-anchor NAP consistency and local SEO mindset
- [ ] Read `agents/data/citation-inventory.json` — load prior state; determine which office to deep-audit this week
- [ ] Read `inc/firm-data.php` — load canonical NAP for ALL 5 offices (this is the source of truth)
- [ ] Note today's date and confirm the rotation office

---

## Step 1: Determine This Week's Deep-Audit Office

From `citation-inventory.json` → `last_audited_office`, determine which office is next in rotation:

**Rotation order:** Savannah → Darien → Charleston → Columbia → Myrtle Beach → (repeat)

- [ ] Set `this_week_office` = next office in rotation
- [ ] Load canonical NAP for `this_week_office` from `inc/firm-data.php`
- [ ] Record the canonical values you will compare against:
  - Street address (including suite/unit)
  - City, State, ZIP
  - Phone number
  - Firm name (exact: "Roden Law")

---

## Step 2: Directory NAP Audit for Selected Office

Check each of the following directories for the selected office. For each, fetch the listing page and compare every NAP field against the canonical data from `inc/firm-data.php`.

**Directories to check:**

| Directory | Search Method |
|-----------|---------------|
| Avvo | WebSearch `"Roden Law" avvo [city]` |
| Martindale-Hubbell | WebSearch `"Roden Law" martindale [city]` |
| FindLaw | WebSearch `"Roden Law" findlaw [city]` |
| Justia | WebSearch `"Roden Law" justia [city]` |
| Super Lawyers | WebSearch `"Roden Law" superlawyers [city]` |
| Yelp | WebSearch `"Roden Law" yelp [city]` |
| BBB | WebSearch `"Roden Law" bbb.org [city]` |
| Google Maps | WebSearch `"Roden Law" [city] [state] google maps` |

**For each directory:**
- [ ] WebSearch to find the listing URL
- [ ] WebFetch the listing page
- [ ] Compare each NAP field:
  - Firm name — exact match?
  - Street address — exact match including suite/unit?
  - City — correct?
  - State — correct?
  - ZIP — correct?
  - Phone — exact match?
- [ ] Record result: MATCH, DISCREPANCY, or MISSING
- [ ] If DISCREPANCY: document exactly what is listed vs. what canonical NAP shows
- [ ] If MISSING: confirm Roden Law has no listing (not just unfindable via search)

**Discrepancy severity:**
- **P0** — Wrong phone number, wrong street address, wrong city/state/zip
- **P1** — Missing suite or unit number, name variant ("Roden Love LLC" vs "Roden Law")
- **P2** — Missing listing entirely, incomplete profile (no phone, no hours)
- **P3** — Minor formatting difference ("St." vs "Street", "Suite" vs "Ste")

---

## Step 3: Google Local Pack Monitoring

For the selected office's city, check Roden Law's position in the local pack for 3 high-value queries.

**Query selection — use city and state from the audited office:**
1. `personal injury lawyer [city] [state]`
2. `car accident attorney [city] [state]`
3. `[city] [state] injury lawyer`

**For each query:**
- [ ] WebSearch the query
- [ ] Note: Is Roden Law in the local pack (top 3 map results)?
- [ ] If yes: record position (1, 2, or 3)
- [ ] If no: who occupies the top 3 positions? Record firm names
- [ ] Note any changes from prior week (compare to `citation-inventory.json` → `local_pack_positions`)

**Flag for Paperclip issue if:**
- Roden Law dropped out of the local pack compared to last recorded position
- A new competitor has entered the top 3

---

## Step 4: Review Count and Rating Tracking

For the audited office, track review data on Google and Avvo.

**Google Business Profile:**
- [ ] WebSearch `"Roden Law" [city] reviews`
- [ ] WebFetch the Google Maps listing if accessible
- [ ] Record: total review count, average rating, most recent review date

**Avvo:**
- [ ] WebSearch `"Roden Law" avvo [city]`
- [ ] WebFetch the Avvo listing
- [ ] Record: total review count, Avvo rating, most recent review date

**Compare against prior week's data from `citation-inventory.json`:**
- [ ] Calculate review velocity: new reviews since last audit
- [ ] Flag if competitor review count significantly exceeds Roden Law's for this market (check top 1-2 local pack competitors)

**Create Paperclip issue if:**
- Review velocity has stalled (0 new reviews in 4+ weeks) — label: `local-seo`, priority: P2
- A competitor has significantly more reviews and is outranking Roden Law in local pack

---

## Step 5: Identify Missing or Stale Listings

Beyond the 8 directories checked in Step 2, scan for additional directories where Roden Law should be listed but isn't.

**Additional directories to check for the audited office's state:**

For Georgia offices (Savannah, Darien):
- [ ] State Bar of Georgia member directory
- [ ] Georgia Trial Lawyers Association
- [ ] Savannah Area Chamber of Commerce (for Savannah office)

For South Carolina offices (Charleston, Columbia, Myrtle Beach):
- [ ] SC Bar member directory
- [ ] South Carolina Association for Justice
- [ ] Local chamber of commerce (Charleston Metro Chamber, Columbia Chamber, Myrtle Beach Area Chamber)

**For each:**
- [ ] WebSearch `"Roden Law" site:[directory domain]`
- [ ] If not found: confirm missing, create Paperclip issue

---

## Step 6: Update Data Store

Before creating reports, write all findings to the persistent data store.

- [ ] Open `agents/data/citation-inventory.json`
- [ ] Update `last_run` timestamp
- [ ] Update `last_audited_office` to this week's office
- [ ] Update `citation_audits` → `[this_week_office]` with this week's results for all 8 directories
- [ ] Update `local_pack_positions` → `[this_week_office]` with the 3 query results
- [ ] Update `review_data` → `[this_week_office]` with current counts and ratings
- [ ] Append to `session_log`
- [ ] Write the updated JSON back to the file

---

## Step 7: Create Paperclip Issues

For every discrepancy, missing listing, and local pack change found in Steps 2-5, create a Paperclip issue.

**NAP discrepancy issues:**
- Label: `local-seo`
- Priority: P0 for wrong address/phone, P1 for missing suite, P2 for missing listing
- Title: `[NAP Fix P0] Correct [field] on [directory] for [office]`
- Body: canonical value, current incorrect value, directory URL, correction steps
- Assign to: Founding Engineer (if firm-data.php update needed) or SEO Strategist (if directory correction needed)

**Local pack drop issues:**
- Label: `local-seo`
- Priority: P1
- Title: `[Local Pack] Roden Law dropped from top 3 for "[query]" in [city]`
- Body: prior position, current position, competitor now occupying the slot

**Review velocity issues:**
- Label: `local-seo`
- Priority: P2
- Title: `[Reviews] Review velocity stalled for [office] — [X] weeks without new review`

**Missing listing issues:**
- Label: `local-seo`
- Priority: P2
- Title: `[Missing Listing] Roden Law not listed on [directory] — [office]`
- Body: directory URL, competitor listing example, recommended NAP to submit

- [ ] Confirm all issues created and IDs recorded in `citation-inventory.json`

---

## Step 8: Report to Principals

### Report to SEO Strategist

Prepare a local SEO health summary covering:
- Overall citation health for audited office (% of checked directories accurate)
- Local pack position for the 3 monitored queries
- Review velocity trend (improving, flat, declining)
- Top citation issues found this week (severity and count)
- Recommendation: is this office's local SEO footprint healthy, at risk, or needs urgent attention?
- Next week's audit office

### Report to Founding Engineer

Prepare an implementation summary covering:
- All P0 and P1 discrepancies with exact correction needed (field, wrong value, canonical value, directory URL)
- Any indication that `inc/firm-data.php` itself may need updating (flag explicitly)
- Paperclip issue IDs for all created issues
- Any directory correction workflows that require owner-level access or verification

---

## Step 9: Fact Extraction and Exit

Before closing the session:

- [ ] Confirm `citation-inventory.json` has been written successfully
- [ ] Confirm all Paperclip issues have been created with correct labels and priorities
- [ ] Confirm both principals have been notified
- [ ] Confirm `last_audited_office` is updated for next week's rotation
- [ ] Note any directories that were inaccessible or returned errors (log in `session_log`)

**Exit cleanly.** Do not leave open tasks or unwritten data.

---

## Data Store Schema Reference

`agents/data/citation-inventory.json` expected structure:

```json
{
  "last_run": "ISO 8601 timestamp",
  "last_audited_office": "savannah",
  "session_log": [],
  "citation_audits": {
    "savannah": {
      "last_audited": "ISO 8601 date",
      "directories": [
        {
          "name": "Avvo",
          "url": "https://...",
          "status": "MATCH | DISCREPANCY | MISSING",
          "discrepancies": [
            {
              "field": "address",
              "canonical": "333 Commercial Dr., Savannah, GA 31406",
              "found": "333 Commercial Drive, Savannah, GA 31406",
              "severity": "P3",
              "paperclip_issue_id": "201"
            }
          ]
        }
      ]
    },
    "darien": {},
    "charleston": {},
    "columbia": {},
    "myrtle-beach": {}
  },
  "local_pack_positions": {
    "savannah": [
      {
        "query": "personal injury lawyer Savannah GA",
        "position": 2,
        "checked_date": "ISO 8601 date",
        "competitors_top3": ["Firm A", "Roden Law", "Firm B"]
      }
    ],
    "darien": [],
    "charleston": [],
    "columbia": [],
    "myrtle-beach": []
  },
  "review_data": {
    "savannah": {
      "google": {
        "count": 0,
        "rating": 0.0,
        "last_review_date": "ISO 8601 date",
        "last_checked": "ISO 8601 date"
      },
      "avvo": {
        "count": 0,
        "rating": 0.0,
        "last_checked": "ISO 8601 date"
      }
    },
    "darien": {},
    "charleston": {},
    "columbia": {},
    "myrtle-beach": {}
  }
}
```
