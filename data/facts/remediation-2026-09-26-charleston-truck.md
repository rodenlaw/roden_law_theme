# Pre-publish legal sweep: Charleston truck accident page (post 3629, DRAFT)

- **Page:** `/truck-accident-lawyers/charleston-sc/` (post 3629, `practice_area`, draft; parent: truck pillar, post 3605).
- **Jurisdiction:** South Carolina only. Reviewer of record: Graeham C. Gillin (SC Bar).
- **What was swept:** the rendered draft HTML (`scratchpad/preview/draft3629.html`) and all 7 JSON-LD blocks in it (LegalService, Person, FAQPage, WebPage, HowTo, LocalBusiness/LegalService/LawFirm, BreadcrumbList).
  - **Page surfaces**, from `bin/rebuild-charleston-truck-accident.php`: body, excerpt, meta description, key takeaways, 6 FAQs.
  - **Template blocks:** hero, NAP bar, office map and directions, law box, what-to-do steps and HowTo, the local-context essay, the truck pillar's negligence and compensation intros (as corrected today by `bin/fix-truck-pillar-intros.php`), the stats block, resources, the sidebar and the footer.
- **Pack:** `law/SC.json` at `origin/main` (`cf4a43b`). It is **SIGNED**: Graeham C. Gillin, 2026-09-26, `verifiedBy` set on all 27 authorities, including §§ 56-5-1260 and 56-5-1270 (#64, #65).
- **Engine run:**
  - 111 blocks from the rendered text, the FAQPage and HowTo JSON-LD, and the LegalService description were replayed through `sweep-claims.mjs --fixtures scratchpad/draft3629-fixture.json --law scratchpad/law-main` (SC + GA rules, `origin/main` packs).
  - Result: **0 findings**.
  - A positive control (a § 15-38-15 miscite) fired, which confirms the rules were loaded.
  - Every finding below comes from hand reading, by claim class.

**Verdict: PASS. No error-level finding.**
- There are 4 warnings: 2 PAGE and 2 TEMPLATE. One more TEMPLATE warning is carried over from the car sweep.
- W1 is a false statement about where the firm's own office is. It is already live on every page that renders the Charleston office block. Fix it before or with this publish.
- The byline "Reviewed by Graeham C. Gillin" must not go live until he has actually reviewed this page. The rebuild script correctly leaves `_roden_last_reviewed` unset.

Source key:
- **PAGE** means `bin/rebuild-charleston-truck-accident.php`.
- **TEMPLATE** means the theme, `inc/firm-data.php`, or truck-pillar meta. A TEMPLATE fix reaches other pages too.

---

## WARN

### W1. The office directions put 127 King Street at King and Calhoun

- **Surface / block:** body, "Visit Our Charleston Office", "Getting here".
- **Source:** TEMPLATE, `inc/firm-data.php` line 181 (`offices.charleston.directions`).
  - Rendered by `template-intersection.php:307` and `template-location.php:473`.
  - So it is already live on the Charleston car page and on `/locations/south-carolina/charleston/`. I could not re-fetch those pages: WP Engine returned its 5.5 KB challenge page.
- **Published:** "Our Charleston office is in the heart of downtown on King Street, Suite 200, near the intersection of King and Calhoun streets. From I-26 East, take Exit 221B onto Meeting Street heading south, then turn right on Calhoun and left on King. From Mount Pleasant, cross the Ravenel Bridge and follow US-17 S to the Meeting Street exit. Street and garage parking available nearby."
- **Corrected:** "Our Charleston office is downtown at 127 King Street, Suite 200, between Broad and Queen streets, about a block from the Charleston County Judicial Center. From I-26 East, take Exit 221B onto Meeting Street heading south toward Broad Street. From Mount Pleasant, cross the Ravenel Bridge and follow US-17 S to the Meeting Street exit. Street and garage parking available nearby."
  - The office should confirm the last turns before this ships. I did not verify one-way segments on lower King.
- **Authority:** no law authority applies; this is a firm fact.
  - The page's own LocalBusiness `geo` (32.777514, −79.932945) and OpenStreetMap place 127 King St at 32.7771, −79.9331. That is the King Street Antiques District, between Broad (32.7763) and Queen (32.7776).
  - King and Calhoun (Marion Square) is at about 32.7855, roughly 0.6 mile north.
- **Rule:** none. The engine does not check firm geography.
- **Related:** the PAGE sentence "Charleston County Judicial Center, 100 Broad Street, a few blocks from our King Street office" is true but loose. It is about a block. Optional: change it to "about a block".

### W2. FAQ 5 and the key takeaways give the SCTCA deadline without the verified-claim extension

- **Surface / block:** FAQ 5, which is also in the FAQPage JSON-LD; the key takeaways.
- **Source:** PAGE (`$faqs[4]`, `$key_takeaways`).
- **Published (FAQ 5):** "The South Carolina Tort Claims Act applies. Suit must be filed within two years (S.C. Code § 15-78-110), and recovery is capped at $300,000 per person and $600,000 per occurrence, with no punitive damages (S.C. Code § 15-78-120)."
- **Corrected (FAQ 5):** "The South Carolina Tort Claims Act applies. Suit must be filed within two years (S.C. Code § 15-78-110), or three years if a verified claim is first filed with the agency within one year (S.C. Code § 15-78-80). Recovery is capped at $300,000 per person and $600,000 per occurrence, with no punitive damages (S.C. Code § 15-78-120)."
- **Published (KT):** "…or two years if the truck belonged to a government entity such as the City of Charleston or SCDOT (S.C. Code § 15-78-110)."
- **Corrected (KT):** "…or generally two years if the truck belonged to a government entity such as the City of Charleston or SCDOT (S.C. Code § 15-78-110)."
- **Authority:** `SC 15-78-110`, `SC 15-78-80` (signed).
- **Rule:** none. The sentence is incomplete rather than false, and it errs toward a shorter deadline.
- **Why it matters:** FAQ 2 and the body both state the three-year extension. FAQ 5 is the answer that stands alone in structured data, so an AI answer lifted from it gives "two years" flat. The page disagrees with itself across its own surfaces.

### W3. The punitive-damages sentence states no standard of proof

- **Surface / block:** body, "Types of Compensation in South Carolina Truck Accident Cases".
- **Source:** TEMPLATE, truck pillar (post 3605) `_roden_pillar_compensation_intro`, as rewritten today. The sentence sits outside the `{{SC}}` and `{{GA}}` branches, so it renders in both states.
- **Published:** "Falsified logs, hours-of-service violations, and gross safety-management failures can support a claim for punitive damages."
- **Corrected (in the `{{SC}}` branch):** "Where falsified logs, hours-of-service violations or gross safety-management failures show reckless disregard for safety, they can support a claim for punitive damages, which must be proven by clear and convincing evidence (S.C. Code § 15-33-135)."
  - The GA branch keeps its own sentence.
- **Authority:** `SC 15-33-135` (signed; this is the burden of proof).
  - The pack holds no authority for the willful, wanton or reckless conduct standard. That standard is common law, so the corrected sentence says "reckless disregard" and cites only the burden.
- **Rule:** none. Severity is low: "can support" is already hedged, and no dollar figure appears.

### W4. Federal claims with no pack authority (the claims are true; the authorities are missing)

- **Surface / block:**
  - body, "Who Can Be Responsible…" (PAGE);
  - "Do I Have a Truck Accident Case…" (TEMPLATE, pillar `_roden_pillar_negligence_intro`).
- **Published:**
  - "Federal safety rules for commercial trucks, covering hours of service, driver qualification, vehicle inspection and maintenance, and drug and alcohol testing, are set by the Federal Motor Carrier Safety Administration. A violation can be strong evidence that the driver or the carrier was careless."
  - The template: "…the Federal Motor Carrier Safety Regulations govern hours of service, driver qualification, vehicle maintenance, and drug and alcohol testing…"
  - Broker liability, in 6 places: the meta description, the excerpt/LegalService description, the KT, FAQ 3, and the body twice. For example: "handle South Carolina truck claims against drivers, carriers and brokers".
- **Corrected:** no change to the wording. Both claims check out against primary text:
  - **FMCSR subjects:** eCFR Title 49, Chapter III. Part 382 is Controlled Substances and Alcohol Use and Testing; Part 391 is Qualifications of Drivers; Part 395 is Hours of Service of Drivers; Part 396 is Inspection, Repair, and Maintenance. Retrieved 2026-09-26.
  - **Broker liability:** *Montgomery v. Caribe Transport II, LLC*, No. 24-1238 (U.S. May 14, 2026), unanimous. It holds that a negligent-hiring claim against a broker is not preempted by the FAAAA (49 U.S.C. § 14501(c)(1)) because of the safety exception in § 14501(c)(2)(A). Read against the slip opinion at supremecourt.gov/opinions/25pdf/24-1238_1b7d.pdf.
- **Authority:** none in any pack. See the proposed pending authorities below. Until Gillin signs them, his page review is the only attorney check these claims get.
- **Rule:** n/a.
- **Nothing specific is unsupported:**
  - There are no hours figures, no ELD retention period, no MCS-90 amounts, and no 49 C.F.R. section numbers.
  - `§ 58-23-10` and `MCS-90` were removed by today's pillar fix and do not render.

## Carried over from the car sweep (not new)

### C1. "Cases successfully handled since 2013"

- **Source:** TEMPLATE, the stats block (car sweep W8).
- **Status:** still rendering.
- **Recommendation (unchanged):** "Cases handled since 2013".

## Checks that PASS

| Check | Result |
|---|---|
| Georgia law | **None.** No O.C.G.A. cite, no GA deadline, no GA rule anywhere in the HTML or JSON-LD. The pillar intros' `{{GA}}` branches do not render. GA mentions are firm-level only ("Serving Georgia & South Carolina", "Licensed in GA & SC", the office list, the footer). The resources block is SC-only (#165). |
| Punitive dollar figure | **None.** There is no $500,000, $739,245 or $2,000,000. The only punitive statements are "no punitive damages" against a government entity (§ 15-78-120, correct) and W3. |
| SOL | 3 years, S.C. Code § 15-3-530, the same in the KT, FAQ 2, law box, essay, pillar intro ("generally") and sidebar ("usually ends"). |
| SCTCA | 2 years under § 15-78-110 / 3 years under § 15-78-80 "optional" (body, FAQ 2); caps of $300,000 / $600,000 and no punitive damages under § 15-78-120 (body, FAQ 5, compensation intro). No "notice" wording anywhere; the essay (fixed in #163) no longer carries it. |
| Comparative fault | *Nelson v. Concrete Supply Co.* is cited (in full in the law box). **§ 15-38-15 appears nowhere.** The KT and FAQ 4 say "50% or less"; the law box and essay say "less than 51%". The car sweep accepted these as equivalent. Gillin may want "50% or less" everywhere, because a fractional share such as 50.5% separates the two. |
| UM / UIM | § 38-77-150 mandatory UM and § 38-77-160 UIM must be offered, matching the pack. |
| Police report (step 5 and HowTo step 5) | §§ 56-5-1260 / 56-5-1270, matching the signed pack wording (#166). Body and HowTo are identical. |
| NHTSA FARS statistic | "126 fatal large-truck crashes in 2024" = `data/statistics.json` `sc-fatal-large-truck-crashes` (value 126, asOf 2024, retrieved 2026-08-25, review every 180 days). Attributed to FARS. |
| Port of Charleston terminals | Verified on scspa.com 2026-09-26. **Wando Welch Terminal**: 400 Long Point Road, Mt. Pleasant, reached by I-526 E, Long Point Road exit. **North Charleston Terminal**: 1000 Remount Rd, North Charleston. **Hugh K. Leatherman Terminal**: 1500 Port Access Road, North Charleston, reached from I-26 Exit 218 by Port Access Road. The page's "including" is correct because Columbus Street also exists. The I-526 and Port Access Road statements are consistent with SCPA's own directions. |
| Local-context essay | Matches the #163 correction: "usually filed", ADR mediation, and MUSC "adult and pediatric Level I" with no superlative. No 2,500 or 354 figures. |
| Citation format | Every cite is `S.C. Code § XX-X-XXX`, with no "Ann." The two scstatehouse.gov links are `t15c078` and `t38c077`, both the correct chapters. |
| Phones / NAP | "(843) 790-8999" and 127 King Street, Suite 200, 29401 match `firm-data`/LocalBusiness. The LegalService `telephone` is the toll-free line (+18447378587 = 844-RESULTS), consistent with the car page. |
| Firm stats | $300M+, 4.9, 5,000+, 62 years and 6 offices match `trust_stats`. The 170+ reviews figure is computed live. See C1. |
| FAQ vs FAQPage JSON-LD | All 6 answers match character for character. |
| Steps vs HowTo JSON-LD | Identical. |
| JSON-LD validity | All 7 blocks parse. |

## Other observations (not findings)

- **"Last updated: September 27, 2026"** is dated tomorrow.
  - `get_the_modified_date()` renders the site-timezone date of a 2026-09-27 01:34 UTC write, which was the evening of 09-26 Eastern. It re-stamps on publish.
  - If the WordPress timezone is UTC, any edit made after 8 pm Eastern shows tomorrow's date. That is a site setting, not a content fix.
- **Pillar negligence intro renders a double space** before "You generally have". It is cosmetic; the space sits before the `{{GA}}` branch's closing.
- **Out of scope for this SC page, for the GA reviewer:** the truck pillar's `{{GA}}` negligence branch still publishes a drafting note, "(procedural rules amended in recent legislation; verify current posture before filing)", about O.C.G.A. § 40-1-112. It will render on any Georgia truck intersection.

## Counts by rule

| Rule | Findings | Severity |
|---|---:|---|
| (engine) all SC + GA rules, signed pack | 0 | — |
| Hand: firm geography / NAP | 1 (W1) | warn |
| Hand: incomplete deadline statement, cross-surface inconsistency | 1 (W2, 2 surfaces + schema) | warn |
| Hand: punitive standard unstated | 1 (W3) | warn (low) |
| Hand: federal claims without pack authority (verified true) | 1 (W4) | warn |
| Carried: firm stats wording | 1 (C1) | warn |
| **Total** | **4 new + 1 carried**, 0 errors | |

Source split:
- **PAGE:** W2, W4 (body and FAQ half).
- **TEMPLATE:** W1, W3, W4 (pillar half), C1.

## False positives

None. The engine raised nothing.

Pack additions go to an `internal-ai-scripts` PR as **pending authorities** with `verifiedBy: null`, for Gillin's next sign-off packet. They are federal, so the owner decides where they live: a new `law/US.json`, or a federal section referenced by SC/GA.

1. **`49 CFR 382 / 391 / 395 / 396`**
   - Subject: the FMCSR subject areas: drug and alcohol testing, driver qualification, hours of service, inspection/repair/maintenance.
   - Quantities: none.
   - Evidence: `https://www.ecfr.gov/current/title-49/subtitle-B/chapter-III`.
2. **`Montgomery v. Caribe Transport II`**
   - Cite: *Montgomery v. Caribe Transport II, LLC*, No. 24-1238 (U.S. May 14, 2026).
   - Claim: a negligent-hiring (negligent-selection) claim against a freight broker is not preempted by 49 U.S.C. § 14501(c)(1); it is saved by the safety exception, § 14501(c)(2)(A).
   - Evidence: `https://www.supremecourt.gov/opinions/25pdf/24-1238_1b7d.pdf`.
   - A candidate for a future rule: any sentence saying brokers "cannot be sued" or are "shielded by federal law" would now be false.

## Before publish

1. PAGE: apply W2 to `bin/rebuild-charleston-truck-accident.php` (FAQ 5 and KT) and re-run it. It stays a draft.
2. TEMPLATE: a theme PR for W1 (`inc/firm-data.php` line 181; the office confirms the route). W3 goes through a `bin/` patcher on post 3605 `_roden_pillar_compensation_intro` (exact-match `str_replace` + `wp_slash`), inside the `{{SC}}` branch.
3. Re-render the draft and re-run the replay (`scratchpad/draft3629-fixture.json`, `--law` at `origin/main`).
4. Gillin reviews the page, including the W4 federal statements. Only then set `_roden_last_reviewed` and publish.
