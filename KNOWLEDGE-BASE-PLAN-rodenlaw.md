# Knowledge Base & Harvest Plan — rodenlaw.com

**Handoff document for Claude Code + content team.** Third in the sequence:
`SEO-PREEMPTION-PLAN-rodenlaw.md` cut the doorway layer, `STEINBERG-MODEL-PLAN-rodenlaw.md`
defined the architecture to grow into. This plan is the content engine that fills it.

**Prepared:** 2026-08-31 · **Evidence:** `docs/gsc-2026-08-24/` (13 months, 2025-07-23 →
2026-08-22), joined against `content/meta.json` at 1,065 posts.

---

## 1. What changed — the cull is done and the ratio is no longer the constraint

The doorway ratio went **29.2% → 19.0%** against Steinberg Principle 1's ≤25% ceiling.
Location pages alone are **4.7%**. All 175 surviving city×practice pages sit in the six
office markets, the defensible tier under Phase 1 rule 6.

So the governing question is no longer *"what else do we delete."* Nothing else needs
deleting. The question is **what the surviving pages become, and what gets built beside
them** — and the answer to both turns out to be mostly *rewriting what already exists*,
not commissioning new work.

---

## 2. The evidence — a format problem, not a place problem

Every surviving page joined against the GSC export, by tier:

| Tier | Pages | Impressions | Clicks | CTR |
|---|---:|---:|---:|---:|
| City×practice intersections (EN+ES) | 175 | 642,575 | **73** | **0.011%** |
| Sub-types (EN) | 207 | 455,457 | 230 | 0.050% |
| Office cities (EN) | 6 | 92,681 | 50 | 0.054% |
| Satellite towns | 43 | 45,725 | 91 | 0.199% |
| State hubs | 2 | 5,459 | 14 | 0.256% |
| **Resource pages** | 72 | 68,447 | **596** | **0.871%** |
| Blog | 487 | 3,519,576 | 16,642 | 0.473% |

**Resource pages convert roughly 75× better per impression than city×practice pages.**

### It is not a ranking problem

The intersections are visible and ignored:

| Page | Position | Impressions | Clicks |
|---|---:|---:|---:|
| `/truck-accident-lawyers/charleston-sc/` | 13.7 | 25,361 | **0** |
| `/pedestrian-accident-lawyers/myrtle-beach-sc/` | 10.8 | 7,617 | **0** |
| `/bicycle-accident-lawyers/myrtle-beach-sc/` | 10.8 | 6,071 | **0** |
| `/workers-compensation-lawyers/savannah-ga/` | 10.2 | 3,999 | **0** |

Page-one placement producing zero clicks across thirteen months is not an optimisation
gap. The local-commercial SERP is map pack plus paid; an organic lawyer page below the
fold is furniture.

### The intent split proves it

Splitting every place-containing query in the top-1,000 by whether it contains a
lawyer word:

| Query type | Queries | Impressions | Clicks | CTR |
|---|---:|---:|---:|---:|
| Place + "lawyer / attorney / near me" | 81 | 150,071 | 195 | 0.130% |
| Place, **no** lawyer word | 95 | 44,536 | **441** | **0.990%** |

**Eight times the click-through on a third of the impressions.** People in these markets
search for the rule, the road and the risk — not for counsel.

### What already works on this domain

Classifying every EN blog and resource page that has served impressions, by title shape:

| Title pattern | Pages | Impressions | Clicks | CTR | Clicks/page | Impr/page |
|---|---:|---:|---:|---:|---:|---:|
| **Two-state** ("…in Georgia or South Carolina") | 57 | 1,436,708 | **7,750** | 0.539% | **136.0** | 25,205 |
| Generic | 208 | 1,426,914 | 6,225 | 0.436% | 29.9 | 6,860 |
| Single-state | 64 | 259,146 | 1,223 | 0.472% | 19.1 | 4,049 |
| City-named | 177 | 464,380 | 2,026 | 0.436% | 11.4 | 2,624 |

**Read this carefully — the CTR edge is modest (1.24×), the productivity gap is not
(12×).** Two-state pages do not mainly convert better; they *attract ten times the
impressions per page* because they answer a question two states' worth of people ask.
The title pattern is a symptom of topic selection, not a trick. Choose two-state topics
and the traffic follows; retitling a narrow topic will not manufacture it.

The site's four best non-brand pages are all two-state rule explainers:

| Page | Impr | Clicks | Pos |
|---|---:|---:|---:|
| `/blog/can-an-insurance-company-go-against-a-police-report/` | 142,999 | **1,669** | 7.9 |
| `/blog/value-of-pain-and-suffering/` | 113,967 | **1,109** | 22.1 |
| `/blog/compensatory-damages-vs-punitive-damages/` | 349,782 | **857** | 9.1 |
| `/blog/are-red-light-runners-always-liable-if-they-crash/` | 43,047 | **770** | 10.5 |

---

## 3. The principle

> **Rank the answer, not the offer.** Where a query asks what the law is, what a road is
> like, or what a word means, publish the answer as a citable two-state reference.
> Reserve the commercial page for commercial intent, and let the reference carry the
> internal link to it.

Structural bonus: **every knowledge-base page lowers the doorway ratio**, because it grows
the non-location denominator. The two goals do not trade off.

---

## 4. A correction that shapes this plan

The first pass at this document asserted two content gaps that **do not exist**. Both
were produced by sweeping `content/meta.json` on **title and excerpt only**:

- *"Zero pages mention super speeder."* → `/blog/georgia-super-speeder-law/` exists and
  has **63,120 impressions**. Its title is "What Are Excessive Speeding Laws?", so a
  title sweep could not see it.
- *"The Georgia car-seat twin does not exist."* → `/blog/georgia-car-seat-law-overview/`
  exists with 9,244 impressions.

This is the failure `CLAUDE.md` already documents — *"a sweep that cannot see a field
reports zero, not unknown"* — recurring in a new field. **Sweep the slug, the title, the
excerpt and the body before declaring any content gap.** Every gap claimed in §6 below
was re-verified across slug + title + excerpt + GSC.

The correction improves the plan: the knowledge base is **substantially already written**.
The work is upgrading it, not commissioning it.

---

## 5. Track A — harvest the intersections

Do **not** delete these. They hold 642,575 impressions of validated demand and the URLs
carry ranking history. Rewrite the high-impression ones **in place** as answer-first
two-state references, keeping the URL.

Value is concentrated, so this is 25 pieces of work, not 175:

- Top 10 carry **357,194** impressions (57%)
- Top 25 carry **487,448** impressions (77%)
- Top 40 carry **552,024** impressions (87%)

### The harvest list — top 25 EN intersections

| # | Impr | Clicks | Pos | URL |
|---:|---:|---:|---:|---|
| 1 | 85,485 | 6 | 19.8 | `/car-accident-lawyers/charleston-sc/` |
| 2 | 72,236 | 3 | 20.1 | `/car-accident-lawyers/savannah-ga/` |
| 3 | 45,260 | 5 | 18.9 | `/car-accident-lawyers/columbia-sc/` |
| 4 | 30,479 | 6 | 16.3 | `/medical-malpractice-lawyers/savannah-ga/` |
| 5 | 28,168 | 2 | 19.2 | `/workers-compensation-lawyers/charleston-sc/` |
| 6 | 25,361 | 0 | 13.7 | `/truck-accident-lawyers/charleston-sc/` |
| 7 | 18,622 | 0 | 16.0 | `/motorcycle-accident-lawyers/charleston-sc/` |
| 8 | 18,428 | 0 | 15.4 | `/wrongful-death-lawyers/charleston-sc/` |
| 9 | 17,447 | 3 | 24.9 | `/medical-malpractice-lawyers/charleston-sc/` |
| 10 | 15,708 | 2 | 54.1 | `/car-accident-lawyers/darien-ga/` |
| 11 | 14,790 | 1 | 17.5 | `/slip-and-fall-lawyers/savannah-ga/` |
| 12 | 13,549 | 1 | 18.7 | `/dog-bite-lawyers/charleston-sc/` |
| 13 | 10,782 | 3 | 23.6 | `/product-liability-lawyers/columbia-sc/` |
| 14 | 9,266 | 0 | 21.0 | `/workers-compensation-lawyers/columbia-sc/` |
| 15 | 9,123 | 1 | 25.1 | `/motorcycle-accident-lawyers/columbia-sc/` |
| 16 | 8,974 | 0 | 16.9 | `/pedestrian-accident-lawyers/charleston-sc/` |
| 17 | 8,849 | 4 | 16.6 | `/workers-compensation-lawyers/myrtle-beach-sc/` |
| 18 | 8,188 | 1 | 21.1 | `/boating-accident-lawyers/columbia-sc/` |
| 19 | 7,617 | 0 | 10.8 | `/pedestrian-accident-lawyers/myrtle-beach-sc/` |
| 20 | 7,553 | 0 | 17.1 | `/slip-and-fall-lawyers/charleston-sc/` |
| 21 | 7,314 | 1 | 22.0 | `/truck-accident-lawyers/columbia-sc/` |
| 22 | 6,768 | 1 | 39.9 | `/pedestrian-accident-lawyers/columbia-sc/` |
| 23 | 6,071 | 0 | 10.8 | `/bicycle-accident-lawyers/myrtle-beach-sc/` |
| 24 | 5,721 | 1 | 16.1 | `/dog-bite-lawyers/savannah-ga/` |
| 25 | 5,689 | 2 | 16.7 | `/dog-bite-lawyers/columbia-sc/` |

### The rewrite pattern

Each harvested page keeps its URL, title tag and commercial CTA, and gains — above the
fold — the material that earns the click:

1. **Answer-first opener** (≤ 60 words) naming the controlling statute for that state.
2. **The local specific**: county court and venue, filing deadline with citation, the
   fault rule that applies, local hazard data where a study exists.
3. **A two-state contrast line** where GA and SC differ.
4. **One table** of extractable facts (deadline, fault rule, cap, notice requirement).
5. **Links out** to the relevant Track B reference and Track D study.

**Rule:** if two harvested pages read identically with the city swapped, neither is done.

### Tiers that are NOT harvested

- **The 43 satellite towns** — best-performing location tier (position 12.1, 0.199% CTR,
  every one earns clicks). Leave alone.
- **The 6 office cities + 2 state hubs** — legitimate but weak (position 31.8). Separate
  work: NAP matching GBP, county courts, market-specific results. Not this track.
- **The 39 `/es/` intersections** (11,009 impr, 3 clicks) — harvest only after the
  English twin ships, per the mirror rule.

---

## 6. Track B — upgrade the reference library that already exists

**This cluster is mostly built.** 57 two-state pages already earn 7,750 clicks — the
site's most productive cohort. Five more were seeded 2026-08-25/26 and have **zero
impressions**, meaning they are not yet indexed and **must not be judged yet**:

`/resources/georgia-vs-south-carolina-comparative-negligence/` ·
`/resources/georgia-vs-south-carolina-filing-deadlines/` ·
`/resources/georgia-vs-south-carolina-workers-compensation/` ·
`/resources/i-26-i-95-corridor-report/` · `/resources/south-carolina-liquor-liability-2026/`

The work is therefore **B1 (upgrade), then B2 (convert format), then B3 (the small real
gaps)** — in that order of value.

### B1 — The upgrade pool: 75 pages, 1,388,080 impressions, ranking below position 15

These are written, indexed, earning impressions, and losing. Highest value on the site:

| Impr | Clicks | Pos | Page | Problem |
|---:|---:|---:|---|---|
| 130,738 | 266 | 16.5 | `/blog/fault-vs-no-fault-car-insurance/` | Generic title; `is georgia a no fault state` ranks 4.0 separately with 7,550 impr |
| 113,967 | 1,109 | 22.1 | `/blog/value-of-pain-and-suffering/` | Already two-state; 1,109 clicks **at position 22** |
| 106,206 | 174 | 22.1 | `/blog/calculating-compensation-for-whiplash-injuries/` | Two-state, buried |
| 63,120 | 58 | 29.6 | `/blog/georgia-super-speeder-law/` | Perfect slug, title "What Are Excessive Speeding Laws?" |
| 57,506 | 125 | 34.6 | `/blog/supporting-a-whiplash-claim/` | Charleston-scoped a two-state topic |
| 43,957 | 53 | 26.4 | `/blog/diminished-value-claims-after-car-accident/` | No state framing at all |
| 38,142 | 211 | 18.3 | `/blog/using-uninsured-underinsured-motorist-coverage-in-georgia/` | Title says GA, body covers both |
| 30,328 | 137 | 16.4 | `/blog/how-car-insurers-use-private-investigators/` | No state framing |
| 26,748 | 239 | 19.6 | `/blog/burn-injury-workers-compensation/` | `burn injury attorney` = 14,593 impr at 24.7 |
| 24,012 | 161 | 15.3 | `/blog/negligence-vs-gross-negligence/` | Two-state, marginal position |
| 23,946 | 57 | 23.2 | `/blog/does-workers-compensation-cover-prescriptions/` | Two-state, buried |
| 20,739 | 10 | 38.7 | `/blog/four-common-construction-accidents/` | Listicle, no jurisdiction |
| 20,485 | 18 | 36.4 | `/blog/what-to-do-when-you-are-in-a-car-accident/` | Two-state, position 36 |
| 20,456 | 28 | 29.1 | `/blog/demand-letters-in-personal-injury-cases/` | No state framing |

Treatment per page: answer-first opener, statute cited inline, two-state contrast table,
`lastReviewed`/`reviewedBy`, retitle only where the topic genuinely spans both states.
**Do not retitle a narrow topic into a two-state title** — §2 shows the pattern reflects
topic scope, not a formatting trick.

### B2 — Finish the pages that were never finished ✅ *done 2026-08-31*

> **This section's original premise was wrong and is corrected here.** It framed the
> work as a blog→resource *format* conversion, on the strength of a 23× click gap
> between `/resources/south-carolina-car-seat-laws/` (138 clicks, pos 8.5) and
> `/blog/georgia-car-seat-law-overview/` (6 clicks, pos 26.9).
>
> Format was never the variable. **Both pages use the default template**, and
> `single.php` already renders key takeaways and FAQs — the only things the
> `resource` type adds are the see-also block and the sidebar. The real difference:
> the SC page was finished (1,154 words, 6 question-shaped H2s, statute cited, full
> `_roden_*` meta) and the GA page was a 2025 stub (678 words, **zero H2s**, no
> statute, no meta at all).

**So the treatment is: upgrade in place, keep the URL, no 301.** Applied to the
Georgia page on 2026-08-31 — 678 → 1,064 words, 0 → 7 H2s, statutes cited, and the
meta it never had. It also carried a **false statement of law** (see §6.1).

Apply the same test to other candidates before assuming format is the problem:
open the page and count H2s, statutes and `_roden_*` keys. A page missing all
three is unfinished, not mis-typed.

### 6.1 — The car-seat evidence rule, found while verifying Step 2

Checking Georgia's statute surfaced a false statement of law on the **South
Carolina** page — the site's best-performing resource:

| | Statute | Rule |
|---|---|---|
| South Carolina | § 56-5-6460 | Not negligence per se, not contributory negligence, **and not admissible as evidence in any civil action** |
| Georgia | § 40-8-76(c) | "shall not constitute negligence per se nor contributory negligence per se" — **no admissibility bar** |

The SC page said an insurer "may try to raise that as comparative fault," on
**three of the four surfaces** — body, `_roden_faqs` (also published as FAQPage
structured data) and `_roden_key_takeaways`. Corrected 2026-08-31; class re-sweep
returned 0 survivals.

**The lesson for the rest of this plan:** every page upgraded under Tracks A–C
should have its legal claims verified against the statute, not carried forward.
Two of the three legal statements on the Georgia stub were wrong or absent. Assume
the same rate elsewhere, and note that a *sibling* page is the most likely place
for a contradicting error to be hiding.

### B3 — The genuinely missing pages (verified across slug + title + excerpt)

| Gap | Evidence | Status |
|---|---|---|
| **SC golf cart law** (permits, road eligibility, age, Myrtle Beach + N. Myrtle Beach municipal rules) | 5 queries, 764 impr, pos 6.6–11.7 | **Real gap.** 19 golf-cart pages exist; every one is an accident/lawyer page. 14 practice pages earn 11 clicks combined |
| **Moped law (GA + SC)** | — | **Real gap.** Zero pages |
| **Helmet law (GA + SC)** | — | **Real gap.** One incidental mention |

Everything else previously proposed as a gap is served: seizure/epilepsy driving
(`/blog/liability-for-epilepsy-related-car-accidents/`, 641 clicks), four-way stops
(200 clicks), red-light liability (770 clicks), police reports (1,669 clicks),
diminished value, u-turns, headphones.

**Track B is ~14 upgrades + ~4 conversions + 3 new pages — not the 20 new builds first
proposed.**

---

## 7. Track C — the damages and injury glossary

The largest under-served vein, and the format is proven:
`/blog/compensatory-damages-vs-punitive-damages/` earns **857 clicks on 349,782
impressions.**

| Query | Impr | Clicks | Pos |
|---|---:|---:|---:|
| `blunt force trauma` | 27,171 | 12 | 12.2 |
| `compensatory` | 25,064 | 5 | 9.7 |
| `what are punitive damages` | 17,943 | 11 | 9.1 |
| `compensatory damages` | 10,708 | 25 | 14.2 |
| `blunt trauma` | 10,455 | 5 | 13.8 |
| `compensatory vs punitive damages` | 9,942 | 44 | 4.2 |
| `what is punitive damages` | 6,878 | 4 | 8.9 |
| `punitive damages` | 6,539 | 13 | 19.3 |
| `punitive damages meaning` | 6,368 | 9 | 9.9 |
| `pain and suffering` | 3,132 | 7 | 29.3 |
| `how is pain and suffering calculated` | 2,427 | 5 | 27.0 |

**~126,600 impressions → ~140 clicks.** The site ranks top-15 on nearly all of it and
converts almost none, because a definitional query lands on a practice page or a long
narrative post instead of a definition.

Build a structured glossary at `/resources/glossary/`: one entry per term — short
definition, GA and SC treatment, statute, worked example. `blunt force trauma` and
`blunt trauma` (37,626 impressions combined) are **medical** entries needing a medical
citation, not legal ones.

---

## 8. Track D — place-danger research

The place-based demand this site earns is about **danger, not counsel**:

| Query | Impr | Clicks | Pos |
|---|---:|---:|---:|
| `why is myrtle beach so dangerous` | 13,785 | 18 | 9.3 |
| `north charleston crime rate` | 495 | 4 | 8.0 |
| `why is columbia, sc so dangerous` | 256 | 1 | 7.9 |

Format already proven on-site: `/blog/myrtle-beach-dangerous-roads-intersections/`
(19,308 impr / 60 clicks), `/blog/dangerous-savannah-intersections/` (3,961 / 34),
`/blog/columbia-dangerous-intersections-roads/` (3,759 / 33).

Study #1 is published with its machinery in `research/`. Continue at one per quarter:

| # | Study | Source | Status |
|---:|---|---|---|
| 1 | I-26 / I-95 Corridor Report | FARS, SCDPS, GDOT | ✅ published, awaiting index |
| 2 | Why Myrtle Beach Is Dangerous — the data | SCDPS, FBI UCR | **pulled forward** — 13,785 impr already |
| 3 | Port Worker Injury Report: Savannah & Charleston | OSHA, USACE, GPA/SCPA | queued |
| 4 | GA vs SC: The Border Crash Gap | both states + statutes | queued |
| 5 | Golf Cart & LSV Injury Study | SCDPS, municipal citations | pairs with B3 |

Study #2 is pulled forward: demand is measured, already ranks 9.3 on a blog post, and it
converts the largest place-based query on the domain into a linkable asset.

---

## 9. The citability standard

Every page produced under Tracks B, C and D carries all seven:

1. **Answer in the first 60 words**, before any qualification.
2. **Statute cited inline** — e.g. Georgia's Super Speeder law is
   **O.C.G.A. § 40-6-189** (verified 2026-08-31) — never "state law requires."
3. **Facts in a table**, not prose. Extractable beats readable here.
4. **Primary sources named with methodology** — which FARS year, which agency table.
5. **`lastReviewed` / `reviewedBy` in schema** — plumbing shipped in #85.
6. **A named attorney with bar credentials**; GA-barred and SC-barred co-bylines on
   two-state pages.
7. **A stated review cadence.**

### Accuracy discipline is not optional here

Per `CLAUDE.md` a claim lives in **four** places: `post_content`, `_roden_faqs` (which
also renders FAQPage structured data), `_roden_key_takeaways`, and `post_excerpt` (which
`roden_schema_article()` publishes as the Article description). This plan multiplies the
number of pages asserting statutes. Every claim must be swept across all four surfaces
and `content/meta.json` regenerated and committed.

**Sweep for the claim *class*, never the string** — and per §4, sweep slug + title +
excerpt + body before declaring anything absent.

---

## 10. Guardrails

1. **No new `location` posts.** Enforced in `inc/content-guardrails.php` — sub-city banned
   permanently, city-tier frozen behind `RODEN_LOCATION_FREEZE`.
2. **No new city×practice `practice_area` permutations.** ⚠️ **Currently unenforced** —
   the guard tests `'location' !== $data['post_type']` only, so
   `/{practice}-lawyers/{city}-{st}/` can still be published. Extend the guard.
3. **Track A rewrites in place.** No new URLs, no 301s, no deletions.
4. **Track B/C pages are state- or term-scoped, never city-scoped.** A rule page titled
   for a city is a doorway page wearing a hat.
5. **Do not retitle narrow topics into two-state titles.** §2 shows the pattern reflects
   topic scope; faking it manufactures nothing.
6. **Nothing ships without §9 met in full.** Seven of seven.

---

## 11. Sequencing

| Phase | Work | Why this order |
|---|---|---|
| **1** | B1 upgrades, top 6 by impressions (538,000 impr) | Written, indexed, ranking 16–35. Cheapest possible wins |
| **2** | B2 format conversions (GA car seat → resource, + adult booster) | 23× proven delta, one template |
| **3** | Track A harvest, top 10 (357,194 impr / 57%) | Largest block of wasted visibility |
| **4** | Track C glossary, damages terms first | ~126K impressions; format proven at 857 clicks |
| **5** | B1 remainder · Track A harvest 11–25 · B3 three new pages | Completes 77% of harvest value |
| **6** | Study #2 (Myrtle Beach) · Study #3 (Port Worker) | Linkable assets, quarterly |
| **ongoing** | `/es/` mirrors after English twins ship | |

Re-measure the five zero-impression seeded resources at Phase 3 — they will have indexed
by then and their performance decides how much more resource-format work is justified.

---

## 12. Measurement

Append to `RECOVERY-LOG.md` at each phase. Baselines from the 13-month export:

| Metric | Baseline | Target |
|---|---:|---|
| Intersection CTR | 0.011% | ≥ 0.30% on harvested pages |
| Resource-tier clicks | 596 | 1,500 |
| Upgrade-pool clicks (75 pages) | 4,616 | 9,000 |
| Two-state page count | 57 | 80 |
| Glossary entries live | 0 | 25 |
| Doorway ratio | 19.0% | ≤ 19.0% (falls as denominator grows) |
| Editorial referring domains | 491 | +10–15 / quarter |
| Position 1–3 count | 68 | holds through next core update |

Judge across Google update boundaries only, never between them.

---

## 13. Owner decisions

- ⬜ **Approve Track A rewrite-in-place** over deletion or 301 consolidation.
- ⬜ **Attorney assignment for two-state bylines** — §9 rule 6 needs a GA-barred and an
  SC-barred reviewer named on every two-state page.
- ⬜ **Extend the guardrail to `practice_area`** (§10 rule 2) — currently a live hole.
- ⬜ **Glossary URL scheme** — `/resources/glossary/{term}/` vs. a single hub page.
