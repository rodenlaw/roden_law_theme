# Track C bounded test — one page, one hypothesis, one decision

**Started 2026-09-03. Re-measure on or after 2026-12-03.**

## Why this is a test and not a build

Plan §7 proposed a 25-entry glossary against ~126,600 impressions. The premise did
not survive the data (§7 is corrected in place):

- Two of the four term families **already have dedicated pages**, and the vein's
  best performer — `/blog/value-of-pain-and-suffering/`, **1,109 clicks** — was
  absent from the plan's own table. A query sweep that never checked a page list.
- Definitional queries convert **~40% below** the site's average at the same
  position band.
- The site holds **181** definitional impressions at position 1–3. Effectively none.

So the entire return rests on one untested assumption: **that glossary formatting
can move a definitional query from position 4 to position 2.** Track A died of an
assumption of exactly that shape. The mechanism here is different — structured
answer → snippet and AI-Overview eligibility, rather than word count → rank — which
earns it a test, not a build on spec.

## The position gradient this is betting on

Brand queries excluded, 13-month export:

| Position | Impressions | CTR |
|---|---:|---:|
| 1–3 | 7,541 | **6.127%** |
| 3–5 | 59,373 | 0.793% |
| 5–10 | 221,838 | 0.252% |
| 10–20 | 290,072 | 0.154% |
| 20+ | 313,120 | 0.093% |

Position 1–3 is worth **~8×** position 3–5. That is the prize.

**Caveat, stated up front:** the 1–3 band holds only 7,541 impressions across 135
long-tail queries. Its 6.127% is not measured on head terms, and no non-brand query
with ≥2,000 impressions sits at 1–3 anywhere on this site. The gradient is real; its
magnitude at head-term volume is an extrapolation.

## Baseline — the falsifiable part

Subject page: `/blog/compensatory-damages-vs-punitive-damages/` (post 1663).
Cluster: all 70 queries in `docs/gsc-2026-08-24/Queries.csv` matching
`compensator|punitive`.

| Metric | 2026-08-24 baseline |
|---|---:|
| Queries | 70 |
| Impressions | 127,662 |
| Clicks | 284 |
| CTR | 0.222% |
| **Impression-weighted position** | **9.09** |

Head terms, for a per-query read:

| Query | Impr | Clicks | Pos |
|---|---:|---:|---:|
| `compensatory` | 25,064 | 5 | 9.71 |
| `what are punitive damages` | 17,943 | 11 | 9.08 |
| `compensatory damages` | 10,708 | 25 | 14.23 |
| `compensatory vs punitive damages` | 9,942 | 44 | 4.21 |
| `what is punitive damages` | 6,878 | 4 | 8.92 |
| `punitive damages` | 6,539 | 13 | 19.34 |
| `punitive damages meaning` | 6,368 | 9 | 9.95 |

## Decision rule, fixed in advance

Re-measure the same 70-query cluster on a 13-month window ending on or after
**2026-12-03**, judged across a Google update boundary and never between them.

- **Weighted position improves materially and CTR rises** → build the remaining
  glossary terms, highest-impression first.
- **Position flat or worse** → the format does not move definitional rank on this
  domain. Do not build the glossary. Record it next to Track A and stop.
- **Position improves but CTR does not** → the page is being read on the SERP rather
  than clicked. That is an AI-citability outcome, not a traffic one, and it is a
  different decision — take it to the firm rather than resolving it here.

Writing the third branch down now, before any result, is the point. It is the branch
most easily rationalised after the fact.

## What changed

1. **`.ai-definition-block`, 53 words, ahead of the table of contents.** §9 rule 1 is
   "answer in the first 60 words"; the page previously opened with two paragraphs of
   narrative. The CSS for this block has shipped since the AI-SEO pass and **no
   published page was using it**, while the speakable spec already targeted the
   selector.
2. **`_roden_glossary_terms`** on the post, published as `DefinedTermSet` /
   `DefinedTerm` by the new `roden_schema_defined_term_set()`. Meta-driven and silent
   everywhere else, in the same shape as `roden_schema_faq_page()`.

The two are bundled deliberately. The decision at stake is "does glossary format
work", not "which half of it works"; isolating the halves would need two pages and
two quarters.

## What did not change, and why

§9 rules 5 and 6 are **not met on this page** and cannot be met from a script:

- **`_roden_last_reviewed` stays unset.** Setting it publishes `reviewedBy`, which
  asserts a named attorney checked this page on a date. None has.
  `inc/schema-helpers.php` argues this itself: *"asserting a review that may not have
  happened is not a trust signal worth manufacturing."*
- **The byline stays Eric Roden (3729), who is admitted in Georgia only.** This is a
  two-state page that states South Carolina law — including the § 15-32-530 rule
  corrected the same day. §9 rule 6 wants a GA-barred **and** an SC-barred co-byline.
  **Graeham C. Gillin (3732) is the only SC-admitted attorney on the site.**

Both are the open owner decision in plan §13. They also mean this test measures the
*format* lever alone, with the two strongest trust signals still switched off — so a
null result does not clear §9, it only clears formatting.

## Method note

An earlier version of this analysis inferred that `_roden_faqs` was stored as a JSON
string on this post and that `roden_schema_faq_page()` — which requires
`is_array()` — was therefore emitting no FAQPage schema on a page with 349,782
impressions. **That was wrong.** A census found all 728 FAQ-carrying published posts
store it as an array, this one included, and the live page emits FAQPage normally.
Recorded because the inference was reasonable and the census was cheap.
