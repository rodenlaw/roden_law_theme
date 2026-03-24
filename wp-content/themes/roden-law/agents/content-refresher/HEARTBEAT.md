# Content Refresher — Heartbeat Protocol

**Cron:** `0 8 * * 4` (every Thursday at 8:00 AM)

---

## Step 1: Identity and Context Check

1. Confirm identity: I am the Content Refresher. My mission is to audit practice area cluster health and surface content decay, accuracy failures, linking gaps, and thin content.
2. Read `AGENTS.md` to confirm working rules are loaded.
3. Read `memory/rotation-state.json` to determine which cluster was audited last week and which cluster is next in the 18-week rotation.
4. Read `agents/data/content-health.json` to load current health scores for all previously audited pages.
5. Confirm today's date and the current week/cycle number.

---

## Step 2: Select the Practice Area Cluster for This Cycle

1. Load the rotation from `memory/rotation-state.json`. The rotation is the ordered list of 18 (then 22) practice area slugs.
2. Select the next cluster in sequence based on `next_index`.
3. Update `next_index` in `rotation-state.json` (wrap to 0 after index 17).
4. Record:
   - Cluster practice area slug (e.g., `car-accident-lawyers`)
   - Practice area display name (e.g., "Car Accident Lawyers")
   - Expected pages in cluster: 1 pillar + up to 5 intersections + N sub-types
   - Previous audit date for this cluster (from rotation-state.json), if any

---

## Step 3: Inventory the Cluster

Before auditing content, establish what pages exist in the cluster.

### 3a. Identify the Pillar Page

The pillar page lives at `/practice-areas/[slug]/`. It has no parent post in WordPress. Confirm:
- The pillar page post exists (check via theme file grep or seeder data)
- The `_roden_jurisdiction` meta field value (both / georgia / south-carolina)
- The assigned `_roden_author_attorney` value (E-E-A-T attribution)
- The `_roden_faqs` repeater — count the number of Q&A pairs

### 3b. Identify Intersection Pages

Intersection pages are child posts of the pillar with `_roden_office_key` matching one of the 5 office slugs. Expected intersection pages:
- `[slug]/savannah-ga/`
- `[slug]/darien-ga/`
- `[slug]/charleston-sc/`
- `[slug]/columbia-sc/`
- `[slug]/myrtle-beach-sc/`

For each, confirm it exists and note its creation date.

### 3c. Identify Sub-Type Pages

Sub-type pages are child posts of the pillar without a matching office key. List all sub-type slugs found for this cluster.

### 3d. Identify Related Content

Using Grep, find blog posts, resource pages, and other pages that:
- Link to any page in this cluster
- Mention the practice area slug in their content
- Are tagged with the relevant `practice_category` taxonomy

---

## Step 4: Pillar Page Deep Audit

Audit the pillar page against all of the following checks. For each check, record: pass / fail / warning, evidence, and severity (1–5).

### 4a. Word Count

Read the pillar page template or post content.
- Pass: 1,500+ words
- Warning: 800–1,499 words (Severity 2)
- Fail: under 800 words (Severity 4)

### 4b. Statute Citations

Verify that the correct statutes are cited for the jurisdiction(s) served.

**Georgia (if jurisdiction = both or georgia):**
- Personal injury SOL must cite: O.C.G.A. § 9-3-33
- Comparative fault must cite: O.C.G.A. § 51-12-33

**South Carolina (if jurisdiction = both or south-carolina):**
- Personal injury SOL must cite: S.C. Code § 15-3-530

Grading:
- All required citations present: Pass
- Missing one citation: Warning (Severity 3)
- Missing multiple or citing wrong section numbers: Fail (Severity 5)

### 4c. FAQ Count and Quality

Read the `_roden_faqs` repeater data (from seeder scripts or theme meta).
- Pass: 5–8 Q&A pairs, each answer 50+ words
- Warning: 3–4 Q&A pairs or any answer under 30 words (Severity 2)
- Fail: fewer than 3 Q&A pairs (Severity 3)

Also check: Do the FAQ questions match real search queries? Cross-reference against `agents/data/qa-discoveries.json` — flag any high-priority discovered questions (score 6+) that are not yet in the FAQ.

### 4d. E-E-A-T Attribution

Check that `_roden_author_attorney` is set to a valid attorney post ID.
- Pass: Attorney assigned
- Fail: No attorney assigned (Severity 4)

### 4e. Firm Stats Freshness

Grep the pillar page content for any of the following stat references and verify they match current values:
- "$250M+" or "$250 million+" — current: $250M+
- "500+ reviews" — current: 500+
- "5,000+ cases" — current: 5,000+
- "62 years" combined experience — current: 62 years
- "4.9" star rating — current: 4.9
- "5 offices" or "five offices" — current: 5

Flag any outdated stat as Severity 3.

### 4f. Internal Links From Pillar to Intersections

Verify the pillar page links to each of its 5 intersection pages (or however many exist). A location matrix or office grid should be present.
- Pass: Links to all existing intersection pages
- Warning: Missing 1–2 intersection links (Severity 2)
- Fail: Missing 3+ intersection links or no matrix/grid at all (Severity 4)

---

## Step 5: Intersection Page Audit (All 5)

For each intersection page in the cluster, perform the following checks.

### 5a. Word Count

- Pass: 600+ words
- Warning: 350–599 words (Severity 2)
- Fail: under 350 words (Severity 3)

### 5b. Unique Local Content

Evaluate whether the page has content specific to that city/office beyond just the city name swapped into a template. Look for:
- Local court name (e.g., "Chatham County Superior Court" for Savannah, "Charleston County Circuit Court" for Charleston)
- Local road, neighborhood, or area references
- Local statistics or news references
- Office-specific phone number

Grading:
- 3+ local specificity signals: Pass
- 1–2 local signals: Warning (Severity 2)
- No local signals — pure template: Fail (Severity 4)

### 5c. Internal Link to Pillar

The intersection page must link back to its parent pillar page.
- Pass: Link to pillar present
- Fail: No link to pillar (Severity 3)

### 5d. Correct Jurisdiction Content

GA offices (savannah-ga, darien-ga) must display GA-specific law.
SC offices (charleston-sc, columbia-sc, myrtle-beach-sc) must display SC-specific law.
Cross-jurisdiction content on a single-state intersection page is a Severity 3 error.

---

## Step 6: Sub-Type Page Audit

For each sub-type page in the cluster, perform the following checks.

### 6a. Word Count

- Pass: 500+ words
- Warning: 300–499 words (Severity 2)
- Fail: under 300 words (Severity 3)

### 6b. Differentiation from Pillar

Does the sub-type page cover materially different content from the pillar? Look for:
- Specific sub-type legal theory or statute
- Unique causes or contributing factors
- Unique damages or compensation considerations

Grading:
- Clearly differentiated: Pass
- Mostly a rewording of the pillar with the sub-type name swapped in: Warning (Severity 2)
- Identical or near-identical to pillar: Fail — potential cannibalization (Severity 4)

### 6c. Internal Link to Pillar

Same requirement as intersection pages. Sub-type must link back to pillar.
- Pass: Link present
- Fail: No link to pillar (Severity 3)

---

## Step 7: GSC Data Check (Content Decay Signals)

Query Google Search Console for impression and click data for each page in the cluster.

### Decay Detection Logic

For each page, retrieve:
- Impressions (last 28 days) vs. impressions (prior 28 days)
- Clicks (last 28 days) vs. clicks (prior 28 days)
- Average position (last 28 days)

**Decay signals:**
- Impressions decline > 30% over 28 days: Severity 3
- Impressions decline > 50% over 28 days: Severity 4
- Click-through rate under 1% with 500+ impressions: Warning (Severity 2) — title/meta optimization needed
- Position worse than 20 on branded + location query: Severity 3

If GSC API is unavailable, note this and proceed without decay data. Do not skip the rest of the audit.

---

## Step 8: Internal Link Audit — Inbound Links Per Page

For each page in the cluster, estimate inbound internal links by searching the codebase and any link data available.

### Minimum Thresholds

| Page Type | Minimum Inbound Internal Links |
|-----------|-------------------------------|
| Pillar | 10 |
| Intersection | 5 |
| Sub-type | 3 |

**How to check:**
- Grep the entire theme templates for the page slug or URL pattern to find where it is linked from
- Check related blog posts, the homepage template, navigation menus, and location pages for links into the cluster

Grading:
- Meets minimum: Pass
- 1–2 below minimum: Warning (Severity 2)
- 3+ below minimum or 0 inbound links: Fail (Severity 4) — orphaned page

---

## Step 9: Keyword Cannibalization Check

Identify whether multiple pages in the cluster are targeting the same primary keyword.

### Methodology

1. Note the primary keyword for the pillar (e.g., "car accident lawyers Georgia South Carolina").
2. For each intersection page, the primary keyword should include the city modifier (e.g., "car accident lawyer Savannah GA") — not the same as the pillar.
3. For each sub-type page, the primary keyword should be the sub-type (e.g., "drunk driving accident lawyer Georgia") — not the same as the pillar or another sub-type.

Flag as potential cannibalization (Severity 3) if:
- Two pages in the cluster appear to target the same query without city or sub-type differentiation
- A sub-type page's title matches the pillar's title with only a word swap
- A blog post from the related content list appears to be targeting the pillar's primary keyword without linking to the pillar

---

## Step 10: Update content-health.json

Write audit findings for all pages in this cycle's cluster to `agents/data/content-health.json`.

### Record Structure

```json
{
  "page_slug": "car-accident-lawyers",
  "page_type": "pillar",
  "pa_cluster": "car-accident-lawyers",
  "last_audited": "2026-03-20",
  "audit_cycle": 1,
  "overall_health_score": 82,
  "findings": [
    {
      "check": "faq_count",
      "result": "warning",
      "evidence": "4 FAQ pairs found, minimum is 5",
      "severity": 2,
      "recommendation": "Add at least 1 FAQ entry. Cross-reference qa-discoveries.json for high-scoring gaps."
    }
  ],
  "word_count": 1843,
  "faq_count": 4,
  "inbound_internal_links": 14,
  "gsc_impressions_28d": 1240,
  "gsc_clicks_28d": 87,
  "has_attorney_attribution": true,
  "statute_citations_present": ["O.C.G.A. § 9-3-33", "S.C. Code § 15-3-530"]
}
```

**Overall health score formula:**
Start at 100. Subtract:
- Severity 5 finding: -20 points
- Severity 4 finding: -12 points
- Severity 3 finding: -7 points
- Severity 2 finding: -3 points
- Severity 1 finding: -1 point

Scores below 60 are flagged as "needs immediate attention." Scores 60–79 are "needs review." Scores 80+ are "healthy."

Write all page records. Preserve existing records for pages not in this cycle's cluster.

---

## Step 11: Create Paperclip Issues for Findings (Severity 3+)

For every finding with severity 3, 4, or 5, create a Paperclip issue.

### Issue Template

```
Title: [Content Refresh] [Page Type] — [PA Cluster]: [Short finding description]

Labels: content-refresh, [pa-slug], [page-type], severity-[N]

Body:
## Page
[Page slug / URL]
Last audited: [date]
Health score: [X/100]

## Finding
**Check:** [check name]
**Severity:** [1–5]
**Evidence:** [specific evidence — word count, missing citation, etc.]

## Recommended Action
[Specific action: rewrite, add FAQ, add internal links, update stat, etc.]
Estimated effort: [small / medium / large]

## Context
Cluster: [pa-slug]
Page type: [pillar / intersection / sub-type]
Audit cycle: [N]
```

**Severity labels:**
- Severity 5: also add label `critical`
- Severity 4: also add label `high-priority`
- Severity 3: standard `content-refresh` label only

Maximum 15 issues per cycle. If more than 15 findings qualify, prioritize by severity (highest first), then by pillar > intersection > sub-type.

---

## Step 12: Report to Content Director

Compile a cycle summary and deliver it to the Content Director.

### Summary Report Format

```
CYCLE [N] REPORT — Content Refresher
Date: [date]
Cluster audited: [pa-slug] — [PA display name]

CLUSTER INVENTORY
- Pillar: 1
- Intersection pages: [N] (of 5 expected)
- Sub-type pages: [N]
- Related blog posts / resources: [N]

HEALTH SCORES
- Pillar: [X/100] — [healthy / needs review / needs immediate attention]
- Intersections: [average X/100] — range [low]–[high]
- Sub-types: [average X/100] — range [low]–[high]

FINDINGS SUMMARY
- Total findings: [N]
- Severity 5 (critical): [N]
- Severity 4 (high): [N]
- Severity 3 (standard): [N]
- Severity 2 (warning): [N]
- Paperclip issues created: [N]

TOP FINDINGS
1. [Finding] — [page slug] — Severity [N] — [brief recommendation]
2. [Finding] — [page slug] — Severity [N] — [brief recommendation]
3. [Finding] — [page slug] — Severity [N] — [brief recommendation]

DECAY SIGNALS
[Any pages showing GSC impression/click decline > 30%]

CANNIBALIZATION FLAGS
[Any pages identified as potentially cannibalizing each other]

ROTATION STATUS
- Clusters audited to date: [N]/18
- Next cluster: [slug]
- Full rotation completion: [date estimate]

NOTES
[Anything unusual, data gaps (e.g., GSC unavailable), or items needing Content Director decision]
```

Deliver by appending to `agents/content-director/memory/inbox.md`.

---

## Step 13: Fact Extraction and Exit

1. Verify `agents/data/content-health.json` was written successfully (confirm record count).
2. Verify `memory/rotation-state.json` was updated with new `next_index` and the audit date for this cluster.
3. Verify all Paperclip issues were created for qualifying findings.
4. Log cycle completion to `memory/cycle-log.json`:
   ```json
   {
     "cycle": [N],
     "date": "[date]",
     "cluster_audited": "[pa-slug]",
     "pages_audited": [N],
     "total_findings": [N],
     "critical_findings": [N],
     "issues_created": [N],
     "overall_cluster_health": [avg score]
   }
   ```
5. Exit cleanly. Next heartbeat in 7 days (next Thursday at 8:00 AM).
