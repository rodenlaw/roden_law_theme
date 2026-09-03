# Statute verification tracker

**Generated 2026-09-03 from `bin/inventory-statute-citations.php`.**

The inventory has existed since #97. Until now nothing recorded *which* of its
statutes had actually been read against primary text, so every pass re-derived
the question and the answer was carried in commit messages. This file is the
record. Update it whenever a statute is verified.

## Coverage

| | Statutes | Page-citations |
|---|---:|---:|
| Verified against primary text | **45** | **2,317** |
| Not yet verified | 230 | 645 |
| Total cited | 275 | 2,962 |

By page-citations that is **78%** of the site's statutory exposure,
on 16% of the distinct statutes — the citations are heavily
concentrated, so verifying by exposure buys far more than verifying alphabetically.

**Every pass so far has found at least one error.** That is the argument for
continuing down this list rather than waiting for the next accident.

## Verified

| Statute | Pages | Verified in |
|---|---:|---|
| `SC 15-3-530` | 606 | #97 |
| `GA 9-3-33` | 469 | #97 |
| `GA 51-12-33` | 289 | #97 |
| `GA 51-12-5.1` | 51 | #97 + SB 68 audit |
| `SC 38-77-150` | 47 | #101 |
| `SC 42-15-40` | 45 | #101 |
| `SC 15-38-15` | 43 | Act 42 brief |
| `SC 38-77-160` | 38 | #101 |
| `SC 15-32-530` | 36 | #102 |
| `GA 9-3-71` | 35 | 2026-09-03 inventory pass |
| `SC 15-51-20` | 34 | 2026-09-03 inventory pass |
| `SC 15-3-545` | 33 | 2026-09-03 inventory pass |
| `SC 15-51-10` | 33 | 2026-09-03 inventory pass |
| `SC 42-15-20` | 32 | #101 |
| `GA 34-9-82` | 32 | 2026-09-03 inventory pass |
| `SC 15-78-110` | 31 | #101 |
| `SC 56-5-1210` | 26 | 2026-09-03 inventory pass |
| `SC 15-79-125` | 26 | 2026-09-03 inventory pass |
| `SC 38-77-140` | 25 | 2026-09-03 inventory pass |
| `GA 40-6-270` | 20 | 2026-09-03 inventory pass |
| `SC 15-78-80` | 19 | #101 |
| `GA 9-3-31` | 13 | #97 |
| `SC 15-32-520` | 7 | #106 |
| `GA 40-8-76.1` | 6 | SB 68 brief |
| `SC 61-2-145` | 4 | Act 42 brief |
| `GA 40-8-76` | 4 | #97 |
| `SC 15-33-135` | 4 | #106 |
| `SC 56-5-6460` | 2 | #97 |
| `SC 61-2-147` | 1 | Act 42 brief |
| `GA 9-3-30` | 1 | #97 |
| `GA 40-6-189` | 1 | super-speeder pass |
| `GA 33-7-11` | 33 | 2026-09-03 pass 2 |
| `GA 51-3-1` | 26 | 2026-09-03 pass 2 |
| `GA 9-11-9.1` | 25 | 2026-09-03 pass 2 |
| `SC 15-73-10` | 26 | 2026-09-03 pass 2 |
| `GA 34-9-80` | 14 | 2026-09-03 pass 2 |
| `GA 36-33-5` | 19 | 2026-09-03 pass 2 |
| `GA 51-1-11` | 19 | 2026-09-03 pass 2 |
| `GA 51-4-1` | 21 | 2026-09-03 pass 2 |
| `GA 51-4-2` | 13 | 2026-09-03 pass 2 |
| `SC 47-3-110` | 17 | 2026-09-03 pass 2 |
| `SC 38-77-170` | 14 | 2026-09-03 pass 2 |
| `SC 56-5-2930` | 17 | 2026-09-03 pass 2 |
| `SC 15-32-220` | 16 | 2026-09-03 pass 2 |

## Not yet verified — top 40 by exposure

| Statute | Pages | Surfaces |
|---|---:|---|
| `SC 15-78-10` | 31 | 2 |
| `SC 56-5-3435` | 13 | 2 |
| `SC 56-5-3660` | 13 | 2 |
| `GA 40-6-391` | 12 | 1 |
| `SC 42-9-30` | 12 | 4 |
| `GA 36-11-1` | 11 | 2 |
| `GA 51-2-7` | 11 | 2 |
| `GA 34-9-1` | 11 | 2 |
| `SC 42-1-10` | 10 | 3 |
| `SC 15-78-120` | 9 | 1 |
| `GA 50-21-26` | 9 | 1 |
| `SC 15-5-90` | 9 | 2 |
| `GA 34-9-201` | 9 | 1 |
| `SC 56-5-3130` | 9 | 3 |
| `GA 50-21-20` | 9 | 1 |
| `SC 42-9-10` | 8 | 2 |
| `SC 42-15-60` | 8 | 2 |
| `SC 56-5-6540` | 8 | 2 |
| `SC 56-5-3410` | 8 | 2 |
| `GA 24-12-1` | 8 | 1 |
| `GA 40-6-91` | 8 | 2 |
| `GA 9-3-99` | 7 | 1 |
| `GA 19-7-1` | 7 | 1 |
| `GA 34-9-261` | 7 | 2 |
| `SC 50-21-112` | 7 | 2 |
| `GA 40-6-315` | 7 | 2 |
| `GA 51-1-40` | 7 | 1 |

…and 204 more, each cited on fewer pages. Full list regenerates from
`bin/inventory-statute-citations.php`.

## Method

1. Extract what the site **asserts** about the statute — a window around every
   citation across `post_content`, `post_excerpt`, `_roden_faqs` and
   `_roden_key_takeaways`. Not a sentence split: the splitter has produced four
   false positives on this site.
2. Condense to the distinct quantities and rules bound to it.
3. Read the statute against primary text — scstatehouse.gov for SC, FindLaw or
   Justia for GA. Justia returned 403 on 2026-09-03; FindLaw worked.
4. Compare, then sweep the **claim class** for anything the first read missed.

A two-state comparison table will bind the other state's number to this state's
citation in any window-based extraction. Twenty such hits on `GA 34-9-82` were
all correct — the 2-year figure was South Carolina's, in the adjacent column.
Read before concluding.

## Pass log

| Date | Statutes read | Errors found |
|---|---:|---|
| 2026-09-03 pass 1 | 12 | hit-and-run penalty tiers wrong on 2 pages (#107) |
| 2026-09-03 pass 2 | 14 | 0.08 limit cited to § 56-5-2930 on 5 pages; GA wrongful-death deadline cited to a definitions section on 1 |

**Two for two.** Every pass through this list has found a live error, and neither
was found by the sweeps that were looking for something else.

### Known maintenance item

`SC 15-32-220` is inflation-adjusted **annually** by the Revenue and Fiscal Affairs
Office. Two pages quote the 2026 figures — roughly $596,001 per provider and about
$1,788,003 in aggregate. The per-provider figure is correct for 2026; one secondary
source gives the aggregate as $1,788,002, a $1 difference on a figure the pages
already hedge with "about". **These numbers go stale every January.** Pages quoting
them need a yearly review, or should state the $350,000 base and the adjustment
mechanism instead.
