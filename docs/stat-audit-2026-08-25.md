# Statistics audit — 2026-08-25

Five numeric claims repeat verbatim across **12 published pages**. Two are
contradicted by primary sources. Three could not be verified from any public
source reachable during the audit. All five are removed by
`bin/apply-stat-remediation.php`; the before/after and a line-by-line removal log
are in `docs/backups/stat-remediation-2026-08-25.json`.

Found while gathering source material for the I-26/I-95 Corridor Report. The
study's entire value is being citable, and it cannot credibly cite FARS while
eleven sibling pages carry numbers that fall over when checked.

## The claims

### 1. "South Carolina recorded 3,167 large truck crashes in 2024" — 5 pages
**Removed. Not reproducible, and the underlying figure is not stable.**

Three sources, three different numbers for the same nominal quantity:

| Source | CY2024 SC large-truck crashes |
|---|---:|
| The site's pages | 3,167 |
| FMCSA MCMIS snapshot dated 2025-09-26 | 3,342 |
| FMCSA A&I portal, queried 2026-08-25 | 1,107 *(flagged incomplete)* |

FMCSA crash counts come from MCMIS, which is a **rolling snapshot** — states
keep reporting, so the same query returns different totals over time. That makes
this a structural problem rather than a typo: *any* bare figure without a source
**and a snapshot date** is indefensible, whichever number it happens to be.

A caution for whoever revisits this. A general web search returned "According to
the most recent data from FMCSA, South Carolina recorded 3,167 large truck
crashes in 2024" — phrasing almost identical to the site's own copy. That is very
likely the search engine paraphrasing these pages, or their SEO siblings, back at
the reader. **Circular sourcing is how a number survives four years and twelve
pages.** Confirm against the agency's own portal, never against a search summary.

### 2. "23% increase in fatal truck accidents" — 3 pages
**Removed. Contradicted in direction by every source checked.**

| Source | SC fatal large-truck crashes |
|---|---|
| FMCSA (via 2025-09-26 snapshot) | 122 (2023) → **74** (2024) — a fall |
| FMCSA A&I, queried 2026-08-25 | 97 (2023) → 28 (2024, incomplete) — a fall |
| FARS 2020–2024, own analysis | 113, 131, 120, 111, 126 — no +23% in any year pair |

The largest year-on-year rise anywhere in the FARS series is **+15.9%**
(2020→2021). Nothing produces 23%, and the most recent movement is downward.

### 3. "354 collisions" at the I-26/I-526 interchange over five years — 5 pages
**Removed. Unverified.** All-severity interchange counts are not in FARS, which
is fatal-only. No SCDPS publication reachable during the audit reports it. One
page attributes it to "SCDPS collision reports" without naming a publication,
table or year range.

### 4. "62 injuries" at the Rivers Avenue/I-526 interchange — 2 pages
**Removed. Unverified.** Same class as #3.

### 5. "More than 2,500 truck-related crashes in Charleston County, 2023" — 4 pages
**Removed. Unverified.** Attributed to "Charleston County collision data" with no
retrievable source.

## What was left alone

The concrete, dated incidents on these pages stay — a tractor-trailer striking
the I-526 overhead sign in February 2026, a concrete truck leaving the I-26
overpass near Dorchester Road, a cement truck overturning on Rivers Avenue in
March 2025. Those are checkable events, not aggregate statistics, and removing
them would strip the pages of the local specificity that makes them worth
keeping. **The problem was never that these pages cite facts; it is that five of
those facts were not facts.**

## Needs an editorial decision — not fixed here

`/blog/ashley-phosphate-i-26-south-carolinas-deadliest-intersection/` (post 4624).
Three uncited claims were removed from its body, including *"#1 most dangerous
intersection in South Carolina (SCDPS collision reports)"*. **The headline still
asserts the ranking.**

Removing the supporting statistics while leaving the claim in the title is worse
than either fixing both or neither: the assertion survives with its evidence
stripped out. Retitling a published post is a content decision, so it is flagged
rather than taken. Suggested: *"Ashley Phosphate Road and I-26: What Makes This
North Charleston Interchange Dangerous"* — which keeps the subject and the search
intent while dropping a superlative nobody can source. The slug is unaffected
either way, so there is no redirect implication.

## The audit was scoped too narrowly — a sitewide pass is still needed

The five claims above were found by accident, in source material harvested from
the *removed* corridor pages. Nothing about that method makes them the only ones,
and the post-fix sweep proved it: the string `#1 most dangerous intersection`
still matched one page — `/resources/abercorn-street-truck-accidents-savannah/`,
a **keeper** — carrying *"the #1 most dangerous intersection in the City of
Savannah"* and *"1 in 4 crashes at this intersection results in serious injury or
fatality."*

A pattern scan across all published posts then found roughly **30 distinct pages**
carrying claims of the same three shapes:

| Shape | Published pages | Examples |
|---|---:|---|
| Superlative ranking | 16 | "#1 most dangerous", "deadliest intersection", "most dangerous road in" |
| Ratio claim | 6 | "1 in 4 crashes", "% of fatal" |
| Aggregate count | 12 | "N crashes in 20XX", "N collisions per year" |

**These were deliberately not touched.** The five claims above were removed
because each had been individually traced and found false or unverifiable. The
~30 are only *shaped* like those claims — some will be properly sourced, some
will trace to real publications, and stripping them wholesale would delete
legitimate content to fix a problem that has not been shown to exist on each one.

That is a per-claim assessment job, not a pattern sweep, and it should be run as
its own pass. `/resources/abercorn-street-truck-accidents-savannah/` is the
obvious place to start: it is a page the GSC evidence says to keep, and it makes
a ranking claim and a serious-injury ratio claim in consecutive sentences.

## Method

Claims were located with a `post_content LIKE` sweep across all published,
non-revision posts, then extracted with surrounding markup and edited offline so
the diff could be reviewed before anything was written. Removals operate on whole
`<li>` elements and whole sentences inside `<p>`, never on fragments. Tag balance
was verified before and after on every page (`p`, `li`, `ul`, `h2`, `h3`,
`strong`, `a`, `table`, `div`) and no `href` was lost.

`post_modified` is deliberately not stamped. `_roden_last_refreshed` is set
instead — the field `inc/template-tags.php` documents as "the content was
corrected or updated on this date. Says nothing about who, and emits no
reviewedBy." Its own docstring names the 2026-08-07 seat-belt corrections as the
precedent: copy that was wrong, fixed by someone who is not a lawyer. Setting
`_roden_last_reviewed` would manufacture the trust signal that
`inc/schema-helpers.php` explicitly warns against.
