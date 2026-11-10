# SC boating authorities and live boating-page findings, 2026-11-09

**Purpose.** These are the authorities the approved statewide guide, "South Carolina boating accident law" (`/resources/`, `_roden_jurisdiction` sc, `practice_category` boating), will rely on. Each was verified against primary text and queued for the attorney's sign-off. This file also lists what the live boating pages get wrong against that text. No Roden page was edited.

**Sign-off state.** The SC pack (`internal-ai-scripts/law/SC.json`) is **signed** by Graeham C. Gillin (2026-09-26). Roden's `law-signoff.json` does not declare SC, so that signature governs. The 12 boating authorities below are **`pendingAuthorities[]`, unsigned** (`verifiedBy: null`). **None of them can back a claim in the guide until Gillin signs and the pack moves them into `authorities[]`.** The guide must not be drafted on them before then. They ride in the next SC sign-off packet.

**Pack PR:** https://github.com/blue-sky-studio/internal-ai-scripts/pull/161 (not merged). It adds the 12 pending authorities, three error rules (`sc-bui-per-se-bac`, `sc-boater-education-birthdate`, `sc-boat-operator-minimum-age`) and the fixture file `law/fixtures/roden-sc-boating-2026-11-09.json` (39/39).

**Sweep.** `data/facts/sweep-2026-11-09.json` was run with `--fresh` (export 2026-11-10T00:09Z) on the pack as it stood **before** the PR: 0 findings. The same export swept with the PR's pack gives **9 findings, all on the four boating pages below**, none elsewhere.

**Primary source for every Chapter 21 authority:** https://www.scstatehouse.gov/code/t50c021.php, the official S.C. Code of Laws, read in full on 2026-11-09. The page carries amendments through 2026 Act No. 124 (eff. May 15, 2026) and 2026 Act No. 109 (eff. Jan. 1, 2027; it changes only the § 50-21-10(17) outboard-motor definition).

---

## Part 1: Authorities (pending sign-off)

### SC 50-21-112: boating under the influence (the offense)
- **Rule.** It is unlawful to operate a *moving motorized* water device or a water device *under sail* on the waters of this State while under the influence of alcohol, other drugs, or both, "to the extent that the person's faculties to operate are materially and appreciably impaired." **The offense is impairment. The section sets no BAC level at which operating is illegal per se.**
- **Quantities.** 1st offense: $200 fine **or** 48 hours to 30 days (48 hours of public service in lieu). 2nd: $2,000–$5,000 **and** 48 hours to 1 year (fine not suspendable below $1,000; 10 days of public service in lieu of jail). 3rd: $3,500–$6,000 **and** 60 days to 3 years. The department bars operation of any water device for **6 months / 1 year / 2 years** on the 1st / 2nd / 3rd conviction. Priors count within **10 years**. ADSAP and a boating safety course are required before reinstatement.
- **The guide may say:** impaired boating is a crime in South Carolina; it covers motorboats, PWCs and sailboats under way; the penalties escalate; a conviction suspends boating privileges.
- **The guide may not say:** that South Carolina's boating "legal limit" is 0.08%, that operating at 0.08% is itself illegal, or that § 50-21-112 "criminalizes operating at or above 0.08."

### SC 50-21-114: implied consent, testing and BAC inferences
- **Rule.** Operating a water device is deemed consent to breath, blood or urine testing on a BUI arrest, with a breath test offered first. In a criminal prosecution the BAC raises these inferences:
  - **0.05% or less**: conclusively presumed *not* under the influence.
  - **More than 0.05% but less than 0.08%**: no inference either way; other evidence decides.
  - **0.08% or more**: it **may be inferred** that the person was under the influence.

  On refusal, no test is given, the department suspends the privilege for **180 days**, and the refusal is admissible "at the trial of a person charged with the offense." The coroner must order a blood test within **48 hours** of notice of a boating fatality.
- **The guide may say:** 0.08% or more lets the court or jury *infer* impairment; refusal costs 180 days of boating privileges and can be used at the criminal trial; fatal accidents get a coroner's blood test.
- **The guide may not say:** that 0.08% is a per se limit. It also may not say that refusal creates an "adverse inference in civil proceedings": the section addresses admissibility at the criminal trial only. A civil-evidence statement needs other authority and Gillin's view.

### SC 50-21-113: BUI causing injury, death or damage
- **Rule.** BUI (operating or in actual control of a moving water device) that causes **great bodily injury or death** of another person is a **felony**. BUI that causes property damage or injury short of that is a misdemeanor. "Great bodily injury" means injury creating a substantial risk of death, or causing serious, permanent disfigurement or protracted loss or impairment of a bodily member or organ.
- **Quantities.** Great bodily injury: mandatory $5,000–$10,000 **and** 30 days–15 years. Death: $10,000–$25,000 **and** 1–25 years. No suspension of sentence and no probation. Misdemeanor: not less than $500 or up to 30 days, or both. Suspension for any prison term **plus 3 years** (death or great bodily injury) or **plus 1 year** (lesser harm).
- **The guide may say** "felony BUI" only for great bodily injury or death.

### SC 50-21-130: duty to stop, render aid, exchange information and report
- **Rule (A).** An operator involved in a collision, accident or other casualty must, if he can do so without serious danger to his own vessel, crew or passengers, render practical or necessary assistance. He must also give his name, address and vessel identification **in writing** to anyone injured and to the owner of damaged property.
- **Rule (B).** A person who renders assistance gratuitously and in good faith is not civilly liable for doing so.
- **Rule (C).** For a *reportable* accident (see § 50-21-10 below), the operator or owner files a full description with **SCDNR within 48 hours**. Death, loss of consciousness or serious bodily injury must be reported to SCDNR **immediately**.
- **Rule (D).** The report is for the department's information. The injured person, the person alleged to have caused the harm, their attorney, a personal representative or an insurer may obtain a copy. **No report or statement in it is admissible as evidence in a civil trial.** The fact that it was filed is admissible only to show compliance.
- **Penalties for failing to stop or comply.** Misdemeanor (injury or damage short of great bodily injury): 30 days–1 year or $100–$5,000, or both. Felony (great bodily injury): 30 days–10 years **and** $5,000–$10,000. Felony (death): 1–25 years **and** $10,000–$25,000. Suspension of **2 years** for not rendering aid and **1 year** for not reporting; no reinstatement until a boating safety course is completed.
- **The guide may say:** get the report, because the victim and the victim's attorney are entitled to a copy.
- **The guide may not say:** that the SCDNR report itself is evidence at trial. It is inadmissible in the civil case.

### SC 50-21-10: definitions (reportable accident, vessel, waters of the State)
- **Rule (21): reportable boating accident.** An accident, collision or other casualty involving a vessel that results in:
  - loss of life;
  - injury causing loss of consciousness, the need for medical treatment, the need to carry a person from the scene, or disability preventing normal duties beyond the day of the casualty; or
  - property damage, including to vessels, **in excess of the minimum amount set by the U.S. Coast Guard**.
- **The dollar figure is not in the S.C. statute.** The federal minimum, 33 C.F.R. § 173.55(a)(3), is damage that "totals $2,000 or more." It was read at https://www.ecfr.gov/current/title-33/part-173/section-173.55 on 2026-11-09. Write "more than $2,000 in damage (the Coast Guard minimum, which South Carolina adopts)". Do not present $2,000 as a South Carolina statutory number, and note that it moves if the Coast Guard changes it.
- **SC wording vs. federal wording.** SC says "necessity for medical treatment" and adds loss of consciousness, being carried from the scene, and disability beyond the day. The federal rule says "medical treatment beyond first aid" and adds disappearance from the vessel. Do not give the federal list as South Carolina's.
- **Other definitions.** "Waters of the State" are waters within the State's territorial limits **but not private lakes or ponds**. "Vessel" is every watercraft used or capable of being used for transportation on water. "Water device" adds water skis, aquaplanes, surfboards and similar devices.

### SC 50-21-110: negligent operation
- **Rule.** No one may operate a water device negligently. The statute's examples (the list is "not limited to" them): above idle speed in a no wake zone, failing to keep a proper lookout, too fast for conditions, racing, pulling a skier through a designated swimming area.
- **Quantities.** Misdemeanor: $50–$200 or up to 30 days per violation. Three convictions in 5 years require a boating safety course, and the privilege is suspended until it is completed.

### SC 50-21-111: reckless operation
- **Rule.** Operating with a wilful or wanton disregard for the safety of persons or property. The statute's examples: weaving through congested traffic above idle speed; jumping another vessel's wake **within 200 feet** of it; crossing a vessel's path or wake when visibility is obstructed; holding a collision course and swerving away at close range.
- **Quantities.** $100–$200 or up to 30 days, and a mandatory boating safety course. A 2nd conviction within 5 years brings a 90-day suspension, then suspension until the course is completed.

### SC 50-21-115: reckless homicide by boat
- **Rule.** When a death ensues **within three years** as a proximate result of injury from operating a boat in reckless disregard of others' safety, the operator is guilty of reckless homicide.
- **Quantities.** $1,000–$5,000 or up to 10 years, or both. The court bars the operator from boating for up to 5 years (also on a conviction for involuntary manslaughter, manslaughter or murder in boat operation).
- **The three years is a causation window for the crime, not a filing deadline.** The pack forbids pairing this cite with "statute of limitations."

### SC 50-21-95 (with § 50-21-90): boating safety certificate; no minimum operating age
- **Rule.** Operating a vessel with an engine of **10 horsepower or more**, a personal watercraft, or a specialty propcraft is unlawful unless the operator:
  1. was born **on or before July 1, 2007**;
  2. holds, or is documented by SCDNR as holding, a South Carolina boating safety certificate;
  3. holds a Coast Guard operator's license or merchant mariner credential (the expiration date does not matter);
  4. is a nonresident with another state's certificate;
  5. is renting from a rental business with a valid boat rental safety certificate, which is valid **30 days** (§ 50-21-90(C)); or
  6. is accompanied by a person **at least 18** who meets one of items 1–4.
- **Non-criminal.** A violation is not a crime: a $50–$300 fine, no court costs, no custodial arrest (except on a failure-to-appear or failure-to-pay warrant), and no SCDNR or SLED record. Effective **August 18, 2023** (2023 Act No. 74, § 3).
- **No minimum operating age.** Chapter 21 now sets **no minimum age to operate**. The same act (§ 5) deleted the former § 50-21-870(B)(9) item on operators younger than sixteen.
- **The guide may not say:** "must be 16," "born after January 1, 1988" (or Georgia's January 1, 1998) as South Carolina law, or that boating without a certificate is a criminal offense.

### SC 50-21-870: personal watercraft and boating safety rules
- **Life jackets.** Everyone aboard a PWC or specialty propcraft wears a Coast Guard-approved Type I, II, III or V PFD. On a Class "A" boat (under sixteen feet), every person **under 12** wears one.
- **Hours.** No PWC operation **after sunset or before sunrise**.
- **Engine cut-off.** A self-circling device or lanyard cut-off switch is required, and the lanyard must be attached to the operator.
- **Idle-speed distances on the named lakes** (Greenwood, Hartwell, Jocassee, Keowee, Marion, Monticello, Murray, Robinson, Russell, Secession, Thurmond, Wateree, Fishing Creek and Parr reservoirs, and a stretch of the Savannah River): **100 feet** of a wharf, dock, bulkhead or pier, and **50 feet** of a moored or anchored vessel or a person in the water.
- **Idle-speed distances on all other waters:** **50 feet** of those, and **100 yards** of the Atlantic coastline. Lake Moultrie is excepted.
- **Wake surfing.** No wake surfing above idle speed within **200 feet** of a moored vessel, dock or person in the water.
- **Towing.** A PWC towing a skier needs a wide-angle mirror or an observer.
- **Owners.** An owner, or a person in charge, who knowingly permits a violation also violates the section.
- **Penalty and exemption.** Misdemeanor, $50–$300. Private waters are exempt.

### SC 50-21-120: owner and livery liability (civil)
- **Owner liability.** The owner of a vessel is **liable for injury or damage caused by its negligent operation**, whether the negligence is a statutory violation or a failure of ordinary care. This applies only if the vessel was used with the owner's express or implied consent, or was in the possession of a person or organization legally responsible for it. Use by a **member of the owner's household is presumed consented**. The section does not reduce anyone else's liability.
- **Livery duties.** A boat livery may not let a vessel depart unless it is sound and safe, registered, numbered and equipped (§ 50-21-610). The livery owner is liable for injury resulting directly from that failure.
- **Rented vessels.** The livery is **not** liable *as owner* for a renter's negligent operation; the **renter-operator is liable as owner**.
- **This is the guide's main civil authority for owner liability.** It supports "the owner can be liable even if someone else was driving," with the consent condition stated.

### SC 50-21-710: regulatory markers
- **Rule.** Operating within a marked prohibited area is negligent operation (reckless if serious enough) (C). Operating other than as regulatory markers, including no wake zones, prescribe is unlawful (D). Existing no wake zones are deemed established under the section (F).
- **Limits.** This is a criminal and regulatory provision. It does not itself say a violation is civil negligence per se, and causation must still be proved (see Part 3, item Q2).

### Already signed; apply unchanged to state-law boating claims
- **SC 15-3-530.** Three years. (5) covers "any injury to the person or rights of another, not arising on contract," with no boating carve-out. (6) covers wrongful death and runs from the death. Re-read 2026-11-09 at scstatehouse.gov/code/t15c003.php.
- **Nelson v. Concrete Supply Co.** Modified comparative negligence: recovery is barred if the plaintiff's negligence exceeds the defendants'. **This holds under state law only** (see the federal scope warning).
- **Government defendants.** SC 15-78-x (SCDNR, a county, public landings) is already in the pack.

### Federal maritime overlay: a scope warning, not added to the pack
These were read on LII, 2026-11-09. They are not added because the pack is a state pack.
- **46 U.S.C. § 30106.** "A civil action for damages for personal injury or death arising out of a maritime tort must be brought within 3 years after the cause of action arose." The same length as SC's, but it is federal law with its own accrual rule.
- **46 U.S.C. §§ 30523 and 30529 (Limitation of Liability Act, as renumbered in 2022).** The owner's liability may be limited to "the value of the vessel and pending freight" for losses incurred without the owner's privity or knowledge. The owner's limitation action "must be brought within 6 months after a claimant gives the owner written notice of a claim."
- **46 U.S.C. §§ 30302–30303 (DOHSA).** Applies to deaths "on the high seas **beyond 3 nautical miles** from the shore". Recovery is "pecuniary loss."
- **Not verified here; the guide should not state them without Gillin:**
  - when admiralty jurisdiction attaches (navigable waters plus a maritime nexus);
  - that admiralty applies **pure** comparative fault rather than Nelson's bar;
  - that state wrongful-death remedies survive in state territorial waters.

  For the guide, a short "if the accident happened on navigable waters, federal law may change the rules" warning is enough.

---

## Part 2: Live-page findings (export 2026-11-10T00:09Z; none edited)

**Pages checked.** The three pages named in the brief, plus the BUI child page and the two Charleston boating posts, which the boating-pages sweep surfaced. All are outside their 90-day window per `data/seo/ledger.json`, and every fix below is a sentence replacement.

**Pages not checked:**
- `/boating-accident-lawyers/columbia-sc/` **no longer exists.** It was removed on 2026-09-19 (url-triage.csv: Rule 6, office-city intersections), and `inc/legacy-redirects.php` line 2282 301s it to `/practice-areas/boating-accident-lawyers/`. There is nothing to check.
- `/practice-areas/es-boating-accident-lawyers/` **does not exist.** The Spanish twin is `/es/practice-areas/boating-accident-lawyers/` (page 4895), checked below: **no SC errors.**
- Live HTML returns 403 to scripted fetches, so all checks used the adapter export.

### F1. /practice-areas/boating-accident-lawyers/ (page 3616): FAQ 4 (`_roden_faqs[3]` + FAQPage schema)
- **Published:** "South Carolina has the same 0.08% threshold (S.C. Code § 50-21-114)."
- **Corrected:** "South Carolina's law turns on impairment instead: it is a crime to operate a moving motorboat or sailboat while materially and appreciably impaired (S.C. Code § 50-21-112), and a BAC of 0.08% or more allows the inference that the operator was under the influence (S.C. Code § 50-21-114)."
- **Authority:** SC 50-21-112, SC 50-21-114 (pending).
- **Rule:** `sc-bui-per-se-bac`.

### F2. Page 3616: `_roden_pillar_compensation_intro` (federal; error, not caught by any rule)
- **Published:** "On navigable waters in death cases, **DOHSA limits recovery to pecuniary losses** for non-seamen passengers — **barring noneconomic loss-of-society claims** entirely (a major trap for the unwary)."
- **Problem:** DOHSA reaches only deaths "on the high seas beyond 3 nautical miles from the shore" (46 U.S.C. § 30302). Most South Carolina boating deaths happen on navigable waters inside that line: harbors, the ICW, rivers, lakes.
- **Corrected:** "For deaths on the high seas more than three nautical miles from shore, the Death on the High Seas Act limits recovery to pecuniary losses (46 U.S.C. §§ 30302–30303), barring loss-of-society damages."
- **Authority:** 46 U.S.C. §§ 30302–30303, read on LII. It is federal and has no pack id, so **Gillin's confirmation is needed before the fix.**
- **Rule:** none (manual).

### F3. Page 3616: `_roden_pillar_negligence_intro` (federal; minor)
- **Published:** "the **Limitation of Liability Act, 46 U.S.C. § 30501**, lets a vessel owner cap liability to the post-casualty value of the vessel"
- **Problem:** § 30501 is now the definitions section. The cap is § 30523(a), "value of the vessel and pending freight". "Post-casualty" valuation comes from case law, not the statute.
- **Corrected:** "the **Limitation of Liability Act, 46 U.S.C. § 30501 et seq.**, lets a vessel owner seek to cap liability at the value of the vessel and pending freight (§ 30523)".
- **Rule:** none (manual).
- The `{{SC}}` sentence in this field is correct. It fired the new BUI rule only across the `{{/GA}}{{SC}}` marker, and the PR's rule no longer does (see Part 4).

### F4. Page 3616: FAQ 1 (improvement, not an error)
- **Published:** "In South Carolina, the reporting threshold is also triggered by injury, death, or significant property damage (S.C. Code § 50-21-130)."
- **Suggested:** "In South Carolina, an accident must be reported to SCDNR within 48 hours if it causes a death, an injury needing medical treatment or causing loss of consciousness, or property damage above the Coast Guard minimum (now $2,000), and immediately if someone dies, loses consciousness or is seriously hurt (S.C. Code §§ 50-21-10, 50-21-130)."
- **Authority:** SC 50-21-130, SC 50-21-10 (pending).

### F5. /boating-accident-lawyers/boating-under-influence/ (page 4144): body, "Georgia & South Carolina BUI Laws"
- **Published:** "Both Georgia and South Carolina prohibit operating any vessel with a blood alcohol concentration (BAC) of 0.08% or higher, mirroring DUI thresholds for motor vehicles:"
- **Corrected:** "Georgia prohibits operating any vessel with a blood alcohol concentration (BAC) of 0.08% or higher, mirroring DUI thresholds for motor vehicles; South Carolina makes impaired operation the crime, and a BAC of 0.08% or more lets the court infer impairment:"
- **Authority:** SC 50-21-112, SC 50-21-114.
- **Rule:** `sc-bui-per-se-bac`.

### F6. Page 4144: FAQ 1 (`_roden_faqs[0]` + schema)
- **Published:** "Both states set the legal limit at 0.08% BAC for boaters 21 and older, the same threshold as driving. Georgia law (O.C.G.A. § 52-7-12) and South Carolina law (S.C. Code § 50-21-112) criminalize operating any vessel at or above this level."
- **Corrected:** "Georgia sets the legal limit at 0.08% BAC for boaters 21 and older, the same threshold as driving (O.C.G.A. § 52-7-12). South Carolina sets no fixed limit: S.C. Code § 50-21-112 makes it a crime to operate a moving motorboat or sailboat while materially and appreciably impaired, and under § 50-21-114 a BAC of 0.08% or more allows the inference that the operator was under the influence."
- **Authority:** SC 50-21-112, SC 50-21-114.
- **Rule:** `sc-bui-per-se-bac`.
- **Georgia half.** It is kept as published. The GA pack is unsigned for Roden, and its accuracy is outside this pass.

### F7. Page 4144: body (manual; unsupported for SC)
- **Published:** "Refusal to submit to testing can result in license suspensions and adverse inferences in civil proceedings."
- **Corrected:** "Refusal to submit to testing can result in suspension of boating privileges (180 days in South Carolina) and can be used as evidence at the criminal trial."
- **Authority:** SC 50-21-114(C), (E).
- **Rule:** none. For Gillin: is there SC authority for a civil adverse inference? If there is, the original can stay with that cite.

### F8. /blog/boating-accidents-charleston-harbor-legal-rights/ (page 4340): FAQ 4 (`_roden_faqs[3]` + schema)
- **Published:** "Under S.C. Code section 50-21-112, operating a boat with a BAC of 0.08 percent or higher is illegal."
- **Corrected:** "Under S.C. Code section 50-21-112, operating a boat while materially and appreciably impaired by alcohol or drugs is a crime, and under section 50-21-114 a BAC of 0.08 percent or higher supports the inference that the operator was under the influence."
- **Authority:** SC 50-21-112, SC 50-21-114.
- **Rule:** `sc-bui-per-se-bac`.

### F9. Page 4340: body, "Boating Under the Influence in South Carolina" (manual; the engine misses it because the sentence names neither the state nor a boat)
- **Published:** "The legal limit is a <strong>blood alcohol concentration (BAC) of 0.08%</strong> — the same as for driving a car."
- **Corrected:** "A <strong>blood alcohol concentration (BAC) of 0.08%</strong> or more — the same figure used for driving — supports the inference that the operator was under the influence (S.C. Code § 50-21-114)."
- **Authority:** SC 50-21-114.

### F10. Page 4340: body step 2 and FAQ 6 (advisory)
- **Published:** "South Carolina law requires reporting boating accidents involving death, injury requiring medical treatment beyond first aid, disappearance of a person, or property damage exceeding $2,000 to the South Carolina Department of Natural Resources (SCDNR) within 48 hours"
- **Problem:** this is the federal list (33 C.F.R. § 173.55), not South Carolina's. SC adds loss of consciousness, being carried from the scene and disability beyond the day, does not list disappearance, and requires immediate notice for death, loss of consciousness or serious injury.
- **Corrected:** "South Carolina law requires reporting a boating accident to the South Carolina Department of Natural Resources (SCDNR) within 48 hours if it causes a death, an injury that needs medical treatment or causes loss of consciousness, or property damage above the Coast Guard minimum (now $2,000), and immediately if someone dies, loses consciousness or is seriously injured"
- **Authority:** SC 50-21-130(C), SC 50-21-10(21).
- **FAQ 6** ("Report the accident to SCDNR within 48 hours.") is acceptable as written.

### F11. /blog/jet-ski-personal-watercraft-accidents-charleston/ (page 4352): body list, SC jet ski laws
- **Published:** "<strong>BUI</strong> — operating a personal watercraft with a BAC of 0.08% or higher is illegal (S.C. Code § 50-21-112)"
- **Corrected:** "<strong>BUI</strong> — operating a personal watercraft while materially and appreciably impaired by alcohol or drugs is a crime, and a BAC of 0.08% or higher supports the inference of impairment (S.C. Code § 50-21-112; § 50-21-114)"
- **Rule:** `sc-bui-per-se-bac`.

### F12. Page 4352: FAQ 3 (`_roden_faqs[2]` + schema)
- **Published:** "Boating Under the Influence is illegal in SC at 0.08 percent BAC under S.C. Code section 50-21-112."
- **Corrected:** "Boating Under the Influence is operating a boat in SC while materially and appreciably impaired by alcohol or drugs (S.C. Code section 50-21-112); a BAC of 0.08 percent or more supports the inference of impairment (section 50-21-114)."
- **Rule:** `sc-bui-per-se-bac`.

### F13. Page 4352: FAQ 6 (`_roden_faqs[5]` + schema); **contradicts the page's own body**
- **Published:** "Operators must be 16+, need boater education if born after Jan 1 1988, must wear life jackets, cannot operate sunset to sunrise, must observe no-wake zones, and BUI at 0.08 BAC is illegal."
- **Self-contradiction:** the body list on the same page correctly says "anyone born after July 1, 2007 must hold a South Carolina boating safety certificate... (S.C. Code § 50-21-95)".
- **Corrected:** "Operators born after July 1, 2007 need a South Carolina boating safety certificate or a qualifying adult 18 or older aboard, everyone on a jet ski must wear a life jacket, jet skis cannot operate sunset to sunrise, operators must observe no-wake zones, and operating while impaired by alcohol or drugs is a crime."
- **Authority:** SC 50-21-95, SC 50-21-870, SC 50-21-112.
- **Rules:** `sc-boat-operator-minimum-age`, `sc-boater-education-birthdate`, `sc-bui-per-se-bac`.

### F14. Page 4352: key takeaways (soft; optional)
- **Published:** "South Carolina requires PWC operators to follow specific age and safety regulations."
- **Suggested:** "South Carolina requires a boating safety certificate of PWC operators born after July 1, 2007 and sets life-jacket and hours rules." This avoids implying an age minimum.
- **Authority:** SC 50-21-95, SC 50-21-870.

### Spanish twin, /es/practice-areas/boating-accident-lawyers/ (page 4895): no errors
- The 3-year period, the Nelson bar ("del 50% o menos") and "operar bajo la influencia es un delito" are correct.
- Its "negligencia per se" FAQ raises the same question as Q2 below.

### Shem Creek post (page 4355): correct; the model for corrections
- Its BUI, § 50-21-95 and § 50-21-110 sentences are correct. They are used as fixture controls.

---

## Part 3: Questions for Gillin (with the sign-off packet)

- **Q1.** Sign, or amend, the 12 pending authorities above.
- **Q2. "Negligence per se."** Pages 3616 (FAQ 7), 4895 (FAQ) and 4352 (body) say a violation of no-wake or boating statutes "establishes negligence per se" (4352 adds "automatically considered negligent" if it caused the accident). Under SC law, is that the right statement for Chapter 21 violations? § 50-21-710(C) calls marked-area violations "negligent operation" but does not speak to civil per se effect.
- **Q3.** Is there authority for a civil adverse inference from a BUI test refusal (F7)?
- **Q4.** May F2 and F3 (federal) be corrected as drafted?
- **Q5.** For the guide: may it state the admiralty pure-comparative-fault rule and the Yamaha territorial-waters wrongful-death point? Neither was verified in this pass.

## Part 4: Counts by rule, and false positives

| Rule | Findings (live, PR pack) | Pages |
|---|---|---|
| `sc-bui-per-se-bac` | 7 | 3616, 4144 (×2), 4340, 4352 (×3) |
| `sc-boater-education-birthdate` | 1 | 4352 |
| `sc-boat-operator-minimum-age` | 1 | 4352 |
| manual (no rule) | 6 errors or advisories: F2, F3, F7, F9, F10, F14 | 3616, 4144, 4340, 4352 |
| improvement | 1: F4 | 3616 |

**False positives.**
- During rule development, page 3616 `_roden_pillar_negligence_intro` matched `sc-bui-per-se-bac`. The match ran across `{{/GA}}{{SC}}`, joining the GA ".08 BAC" sentence with the correct SC sentence, because the engine does not treat block markers as sentence breaks.
- It was handled in the PR, not by editing the page. The control sentence went into the fixture first. The narrowest change was then made: the BUI assert may not cross a `{{` marker.
- The same engine limitation could affect any rule. An engine-level fix that treats `{{GA}}`, `{{SC}}` and their closing markers as sentence breaks is a separate proposal.
- None of the 9 remaining live findings is a false positive.

**Application.** WordPress legal sentences go through a `bin/` remediation script with exact-match `str_replace` and `wp_slash`. FAQ edits must update `_roden_faqs` so the FAQPage schema follows. F2, F3 and F7 wait for Gillin.
