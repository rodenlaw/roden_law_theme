# Linked-pages batch — 2026-09-28

Owner, 2026-09-28: "let's work through all the linked pages now".

**Machine list:** `data/facts/linked-pages-batch-2026-09-28.json`. It has 132 entries, and `bin/build-linked-pages-batch.py` embeds the `apply` class only.

**Sources.** Every LINKED, L-numbered, follow-up and Open item in:
- `remediation-2026-09-26-*` and `remediation-2026-09-28-*`;
- `RECOVERY-LOG.md` from 2026-09-26 onward.

Items the log records as fixed today were re-checked in a fresh export (2026-09-28 20:26 UTC) and are live-correct:
- 4059, the government-vehicle page;
- 4054 FAQ 4 and 4061 FAQ 5;
- 4645's legal lines;
- 4687 / 4680 / 4654 / 4655 / 4656 / 3518;
- 4814 / 4937 "21 or older";
- 4073 FAQ 0.

They are not in the batch.

**Law pack.** `law/SC.json` is signed by Graeham C. Gillin (39 authorities). Every `apply` edit rests only on those signed authorities or on a checked non-legal source. Everything that needs an authority not yet in the pack is class `gillin`, and those authorities are **unsigned**:
- SC 15-32-230;
- SC 42-1-400 and SC 42-1-410;
- SC 56-5-3130;
- SC 15-7-30;
- *Hook v. Rothstein*;
- amendments to SC 15-3-545 (B)/(D), 15-3-530(6) and 15-36-100.

Georgia items are for Eric Roden.

## Counts

| Class | Entries | Notes |
|---|---:|---|
| apply | 109 | 20 posts; 69 content, 29 FAQ answers, 11 key takeaways; no title or excerpt; 6 are pure deletions |
| gillin | 13 | 7 carry a ready `from`/`to` that waits on his answer; WD-G1 carries the sentence only |
| ga | 6 | listed without `from`/`to` |
| source-or-cut | 4 | not clean as an in-place cut; the clean cuts are already in `apply` (7 noted "source-or-cut, clean", plus the "30-72 hours" cut inside NC-L4a) |

**Apply posts (20):** 3553, 4099, 4101, 4102, 4104, 4105, 4106, 4195, 4337, 4339, 4346, 4349, 4363, 4562, 4617, 4645, 4678, 4679, 4809, 4861.

## Verification

- **Exact match.** A read-only dump of the raw prod fields was taken (`post_content`, `post_excerpt`, `_roden_key_takeaways`, `_roden_faqs`), and the applier's logic was simulated in array order. All 109 `from` strings occur exactly once at the moment they run, against both prod and the export. All 20 posts are published, `_roden_faqs` is a list on each, and none has inline JSON-LD or a backslash in its content.
- **Engine replay.** Every `apply` replacement and every proposed `gillin` / `source-or-cut` replacement was run through `sweep-claims.mjs --fixtures` (SC,GA), plus two positive controls. **Result: 115/115, 0 findings; both controls fired.**
  - A first draft of COL-L6 tripped the `SC 56-5-1260` forbidden-context guard. It now uses the theme's approved step-5 wording, one sentence per statute.
  - Three SCTCA sentences were re-cited per clause, which clears two suppressed authority-quantity warnings.
- **Whole-document sweep.** All 20 posts were swept before and after: errors 0 → 0, and the suppressed warnings went from 7 to 5, with none new.
- **The engine found none of these errors.** Everything here is a false negative, and the proposed rules are in the source remediation files. So "0 after" shows only that nothing regressed, not that the edits are correct. Correctness rests on the authorities named on each edit.

## Before applying

1. **Order.** Run the edits in array order. The builder and applier preserve it. Order matters in these places:
   - 4562 content: MM-L1n rewrites the repose row, and MM-L1o then deletes the minors row beneath it. MM-G1 (Gillin) targets the post-L1n text, so it must run after both.
   - Several fields take two edits: 4562 takeaways; 4861 faq3; 4337 content; 4346 content.
   - Each `from` was checked against the text as it stands after the earlier edits.
2. **Stale review stamps.** 4106, 4337, 4339 and 4346 carry `_roden_last_reviewed` 2026-09-02, which would certify the new copy. Leave the stamps until Gillin (4106 SC half: Gillin; its byline is Eric Roden) has seen it, or clear them.
3. **After apply:**
   - `wp cache flush` and `wp page-cache flush`;
   - regenerate `content/meta.json`;
   - run `bin/check-unslashed-post-writes.php` through `wp eval-file -`;
   - a `--fresh` claims sweep;
   - spot-check FAQPage JSON-LD on 4861, 4104, 4562, 4349, 4617, 4106 and 3553.

## What `apply` fixes (by source finding)

- **4562** (MM-L1, 28 edits) fixes:
  - the caps, now the signed 2026 figures, on every surface;
  - the invented 90-day wait and records authorization, now NOI filed with the affidavit, tolling and pre-suit mediation;
  - "mediation after the lawsuit is filed";
  - the repose cited to (B) and called "absolute", now § 15-3-545 with "generally";
  - the invented minors row, deleted;
  - *Platt v. CSX*, deleted;
  - "§ 15-79-10 et seq.";
  - med-mal wrongful-death accrual, deleted pending WD-G1.
- **4349 / 4363** (MM-L2/L3) fix:
  - the 90-day notice everywhere;
  - the expert qualifications, now in the signed § 15-36-100 wording;
  - "eighth birthday" (deleted) and "under the age of six" (removed);
  - 2026 cap figures;
  - on 4349, the "gross negligence" punitive line, now the § 15-33-135 wording approved on 3518.
- **4195** (MM-L4): the false SC minors sentence is deleted from FAQ[0] and the body.
- **4861** (WD-L1) fixes:
  - SCTCA "notice deadlines", now two years or three (§§ 15-78-110, 15-78-80);
  - the charity cap (§ 33-56-180), added;
  - the punitive-cap exceptions, restated per § 15-32-530;
  - the chapter cite.
- **4099** (WD-L2): distribution "by dependency" is now intestacy shares (§ 15-51-40).
- **4099 / 4101 / 4104 / 4105 / 4106** (WD-L3): the SC measure (§§ 15-51-40, 15-5-90) is added, and South Carolina is removed from Georgia's "full value of the life" sentences. The Georgia wording is untouched (see GA-5).
- **4104** (WD-L4): the SC punitive cap and burden.
- **4101** (WD-L5):
  - NOI + affidavit + mediation;
  - the Hopkins "250,000" figure is cut.
- **4102:** "OSHA investigates all" becomes "many".
- **4106 FAQ[4]** (new on re-read, same class as 4061/4054): notice scoped to Georgia, plus the SC deadline.
- **4617** (NC-L2):
  - § 15-78-80 was cited as the Act and as the deadline;
  - "all injury claims";
  - the population figure and ranking are cut.
- **4337 / 4339 / 4346** (NC-L4):
  - the wrongful-death deadline, cited to § 15-51-20, is now § 15-3-530, with the PR under § 15-51-20;
  - "SS" and "all claims";
  - "30-72 hours" and "40%" are cut;
  - the per-capita ranking is cut.
- **4346** (NC-L5):
  - "properly notified";
  - "Town of Ladson": Ladson is a CDP (Wikipedia);
  - Exit 199: US 17 Alt at Summerville, north-west of Ladson (Wikipedia I-26 exit list).
- **4809** (NC-L6): UM is mandatory and UIM offered (§§ 38-77-150/-160); the SCTCA cap is added to the "no cap" lines.
- **4645:** the unsourced 9% uninsured rate is cut from the body list.
- **4678 / 4679** (COL-L5):
  - Richland 2023 becomes **12,450 collisions / 58 fatal collisions**. The SCDPS Traffic Collision Fact Book 2023, Richland page (p. 164), was downloaded and read: 12,450 total, 58 fatal, 60 killed. The unsourced 12,731/65 is wrong.
  - US-1's 939 / 5 is right per the same page, but "Augusta Road" is US-1 in Lexington County, so the label is dropped.
  - The "Most Dangerous Truck Corridors" heading is retitled.
- **3553** (COL-L6): the report duty is split into § 56-5-1260 and § 56-5-1270 ("$1,000 or more"), in FAQ[4] and in body step 1 (new on re-read).

## Gillin review packet (13)

| id | Page | Published | Question | Proposed authority |
|---|---|---|---|---|
| MM-G1 | 4562 table; 4349 deadlines list; 4195 FAQ[0] + body | (rows deleted by the batch) | Sign the § 15-3-545 amendment: (B) foreign object, 2 yrs from discovery, no 6-yr repose; (D) minors, tolling ≤ 7 yrs and ≤ 1 yr past majority? Then add: "Tolled during minority, but by no more than seven years, and no more than one year after the minor turns 18 (S.C. Code § 15-3-545(D))." | SC 15-3-545 amendment (pending) |
| MM-G2 | 4363 body; 4197 FAQ[0] + "Emergency Standard" | ER standard stated with no SC gross-negligence rule | Sign § 15-32-230? Does it reach the hospital or only the physician? Proposed: "…an emergency-department physician is liable only if grossly negligent (S.C. Code § 15-32-230). The rule does not cover care after the patient is stabilized or discharged." | SC 15-32-230 (pending) |
| MM-G3 | 4349, 4363 | (now "recently practiced or taught") | State § 15-36-100(A)(2)(b)'s "at least three of the last five years immediately preceding the opinion"? | SC 15-36-100 claim amendment |
| MM-G4 | 4199 body + FAQ[2] | "…sufficient information for a reasonable patient to make an informed decision" | Is SC disclosure measured by the reasonable-physician standard? Proposed: "South Carolina courts generally measure the disclosure a doctor owed by what a reasonable physician in the same field would have disclosed." | *Hook v. Rothstein*, 281 S.C. 541 (Ct. App. 1984) (pending) |
| WD-G1 | 4101 (no SC deadline); affects 4562, 4337, 4339, 4346 | — | For a malpractice death, § 15-3-545 or § 15-3-530(6) ("upon the death")? Until he answers, the batch says "generally within three years (§ 15-3-530)" and drops "from the date of death". | SC 15-3-530(6) amendment |
| WD-G2 | 4102 body list + FAQ[0] | "…third parties … can be held fully liable: Property owners … General contractors … Subcontractors" | These are often statutory employers (immune). Sign §§ 42-1-400/-410 and approve the reworded lead-in? | SC 42-1-400, 42-1-410 (pending); SC 42-1-540 |
| WD-G3 | 4816 FAQ[2] + body; 4861 | Funeral and burial as a WD element; "not used to pay … creditors" | Confirm both (case law). | none |
| WD-G4 | 4104 | — | Should the nursing-home WD page say the med-mal cap (§ 15-32-220) and the charity cap (§ 33-56-180) can apply? This is tied to the open nursing-home scope question. | SC 15-32-220, SC 33-56-180 |
| NC-G1 | 4339 body | "§ 56-5-3130 — drivers must yield … in marked crosswalks and at intersections with traffic signals" (backwards) | Sign § 56-5-3130; the corrected sentence is ready. Interim: delete the bullet. | SC 56-5-3130 (pending) |
| NC-G2 | 4346 FAQ[1] + body | "must be filed in the county where the accident occurred or where the defendant resides" | Approve "generally may be filed … where the defendant lives or is based"? | SC 15-7-30 (pending) |
| NC-G3 | 4846 takeaways/FAQ[3]/body; 4812 excerpt/meta/takeaways/FAQ[0]/[2] | "allows stacking of UM/UIM" with no § 38-77-160 vehicle-involved limit | Approve a stacking statement, or cut to UM-mandatory / UIM-offered? | SC 38-77-160 |
| MC-G1 | 4814 FAQ[49]/[50] (ES 4937 FAQ[57]/[58]) | "would run through ordinary comparative fault … not an automatic bar" | Keep uncited helmet-defense law, or cut to the § 56-5-3660 rule? | none |
| MC-G2 | 4073 FAQ[2] + body | "Some states have legalized lane filtering at low speeds" | I believe it is true (UT, MT, AZ, CO). Keep, or cut other-state law? | SC 56-5-3640 |

## Georgia (Eric Roden), 6

- **GA-1:** 1809's Employer's First Report is "within 10 days", and it says the limitations period "begins" when the report is filed.
- **GA-2:** 1809 does not mention co-employee immunity (§ 34-9-11(a)).
- **GA-3:** med-mal deadline cites on 4363 (§ 9-3-73) and 4349 (§ 9-3-33) should be § 9-3-71.
- **GA-4:** 4197's closing Georgia ER sentence (§ 51-1-29.5).
- **GA-5:** the remaining unscoped "full value of the life" sentences on 4099, 4101, 4102, 4104 and 4105. Prefix them "In Georgia," once he confirms.
- **GA-6:** Georgia law on the Columbia post 3553.

## Source-or-cut, not clean (4)

- **MM-L3l:** "the most common malpractice claim" on 4363's excerpt, takeaways and H2. A hedge is offered.
- **NC-L3y:** "one of the deadliest pedestrian corridors in South Carolina" on 4339's FAQ[0], excerpt, takeaways and intro.
- **NC-L1b:** 4645 FAQ[1]. The whole answer is the 9% figure: source it or delete the FAQ.
- **NC-L1c:** 4645's "crime rate of 47 per 1,000 — one of the highest in America" and the takeaways' "research links…". The post's premise rests on them.

## Same class, outside this batch (not linked; found by a class sweep of the export after the batch)

These carry the same errors this batch fixes and should be the next batch:
- **4562 class (90-day NOI, "$350,000 per defendant / $1.05M total", "8th birthday"):**
  - 1646 (table, takeaways, FAQ[2]);
  - 1696 (body, takeaways, FAQ[3], minors row);
  - 1813 (body, takeaways, FAQ[2], FAQ[3]);
  - 1668 (body, takeaways, FAQ[4]);
  - 4350 (body, FAQ[4], FAQ[5]).
- **Hit-and-run "injury is a felony … up to 10 years":** 4075 `/motorcycle-accident-lawyers/hit-and-run-motorcycle-accident/`.
- **SCTCA "notice deadlines can be much shorter":** 4859 (body, FAQ[3]) and 4860 (body, FAQ[4]).
- **"Tort Claims Act (S.C. Code § 15-78-80)" as the Act:** 4635.
- **"does not require adult riders":** 4644.

## Not in this batch (template, not linked-page content)

These are theme items from the 09-26/09-28 plans and need a theme PR:
- the firm-data essay stats;
- the `local_context` WD/MM variants for other offices;
- the Columbia essay's § 15-3-530 line;
- the empty attorneys heading;
- the owner-deferred results grid.
