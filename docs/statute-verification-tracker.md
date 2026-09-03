# Statute verification tracker

**Generated from `bin/inventory-statute-citations.php`. Last updated 2026-09-03.**

The inventory has existed since #97. Until pass 1 nothing recorded *which* of its
statutes had been read against primary text, so every pass re-derived the question
and the answer lived in commit messages. This file is the record. Update it whenever
a statute is verified.

## Coverage

| | Statutes | Page-citations |
|---|---:|---:|
| Verified against primary text | **74** | **2,552** |
| Not yet verified | 201 | 410 |
| Total cited | 275 | 2,962 |

By page-citations that is **86%** of the site's statutory exposure, on
27% of the distinct statutes. The citations are heavily concentrated:
the 201 unverified statutes average 2.0 pages each, against
34 for the verified set. Work down by exposure, not alphabetically.

## Pass log

| Pass | Statutes read | Errors found |
|---|---:|---|
| #107 pass 1 | 12 | hit-and-run penalty tiers wrong on 2 pages |
| #108 pass 2 | 14 | 0.08 limit cited to § 56-5-2930 on 5 pages; GA wrongful-death deadline cited to a definitions section |
| #109 pass 3 | 12 | **an invented three-foot passing law for SC on 12 pages**; GA passing duty cited to § 40-6-292 |
| pass 4 | 18 | **none** |

**Three of four passes found a live error, and none surfaced from a sweep looking**
**for something else.** Pass 4 is the first clean one — 18 statutes, 200+ assertions,
nothing wrong. Worth recording as loudly as the failures: the workers'-compensation
schedules, the tort-claims caps, the helmet and crosswalk duties and the dram-shop
conditions are all stated correctly, several of them word-for-word from the statute.

### The worst finding so far

Pass 3. **S.C. Code § 56-5-3435 requires only a "safe operating distance" and names no**
**number**; its own heading says so. A 2019-2020 bill would have defined the term as
"not less than three feet" and was not enacted. Twelve pages asserted a three-foot rule
anyway, one in the words "same as Georgia". Georgia does have it (§ 40-6-56).

That is the only error found here where the site **invented a numeric legal standard**
rather than misciting an existing one, and a citation sweep could not catch it: seven
instances named no statute at all.

## Verified

| Statute | Pages | Verified in |
|---|---:|---|
| `SC 15-3-530` | 606 | earlier PRs (#92–#102, briefs) |
| `GA 9-3-33` | 469 | earlier PRs (#92–#102, briefs) |
| `GA 51-12-33` | 289 | earlier PRs (#92–#102, briefs) |
| `GA 51-12-5.1` | 51 | earlier PRs (#92–#102, briefs) |
| `SC 38-77-150` | 47 | earlier PRs (#92–#102, briefs) |
| `SC 42-15-40` | 45 | earlier PRs (#92–#102, briefs) |
| `SC 15-38-15` | 43 | earlier PRs (#92–#102, briefs) |
| `SC 38-77-160` | 38 | earlier PRs (#92–#102, briefs) |
| `SC 15-32-530` | 36 | earlier PRs (#92–#102, briefs) |
| `GA 9-3-71` | 35 | 2026-09-03 pass 1 (#107) |
| `SC 15-51-20` | 34 | 2026-09-03 pass 1 (#107) |
| `SC 15-3-545` | 33 | 2026-09-03 pass 1 (#107) |
| `SC 15-51-10` | 33 | 2026-09-03 pass 1 (#107) |
| `GA 33-7-11` | 33 | 2026-09-03 pass 2 (#108) |
| `SC 42-15-20` | 32 | earlier PRs (#92–#102, briefs) |
| `GA 34-9-82` | 32 | 2026-09-03 pass 1 (#107) |
| `SC 15-78-110` | 31 | earlier PRs (#92–#102, briefs) |
| `SC 15-78-10` | 31 | 2026-09-03 pass 2 (#108) |
| `SC 15-79-125` | 26 | 2026-09-03 pass 1 (#107) |
| `SC 56-5-1210` | 26 | 2026-09-03 pass 1 (#107) |
| `GA 51-3-1` | 26 | 2026-09-03 pass 2 (#108) |
| `SC 15-73-10` | 26 | 2026-09-03 pass 2 (#108) |
| `SC 38-77-140` | 25 | 2026-09-03 pass 1 (#107) |
| `GA 9-11-9.1` | 25 | 2026-09-03 pass 2 (#108) |
| `GA 51-4-1` | 21 | 2026-09-03 pass 2 (#108) |
| `GA 40-6-270` | 20 | 2026-09-03 pass 1 (#107) |
| `SC 15-78-80` | 19 | earlier PRs (#92–#102, briefs) |
| `GA 36-33-5` | 19 | 2026-09-03 pass 2 (#108) |
| `GA 51-1-11` | 19 | 2026-09-03 pass 2 (#108) |
| `SC 47-3-110` | 17 | 2026-09-03 pass 2 (#108) |
| `SC 56-5-2930` | 17 | 2026-09-03 pass 2 (#108) |
| `SC 15-32-220` | 16 | 2026-09-03 pass 2 (#108) |
| `GA 34-9-80` | 14 | 2026-09-03 pass 2 (#108) |
| `SC 38-77-170` | 14 | 2026-09-03 pass 2 (#108) |
| `GA 9-3-31` | 13 | earlier PRs (#92–#102, briefs) |
| `GA 51-4-2` | 13 | 2026-09-03 pass 2 (#108) |
| `SC 56-5-3435` | 13 | 2026-09-03 pass 3 (#109) |
| `SC 56-5-3660` | 13 | 2026-09-03 pass 3 (#109) |
| `SC 42-9-30` | 12 | 2026-09-03 pass 3 (#109) |
| `GA 40-6-391` | 12 | 2026-09-03 pass 3 (#109) |
| `GA 36-11-1` | 11 | 2026-09-03 pass 3 (#109) |
| `GA 51-2-7` | 11 | 2026-09-03 pass 3 (#109) |
| `GA 34-9-1` | 11 | 2026-09-03 pass 4 |
| `SC 42-1-10` | 10 | 2026-09-03 pass 4 |
| `SC 15-78-120` | 9 | 2026-09-03 pass 3 (#109) |
| `GA 50-21-26` | 9 | 2026-09-03 pass 3 (#109) |
| `SC 56-5-3130` | 9 | 2026-09-03 pass 3 (#109) |
| `SC 15-5-90` | 9 | 2026-09-03 pass 4 |
| `GA 34-9-201` | 9 | 2026-09-03 pass 4 |
| `GA 50-21-20` | 9 | 2026-09-03 pass 4 |
| `SC 42-9-10` | 8 | 2026-09-03 pass 4 |
| `SC 42-15-60` | 8 | 2026-09-03 pass 4 |
| `SC 56-5-6540` | 8 | 2026-09-03 pass 4 |
| `SC 56-5-3410` | 8 | 2026-09-03 pass 4 |
| `GA 24-12-1` | 8 | 2026-09-03 pass 4 |
| `GA 40-6-91` | 8 | 2026-09-03 pass 4 |
| `SC 15-32-520` | 7 | 2026-09-03 pass 2 (#108) |
| `GA 9-3-99` | 7 | 2026-09-03 pass 3 (#109) |
| `GA 19-7-1` | 7 | 2026-09-03 pass 4 |
| `GA 34-9-261` | 7 | 2026-09-03 pass 4 |
| `SC 50-21-112` | 7 | 2026-09-03 pass 4 |
| `GA 40-6-315` | 7 | 2026-09-03 pass 4 |
| `GA 51-1-40` | 7 | 2026-09-03 pass 4 |
| `GA 40-8-76.1` | 6 | earlier PRs (#92–#102, briefs) |
| `SC 42-9-20` | 6 | 2026-09-03 pass 4 |
| `GA 40-8-76` | 4 | earlier PRs (#92–#102, briefs) |
| `SC 61-2-145` | 4 | earlier PRs (#92–#102, briefs) |
| `SC 15-33-135` | 4 | 2026-09-03 pass 2 (#108) |
| `GA 40-6-56` | 4 | 2026-09-03 pass 3 (#109) |
| `SC 56-5-6460` | 2 | earlier PRs (#92–#102, briefs) |
| `GA 9-3-30` | 1 | earlier PRs (#92–#102, briefs) |
| `SC 61-2-147` | 1 | earlier PRs (#92–#102, briefs) |
| `GA 40-6-189` | 1 | earlier PRs (#92–#102, briefs) |
| `GA 40-6-292` | 1 | 2026-09-03 pass 3 (#109) |

## Not yet verified — top 30 by exposure

| Statute | Pages |
|---|---:|
| `SC 50-21-10` | 7 |
| `SC 56-5-3230` | 6 |
| `SC 56-2-100` | 6 |
| `SC 56-5-3150` | 6 |
| `GA 51-12-4` | 6 |
| `GA 40-7-120` | 6 |
| `GA 52-7-1` | 6 |
| `GA 24-4-403` | 5 |
| `GA 51-4-5` | 5 |
| `GA 9-3-73` | 5 |
| `SC 15-36-100` | 5 |
| `GA 40-6-71` | 5 |
| `SC 56-2-105` | 5 |
| `GA 40-6-181` | 5 |
| `SC 56-5-3890` | 5 |
| `GA 24-7-702` | 5 |
| `GA 33-4-6` | 5 |
| `GA 40-6-273` | 5 |
| `GA 34-9-17` | 5 |
| `GA 34-9-200.1` | 5 |
| `GA 34-9-263` | 5 |
| `SC 42-1-400` | 5 |
| `SC 43-35-5` | 5 |
| `SC 56-15-10` | 5 |
| `GA 40-6-294` | 5 |
| `GA 31-8-1` | 5 |
| `GA 4-8-20` | 5 |
| `SC 22-3-10` | 4 |
| `GA 40-6-390` | 4 |
| `SC 56-5-1520` | 4 |

…and 171 more. Regenerate the full list from `bin/inventory-statute-citations.php`.

## Method

1. Extract what the site **asserts** — a window around every citation across
   `post_content`, `post_excerpt`, `_roden_faqs` and `_roden_key_takeaways`. Not a
   sentence split: the splitter has produced four false positives here.
2. Condense to the distinct quantities and rules bound to the section.
3. Read the statute against primary text — scstatehouse.gov for SC, codes.findlaw.com
   for GA. Justia returns 403. Long SC chapter pages truncate before the section you
   want; search for the section directly when that happens.
4. Compare, then sweep the **claim class** — cited *and* uncited forms.

### Two traps this list has already sprung

**A two-state comparison table binds the other state's number to this state's**
**citation** in any window-based extraction. Twenty hits on `GA 34-9-82` looked like a
2-year deadline against a 1-year statute; all twenty were South Carolina's column.

**An uncited false claim is not less false, only harder to grep.** Pass 3's first fix
caught the 21 instances that cited § 56-5-3435 and missed seven that asserted three
feet with no citation at all — including the opening paragraph of every city page.

## Watch items

**`SC 15-32-220` is inflation-adjusted every January** by the Revenue and Fiscal Affairs
Office. Two pages quote 2026 figures — roughly $596,001 per provider and about
$1,788,003 in aggregate. The per-provider figure is correct for 2026. **These go stale**
**next January** unless reviewed, or rewritten to state the $350,000 base and the
adjustment mechanism.

**SC Bill 280 (2025-2026), "Safety belts, evidence admissibility in civil action"**,
is pending. `SC 56-5-6540(C)` currently makes a seat-belt violation inadmissible in a
civil action, and eight pages rely on that. Georgia's equivalent rule reversed in 2025
and went unpropagated here for sixteen months (#97). If Bill 280 passes, sweep those
eight pages the same week.
