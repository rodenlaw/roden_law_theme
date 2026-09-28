# Pre-publish legal sweep: Charleston motorcycle accident page (post 3639, DRAFT)

- **Page:** `/motorcycle-accident-lawyers/charleston-sc/` (post 3639, `practice_area`, draft, `_roden_retired` still set; parent: the motorcycle pillar, post 3607). Wave 1, #7.
- **Jurisdiction:** South Carolina only. Reviewer of record: Graeham C. Gillin (SC Bar).
- **What was swept:** the rendered draft (`scratchpad/draft3639.txt`, `scratchpad/preview/draft3639.html`) and all 7 JSON-LD blocks in it (LegalService, Person, FAQPage, WebPage, HowTo, LocalBusiness/LegalService/LawFirm, BreadcrumbList).
  - **Page surfaces**, from `bin/rebuild-charleston-motorcycle-accident.php`: body, excerpt, meta description, key takeaways, 6 FAQs.
  - **Template blocks:** hero, NAP bar, office map and directions, law box, what-to-do steps and HowTo, case types, the local-context essay, the motorcycle pillar's negligence and compensation intros (as corrected today by `bin/fix-motorcycle-pillar-intros.php`, applied 2026-09-28 15:36 UTC), the stats block, attorneys, case results, resources, the sidebar and the footer.
  - **Linked pages** that the page sends a reader to on a legal point were opened in `content/meta.json` (W4, W5). The Spanish twin, post 5184, was read from production, read-only (W6).
- **Pack:** `law/SC.json` is **SIGNED** (Graeham C. Gillin, 2026-09-26) for its 31 authorities.
  - **§§ 56-5-3640 and 56-5-3660 are NOT signed.** They are `pendingAuthorities` on branch `law/sc-motorcycle-statutes-2026-09-28` (internal-ai-scripts PR #68, commit `110238e`). They were verified against scstatehouse.gov primary text but carry `verifiedBy: null`. See B1.
- **Engine run:**
  - 94 blocks were replayed through `sweep-claims.mjs --fixtures scratchpad/draft3639-fixture.json --states SC,GA`, on the PR #68 working tree. The blocks cover the rendered text, the 6 FAQPage answers, the 7 HowTo steps, the LegalService description and the key takeaways.
  - Result: **0 findings**.
  - A positive control (a § 15-38-15 miscite) fired, which confirms the rules were loaded. Result line: 95/95.
  - Every finding below comes from hand reading, by claim class.

**Verdict: FAIL.**
- One error-level finding (E1): the helmet FAQ states the age rule wrongly for riders aged 18 to 20. It is published twice, once in the FAQ and once in the FAQPage schema.
- Separately, publish is gated on B1: Gillin must sign §§ 56-5-3640 and 56-5-3660 (PR #68), because seven surfaces rest on them.
- With E1 fixed and PR #68 signed, the page passes with the warnings below.
- The byline "Reviewed by Graeham C. Gillin" must not go live until he has actually reviewed this page. `_roden_last_reviewed` is correctly unset. The pre-apply backup shows no stale review date.

Source key:
- **PAGE** means `bin/rebuild-charleston-motorcycle-accident.php` (post 3639 content and meta).
- **TEMPLATE** means the theme, `inc/firm-data.php`, or motorcycle-pillar meta (post 3607). A TEMPLATE fix reaches every motorcycle office page in both states.
- **LINKED** means a separate published page that this page links to. It is not rendered here, so it does not block this publish.

---

## GATE

### B1. Seven surfaces rest on two unsigned authorities

`SC 56-5-3640` and `SC 56-5-3660` are pending in PR #68. The pack's rule is that an authority cannot back a new claim until an attorney signs it. These claims must not publish until Gillin signs PR #68 and the pack records `verifiedBy`.

| # | Surface | Source | Sentence (as published) | Rests on |
|---|---|---|---|---|
| 1 | Key takeaways | PAGE `_roden_key_takeaways` | "Riders 21 and older are not required to wear a helmet (S.C. Code § 56-5-3660), and every motorcycle is entitled to the full use of its lane (S.C. Code § 56-5-3640)." | both |
| 2 | Body, "Your right to the lane" | PAGE `post_content` | "South Carolina law entitles every motorcycle to the full use of a lane … (S.C. Code § 56-5-3640). The same section prohibits riding between lanes of traffic or rows of vehicles, and riding more than two abreast in a single lane." | 3640 |
| 3 | Body, "Helmets" | PAGE `post_content` | "South Carolina requires a helmet only for operators and passengers under 21 (S.C. Code § 56-5-3660). If you were 21 or older, riding without a helmet broke no law." | 3660 |
| 4 | FAQ 3 + FAQPage | PAGE `_roden_faqs[2]` | see E1 | 3660 |
| 5 | FAQ 5 + FAQPage | PAGE `_roden_faqs[4]` | "No. S.C. Code § 56-5-3640 prohibits riding between lanes of traffic or rows of vehicles. …" | 3640 |
| 6 | Body, "Do I Have a Motorcycle Accident Case in Charleston?" | TEMPLATE `_roden_pillar_negligence_intro` `{{SC}}` branch (post 3607) | "South Carolina requires helmets only for riders under 21 under S.C. Code § 56-5-3660." | 3660 |

Each sentence matches the primary text. It was re-read today at scstatehouse.gov/code/t56c005.php, with one exception: the two-abreast carve-out (W2).

Row 6 is not new. The sentence was already live on the pillar and on every SC motorcycle intersection before today, backed only by the helmet-claim verification of 2026-09-19. The same sign-off covers it.

Pack housekeeping for PR #68, before it goes into Gillin's packet:
- Both `evidence` fields name the scstatehouse page but no URL for the section itself. Add a Justia URL where it can be fetched, per the pack's evidence preference.
- `SC 56-5-3640` has `quantities: []`. The two-abreast limit ("two") is a quantity the claim states.

## ERROR

### E1. The helmet FAQ says an "adult" rider without a helmet broke no law

- **Surface / block:** FAQ 3 ("Can I still recover if I was not wearing a helmet?"), and the same answer in the FAQPage JSON-LD.
- **Source:** PAGE, `_roden_faqs[2]`.
- **Published:** "Yes, you can still bring a claim. South Carolina requires a helmet only for operators and passengers under 21 (S.C. Code § 56-5-3660), so an adult rider without one broke no law. An insurer may still raise it, which is one reason to preserve the evidence of how the crash happened."
- **Corrected:** "Yes, you can still bring a claim. South Carolina requires a helmet only for operators and passengers under 21 (S.C. Code § 56-5-3660), so a rider 21 or older without one broke no law. An insurer may still raise it, which is one reason to preserve the evidence of how the crash happened."
- **Authority:** `SC 56-5-3660` (pending, PR #68): "unlawful for any person under the age of twenty-one to operate or ride upon a two-wheeled motorized vehicle unless he wears a protective helmet".
- **Rule:** none fired. No SC rule covers the helmet age threshold (see "Pack changes", item 2).
- **Why it is an error:** an 18-, 19- or 20-year-old is an adult who *did* break § 56-5-3660 by riding without a helmet. The sentence gives the age rule and then states a conclusion the rule contradicts.
  - The page's own body and key takeaways say "21 or older" / "21 and older" correctly. The FAQ disagrees with them, and it is the version that goes out in structured data.
- **Same claim class elsewhere (not on this page, low severity):**
  - `/resources/south-carolina-personal-injury-faq/` `_roden_faqs[50]` says "Yes, if you were 21 or older, since the law does not require a helmet for adult riders".
  - The ES twin `_roden_faqs[58]` says "…la ley no exige casco para los motociclistas adultos".
  - Both are conditioned on 21, so neither is false, but "adult riders" should read "riders 21 and older". Fix both in the same `bin/apply-faq-remediation.php` pass.
- **Fix path:** the rebuild script's `$faqs[2]` (the page is still a draft, so re-run the script). Re-render, then confirm the FAQ and the FAQPage answer match character for character.

## WARN

### W1. UM/UIM: the right statutes, but the one rule that bites a rider is missing

This is the check the caller asked for: whether the UM/UIM sentences overstate how § 38-77-150 applies to a motorcyclist.

- **Surfaces:**
  - Body, "Your own coverage": PAGE `post_content`.
  - FAQ 6 + FAQPage: PAGE `_roden_faqs[5]`.
  - Body, "Types of Compensation…": TEMPLATE `_roden_pillar_compensation_intro`, `{{SC}}` branch, post 3607.
- **Published:**
  - Body: "Every South Carolina auto policy must include uninsured motorist coverage (S.C. Code § 38-77-150), and insurers must offer underinsured motorist coverage (S.C. Code § 38-77-160). Because injuries in motorcycle crashes are often severe, your own UM or UIM coverage can matter when the at-fault driver's policy is not enough. Which of your policies applies depends on its terms."
  - FAQ 6: "Your own coverage may pay. Every South Carolina auto policy must include uninsured motorist coverage (S.C. Code § 38-77-150), and insurers must offer underinsured motorist coverage (S.C. Code § 38-77-160). Which of your policies applies depends on its terms."
  - Compensation intro: the same two sentences on § 38-77-150 and § 38-77-160.
- **Assessment:** the sentences do **not** overstate § 38-77-150 for a rider. Read against t38c077.php and t56c009.php on 2026-09-28:
  - § 38-77-150(A) binds every "automobile insurance policy".
  - § 38-77-30(1) defines automobile insurance to include "a motor vehicle liability policy as defined in … Section 56-9-20".
  - § 56-9-20(4) defines "motor vehicle" as every self-propelled highway vehicle, excepting mopeds and other named machines but not motorcycles.
  - § 38-77-30(5.5)(a)(iv) lists "motorcycles" as individual private passenger automobiles.
  - So a South Carolina motorcycle policy must carry UM. The page's "auto policy" is correct, but a rider may read it as not covering the bike.
- **What the page gets wrong:**
  - "Which of your policies applies depends on its terms" puts on the policy what the statute decides.
  - § 38-77-160: "If … an insured … is protected by uninsured or underinsured motorist coverage in excess of the basic limits, the policy shall provide that the insured … is protected only to the extent of the coverage he has on the vehicle involved in the accident."
  - For a rider, the vehicle involved is usually the motorcycle. A rider who carries high UIM on a car and minimum UIM on the bike is limited to the bike's coverage.
  - This is the motorcycle-specific trap. The page names the right statute and then sends the reader to "its terms".
- **Corrected (body):** "Every South Carolina auto policy, including a motorcycle policy, must include uninsured motorist coverage (S.C. Code §§ 38-77-30, 38-77-150), and insurers must offer underinsured motorist coverage (S.C. Code § 38-77-160). Because injuries in motorcycle crashes are often severe, your own UM or UIM coverage can matter when the at-fault driver's policy is not enough. Above the basic limits, South Carolina generally limits you to the coverage on the vehicle involved in the crash, which for a rider is usually the motorcycle's own policy (S.C. Code § 38-77-160), so the limits on that policy matter."
- **Corrected (FAQ 6):** "Your own coverage may pay. Every South Carolina auto policy, including a motorcycle policy, must include uninsured motorist coverage (S.C. Code §§ 38-77-30, 38-77-150), and insurers must offer underinsured motorist coverage (S.C. Code § 38-77-160). Above the basic limits, you are generally limited to the coverage on the vehicle involved in the crash (S.C. Code § 38-77-160)."
- **Corrected (compensation intro, `{{SC}}` branch):** "Every South Carolina auto policy, including a motorcycle policy, must include uninsured motorist coverage (S.C. Code §§ 38-77-30, 38-77-150), and insurers must offer underinsured motorist coverage (S.C. Code § 38-77-160)."
- **Authority:**
  - `SC 38-77-150` and `SC 38-77-160` are signed, but only for "mandatory" and "must be offered".
  - The motorcycle scope and the vehicle-involved limit need a new pending `SC 38-77-30` and an amended `SC 38-77-160` claim (see "Pack changes", item 3). Both are unsigned, so the corrected wording also needs Gillin.
- **Option B if Gillin does not want to sign the new claims before launch:** delete "Which of your policies applies depends on its terms." from the body and FAQ 6 and publish the rest unchanged. It names no new law, and it removes the only misleading sentence.
- **Rule:** none.
- **Severity:** warn. Nothing published is false, but the one sentence of guidance points the wrong way.

### W2. § 56-5-3640's two-abreast carve-out is omitted

- **Surfaces:** FAQ 5 + FAQPage (PAGE `_roden_faqs[4]`); body "Your right to the lane" (PAGE); key takeaways (PAGE).
- **Published (FAQ 5):** "The same section entitles every motorcycle to the full use of a lane, and a driver who crowds a rider out of the lane violates it."
- **Corrected (FAQ 5):** "The same section entitles every motorcycle to the full use of a lane (except when motorcycles ride two abreast in it), and a driver who crowds a rider out of the lane violates it."
- **Body:** optionally append "(this does not apply to motorcycles riding two abreast in one lane)" after the first cite. The key takeaways can stay as they are.
- **Authority:** `SC 56-5-3640`(a), pending: "This shall not apply to motorcycles operated two abreast in a single lane."
- **Rule:** none.
- **Severity:** low. The FAQ's flat "violates it" is the only place the omission changes the answer.

### W3. The page contradicts its own office block on the courthouse distance

- **Surface:** body, "Where your case would be filed". PAGE.
- **Published:** "…at the Charleston County Judicial Center, 100 Broad Street, a few blocks from our King Street office."
- **The directions block on the same page** (TEMPLATE, `inc/firm-data.php:185`, corrected 2026-09-26) says the office is "between Broad and Queen streets, about a block from the Charleston County Judicial Center".
- **Corrected:** "…at the Charleston County Judicial Center, 100 Broad Street, about a block from our King Street office."
- **Authority:** n/a (firm fact). **Rule:** none. **Severity:** low.

### W4. LINKED: the lane-splitting sub-type page states other states' law wrongly

- **Where it shows here:** the case-types grid and the sidebar both link to `/motorcycle-accident-lawyers/lane-splitting-accident/`. That page is published and two-state (`_roden_jurisdiction: both`).
- **Published (its `_roden_faqs[0]`):** "No. Lane splitting is illegal in both states. Georgia law (O.C.G.A. § 40-6-312) specifically prohibits operating a motorcycle between lanes of traffic. South Carolina has similar prohibitions. Only California explicitly permits lane splitting by statute."
- **Issues:**
  - "Only California" is no longer true: Minnesota enacted lane splitting effective 2025-07-01. Confirm the Minnesota cite before relying on it; the correction below does not need it.
  - "South Carolina has similar prohibitions" is uncited, and this page now carries the section.
- **Corrected (SC-side sentences only):** "…South Carolina law prohibits riding between lanes of traffic or between rows of vehicles (S.C. Code § 56-5-3640)." Delete "Only California explicitly permits lane splitting by statute." The Georgia sentence is left to the Georgia reviewer.
- **Authority:** `SC 56-5-3640` (pending). **Rule:** none.
- **Severity:** warn. It does not block this page, but this page's own FAQ 5 now answers the same question correctly, and the reader clicks straight through to a page that does not match it.

### W5. LINKED: the UM/UIM resource asserts stacking without the § 38-77-160 limit

- **Where it shows here:** the "Your own coverage" paragraph links "UM and UIM coverage in South Carolina" to `/resources/south-carolina-um-uim-stacking/` (Gillin-attributed).
- **Published (its excerpt and meta description):** "South Carolina lets drivers stack uninsured (UM) and underinsured (UIM) coverage across multiple vehicles or policies — potentially multiplying what you can recover." Its key takeaways and `_roden_faqs[0]` and `[2]` say the same, with the "$100,000 on each of two household vehicles" example.
- **Issue:**
  - Today's pillar fix removed the "UM/UIM stacking" and "household resident-relative coverage" claims from the motorcycle compensation intro because the pack does not support them.
  - This page now links motorcyclists to a resource that makes the same claim without the § 38-77-160 vehicle-involved limit, which is the limit that matters most to a rider.
  - Stacking is an attorney question (Class I vs Class II insureds). No correction is proposed here.
- **Action:** add the resource to Gillin's packet. Until he rules, consider pointing the anchor at the SC pillar's coverage section instead.
- **Severity:** warn, LINKED.

### W6. The Spanish twin (post 5184) was not rebuilt and still carries removed claims

- **Status:** draft, `_roden_retired` set, last modified 2026-09-18. It is paired to 3639 through `_roden_translation_es: 5184`. The rendered EN draft emits no hreflang to it.
- **Content:** it is the pre-rebuild copy.
  - Its FAQ says "La ley del estado permite acumular (stacking) su propia cobertura … entre varias pólizas" (the W5 class).
  - It says the King Street videos "se borran en días", which is unsourced.
  - It gives no government-entity (§ 15-78-110) deadline anywhere.
- **Action:** do not publish or un-retire 5184 until it is rebuilt from the corrected EN copy and swept.
- **Severity:** informational. It does not block EN.

## Checks that PASS

| Check | Result |
|---|---|
| Georgia law | **None.** No O.C.G.A. cite, Georgia deadline or Georgia rule on the page or in its JSON-LD. The pillar intros' `{{GA}}` branches do not render. The resources block is now SC-only (moped, golf cart, helmet, Grand Strand), which clears the car sweep's W10. |
| Two-state / other-state text | None in page copy or pillar intros. "Lane-splitting is illegal in both states" and "Both {state_full} and neighboring states allow UM/UIM stacking" are gone from 3607. Only the firm-level mentions remain (next row). |
| Firm-level GA mentions (accepted on siblings) | "Available 24/7 · Georgia & South Carolina" (CTA ×2), "$300M+ … across Georgia and South Carolina", "Licensed in GA & SC", footer offices and disclaimer. |
| Helmet-defense case law | **None.** The pillar's "most courts disallow the so-called 'helmet defense' … injury-enhancement arguments persist" was removed today. The page frames non-use only as the insurer's argument ("Insurers sometimes raise it anyway"), matching the 2026-09-19 helmet remediation. No claim that non-use is inadmissible or cannot reduce damages. |
| Stacking / household coverage | **None on the page.** Removed from the compensation intro today. Survives only on the linked resource (W5) and the ES twin (W6). |
| SOL | 3 years, S.C. Code § 15-3-530, the same in the KT, FAQ 2, law box, essay, negligence intro and sidebar. The sidebar now reads "usually ends your right to recover" (the car sweep's W5, fixed). |
| Government entity | Two years under § 15-78-110 (from loss or discovery), with an optional verified claim that extends it to three years (§ 15-78-80), in the body, KT and FAQ 2. $300,000 / $600,000 and no punitive damages under § 15-78-120. All match the signed pack. There is no "notice" wording anywhere, and the essay's SCTCA sentence (car E1) is no longer present. |
| Comparative fault | *Nelson v. Concrete Supply Co.* (in full in the law box). **§ 15-38-15 appears nowhere.** "50% or less" (KT, FAQ 4), "less than 51%" (law box, essay) and "51% … bar" (negligence intro) are accepted as equivalent, as on the siblings. |
| § 56-5-3640 (pending) | Full use of a lane, (a); no riding between lanes or rows, (c); no more than two abreast, (d). All three are correct against primary text, apart from W2. |
| § 56-5-3660 (pending) | "Operators and passengers under 21" and "21 and older" are correct against primary text (it reaches any two-wheeled motorized vehicle). Error only in FAQ 3's "adult" (E1). § 56-5-3670 (goggles or face shield, under-21 operators) is not stated. That omission is acceptable. |
| Police-report step and HowTo | The SC-specific § 56-5-1260 / § 56-5-1270 text (car W7, fixed) matches the signed pack. The step text and the HowTo JSON-LD are identical. |
| Punitive damages | No punitive dollar figure anywhere. The only statement is "no punitive damages" against a government entity, which is correct. |
| Statistics | No numeric crash statistic on the page (the rebuild script confirms `data/statistics.json` has none for SC motorcycles). Descriptive claims ("often severe", "many crashes happen when a driver turns left…") are hedged and unquantified. |
| Local-context essay | It carries the corrected Charleston text from 2026-09-26 (court "usually filed", no vendor name, no months, MUSC "adult and pediatric Level I", no crash statistics). |
| Directions | Corrected text from the truck sweep's W1 ("between Broad and Queen"). |
| Citation format and links | Every cite is `S.C. Code § XX-X-XXX`, with no "Ann." and no `O.C.G.A.` Three scstatehouse.gov links point to the right chapters (`t56c005`, `t15c078`, `t38c077`). |
| FAQ vs FAQPage JSON-LD | All 6 answers are identical. E1 is therefore in both. |
| Excerpt / meta description / LegalService description | They are marketing only, with no legal claim. |
| Author / reviewer | Graeham C. Gillin (SC Bar). `_roden_last_reviewed` is unset. |
| JSON-LD validity | 7/7 blocks parse. |
| Firm boilerplate (accepted or owner-deferred; not re-raised) | The stats block ("5,000+ Cases successfully handled", 170+ reviews, 62 years), the case-results grid, Nolan Alexander in the attorneys block, the statewide uplink "comparative-fault rule" (correct for a tort page), and the bottom CTA "believe another party is at fault" (correct for a tort page). |

## Counts by rule

| Rule | Findings | Severity |
|---|---:|---|
| (engine) all SC + GA rules, 94 blocks + control | 0 | — |
| Gate: claim rests on a pending authority (§§ 56-5-3640 / 3660) | 1 (6 surfaces) | block until signed |
| Hand: legal threshold misstated (helmet age, "adult") | 1 (+2 same-class, linked) | error |
| Hand: incomplete statement of law (UM/UIM vehicle-involved limit) | 1 (3 surfaces) | warn |
| Hand: statutory exception omitted (two abreast) | 1 | warn, low |
| Hand: page contradicts itself (courthouse distance) | 1 | warn, low |
| Hand: linked page wrong or unsupported (lane-splitting sub-type, stacking resource) | 2 | warn, LINKED |
| Hand: unrebuilt translation twin | 1 | info |
| **Total** | **8** (1 gate, 1 error, 5 warn, 1 info) | |

Source split:
- **PAGE:** E1, W1 (body and FAQ), W2, W3, and B1 rows 1–5.
- **TEMPLATE:** W1 (compensation intro) and B1 row 6.
- **LINKED / other posts:** W4, W5, W6, and the E1 same-class items.

## False positives

None. The engine raised nothing. The items below are **false negatives**, and they go to an `internal-ai-scripts` PR, not to a content edit.

## Pack changes (proposed; not made)

1. **PR #68:** Gillin signs `SC 56-5-3640` and `SC 56-5-3660` and moves them from `pendingAuthorities` to `authorities` with `verifiedBy` set. Add the section-level evidence URL and the 3640 quantity (B1).
2. **New rule `sc-helmet-adult-threshold` (error, SC).** Fixtures first, in `law/fixtures/`:
   - **Positives:** E1 as published; "In South Carolina, adults are not required to wear a helmet."; "In South Carolina, an adult riding without a helmet is legal."
   - **Controls:** the corrected E1 sentence; "If you were 21 or older, riding without a helmet broke no law."; "Riders 21 and older are not required to wear a helmet (S.C. Code § 56-5-3660)."; the Georgia universal-helmet sentence; "South Carolina has no statewide helmet requirement for adult bicycle riders."
   - **Patterns** (`W` = `(?:[^.!?]|(?<=\b[A-Z])\.)`, which lets the window run across "S.C."):
     - `helmet W{0,200} \badults?\b W{0,60} (broke no law | (is|are) not (legally )?required | no law requires | (is|are) (legal|lawful))`
     - `\badults?\b W{0,40} (without|not wearing|no) W{0,20} helmet W{0,60} (broke no law | (is|are) (legal|lawful))`
     - `\badults?\b W{0,30} (is|are|do|does) not (legally )?(required|have) to wear (a )?helmets?`
   - `unless`: `bicycl|e-bike|scooter|georgia|o\.c\.g\.a`.
   - Tested in scratch: 3/3 positives hit and 5/5 controls pass. The `unless` guards bicycle and scooter wording that pattern 3 could otherwise reach. Re-run both fixture sets to 100% before merging.
3. **Pending authorities, `verifiedBy: null`:**
   - **New `SC 38-77-30`.** Claim: "'Automobile insurance' includes a motor vehicle liability policy under § 56-9-20, whose 'motor vehicle' is every self-propelled highway vehicle except mopeds and certain machinery; motorcycles are expressly 'individual private passenger automobiles' (§ 38-77-30(5.5)(a)(iv)). The mandatory UM of § 38-77-150 therefore reaches a South Carolina motorcycle policy." Evidence: scstatehouse.gov/code/t38c077.php and t56c009.php, read 2026-09-28.
   - **Amend the `SC 38-77-160` claim** to add: "Above the basic limits, an insured is protected only to the extent of the coverage on the vehicle involved in the accident; if none of the insured's vehicles is involved, only to the extent of the coverage on any one vehicle." Evidence: t38c077.php, read 2026-09-28.
4. **Optional guard `sc-lane-splitting-legal` (error, SC)** for "lane splitting/filtering is legal/permitted/allowed in South Carolina", backed by `SC 56-5-3640`(c) once signed. There is no live hit today. It is proposed because the claim class now has an authority.

After any pack change: `node scripts/facts/vendor.mjs rodenlaw --write` if the client vendors the pack, then `--check`.

## Before publish

1. Fix E1 in `bin/rebuild-charleston-motorcycle-accident.php` (`$faqs[2]`). Take W2 and W3 in the same edit, and W1 either as the full correction (needs item 3 signed) or as Option B. Re-run the script against the draft.
2. If W1 goes out as the full correction: patch the `{{SC}}` branch of `_roden_pillar_compensation_intro` on post 3607 through a `bin/` patcher (exact-match `str_replace`, `update_post_meta( wp_slash( … ) )`, read-back). The key is on the export whitelist, so regenerate `content/meta.json` afterwards.
3. Gillin signs PR #68 (and item 3, if W1 goes out as the full correction). Record it in the pack.
4. Re-render the draft and re-run this sweep, including the replay fixture (`scratchpad/draft3639-fixture.json`, 95 entries).
5. Gillin reviews and signs off the page. Only then set `_roden_last_reviewed`, remove `_roden_retired` and publish. Leave post 5184 retired (W6).
6. Separately: W4 and W5 go to Gillin's packet and to a FAQ remediation pass. The Georgia-side sentences on the lane-splitting page go to the Georgia reviewer.
