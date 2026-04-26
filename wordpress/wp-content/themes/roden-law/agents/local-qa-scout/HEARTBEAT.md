# Local Q&A Scout — Heartbeat Protocol

**Cron:** `0 9 */3 * *` (every 72 hours at 9:00 AM)

---

## Step 1: Identity and Context Check

1. Confirm identity: I am the Local Q&A Scout. My mission is to discover unanswered questions about personal injury law in Roden Law's GA/SC markets.
2. Read `AGENTS.md` to confirm working rules are loaded.
3. Read `memory/rotation-state.json` to determine which practice area × city combinations were covered in the last cycle and which 3 to select this cycle.
4. Read `agents/data/qa-discoveries.json` to load the current state of all known questions (covered and gaps).
5. Confirm today's date. Note the current cycle number.

---

## Step 2: Select 3 PA × City Combinations for This Cycle

1. Load the rotation queue from `memory/rotation-state.json`. The queue tracks the next index position across the 110-item ordered list of PA × city combos.
2. Select the next 3 combos in sequence. If the end of the list is reached, wrap around to the beginning.
3. Record the selected combos and update the `next_index` field in `rotation-state.json`.
4. For each selected combo, note:
   - Practice area name and slug (e.g., "car accident lawyers", `car-accident-lawyers`)
   - City name and slug (e.g., "Savannah", `savannah-ga`)
   - State (GA or SC) and the applicable jurisdiction data

Example selected combos for a cycle:
```json
[
  { "pa_slug": "car-accident-lawyers", "pa_name": "Car Accident Lawyers", "city_slug": "savannah-ga", "city": "Savannah", "state": "GA" },
  { "pa_slug": "slip-and-fall-lawyers", "pa_name": "Slip and Fall Lawyers", "city_slug": "charleston-sc", "city": "Charleston", "state": "SC" },
  { "pa_slug": "truck-accident-lawyers", "pa_name": "Truck Accident Lawyers", "city_slug": "columbia-sc", "city": "Columbia", "state": "SC" }
]
```

---

## Step 3: Search Query Execution (Per Combo)

For each of the 3 selected combos, run the following searches. Record all "People Also Ask" questions, autocomplete suggestions, and related searches found.

### 3a. Primary Search Queries

Run each of these query patterns:
- `"[practice area] lawyer [city]"` — e.g., "car accident lawyer Savannah"
- `"[practice area] [city] [state full name]"` — e.g., "car accident Savannah Georgia"
- `"[practice area] attorney [city] [state abbreviation]"` — e.g., "car accident attorney Savannah GA"
- `"how much does a [practice area] attorney cost [city]"` — fee/cost intent
- `"do I need a lawyer for [practice area injury type] [city/state]"` — investigational intent

### 3b. Extract PAA Questions

For each search, capture:
- All visible "People Also Ask" questions
- The featured snippet or AI overview if present (note whether Roden Law is cited)
- Related searches at the bottom of the SERP

### 3c. Autocomplete Mining

Search the following autocomplete seed queries and record all suggested completions:
- `"[practice area] lawyer [city] "`
- `"[city] [practice area injury] "`
- `"what happens if ` + relevant injury type + city/state modifier

---

## Step 4: Reddit Community Sourcing (Per Combo)

Search the following subreddits for questions related to each combo's practice area and city/state. Focus on posts from the past 12 months.

### Subreddits to Search

| Market | Subreddit |
|--------|-----------|
| Savannah / SE Georgia | r/savannah |
| Charleston / Lowcountry | r/charleston |
| Columbia / Midlands SC | r/columbia_sc |
| Myrtle Beach / Grand Strand | r/MyrtleBeach |
| Darien / Southeast GA coast | r/savannah (closest active community) |
| GA statewide | r/Georgia |
| SC statewide | r/southcarolina |
| All markets | r/legaladvice |
| All markets | r/personalinjury (if exists) |

### Reddit Search Queries

- `"[practice area] [city]"` — direct geo-PA query
- `"lawyer [city]"` — general legal advice seeking
- `"accident [city]"` — incident reports that reveal questions
- `"insurance [injury type] [state]"` — insurance dispute questions

### What to Capture from Reddit

For each relevant thread found:
- The original question (verbatim or paraphrased if very long)
- Thread URL
- Upvote count and comment count (signals community interest)
- Top-voted answer summary (reveals what people accept as correct)
- Subreddit and post date

---

## Step 5: Cross-Reference Against Existing FAQ Coverage

Before scoring any question as a gap, check whether it is already covered.

### 5a. Check qa-discoveries.json

Read `agents/data/qa-discoveries.json`. Search for the question text or close paraphrases. If found with status `covered` or `published`, skip it.

### 5b. Grep Existing Theme Files

Use Grep to search for the question subject matter in existing FAQ-related content:

```
Search pattern: keywords from the question
Files to search: inc/ directory (seeder scripts, FAQ data)
Also search: templates/ for any hardcoded FAQ content
```

Example: For the question "How long do I have to file a car accident claim in Savannah?", grep for:
- `statute of limitations` in `inc/` files
- `how long` near `car accident` or `savannah`
- `O.C.G.A.` near the practice area slug

### 5c. Mark Coverage Status

For each discovered question, assign one of:
- `new_gap` — Not found anywhere in the site content
- `partial` — Addressed but not as a dedicated FAQ entry; could be improved
- `covered` — Already answered adequately in a FAQ, blog post, or page

---

## Step 6: Score Each Question

Score each question on a 1–10 scale using this rubric:

| Dimension | Weight | Criteria |
|-----------|--------|----------|
| Search volume potential | 3 pts | PAA appearance = 3, autocomplete = 2, Reddit only = 1 |
| AI-citation potential | 3 pts | Has featured snippet or AI overview = 3, likely cited = 2, informational only = 1 |
| Intent value | 2 pts | Transactional = 2, investigational = 1, pure informational = 0.5 |
| Gap severity | 2 pts | new_gap = 2, partial = 1, covered = 0 |

**Score threshold:**
- 8–10: Critical gap — create Paperclip issue immediately
- 6–7: High priority — add to Content Director queue
- 4–5: Low priority — log in qa-discoveries.json, revisit next rotation
- 1–3: Informational only — log with status `low-priority`

---

## Step 7: Update qa-discoveries.json

Write all newly discovered questions to `agents/data/qa-discoveries.json`.

### Record Structure

```json
{
  "id": "qa-[timestamp]-[sequence]",
  "question": "How long do I have to file a car accident lawsuit in Georgia?",
  "pa_slug": "car-accident-lawyers",
  "city_slug": "savannah-ga",
  "state": "GA",
  "jurisdiction": "georgia",
  "intent": "informational",
  "source": "PAA",
  "source_url": "https://www.google.com/search?q=car+accident+lawyer+savannah",
  "coverage_status": "new_gap",
  "score": 8,
  "cycle": 12,
  "discovered_date": "2026-03-20",
  "notes": "Appears in PAA for 3 of 5 search variants. O.C.G.A. § 9-3-33 should be cited in the answer."
}
```

Preserve all existing records. Append new ones. Do not overwrite or delete existing entries.

---

## Step 8: Create Paperclip Issues for High-Value Gaps

For every question scoring 6 or higher with coverage status `new_gap` or `partial`, create a Paperclip issue.

### Issue Template

```
Title: [Q&A Gap] [Practice Area] × [City]: "[Question text shortened to ~60 chars]"

Labels: qa-discovery, [pa-slug], [city-slug], [state]

Body:
## Question Discovered
[Full question text]

## Source
- Type: [PAA / Reddit / Autocomplete]
- URL: [source URL or thread link]
- Discovered: [date]

## Coverage Status
[new_gap / partial]
Current coverage note: [what exists, if anything]

## Score: [X/10]
- Search volume potential: [X/3]
- AI-citation potential: [X/3]
- Intent value: [X/2]
- Gap severity: [X/2]

## Recommended Action
[FAQ addition to existing page / new blog post / new resource page]
Suggested target page: [URL or template]

## Jurisdiction Note
[State-specific statute or rule that should be cited in the answer]
GA: O.C.G.A. § 9-3-33 (2-year SOL), modified comparative fault < 50%
SC: S.C. Code § 15-3-530 (3-year SOL), modified comparative fault < 51%
```

---

## Step 9: Report to Content Director

After completing all 3 combo audits, compile a cycle summary and deliver it to the Content Director.

### Summary Report Format

```
CYCLE [N] REPORT — Local Q&A Scout
Date: [date]
Combos audited: [3 combos listed]

DISCOVERIES THIS CYCLE
- Total questions collected: [N]
- New gaps found: [N]
- High-priority gaps (score 6+): [N]
- Paperclip issues created: [N]

TOP 3 FINDINGS THIS CYCLE
1. [Question] — [PA × City] — Score [X] — [Brief recommendation]
2. [Question] — [PA × City] — Score [X] — [Brief recommendation]
3. [Question] — [PA × City] — Score [X] — [Brief recommendation]

ROTATION STATUS
- Combos completed to date: [N]/110
- Next 3 combos scheduled: [list]
- Estimated full rotation completion: [date]

NOTES
[Any anomalies, unavailable searches, or observations for the Content Director]
```

Deliver this report by writing it to `agents/content-director/memory/inbox.md` (append, do not overwrite).

---

## Step 10: Fact Extraction and Exit

1. Verify `agents/data/qa-discoveries.json` was written successfully (confirm record count increased).
2. Verify `memory/rotation-state.json` was updated with the new `next_index`.
3. Verify all Paperclip issues were created for qualifying gaps.
4. Log cycle completion to `memory/cycle-log.json`:
   ```json
   {
     "cycle": [N],
     "date": "[date]",
     "combos_audited": ["[combo1]", "[combo2]", "[combo3]"],
     "questions_collected": [N],
     "gaps_found": [N],
     "issues_created": [N]
   }
   ```
5. Exit cleanly. Next heartbeat in 72 hours.
