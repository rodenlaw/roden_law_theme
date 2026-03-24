# Heartbeat: Competitor Intelligence Agent

**Schedule:** Every Wednesday at 7:00 AM (`cron: 0 7 * * 3`)

---

## Pre-Flight: Identity and Context Check

Before doing any work, confirm your operating context:

- [ ] Read `AGENTS.md` — confirm role, reporting structure, working rules
- [ ] Read `SOUL.md` — re-anchor competitive analysis mindset
- [ ] Read `CLAUDE.md` — confirm current practice area list, URL architecture, firm stats
- [ ] Read `agents/data/competitive-rankings.json` — load prior week's state (create file with empty scaffold if missing)
- [ ] Note today's date and which markets were deep-audited last week (rotate focus if needed)

---

## Step 1: Maintain Competitor List

For each of the 5 markets, maintain a list of the top 5-8 competing PI firms. Update when new competitors appear or known firms change their presence.

**For each market, identify competitors via:**
- WebSearch: `"personal injury lawyer [city]"` — scan top 10 organic results
- WebSearch: `"car accident attorney [city]"` — cross-reference
- Note any new entrants or firms that have climbed significantly since last week

**Markets to check:**
- [ ] Savannah, GA
- [ ] Darien, GA (may overlap with Savannah/Brunswick)
- [ ] Charleston, SC
- [ ] Columbia, SC
- [ ] Myrtle Beach / Murrells Inlet, SC

**Update** `competitive-rankings.json` → `competitors` array with firm name, primary URL, markets served, and last-verified date.

---

## Step 2: Priority Keyword Position Tracking

Track Roden Law's position for the top 50 priority keywords. Focus on:

**High-value query patterns:**
- `[practice area] lawyer [city]` (e.g., "car accident lawyer Savannah")
- `[city] [practice area] attorney`
- `best [practice area] lawyer [city]`
- `[practice area] [city] no win no fee`

**Core practice areas to track each week (rotate full list across 4 weeks):**
- Week A: car accident, truck accident, slip and fall, motorcycle accident, wrongful death
- Week B: medical malpractice, workers compensation, dog bite, brain injury, spinal cord injury
- Week C: maritime injury, product liability, boating accident, burn injury, construction accident
- Week D: nursing home abuse, premises liability, pedestrian accident, bicycle accident, electric scooter

**For each keyword:**
- [ ] WebSearch the query
- [ ] Record Roden Law's position (or "not in top 10")
- [ ] Record the #1 ranking competitor URL
- [ ] Note estimated word count and schema presence if inspectable

**Update** `competitive-rankings.json` → `keyword_positions` array.

---

## Step 3: Quick Wins — Positions 4-10

Identify keywords where Roden Law currently ranks 4-10 and could realistically reach top 3 with content optimization.

**Quick win criteria:**
- Roden Law has a relevant existing page
- The page ranks 4-10
- Top 3 competitors have noticeably longer content OR better FAQ coverage OR stronger schema
- The keyword has meaningful commercial intent

**For each quick win candidate:**
- [ ] WebFetch the Roden Law page and the #1 competitor page
- [ ] Compare: word count, FAQ depth, schema types present, internal link count, heading structure
- [ ] Identify the specific gap (e.g., "competitor has 8 FAQs, Roden has 3")

**Create a Paperclip issue for each quick win:**
- Label: `quick-win`
- Title: `[Quick Win] Optimize "[keyword]" page from position [X] to top 3`
- Body: specific gap analysis and recommended actions
- Assign to: Founding Engineer

---

## Step 4: Content Gap Analysis

Search for competitor pages that Roden Law does not have an equivalent for.

**Method:**
- WebFetch each major competitor's sitemap or practice area index page
- Scan for page types Roden Law lacks: specific sub-types, neighborhood pages, FAQ hubs, resource guides, city-specific blog content
- Cross-reference against Roden Law's existing 22 practice areas and three-tier URL structure

**Flag content gaps when:**
- A competitor has a page for a sub-type or location that Roden Law does not
- Multiple competitors have similar pages (signals demand exists)
- The gap maps to a keyword with visible search volume

**Create a Paperclip issue for each significant content gap:**
- Label: `content`
- Title: `[Content Gap] Build page for "[topic/keyword]"`
- Body: competitor example URLs, estimated opportunity, recommended URL per Roden Law architecture
- Assign to: Founding Engineer

---

## Step 5: Backlink Gap Analysis

Identify directories and sites linking to competitors but not to Roden Law.

**Priority directories for PI law firms:**
- Avvo, Martindale-Hubbell, FindLaw, Justia, Super Lawyers
- Google Business Profile, Bing Places, Apple Maps
- Yelp, BBB, Chambers USA, Best Lawyers
- State bar association directories (State Bar of Georgia, SC Bar)
- Local chambers of commerce (Savannah, Charleston, Columbia, Myrtle Beach)
- Court-adjacent directories and local legal aid referral pages

**Method:**
- WebSearch `site:[competitor domain]` to assess their directory presence
- WebSearch `"[competitor firm name]" avvo OR martindale OR justia` to check coverage
- Check 2-3 top competitors per market

**For each backlink gap:**
- [ ] Confirm Roden Law is not already listed (WebSearch `"Roden Law" [directory name]`)
- [ ] Note the specific URL where the competitor appears
- [ ] Flag as Paperclip issue if confirmed missing

**Create Paperclip issues:**
- Label: `local-seo`
- Title: `[Backlink Gap] Claim/update listing on [directory] for [office]`
- Body: competitor's listing URL, recommended NAP to submit, priority level

---

## Step 6: AI Overview Monitoring

For 5 high-value queries this week, check whether Google is showing AI Overviews and who gets cited.

**Select 5 queries from this list (rotate weekly):**
- "what to do after a car accident in Georgia"
- "how long do I have to file a car accident claim in South Carolina"
- "car accident lawyer Savannah GA"
- "truck accident attorney Charleston SC"
- "slip and fall lawyer Columbia SC"
- "what is comparative fault in Georgia"
- "workers compensation attorney Savannah"
- "wrongful death lawsuit South Carolina"
- "motorcycle accident lawyer Myrtle Beach"
- "medical malpractice statute of limitations Georgia"

**For each query:**
- [ ] WebSearch the query
- [ ] Note: Does an AI Overview appear? (yes/no)
- [ ] If yes: which domain(s) are cited in the AI Overview?
- [ ] Is Roden Law cited? (yes/no)
- [ ] If a competitor is cited and Roden Law is not, what type of content are they citing? (FAQ page, guide, blog post, etc.)

**Create Paperclip issues for AI Overview gaps:**
- Label: `content`
- Title: `[AI Overview] Optimize content for "[query]" — competitor cited, not Roden Law`
- Body: query, cited competitor URL, content type, recommended optimization

---

## Step 7: Update Data Store

Before creating reports, write all findings to the persistent data store.

- [ ] Open `agents/data/competitive-rankings.json`
- [ ] Update `last_run` timestamp
- [ ] Update `competitors` with any changes
- [ ] Update `keyword_positions` with this week's tracked positions
- [ ] Update `quick_wins` with current candidates
- [ ] Update `content_gaps` with new gaps found
- [ ] Update `backlink_gaps` with new directory opportunities
- [ ] Update `ai_overview_status` with this week's 5 queries
- [ ] Write the updated JSON back to the file

---

## Step 8: Create Paperclip Issues

Review all findings from Steps 3-6 and ensure every actionable item has a corresponding Paperclip issue.

**Issue checklist:**
- [ ] Quick-win optimization issues created (label: `quick-win`)
- [ ] Content gap issues created (label: `content`)
- [ ] Backlink/directory issues created (label: `local-seo`)
- [ ] AI Overview content issues created (label: `content`)

---

## Step 9: Report to Principals

### Report to SEO Strategist

Prepare a strategic summary covering:
- Top 3 competitive threats identified this week (firms gaining ground)
- Top 3 keyword opportunities (gaps where content investment would pay off)
- Content moat status — where Roden Law has depth advantage and where that advantage is eroding
- AI Overview positioning — are we getting cited? Are competitors?
- Recommended strategic priority for next week

### Report to Founding Engineer

Prepare an implementation summary covering:
- Paperclip issues created this week (with issue IDs if available)
- Quick-win pages that need specific optimization work (URL, what to change)
- New pages that should be built (URLs, architecture tier, content brief summary)
- Any technical observations (competitor schema types, URL structure advantages, page speed signals)

---

## Step 10: Fact Extraction and Exit

Before closing the session:

- [ ] Confirm `competitive-rankings.json` has been written successfully
- [ ] Confirm all Paperclip issues have been created
- [ ] Confirm both principals have been notified
- [ ] Note any anomalies or data quality issues for next run
- [ ] Log session completion with timestamp in `competitive-rankings.json` → `session_log`

**Exit cleanly.** Do not leave open tasks or unwritten data.

---

## Data Store Schema Reference

`agents/data/competitive-rankings.json` expected structure:

```json
{
  "last_run": "2026-03-20T07:00:00Z",
  "session_log": [],
  "competitors": {
    "savannah": [],
    "darien": [],
    "charleston": [],
    "columbia": [],
    "myrtle-beach": []
  },
  "keyword_positions": [],
  "quick_wins": [],
  "content_gaps": [],
  "backlink_gaps": [],
  "ai_overview_status": []
}
```
