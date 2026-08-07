# Content brief — roden-content-writer

**Page:** Truck accident settlement process (new `resource` page)
**Brief date:** 2026-08-06

> Read this entire file, then write the page per your standard system-prompt patterns — Key Takeaways,
> According-to citations, comparison table, prose attribution, FAQs, internal links, jurisdiction-stamped
> statutes, Last-reviewed line. **Those rules belong to you; this brief supplies facts, not rules.**
> Save the draft to `docs/briefs/drafts/2026-08-06-truck-accident-settlement-process-draft.md`.
> Claude Code only — no other vendor LLM.

---

## Why this page exists

This page must own one conversational AI prompt:

> **"How do I start the settlement process with a truck accident lawyer, and what do they need from me
> to get the best outcome?"**

It is **two questions**, and the second one is the prize:

1. *How does it start / what is the sequence?*
2. *What does the lawyer need FROM ME to maximize the outcome?*

A sweep of all 710 posts in `content/meta.json` and 1,227 URLs in `wp-content-inventory-urls.txt`
confirms rodenlaw.com has **no settlement-process page, no claim-timeline page, and — anywhere on the
site — no "what to bring to a lawyer" document checklist.** Question 2 is completely uncontested.

Trucking is the site's densest cluster (pillar + 6 intersections + 11 sub-types + ~40 corridor
resources). It is deep on *where crashes happen* and *what a case is worth*, and silent on *what the
client does next*. You are writing the missing middle.

---

## Page specification

| Field | Value |
|---|---|
| **Page type** | `resource` (CPT), not blog, not sub-type |
| **Slug** | `truck-accident-settlement-process` |
| **Target URL** | `/resources/truck-accident-settlement-process/` (verified 404 — free) |
| **SEO title** | How to Start a Truck Accident Settlement — and What Your Lawyer Needs From You |
| **H1** | How Do I Start the Settlement Process With a Truck Accident Lawyer? |
| **Jurisdiction** | `both` — carries **both** `O.C.G.A. §` and `S.C. Code §` citations |
| **Attribution** | **Joshua Dorminy** — Partner, Darien GA office, admitted in Georgia **and** South Carolina, leads Roden Law's trucking litigation |
| **Word target** | 2,400–2,800 |
| **Primary keyword** | `truck accident settlement process` |

### Required frontmatter

```yaml
---
page_type: resource
target_url: /resources/truck-accident-settlement-process/
jurisdiction: both
_roden_author_attorney: Joshua Dorminy (Darien, GA & SC)
_roden_is_howto: 1
primary_keyword: truck accident settlement process
word_count: <actual count>
internal_links: <count>
schema_feeds: [HowTo, FAQPage]
excerpt: "<140-160 char meta description>"
---
```

**Why `_roden_is_howto: 1`:** verified at `inc/schema-helpers.php:305-320` — this flag swaps
`roden_schema_article()` for `roden_schema_howto()`, and `roden_schema_faq_page()` fires additively
either way. **Consequence for you:** the phases section must be *genuinely sequential and stepwise*,
one H3 per phase, in order, each self-contained. Do not interleave digressions into that section — put
them elsewhere on the page.

---

## Outline

### 1. `Last reviewed: 2026-08-06`
ISO form only. Prose month names fail the gate.

### 2. `## Key Takeaways` — 6 bullets
Immediately under the H1 / Last-reviewed line. ≤25 words each, self-contained, liftable. Lead with the
concrete action. At least one bullet must answer "what do I bring," and one must say starting costs
nothing.

### 3. `## How the settlement process starts` (~250w)
**Answer-first.** Open by answering the question directly: it starts with a free consultation and a
signed contingency-fee agreement, after which the firm sends a spoliation/evidence-preservation letter
to the motor carrier. Establish that the reader can start today and that starting costs nothing.

### 4. `## The seven phases of a truck accident settlement` (~700w) — the HowTo spine
One H3 per phase, **in order**, each with a labeled lead-in (`**Phase 3 — treatment.** …`). Carries the
first required table.

| Phase | What happens | Typical duration | What you do |
|---|---|---|---|
| 1. Consultation & retention | ... | ... | ... |
| 2. Evidence preservation & investigation | ... | ... | ... |
| 3. Medical treatment to maximum medical improvement | ... | ... | ... |
| 4. Demand package | ... | ... | ... |
| 5. Negotiation | ... | ... | ... |
| 6. Settlement or filing suit | ... | ... | ... |
| 7. Disbursement & lien resolution | ... | ... | ... |

Durations must be **ranges**, must be realistic for a **truck** case (not a car case), and the prose
must agree with the table exactly. Do not state a single-point timeline.

### 5. `## What your lawyer needs from you at the first meeting` (~400w) — **the differentiator**
**Answer-first.** Table-shaped so AI engines lift it cleanly:

| Category | Bring | Why it matters |
|---|---|---|
| The crash | Police/collision report number, photos, dashcam | ... |
| Insurance | Your declarations page, any letters from the carrier's insurer | ... |
| Medical | Provider names, ER discharge papers, prescriptions | ... |
| Work | Pay stubs, employer contact, missed-time records | ... |
| Contact attempts | Every voicemail, letter, or adjuster name | ... |

Write this in second person. Be specific and genuinely actionable — a reader should be able to work
straight down it.

### 6. `## What to gather over the following weeks` (~300w)
Second table. Explicitly separates "day one" from "ongoing": continuing treatment records,
out-of-pocket receipts, mileage to appointments, a symptom/pain journal, lost-wage verification.

### 7. `## What makes a truck settlement different from a car accident settlement` (~450w)
**This section justifies a truck-specific page.** Cover:
- Federal record retention and why speed matters (verified citation below)
- ECM / "black box" and onboard data
- Multiple potential defendants: driver, motor carrier, broker, shipper, cargo loader, maintenance vendor
- Federal minimum liability coverage tiers (verified citation below)

### 8. `## Five things that most damage your outcome` (~350w)
Behavioral, concrete, second person: giving a recorded statement to the carrier's insurer, posting on
social media, gaps in treatment, signing a blanket medical authorization, waiting.

### 9. `## Deadlines in Georgia and South Carolina` (~250w)
GA-vs-SC comparison table. Both states, jurisdiction-stamped, statutes named:

| | Georgia | South Carolina |
|---|---|---|
| Personal injury deadline | 2 years — O.C.G.A. § 9-3-33 | 3 years — S.C. Code § 15-3-530 |
| Comparative fault bar | recover if less than 50% at fault — O.C.G.A. § 51-12-33 | recover if less than 51% at fault |
| Wrongful death filed by | per your standard reference | estate's personal representative — S.C. Code § 15-51-20 |

### 10. `## What it costs to start` (~150w)
Contingency fee, no fees unless we win, free consultation. Firm stats verbatim: $300M+ recovered ·
4.9-star average · 500+ client reviews · 5,000+ cases handled · 62 years combined experience ·
6 offices · toll-free 1-844-RESULTS.

### 11. `## Frequently Asked Questions` — 7 pairs
`**Q:**` / `**A:**`. Each answer 50+ words, first 1–2 sentences self-contained and liftable (~40–60
words), jurisdiction-stamped where relevant. Phrase questions the way a frightened person searches:

1. How long does a truck accident settlement take?
2. What does it cost to hire a truck accident lawyer?
3. Will I have to go to court?
4. The trucking company's insurer already called me — what do I do?
5. What if I was partly at fault?
6. Can I start a claim before I finish medical treatment?
7. Do I really need a lawyer for a truck accident claim?

### 12. Byline paragraph
≥80 chars, **normal prose, not a blockquote, not opening a section.** Carries Joshua Dorminy's name and
his relevant bar admission (Georgia and South Carolina) and trucking focus.

---

## Verified federal facts — safe to state as written

Both confirmed against Cornell LII on 2026-08-06. **These two are verified; use them.**

- **49 CFR § 395.8(k)(1)** — a motor carrier must retain records of duty status and supporting documents
  *"not less than 6 months from the date of receipt."* This is the load-bearing fact for the
  evidence-preservation urgency argument: driver logs can lawfully be destroyed six months out, which is
  precisely why the preservation letter goes out in week one.

- **49 CFR § 387.9** — minimum financial responsibility, for-hire interstate carriers of property:
  - **$750,000** — non-hazardous property, GVWR 10,001+ lbs
  - **$1,000,000** — oil, hazardous waste, certain listed hazardous substances
  - **$5,000,000** — bulk Division 1.1/1.2/1.3; Division 2.3 Hazard Zone A; Division 6.1 PG I Hazard
    Zone A; highway route controlled Class 7

  **Note the $1,000,000 tier.** Most competitor pages state only "$750k or $5M" and are wrong. Stating
  all three correctly is a real accuracy edge — do not collapse them.

### Anything else regulatory must be verified or omitted

ELD mandate specifics, ECM data retention periods, spoliation legal standards, MCS-90 endorsement
mechanics, broker liability doctrine — **verify each against a primary source before asserting it, or
write around it.** Do not state a regulatory fact from memory. Flag in your hand-off anything you
could not verify.

---

## Citation targets — need ≥4 sentence-initial "According to X"

Real, citable sources. **No figure is supplied here for quotation — pull the current published number
from the source itself and cite the edition/year.**

| Source | What it supports |
|---|---|
| FMCSA, *Large Truck and Bus Crash Facts* (latest edition) | Large-truck crash, injury, fatality counts |
| NHTSA | Occupant-fatality distribution in large-truck crashes |
| IIHS | Why occupants of the smaller vehicle bear the injury burden |
| Insurance Research Council | Represented vs. unrepresented claimant outcomes |
| Georgia DOT / South Carolina DPS | State-level commercial vehicle crash counts |

Format reminder: must **start the sentence** with capital `According to` + a capitalized proper-noun
source. `…and according to the CDC…` does not count.

**Firm figures are not third-party sources.** If you use Roden Law's own numbers, say plainly that they
are the firm's own reported figures. Never dress them as external attribution.

---

## Internal links — all 13 verified live (HTTP 200, final URL = requested) on 2026-08-06

Use **10–13**. The pillar up-link is mandatory.

| Path | Suggested anchor | Purpose |
|---|---|---|
| `/practice-areas/truck-accident-lawyers/` | truck accident lawyers | **Required up-link to pillar** |
| `/resources/georgia-truck-accident-settlement-value/` | what a Georgia truck accident case is worth | Routes *how much* intent away from this page |
| `/resources/south-carolina-truck-accident-settlement-value/` | what a South Carolina truck accident case is worth | SC counterpart |
| `/resources/south-carolina-statute-of-limitations/` | South Carolina's three-year deadline | Deadlines section |
| `/resources/south-carolina-comparative-negligence/` | South Carolina's 51% bar | Partial-fault FAQ |
| `/resources/south-carolina-um-uim-stacking/` | stacking UM and UIM coverage | Coverage-shortfall path |
| `/resources/south-carolina-personal-injury-faq/` | South Carolina personal injury FAQ | Depth |
| `/truck-accident-lawyers/savannah-ga/` | Savannah truck accident lawyers | GA office |
| `/truck-accident-lawyers/darien-ga/` | Darien truck accident lawyers | Dorminy's office — supports the byline |
| `/truck-accident-lawyers/charleston-sc/` | Charleston truck accident lawyers | SC office |
| `/truck-accident-lawyers/fatigued-trucker-accident/` | fatigued trucker accidents | Ties to hours-of-service logs |
| `/truck-accident-lawyers/18-wheeler-semi-truck-accident/` | 18-wheeler accidents | Sub-type |
| `/wrongful-death-lawyers/fatal-truck-accident/` | fatal truck accidents | Wrongful-death path |

**Do not invent any other internal URL.** If you want a link that isn't on this list, flag it in your
hand-off instead of guessing — the URL inventory contains stale duplicate-form practice-area paths that
will 301 or 404.

**Note on the SC skew:** Georgia has no statute-of-limitations or comparative-negligence resource page
(a known site gap). That is why the deep statute links all point to South Carolina. Do **not**
compensate by inventing a Georgia equivalent URL. Cite Georgia law inline with the statute number and
link to the Georgia settlement-value page instead.

---

## Cannibalization guard

The two settlement-value pages own **"how much is it worth."** This page owns **"how do I start."**

- Neither the H1 nor any H2 on this page may ask what a case is worth.
- When value comes up, answer in one sentence and link out to the right state's settlement-value page.
- Do not restate their severity bands or dollar figures.

There is also a legacy blog post at `/blog/average-personal-injury-settlement-amounts/`. Do not
reference or compete with it.

---

## Editorial rules specific to settlement content

From `docs/en-settlement-value-content-review-2026-08-03.md` — read it before drafting:

- Any settlement figure in prose must agree with every table on the same page.
- The firm's own statistics must never be presented as third-party attribution.
- *Nestlehutt* struck **O.C.G.A. § 51-13-1**, the **medical-malpractice** noneconomic damages cap only.
  Do not overstate its reach. Safest course on this page: don't invoke it at all.
- Never fabricate a statute, statistic, street, court, or case result.

---

## Hand-off report

When done, report: file written, word count, internal links used (path + anchor), statutes cited,
"According to" count, attorney attributed, and **everything you could not verify and therefore flagged
or omitted.**
