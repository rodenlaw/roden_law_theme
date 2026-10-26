# Statute verification, pass 3: the next 30 — 2026-10-26

**Read-only pass.** Nothing on production, the law packs, the fixtures, the tracker or the plays
was changed. Every finding below is a proposal. None has been applied.

**Attorney status.**
- Georgia findings go to **Tyler Love**. The GA pack is still unsigned for Roden, so every GA
  correction here needs his sign-off before it is applied.
- South Carolina findings go to **Graeham C. Gillin**. He has signed the SC pack, but corrections
  marked RULE REWRITE still need his read.

**Numbering.** Findings are numbered G1–G29 so they do not collide with pass 1's E1–E58
(`data/facts/statute-pass-2026-10-24.md`) or pass 2's F1–F39
(`data/facts/statute-pass-2-2026-10-24.md`).

## Summary

| | Count |
|---|---|
| Sections read (the tracker's top 30 after pass 2) | 30 (9 SC, 21 GA) |
| Page-citations covered | 64 (48 correct, 16 wrong) |
| Correct as the site uses them | 19 |
| Wrong or mis-cited somewhere on the site | 11 — GA 34-9-202, GA 34-9-280, GA 40-6-123, GA 40-6-188, GA 20-2-324.1, GA 52-7-12, GA 52-7-8.2, SC 50-21-145, SC 59-63-75, SC 44-7-110, SC 42-11-10 |
| Repealed or renumbered | 1 — SC 50-21-145 (a former no-wake-zone section; it is not a personal-watercraft rule and is no longer in the Code) |
| Live errors (G1–G29) | 29 on 16 documents |
| MECHANICAL / RULE REWRITE | 6 / 23 |
| Survivors of pass 2's invented classes (GA e-scooter, GA golf cart, SC three-foot) outside the F-items | 1 (G9, an uncited "3-foot law" in the bicycle pillar's rendered common-causes list); no GA e-scooter or golf-cart survivors |
| Dormant errors (stored but not rendered) | 1 new — see "Dormant" |

**Worst finding.** The two brain-injury sub-type pages tell parents a coach who breaks Georgia's
concussion law "is negligent" and that a violation is "automatic proof of negligence" (G20–G24).
O.C.G.A. § 20-2-324.1(e) says the opposite: the section **creates no liability and no cause of
action** against a school, a public recreation facility, or their staff for removing or not
removing an athlete. The pages also widen the statute to "all youth sports organizations" (it
binds public, private and charter schools; recreation programs owe only an information sheet;
church leagues and lessons are excluded) and describe South Carolina's law as "identical" when it
allows a same-day return after a negative on-site evaluation and shields the evaluator except for
gross negligence (§ 59-63-75(D)(2), (D)(5)). The claim appears in the body and the FAQs, so it is
also published as FAQPage structured data.

**Second.** Georgia's work-zone speeding law does not double fines (G16–G19). § 40-6-188(e) sets
its own penalty, $100 to $2,000 or up to 12 months, and requires workers **or** barriers, work
vehicles or drop-offs, not workers alone. The same page's South Carolina sentence describes
§ 56-5-1535 as a speeding statute with doubled fines (G5); 2017 Act No. 81 deleted the speeding
provision and made it the offence of endangering a highway worker.

## Sources

- **SC:** scstatehouse.gov chapter pages fetched directly (HTTP 200) on 2026-10-26: t42c011,
  t44c007, t38c071, t50c021, t56c005, t59c063, t61c004, t62c005. Each section's HISTORY line was
  read. Two sections carry 2025–2026 amendments that matter: § 59-63-75 (2026 Act No. 146, agency
  rename only) and § 61-4-580 (2025 Act No. 42, adds "In addition to civil liability as provided
  by law" and fixed fines, effective January 1, 2026).
- **GA:** codes.findlaw.com returns 403 to direct fetch. Two routes worked:
  - Internet Archive `id_` captures of FindLaw, which state their currency: "current as of
    March 28, 2024" for most; "January 01, 2024" for § 29-3-3 and § 34-9-8; **"April 14, 2021"
    for § 40-6-188 and § 40-6-49** (the newest captures available).
  - Internet Archive `id_` captures of Justia where FindLaw had none: § 40-5-35 (2023 Code),
    § 15-19-14 (2023), § 20-2-324.1 (2024), § 9-3-96 (2019; the section's history ends in 1933).
  - **Currency caveat for Tyler.** Nothing here reflects the 2024–2026 sessions, and § 40-6-188
    rests on a 2021 text. Check the 2024–2026 session laws before rewriting G16–G19 (work zones)
    and G20–G24 (concussion).
  - **Not read:** § 52-7-8 (the born-on-or-after-1998 boater-education rule; no capture exists).
    G27 and G28 drop that clause rather than re-cite it unread.
- **Site text:** read from production on 2026-10-26 with read-only `wp eval-file` over SSH:
  `post_content`, `post_excerpt`, `_roden_faqs` (every index), `_roden_key_takeaways`,
  `_roden_meta_description`, `_roden_why_hire`, `_roden_common_injuries`, `_roden_common_causes`,
  `_roden_pillar_negligence_intro`, `_roden_sol_ga`, `_roden_sol_sc`, on all 645 published posts.
  Array-valued meta (`_roden_common_causes`, `_roden_common_injuries`) was JSON-encoded before
  matching; a first read that cast them to strings saw nothing in them. Titles checked against
  `content/meta.json`.

## Per statute

### South Carolina

**1. SC 44-7-110** — Short title of Article 3, Chapter 7. t44c007.php
- **Statute:** "This article may be cited as the 'State Health Facility Licensure Act'." 2023 Act
  No. 20 deleted "Certification of Need and" from the name.
- **Site:** 4348 and 4170 cite "§ 44-7-110 et seq." for licensing; correct. 4164 still uses the
  pre-2023 name.
- **Verdict:** WRONG on 4164 (G6, name only).

**2. SC 38-71-190** — Health-insurer subrogation. t38c071.php
- **Statute:** a policy may provide for subrogation, capped at benefits paid; the Director (on the
  insured's petition) may bar it as inequitable; the insurer pays fees and costs from the recovery.
- **Site:** 1711 (body, table, FAQ 2) and 1712 state it the same way.
- **Verdict:** CORRECT.

**3. SC 42-11-10** — Occupational disease defined. t42c011.php (rewritten by 2007 Act No. 111)
- **Statute:** a disease "due to hazards in excess of those ordinarily incident to employment and
  … peculiar to the occupation"; caused by a hazard "recognized as peculiar to a particular trade,
  process, occupation, or employment"; proven by a preponderance; six exclusions in (B), including
  ordinary diseases of life and chronic skeletal joint disease.
- **Site:** 1652 FAQ 4 is correct. 4111 paraphrases it in language the statute does not use, and
  4111's Georgia sentence borrows this section's "hazard recognized as peculiar" wording.
- **Verdict:** WRONG on 4111 (G8, and see G13).

**4. SC 50-21-145** — Not a personal-watercraft rule. t50c021.php
- **Statute:** the chapter page lists 50-21-145 only as formerly "No wake and no swimming zones on
  Lakes Keowee and Jocassee". South Carolina's personal-watercraft rules are § 50-21-870 (life
  jackets, no operation sunset to sunrise, idle speed near docks and people, cut-off switch).
- **Site:** 3616 FAQ 7 and its Spanish twin 4895 FAQ 7 cite it for "similar restrictions".
- **Verdict:** MIS-CITED (G1, G2).

**5. SC 56-5-1520** — Speed limits. t56c005.php
- **Statute:** "reasonable and prudent" rule in (A); first-offence fine tiers in (G), the top tier
  $75–$200 or 30 days for more than 25 mph over.
- **Site:** 1716 and 1790 (body and key takeaways).
- **Verdict:** CORRECT.

**6. SC 59-63-75** — Student-athlete concussion protocol. t59c063.php
- **Statute:** an annual information sheet, with the parent's receipt documented; removal when a
  coach, trainer, official or physician suspects a concussion; **same-day return allowed** if an
  athletic trainer, physician, PA or NP finds no signs or symptoms on site; written physician
  clearance only for an athlete still suspected of a concussion; **evaluator immune except for
  gross negligence or wilful, wanton misconduct** (D)(5). Applies through school districts and
  to High School League-sanctioned events. The Code gives it no short title.
- **Site:** 4207 calls the two states' laws "identical"; 4205 says written clearance is always
  required.
- **Verdict:** WRONG (G3, G4).

**7. SC 61-4-580** — Prohibited acts by beer and wine permittees. t61c004.php
- **Statute:** (A)(2) bars knowingly selling beer or wine to an intoxicated person; (B), as
  amended by 2025 Act No. 42, adds "In addition to civil liability as provided by law".
- **Site:** 4189 (body, FAQ 2) and 4144 FAQ 2: establishments that knowingly serve a visibly
  intoxicated person can be liable. 4189 also notes the 2025 Act.
- **Verdict:** CORRECT. ("Visibly" is the case-law gloss; the section covers beer and wine only,
  with liquor in § 61-6-2220. Not counted.)

**8. SC 62-5-433** — Settlement of minors' claims. t62c005.php (amended by 2024 Act No. 200)
- **Statute:** circuit court above $25,000; circuit or probate up to $25,000; no court approval at
  $2,500 or less (D); "claim" is the net amount.
- **Site:** 1704 (body, table, FAQ 3) and 4116.
- **Verdict:** CORRECT as cited. 4116's uncited lead-in sentence says *any* settlement needs court
  approval (G29).

**9. SC 42-11-10, -1535 and -95 (supporting)** — read for G5, G7 and G8; see those entries.

### Georgia

**10. GA 34-9-104** — Change in condition. (FindLaw, 2024-03-28)
- **Statute:** "change in condition" includes "status"; the 52-consecutive / 78-aggregate-week
  conversion from TTD to TPD for non-catastrophic injuries; two-year (four-year for § 34-9-263)
  window to apply.
- **Site:** 1666, 1682, 1697.
- **Verdict:** CORRECT. (1697 ties suspension on resignation to this section; the suspension
  mechanism is § 34-9-240. Not counted.)

**11. GA 40-6-123** — Turning and stopping signals. (FindLaw, 2024-03-28)
- **Statute:** (a) appropriate and timely signal before turning or changing lanes; (b) signal
  continuously for a sufficient time; (c) no stopping or sudden slowing **without first giving a
  signal** to the driver behind when there is an opportunity.
- **Site:** 2658 and 1831 are correct. 1780 says (c) forbids braking "when there is no reason".
- **Verdict:** WRONG on 1780 (G15).

**12. GA 40-6-181** — Maximum speed limits. (FindLaw, 2024-03-28)
- **Site:** 4539, 4538, 1793 say only that speed limits are "governed by" it.
- **Verdict:** CORRECT.

**13. GA 15-19-14** — Attorney liens. (Justia, 2023)
- **Statute:** retaining lien on papers and money; charging lien on actions and judgments, superior
  to all but tax liens.
- **Site:** 1708 (body, table, FAQ 1, key takeaways) and 1711.
- **Verdict:** CORRECT.

**14. GA 24-6-601** — Competency. (FindLaw, 2024-03-28)
- **Statute:** one sentence: "Except as otherwise provided in this chapter, every person is
  competent to be a witness."
- **Site:** 1713, 1758.
- **Verdict:** CORRECT. (1713 attaches personal-knowledge and oath requirements to this section;
  those are §§ 24-6-602 and -603. Not counted.)

**15. GA 24-6-609** — Impeachment by conviction. (FindLaw, 2024-03-28)
- **Site:** 1703; 1758 body and FAQ 5 (felonies and crimen falsi, ten years, nolo and
  first-offender excluded).
- **Verdict:** CORRECT. (The ten years run from conviction or release, whichever is later. Not
  counted.)

**16. GA 44-14-470** — Hospital, physician and chiropractic liens. (FindLaw, 2024-03-28)
- **Site:** 1711 (body, FAQ 1, key takeaways), 1712 (body, FAQ 5, key takeaways): a lien on the
  cause of action, not the person, subject to the attorney's lien.
- **Verdict:** CORRECT.

**17. GA 9-11-35** — Physical and mental examinations. (FindLaw, 2024-03-28)
- **Site:** 1719, 1723 (body, table, FAQ 1, key takeaways).
- **Verdict:** CORRECT.

**18. GA 9-2-41** — Survival of actions. (FindLaw, 2024-03-28)
- **Statute:** survives the death of either party; against the personal representative; no
  punitive damages against the representative.
- **Site:** 3493, 1649 (body, FAQ 0, FAQ 1, key takeaways).
- **Verdict:** CORRECT.

**19. GA 20-2-324.1** — Concussion management and return to play. (Justia, 2024; 2013 Ga. Laws 25)
- **Statute:** binds local boards of education, nonpublic schools and charter schools, which must
  adopt a policy: an information sheet before each season; removal and evaluation by a health
  care provider of an athlete who **exhibits symptoms**; no return for an athlete found to have a
  concussion until a health care provider clears it. Public recreation facilities owe only the
  information sheet. Excludes college, church and synagogue activities, lessons and instructional
  activities. **(e): creates no liability or cause of action** against those entities or their
  personnel for removal or non-removal.
- **Site:** 4207 (body, FAQ 2), 4205 (body, FAQ 0, FAQ 2).
- **Verdict:** WRONG (G20–G24).

**20. GA 29-3-3** — Compromise of minors' claims. (FindLaw, 2024-01-01)
- **Statute:** gross $25,000 or less: the natural guardian may settle without court approval; more
  than $25,000: probate court, or the court where the action is pending; conservator required if
  the net also exceeds $25,000.
- **Site:** 1704 (body, table, FAQ 3), 4116.
- **Verdict:** CORRECT as cited (4116's lead-in: G29).

**21. GA 34-9-202** — Employer and employee examinations. (FindLaw, 2024-03-28)
- **Statute:** (e) one employee-chosen examination paid by the employer "within 120 days of
  receipt of **any** income benefits".
- **Site:** 1682 body, 1702 body and FAQ 5 all say "within 120 days of your **first**
  income-benefit check".
- **Verdict:** WRONG (G10–G12). The statute's text does not fix the window to the first check;
  Tyler should confirm the Board's reading before the rewrite is applied.

**22. GA 34-9-280** — Occupational disease defined. (FindLaw, 2024-03-28)
- **Statute:** five elements in (2)(A)–(E); **partial hearing loss from noise is not an
  occupational disease**; psychiatric and heart and vascular disease excluded unless they arise
  from a separate occupational disease. Noise-induced hearing loss is compensated instead under
  § 34-9-264 (both ears, permanent, harmful noise of 90 dBA or more), also read.
- **Site:** 1652 FAQ 4 is correct. 4111's body states the definition in South Carolina's words,
  and 4111 FAQ 2 calls noise-induced hearing loss "a compensable occupational disease" in Georgia.
- **Verdict:** WRONG on 4111 (G13, G14).

**23. GA 34-9-8** — Statutory employer. (FindLaw, 2024-01-01)
- **Site:** 1782 (body, FAQ 3); 3618 pillar intro (dormant).
- **Verdict:** CORRECT.

**24. GA 40-5-35** — Disqualifying disorders; physician reports. (Justia, 2023)
- **Statute:** no Class C disqualification for epilepsy unless an episode occurred in the
  preceding six months; physicians *may* report; no civil or criminal action for reporting;
  notice and a hearing on revocation.
- **Site:** 1654 (body ×2, key takeaways), 1707 (body, table).
- **Verdict:** CORRECT.

**25. GA 40-6-188** — Highway work zones. (FindLaw, **2021-04-14**)
- **Statute:** speeding in a designated work zone, with the signage present and **either** workers
  **or** barriers, work vehicles or drop-offs, is a misdemeanor of a high and aggravated nature:
  $100–$2,000, up to 12 months, or both. No doubling.
- **Site:** 4539 states the $100–$2,000 range correctly. 4162 body and FAQ 0 say it "doubles
  fines … when workers are present".
- **Verdict:** WRONG on 4162 (G16, G17); the uncited form survives on 4683 and 1799 (G18, G19).

**26. GA 40-6-49** — Following too closely. (FindLaw, 2021-04-14)
- **Site:** 4581 (body, FAQ 2), 1780.
- **Verdict:** CORRECT.

**27. GA 51-1-11.1** — Product sellers not strictly liable. (FindLaw, 2024-03-28)
- **Statute:** "product seller" includes installers and repairers; not liable as a manufacturer in
  strict liability.
- **Site:** 2479, 1864 (body, key takeaways).
- **Verdict:** CORRECT.

**28. GA 51-12-11** — Mitigation. (FindLaw, 2024-03-28)
- **Site:** 2398 (body, FAQ 0) quotes it verbatim; 1706.
- **Verdict:** CORRECT. (The positive-and-continuous-tort exception is not mentioned. Not counted.)

**29. GA 52-7-12** — Boating under the influence. (FindLaw, 2024-03-28)
- **Statute:** 0.08 per se, 0.02 under 21; first and second convictions misdemeanors, third high
  and aggravated, fourth within ten years a felony. A first conviction: $300–$1,000, 10 days to
  12 months, 40 hours' community service, a **DUI Alcohol or Drug Use Risk Reduction Program**,
  and a clinical evaluation. No boater-safety course appears in the section.
- **Site:** 3616 FAQ 3 and 4144 FAQ 0 correct. 4144 body and FAQ 3 add "mandatory boater safety
  courses".
- **Verdict:** WRONG on 4144 (G25, G26).

**30. GA 52-7-8.2** — Personal watercraft. (FindLaw, 2024-03-28)
- **Statute:** life jackets; no operation sunset to sunrise; idle speed within 100 feet of vessels,
  docks, people in the water or residential shoreline; **no operator under 12; 12–15 only with an
  adult aboard or after an approved boating education course**. It contains no
  born-after-1998 rule.
- **Site:** 3616 FAQ 7 and 4895 FAQ 7 attach the 1998 boater-education rule to it.
- **Verdict:** WRONG (G27, G28).

**31. GA 9-3-96** — Tolling for fraud. (Justia, 2019; unchanged since 1933)
- **Site:** 1840 (body, FAQ 0) correct. 1676 says fraud "pauses the limitation, but not the
  repose": see "Needs an attorney".
- **Verdict:** CORRECT as to the section's text.

## Errors: published sentence, correction, authority

Each finding gives the field (FAQ index where relevant), the published sentence verbatim, the
proposed sentence, the authority, the type, and the attorney.

### SC — Graeham C. Gillin

**G1.** 3616 `/practice-areas/boating-accident-lawyers/` — `_roden_faqs[7]`, answer, second
sentence. This also renders as FAQPage schema.
- **Published:** "South Carolina has similar restrictions (S.C. Code § 50-21-145)."
- **Proposed:** "South Carolina has similar restrictions (S.C. Code § 50-21-870)."
- **Authority:** S.C. Code § 50-21-870(B) (life jackets, no operation sunset to sunrise, idle speed
  near docks, vessels and people in the water). § 50-21-145 is a former no-wake-zone section.
- **Type:** MECHANICAL.

**G2.** 4895 `/es/practice-areas/boating-accident-lawyers/` — `_roden_faqs[7]`, answer, second
sentence (Spanish page). This also renders as FAQPage schema.
- **Published:** "Carolina del Sur tiene restricciones similares (S.C. Code § 50-21-145)."
- **Proposed:** "Carolina del Sur tiene restricciones similares (S.C. Code § 50-21-870)."
- **Authority:** S.C. Code § 50-21-870(B).
- **Type:** MECHANICAL.

**G3.** 4207 `/brain-injury-lawyers/second-impact-syndrome/` — `post_content`, "Concussion
Return-to-Play Laws" section, South Carolina sentence.
- **Published:** "South Carolina's Youth Athletic Concussion Prevention Act (S.C. Code § 59-63-75)
  imposes identical requirements — immediate removal and mandatory medical clearance before
  return."
- **Proposed:** "South Carolina's student-athlete concussion law (S.C. Code § 59-63-75) is similar
  but not identical: an athlete suspected of a concussion must be removed from practice or
  competition, may return the same day only if an athletic trainer, physician, physician assistant
  or nurse practitioner finds no signs or symptoms on site, and otherwise needs written clearance
  from a physician."
- **Authority:** S.C. Code § 59-63-75(D)(1)–(3).
- **Attorney:** the Code gives § 59-63-75 no short title. Is "Youth Athletic Concussion Prevention
  Act" a name you would keep? It also appears in 4207 FAQ 2 and 4205 FAQ 0.
- **Type:** RULE REWRITE.

**G4.** 4205 `/brain-injury-lawyers/sports-related-brain-injury/` — `post_content`, "Concussion
Legislation" section, South Carolina sentence.
- **Published:** "South Carolina's Youth Athletic Concussion Prevention Act (S.C. Code § 59-63-75)
  imposes similar requirements, mandating annual concussion education, immediate removal from
  play when concussion is suspected, and written medical clearance before return to activity."
- **Proposed:** "South Carolina's student-athlete concussion law (S.C. Code § 59-63-75) imposes
  similar requirements: an annual concussion information sheet for athletes and parents, removal
  from practice or competition when a concussion is suspected, and, unless an on-site evaluation
  by an athletic trainer, physician, physician assistant or nurse practitioner finds no signs or
  symptoms, written clearance from a physician before return to play."
- **Authority:** S.C. Code § 59-63-75(C), (D)(1)–(3).
- **Type:** RULE REWRITE.

**G5.** 4162 `/construction-accident-lawyers/highway-road-construction-accident/` —
`post_content`, "Work Zone Laws" list, South Carolina item.
- **Published:** "South Carolina: S.C. Code § 56-5-1535 imposes enhanced penalties for speeding in
  highway work zones, including doubled fines and potential license suspension for repeat
  offenses."
- **Proposed:** "South Carolina: S.C. Code § 56-5-1535 makes it an offense to endanger a highway
  worker by driving through a work zone outside the marked lanes or disobeying its traffic control
  devices while workers are present, with mandatory fines of $500 to $1,000, $1,000 to $2,000 if a
  worker is injured, and $2,000 to $5,000 for great bodily injury, plus license points."
- **Authority:** S.C. Code § 56-5-1535(A)–(C), as rewritten by 2017 Act No. 81, which deleted the
  former work-zone speeding provision.
- **Type:** RULE REWRITE.

**G6.** 4164 `/nursing-home-abuse-lawyers/nursing-home-neglect/` — `post_content`, staffing
section.
- **Published:** "South Carolina's S.C. Code § 44-7-110 et seq. (State Certification of Need and
  Health Facility Licensure Act) establishes similar standards."
- **Proposed:** "South Carolina's S.C. Code § 44-7-110 et seq. (State Health Facility Licensure
  Act) establishes similar standards."
- **Authority:** S.C. Code § 44-7-110, as amended by 2023 Act No. 20, § 1.B.
- **Type:** MECHANICAL.

**G7.** 4352 `/blog/jet-ski-personal-watercraft-accidents-charleston/` — `post_content`, "South
Carolina Personal Watercraft Laws" list, first two items.
- **Published (age):** "Minimum operator age — no person under 16 years old may operate a personal
  watercraft"
- **Published (education):** "Boater education — operators born after January 1, 1988 must
  complete an approved boater education course"
- **Proposed (age):** "Who may operate — anyone born after July 1, 2007 must hold a South Carolina
  boating safety certificate (or a qualifying Coast Guard license, another state's certificate or
  a rental safety certificate), or be accompanied by someone 18 or older who qualifies, to operate
  a personal watercraft or a boat of 10 horsepower or more (S.C. Code § 50-21-95)"
- **Proposed (education):** delete the item; the age item above replaces both.
- **Authority:** S.C. Code § 50-21-95(A) (2023 Act No. 74, § 3, effective August 18, 2023). The
  same Act deleted the under-16 rule from § 50-21-870.
- **Type:** RULE REWRITE.

**G8.** 4111 `/workers-compensation-lawyers/occupational-disease/` — `post_content`, "Workers'
Compensation for Occupational Diseases" section, South Carolina sentence.
- **Published:** "South Carolina's occupational disease provision (S.C. Code § 42-11-10 et seq.)
  provides similar coverage, defining an occupational disease as one that is due to causes and
  conditions characteristic of and peculiar to the particular trade, occupation, or employment."
- **Proposed:** "South Carolina defines an occupational disease as one arising out of and in the
  course of employment that is due to hazards in excess of those ordinarily incident to employment
  and peculiar to the occupation, and the worker must prove by a preponderance of the evidence
  that it arose directly and naturally from exposure in South Carolina to those hazards (S.C. Code
  § 42-11-10(A))."
- **Authority:** S.C. Code § 42-11-10(A), as rewritten by 2007 Act No. 111.
- **Type:** RULE REWRITE.

**G9.** 4087 `/practice-areas/bicycle-accident-lawyers/` — common-causes list
(`_roden_common_causes`, item 3), rendered on the pillar.
- **Published:** "Drivers passing too closely (violating 3-foot law)"
- **Proposed:** "Drivers passing too closely (inside Georgia's 3-foot minimum, or without a safe
  operating distance in South Carolina)"
- **Authority:** S.C. Code § 56-5-3435 (a safe operating distance, no figure); O.C.G.A. § 40-6-56.
- **Type:** MECHANICAL.

### GA — Tyler Love

**G10.** 1682 `/blog/how-long-can-a-person-stay-on-workers-compensation/` — `post_content`, "Get
an Independent Medical Opinion".
- **Published:** "In Georgia, you get one insurer-paid exam by a doctor you choose if you request
  it within 120 days of your first income-benefit check (O.C.G.A. § 34-9-202(e))."
- **Proposed:** "In Georgia, you get one insurer-paid exam by a doctor you choose within 120 days
  of receiving any income benefits (O.C.G.A. § 34-9-202(e))."
- **Authority:** O.C.G.A. § 34-9-202(e) ("within 120 days of receipt of any income benefits").
- **Attorney:** does the State Board read the 120 days from the latest payment, as the text
  suggests? The proposal follows the statute's words and does not pick a reading.
- **Type:** RULE REWRITE.

**G11.** 1702 `/blog/maximum-medical-improvement-in-an-injury-claim/` — `post_content`, "In
Workers' Compensation Cases", Georgia list.
- **Published:** "Use your one-time independent medical examination by a physician of your
  choosing at the insurer's expense — the request must be made within 120 days of your first
  income-benefit check (O.C.G.A. § 34-9-202(e))"
- **Proposed:** "Use your one-time independent medical examination by a physician of your
  choosing at the insurer's expense — it must take place within 120 days of your receiving any
  income benefits (O.C.G.A. § 34-9-202(e))"
- **Authority:** O.C.G.A. § 34-9-202(e).
- **Type:** RULE REWRITE.

**G12.** 1702 — `_roden_faqs[5]`, answer, item (4). This also renders as FAQPage schema.
- **Published:** "(4) in Georgia, use your one-time independent examination at the insurer's
  expense within 120 days of your first income-benefit check (O.C.G.A. § 34-9-202(e))"
- **Proposed:** "(4) in Georgia, use your one-time independent examination at the insurer's
  expense within 120 days of receiving any income benefits (O.C.G.A. § 34-9-202(e))"
- **Authority:** O.C.G.A. § 34-9-202(e).
- **Type:** RULE REWRITE.

**G13.** 4111 `/workers-compensation-lawyers/occupational-disease/` — `post_content`, "Workers'
Compensation for Occupational Diseases" section, Georgia sentence.
- **Published:** "Georgia law defines an occupational disease as a disease arising out of and in
  the course of employment that is caused by hazards recognized as peculiar to a particular trade,
  occupation, or process (O.C.G.A. § 34-9-280)."
- **Proposed:** "Georgia law defines an occupational disease as one arising out of and in the
  course of the particular trade, occupation, process or employment in which the worker is
  exposed to it, and the worker must prove five elements, including a direct causal connection
  between the working conditions and the disease and that it is not an ordinary disease of life
  to which the general public is exposed (O.C.G.A. § 34-9-280(2))."
- **Authority:** O.C.G.A. § 34-9-280(2)(A)–(E). The published wording is South Carolina's
  (§ 42-11-10(A)).
- **Type:** RULE REWRITE.

**G14.** 4111 — `_roden_faqs[2]`, answer, first two sentences. This also renders as FAQPage schema.
- **Published:** "Yes. Occupational hearing loss from prolonged noise exposure is a compensable
  occupational disease in both Georgia and South Carolina."
- **Proposed:** "Yes, in both states, but Georgia does not treat it as an occupational disease:
  O.C.G.A. § 34-9-280(2) excludes partial hearing loss from noise, and § 34-9-264 instead
  compensates permanent hearing loss in both ears caused by prolonged exposure to harmful
  workplace noise."
- **Authority:** O.C.G.A. § 34-9-280(2) (last paragraph); § 34-9-264(a)–(b).
- **Also:** the South Carolina half is unchanged; Graeham should confirm it.
- **Type:** RULE REWRITE.

**G15.** 1780 `/blog/rear-end-collision-liability/` — `post_content`, "When the Driver Who Gets
Rear-Ended is at Fault" list, first item.
- **Published:** "Slamming on the brakes when there is no reason (O.C.G.A. § 40-6-123(c))"
- **Proposed:** "Stopping or slowing suddenly without first signaling to the driver behind when
  there was a chance to (O.C.G.A. § 40-6-123(c))"
- **Authority:** O.C.G.A. § 40-6-123(c).
- **Type:** MECHANICAL.

**G16.** 4162 `/construction-accident-lawyers/highway-road-construction-accident/` —
`post_content`, "Work Zone Laws" list, Georgia item.
- **Published:** "Georgia: O.C.G.A. § 40-6-188 doubles fines for speeding in active work zones when
  workers are present."
- **Proposed:** "Georgia: speeding in a marked highway work zone is a high and aggravated
  misdemeanor punishable by a fine of $100 to $2,000, up to 12 months in jail, or both, when
  workers or hazards such as barriers, work vehicles or pavement drop-offs are present (O.C.G.A.
  § 40-6-188)."
- **Authority:** O.C.G.A. § 40-6-188(e) (text current as of April 14, 2021).
- **Attorney:** the next sentence, "Georgia law also authorizes enhanced penalties for reckless
  driving in construction zones," cites nothing, and § 40-6-188 covers speeding only. Keep it with
  a citation, or drop it?
- **Type:** RULE REWRITE.

**G17.** 4162 — `_roden_faqs[0]`, question and answer. This also renders as FAQPage schema.
- **Published (question):** "Are fines doubled in Georgia construction zones?"
- **Published (answer):** "Yes. Georgia law (O.C.G.A. § 40-6-188) doubles fines for speeding in
  active work zones when construction workers are present."
- **Proposed (question):** "What is the penalty for speeding in a Georgia construction zone?"
- **Proposed (answer):** "Georgia does not double the fine. Speeding in a marked highway work zone
  is a separate high and aggravated misdemeanor: a fine of $100 to $2,000, up to 12 months in
  jail, or both, when workers or hazards such as barriers or pavement drop-offs are present
  (O.C.G.A. § 40-6-188)."
- **Authority:** O.C.G.A. § 40-6-188(e).
- **Type:** RULE REWRITE.

**G18.** 4683 `/resources/i-16-i-95-construction-zone-truck-accidents/` — `post_content`,
"Georgia Law: Deadlines & Fault Rules" list.
- **Published:** "Work zone speed violations: Georgia law doubles fines for speeding in active
  construction zones, and work zone speeding can be used as evidence of negligence in a civil
  case."
- **Proposed:** "Work zone speed violations: speeding in a marked Georgia highway work zone carries
  a fine of $100 to $2,000 (O.C.G.A. § 40-6-188), and work zone speeding can be used as evidence of
  negligence in a civil case."
- **Authority:** O.C.G.A. § 40-6-188(e).
- **Type:** RULE REWRITE.

**G19.** 1799 `/blog/safe-driving-in-construction-zones/` — `post_content`, speeding paragraph.
- **Published:** "Also, speeding is expensive because tickets are usually doubled in construction
  zones."
- **Proposed:** "Also, speeding is expensive: in Georgia, speeding in a marked highway work zone
  carries a fine of $100 to $2,000 (O.C.G.A. § 40-6-188)."
- **Authority:** O.C.G.A. § 40-6-188(e). South Carolina has had no work-zone speeding enhancement
  since 2017 Act No. 81 rewrote § 56-5-1535.
- **Type:** RULE REWRITE.

**G20.** 4207 `/brain-injury-lawyers/second-impact-syndrome/` — `post_content`, "Concussion
Return-to-Play Laws" section, Georgia sentences.
- **Published (rule):** "Georgia's Return to Play Act of 2013 (O.C.G.A. § 20-2-324.1) mandates that
  any youth athlete suspected of sustaining a concussion must be immediately removed from play and
  prohibited from returning until cleared in writing by a qualified healthcare provider."
- **Published (scope):** "The law applies to all youth athletic activities organized by schools and
  youth sports organizations."
- **Proposed (rule):** "Georgia's Return to Play Act of 2013 (O.C.G.A. § 20-2-324.1) requires
  public, private and charter schools to adopt a policy under which a youth athlete who shows
  symptoms of a concussion is removed from the game or practice and evaluated by a health care
  provider, and an athlete found to have a concussion may not return until a health care provider
  clears it."
- **Proposed (scope):** "Public recreation programs must give parents a concussion information
  sheet at registration; church and synagogue leagues, lessons and college sports are outside the
  statute."
- **Authority:** O.C.G.A. § 20-2-324.1(a)(4), (b), (c).
- **Type:** RULE REWRITE.

**G21.** 4207 — `post_content`, the two sentences after the South Carolina sentence.
- **Published (liability):** "Coaches and organizations that violate these laws bear direct
  liability for resulting brain injuries."
- **Published (per se):** "Violation of these statutes constitutes negligence per se — automatic
  proof of negligence — in a lawsuit for second impact syndrome injuries."
- **Proposed (liability):** "Neither statute creates a lawsuit of its own. Georgia's says that it
  creates no liability or cause of action against a school, a recreation program or their staff
  for removing or not removing an athlete (O.C.G.A. § 20-2-324.1(e)), and South Carolina's shields
  the trainer or physician who clears an athlete except for gross negligence or wilful misconduct
  (S.C. Code § 59-63-75(D)(5))."
- **Proposed (per se):** "A claim against a coach or school rests on ordinary negligence, and the
  return-to-play protocol is evidence of what reasonable care required."
- **Authority:** O.C.G.A. § 20-2-324.1(e); S.C. Code § 59-63-75(D)(5).
- **Attorney:** is a school's own concussion policy admissible in Georgia as evidence of the
  standard of care, given subsection (e)? The second proposed sentence assumes it is.
- **Also:** the South Carolina half of the first proposed sentence is for Graeham.
- **Type:** RULE REWRITE.

**G22.** 4207 — `_roden_faqs[2]`, answer. This also renders as FAQPage schema.
- **Published:** "Yes. Georgia's Return to Play Act (O.C.G.A. § 20-2-324.1) and South Carolina's
  Youth Athletic Concussion Prevention Act (S.C. Code § 59-63-75) require immediate removal from
  play and medical clearance. A coach who violates these laws is negligent."
- **Proposed:** "Possibly, but not because of the statutes alone. Both states require removal from
  play and clearance before return (O.C.G.A. § 20-2-324.1; S.C. Code § 59-63-75), but Georgia's
  law says it creates no liability or cause of action for removing or not removing an athlete
  (§ 20-2-324.1(e)). A claim rests on ordinary negligence, and the protocol helps show what
  reasonable care required."
- **Authority:** O.C.G.A. § 20-2-324.1(b), (e); S.C. Code § 59-63-75(D).
- **Type:** RULE REWRITE.

**G23.** 4205 `/brain-injury-lawyers/sports-related-brain-injury/` — `post_content`, "Concussion
Legislation" section, Georgia sentences.
- **Published (rule):** "Georgia's Return to Play Act of 2013 (O.C.G.A. § 20-2-324.1) requires
  youth sports organizations and schools to provide concussion information to athletes and
  parents, remove from play any athlete suspected of sustaining a concussion, and require written
  clearance from a licensed healthcare provider before the athlete can return to play."
- **Published (negligence):** "Failure to comply with these requirements can serve as evidence of
  negligence."
- **Proposed (rule):** "Georgia's Return to Play Act of 2013 (O.C.G.A. § 20-2-324.1) requires
  public, private and charter schools to give parents a concussion information sheet before each
  season, remove an athlete who shows concussion symptoms for evaluation by a health care
  provider, and keep an athlete with a concussion out until a health care provider clears a
  return; public recreation programs must give parents the information sheet."
- **Proposed (negligence):** "The statute itself creates no liability or cause of action (O.C.G.A.
  § 20-2-324.1(e)), but a school's own concussion policy can be evidence of what reasonable care
  required."
- **Authority:** O.C.G.A. § 20-2-324.1(b), (c), (e).
- **Type:** RULE REWRITE.

**G24.** 4205 — `_roden_faqs[2]`, answer. This also renders as FAQPage schema.
- **Published:** "Georgia's Return to Play Act (O.C.G.A. § 20-2-324.1) requires youth sports
  organizations to educate athletes and parents about concussions, remove athletes suspected of
  having a concussion, and require medical clearance before return to play. Violations support
  negligence claims."
- **Proposed:** "Georgia's Return to Play Act (O.C.G.A. § 20-2-324.1) requires public, private and
  charter schools to give parents a concussion information sheet before each season, remove an
  athlete who shows concussion symptoms for evaluation by a health care provider, and keep an
  athlete with a concussion out until a health care provider clears a return. Public recreation
  programs must give parents the information sheet. The statute itself creates no liability or
  cause of action (§ 20-2-324.1(e))."
- **Authority:** O.C.G.A. § 20-2-324.1(b), (c), (e).
- **Type:** RULE REWRITE.

**G25.** 4144 `/boating-accident-lawyers/boating-under-influence/` — `post_content`, "BUI Laws"
list, Georgia item, second sentence.
- **Published:** "Penalties include fines, jail time, and mandatory boater safety courses."
- **Proposed:** "Penalties include fines, jail time, community service and a DUI Alcohol or Drug Use
  Risk Reduction Program."
- **Authority:** O.C.G.A. § 52-7-12(m)(1)(A)–(E).
- **Type:** RULE REWRITE.

**G26.** 4144 — `_roden_faqs[3]`, answer, first sentence. This also renders as FAQPage schema.
- **Published:** "Georgia BUI (O.C.G.A. § 52-7-12) is a misdemeanor with penalties including fines
  up to $1,000, up to 12 months in jail, and mandatory completion of a boater safety course."
- **Proposed:** "Georgia BUI (O.C.G.A. § 52-7-12) is a misdemeanor with penalties including fines
  up to $1,000, up to 12 months in jail, community service and completion of a DUI Alcohol or Drug
  Use Risk Reduction Program."
- **Authority:** O.C.G.A. § 52-7-12(m)(1)–(2).
- **Attorney:** is a boater-education course required anywhere else after a BUI conviction, for
  example as a condition of restoring vessel-operating privileges? If so, cite it and keep the
  course.
- **Type:** RULE REWRITE.

**G27.** 3616 `/practice-areas/boating-accident-lawyers/` — `_roden_faqs[7]`, answer, first
sentence. This also renders as FAQPage schema.
- **Published:** "Yes. Georgia law (O.C.G.A. § 52-7-8.2) restricts personal watercraft operation
  near other vessels and swimmers, prohibits operation after sunset, and requires operators born
  after January 1, 1998 to complete a boating safety course."
- **Proposed:** "Yes. Georgia law (O.C.G.A. § 52-7-8.2) bars personal watercraft from running above
  idle speed within 100 feet of other vessels, docks, people in the water or the shore, prohibits
  operation between sunset and sunrise, bars anyone under 12 from operating one, and allows 12- to
  15-year-olds to operate one only with an adult aboard or after an approved boating education
  course."
- **Authority:** O.C.G.A. § 52-7-8.2(d), (j), (l), (m).
- **Attorney:** the born-on-or-after-January-1-1998 boater-education rule is not in § 52-7-8.2. If
  you want it kept, which section carries it (believed to be § 52-7-8, which this read could not
  reach), and is the cutoff "after" or "on or after"?
- **Type:** RULE REWRITE.

**G28.** 4895 `/es/practice-areas/boating-accident-lawyers/` — `_roden_faqs[7]`, answer, first
sentence (Spanish page). This also renders as FAQPage schema.
- **Published:** "Sí. La ley de Georgia (O.C.G.A. § 52-7-8.2) restringe el uso de motos acuáticas
  cerca de otras embarcaciones y de nadadores, prohíbe operarlas después de la puesta del sol y
  exige que los operadores nacidos después del 1 de enero de 1998 completen un curso de seguridad
  náutica."
- **Proposed:** "Sí. La ley de Georgia (O.C.G.A. § 52-7-8.2) prohíbe operar motos acuáticas a más
  de velocidad mínima a menos de 100 pies de otras embarcaciones, muelles, personas en el agua o
  la orilla, prohíbe operarlas entre la puesta y la salida del sol, prohíbe que las operen menores
  de 12 años y permite que los de 12 a 15 años las operen solo con un adulto a bordo o tras
  aprobar un curso de educación náutica."
- **Authority:** O.C.G.A. § 52-7-8.2(d), (j), (l), (m).
- **Type:** RULE REWRITE.

**G29.** 4116 `/dog-bite-lawyers/child-dog-bite/` — `post_content`, procedural-rules paragraph.
- **Published:** "A parent or legal guardian must bring the claim on the child's behalf as "next
  friend," and any settlement must be approved by the court to protect the child's interests."
- **Proposed:** "A parent or legal guardian must bring the claim on the child's behalf as "next
  friend," and larger settlements must be approved by a court to protect the child's interests."
- **Authority:** O.C.G.A. § 29-3-3(c)(1) (no approval at $25,000 gross or less); S.C. Code
  § 62-5-433(D) (no approval at $2,500 or less). The next sentence on the page already states the
  thresholds correctly.
- **Also:** both states; Graeham should see the South Carolina half.
- **Type:** MECHANICAL.

## Error count

| Section | Findings | Docs | MECH | RULE |
|---|---|---|---|---|
| SC 50-21-145 (re-cite to § 50-21-870) | G1–G2 | 3616, 4895 | 2 | 0 |
| SC 59-63-75 (concussion) | G3–G4 | 4207, 4205 | 0 | 2 |
| SC 56-5-1535 (work zone, supporting section) | G5 | 4162 | 0 | 1 |
| SC 44-7-110 (Act name) | G6 | 4164 | 1 | 0 |
| SC 50-21-95 (boater education, class sweep) | G7 | 4352 | 0 | 1 |
| SC 42-11-10 | G8 | 4111 | 0 | 1 |
| SC three-foot rule (class sweep) | G9 | 4087 | 1 | 0 |
| GA 34-9-202 | G10–G12 | 1682, 1702 | 0 | 3 |
| GA 34-9-280 / -264 | G13–G14 | 4111 | 0 | 2 |
| GA 40-6-123 | G15 | 1780 | 1 | 0 |
| GA 40-6-188 (cited and uncited) | G16–G19 | 4162, 4683, 1799 | 0 | 4 |
| GA 20-2-324.1 (concussion) | G20–G24 | 4207, 4205 | 0 | 5 |
| GA 52-7-12 | G25–G26 | 4144 | 0 | 2 |
| GA 52-7-8.2 | G27–G28 | 3616, 4895 | 0 | 2 |
| Minor settlements (uncited lead-in) | G29 | 4116 | 1 | 0 |
| **Total** | **29** | **16** | **6** | **23** |

## Class sweeps run (cited and uncited, both columns, EN and ES, every surface)

- **GA e-scooter rules** (40-6-320, PTV, EPAMD, § 40-1-1(15.4)/(43.4), ages 15/16, 20 mph,
  bicyclist status): confined to the pages pass 2 already filed (4088, 4224, 4227, 4229). The
  other sub-types (4225, 4228), the ES pillar (4899) and the helmet and moped resources (6312,
  6313, 6315, 6316) make no Georgia scooter rule.
- **GA golf-cart rules** (40-6-330/-331, 25/35 mph, daylight, age 16, learner's permit): confined
  to 4090, 4186, 4190. The other sub-types (4187, 4188, 4189) and the ES pillar (4901) state no
  Georgia figure. 3497's 15 mph is a posted community limit. 4343 and 6314 (SC, § 56-2-90) are
  correct.
- **SC three-foot passing rule** ("3-foot", "three feet", "3 pies"): one new survivor, G9 (an
  uncited list item in a rendered meta field). 4087's `_roden_why_hire`, FAQ 1 and key takeaways,
  4106, 4898 FAQ 5 and 1698 FAQ 3 are correct. 4639 and 1698's body and key takeaways are pass 2's
  F17–F19.
- **"First income-benefit check"** (120-day IME): 1682, 1702 ×2 only (G10–G12).
- **Doubled work-zone fines** (EN and ES): 4162 ×2, 4683, 1799 (G16–G19). 4635 states § 56-5-1535
  correctly.
- **Boater safety course** (BUI and personal watercraft): 4144 ×2, 3616, 4895 and 4352 (G7,
  G25–G28).
- **Concussion statutes as a source of liability:** 4207 and 4205 only. The general concussion
  mentions on 15 other pages make no statutory claim.
- **Hearing loss as an occupational disease:** 4111 FAQ 2 only.
- **"Any settlement" of a minor's claim needs approval:** 4116 only.
- **§ 50-21-145, § 56-5-1535 and the pre-2023 SC licensure Act name:** as listed in G1, G2, G5, G6.

## Dormant (stored, not rendered)

`roden_render_pillar_intro()` is still not called anywhere (as pass 2 found), so
`_roden_pillar_negligence_intro` does not publish. One more stored intro is wrong and would
publish if the renderer is wired up:

| Post | Stored text | Problem |
|---|---|---|
| 4087 bicycle pillar | "A **3-foot passing rule** applies to motorists overtaking cyclists ({{GA}}O.C.G.A. § 40-6-56{{/GA}}{{SC}}S.C. Code § 56-5-3435{{/SC}})" | The SC branch renders a three-foot rule against § 56-5-3435, which names no distance. |

3618's construction intro (§ 34-9-8) and 3616's boating intro (§ 52-7-12) were read and are
correct. Not counted as live errors.

## Optional imprecisions (not counted)

- 1697 (§ 34-9-104): benefit suspension on resignation is a § 34-9-240 matter.
- 1713 (§ 24-6-601): personal knowledge and the oath are §§ 24-6-602 and -603.
- 1758 body and FAQ 5 (§ 24-6-609): ten years from conviction or release, whichever is later.
- 2398 and 1706 (§ 51-12-11): the positive-and-continuous-tort exception.
- 4189 and 4144 FAQ 2 (§ 61-4-580): beer and wine only (liquor is § 61-6-2220); "visibly" is the
  case-law gloss.
- 4162: "negligence per se … meaning the violator is automatically considered negligent" — the
  site elsewhere says per se establishes duty and breach, not causation. Consider aligning.

## Needs an attorney

- **Tyler Love:**
  - All GA findings, and a 2024–2026 session-law check before G16–G24 are applied (§ 40-6-188 was
    read only in a 2021 text).
  - G10–G12: the Board's reading of "within 120 days of receipt of any income benefits".
  - G16: the uncited reckless-driving-in-construction-zones sentence on 4162.
  - G21: whether a school's concussion policy is admissible as the standard of care despite
    § 20-2-324.1(e).
  - G26: any boater-course requirement outside § 52-7-12.
  - G27/G28: the section and wording of the 1998 boater-education rule.
  - 1676 (`/blog/medical-malpractice-limits-georgia/`, body): "Fraud by the provider pauses the
    limitation, but not the repose, until the fraud is discovered (O.C.G.A. § 9-3-96)." Georgia
    appellate cases have held a provider's fraud can toll or estop the medical-malpractice repose
    in § 9-3-71; that case law was not read here. Not filed as an error; confirm or correct.
- **Graeham C. Gillin:**
  - G3–G9.
  - The South Carolina halves of G14, G21 and G29.
  - G3: whether to keep the "Youth Athletic Concussion Prevention Act" name.

## Pack PR candidates

- **SC:**
  - Add § 50-21-870 (personal watercraft) and § 50-21-95 (boater education from July 1, 2007), with
    a forbidden-claim rule: no under-16 personal-watercraft ban since 2023 Act No. 74, and no
    "born after 1988" rule.
  - Add § 56-5-1535 as endangerment of a highway worker, with a rule that it is not a speeding or
    doubled-fine statute.
  - Add § 59-63-75 with the same-day-return and evaluator-immunity points.
  - § 44-7-110: the post-2023 name.
- **GA:**
  - Add § 40-6-188(e) ($100–$2,000; workers or hazards), with a forbidden-claim rule: no doubled
    work-zone fines.
  - Add § 20-2-324.1, with a rule that it creates no liability or cause of action ((e)).
  - Add § 34-9-202(e) ("any income benefits"), and § 34-9-264 with the hearing-loss exclusion from
    § 34-9-280(2).
  - Add § 52-7-8.2 age rules (under 12 barred; 12–15 conditional) and § 52-7-12(m) (risk-reduction
    program, not a boater course).

## Coverage

- Before this pass (tracker, 2026-10-24): 217 statutes / 275 page-citations unverified; 89.5% of
  2,620 page-citations verified.
- This pass read 30 statutes covering 64 page-citations. If the tracker records them as read:
  **187 statutes / 211 page-citations unverified; about 91.9% verified.** Eleven of the 30 are
  read but carry open errors (G1–G29).
- Supporting sections read and not in the ranked 30: SC §§ 50-21-95, 50-21-870, 56-5-1535; GA
  § 34-9-264. They are not counted in the figures above.
- The rest of the list is a tail: after these 30, every unverified section sits on two pages or
  fewer (24 at two, 163 at one, per the tracker).

## Supporting sections read

- **SC:** §§ 50-21-95, 50-21-114, 50-21-870, 56-5-1535, and the 50-21-1xx section list, from
  scstatehouse.gov t50c021 and t56c005.
- **GA:** § 34-9-264 (FindLaw capture, current as of 2024-03-28).
