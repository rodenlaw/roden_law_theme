# Plan — closing the Georgia resource gap

**Date:** 2026-08-07
**Status:** awaiting scope decision

## The gap

South Carolina has a statute/procedure resource layer. Georgia has none.

| | South Carolina | Georgia |
|---|---|---|
| Statute of limitations | `/resources/south-carolina-statute-of-limitations/` | — |
| Comparative negligence | `/resources/south-carolina-comparative-negligence/` | — |
| Personal injury FAQ | `/resources/south-carolina-personal-injury-faq/` | — |
| UM/UIM stacking | `/resources/south-carolina-um-uim-stacking/` | — |
| County court process | `/resources/personal-injury-claim-charleston-county-court/` | — |
| Settlement value | 6 pages | 2 pages |

The consequence is structural: every deep statute link on a `both`-jurisdiction page
points to South Carolina, because there is nothing in Georgia to point at. The new
settlement-process page has exactly this shape — four SC statute links, zero GA.

Georgia is also the firm's home state (Savannah HQ, Darien second office).

## The control group failed — read this before building anything

The two SC pages this plan would twin **earn essentially nothing**:

| Page | Keywords | Best position | Traffic |
|---|---|---|---|
| `south-carolina-statute-of-limitations` | 5 | 38 | **0** |
| `south-carolina-comparative-negligence` | 1 | 45 | **0** |

They are also thin by the site's own standard — 1,397 and 1,065 words, one table each,
4–6 internal links, 5 FAQs, and **no `_roden_last_reviewed` on either**.

So the failure is confounded: we cannot tell whether the topic doesn't earn or whether
these particular pages were too thin to compete. **A Georgia page that is merely a state
swap of these should be expected to earn zero as well.** Anything built here has to be
materially better — the settlement-process treatment, not the SC treatment.

## What the Georgia demand actually looks like

Semrush, US database, 2026-08-07:

**Statute of limitations cluster — ~1,790/mo, high commercial intent**

| Keyword | Volume | KD | CPC |
|---|---|---|---|
| statute of limitations georgia | 1,300 | 16 | $2.24 |
| georgia statute of limitations personal injury | 260 | 15 | **$25.31** |
| georgia personal injury statute of limitations | 140 | 19 | **$25.31** |
| ocga 9-3-33 | 40 | — | — |
| georgia ante litem notice | 30 | — | — |
| georgia statute of limitations car accident | 20 | — | — |

**Tort reform / SB 68 cluster — ~2,080/mo, informational intent**

| Keyword | Volume | KD | CPC |
|---|---|---|---|
| georgia tort reform | 1,300 | 17 | $0 |
| sb 68 georgia | 390 | 22 | $0 |
| georgia tort reform 2025 | 320 | 11 | $0 |
| georgia sb 68 | 70 | 27 | $0 |

**Comparative negligence cluster — ~90/mo**

| Keyword | Volume | KD |
|---|---|---|
| georgia comparative negligence | 50 | 24 |
| comparative negligence georgia | 40 | 12 |

For contrast, the SC terms the existing pages target run 40–170/mo. Georgia demand is
roughly an order of magnitude larger.

## The SERP is winnable

Top 12 for "georgia statute of limitations personal injury": bbga.com, Justia,
wpmhlegal, FindLaw, franklinlawllc, barneslawgroup, farahandfarah, schollelaw,
smithbeerlaw, thechampionfirm, kermanillp, jttlaw.

Small-to-mid Georgia firms plus two legal directories. No national juggernaut. Almost all
of them are **blog posts**, not purpose-built resource pages. KD 15–19 against a domain
with Roden's authority is a real opening.

## Recommendation

**Build one page now: `/resources/georgia-statute-of-limitations/`**

- Highest commercial value on the board — $25.31 CPC means these searchers convert
- Evergreen, unlike the tort-reform cluster
- Directly fills the structural link gap
- Low difficulty against beatable competition

**Do not build a standalone `/resources/georgia-comparative-negligence/`.** At ~90/mo it
does not carry a page, and its SC twin is the single worst performer on the site. Cover
Georgia's 50% bar as a section inside whichever page ships, and link to the anchor.

**Treat Georgia tort reform / SB 68 as a separate, later decision.** Bigger raw volume
(~2,080/mo) but zero CPC and decaying interest. Its real value is that it *absorbs* the
comparative-negligence topic — SB 68 clarified the 50% bar — and most competitor content
on that SERP predates April 2025 and is now stale.

## Page spec — Georgia statute of limitations

| Field | Value |
|---|---|
| URL | `/resources/georgia-statute-of-limitations/` |
| Type | `resource` |
| Title | Georgia Statute of Limitations for Personal Injury Claims |
| H1 | How Long Do I Have to File a Personal Injury Claim in Georgia? |
| Jurisdiction | `georgia-only` — must contain **zero** `S.C. Code §` citations |
| Byline | Eric Roden (#3729) or Tyler Love (#3730) — both unambiguously GA-admitted |
| Word target | 2,000–2,400 (the SC twin's 1,397 is part of why it lost) |
| Primary keyword | `georgia statute of limitations personal injury` |

### Outline — H2s phrased as questions, matching the SC model's best feature

1. How long do I have to file a personal injury lawsuit in Georgia? — 2 years, O.C.G.A. § 9-3-33
2. Deadlines by claim type — **the required comparison table**
3. When does the clock start? The discovery rule
4. What if my claim is against a city, county, or the state? — **ante litem notice**
5. What if the injured person is a minor? — tolling
6. Does a criminal case against the driver change my deadline? — tolling during prosecution
7. What if I was partly at fault? — the 50% bar, absorbing the comparative-negligence topic
8. What happens if I miss the deadline?
9. Talk to a Georgia injury attorney before your deadline runs

### The deadlines table — every cell needs verification

| Claim type | Deadline | Statute |
|---|---|---|
| Personal injury | 2 years | O.C.G.A. § 9-3-33 |
| Wrongful death | 2 years | verify — plus tolling during estate administration |
| Property damage | 4 years | verify — § 9-3-30 / § 9-3-31 |
| Medical malpractice | 2 years + 5-year repose | verify — § 9-3-71 |
| **Workers' compensation** | **1 year** | **O.C.G.A. § 34-9-82** — 30-day notice |
| Claim vs. city | ante litem 6 months | verify — § 36-33-5 |
| Claim vs. county | ante litem 12 months | verify — § 36-11-1 |
| Claim vs. state | ante litem 12 months | Georgia Tort Claims Act, verify — § 50-21-26 |
| Minors | tolled to age 18 | verify — § 9-3-90 |

The **workers' comp row is the highest-value cell on the page**. The 1-year deadline under
§ 34-9-82 has already caused a live error on this site — 13 pages told Georgia workers they
had 2 years. Competitor pages routinely omit it. Getting it right is a genuine differentiator.

The **ante litem section is the second**. Six months against a city is the trap that actually
destroys Georgia claims, and it is largely absent from the blog posts currently ranking.

### Non-negotiable verification rule

Georgia enacted **SB 68 on 2025-04-21** — sweeping tort reform touching comparative
negligence, apportionment, seatbelt-evidence admissibility, premises liability and phantom
damages, most of it **retroactive**. Nothing about current Georgia law may be asserted from
memory or copied from a competitor page.

Every statute number and every deadline in the table must be verified against primary
source (Georgia General Assembly or Justia code text) at drafting time, and anything that
cannot be verified must be flagged and omitted rather than guessed.

This is also the opportunity: most of the ranking competitors published before April 2025.

### Internal links (8–12)

Verify each is live before use. Candidates: the truck settlement-process page, both GA
settlement-value resources, `/practice-areas/personal-injury-lawyers/`,
`/practice-areas/car-accident-lawyers/`, `/practice-areas/truck-accident-lawyers/`,
`/practice-areas/workers-compensation-lawyers/`, `/practice-areas/medical-malpractice-lawyers/`,
`/practice-areas/wrongful-death-lawyers/`, `/truck-accident-lawyers/savannah-ga/`,
`/truck-accident-lawyers/darien-ga/`, `/locations/georgia/`.

### Reciprocal wiring

`_roden_see_also` renders on `single-resource.php` and `template-subtype.php` only. Add an
entry on both GA settlement-value resources and on the truck settlement-process page. The
pillars need an inline `_roden_why_hire` link instead — see
`bin/en-link-pillar-to-settlement-process.php` for the working pattern.

## Separate finding — worth its own pass

SB 68 applies **retroactively**. Roden Law has live pages citing O.C.G.A. § 51-12-33 and
describing Georgia comparative fault that were written before April 2025. Those should be
audited against SB 68 rather than assumed correct. This is a content-accuracy issue
independent of whether any new page gets built.

## Build sequence

1. Verify every statute in the deadlines table against primary source; flag what fails
2. Write the brief from this plan
3. Draft via `roden-content-writer` (jurisdiction `georgia-only`)
4. Generate featured image
5. Seed via a `bin/` script modeled on `bin/en-seed-truck-settlement-process.php` —
   reuse its two guards, and fix the attachment lookup to key on `_wp_attached_file`
6. Verify rendered page, wire reciprocals, regenerate `content/meta.json`
