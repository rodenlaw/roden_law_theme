# Statute verification, pass 2: the next 30 — 2026-10-24

**Read-only pass.** Nothing on production, the law packs, the fixtures or the tracker was changed.
Every finding below is a proposal. None has been applied.

**Attorney status.**
- Georgia findings go to **Tyler Love**. The GA pack is still unsigned for Roden, so every GA
  correction here needs his sign-off before it is applied.
- South Carolina findings go to **Graeham C. Gillin**. He has signed the SC pack, but corrections
  marked RULE REWRITE still need his read.

**Numbering.** Findings are numbered F1–F39 so they do not collide with pass 1's E1–E58
(`data/facts/statute-pass-2026-10-24.md`).

## Summary

| | Count |
|---|---|
| Sections read (top 30 by the rebuilt ranking) | 30 (15 SC, 15 GA) |
| Correct as the site uses them | 23 |
| Wrong or mis-cited somewhere on the site | 7 — GA 40-6-320, GA 40-6-330, GA 34-9-263, GA 34-9-2, GA 40-13-58, SC 56-5-3150, SC 43-35-10 et seq. |
| Repealed or renumbered | 0 |
| Live errors (F1–F39) | 39 on 15 documents |
| MECHANICAL / RULE REWRITE | 17 / 22 |
| Surviving SC three-foot passing claims (found by the class sweep, not tied to a ranked section) | 3, on 4639 (×2) and 1698 |
| Dormant errors (stored but not rendered) | 2 — see "Dormant" |

**Worst finding.** The Georgia e-scooter rule set is invented and pinned to the wrong statute
across the whole e-scooter cluster (F24–F32):
- The rules: a minimum rider age of 15 (16 for rentals), a 20 mph cap, a "personal transportation
  vehicle" classification, bicyclist-equivalent rights, and a three-foot passing rule.
- The statute it is pinned to: O.C.G.A. § 40-6-320. That section governs **electric personal
  assistive mobility devices**, which § 40-1-1(15.4) defines as *self-balancing, two-wheeled*
  devices. It does not cover stand-up scooters.
- The PTV definition, § 40-1-1(43.4), expressly excludes scooters.
- No Georgia statute covering stand-up e-scooters appears in the Code as read.
- Where it appears: the pillar body, FAQ 0 (which also becomes FAQPage schema), the rendered
  `_roden_why_hire` block, and three sub-type pages.

The Georgia golf-cart cluster (F33–F39) is the same failure: a 25 mph cap, a daylight-only rule and
an age-16 rule that § 40-6-330 does not contain.

## Sources

- **SC:** scstatehouse.gov chapter pages, fetched directly (HTTP 200) on 2026-10-24. The URLs are
  per-chapter, for example `https://www.scstatehouse.gov/code/t56c005.php`. Each section's HISTORY
  line was read.
- **GA:** codes.findlaw.com returns 403 to direct fetch. Two routes worked:
  - Internet Archive `id_` captures of FindLaw, which state their currency: "current as of
    March 28, 2024" for most, "January 01, 2024" for § 24-8-803 and § 40-5-121, and **"April 14,
    2021" for § 40-6-320 and § 40-6-330.1**.
  - Live codes.findlaw.com read through the fetch tool, which returns only short quotes. Used for
    § 40-7-1, § 40-7-4 and § 40-7-5, current as of 2024-03-28.
  - **Currency caveat for Tyler.** Nothing here reflects the 2024–2026 sessions. In particular, a
    2024–2026 act could have added an e-scooter or golf-cart rule that this pass cannot see. Check
    the 2024–2026 session laws before rewriting F24–F39.
- **GA § 40-6-305 / -306 / -307** (farm use vehicles, 2016 HB 579): FindLaw 404s on both. Read from
  the legis.ga.gov HB 579 committee substitute (LC 40 1119S). That is not the enrolled text, so
  Tyler should confirm it.
- **Site text:**
  - `data/content-cache/wp-export.json`: `post_content`, `post_excerpt`, `_roden_faqs`,
    `_roden_key_takeaways`.
  - `content/meta.json`: pillar meta.
  - Live pages fetched with a cache-busting `?nc=` parameter: the ATV, pedestrian, e-scooter and
    golf-cart pillars (EN), plus the ES ATV and pedestrian pillars.

## Re-rank note

The ranking was rebuilt from `data/facts/statute-inventory-2026-10-24-postfix.txt`.
- **Excluded:** tracker-verified sections, pack authorities and the 20 sections pass 1 read.
  Pending pack authorities stay **in**; SC 15-3-40 and GA 40-6-93 are pending.
- **Order:** pages, then surface weight (an FAQ or key-takeaways hit outweighs a body hit).

**Moved in** compared with the tracker's old list. Each now ranks higher, mostly because the old
inventory did not see FAQ, key-takeaways or pillar-meta hits:

| Section | Old pages | Now | Why |
|---|---|---|---|
| SC 56-5-6410 | 2 | 4 | 3 pages carry it in FAQ/KT |
| SC 15-3-535 | 2 | 3 | 3 FAQ/KT pages |
| GA 40-6-93 | 2 | 3 | 3 FAQ/KT pages |
| GA 34-9-2 | 2 | 3 | 2 FAQ/KT pages |
| SC 56-5-3110 | 2 | 3 | Pillar meta (`_roden_pillar_negligence_intro`) |

GA 40-6-305 also rose, from 4 pages to 5, but it was already on the list.

**Moved out:** GA 40-6-181, SC 44-7-110, GA 40-6-123 and GA 34-9-104.
- Each is still on 3 pages, but body only, so the surface weight ranks them below the 3-page
  sections above.
- They are ranks 31–34 and are next in line for pass 3.

**Final top 30, in rank order:**
1. SC 42-9-200
2. SC 15-5-100
3. GA 40-6-305
4. GA 40-7-1
5. GA 40-6-320
6. SC 56-5-6410
7. SC 56-5-3230
8. GA 33-6-34
9. SC 15-3-40
10. SC 43-35-10
11. GA 34-9-263
12. SC 56-5-3150
13. SC 42-1-560
14. SC 50-26-10
15. GA 40-6-330
16. SC 15-3-535
17. GA 40-6-93
18. GA 34-9-2
19. GA 24-4-403
20. SC 42-1-160
21. GA 9-3-72
22. GA 40-5-121
23. SC 56-5-2920
24. GA 24-8-803
25. SC 56-1-460
26. GA 36-1-4
27. GA 40-6-96
28. GA 40-13-58
29. SC 42-9-260
30. SC 56-5-3110

## Per statute

### South Carolina

**1. SC 42-9-200** — Waiting period. https://www.scstatehouse.gov/code/t42c009.php
- **Statute:** No compensation for the first 7 days; payable from day one if the disability
  exceeds 14 days. Medical benefits are not subject to the wait (§ 42-15-60).
- **Site:** 5 pages state it the same way.
- **Verdict:** CORRECT.

**2. SC 15-5-100** — Funeral expenses in survival and wrongful-death actions. t15c005.php
- **Statute:** Funeral expenses may be recovered in only one of the two actions.
- **Verdict:** CORRECT on all 5 pages.

**3. SC 56-5-6410** — Child restraints. t56c005.php (rewritten by 2017 Act No. 78)
- **Statute:** Rear-facing under 2 until the child outgrows the seat; then a forward-facing
  harness; a booster from age 4; the adult belt at age 8 or 57 inches, subject to the fit test.
- **Verdict:** CORRECT on all 4 pages.

**4. SC 56-5-3230** — Driver to exercise due care. t56c005.php
- **Statute:** "every driver of a vehicle shall exercise due care to avoid colliding with any
  pedestrian or any person propelling a human-powered vehicle and shall give an audible signal when
  necessary and shall exercise proper precaution upon observing any child or any obviously
  confused, incapacitated or intoxicated person"
- **Site:** Correct where cited, on 1767, 4357, 4368 and 4639.
- **Verdict:** CORRECT. Post 4478 attributes this rule to § 56-5-3150 instead; see section 6.

**5. SC 15-3-40** — Disabilities: minors and insanity. t15c003.php. Pending pack authority.
- **Statute:** A minor gets the later of one year after turning 18 or the ordinary period. The
  insanity extension is capped at 5 years, and at 1 year after the disability ends.
- **Also read:** §§ 15-3-30 and 15-3-50, as cited alongside it.
- **Verdict:** CORRECT.

**6. SC 56-5-3150** — Crossing at other than crosswalks. t56c005.php
- **Statute:**
  - (a) A pedestrian crossing outside a marked crosswalk, or outside an unmarked crosswalk at an
    intersection, "shall yield the right-of-way to all vehicles upon the roadway."
  - (c) "Between adjacent intersections at which traffic-control signals are in operation
    pedestrians shall not cross at any place except in a marked crosswalk."
  - The section imposes no driver duty.
- **Site:**
  - 4478 uses § 56-5-3150 as the driver due-care section, and quotes UVC-style text that is not
    South Carolina law.
  - 4478 then gives the real § 56-5-3150 rules to § 56-5-3140, which is in fact "Pedestrian shall
    use right half of crosswalk."
  - 1856 cites § 56-5-3150 for the § 56-5-3130(b) curb rule.
- **Verdict:** **MIS-CITED.** F4–F15.

**7. SC 43-35-10 et seq.** — Omnibus Adult Protection Act. t43c035.php
- **Statute:**
  - § 43-35-10 holds the definitions. HISTORY shows a 2026 Act No. 146 amendment (eff 2026-05-15)
    that renames agencies only.
  - § 43-35-85 makes abuse, neglect and exploitation crimes.
  - § 43-35-25(A) limits the reporting duty. Listed professionals and facility staff "having
    reason to believe" must report. "Any other person who has actual knowledge" must report.
    (B): anyone else "may report."
- **Site:** 1837 says anyone who suspects, or has reason to believe, must report.
- **Verdict:** **WRONG on the reporting duty.** F1–F3. The criminal-exploitation statement in FAQ 3
  is correct.

**8. SC 42-1-560** — Third-party actions. t42c001.php
- **Statute:** The employee has one year after acceptance or award to sue. After that, the action
  is assigned to the carrier on 20 days' notice. 30 days' notice of suit is required. The lien is
  net of fees, and (f) lets the Commission reduce it.
- **Verdict:** CORRECT on 4 pages.

**9. SC 50-26-10** — Chandler's Law (2011 Act No. 24). t50c026.php
- **Statute:**
  - § 50-26-10 is the short title only.
  - The chapter (§§ 50-26-20 to -70) supplies the rules: no operation under age 6; helmet and
    safety certificate through age 15; and (§ 50-26-30(B)) a parent may not let an unlicensed rider
    under 16 carry a passenger.
- **Verdict:** CORRECT on 4182.
- **Imprecision on 4179 and 4089:** "SC law restricts ATV operation on public roads" is not in
  Chapter 26, which governs lands open to the public. Optional fix: cite § 56-3-110 there or drop
  the citation.

**10. SC 15-3-535** — Discovery rule. t15c003.php
- **Verdict:** CORRECT on 3 pages.

**11. SC 42-1-160** — Injury by accident, including the stress and mental-injury provisions.
t42c001.php
- **Verdict:** CORRECT.
- **Imprecision on 1650 FAQ 5:** It says to "prove with medical evidence that the event was
  extraordinary." Under the statute, medical evidence proves causation; the extraordinary
  conditions are proved by the facts. Optional fix.

**12. SC 56-5-2920** — Reckless driving. t56c005.php
- **Statute:** $25–$200 or 30 days. A second offense within 5 years carries a 3-month suspension.
- **Verdict:** CORRECT.

**13. SC 56-1-460** — Driving under suspension. t56c001.php
- **Verdict:** CORRECT.

**14. SC 42-9-260** — Termination or suspension of compensation. t42c009.php
- **Verdict:** CORRECT.
- **Imprecision on the 1702 table:** "Stopping at MMI needs Commission approval after 150 days."
  The 150-day point governs when a carrier may stop by Form 15 versus needing a hearing. The
  wording is close, but could be tightened.

**15. SC 56-5-3110** — Pedestrians subject to traffic-control signals. t56c005.php
- **Verdict:** CORRECT where cited (1856, 4478).
- **Imprecision for Gillin:** 4478 says a pedestrian who began crossing on Walk keeps the right of
  way. That rule lives in the signal section (§ 56-5-970), not § 56-5-3110.
- The pillar-meta range citation "S.C. Code § 56-5-3110 to -3230" is dormant (see "Dormant").

### Georgia

**16. GA 40-6-305** — Farm use vehicles on public roads (2016 HB 579; legis.ga.gov committee
substitute).
- **Statute:**
  - A farmer 16 or older may operate a farm use vehicle (ATV or PTV) on a public road. The vehicle
    must display the § 40-8-4 slow-moving-vehicle emblem, and the trip must carry farm products or
    run between the farmer's residence and farm.
  - § 40-6-306 gives that operator the rights and duties of any driver.
  - § 40-6-307 lets a municipality prohibit it.
- **Verdict:** CORRECT on 5 pages, including ES pillar FAQ ("agricultores de 16 años o más").
  Tyler should confirm against the enrolled act.

**17. GA 40-7-1** — "Off-Road Vehicle Act of 1975." FindLaw, current as of 2024-03-28.
- **Statute:**
  - § 40-7-4 bars operation without operative brakes or mufflers, on private property without the
    owner's express written permission, and within perennial streams. It sets no age rule.
  - § 40-7-5 lets localities regulate time periods and zones of use.
  - § 40-7-3 defines "off-road vehicle."
- **Verdict:** CORRECT, including 4182's "no minimum age."

**18. GA 40-6-320** — EPAMDs (and personal delivery devices). IA capture, **currency 2021-04-14**.
- **Statute:**
  - EPAMDs may use highways and sidewalks, keeping a 48-inch clear path.
  - They may use a roadway only where the limit is 35 mph or less or there is a striped bicycle
    lane, and must travel in the direction of traffic.
  - § 40-6-321 requires due care toward pedestrians and yielding to them.
  - § 40-1-1(15.4): an EPAMD is a "self-balancing, two nontandem wheeled device" with a top speed
    under 20 mph.
  - § 40-1-1(43.4): a PTV has three or more wheels, a top speed under 20 mph, and **expressly
    excludes** EPAMDs and scooters.
  - No statewide stand-up e-scooter statute was found in the Code as read. SB 159 was not found
    enacted.
- **Site:** Treats § 40-6-320 as the Georgia e-scooter statute, with an age 15/16 rule, a 20 mph
  cap, a PTV classification, bicyclist rights, three-foot passing and a sidewalk ban.
- **Verdict:** **WRONG.** F24–F32.

**19. GA 33-6-34** — Unfair claims settlement practices. IA capture, current as of 2024-03-28.
- **Verdict:** CORRECT.
- **Imprecision on 1719:** "denying a claim without a written explanation." Under (10), the written
  explanation is owed on the insured's written request. Optional fix.

**20. GA 34-9-263** — Permanent partial disability. IA capture 2025-04-28, current as of
2024-03-28.
- **Statute:**
  - (b)(1): PPD is payable "without regard to whether the employee has suffered economic loss."
  - (b)(2): PPD is not paid while §§ 34-9-261 or -262 benefits are payable.
  - (c) schedule: hand 160 weeks, foot 135, eye 150, one ear 75, arm and leg 225, **body as a whole
    300**.
  - (d): AMA Guides, 5th edition.
- **Site:** 1702 and 1761 are correct. 1677 is wrong on unscheduled injuries.
- **Verdict:** **WRONG on 1677.** F22. Post 1801's "body as a whole, 300 weeks maximum" is correct.

**21. GA 40-6-330** — PTV local standards. IA capture, current as of 2024-03-28.
- **Statute:**
  - "Any local authority desiring to establish operating standards for personal transportation
    vehicles shall comply with Part 6 of this article."
  - § 40-6-331(a): a local ordinance designates the streets and "establish[es] the conditions
    under which PTVs may be operated." Operators must hold a valid driver's license, except under
    ordinances adopted before 2012.
  - § 40-6-330.1 (2021 capture): the required equipment is brakes, a reverse warning, a power
    switch, head lamps, reflex reflectors, tail lamps, a horn, a mirror, labels and hip restraints.
    (b) exempts pre-2012 daylight-ordinance carts.
- **Not in the statute:** a statewide 25 mph cap, a 35 mph extension, a daylight-only rule or an
  age-16 rule. The only 25 mph figure is the § 40-6-331(e) delivery-subdivision exception.
- **Site:** The equipment claims (headlights, taillights, reflectors) are correct.
- **Verdict:** **WRONG** on the speed, daylight and age rules, and mis-cited on 4190. F33–F39.

**22. GA 40-6-93** — Pedestrian due care / driver due care. Pending pack authority. IA capture,
current as of 2024-03-28.
- **Verdict:** CORRECT on 3 pages.

**23. GA 34-9-2** — Scope of the Act. IA capture, current as of 2024-03-28.
- **Statute:** The Act does not apply "to farm laborers or domestic servants; nor to employers of
  such employees," nor to employers with fewer than three employees.
- **Site:** The 3-employee threshold and the domestic exclusion are correct. The 1693 agricultural
  row ("10+ farmworkers") is wrong.
- **Verdict:** **WRONG on one cell.** F21.

**24. GA 24-4-403** — Exclusion of relevant evidence. Current as of 2024-03-28.
- **Verdict:** CORRECT.

**25. GA 9-3-72** — Foreign objects in medical malpractice: one year from discovery. Excludes
chemical compounds, fixation devices and prosthetics.
- **Verdict:** CORRECT. The tenth-birthday errors on 1676 are pass-1 E17/E18 and are not counted
  again here.

**26. GA 40-5-121** — Driving while license suspended. Current as of 2024-01-01.
- **Verdict:** CORRECT.

**27. GA 24-8-803** — Hearsay exceptions. Current as of 2024-01-01.
- **Verdict:** CORRECT as cited for (1), (2) and (8).
- **Note for Tyler:** "Only the officer's own observations" is narrower than (8)(C), which also
  admits factual findings in civil cases. The limit the site describes comes from case law.

**28. GA 36-1-4** — County immunity. "A county is not liable to suit for any cause of action
unless made so by statute."
- **Verdict:** CORRECT.

**29. GA 40-6-96** — Pedestrians on roadways. IA capture, current as of 2024-03-28.
- **Statute:** Use the sidewalk where there is one. Otherwise use the shoulder. Walk on the left of
  a two-way roadway only where there is neither sidewalk nor shoulder. (b) has a 1,000-foot
  exception.
- **Verdict:** CORRECT on 4477.
- **Imprecise** on 1856 and on 4086 (body and FAQ 0): "where no sidewalks exist, walk on the left"
  skips the shoulder rule. Optional fix, not counted as an error.

**30. GA 40-13-58** — Cash bond forfeiture as admission of guilt.
- **Statute:** Posting a cash bond and failing to appear "shall be construed as an admission of
  guilt."
- **Site:** 1679 and 1740 are correct; 1740 says expressly that merely paying a fine is not an
  admission. 1790 says paying online is the admission.
- **Verdict:** **WRONG on 1790.** F23.

## Errors: published sentence, correction, authority

Each finding gives the field (FAQ index where relevant), the published sentence verbatim, the
proposed sentence, the authority, the type, and the attorney.

### SC — Graeham C. Gillin

**F1.** 1837 `/blog/financial-abuse-at-nursing-homes/` — `post_content`, comparison table,
"Mandatory Reporting" row, SC cell.
- **Published:** "Yes — anyone who has reason to believe a vulnerable adult is being abused must
  report"
- **Proposed:** "Yes — listed professionals, caregivers and facility staff must report when they
  have reason to believe; anyone else must report only with actual knowledge (S.C. Code
  § 43-35-25(A))"
- **Type:** RULE REWRITE.

**F2.** 1837 — `post_content`.
- **Published:** "South Carolina has a broader mandatory reporting requirement — anyone who has
  reason to believe a vulnerable adult is being abused or exploited must report it."
- **Proposed:** "In South Carolina, doctors, nurses, caregivers, facility staff and the other
  professionals listed in S.C. Code § 43-35-25(A) must report when they have reason to believe a
  vulnerable adult has been abused, neglected or exploited, and any other person who has actual
  knowledge of it must report as well."
- **Type:** RULE REWRITE.

**F3.** 1837 — `_roden_faqs[3]`, answer, second sentence.
- **Published:** "South Carolina has a broader mandatory reporting requirement — anyone who
  suspects abuse must report it."
- **Proposed:** "Listed professionals and caregivers must report when they have reason to believe
  abuse occurred, and anyone with actual knowledge of it must report (S.C. Code § 43-35-25(A))."
- **Type:** RULE REWRITE.

**F4.** 4478 `/blog/south-carolina-pedestrian-right-of-way-laws/` — `post_content`, heading and
quote.
- **Published (heading):** "S.C. Code § 56-5-3150 — Drivers to Exercise Due Care"
- **Published (quote):** "This critical statute states: "Notwithstanding the foregoing provisions
  of this article, every driver of a vehicle shall exercise due care to avoid colliding with any
  pedestrian upon any roadway.""
- **Proposed heading:** "S.C. Code § 56-5-3230 — Driver to Exercise Due Care"
- **Proposed quote:** "This critical statute states: "Notwithstanding other provisions of any local
  ordinance, every driver of a vehicle shall exercise due care to avoid colliding with any
  pedestrian or any person propelling a human-powered vehicle and shall give an audible signal when
  necessary and shall exercise proper precaution upon observing any child or any obviously
  confused, incapacitated or intoxicated person.""
- **Also:** The paragraph that follows, glossing "notwithstanding," still works. Check that it
  does not lean on "the foregoing provisions of this article."
- **Type:** MECHANICAL (re-cite, and replace the quote with the verbatim text).

**F5.** 4478 — `post_content`, driver-duties list.
- **Published:** "Exercise due care to avoid colliding with any pedestrian on any roadway,
  regardless of who has the right of way (S.C. Code § 56-5-3150)"
- **Proposed:** the same text with "(S.C. Code § 56-5-3230)".
- **Type:** MECHANICAL.

**F6.** 4478 — `post_content`, driver-duties list.
- **Published:** "Sound the horn when necessary to warn pedestrians of danger (S.C. Code
  § 56-5-3150)"
- **Proposed:** "Give an audible signal when necessary (S.C. Code § 56-5-3230)"
- **Type:** MECHANICAL.

**F7.** 4478 — `post_content`, driver-duties list.
- **Published:** "Exercise extra precaution when observing children or confused or incapacitated
  persons on the roadway (S.C. Code § 56-5-3150)"
- **Proposed:** "Exercise proper precaution upon observing any child or any obviously confused,
  incapacitated or intoxicated person (S.C. Code § 56-5-3230)"
- **Type:** MECHANICAL.

**F8.** 4478 — `post_content`.
- **Published:** "It is critical to understand that even when a pedestrian violates these rules,
  the driver's duty to exercise due care under S.C. Code § 56-5-3150 remains in effect."
- **Proposed:** the same sentence with "S.C. Code § 56-5-3230".
- **Type:** MECHANICAL.

**F9.** 4478 — `_roden_faqs[3]`. This also renders as FAQPage schema.
- **Published:** "Under S.C. Code § 56-5-3150, drivers must exercise due care to avoid colliding
  with any pedestrian on any roadway, regardless of who has the right of way."
- **Proposed:** "Under S.C. Code § 56-5-3230, drivers must exercise due care to avoid colliding
  with any pedestrian, regardless of who has the right of way."
- **Type:** MECHANICAL.

**F10.** 4478 — `_roden_faqs[4]`.
- **Published:** "S.C. Code § 56-5-3150 requires drivers to exercise proper precaution upon
  observing any child or any confused or incapacitated person on a roadway."
- **Proposed:** "S.C. Code § 56-5-3230 requires drivers to exercise proper precaution upon
  observing any child or any obviously confused, incapacitated or intoxicated person."
- **Type:** MECHANICAL.

**F11.** 4478 — `post_content`, heading.
- **Published:** "S.C. Code § 56-5-3140 — Crossing at Other Than Crosswalks"
- **Proposed:** "S.C. Code § 56-5-3150 — Crossing at Other Than Crosswalks"
- **Note:** § 56-5-3140 is "Pedestrian shall use right half of crosswalk." The body under the
  heading states § 56-5-3150(a) and (c) correctly.
- **Type:** MECHANICAL.

**F12.** 4478 — `post_content`, pedestrian-duties list (two bullets).
- **Published:**
  - "Use crosswalks when available — between adjacent signalized intersections, pedestrians must
    cross at a crosswalk (S.C. Code § 56-5-3140)"
  - "Yield to vehicles when outside a crosswalk — … (S.C. Code § 56-5-3140)"
- **Proposed:** cite "§ 56-5-3150(c)" and "§ 56-5-3150(a)" respectively. In the first bullet,
  change "at a crosswalk" to "in a marked crosswalk", which is the statute's word.
- **Type:** MECHANICAL.

**F13.** 4478 — `post_content`, the § 56-5-3130 quote.
- **Published:** "the driver of a vehicle shall yield the right of way, slowing down or stopping
  if need be to so yield, to a pedestrian crossing the roa[dway within …]"
- **Proposed:** quote the verbatim text with its condition: "When traffic-control signals are not
  in place or not in operation the driver of a vehicle shall yield the right-of-way, slowing down
  or stopping if need be to yield to a pedestrian crossing the roadway within a crosswalk when the
  pedestrian is upon the half of the roadway upon which the vehicle is traveling or when the
  pedestrian is approaching so closely from the opposite half of the roadway as to be in danger."
- **Also:** The body says § 56-5-3130 "explicitly applies to 'any unmarked crosswalk at an
  intersection'." That phrase appears only in (d), the do-not-pass rule. Change it to say that a
  "crosswalk" includes the unmarked crosswalk at an intersection.
- **Type:** MECHANICAL.

**F14.** 4478 — `post_content`, § 56-5-3130(b) quote.
- **Published:** "a pedestrian shall not "suddenly leave a curb or other place of safety and walk
  or run into the path of a vehicle which is so close that it is impossible for the driver to
  yield.""
- **Proposed:** "…walk or run into the path of a vehicle which is so close as to constitute an
  immediate hazard."
- **Type:** MECHANICAL.

**F15.** 1856 `/blog/pedestrian-safety-georgia/` — `post_content`.
- **Published:** "Pedestrian responsibilities (S.C. Code § 56-5-3150): Pedestrians must not
  suddenly walk into the path of a vehicle that is so close as to constitute an immediate hazard."
- **Proposed:** the same text with "(S.C. Code § 56-5-3130(b))".
- **Type:** MECHANICAL.

**F16.** 1856 — `post_content`.
- **Published:** "Walking on highways (S.C. Code § 56-5-3190): Pedestrians walking along roads
  must use sidewalks when available, or walk on the left side facing traffic when no sidewalk is
  present."
- **Proposed:** "Walking on highways (S.C. Code § 56-5-3160): Pedestrians must use a sidewalk when
  one is available, otherwise the shoulder, and walk on the left side facing traffic only where
  there is neither a sidewalk nor a shoulder."
- **Note:** § 56-5-3190 is the white-cane section.
- **Type:** MECHANICAL. The citation is the error; the wording fix is the § 56-5-3160(b)–(c)
  shoulder rule.

**F17.** 4639 `/resources/pedestrian-bicycle-safety-north-charleston/` — `_roden_key_takeaways`.
This is the invented SC three-foot rule from earlier passes, surviving uncited.
- **Published:** "Bicyclists have the same rights and duties as motor vehicles and are entitled to
  a 3-foot passing distance."
- **Proposed:** "Bicyclists have the same rights and duties as drivers (S.C. Code § 56-5-3420),
  and a driver passing a cyclist must keep a safe operating distance; South Carolina sets no fixed
  number of feet (S.C. Code § 56-5-3435)."
- **Type:** RULE REWRITE.

**F18.** 4639 — `post_content`, "South Carolina Bicycle Laws" list.
- **Published:** "Passing distance: Drivers must give cyclists at least 3 feet of clearance when
  passing (recommended; enforcement varies)."
- **Proposed:** "Passing distance: Drivers must keep a safe operating distance when passing a
  cyclist; South Carolina law names no fixed distance (S.C. Code § 56-5-3435)."
- **Type:** RULE REWRITE.

**F19.** 1698 `/blog/steps-to-take-if-you-are-involved-in-a-bicycle-hit-and-run/` —
`_roden_key_takeaways`. Two-state trap: this contradicts the page's own FAQ 3, which is correct.
- **Published:** "Both states require 3-foot passing clearance for cyclists."
- **Proposed:** "Georgia requires at least three feet when passing a cyclist (O.C.G.A. § 40-6-56);
  South Carolina requires a safe operating distance and names no fixed figure (S.C. Code
  § 56-5-3435)."
- **Type:** RULE REWRITE. Gillin, with Tyler for the GA half (already a pack authority).

**F20.** 1693 `/blog/am-i-eligible-for-workers-compensation/` — `post_content`, eligibility table,
"Agricultural workers" row, SC cell.
- **Published:** "Exempt unless employer meets the 4-employee threshold"
- **Proposed:** "Exempt unless the employer elects coverage (S.C. Code §§ 42-1-360(4), 42-1-380)"
- **Type:** RULE REWRITE.

### GA — Tyler Love

**F21.** 1693 — same table, GA cell.
- **Published:** "Exempt unless employer regularly employs 10+ farmworkers"
- **Proposed:** "Excluded — the Act does not apply to farm laborers or their employers, whatever
  the head count (O.C.G.A. § 34-9-2(a))"
- **Note:** Tyler should confirm whether a voluntary election for farm employers should be
  mentioned.
- **Type:** RULE REWRITE.

**F22.** 1677 `/blog/when-does-workers-compensation-stop-paying/` — `post_content`.
- **Published:** "For injuries not on the schedule (such as back or neck injuries), benefits are
  determined based on the impairment rating and its effect on your earning capacity, subject to
  the 400-week overall cap."
- **Proposed:** "For injuries not on the schedule (such as back or neck injuries), the impairment
  rating is applied to the body as a whole — 300 weeks — and the benefit is paid whether or not
  you have lost earnings (O.C.G.A. § 34-9-263(b)(1), (c))."
- **Note:** The 400-week cap is the § 34-9-261/-262 income-benefit limit, not a PPD cap.
- **Type:** RULE REWRITE.

**F23.** 1790 `/blog/georgia-super-speeder-law/` — `post_content`.
- **Published:** "Some drivers pay the fine online without appearing in court, which O.C.G.A.
  § 40-13-58 treats as an admission of guilt; it is reported as a conviction."
- **Proposed:** "Some drivers post a cash bond and do not appear in court; O.C.G.A. § 40-13-58
  treats that as an admission of guilt, and it is reported as a conviction."
- **Note:** Tyler should confirm whether online payment in his courts is processed as bond
  forfeiture. The super-speeder outcome may be the same, but the statute's trigger is the bond.
  The page also conflicts with 1740, which is correct.
- **Type:** RULE REWRITE.

**F24.** 4088 `/practice-areas/electric-scooter-accident-lawyers/` — `post_content`.
- **Published:** "Georgia: Electric scooters are regulated under O.C.G.A. § 40-6-320 et seq..
  Riders must be at least 15 years old (or 16 for rental scooters). Maximum speed is 20 mph."
- **Proposed:** "Georgia: No Georgia statute is written for stand-up electric scooters. O.C.G.A.
  § 40-6-320 governs self-balancing devices (§ 40-1-1(15.4)), not scooters, so where and how
  scooters may be ridden is set mainly by city ordinances and the rental companies' terms."
- **Note:** Tyler to confirm, with the 2024–2026 currency check.
- **Type:** RULE REWRITE.

**F25.** 4088 — `_roden_faqs[0]` (FAQPage schema).
- **Published:** "Yes. Georgia regulates e-scooters under O.C.G.A. § 40-6-320 et seq. Riders must
  be at least 15 (16 for rentals). Maximum speed is 20 mph."
- **Proposed:** "Yes, but Georgia has no statute written for stand-up e-scooters; § 40-6-320
  covers self-balancing devices. Where scooters may operate is set mainly by local ordinance."
  Keep the existing sentence about cities.
- **Type:** RULE REWRITE.

**F26.** 4088 — `_roden_why_hire`, rendered live on the pillar.
- **Published:** "Georgia classifies electric scooters as "electric personal transporters" under
  O.C.G.A. § 40-1-1(15.4) and regulates their use under O.C.G.A. § 40-6-320 et seq., limiting
  riders to 20 mph and requiring use on streets (not sidewalks in many municipalities)."
- **Proposed:** "Georgia's motor vehicle code has no section written for stand-up electric
  scooters — O.C.G.A. § 40-1-1(15.4) and § 40-6-320 cover self-balancing devices — so scooter use
  is governed mainly by local ordinances, many of which keep scooters off downtown sidewalks."
- **Also:** Both Justia links in this block point to the wrong rule.
- **Type:** RULE REWRITE.

**F27.** 4224 `/electric-scooter-accident-lawyers/escooter-vehicle-collision/` — `post_content`.
- **Published:** "Georgia law classifies electric scooters as "personal transportation vehicles"
  under O.C.G.A. § 40-6-320 et seq., which grants e-scooter riders many of the same rights and
  responsibilities as bicyclists on public roadways. Riders may use bike lanes, multi-use paths,
  and roadways with speed limits of 35 mph or less."
- **Proposed:** "Georgia has no statute written for stand-up e-scooters: the personal
  transportation vehicle definition expressly excludes scooters (O.C.G.A. § 40-1-1(43.4)), and
  § 40-6-320 covers self-balancing devices. Where scooters may ride is set mainly by local
  ordinance."
- **Note:** The following safe-passing sentence is accurate for bicycles. Keep it framed as "as
  with a bicycle," not as a scooter rule.
- **Type:** RULE REWRITE.

**F28.** 4224 — `_roden_faqs[0]`.
- **Published:** "Under O.C.G.A. § 40-6-320, electric scooter riders have many of the same rights
  and responsibilities as bicyclists, including the right to use bike lanes and roadways with
  speed limits of 35 mph or less. Motorists must give them at least three feet of clearance when
  passing."
- **Proposed:** "Georgia has no statute that gives e-scooter riders bicyclists' rights; every
  driver still owes them ordinary care, and a driver who hits a lawfully riding scooter rider can
  be liable."
- **Note:** The three-foot rule, O.C.G.A. § 40-6-56, is written for bicycles only. Drop it or
  frame it as a bicycle rule.
- **Type:** RULE REWRITE.

**F29.** 4227 `/electric-scooter-accident-lawyers/escooter-pedestrian-accident/` — `post_content`.
- **Published:** "Georgia law under O.C.G.A. § 40-6-320 et seq. generally prohibits e-scooter
  operation on sidewalks unless permitted by local ordinance."
- **Proposed:** "No Georgia statute bans e-scooters from sidewalks statewide; sidewalk riding is
  restricted by local ordinance."
- **Note:** § 40-6-320 actually *permits* EPAMDs on sidewalks.
- **Type:** RULE REWRITE.

**F30.** 4227 — `_roden_faqs[0]`.
- **Published:** "E-scooter riders who operate on sidewalks in violation of Georgia law (O.C.G.A.
  § 40-6-320) or local ordinances can be held liable for negligence."
- **Proposed:** "E-scooter riders who operate on sidewalks in violation of local ordinances, or
  carelessly, can be held liable for negligence."
- **Type:** MECHANICAL (drop the citation).

**F31.** 4229 `/electric-scooter-accident-lawyers/escooter-intersection-crash/` — `post_content`.
- **Published:** "Georgia's traffic code under O.C.G.A. § 40-6-70 et seq. establishes right-of-way
  rules at intersections that apply equally to e-scooter riders under the state's e-scooter
  statute (O.C.G.A. § 40-6-320)."
- **Proposed:** "Georgia's traffic code under O.C.G.A. § 40-6-70 et seq. establishes right-of-way
  rules at intersections."
- **Note:** Tyler should confirm whether the next sentence's negligence-per-se claim survives
  without a scooter statute.
- **Type:** MECHANICAL (drop the clause).

**F32.** 4229 — `_roden_faqs[1]`.
- **Published:** "Under Georgia law (O.C.G.A. § 40-6-320), e-scooter riders have the same
  right-of-way protections as bicyclists."
- **Proposed:** "Drivers must yield the right of way at intersections as Georgia's traffic code
  requires (O.C.G.A. § 40-6-70 et seq.), and a driver who fails to yield to a lawfully riding
  scooter rider can be liable."
- **Type:** RULE REWRITE.

**F33.** 4090 `/practice-areas/golf-cart-accident-lawyers/` — `post_content`.
- **Published:** "Georgia: O.C.G.A. § 40-6-330 et seq. permits golf cart operation on public roads
  with speed limits of 25 mph or less, during daylight hours, and only on roads specifically
  designated for golf cart use. Operators must be at least 16 and hold a valid driver's license or
  learner's permit."
- **Proposed:** "Georgia: A golf cart may use only the streets a city or county has designated by
  ordinance, under the conditions that ordinance sets, and the operator must hold a valid driver's
  license (O.C.G.A. §§ 40-6-330, 40-6-331(a))."
- **Note:** Keep the equipment sentence; it is supported by § 40-6-330.1. "Learner's permit" is
  not in § 40-6-331(a); Tyler to confirm.
- **Type:** RULE REWRITE.

**F34.** 4090 — `_roden_faqs[0]`.
- **Published:** "Only on roads specifically designated for golf cart use with speed limits of 25
  mph or less, during daylight hours. Operators must be at least 16 with a valid license."
- **Proposed:** "Only on streets your city or county has designated for golf carts by ordinance,
  under that ordinance's conditions; the operator must hold a valid driver's license (O.C.G.A.
  § 40-6-331(a))."
- **Type:** RULE REWRITE.

**F35.** 4090 — `_roden_why_hire`, rendered live.
- **Published:** "Georgia law (O.C.G.A. § 40-6-330 et seq.) specifically regulates golf cart
  operation on public roads, limiting their use to designated streets and communities with speed
  limits of 25 mph or less."
- **Proposed:** "Georgia law (O.C.G.A. § 40-6-330 et seq.) lets each city or county designate
  which streets golf carts may use and set the conditions."
- **Note:** The SC sentence that follows ("similar regulations that vary by municipality")
  understates the statewide § 56-2-90 rule. That is an imprecision, already noted in the golf-cart
  record.
- **Type:** RULE REWRITE.

**F36.** 4186 `/golf-cart-accident-lawyers/golf-cart-vehicle-collision/` — `post_content`.
- **Published:** "Georgia law under O.C.G.A. § 40-6-330 et seq. permits golf carts on public roads
  with speed limits of 25 mph or less (extendable to 35 mph by local ordinance) and requires basic
  safety equipment including working headlights, taillights, and reflectors."
- **Proposed:** "Georgia law under O.C.G.A. § 40-6-330 et seq. permits golf carts on public
  streets a local ordinance has designated for them and requires basic safety equipment including
  working headlights, taillights, and reflectors (§ 40-6-330.1)."
- **Type:** RULE REWRITE.

**F37.** 4186 — `_roden_faqs[0]`.
- **Published:** "Georgia (O.C.G.A. § 40-6-330) permits golf carts on roads with speed limits of
  25 mph or less, and motorists must exercise care around them."
- **Proposed:** "Georgia (O.C.G.A. §§ 40-6-330, 40-6-331) permits golf carts on streets a city or
  county has designated for them, and motorists must exercise care around them."
- **Type:** RULE REWRITE.

**F38.** 4190 `/golf-cart-accident-lawyers/golf-cart-pedestrian-accident/` — `post_content`.
- **Published:** "Georgia's golf cart statute (O.C.G.A. § 40-6-330) subjects golf cart operators
  to the same traffic laws that govern motor vehicle drivers, including the duty to yield to
  pedestrians in crosswalks …"
- **Proposed:** "Golf cart operators on Georgia streets are subject to the same traffic laws that
  govern motor vehicle drivers, including the duty to yield to pedestrians in crosswalks
  (O.C.G.A. § 40-6-91) …"
- **Note:** Tyler to confirm the rules-of-the-road hook for PTVs.
- **Type:** MECHANICAL (re-cite).

**F39.** 4190 — `_roden_faqs[0]`.
- **Published:** "Golf cart operators owe pedestrians a duty of care under Georgia (O.C.G.A.
  § 40-6-330) and South Carolina law."
- **Proposed:** "Golf cart operators owe pedestrians a duty of care under Georgia and South
  Carolina law."
- **Type:** MECHANICAL (drop the citation).

## Error count

| Section | Findings | Docs | MECH | RULE |
|---|---|---|---|---|
| SC 43-35-10 et seq. (reporting) | F1–F3 | 1837 | 0 | 3 |
| SC 56-5-3150 / -3140 / -3130 / -3190 (4478, 1856) | F4–F16 | 4478, 1856 | 13 | 0 |
| SC three-foot rule (class sweep) | F17–F19 | 4639, 1698 | 0 | 3 |
| SC 42-1-360 (two-state cell) | F20 | 1693 | 0 | 1 |
| GA 34-9-2 | F21 | 1693 | 0 | 1 |
| GA 34-9-263 | F22 | 1677 | 0 | 1 |
| GA 40-13-58 | F23 | 1790 | 0 | 1 |
| GA 40-6-320 (e-scooter) | F24–F32 | 4088, 4224, 4227, 4229 | 2 | 7 |
| GA 40-6-330 (golf cart) | F33–F39 | 4090, 4186, 4190 | 2 | 5 |
| **Total** | **39** | **15** | **17** | **22** |

## Class sweeps run (cited and uncited, both columns, EN and ES)

- **SC three-foot passing rule** ("3-foot", "three feet", "3 pies", "tres pies" near South Carolina
  or bicycles):
  - 3 survivals found: F17–F19.
  - Correct statements on 1698 FAQ 3, 4087 FAQ 1 and KT, 4106, 4224 and 4898 FAQ 5.
- **SC universal reporting duty** ("anyone … must report"): 1837 only.
- **GA e-scooter rules** (ages 15/16, 20 mph, PTV, 15.4, sidewalks, three feet), EN and ES:
  - Confined to 4088, 4224, 4227 and 4229.
  - 4227's "travel at speeds up to 15–20 mph" is a description, not a rule.
  - 6313 states SC correctly ("None in the motor vehicle code").
  - The ES pillar 4899 carries no GA scooter rule.
- **GA golf-cart rules** (25/35 mph, daylight, 16, learner's): confined to 4090, 4186 and 4190.
  The SC statements on 4343 and 6314 (§ 56-2-90) are correct.
- **GA PPD unscheduled injuries:** only 1677 is wrong. 1801 ("body as a whole, 300 weeks") is
  correct. 1677's SC sentence (loss of earning capacity, 500 weeks) matches the SC rule.
- **Farm-labor exemption:** 1693 table (F20, F21). 1684 ("exempt under certain conditions in both
  states") and 1693 FAQ 1 are vague but not wrong.
- **Fine payment as admission:** only 1790. 1740 states the rule correctly.
- **SC due care cited to § 56-5-3150 / § 56-5-3140:** only 4478 and 1856.

## Dormant (stored, not rendered)

`_roden_pillar_negligence_intro` is defined in `inc/meta-boxes.php`, and
`roden_render_pillar_intro()` exists in `inc/template-tags.php`, but **nothing calls the
function**. That is why the inventory's pillar-meta hits for GA 40-7-1, SC 50-26-10 and
SC 56-5-3110 do not appear on the live EN or ES pillars. Two stored intros are wrong and would
publish if the renderer is ever wired up:

| Post | Stored text | Problem |
|---|---|---|
| 4089 ATV pillar | "S.C. Code § 50-26-10 et seq. … prohibits passengers on single-rider ATVs" | § 50-26-30(B) bars a parent from letting an unlicensed rider under 16 carry a passenger. It is not a single-rider ban. |
| 4090 golf-cart pillar | "golf carts may operate on roads with speed limits ≤35 mph in jurisdictions that have authorized them by ordinance" (cited "§ 40-6-330 to -334") | There is no statutory 35 mph figure in §§ 40-6-330 / -331 as read, and -334 was not confirmed to exist. |

Fix these before anyone wires up the renderer. They are not counted as live errors.

## Optional imprecisions (not counted)

- 1650 FAQ 5 (§ 42-1-160): medical evidence proves causation, not extraordinariness.
- 1702 table (§ 42-9-260): the wording of the 150-day point.
- 4179 and 4089 (§ 50-26-10): the public-road restriction is not in Chapter 26.
- 1719 (§ 33-6-34(10)): the explanation is owed on written request.
- 1856, 4086 body and 4086 FAQ 0 (§ 40-6-96): the shoulder rule is skipped.
- 4478 (§ 56-5-3110): right of way after starting on Walk is a § 56-5-970 matter.
- 4478 FAQ 0 and 1856 (§ 56-5-3130): stated without the "signals not in place" condition.
- 24-8-803(8)(C) note for Tyler.

## Needs an attorney

- **Tyler Love:**
  - All GA findings.
  - Specifically: a 2024–2026 session-law check for any e-scooter or PTV act before F24–F39 are
    applied.
  - The HB 579 enrolled text (§ 40-6-305).
  - The farm-employer election (F21).
  - Online payment versus bond forfeiture (F23).
  - The PTV rules-of-the-road hook (F38).
  - The learner's-permit point (F33).
- **Graeham C. Gillin:**
  - F1–F3 (the § 43-35-25 reporting scope).
  - F17–F20.
  - Confirm the § 56-5-3230 quote for F4 against his annotated code.

## Pack PR candidates

- **SC:**
  - Add § 56-5-3230 (driver due care) and § 56-5-3150 (crossing outside crosswalks) as
    authorities, with a rule that due care is never cited to § 56-5-3150.
  - Add § 43-35-25 with the professional / actual-knowledge reporting split.
  - Add a forbidden-claim rule: no fixed passing distance in SC (§ 56-5-3435).
- **GA:**
  - Add § 40-1-1(15.4) and (43.4) and § 40-6-320 with a rule that an EPAMD is not an e-scooter.
  - Add §§ 40-6-330 / -331 with a rule that there is no statewide PTV speed, daylight or age
    figure.
  - Add § 34-9-263(c) body-as-a-whole = 300 weeks.
  - Add § 34-9-2 farm-laborer exclusion.
  - Add § 40-13-58 (bond forfeiture, not fine payment).

## Supporting sections read

- **SC:**
  - Pedestrian sections §§ 56-5-970, 56-5-3130, 56-5-3140, 56-5-3160 and 56-5-3190.
  - Limitations §§ 15-3-30 and 15-3-50.
  - § 42-1-360.
  - §§ 43-35-25 and 43-35-85.
  - §§ 50-26-20 through 50-26-70.
  - All on scstatehouse.gov chapter pages t56c005, t15c003, t42c001, t43c035 and t50c026.
- **GA:**
  - §§ 40-6-330.1, 40-6-331 and 40-6-321.
  - § 40-1-1(3), (15.4) and (43.4).
  - §§ 40-7-3, 40-7-4 and 40-7-5.
  - §§ 40-6-306 and 40-6-307 (HB 579 committee substitute).
