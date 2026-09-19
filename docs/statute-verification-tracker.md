# Statute verification tracker

**Generated from `bin/inventory-statute-citations.php`. Last updated 2026-09-03.**

The inventory has existed since #97. Until pass 1 nothing recorded *which* of its
statutes had been read against primary text, so every pass re-derived the question
and the answer lived in commit messages. This file is the record. Update it whenever
a statute is verified.

## Coverage

| | Statutes | Page-citations |
|---|---:|---:|
| Verified against primary text | **110** | **2,562** |
| Not yet verified | 196 | 396 |
| Total cited | 290 | 2,962 |

*2026-09-19, moped pass: eighteen sections verified ahead of first use for the two moped-law
pages (five Georgia, thirteen South Carolina); `SC 56-2-3010` is now cited on the e-bike
pillar after its correction.*

*2026-09-19, golf-cart pass: `SC 56-2-100` verified (6 pages, but for the wrong vehicle — see
the pass log) and `SC 56-2-90` verified ahead of first use. `SC 56-2-105` (5 pages) leaves the
unverified list not because it was verified but because it **no longer exists**: repealed
2025-05-22. Its five page-citations are counted here under Verified against the section that
replaced it, and the pages are the remediation queue in
`data/facts/golf-cart-verification-2026-09-19.md`.*

*2026-09-19: sixteen sections verified in the helmet pass — six Georgia (codes.findlaw.com)
and ten South Carolina (scstatehouse.gov, read by the SC writer, owner sign-off the same
day). Thirteen of them were not cited anywhere on the site before the two helmet pages
published; they were verified ahead of first use, and the pages now cite them. Page-citation
counts will catch up on the next full pass.*

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
| 2026-09-09 | `SC 15-78-50`, `-80`, `-110` re-read | **4 instances on 2 pages** cited § 15-78-50 — a section with no deadline in it — for a two-year notice requirement that is neither two years nor required |
| 2026-09-08 recheck | `SC 15-38-15` re-read | **31 instances on 23 pages** still cited it for the plaintiff's recovery bar — a class #97 had already corrected |
| 2026-09-19 moped pass | GA `40-1-1(28)`, `40-1-1(30)`, `40-6-350`, `40-6-351`, `40-6-352`, `40-6-353`, `40-2-20(b)(6)` on codes.findlaw.com (current as of 2024-03-28); SC `56-1-10(26)`, `56-2-3000` to `56-2-3080` on scstatehouse.gov t56c002, and `56-1-1720`, `56-1-1730`, `38-77-30` from the enrolled text of 2017 Act No. 89 (H.3247, eff 2018-11-19) because the Chapter 1 page is too long for the fetcher | **One live error**: the e-bike pillar (4578) said an over-threshold e-bike becomes a moped "requiring title, registration, and insurance"; `§ 56-2-3010` says mopeds are registered but "not required to be titled or insured in this State". Fixed same day (`bin/fix-moped-claims.php`). Only three pages mention mopeds at all. SC `§ 56-5-2930` (DUI) could not be read — the Chapter 5 page truncates before it — so the pages rest on `§ 56-1-10(26)` defining a moped "as a motor vehicle" and do not cite the DUI section. |
| 2026-09-19 golf-cart pass | `SC 56-2-90`, `56-2-100`, `56-2-105`, `56-3-115` read on scstatehouse.gov; 2025 Act No. 64 (H.3292) read on the bill page | **`§ 56-2-105` was REPEALED 2025-05-22** by Act 64 §2 and replaced by `§ 56-2-90` (Act 64 §1). Four live pages still cite the repealed section as current law (4343, 4364, 4754, 4804). `§ 56-2-100` is the LOW-SPEED VEHICLE section, not a golf-cart one; 4738 cites it and `§ 56-3-115` (today: a deaf/hard-of-hearing registration notation, 2021) for golf-cart eligibility. Two sub-type pages (4185, 4186) say South Carolina has no statewide golf-cart statute. 4343 says SC does not require golf-cart liability insurance; `§ 56-2-90(A)` requires proof of it for the permit. 4364 says the licence rule means "minors under 15" cannot drive; `§ 56-2-90(B)` says at least sixteen. Record: `data/facts/golf-cart-verification-2026-09-19.md`. |
| 2026-09-19 helmet pass | `GA 40-6-296`, `40-6-300`, `40-6-301`, `40-6-302`, `40-6-303`, `40-1-1(15.3)` read on codes.findlaw.com (current as of 2024-03-28) | **none** on the sections themselves: the site's uncited bicycle (under 16) and e-bike (Class III all ages, no operator under 15, Class I/II ride as bicycles) statements all match the text. The pass surfaced two evidence bars the site had never stated — § 40-6-296(d)(5) and § 40-6-303(c)(5): a bicycle or e-bike helmet violation "shall not … be considered evidence of negligence or liability". The motorcycle statute has no equivalent. Justia and LegiScan 403; the enrolled act (HB 454, 2019) was not cross-checked. |

**Three of four passes found a live error, and none surfaced from a sweep looking**
**for something else.**

**A PAGE CAN CONTRADICT ITSELF ACROSS SURFACES.**
/blog/rideshare-accident-i-26-tenmile-north-charleston/ cited § 15-78-50 for the
Tort Claims Act deadline in its visible prose while its own FAQ structured data,
in the same `post_content`, cited § 15-78-110. One was right. A sweep reading only
one surface would have found either a clean page or a broken one depending on which
it read.

**A CORRECTED CLASS CAN COME BACK.** #97 fixed 34 pages that cited § 15-38-15 for
South Carolina's plaintiff bar; the rule is *Nelson v. Concrete Supply Co.*, and
the section governs apportionment among defendants. On 2026-09-08 **thirty-one
instances across twenty-three pages** were carrying it again — including the
Charleston personal-injury page three times, and a dozen local-SEO blog posts that
POSTDATE the fix. Remediating a class does not immunise it; the templates that
generate new pages carry the error forward. Re-check a corrected class when new
content ships against it. Pass 4 is the first clean one — 18 statutes, 200+ assertions,
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
| `GA 40-6-296` | 1 | 2026-09-19 helmet pass — (d): bicycle helmet, riders and passengers under 16, ANSI/Snell; (d)(5) not evidence of negligence |
| `GA 40-6-300` | 1 | 2026-09-19 helmet pass — Class I/II/III definitions (20 / 20 / 28 mph) |
| `GA 40-1-1` (15.3) | 1 | 2026-09-19 helmet pass — "electric assisted bicycle": two or three wheels, operative pedals, motor ≤ 750 W |
| `GA 40-6-301` | 0 | 2026-09-19 helmet pass — e-bike operator has a bicycle operator's rights and duties |
| `GA 40-6-302` | 0 | 2026-09-19 helmet pass — labelling; same equipment as bicycles; Class III speedometer |
| `GA 40-6-303` | 0 | 2026-09-19 helmet pass — (b) no operator under 15 on Class III; (c)(1) every Class III operator and passenger wears a helmet; (c)(5) not evidence of negligence |
| `SC 56-5-3670`, `56-5-3680` | 0 | 2026-09-19 helmet pass (SC writer, scstatehouse.gov t56c005; owner sign-off 2026-09-19) — goggles or face shield for operators under 21; wind-screen exception |
| `SC 56-5-3700` | 0 | 2026-09-19 helmet pass — helmet/eye-protection violation: misdemeanor, up to $100 or 30 days |
| `SC 56-5-3520` | 0 | 2026-09-19 helmet pass — electric-assist bicycle ridden under the bicycle rules |
| `SC 56-1-10(29)` | 0 | 2026-09-19 helmet pass — "electric-assist bicycle": ≤ 750 W, under 20 mph |
| `SC 56-2-3070` | 0 | 2026-09-19 helmet pass (t56c002) — (C) moped operator or passenger under 21 wears a helmet; (G) misdemeanor, up to $200 or 30 days |
| `SC 50-26-30`, `50-26-60`, `50-26-70` | 0 | 2026-09-19 helmet pass (t50c026) — ATV riders 15 and younger: FMVSS 218 helmet and eye protection; $50–$200; farming, hunting, supervised private-land exceptions |
| `SC 56-5-6540(C)` | 0 | 2026-09-19 helmet pass — seat-belt violation is not negligence per se and not admissible in a civil action (cited for contrast only; there is no helmet equivalent) |
| `SC 56-2-90` | 0 | 2026-09-19 golf-cart pass (scstatehouse.gov t56c002; 2025 Act No. 64 §1, eff 2025-05-22) — (A) DMV permit decal + registration, proof of ownership and liability insurance, $5, renew every 5 years or on change of address; (B) operator at least 16 with a valid licence, carrying registration, proof of insurance per § 38-77-140 and licence; (C) municipality/county may by ordinance set hours, methods, locations (only where the limit is ≤ 35 mph), permit night operation with working head- and taillights, designate separated cart paths, and may not require proof of property ownership for a decal; (D) absent an ordinance: daylight only, secondary highway ≤ 35 mph, within 4 miles of the registered address or a gated community's gate, may cross a > 35 mph highway at an intersection; (E) passengers under 12 must wear a fastened safety belt. **Replaces `§ 56-2-105`, repealed by Act 64 §2 the same day.** |
| `GA 40-1-1(28)`, `(30)` | 0 | 2026-09-19 moped pass — "moped": motor driven cycle, two or three wheels, max two brake horsepower, combustion engine ≤ 50 cc (3.05 cu in), unassisted top speed ≤ 30 mph on level road, automatic drive; "motor driven cycle": motorcycles ≤ 5 bhp and every moped |
| `GA 40-6-350` | 0 | 2026-09-19 moped pass — moped operator has a vehicle driver's rights and duties, except the headlight/taillight rule of § 40-6-312(e) and the windshield/eye-protection rule of § 40-6-315(b) |
| `GA 40-6-351` | 0 | 2026-09-19 moped pass — no operator under 15; a valid driver's licence, instruction permit or limited permit of any class required |
| `GA 40-6-352` | 0 | 2026-09-19 moped pass — every operator AND passenger wears protective headgear meeting the Commissioner of Public Safety's standards; approved motorcycle helmets comply |
| `GA 40-6-353` | 0 | 2026-09-19 moped pass — DOT commissioner or a local authority may prohibit mopeds on roads in its jurisdiction for safety |
| `GA 40-2-20(b)(6)` | 0 | 2026-09-19 moped pass — mopeds exempt from registration |
| `SC 56-1-10(26)` | 0 | 2026-09-19 moped pass — "moped": a cycle "defined as a motor vehicle", ≤ 3 wheels, motor of 50 cc, or electric input over 750 W and not more than 1,500 W |
| `SC 56-1-1720`, `56-1-1730` | 0 | 2026-09-19 moped pass (2017 Act No. 89 enrolled text) — a valid driver's licence or a moped operator's licence, issued at 15 or older; eligibility "without regard to" any other licence's status; DMV may suspend it only for moped violations |
| `SC 56-2-3000` | 0 | 2026-09-19 moped pass — carry a valid moped or driver's licence and the moped registration |
| `SC 56-2-3010` | 1 | 2026-09-19 moped pass — mopeds on public highways registered and licensed like passenger vehicles; **not required to be titled or insured**; exempt from property tax |
| `SC 56-2-3020` to `56-2-3060`, `56-2-3080` | 0 | 2026-09-19 moped pass — nonresident 180-day rule; application, title on request, fraud penalties; dealers must sell/rent with operable pedals (if fitted), a mirror, head- and running lights, brake lights; $200 / 30 days |
| `SC 56-2-3070` | 0 | 2026-09-19 moped pass (confirmed the helmet pass) — (A) ride astride a permanent seat; (B) farthest right lane on multilane highways; (C) under 21 wears a § 56-5-3660 helmet; (D) no faster than 35 mph; (E) not on highways posted above 55 mph; (F) headlight and lights on at all times; (G) misdemeanor, $200 / 30 days |
| `SC 38-77-30` | 0 | 2026-09-19 moped pass (Act 89 text) — mopeds are motor vehicles for uninsured/underinsured motorist coverage purposes only |
| `SC 56-1-10` (low speed vehicle) | 0 | 2026-09-19 golf-cart pass (SC writer, scstatehouse.gov t56c001; owner sign-off) — four-wheeled motor vehicle, more than 20 and not more than 25 mph in one mile, GVWR under 3,000 lb |
| `SC 56-2-120` | 0 | 2026-09-19 golf-cart pass (t56c002) — (A) LSVs titled; the State issues no VIN to homemade LSVs or **retrofitted golf carts**, which do not qualify as LSVs; (C) registered, licensed and insured like passenger vehicles |
| `SC 38-77-140(A)` | 0 | 2026-09-19 golf-cart pass (t38c077) — minimum automobile liability limits $25,000 / $50,000 / $25,000; referenced by § 56-2-90(B)(2) |
| `SC 56-2-100` | 6 | 2026-09-19 golf-cart pass — LOW-SPEED VEHICLES, not golf carts: operation only on ≤ 35 mph highways, may cross faster highways at intersections, FMVSS 500 equipment, local and DOT prohibitions permitted, farm vehicles excluded. The six pages citing it for golf carts miscite. |

## Not yet verified — top 30 by exposure

| Statute | Pages |
|---|---:|
| `SC 50-21-10` | 7 |
| `SC 56-5-3230` | 6 |
| `SC 56-5-3150` | 6 |
| `GA 51-12-4` | 6 |
| `GA 40-7-120` | 6 |
| `GA 52-7-1` | 6 |
| `GA 24-4-403` | 5 |
| `GA 51-4-5` | 5 |
| `GA 9-3-73` | 5 |
| `SC 15-36-100` | 5 |
| `GA 40-6-71` | 5 |
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

**A verified section can stop existing.** `SC 56-2-105` was on the site as current
golf-cart law on four pages for sixteen months after 2025 Act No. 64 repealed it and moved
the rules to `§ 56-2-90` (2025-05-22). Nothing in the verification method catches a
repeal after the fact: a page cites the section, the section reads correctly on the day it
is checked, and the legislature moves it the next session. Each pass should re-read the
HISTORY line of every section it touches, and any section with an effective date newer
than the page citing it is a page to re-read. The same pass found `§ 56-3-115` cited for
golf-cart eligibility; today that number is a deaf/hard-of-hearing registration notation.

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
