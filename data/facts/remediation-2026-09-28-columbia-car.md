# Pre-publish legal sweep: Columbia car accident page (post 3625, DRAFT)

- **Page:** `/car-accident-lawyers/columbia-sc/`. Post 3625, `practice_area`, draft, `_roden_retired` still set. Parent: the car accident pillar. Allowlisted in #185. Wave 1, #8.
- **Jurisdiction:** South Carolina only. Reviewer of record: Graeham C. Gillin (SC Bar).
- **What was swept:** the rendered draft (`scratchpad/draft3625.txt`, `scratchpad/preview/draft3625.html`) and all 7 JSON-LD blocks in it (LegalService, Person, FAQPage, WebPage, HowTo, LocalBusiness/LegalService/LawFirm, BreadcrumbList).
  - **Page surfaces**, from `bin/rebuild-columbia-car-accident.php`: body, excerpt (Article `description`), meta description, key takeaways, 6 FAQs.
  - **Template blocks:** hero, NAP bar, office map and directions, law box, what-to-do steps and HowTo, case types, the Columbia `local_context` essay and `directions` (both rewritten in #185, `inc/firm-data.php`), the car pillar's negligence and compensation intros, the statewide uplink, the stats block, attorneys, case results, resources, the CTAs and the sidebar.
  - **Where the #185 text renders:**
    - `directions` renders on the live Columbia hub (`template-location.php:473`) and on every Columbia intersection.
    - `local_context` renders only through `roden_office_local_context_block()` (`template-intersection.php:474`), plus market pages that fall back to the Columbia block.
    - Columbia has no `local_context_wc`, so the tort essay does **not** render on a Columbia workers' comp page. The block deliberately has no fallback.
  - **Linked pages** were read in `content/meta.json` (FAQs, excerpt, key takeaways) and in the sweep's WordPress export (`data/content-cache/wp-export.json`, exported 2026-09-28 16:21 UTC, bodies).
- **Pack:** `law/SC.json` is **SIGNED**: Graeham C. Gillin, 2026-09-26, 34 authorities, no `pendingAuthorities`.
  - Every authority this page rests on is signed and has `verifiedBy` set: `SC 15-3-530`, `Nelson v. Concrete Supply Co.`, `SC 15-78-110`, `SC 15-78-80`, `SC 15-78-120`, `SC 38-77-140`, `SC 38-77-150`, `SC 38-77-160`, `SC 38-77-170`, `SC 56-5-1260`, `SC 56-5-1270`.
  - No claim on the page needs a new authority.
- **Engine run:**
  - I replayed 45 blocks through `sweep-claims.mjs --fixtures scratchpad/draft3625-fixture.json --states SC,GA` on internal-ai-scripts `main` (`042f154`). The blocks are 30 rendered-text blocks, 6 FAQPage answers, 7 HowTo steps, the LegalService description and the key takeaways.
  - Result: **0 findings**. A positive control (a § 15-38-15 miscite) fired, which confirms the rules were loaded. Result line: 45/45.
  - A second fixture (`scratchpad/columbia-linked-fixture.json`, 4 blocks) replayed the linked-page sentences in L1, L2 and L6. It also returned 0, and all of those are false negatives (see "Pack changes").

**Verdict: PASS for the page.**
- No error-level finding on any rendered surface, page or template. Three low-severity warnings (W1–W3).
- The page's SC rules text is the Charleston car wording that Gillin reviewed, and it matches the signed pack on every surface.
- **One LINKED error (L1) should be fixed in the same batch.**
  - The body's SCTCA paragraph, the case-types grid and the sidebar all send the reader to `/car-accident-lawyers/government-vehicle-accident/`.
  - That page is live and says a South Carolina claim **must** be filed with the agency, which then gets 180 days, before suit. It also says a $1.2 million cap applies to multiple entities.
  - Both statements contradict the paragraph the reader just left, and the signed pack.
  - The live Charleston car page already links to it, so it is a live error today whether or not this page publishes.
- Byline: "Reviewed by Graeham C. Gillin" must not go live until he has reviewed this page.
  - `_roden_last_reviewed` is correctly unset (checked in `docs/backups/columbia-car-accident-before-2026-09-28.json`).
  - "Last updated: September 28, 2026" is the modified date, not a review stamp.

Source key:
- **PAGE** means `bin/rebuild-columbia-car-accident.php` (post 3625 content and meta).
- **TEMPLATE** means the theme or `inc/firm-data.php`.
- **LINKED** means a separate published page this page links to. It is not rendered here, so it does not block this publish.

---

## Road, court and hospital facts (the caller's four checks)

| Claim as published | Where | Result | Evidence |
|---|---|---|---|
| "The I-20 / I-26 interchange, known locally as Malfunction Junction" | PAGE body; TEMPLATE essay | **Confirmed** | Wikipedia *Interstate 20 in South Carolina* ("its Malfunction Junction cloverleaf interchange with I-26/US 76"), *Interstate 126* and *Malfunction Junction* ("interchange at Interstate 26 and Interstate 20 near Columbia"). I-77 is not part of it. |
| "Carolina Crossroads project, which is reworking [rebuilding] the I-20, I-26 and I-126 corridors" | PAGE body; TEMPLATE essay | **Confirmed** | Wikipedia *Interstate 26 in SC* / *Interstate 126*: SCDOT/FHWA improvements to "the I-20/I-26/I-126 corridor, including the system interchanges at I-20/I-26 and I-26/I-126". "Shifting work zones expected for years" is tense-proof, with no end date and no dollar figure. |
| "Prisma Health Richland Hospital (5 Richland Medical Park Drive), a Level I trauma center" | TEMPLATE essay (EN + ES) | **Confirmed** | The OSM/Nominatim address record is "Prisma Health Richland Hospital, 5, Richland Medical Park Drive, Columbia, 29203". Wikipedia says "a Level I Trauma Center". firm-data's own `trauma_center` ("Prisma Health Richland (Adult Level I)") was checked against the SC DPH list in Aug 2026. "Often taken to" is properly hedged, and "only Level I" is gone. prismahealth.org renders client-side and returned no text to curl. |
| "Richland County Judicial Center, 1701 Main Street … near our Sumter Street office" | PAGE body + FAQ 5; TEMPLATE essay | **Confirmed** | Nominatim resolves "Richland County Judicial Center, 1701 Main Street" to 34.00804, -81.03762. The office geocodes to 34.00678, -81.03449, which matches the LocalBusiness `geo` exactly. That is about 0.2 mi apart (Main is one block west of Sumter), so "near" holds. firm-data `court_address` "1701 Main St., Columbia, SC 29201" agrees. |
| Directions: "From I-20 or I-77, SC 277 leads downtown and becomes Bull Street; from I-26, I-126 leads downtown." | TEMPLATE `directions`; also on the live Columbia hub | **Confirmed** | Wikipedia *SC Highway 277*: it runs from I-77 (exit 18) with an I-20 interchange, and its last 0.7 mi "is part of Bull Street". *Interstate 126*: it "connects I-26 to Downtown Columbia", ending at Gadsden St. None of I-277, the Exit 111B/16A/74 claims or Broad River Rd survives. |
| "Columbia sits where three interstates meet" / "I-20 carries traffic across the north side of the city" / "I-77 runs toward Blythewood and Rock Hill" | PAGE body | **Confirmed** | I-20 "passes north of Columbia", and I-77 runs north to Charlotte through Blythewood and Rock Hill. "Where three interstates meet" names no single interchange, so it does not repeat the I-26/I-20/I-77 error. |

---

## WARN (page and template; low)

### W1. The filing-location answer covers Richland County only

- **Surface / block:** FAQ 5 and its FAQPage answer (they are identical); body, "Where your case would be filed". Both are PAGE.
- **Published (FAQ 5):** "Most Richland County car accident lawsuits are filed in the Court of Common Pleas at the Richland County Judicial Center, 1701 Main Street, near our Sumter Street office."
- **Issue:**
  - The question is "Where would my *Columbia* car accident case be filed?", and the hero and LocalBusiness `areaServed` list Lexington, West Columbia and Cayce, which are in Lexington County.
  - The answer is true as scoped, but it does not answer a West Columbia or Lexington reader, and FAQPage publishes it without the rest of the page.
- **Corrected (FAQ 5):** "Most Richland County car accident lawsuits are filed in the Court of Common Pleas at the Richland County Judicial Center, 1701 Main Street, near our Sumter Street office. A crash in Lexington County, such as in West Columbia, Cayce or Lexington, may be filed there instead."
- **Authority:** n/a. No venue authority is in the pack, and the added sentence is hedged ("may"), names no statute and gives no address.
- **Rule:** none.
- **Severity:** low. Optional, but it is the answer that stands alone in schema.

### W2. The "Local … Resources" block has nothing local to Columbia

- **Surface / block:** "Local Car Accident Lawyers Resources". TEMPLATE (the resources query).
- **Published:** SC moped laws, SC golf cart laws, SC helmet laws, and "Grand Strand Fatal Crash Report: Horry County, 2020–2024".
- **Issue:**
  - The first three are statewide and were verified 2026-09-19, so they are fine as SC resources.
  - The Horry County report is Myrtle Beach data under a "Local" heading on a Columbia page.
  - No legal claim is involved. The Georgia-leak problem from the Charleston car sweep (W10) is gone: all four are SC.
- **Fix:** filter the resources by office or market, or retitle the block "South Carolina Resources".
- **Severity:** low, presentation only.

### W3. Two linked pages cannot be seen by any sweep

- **Surface / block:**
  - Body: "If a commercial truck was involved, see our Columbia truck accident lawyers" links `/columbia-truck-accident-lawyer/` (PAGE).
  - Statewide uplink: `/south-carolina-car-accident-lawyer/` (TEMPLATE, `roden_sc_statewide_uplink()`).
- **Issue:**
  - Both are `page` posts that `functions.php:279–281` excludes from the sitemap as "Duplicates PA CPT intersection".
  - Neither is in `content/meta.json`. The WordPress export holds 8 characters of `post_content` for each, so they are template-rendered.
  - rodenlaw.com returns a Cloudflare challenge to curl. **Their published claims were not checked.** Per CLAUDE.md, a sweep that cannot see a page reports zero, not clean.
  - The uplink is shared with the Charleston pages and is not new. The truck link is new on this page.
- **Fix:**
  - Point the truck link at the truck pillar, or at `/truck-accident-lawyers/columbia-sc/` once it is live, rather than at a sitemap-excluded duplicate.
  - Render both pages server-side and sweep them the way this draft was swept.
- **Severity:** low. It is a visibility gap, not a known error.

---

## LINKED (do not block this publish)

### L1. Government-vehicle sub-type: the SCTCA is stated wrongly (live, error class)

- **Where it shows here:**
  - Body, "Crashes involving a city, county or state vehicle" ("See government vehicle accidents").
  - The case-types grid.
  - The sidebar "Related Case Types".
  - All three link to `/car-accident-lawyers/government-vehicle-accident/`. It is published, `_roden_jurisdiction: both`, author meta "Eric Roden".
- **Published (body, "South Carolina Government Vehicle Accident Claims"):**
  1. "Filing requirements: Claims must be filed with the appropriate governmental entity, and the entity has 180 days to investigate before a lawsuit can be filed."
  2. "Damage caps: Recovery against a single government entity is capped at $300,000 per claimant and $600,000 per occurrence. For multiple entities, the total cap is $1.2 million per occurrence."
- **Why both are false** (primary text re-read 2026-09-28 at scstatehouse.gov/code/t15c078.php):
  1. § 15-78-80(a): a verified claim "**may** be filed". § 15-78-90(b): "**Whether or not the claim is filed**, the claimant is entitled to institute an action". The 180-day wait applies only *if* a claimant chooses to file.
     - This is the `sctca-mandatory-notice` class, in words the rule does not match.
  2. § 15-78-120(a)(1)–(2): $300,000 per person and $600,000 per occurrence "**regardless of the number of agencies or political subdivisions involved**". The $1,200,000 limits in (a)(3)–(4) apply only to torts of a government-employed licensed physician or dentist.
- **Corrected (1):** "Filing requirements: Filing a verified claim with the agency is optional, and you may sue whether or not you file one. Suit must be brought within two years, or within three years if a verified claim was filed with the agency within one year (S.C. Code §§ 15-78-80, 15-78-110)."
- **Corrected (2):** "Damage caps: Recovery is capped at $300,000 per person and $600,000 per occurrence, however many government entities are involved (S.C. Code § 15-78-120). The higher $1.2 million limits apply only when the harm was caused by a government-employed physician or dentist."
- **Same page, same class:**
  - **Excerpt / Article `description`:** "…Our lawyers navigate sovereign immunity rules and strict notice deadlines to pursue your claim."
    - Corrected: "…Our lawyers handle the sovereign immunity rules, filing deadlines and, where they apply, notice requirements for your claim."
    - (Georgia's ante litem notice is real. South Carolina has no notice requirement.)
  - **FAQ 5 + FAQPage:** "How long do I have to file a government vehicle accident claim?" lists only Georgia and federal deadlines, then says "The standard personal injury statute of limitations also applies."
    - For South Carolina that is wrong: § 15-78-110's two years displaces § 15-3-530's three.
    - Add: "In South Carolina, suit must be filed within two years, or three years if a verified claim is filed with the agency within one year (S.C. Code §§ 15-78-110, 15-78-80)."
    - Scope "The standard personal injury statute of limitations also applies" to the Georgia and federal sentences, or delete it.
  - **Body, "Critical Deadlines in Government Vehicle Cases":** it names Georgia ante litem and the FTCA only. Add the same South Carolina sentence.
  - **FAQ 0:** "Strict notice and filing requirements apply." Scope it: "Georgia and federal claims have strict notice and filing requirements; South Carolina has a shorter filing deadline but no notice requirement."
- **Georgia-side sentences** (O.C.G.A. § 36-33-5, § 36-11-1, the DOAS 12 months, § 40-6-6) are outside this sweep. They are left to the Georgia reviewer.
- **Authority:** `SC 15-78-80` (its claim records § 15-78-90(b)), `SC 15-78-110`, `SC 15-78-120`. All are signed.
- **Rule:** none fired (see "Pack changes", items 1 and 2).
- **Severity:** **error on a live page.** It does not block this page, but fix it before or with this publish: it is where this page sends readers for the SCTCA, and the live Charleston car page already sends them there.
- **Fix path:** it is a published page, so use a `bin/` patcher. Use exact-match `str_replace` on `post_content` and `post_excerpt`, write with `wp_update_post( wp_slash( … ) )`, and never put a `$` in a replacement (the caps sentence contains `$300,000`, so build it by concatenation or use a nowdoc and `str_replace`, not `preg_replace`). FAQ answers go through `bin/apply-faq-remediation.php`. Then regenerate `content/meta.json` and run `bin/check-unslashed-post-writes.php`.

### L2. § 15-78-80 is cited as the source of the SCTCA damage caps (4 Columbia resources)

- **Where it shows here:** the body links all four from "Where Car Accidents Happen".
- **Published:**
  - `/resources/carolina-crossroads-construction-zone-truck-accidents/`:
    - FAQ 4 + FAQPage: "claims against SCDOT are subject to the SC Tort Claims Act (S.C. Code Section 15-78-80), which imposes damage caps and specific procedural requirements"
    - Body, the "SC Tort Claims Act:" paragraph (same wording)
    - Body, liability table: "(subject to SC Tort Claims Act, S.C. Code § 15-78-80)"
  - Liability tables on `/resources/bush-river-road-i-26-truck-accidents-columbia/`, `/resources/two-notch-road-truck-accidents-columbia/` and `/resources/broad-river-road-truck-accidents-columbia/`: "(subject to SC Tort Claims Act, S.C. Code § 15-78-80)"
- **Issue:** § 15-78-80 is the optional verified claim. The caps are § 15-78-120. The table rows use § 15-78-80 as if it were the Act.
- **Corrected (Crossroads FAQ 4 and body):** "…subject to the South Carolina Tort Claims Act, which caps recovery at $300,000 per person and $600,000 per occurrence (S.C. Code § 15-78-120) and sets a two-year filing deadline (S.C. Code § 15-78-110)."
- **Corrected (the four tables):** "(subject to the SC Tort Claims Act, S.C. Code § 15-78-10 et seq.)", or "(§§ 15-78-110, 15-78-120)".
- Two Notch FAQ 4 already cites § 15-78-110 correctly, and Bush River FAQ 3 is correct.
- **Authority:** `SC 15-78-120`, `SC 15-78-110`, `SC 15-78-80`. **Rule:** none (proposed as item 3). **Severity:** warn.

### L3. The Carolina Crossroads and I-20 resources repeat the claims #185 removed from the essay

- **Where it shows here:** body links.
- **Published:**
  - Crossroads resource: "$2.08 billion" in the H2, excerpt, key takeaways and FAQ 0; "134,000+ vehicles daily"; body, "The I-26/I-20/I-77 interchange area remains one of the most complex navigation challenges…".
  - `/resources/i-20-truck-accidents-columbia/` body: "The I-26/I-20/I-77 interchange complex is a crash hotspot…".
- **Issue:**
  - #185 removed "$2.08 billion", "largest in agency history" and I-77-as-Malfunction-Junction from the Columbia essay as unverified or wrong.
  - The resources the page now links to still carry them. Malfunction Junction is I-20/I-26 (see the facts table).
- **Fix:** verify "$2.08 billion" and "134,000" against SCDOT's Carolina Crossroads page, or delete them. Change "I-26/I-20/I-77 interchange" to "I-20/I-26 interchange (Malfunction Junction)".
- **Severity:** warn (not law).

### L4. Site-wide follow-up: the I-26/I-20/I-77 "interchange" resource (not linked from this page)

- **Page:** `/resources/columbia-i-26-i-20-i-77-interchange-truck-accidents/`, published, author meta "Ivy S. Montano".
  - Title: "Columbia's I-26/I-20/I-77 Interchange: South Carolina's Most Dangerous Truck Corridor".
  - Body: "one of the only cities in the Southeast where three major interstates … converge"; "stretching from the I-26/I-20 junction in West Columbia to the I-77/I-20 interchange south of downtown".
- **Issue:**
  - There is no single I-26/I-20/I-77 interchange.
  - The I-20/I-77 interchange is north-east of downtown, not south.
  - "Most dangerous truck corridor" and "one of the only cities" are unsourced superlatives.
- **Reach:** this page does not link it. Four pages it *does* link do: Crossroads, I-20, Bush River and Broad River. So it is two clicks away.
  - Export count for the phrase "I-26/I-20/I-77 interchange": this resource ×3, Crossroads ×2, I-20 ×1, `/resources/i-77-truck-accidents-columbia-rock-hill/` ×1.
- **Action:** a separate batch. Retitle and rewrite as the I-20/I-26 (Malfunction Junction) page, or consolidate it into the Bush River or Crossroads resource with a 301. Fix the four inbound bodies.

### L5. Conflicting Richland County crash statistics, and one internally inconsistent road claim

- **Published:**
  - `/blog/columbia-dangerous-intersections-roads/` (Gillin-attributed): "Richland County … recorded 12,450 traffic collisions in 2023 … including 58 fatal collisions in which 60 people died (SCDPS Traffic Collision Fact Book, 2023 edition)". The Blythewood and Irmo `local_context` essays in firm-data repeat 12,450 / 58.
  - `/resources/two-notch-road-…/` and `/resources/broad-river-road-…/` key takeaways and body: "Richland County recorded 12,731 total collisions and 65 fatal crashes in 2023", with no source.
  - Broad River body: "US-1 (Augusta Road) is the most dangerous road in Richland County overall, with 939 collisions and 5 fatalities in 2023".
    - US 1 is Augusta Road in *Lexington* County (West Columbia and Lexington). In Richland County, US 1 is Two Notch Road. The claim names the wrong county, the wrong road, or both.
- **Action:** one of the two county figures is wrong. Check both against the SCDPS 2023 Fact Book, keep the sourced one, and add it to `data/statistics.json`. Delete or verify the US-1 sentence.
  - This is the stat-audit class from 2026-08-25. The market essays are template text that the statistics registry cannot see.
- **Severity:** warn (not law).

### L6. Two car sub-types still carry SCTCA "notice" wording; the Columbia blogs have small SC issues

- **`/car-accident-lawyers/commercial-vehicle-accident/` FAQ (two-state):** "You may file a claim against the government entity, but strict notice requirements and shorter filing deadlines apply. In Georgia, you must provide ante litem notice before suing. South Carolina has its own tort claims act with specific procedures."
  - The first sentence is unhedged and not scoped to a state. Corrected: "…Georgia requires ante litem notice before suing. South Carolina requires no notice, but its Tort Claims Act sets a two-year filing deadline (S.C. Code § 15-78-110)."
  - Authority `SC 15-78-80`, `SC 15-78-110`.
- **`/car-accident-lawyers/bus-accident/` FAQ:** "If the bus was operated by a government entity, shorter notice deadlines may apply."
  - Hedged, and true for Georgia. For the SC half, use "shorter filing deadlines".
  - Low severity. It is the `sctca-shorter-notice-hedge` class on a two-state page.
- **`/blog/columbia-dangerous-intersections-roads/`:**
  - FAQ 4 says "South Carolina law requires reporting any accident causing injury or more than $1,000 in property damage". Use this page's step-5 wording (`SC 56-5-1260`, `SC 56-5-1270`: "$1,000 or more", and only when no officer investigated).
  - FAQ 1 and a body section state Georgia's deadline and fault threshold on a Columbia post with `_roden_jurisdiction` unset. Georgia law on an SC city post is presentation, not an SC error. Those sentences are for the Georgia reviewer.
- **`/blog/guide-after-a-car-accident-in-columbia-sc/`:** "Punitive Damages: Awarded in rare cases to punish the at-fault party for extreme negligence or recklessness."
  - "Extreme negligence" is not the SC standard.
  - Proposed: "Awarded in rare cases of reckless, willful or wanton conduct, which must be proved by clear and convincing evidence (S.C. Code § 15-33-135)."
  - `SC 15-33-135` backs the burden only. The conduct standard is case law with no pack authority, so this sentence needs Gillin.
- **Severity:** warn, low.

### L7. Spanish twin (post 4910)

- `_roden_translation_es: 4910` is set on 3625. 4910 is not published (it is absent from the export and from `content/meta.json`), and the rendered EN draft emits no hreflang to it.
- Do not publish or un-retire it until it is rebuilt from this copy and swept. The Columbia `local_context_es` it would render is already corrected by #185.
- **Severity:** info.

---

## Checks that PASS

| Check | Result |
|---|---|
| South Carolina only | **No Georgia law** on the page or in its 7 JSON-LD blocks: no O.C.G.A. cite, Georgia deadline or Georgia rule. The pillar intros render their SC branch. |
| Firm-level GA mentions (accepted on siblings) | "Available 24/7 · Georgia & South Carolina" (CTA ×2), "$300M+ … across Georgia and South Carolina", "Licensed in GA & SC". |
| SOL | 3 years, S.C. Code § 15-3-530, the same in the KT, FAQ 2, law box, essay, negligence intro and sidebar. "Generally" and "usually ends your right to recover" are used (the Charleston car sweep's W5 is fixed). |
| Government entity | Two years under § 15-78-110 (from loss or discovery), with an optional verified claim within one year that extends it to three (§ 15-78-80), in the body, KT and FAQ 2. $300,000 / $600,000 and no punitive damages under § 15-78-120. All match the signed pack and the primary text re-read today. There is **no "notice" wording** anywhere on the page, and the old essay's SCTCA sentence is gone. |
| Comparative fault | *Nelson v. Concrete Supply Co.* (in full in the law box: 303 S.C. 243, 399 S.E.2d 783 (1991)). **§ 15-38-15 appears nowhere.** "50% or less" (KT, FAQ 3), "less than 51%" (law box, essay) and "51% or more … bars" (negligence intro) are equivalent. |
| Insurance | 25/50/25 under § 38-77-140; UM mandatory under § 38-77-150; UIM must be offered under § 38-77-160; hit-and-run police report and corroboration under § 38-77-170. All match the signed claims. |
| Stacking / household coverage | **None.** It was removed from the essay in #185 (EN and ES). The stacking resource is not linked. |
| Noneconomic damages / caps | Compensation intro: "recoverable … reduced by your share of fault", with the SCTCA cap as the stated exception. The old "limited only by the evidence" / "no statutory cap" overstatement is gone. |
| Punitive damages | No punitive dollar figure anywhere. The only statement is "no punitive damages" against a government entity, which is correct. |
| Police-report step and HowTo | The § 56-5-1260 / § 56-5-1270 text matches the signed pack. Step 5 and HowTo step 5 are identical. |
| Negligence intro | "Violating a traffic statute can support a negligence per se theory…" is hedged. It is the wording accepted on the Charleston car page. |
| Essay (#185) | Court "usually filed", Judicial Branch e-filing, ADR Rules "before trial", with no vendor name, no "mandatory", no Rule 40 track, no $2.08B and no end year. Malfunction Junction is I-20/I-26, Prisma Health Richland has no "only", and the SOL and fault line matches the Charleston essay. The ES text is equivalent. |
| Directions (#185) | Confirmed (see the facts table). There is no I-277 and no exit numbers. |
| Statistics | No numeric crash statistic on the page. |
| Citation format and links | Every cite is `S.C. Code § XX-X-XXX`, with no "Ann." and no `O.C.G.A.` Two scstatehouse.gov links point to the right chapters (`t15c078`, `t38c077`). |
| FAQ vs FAQPage JSON-LD | All 6 answers are identical, character for character. |
| Excerpt / meta description / LegalService description | They are marketing only, with no legal claim. |
| NAP / LocalBusiness | 1545 Sumter St., Suite B, 29201; (803) 219-2816. `geo` 34.006782, -81.034492 matches the geocoded address. The map place ID was verified in #185. |
| Attorneys | Ivy S. Montano (Associate, `barStates: ["SC"]` in `client.json`) matches "attorneys licensed here". Minor data note: firm-data `offices.columbia.attorneys` lists only `graeham-gillin`, while the attorney CPT query renders Montano. |
| Author / reviewer | Graeham C. Gillin (SC Bar). `_roden_last_reviewed` is unset. |
| JSON-LD validity | 7/7 blocks parse. |
| Firm boilerplate (accepted or owner-deferred; not re-raised) | The stats block ("5,000+ Cases successfully handled", 170+ reviews, 62 years), the unfiltered case-results grid, the statewide uplink "comparative-fault rule" and the bottom CTA "believe another party is at fault" (both correct for a tort page). |

## Counts by rule

| Rule | Findings | Severity |
|---|---:|---|
| (engine) all SC + GA rules, 45 blocks + control | 0 | — |
| Hand: answer scoped narrower than the question (venue, FAQ 5) | 1 | warn, low |
| Hand: unfiltered / mislabelled template block (resources) | 1 | warn, low |
| Hand: linked page not visible to any sweep | 1 (2 pages) | warn, low |
| Hand, LINKED: SCTCA pre-suit claim stated as mandatory; multi-entity cap misstated | 1 (5 surfaces on one page) | **error (live)** |
| Hand, LINKED: SCTCA caps cited to § 15-78-80 | 1 (4 pages) | warn |
| Hand, LINKED: unverified figures and the I-77 interchange claim | 2 (L3, L4) | warn |
| Hand, LINKED: conflicting crash statistics / wrong-county road | 1 | warn |
| Hand, LINKED: notice wording, report threshold, punitive standard | 1 (4 pages) | warn, low |
| Hand: untranslated twin | 1 | info |
| **Total** | **11** (0 page errors, 3 page warnings, 1 linked error, 6 linked warnings, 1 info) | |

Source split:
- **PAGE:** W1 and W3 (the truck link).
- **TEMPLATE:** W2 and W3 (the uplink).
- **LINKED / other posts:** L1–L7.

## False positives

None. The engine raised nothing on the page. The items below are **false negatives**, confirmed by replaying the published sentences (`scratchpad/columbia-linked-fixture.json`, 4/4 "nothing"). They go to an `internal-ai-scripts` PR, not to a content edit.

## Pack changes (proposed; not made)

Fixtures come first for all of these, in `law/fixtures/`. Re-run both fixture sets to 100% before merging.

1. **Extend `sctca-mandatory-notice` (error) to the "claim must be filed … before a lawsuit" form.**
   - **Positive:** L1 sentence 1 as published.
   - **Controls:** the corrected L1 sentence; this page's "Filing a verified claim with the agency within one year is optional…"; an FTCA sentence ("must file an administrative claim with the responsible federal agency within 2 years"); a Georgia ante litem sentence.
   - **Candidate branch:** `(?:claims?)\s+must\s+(?:first\s+)?be\s+(?:filed|presented|submitted)\s+with\s+(?:the\s+)?(?:appropriate\s+)?(?:governmental|government)\s+(?:entity|agency)[^.]{0,120}(?:before|prior to)\s+(?:a\s+)?(?:lawsuit|suit|action)`. It needs a South Carolina context window, or an `unless` of `georgia|o\.c\.g\.a|ftca|federal|ante litem|doas`.
2. **New rule `sctca-cap-multiple-entities` (error, SC).**
   - **Positive:** L1 sentence 2 ("For multiple entities, the total cap is $1.2 million per occurrence").
   - **Controls:** the pack's own physician/dentist wording; the § 33-56-180 charity-cap sentence.
   - **Pattern:** `(?:multiple|several|more than one)\s+(?:government(?:al)?\s+)?(?:entities|agencies|defendants)[^.]{0,60}\$?1[.,]2\s*million` with `unless` `physician|dentist`.
   - Backed by `SC 15-78-120`: its claim already carries "($1,200,000 for physicians and dentists)". Add "regardless of the number of agencies or political subdivisions involved" to the claim text.
3. **New rule `sctca-caps-cited-to-15-78-80` (warn, SC).**
   - **Positives:** the L2 sentences.
   - **Control:** this page's § 15-78-80 sentence (optional verified claim, three years).
   - **Pattern:** `15-78-80\)?[^.]{0,40}(?:cap|caps|limit)` and `(?:cap|caps)[^.]{0,60}15-78-80`.
4. **Optional:** a statistics-registry entry for Richland County 2023 collisions and fatal collisions (L5), so one sourced figure is enforced. The registry does not read `firm-data.php`, so add the Blythewood and Irmo essays to a theme fixture like `roden-comparison-table-2026-09-26.json`.

After any pack change: `node scripts/facts/vendor.mjs rodenlaw --write` if the client vendors the pack, then `--check`.

## Before publish

1. Optional page edits in `bin/rebuild-columbia-car-accident.php`: W1 (FAQ 5), and the W3 truck link target. Re-run the script against the draft, re-render, and confirm that FAQ 5 and the FAQPage answer match.
2. **Recommended in the same batch:** fix L1 on `/car-accident-lawyers/government-vehicle-accident/` (body, excerpt, FAQ 0 and FAQ 5) through a `bin/` patcher and `bin/apply-faq-remediation.php`. Then regenerate `content/meta.json` and run `bin/check-unslashed-post-writes.php`.
3. Re-run this sweep if anything in step 1 changes, including the replay fixture (`scratchpad/draft3625-fixture.json`, 45 entries).
4. Gillin reviews and signs off the page. Only then set `_roden_last_reviewed`, remove `_roden_retired` and publish. Leave post 4910 unpublished (L7).
5. Separately:
   - L2–L6 go to a Columbia resources batch.
   - The Georgia-side sentences on the government-vehicle page and the Columbia intersections blog go to the Georgia reviewer.
   - The punitive-standard wording in L6 (Columbia guide blog) goes to Gillin's packet.

---

## Follow-up fixes (2026-09-28)

**Scripts swept (not applied, read-only review):**
- `bin/rewrite-columbia-interchange-resource.php`: post 4656, a full rewrite (L4).
- `bin/fix-columbia-resources-claims.php`: 17 exact-match edits on 4687, 4680, 4679, 4678, 4654, 4655 and 3518 (L2, L3, and the L6 punitive line).

**Method:**
- The new text was extracted from the PHP: the 4656 title, body blocks, excerpt, key takeaways and 5 FAQs, plus all 17 `to` strings.
- Replayed through `sweep-claims.mjs --fixtures scratchpad/followup-fixture.json --states SC,GA` with a § 15-38-15 positive control: 64/64, **0 findings**.
- Each replacement was then read in its surrounding paragraph from `data/content-cache/wp-export.json` (exported 2026-09-28 16:21 UTC).
- § 15-38-15 was re-read at scstatehouse.gov/code/t15c038.php. The Carolina Crossroads figures were re-read on scdotcarolinacrossroads.com.

**Verdict: FAIL, and it clears with the three required changes below.**
- Every SCTCA, Nelson, SOL and punitive sentence is correct against the signed pack.
- The fix script leaves 4655's own "south of Columbia" geography in place around the reworded anchor, and that geography contradicts the 4656 rewrite it links to (R1).
- The 4656 § 15-38-15 sentence is stated without "generally" (R2).
- One routing sentence in 4656 is overbroad (R3).

### Required

**R1. Post 4655 (`/resources/i-77-truck-accidents-columbia-rock-hill/`): the I-20/I-77 interchange is not south of Columbia.**
- The script rewords the anchor sentence but leaves the sentences around it.
- I-77 leaves I-26 in Cayce, heads east along the western edge of Fort Jackson, and meets I-20 at Woodfield, **northeast** of downtown (Wikipedia *Interstate 77 in South Carolina*; I-20 Exit 76).
- The rewritten 4656 says "east of downtown", so as scripted 4655 contradicts the page it links to. Add these five edits to the script (content, each found exactly once in the export):
  1. `is adjacent to I-77 south of Columbia, generating` → `is adjacent to I-77 on the east side of Columbia, generating`
  2. `<li>The I-77/I-20 interchange south of Columbia is one of the <strong>most congested truck junctions</strong> in the Midlands</li>` → `<li>The I-77/I-20 interchange northeast of downtown Columbia carries truck traffic between Charlotte and I-20</li>`. This also drops an unsourced superlative.
  3. `<h3>I-77/I-20 Interchange (South Columbia)</h3>` → `<h3>I-77/I-20 Interchange (Northeast Columbia)</h3>`
  4. `The interchange where I-77 meets I-20 south of Columbia is a critical convergence point` → `The interchange where I-77 meets I-20 northeast of downtown Columbia is a critical convergence point`
  5. `from the I-20 interchange south of Columbia to Rock Hill` → `from the I-20 interchange northeast of downtown Columbia to Rock Hill`
- 4655's excerpt, key takeaways and FAQs carry no "south" claim.

**R2. Post 4656: § 15-38-15 needs "generally".**
- The current statute (the version effective 2026-01-01) keeps several-only liability for a defendant under 50% of total fault. Subsection (F) excludes a defendant whose conduct is "wilful, wanton, reckless, or intentional" or involves illegal drugs, and such a defendant "shall be jointly and severally liable". Under (C)(a), a carrier vicariously liable for its driver is treated as a single party with the driver.
- The signed claim ("a defendant less than 50% at fault is only severally liable") backs the general rule, not a flat one.
- Body: `a defendant found less than 50% at fault pays only its own share of the damages (S.C. Code § 15-38-15), which is one reason` → `a defendant found less than 50% at fault generally pays only its own share of the damages (S.C. Code § 15-38-15), which is one reason`
- FAQ 3: `a defendant found less than 50% at fault pays only its own share of the damages, so identifying` → `a defendant found less than 50% at fault generally pays only its own share of the damages, so identifying`
- Naming the reckless/intentional exception on the page needs the pack amendment below, signed first.
- The Nelson bullet is in its own sentence and cites Nelson, not § 15-38-15. The engine's `nelson-bar-miscited-to-15-38-15` did not fire, and the control did.

**R3. Post 4656 body: not every Charleston truck takes I-77.**
- `A truck coming from Charleston on I-26 takes this interchange straight onto I-77.` → `A truck coming from Charleston on I-26 and bound for Charlotte takes this interchange straight onto I-77.`

### Recommended (not blocking)

- **4656 compass points.** I-20/I-77 is northeast of downtown and I-20/I-26 is northwest; "east" and "west" are loose, not false.
  - Body `<strong>I-20 and I-77, east of downtown.</strong>` → `<strong>I-20 and I-77, northeast of downtown.</strong>`
  - Key takeaways `<strong>I-20 and I-77</strong> east of downtown` → `<strong>I-20 and I-77</strong> northeast of downtown`
  - FAQ 0 `and meets I-77 east of downtown.` → `and meets I-77 northeast of downtown.`
  - Body and FAQ 0 `runs north toward Rock Hill and Charlotte` → `curves east around Columbia and then runs north toward Rock Hill and Charlotte` (I-77 "heads east" from Cayce before turning north).
- **4687: the 14-mile corridor is not Malfunction Junction.** Malfunction Junction is the I-20/I-26 interchange inside the corridor.
  - Body `in Columbia &mdash; the interchange complex long known as <strong>&ldquo;Malfunction Junction.&rdquo;</strong>` → `in Columbia, which includes the I-20/I-26 interchange long known as <strong>&ldquo;Malfunction Junction.&rdquo;</strong>`
  - Key takeaways `in Columbia &mdash; known as <strong>&ldquo;Malfunction Junction&rdquo;</strong> &mdash; carrying` → `in Columbia, including the I-20/I-26 interchange known as <strong>&ldquo;Malfunction Junction&rdquo;</strong>, and carrying`
  - FAQ 0 `corridor in Columbia, long known as Malfunction Junction.` → `corridor in Columbia, including the I-20/I-26 interchange long known as Malfunction Junction.`
  - These can go in the same run as the `$2.08` → `$2.69` edits. Order them so that each `from` string still matches.

### Confirmed

- **Carolina Crossroads.** The project homepage (scdotcarolinacrossroads.com, read 2026-09-28) gives:
  - "2.69 billion dollar investment" and "reconfiguring 14 miles of the I-20/I-26/I-126 corridor";
  - "More than 134,000 vehicles travel through the I-20/I-26/I-126 corridor on a daily basis";
  - "began in November 2021 and is expected to be substantially complete in the mid-2030s".
  - Its `/about` page still shows the old "$2.08 billion" and "9 Years of Construction". Cite the homepage, not `/about`.
- **Interchanges and exits.**
  - I-77 begins at I-26 in Cayce (Wikipedia *Interstate 77 in SC*).
  - I-20 meets I-77 at I-20 Exit 76.
  - Malfunction Junction is I-20/I-26 (Exit 107). I-126 leaves I-26 at Exit 108 and runs downtown.
- **4656 legal section** (apart from R2):
  - SOL § 15-3-530; Nelson 50% or less;
  - SCTCA two years, or three with an optional verified claim filed within one year, and $300,000 / $600,000 (§§ 15-78-110, 15-78-80, 15-78-120);
  - punitive damages only with clear and convincing proof (§ 15-33-135);
  - no conduct standard stated, which is correct given the pack.
  - The FMCSA and broker lines are hedged ("where the facts support it").
- **Fix script (L2, L3, L6).**
  - The four table cites now read "§§ 15-78-110, 15-78-120".
  - The 4687 SCTCA paragraph and FAQ 4 now state the deadline and the caps with the right sections, and the surrounding sentences read correctly ("…subject to the SC Tort Claims Act. Suit must be filed…").
  - Cutting "busiest interchange system" leaves "More than 134,000 vehicles daily pass through this corridor." intact.
  - The 4654 replacement reads correctly after "…not originally designed for current traffic volumes."
  - The 3518 table cell ("Awarded only in rare cases, and must be proved by clear and convincing evidence (S.C. Code § 15-33-135).") matches `SC 15-33-135`, and its "Examples" cell (drunk driving, street racing) still fits.
  - After both scripts, no "I-26/I-20/I-77" wording remains in the export apart from 4656's slug.
- **Mechanics.**
  - Replacements use `str_replace`, `substr_count` guards and single-quoted or nowdoc literals. The `$` in `$2.69` and `$300,000` is literal and safe in this form. Do not convert to `preg_replace` or double-quoted strings.
  - Meta is written with `wp_slash`, and columns with `$wpdb->update`, which does no unslash.
  - None of the 8 posts has `_roden_last_reviewed` set, so no stale review stamp certifies the new copy.

### Pack change (proposed; not made)

- Amend the `SC 15-38-15` claim for the version effective 2026-01-01, with `verifiedBy: null`, for Gillin's packet:
  - (F): several-only liability does not apply to a defendant whose conduct is wilful, wanton, reckless or intentional, or involves illegal drugs. Such a defendant is jointly and severally liable. The pre-2026 alcohol and gross-negligence exceptions were dropped.
  - (G)–(H): fault may be allocated to a disclosed nondefendant tortfeasor.
  - (C)(a): vicariously liable defendants are treated as a single party.
  - Evidence: scstatehouse.gov/code/t15c038.php, read 2026-09-28.
- The pack entry was verified 2026-09-08 against a section that has since changed. Its general claim is still true, but any page that states the exception needs the amended entry signed first.

After R1–R3: re-run both dry runs (the new 4655 `from` strings must each match exactly once), re-run `scratchpad/followup-fixture.json`, apply, then run `bin/check-unslashed-post-writes.php` and regenerate `content/meta.json`.
