# Statute verification tracker

**Generated from `bin/inventory-statute-citations.php`. Last updated 2026-10-26, after pass 3 and
its SC fixes**; last recount 2026-10-24, after pass 2 and batch 2 (recount `data/facts/statute-inventory-2026-10-24-batch2.txt`, 645 published documents).

The inventory has existed since #97. Until pass 1 nothing recorded *which* of its
statutes had been read against primary text, so every pass re-derived the question
and the answer lived in commit messages. This file is the record. Update it whenever
a statute is verified.

## Coverage

| 2026-10-26, after pass 3 (computed from the 2026-10-24 recount, not a new run) | Statutes | Page-citations |
|---|---:|---:|
| Verified against primary text | **209** | **2,409** (91.9%) |
| Not yet verified | 187 | 211 |
| Total cited | 396 | 2,620 |

*Pass 3 read the 30 sections listed under "Not yet verified" below (64 page-citations). Eleven of
the 30 are read but still carry open errors (G3–G5, G7, G8, G10–G29), which wait on the attorneys.
Re-run `bin/inventory-statute-citations.php` before ranking pass 4.*

| 2026-10-24, after pass 2 and batch 2, fixed inventory | Statutes | Page-citations |
|---|---:|---:|
| Verified against primary text | **179** | **2,345** (89.5%) |
| Not yet verified | 217 | 275 |
| Total cited | 396 | 2,620 |

*Pass 2 (30 sections in scope, 9 supporting that are cited) adds 39 statutes and 120 page-citations
over the batch-1 figure of 140 / 2,225 of 2,621 (84.9%). Batch 2 removed one cited section
(`SC 56-5-3190`, the white-cane section, cited for the walking-along-a-highway rule) and added
`SC 56-5-500`.*

*The inventory script was fixed on 2026-10-24 (`JSON_UNESCAPED_UNICODE` on `_roden_faqs`, and matching
on stripped text). Before the fix it could not see FAQ citations written with "§", and it read 379 / 2,303
(135 / 1,944 verified, 84.4%). The figures above are today's run of the fixed script, after batch 1
(`data/facts/statute-inventory-2026-10-24-postfix.txt`). The pre-fix run is kept as
`statute-inventory-2026-10-24.txt`. The script now also reads `_roden_why_hire`, `_roden_common_injuries`, `_roden_common_causes` and
`_roden_pillar_negligence_intro`, after batch 1b found a § 40-6-294 miscitation in `_roden_why_hire` that it
could not see. Those fields add 2 statutes and 15 page-citations. **The claims sweep's export
(`data/content-cache/wp-export.json`, a toolkit file) still does not read them**: fixing that is a toolkit PR.*

**How the numbers are counted.**
- **Unit: inventory section.** The unit is the inventory's key: state plus section number, with
  any `(a)`/`(1)` subsection stripped (`preg_replace('/\([a-z0-9]+\)/i', '', …)`).
  - Subsections are folded into their section, not counted separately. `GA 40-1-1(15.3)` and
    `GA 40-1-1(29)` both count as `GA 40-1-1`.
  - A page-citation is one page citing that section on any surface.
  - Rows in the Verified table below that name a subsection, or several sections in one row,
    therefore do not map one-to-one onto the Statutes column.
- **Rule for "verified".** A section counts as verified if it is listed in ## Verified, **or** it is
  an authority id in `internal-ai-scripts/law/GA.json` / `SC.json`. Pending authorities do not
  count.
  - "Verified" means read against primary text. It does **not** mean attorney-signed.
  - The GA pack is UNSIGNED for Roden (`law-signoff.json`; Tyler Love to sign). The SC pack is
    signed by Graeham C. Gillin.
- **Reconciling the pack authorities.** Twenty-five sections were verified into the packs and
  never recorded here. They come to 111 page-citations, and they include the GA statute research
  of 2026-09-30 and the 2026-10-20 attorney-approved batch. They are listed under "Verified via
  pack authority" below and counted in the 135.
  - Before today's pass, the same basis gave **112 / 379 statutes and 1,826 / 2,303
    page-citations (79.3%)**.
  - The 2026-10-24 pass adds 23 sections and 118 page-citations.
- **Not comparable with earlier figures.** The 2026-09-03 table (114 / 2,571 of 2,962) was taken
  on an older snapshot and was carried forward as a running estimate. Since then:
  - the floor cull and the mass-tort retirement unpublished pages;
  - pages were rewritten;
  - this recount reads only published documents.
- **Blind spot in the basis itself.** The inventory serialises `_roden_faqs` with
  `wp_json_encode()`, which escapes "§" to `\u00a7`, so its regex misses every FAQ citation
  written with "§". A tag or `&nbsp;` between "O.C.G.A." and "§" also defeats it.
  - Re-run over today's export with FAQs unescaped and HTML stripped, the site cites **393
    statutes on 2,607 page-citations**.
  - On that basis coverage is **137 verified (2,217, 85.0%)**, with 256 unverified (390).
  - Details are in `data/facts/statute-pass-2026-10-24.md`.
  - The fix is `JSON_UNESCAPED_UNICODE` plus `wp_strip_all_tags` in the inventory script.

*2026-10-24 pass: the twenty most-exposed unverified sections read (6 SC on scstatehouse.gov; 14
GA from Internet Archive captures of codes.findlaw.com and law.justia.com, plus SB 68 from
legis.ga.gov). Supporting sections `GA 31-7-1`, `SC 38-59-30` and `SC 41-1-80` (cited on 4 pages)
were also read, along with six sections ahead of first use. See the pass log.*

*2026-09-21: `GA 40-1-1(29)`/`(33)`, `GA 40-6-391(a)`, `SC 56-5-2930(A)` and `SC 56-1-10(7)`
verified. `§ 40-6-391` had been cited on the golf-cart DUI sub-type and pillar before it was
read; it moves from the unverified side. Page-citation counts are running estimates until the
next full pass recounts them.*

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

By page-citations that is **84.4%** of the site's statutory exposure (inventory basis), on 36% of
the distinct statutes. The citations are heavily concentrated: the 244 unverified statutes average
1.5 pages each, against 14.4 for the verified set. 167 of the unverified are cited on a single
page. Work down by exposure, not alphabetically.

## Pass log

| Pass | Statutes read | Errors found |
|---|---:|---|
| #107 pass 1 | 12 | hit-and-run penalty tiers wrong on 2 pages |
| #108 pass 2 | 14 | 0.08 limit cited to § 56-5-2930 on 5 pages; GA wrongful-death deadline cited to a definitions section |
| #109 pass 3 | 12 | **an invented three-foot passing law for SC on 12 pages**; GA passing duty cited to § 40-6-292 |
| pass 4 | 18 | **none** |
| 2026-09-09 | `SC 15-78-50`, `-80`, `-110` re-read | **4 instances on 2 pages** cited § 15-78-50 — a section with no deadline in it — for a two-year notice requirement that is neither two years nor required |
| 2026-09-08 recheck | `SC 15-38-15` re-read | **31 instances on 23 pages** still cited it for the plaintiff's recovery bar — a class #97 had already corrected |
| 2026-09-21 e-bike classification pass | `GA 40-1-1(29)`, `(33)` on codes.findlaw.com, against `(15.3)`, `(28)` and `SC 56-1-10(26)`, `(29)` already verified | **Imprecision, not error**, on the e-bike pillar (4578): speed offered as the trigger for an e-bike becoming a moped, and "a moped or motor vehicle" offered as alternatives. The statutes hinge on motor power (750 W; Georgia's moped at 2 bhp / 30 mph / automatic drive; South Carolina's at 750–1,500 W), and a Georgia moped is a motor vehicle. Five edits on three surfaces (`bin/fix-ebike-classification.php`). |
| 2026-09-19 moped pass | GA `40-1-1(28)`, `40-1-1(30)`, `40-6-350`, `40-6-351`, `40-6-352`, `40-6-353`, `40-2-20(b)(6)` on codes.findlaw.com (current as of 2024-03-28); SC `56-1-10(26)`, `56-2-3000` to `56-2-3080` on scstatehouse.gov t56c002, and `56-1-1720`, `56-1-1730`, `38-77-30` from the enrolled text of 2017 Act No. 89 (H.3247, eff 2018-11-19) because the Chapter 1 page is too long for the fetcher | **One live error**: the e-bike pillar (4578) said an over-threshold e-bike becomes a moped "requiring title, registration, and insurance"; `§ 56-2-3010` says mopeds are registered but "not required to be titled or insured in this State". Fixed same day (`bin/fix-moped-claims.php`). Only three pages mention mopeds at all. SC `§ 56-5-2930` (DUI) could not be read — the Chapter 5 page truncates before it — so the pages rest on `§ 56-1-10(26)` defining a moped "as a motor vehicle" and do not cite the DUI section. |
| 2026-09-19 golf-cart pass | `SC 56-2-90`, `56-2-100`, `56-2-105`, `56-3-115` read on scstatehouse.gov; 2025 Act No. 64 (H.3292) read on the bill page | **`§ 56-2-105` was REPEALED 2025-05-22** by Act 64 §2 and replaced by `§ 56-2-90` (Act 64 §1). Four live pages still cite the repealed section as current law (4343, 4364, 4754, 4804). `§ 56-2-100` is the LOW-SPEED VEHICLE section, not a golf-cart one; 4738 cites it and `§ 56-3-115` (today: a deaf/hard-of-hearing registration notation, 2021) for golf-cart eligibility. Two sub-type pages (4185, 4186) say South Carolina has no statewide golf-cart statute. 4343 says SC does not require golf-cart liability insurance; `§ 56-2-90(A)` requires proof of it for the permit. 4364 says the licence rule means "minors under 15" cannot drive; `§ 56-2-90(B)` says at least sixteen. Record: `data/facts/golf-cart-verification-2026-09-19.md`. |
| 2026-09-19 helmet pass | `GA 40-6-296`, `40-6-300`, `40-6-301`, `40-6-302`, `40-6-303`, `40-1-1(15.3)` read on codes.findlaw.com (current as of 2024-03-28) | **none** on the sections themselves: the site's uncited bicycle (under 16) and e-bike (Class III all ages, no operator under 15, Class I/II ride as bicycles) statements all match the text. The pass surfaced two evidence bars the site had never stated — § 40-6-296(d)(5) and § 40-6-303(c)(5): a bicycle or e-bike helmet violation "shall not … be considered evidence of negligence or liability". The motorcycle statute has no equivalent. Justia and LegiScan 403; the enrolled act (HB 454, 2019) was not cross-checked. |
| 2026-10-24 pass (top 20 by exposure) | 20 in scope (GA 51-12-1.1, 34-9-17, 34-9-200.1, 9-3-73, 34-9-200, 51-4-5, 9-3-90, 51-1-29.5, 9-10-184, 24-7-702, 40-6-294, 31-8-1, 4-8-20, 34-9-11.1, 9-11-67.1; SC 38-59-40, 56-5-6160, 38-59-20, 56-5-1290, 15-78-60), plus 16 supporting. SC from scstatehouse.gov. GA from Internet Archive captures of codes.findlaw.com and law.justia.com, because both sites served bot checks to direct requests; FindLaw text is current as of 2024-03-28. SB 68 from legis.ga.gov. 0 unreadable. | **66 live errors on 34 documents; 10 of the 20 sections wrong or mis-cited somewhere.** Worst: post 1690 gives South Carolina an **invented safety-rule benefit reduction** under § 42-9-60, which bars compensation only for intoxication or wilful intent to injure. It appears in five places across the body, FAQ 3 and the key takeaways. ER sub-type 4197 says Georgia does not lower the standard in emergencies, against § 51-1-29.5's gross-negligence / clear-and-convincing rule (uncited). 5145, 5128 and ES 5141 say SC holds ER care to ordinary negligence, against § 15-32-230. § 34-9-200: 1677 says GA medical benefits have no time limit, in five places, against the 400-week limit for post-2013 non-catastrophic injuries. § 9-3-73: the repose (10th birthday) is given as the filing deadline on 1676, 1696 and 4195. § 34-9-17 is cited as an anti-retaliation statute (1662) and given a drug-free-policy precondition (1690). §§ 40-6-294 and 31-8-1 are mis-cited on five pages each. The § 4-8-21 dog definitions are wrong on 4119. § 9-11-67.1's 2024 amendment is dated July 1 instead of April 22 (1722). The wrongful-death deadline is cited to §§ 51-4-5 and 9-3-71 (4360, 1823). The pass also found the inventory's FAQ blind spot (`wp_json_encode` escapes "§"): 304 page-citations and 14 statutes it cannot see. Record: `data/facts/statute-pass-2026-10-24.md`. |
| 2026-10-24 pass 2 (next 30, re-ranked on the fixed inventory) | 30 in scope (SC 42-9-200, 15-5-100, 56-5-6410, 56-5-3230, 15-3-40, 56-5-3150, 43-35-10, 42-1-560, 50-26-10, 15-3-535, 42-1-160, 56-5-2920, 56-1-460, 42-9-260, 56-5-3110; GA 40-6-305, 40-7-1, 40-6-320, 33-6-34, 34-9-263, 40-6-330, 40-6-93, 34-9-2, 24-4-403, 9-3-72, 40-5-121, 24-8-803, 36-1-4, 40-6-96, 40-13-58), plus supporting. SC from scstatehouse.gov; GA from FindLaw captures current to 2024-03-28 (§ 40-6-320 only to 2021-04-14) and the HB 579 committee substitute. | **39 live errors on 15 documents; 7 of the 30 wrong or mis-cited.** Worst: an **invented Georgia e-scooter rule set** (age 15/16, 20 mph, PTV, bicyclist rights, three feet, sidewalk ban) pinned to § 40-6-320, which covers self-balancing EPAMDs, across 4088 (body, FAQ 0, why-hire), 4224, 4227 and 4229. Golf carts the same way (4090, 4186, 4190): a statewide 25 mph cap, daylight and age 16 that §§ 40-6-330/-331 do not contain. 4478 gave SC driver due care to § 56-5-3150 seven times, with a quote that is not SC text; 1856 cited the white-cane section. The SC three-foot rule was still live on 4639 and 1698. 1837 gave SC a universal abuse-reporting duty. Batch 2 (17 mechanical + F4b, 21 edits on 5 posts) applied the same day; 22 rule rewrites in the attorney packet addendum. Two wrong stored pillar intros (4089, 4090) never render. Record: `data/facts/statute-pass-2-2026-10-24.md`. |
| 2026-10-26 pass 3 (next 30 on the fixed inventory) | 30 in scope (GA 34-9-104, 40-6-123, 40-6-181, 15-19-14, 24-6-601, 44-14-470, 9-11-35, 9-2-41, 20-2-324.1, 24-6-609, 29-3-3, 34-9-202, 34-9-280, 34-9-8, 40-5-35, 40-6-188, 40-6-49, 51-1-11.1, 51-12-11, 52-7-12, 52-7-8.2, 9-3-96; SC 44-7-110, 38-71-190, 42-11-10, 50-21-145, 56-5-1520, 59-63-75, 61-4-580, 62-5-433), plus supporting (SC 50-21-870, 50-21-95, 56-5-1535). SC from scstatehouse.gov; GA from FindLaw captures current to 2024 (§§ 40-6-188 and 40-6-49 only to 2021-04-14) and Justia; § 52-7-8 unreadable. | **29 live errors on 16 documents; 11 of the 30 wrong or mis-cited.** Worst: the concussion pages (4207, 4205) say a coach who breaks the law "is negligent" and that a violation is "automatic proof of negligence", against § 20-2-324.1(e) (the Act creates no liability or cause of action), stretch the Georgia Act to all youth organisations, and call South Carolina's § 59-63-75 identical. Georgia "doubles" work-zone fines on 4162, 4683 and 1799; § 40-6-188 sets $100–$2,000, and SC § 56-5-1535 has not covered work-zone speeding since 2017 Act No. 81. Georgia occupational disease written in SC's statutory words, and hearing loss called an occupational disease (4111). The 120-day IME window misread (1682, 1702). SC boating rules cited to a former no-wake-zone section (3616, 4895) and an under-16 PWC ban plus a "born after 1988" rule that 2023 Act No. 74 replaced (4352). Class re-check of pass 2's invented rules: no new e-scooter or golf-cart survivors; the SC three-foot rule survived only in 4087's common-causes list (and its dormant intro). G1, G2, G6, G9 applied the same day (`bin/fix-statute-pass-3-2026-10-26-sc.php`, owner); 25 more go to the attorneys on the review pages. Record: `data/facts/statute-pass-3-2026-10-26.md`. |

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

**Its non-numeric counterpart, 2026-10-24.** Post 1690 says that under S.C. Code § 42-9-60 the
Commission "may reduce (but not necessarily eliminate)" benefits for a wilful safety-rule
violation. It then lists the elements the employer must prove. The section has two sentences, and
neither mentions safety rules or a reduction. The page states the rule in five places: a body
subsection, two table cells, an OSHA paragraph, FAQ 3 (which is also FAQPage structured data) and
the key takeaways. The SC workers'-comp pillar states the law correctly, so a reader moving
between the two pages gets opposite answers.

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
| `GA 40-6-391(a)` | 3 | 2026-09-21 DUI pass (codes.findlaw.com, current 2024-03-28) — "A person shall not drive or be in actual physical control of **any moving vehicle** while" impaired, (1)–(6) incl. 0.08 within three hours; no definition of "vehicle" in the section, so it reaches mopeds, golf carts and e-bikes without a definitional chain |
| `SC 56-5-2930(A)` | 3 | 2026-09-21 DUI pass (scstatehouse.gov t56c005, by direct download — 696 KB, the fetch tool truncates it) — "unlawful for a person to drive **a motor vehicle** within this State while under the influence" to material and appreciable impairment; reaches mopeds via `§ 56-1-10(26)` ("defined as a motor vehicle") and golf carts via `§ 56-1-10(7)` (every self-propelled vehicle). The chapter's interlock provisions carve out "a moped or motorcycle" by name (2017 Act No. 89 §34), which confirms mopeds are otherwise inside the scheme |
| `SC 56-1-10(7)` | 2 | 2026-09-21 DUI pass — "motor vehicle": every vehicle which is self-propelled, and every vehicle propelled by electric power from overhead trolley wires but not operated upon rails |
| `GA 40-1-1(29)`, `(33)` | 1 | 2026-09-21 e-bike classification pass (codes.findlaw.com) — "motor vehicle": every self-propelled vehicle other than a personal delivery device, an electric assisted bicycle, or an EPAMD, so a **moped is a motor vehicle** in Georgia; "motorcycle": a motor vehicle with a saddle on ≤ 3 wheels, **excluding** a tractor, an ATV and a moped |
| `GA 40-6-350` | 0 | 2026-09-19 moped pass — moped operator has a vehicle driver's rights and duties, except the headlight/taillight rule of § 40-6-312(e) and the windshield/eye-protection rule of § 40-6-315(b) |
| `GA 40-6-351` | 0 | 2026-09-19 moped pass — no operator under 15; a valid driver's licence, instruction permit or limited permit of any class required |
| `GA 40-6-352` | 0 | 2026-09-19 moped pass — every operator AND passenger wears protective headgear meeting the Commissioner of Public Safety's standards; approved motorcycle helmets comply |
| `GA 40-6-353` | 0 | 2026-09-19 moped pass — DOT commissioner or a local authority may prohibit mopeds on roads in its jurisdiction for safety |
| `GA 40-2-20(b)(6)` | 0 | 2026-09-19 moped pass — mopeds exempt from registration |
| `SC 56-1-10(26)` | 0 | 2026-09-19 moped pass — "moped": a cycle "defined as a motor vehicle", ≤ 3 wheels, motor of 50 cc, or electric input over 750 W and not more than 1,500 W |
| `SC 56-1-1720`, `56-1-1730` | 0 | 2026-09-19 moped pass — read first from the 2017 Act No. 89 enrolled text, then verbatim from scstatehouse.gov t56c001 by a direct download (the page is 383 KB; the fetch tool truncates it, `curl` does not) — (A) a valid driver's licence or a moped operator's licence, issued at 15 or older; **(B) a licensed rider under 16 may ride alone in daylight only, and at night only accompanied by a licensed driver 21+ with a year's experience**; (C) 16+ any time; (D) misdemeanor, $100 first offence, $200 after; `1730`: eligibility "without regard to" any other licence's status; DMV may suspend it only for moped violations, on the same grounds as any licence |
| `SC 56-2-3000` | 0 | 2026-09-19 moped pass — carry a valid moped or driver's licence and the moped registration |
| `SC 56-2-3010` | 1 | 2026-09-19 moped pass — mopeds on public highways registered and licensed like passenger vehicles; **not required to be titled or insured**; exempt from property tax |
| `SC 56-2-3020` to `56-2-3060`, `56-2-3080` | 0 | 2026-09-19 moped pass — nonresident 180-day rule; application, title on request, fraud penalties; dealers must sell/rent with operable pedals (if fitted), a mirror, head- and running lights, brake lights; $200 / 30 days |
| `SC 56-2-3070` | 0 | 2026-09-19 moped pass (confirmed the helmet pass) — (A) ride astride a permanent seat; (B) farthest right lane on multilane highways; (C) under 21 wears a § 56-5-3660 helmet; (D) no faster than 35 mph; (E) not on highways posted above 55 mph; (F) headlight and lights on at all times; (G) misdemeanor, $200 / 30 days |
| `SC 38-77-30` | 0 | 2026-09-19 moped pass (Act 89 text) — mopeds are motor vehicles for uninsured/underinsured motorist coverage purposes only |
| `SC 56-1-10` (low speed vehicle) | 0 | 2026-09-19 golf-cart pass (SC writer, scstatehouse.gov t56c001; owner sign-off) — four-wheeled motor vehicle, more than 20 and not more than 25 mph in one mile, GVWR under 3,000 lb |
| `SC 56-2-120` | 0 | 2026-09-19 golf-cart pass (t56c002) — (A) LSVs titled; the State issues no VIN to homemade LSVs or **retrofitted golf carts**, which do not qualify as LSVs; (C) registered, licensed and insured like passenger vehicles |
| `SC 38-77-140(A)` | 0 | 2026-09-19 golf-cart pass (t38c077) — minimum automobile liability limits $25,000 / $50,000 / $25,000; referenced by § 56-2-90(B)(2) |
| `SC 56-2-100` | 6 | 2026-09-19 golf-cart pass — LOW-SPEED VEHICLES, not golf carts: operation only on ≤ 35 mph highways, may cross faster highways at intersections, FMVSS 500 equipment, local and DOT prohibitions permitted, farm vehicles excluded. The six pages citing it for golf carts miscite. |
| `GA 51-12-1.1` | 8 | pass 2026-10-24 (SB 68 § 7, as passed; applies to causes of action arising on or after 2025-04-21, § 9(b)). (b) medical specials limited to the reasonable value of medically necessary care; (c) evidence of both the amounts charged and the amounts needed to satisfy them under any health insurance, used or not; (d) LOP, itemized charges, factoring buyer and price, referral source discoverable; (e) collateral source rule abrogated to the extent necessary; (f) either side may challenge reasonableness. Site correct on all 8 pages. |
| `GA 34-9-17` | 8 (9 with an FAQ the inventory misses) | pass 2026-10-24 (FindLaw, current 2024-03-28). (a) willful misconduct, self-inflicted injury, attempt to injure another, willful refusal to use a safety appliance or perform a statutory duty; (b) intoxication, with rebuttable presumptions at 0.08 within 3 hours, any marijuana or controlled substance within 8 hours, and test refusal (§ 34-9-415); (c) burden on the party claiming the exemption. **No retaliation provision.** Wrong on 1662, 1690, 1693, 1695. |
| `SC 38-59-40` | 7 | pass 2026-10-24 (t38c059). Refusal to pay within 90 days of the policyholder's demand, found without reasonable cause or in bad faith, gives reasonable attorneys' fees, capped at one-third of the judgment; Tyger River unaffected. HISTORY 1987/1989/1999. Correct. |
| `SC 56-5-6160` | 7 | pass 2026-10-24 (t56c005). "No evidence of conviction … for any violation of this chapter shall be admissible … in any civil action." Correct; pages that bind the *ticket* to it are imprecise. The guilty-plea admission rests on Samuel v. Mouzon (not read). |
| `GA 34-9-200.1` | 7 | pass 2026-10-24. (a) employer furnishes rehabilitation for a catastrophic injury; (g)(1)–(6) definition, **including (6) any injury preventing prior work and any work available in substantial numbers**; (6)(B) retirement-age presumption. Says nothing about benefit duration (§ 34-9-261). Mis-cited on 1666; definition wrong on 1677. |
| `GA 9-3-73` | 6 | pass 2026-10-24. Child under five: two years from the fifth birthday (limitation), never after the tenth birthday (repose); five and older: ordinary periods, five-year repose; foreign objects under § 9-3-72. Wrong on 1676, 1696 FAQ, 4195. |
| `GA 34-9-200` | 6 | pass 2026-10-24. (a)(1) pre-2013-07-01 and catastrophic injuries: physician-prescribed care reasonably required, no time limit; **(a)(2) post-2013-07-01 non-catastrophic: maximum 400 weeks from injury**; (a)(3) prosthetic/stimulator/pump/DME exemptions. Wrong on 1677 (and 5354, uncited); misquoted on 1674 and 1752. |
| `GA 51-4-5` | 5 | pass 2026-10-24. (a) administrator sues when no one can under §§ 51-4-2 or 51-4-4 (full value of life); (b) personal representative recovers funeral, medical and other necessary expenses. **No limitation period**: 4360 mis-cites it for the 2-year wrongful-death deadline. |
| `GA 9-3-90` | 5 (6) | pass 2026-10-24. (a) incompetents (intellectual disability or mental illness at accrual): same time after removal; (b) under-18s: same time after 18, except § 9-3-33.1. Correct. |
| `GA 51-1-29.5` | 5 | pass 2026-10-24 (FindLaw, current 2024-01-01). (c) emergency medical care in an ED or obstetrical unit, or a surgical suite right after ED care: gross negligence by clear and convincing evidence; (a)(5) ends at stabilization; (d) jury instructions. Correct where cited; contradicted uncited on 4197. |
| `GA 9-10-184` | 5 | pass 2026-10-24 (SB 68 § 1; applies to pending cases). Noneconomic value may be argued only after the close of evidence at the first damages argument, rationally related to the evidence; concluding argument cannot change the figure; "enlightened conscience of an impartial jury". Correct. |
| `SC 38-59-20` | 5 (6) | pass 2026-10-24. Eight improper claim practices, actionable when frequent enough to be a general business practice; third-party liability claims expressly included; director enforces (§ 38-59-30). Correct. |
| `SC 56-5-1290` | 5 | pass 2026-10-24. Reports required by §§ 56-5-1260 to -1280 (including the officer's report under -1270) are not evidence of negligence or due care at trial; officers may refresh recollection. Correct. |
| `SC 15-78-60` | 5 | pass 2026-10-24. 40 exceptions; (4) laws, (5) discretion, (12) licensing (except gross negligence), (15) signs/signals after actual or constructive notice and no liability for highway design, (25) custody (except gross negligence). HISTORY through 2005 Act No. 137. Correct. |
| `GA 24-7-702` | 5 | pass 2026-10-24. (b) Daubert-style reliability test; (c) malpractice experts: licensed, same profession, 3 of the last 5 years in practice or teaching of the specialty; (f) Daubert/Joiner/Kumho; (g) not strict in workers' comp. One misstatement (1718 KT: "requires expert testimony"). |
| `GA 40-6-294` | 5 | pass 2026-10-24. Ride near the right except when turning left, avoiding hazards, the lane is too narrow, at traffic speed, passing, or a right-turn-only lane; two abreast; bike paths; ride with traffic in a bike lane. **Grants no "same rights"**: that is `§ 40-6-291`. Mis-cited on 4087, 4171, 4172, 4173, 4178. |
| `GA 31-8-1` | 5 | pass 2026-10-24. Hospital Care for the Indigent Program (Department of Community Health). **Not a licensing act**: nursing homes are institutions under § 31-7-1 et seq.; the residents' bill of rights is § 31-8-100 et seq. Mis-cited on 4163, 4164, 4165, 4170; imprecise on 4166. |
| `GA 4-8-20` | 5 | pass 2026-10-24. Short title only, "Responsible Dog Ownership Law". The substance is in § 4-8-21 (definitions) and § 4-8-27 (registration; $50,000 insurance for **vicious** dogs only). Wrong on 4117, 4119, 4120. |
| `GA 34-9-11.1` | 5 | pass 2026-10-24 (Justia 2023 edition). (b) lien limited to disability, death and medical benefits paid, recoverable only if the employee is fully and completely compensated; (c) carrier may sue after one year from injury; (d) fee apportionment. Correct. |
| `GA 9-11-67.1` | 5 (6) | pass 2026-10-24 (Justia; history "2024 Ga. Laws 415, § 1, **eff. 4/22/2024**, app. to offers made on or after 4/22/2024"). From accrual until answer; attorney-prepared motor-vehicle offers; 30 days to accept, 40 to pay; material terms; enclosed records; (i) safe harbor; product liability excluded. Error on 1722 (dated July 1, 2024). |
| `GA 31-7-1` | 1 | pass 2026-10-24, supporting. Definitions: "institution" includes a facility classified as a hospital, nursing home, **assisted living community**, or personal care home (separately). |
| `SC 38-59-30` | 1 | pass 2026-10-24, supporting. The director, after notice and hearing, orders cease and desist and may impose a § 38-2-10 penalty for § 38-59-20 practices. |
| `SC 41-1-80` | 2 | pass 2026-10-24, supporting. No discharge or demotion for instituting a workers'-comp proceeding in good faith or testifying; lost wages and reinstatement; burden on the employee; listed affirmative defenses; one-year limitation. HISTORY 1986 Act No. 451. |
| `GA 40-6-291`, `GA 4-8-21`, `GA 4-8-27`, `GA 31-8-100`, `GA 31-8-108`, `SC 56-5-1280` | 0 | pass 2026-10-24, ahead of first use (they are the corrections' authorities in the pass record). § 40-6-291(a): the chapter's vehicle provisions apply to bicycles; § 4-8-21 / § 4-8-27 as above; § 31-8-100 short title; § 31-8-108 care "adequate and appropriate", "with reasonable care and skill", right to refuse medications; § 56-5-1280 reports by an occupant or owner when the driver cannot. |
| `SC 42-9-200` | 5 | pass 2 2026-10-24 (scstatehouse.gov). No compensation for the first 7 days; payable from day one if the disability exceeds 14 days. Medical benefits are not subject to the wait (§ 42-15-60). |
| `SC 15-5-100` | 5 | pass 2 2026-10-24 (scstatehouse.gov). Funeral expenses may be recovered in only one of the two actions. |
| `SC 56-5-6410` | 4 | pass 2 2026-10-24 (scstatehouse.gov). Rear-facing under 2 until the child outgrows the seat; then a forward-facing harness; a booster from age 4; the adult belt at age 8 or 57 inches, subject to the fit test. |
| `SC 56-5-3230` | 5 | pass 2 2026-10-24 (scstatehouse.gov). "every driver of a vehicle shall exercise due care to avoid colliding with any pedestrian or any person propelling a human-powered vehicle and shall give an audible signal when necessary and shall exercise proper precaution upon observing any child or any … |
| `SC 15-3-40` | 4 | pass 2 2026-10-24 (scstatehouse.gov). A minor gets the later of one year after turning 18 or the ordinary period. The insanity extension is capped at 5 years, and at 1 year after the disability ends. |
| `SC 56-5-3150` | 3 | pass 2 2026-10-24 (scstatehouse.gov). (a) A pedestrian crossing outside a marked crosswalk, or outside an unmarked crosswalk at an intersection, "shall yield the right-of-way to all vehicles upon the roadway."; (c) "Between adjacent intersections at which traffic-control signals are in … **Mis-stated or mis-cited on the site: F4–F16.** |
| `SC 43-35-10` | 4 | pass 2 2026-10-24 (scstatehouse.gov). § 43-35-10 holds the definitions. HISTORY shows a 2026 Act No. 146 amendment (eff 2026-05-15) that renames agencies only.; § 43-35-85 makes abuse, neglect and exploitation crimes.; § 43-35-25(A) limits the reporting duty. Listed professionals and facility … **Mis-stated or mis-cited on the site: F1–F3.** |
| `SC 42-1-560` | 4 | pass 2 2026-10-24 (scstatehouse.gov). The employee has one year after acceptance or award to sue. After that, the action is assigned to the carrier on 20 days' notice. 30 days' notice of suit is required. The lien is net of fees, and (f) lets the Commission reduce it. |
| `SC 50-26-10` | 4 | pass 2 2026-10-24 (scstatehouse.gov). § 50-26-10 is the short title only.; The chapter (§§ 50-26-20 to -70) supplies the rules: no operation under age 6; helmet and safety certificate through age 15; and (§ 50-26-30(B)) a parent may not let an unlicensed rider under 16 carry a passenger. |
| `SC 15-3-535` | 3 | pass 2 2026-10-24 (scstatehouse.gov). Discovery rule. t15c003.php |
| `SC 42-1-160` | 3 | pass 2 2026-10-24 (scstatehouse.gov). Injury by accident, including the stress and mental-injury provisions. t42c001.php |
| `SC 56-5-2920` | 3 | pass 2 2026-10-24 (scstatehouse.gov). $25–$200 or 30 days. A second offense within 5 years carries a 3-month suspension. |
| `SC 56-1-460` | 3 | pass 2 2026-10-24 (scstatehouse.gov). Driving under suspension. t56c001.php |
| `SC 42-9-260` | 3 | pass 2 2026-10-24 (scstatehouse.gov). Termination or suspension of compensation. t42c009.php |
| `SC 56-5-3110` | 3 | pass 2 2026-10-24 (scstatehouse.gov). Pedestrians subject to traffic-control signals. t56c005.php |
| `GA 40-6-305` | 5 | pass 2 2026-10-24 (legis.ga.gov HB 579 committee substitute). A farmer 16 or older may operate a farm use vehicle (ATV or PTV) on a public road. The vehicle must display the § 40-8-4 slow-moving-vehicle emblem, and the trip must carry farm products or run between the farmer's residence and farm.; § 40-6-306 gives … |
| `GA 40-7-1` | 5 | pass 2 2026-10-24 (FindLaw, current to 2024). § 40-7-4 bars operation without operative brakes or mufflers, on private property without the owner's express written permission, and within perennial streams. It sets no age rule.; § 40-7-5 lets localities regulate time periods and zones of use.; § 40-7-3 … |
| `GA 40-6-320` | 4 | pass 2 2026-10-24 (FindLaw via Internet Archive, current 2021-04-14). EPAMDs may use highways and sidewalks, keeping a 48-inch clear path.; They may use a roadway only where the limit is 35 mph or less or there is a striped bicycle lane, and must travel in the direction of traffic.; § 40-6-321 requires due care toward … **Mis-stated or mis-cited on the site: F24–F32.** |
| `GA 33-6-34` | 4 | pass 2 2026-10-24 (FindLaw, current to 2024). Unfair claims settlement practices. IA capture, current as of 2024-03-28. |
| `GA 34-9-263` | 4 | pass 2 2026-10-24 (FindLaw, current to 2024). (b)(1): PPD is payable "without regard to whether the employee has suffered economic loss."; (b)(2): PPD is not paid while §§ 34-9-261 or -262 benefits are payable.; (c) schedule: hand 160 weeks, foot 135, eye 150, one ear 75, arm and leg 225, **body as a … **Mis-stated or mis-cited on the site: F22.** |
| `GA 40-6-330` | 2 | pass 2 2026-10-24 (FindLaw, current to 2024). "Any local authority desiring to establish operating standards for personal transportation vehicles shall comply with Part 6 of this article."; § 40-6-331(a): a local ordinance designates the streets and "establish[es] the conditions under which PTVs may … **Mis-stated or mis-cited on the site: F33–F39.** |
| `GA 40-6-93` | 3 | pass 2 2026-10-24 (FindLaw, current to 2024). Pedestrian due care / driver due care. Pending pack authority. IA capture, current as of 2024-03-28. |
| `GA 34-9-2` | 3 | pass 2 2026-10-24 (FindLaw, current to 2024). The Act does not apply "to farm laborers or domestic servants; nor to employers of such employees," nor to employers with fewer than three employees. **Mis-stated or mis-cited on the site: F21.** |
| `GA 24-4-403` | 3 | pass 2 2026-10-24 (FindLaw, current to 2024). Exclusion of relevant evidence. Current as of 2024-03-28. |
| `GA 9-3-72` | 3 | pass 2 2026-10-24 (FindLaw, current to 2024). Foreign objects in medical malpractice: one year from discovery. Excludes chemical compounds, fixation devices and prosthetics. |
| `GA 40-5-121` | 3 | pass 2 2026-10-24 (FindLaw, current to 2024). Driving while license suspended. Current as of 2024-01-01. |
| `GA 24-8-803` | 3 | pass 2 2026-10-24 (FindLaw, current to 2024). Hearsay exceptions. Current as of 2024-01-01. |
| `GA 36-1-4` | 3 | pass 2 2026-10-24 (FindLaw, current to 2024). County immunity. "A county is not liable to suit for any cause of action unless made so by statute." |
| `GA 40-6-96` | 3 | pass 2 2026-10-24 (FindLaw, current to 2024). Use the sidewalk where there is one. Otherwise use the shoulder. Walk on the left of a two-way roadway only where there is neither sidewalk nor shoulder. (b) has a 1,000-foot exception. |
| `GA 40-13-58` | 3 | pass 2 2026-10-24 (FindLaw, current to 2024). Posting a cash bond and failing to appear "shall be construed as an admission of guilt." **Mis-stated or mis-cited on the site: F23.** |
| `SC 56-5-500`, `SC 56-5-970`, `SC 56-5-3130`, `SC 56-5-3140`, `SC 56-5-3160`, `SC 56-5-3190`, `SC 15-3-30`, `SC 15-3-50`, `SC 42-1-360`, `SC 43-35-25`, `SC 43-35-85`, `SC 50-26-20`, `SC 50-26-30`, `SC 50-26-40`, `SC 50-26-50`, `SC 50-26-60`, `SC 50-26-70`, `GA 40-6-330.1`, `GA 40-6-331`, `GA 40-6-321`, `GA 40-1-1`, `GA 40-7-3`, `GA 40-7-4`, `GA 40-7-5`, `GA 40-6-306`, `GA 40-6-307` | 27 across 12 cited | pass 2 2026-10-24, supporting (scstatehouse.gov t56c005, t15c003, t42c001, t43c035, t50c026; GA from FindLaw captures current to 2024, §§ 40-6-306/-307 from the HB 579 committee substitute). § 56-5-500 and §§ 56-5-3130/-3160/-3190 re-read by the strategist on scstatehouse.gov for batch 2. |

### Verified via pack authority (reconciled 2026-10-24)

These sections are authority ids in the law packs and count as verified above, but were never
recorded in this file. They are on the inventory basis, as of 2026-10-24. The date is the pack's
`verifiedAt`. GA entries are unsigned for Roden.

| Statute | Pages | Pack `verifiedAt` — subject |
|---|---:|---|
| `SC 15-36-100` | 11 | 2026-09-28 — expert affidavit in professional negligence actions |
| `SC 15-51-40` | 11 | 2026-09-28 — wrongful death damages and distribution |
| `GA 40-6-273` | 9 | 2026-10-20 — duty to report a crash to police |
| `GA 33-4-6` | 8 | 2026-10-20 — first-party insurer bad-faith penalty |
| `SC 42-9-60` | 8 | 2026-09-26 — intoxication and wilful-intent defense (re-read 2026-10-24) |
| `GA 9-3-32` | 7 | 2026-09-10 — property damage limitation |
| `SC 56-5-1260` | 7 | 2026-09-26 — report an injury or death crash to police (re-read 2026-10-24) |
| `SC 56-5-1270` | 7 | 2026-09-26 — written report to DMV when no officer investigated (re-read 2026-10-24) |
| `SC 33-56-180` | 5 | 2026-09-26 — charitable organization liability cap |
| `GA 51-11-7` | 4 | 2026-08-25 — avoidance doctrine |
| `GA 40-6-92` | 4 | 2026-08-25 — pedestrian crossing outside a crosswalk |
| `SC 15-32-230` | 4 | 2026-09-28 — emergency care: physician liable only for gross negligence (re-read 2026-10-24) |
| `SC 42-1-540` | 4 | 2026-09-26 — workers' comp exclusive remedy |
| `GA 34-9-11` | 4 | 2026-10-20 — workers' comp exclusive remedy |
| `SC 56-5-2933` | 3 | 2026-09-03 — DUAC per se |
| `GA 40-6-241` | 2 | 2026-07-15 — Hands-Free Georgia Act |
| `GA 40-5-142` | 2 | 2026-07-27 — CDL threshold |
| `SC 56-5-1535` | 2 | 2026-09-29 — endangerment of a highway worker |
| `SC 56-5-3640` | 2 | 2026-09-28 — motorcycle lane use |
| `GA 50-21-29` | 2 | 2026-10-20 — Georgia Tort Claims Act damages cap |
| `SC 56-5-1895` | 1 | 2026-09-29 — no passing in work zones |
| `SC 15-78-30` | 1 | 2026-09-29 — Tort Claims Act definitions |
| `GA 15-10-2` | 1 | 2026-10-20 — magistrate court jurisdiction |
| `SC 22-3-10` | 1 | 2026-09-26 — magistrate court jurisdiction |
| `SC 42-1-410` | 1 | 2026-09-28 — statutory employer |
| `GA 34-9-104` | 3 | 2026-10-26 pass 3 |
| `GA 40-6-123` | 3 | 2026-10-26 pass 3 |
| `GA 40-6-181` | 3 | 2026-10-26 pass 3 |
| `SC 44-7-110` | 3 | 2026-10-26 pass 3 |
| `GA 15-19-14` | 2 | 2026-10-26 pass 3 |
| `GA 24-6-601` | 2 | 2026-10-26 pass 3 |
| `GA 44-14-470` | 2 | 2026-10-26 pass 3 |
| `GA 9-11-35` | 2 | 2026-10-26 pass 3 |
| `GA 9-2-41` | 2 | 2026-10-26 pass 3 |
| `GA 20-2-324.1` | 2 | 2026-10-26 pass 3 |
| `GA 24-6-609` | 2 | 2026-10-26 pass 3 |
| `GA 29-3-3` | 2 | 2026-10-26 pass 3 |
| `GA 34-9-202` | 2 | 2026-10-26 pass 3 |
| `GA 34-9-280` | 2 | 2026-10-26 pass 3 |
| `GA 34-9-8` | 2 | 2026-10-26 pass 3 |
| `GA 40-5-35` | 2 | 2026-10-26 pass 3 |
| `GA 40-6-188` | 2 | 2026-10-26 pass 3 |
| `GA 40-6-49` | 2 | 2026-10-26 pass 3 |
| `GA 51-1-11.1` | 2 | 2026-10-26 pass 3 |
| `GA 51-12-11` | 2 | 2026-10-26 pass 3 |
| `GA 52-7-12` | 2 | 2026-10-26 pass 3 |
| `GA 52-7-8.2` | 2 | 2026-10-26 pass 3 |
| `GA 9-3-96` | 2 | 2026-10-26 pass 3 |
| `SC 38-71-190` | 2 | 2026-10-26 pass 3 |
| `SC 42-11-10` | 2 | 2026-10-26 pass 3 |
| `SC 50-21-145` | 2 | 2026-10-26 pass 3 |
| `SC 56-5-1520` | 2 | 2026-10-26 pass 3 |
| `SC 59-63-75` | 2 | 2026-10-26 pass 3 |
| `SC 61-4-580` | 2 | 2026-10-26 pass 3 |
| `SC 62-5-433` | 2 | 2026-10-26 pass 3 |

## Not yet verified — top 30 by exposure

**Read in pass 3 (2026-10-26)** and now listed under Verified; kept here as the record of what
pass 3 covered. The next 30 come from a fresh run of `bin/inventory-statute-citations.php`.

Rebuilt 2026-10-24 after pass 2 and batch 2, from `data/facts/statute-inventory-2026-10-24-batch2.txt`
(the fixed inventory: FAQ, key takeaways and pillar meta included). Excluded: every section in
## Verified and every verified pack authority. Ordered by pages, then by surface weight (FAQ, key
takeaways, why-hire, excerpt and meta description render into structured data or above the fold).

The exposure curve has flattened: after pass 2 only four unverified sections sit on three pages,
and none on more. The rest of the list is a two-page tail.

| Statute | Pages | Surfaces |
|---|---:|---|
| `GA 34-9-104` | 3 | body |
| `GA 40-6-123` | 3 | body |
| `GA 40-6-181` | 3 | body |
| `SC 44-7-110` | 3 | body |
| `GA 15-19-14` | 2 | body, FAQ, KT |
| `GA 24-6-601` | 2 | body, FAQ, KT |
| `GA 44-14-470` | 2 | body, FAQ, KT |
| `GA 9-11-35` | 2 | body, FAQ, KT |
| `GA 9-2-41` | 2 | body, FAQ, KT |
| `GA 20-2-324.1` | 2 | body, FAQ |
| `GA 24-6-609` | 2 | body, FAQ |
| `GA 29-3-3` | 2 | body, FAQ |
| `GA 34-9-202` | 2 | body, FAQ |
| `GA 34-9-280` | 2 | body, FAQ |
| `GA 34-9-8` | 2 | pillar intro (dormant), body, FAQ |
| `GA 40-5-35` | 2 | body, KT |
| `GA 40-6-188` | 2 | body, FAQ |
| `GA 40-6-49` | 2 | body, FAQ |
| `GA 51-1-11.1` | 2 | body, KT |
| `GA 51-12-11` | 2 | body, FAQ |
| `GA 52-7-12` | 2 | body, FAQ, pillar intro (dormant) |
| `GA 52-7-8.2` | 2 | FAQ |
| `GA 9-3-96` | 2 | body, FAQ |
| `SC 38-71-190` | 2 | body, FAQ |
| `SC 42-11-10` | 2 | body, FAQ |
| `SC 50-21-145` | 2 | FAQ |
| `SC 56-5-1520` | 2 | body, KT |
| `SC 59-63-75` | 2 | body, FAQ |
| `SC 61-4-580` | 2 | body, FAQ |
| `SC 62-5-433` | 2 | body, FAQ |

…then 24 more at two pages and 163 at one. Regenerate with `bin/inventory-statute-citations.php`.

**Next pass (pass 3):** the 30 above. At this exposure a 30-section pass covers 64 page-citations, about 2.4 percentage points of
coverage, so pass 3 should also re-read the claim classes pass 2 found invented (e-scooter,
golf-cart, three-foot passing) in any new content before it is weighed against more tail sections.

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

**The inventory cannot see FAQ citations written with "§"** (found 2026-10-24).
`wp_json_encode()` escapes the character to `\u00a7` before the regex runs. On today's export
that hides 304 page-citations and 14 statutes, most of them in FAQ answers, which are also
FAQPage structured data. `GA 34-9-17`, `GA 9-3-90`, `SC 38-59-20` and `GA 9-11-67.1` each sit on
one more page than the inventory reports. Until the script passes `JSON_UNESCAPED_UNICODE` and
strips tags before matching, treat its FAQ column as a floor, not a count.

**A verified section is not a correct page.** Ten of this pass's twenty sections read exactly as
the tracker would want, yet the claim class around them was wrong elsewhere. Examples:
- § 51-1-29.5 was correct where cited and contradicted, uncited, on the ER sub-type page.
- § 15-32-230 is a signed pack authority, and the SC cell of two comparison tables still says
  "ordinary". Verification closes the citation; only the class sweep closes the claim.

**SC Bill 280 (2025-2026), "Safety belts, evidence admissibility in civil action"**,
is pending. `SC 56-5-6540(C)` currently makes a seat-belt violation inadmissible in a
civil action, and eight pages rely on that. Georgia's equivalent rule reversed in 2025
and went unpropagated here for sixteen months (#97). If Bill 280 passes, sweep those
eight pages the same week.
