# Remediation plan: live pages after the 2026-09-30 attorney approvals

- **Status:** built and dry-run only. Nothing has been applied.
- **Rests on:** `data/facts/attorney-approvals-2026-09-30.md`.
  - Georgia items: approved 2026-09-30 (Tyler Love).
  - South Carolina items: approved 2026-09-30 (Gillin).
  - The emails themselves are not quoted here. Page text uses the approved page wording.
- **Batch:** `approvals-batch-2026-09-30.json`, 94 edits on 34 published posts, all class `apply`.
- **Meta list:** `approvals-meta-2026-09-30.json`, 4 items. These need a separate `bin/` patcher.
- **Replay:** `approvals-replay-2026-09-30.json`.

## Packs

Both packs are **signed** (GA 21 rules, SC 16 rules). No state is unsigned. Some page wording goes beyond a signed claim; it rests on today's approvals and needs toolkit pack PRs (#70/#71 pattern):

- **GA 40-8-76.1:** the signed claim lacks the SB 69 § 5(c)(2) "commenced on or after 2025-04-21" limit. The pack PR is already pending.
- **GA 40-8-76:** the signed claim lacks the (b)(1)(D) physician's-statement exception.
- **SC 38-77-160:** the signed claim needs Gillin's stacking substance (Class I, vehicle involved, not-involved rule).
- **SC 15-3-545:** the signed claim needs the malpractice-death rule (no revival of a barred claim).
- **SC 15-5-100 (funeral / survival overlap):** **not in the SC pack.** Add it with `verifiedBy: null`.
- **SC 15-32-210 (nursing home = health care institution):** **not in the SC pack.** Add it the same way.
- **SC 15-51-20 / 15-51-40:** both are signed. The pack needs the "generally not available to general creditors" claim.

## Dry run

```
python3 bin/build-linked-pages-batch.py data/facts/approvals-batch-2026-09-30.json > <scratch>/appr-run.php   # 94 apply edits embedded
ssh … "wp --path=… eval-file -" < <scratch>/appr-run.php                                                       # no "apply" argument
Would fix: 94 edits across 34 posts
```

There was no ABORT, and every `from` string matched exactly once, in order, on the live DB (read 2026-09-30 15:00 UTC). The prod theme md5s matched the repo before the run.

## Edits by class

| Class | Rule | Edits | Posts |
|---|---|---:|---|
| A | GA seat-belt rule without the commenced-on/after limit (§ 40-8-76.1(d), SB 68/69) | 14 | 6318 (body, FAQ[3]); 1759 (body ×2, FAQ[2]); 2647 (body, FAQ[2]); 3493; 3433 (also re-cites § 40-8-76 → .1(d)); 3612 KT; 5352 (body, KT, FAQ[2]); 1874 body |
| B | 1874 physician's-statement exception | 6 | 1874: summary line, rear-seat paragraph, "two" → "three paths" plus a Medical bullet, KT, FAQ[1] |
| C | SC stacking without the § 38-77-160 limits (NC-G3) | 37 | 4812 (excerpt, body ×5, KT, FAQ[0], FAQ[2]); 4931 ES (excerpt, body ×5, KT, FAQ[0], FAQ[2]); 4814 FAQ[27]; 4937 FAQ[9], FAQ[40]; 4846 (body, KT, FAQ[3]); 4923 ES (body, KT, FAQ[3]); 4819 (body, KT, FAQ[2]); 4925 ES (body, FAQ[2]); 1715 (SC table cell, SC half of the stacking paragraph); 1649 SC cell; 1724 (body, SC cell) |
| D | SC malpractice death "from the date of death" (WD-G1) | 4 | 1646 body; 4101 body (adds the § 15-3-545 paragraph); 4562 body (restores the rule MM-L1x cut); 4350 FAQ[4] |
| E | SC funeral / creditors wording (WD-G3) | 13 | 4816 (body ×2, KT, FAQ[2]); 4928 ES (body ×2, KT, FAQ[2]); 4861 body; 4814 FAQ[73], FAQ[75]; 4937 FAQ[76], FAQ[78] |
| F | Nursing-home caps (WD-G4) | 1 | 4104 Damages section: the approved paragraph, verbatim |
| G | SC helmet comparative-fault lines → statute only (MC-G1 / B3-G4) | 19 | 4814 FAQ[49], [50]; 4937 FAQ[57], [58]; 4644 (FAQ[3], helmet list, KT); 4815 (body, FAQ[1], KT); 4927 ES (body, FAQ[1], KT); 1664 (body, FAQ[2] SC half); 1667 (two bullets); 4858 FAQ[4]; 4877 ES FAQ[1] (scoped to Georgia, as EN 3607 already is) |
| **Total** | | **94** | **34 posts** |

Notes on the edits:

- **4812 / 4931 stacking example.** The "$100,000 on each of two household vehicles" example now requires that the insured be hurt in one of the vehicles. It is limited by the § 38-77-160 vehicle-involved limit and states the not-involved rule. It names no stacked total; see the open items below.
- **Georgia halves are untouched.**
  - 1715 keeps "In Georgia, insurers must offer the option".
  - 1646 keeps "In Georgia, the limitation period runs from the date of death".
  - 1664 FAQ[2] keeps the Georgia comparative-fault clause.
- **Ordinary SC wrongful death** "3 years from the date of death" (§ 15-3-530(6)) was left everywhere (Gillin 2(a)).

## Meta list (`approvals-meta-2026-09-30.json`, 4)

| id | Post | Key | Change |
|---|---|---|---|
| M1 | 4812 | `_roden_meta_description` | Stacking short form (mirrors C1) |
| M2 | 4931 | `_roden_meta_description` | Stacking short form (ES) |
| M3 | 4101 | `_roden_sol_sc` | "S.C. Code § 15-3-530" → "Medical malpractice deadlines apply (S.C. Code § 15-3-545)". It renders verbatim in the sidebar Filing Deadlines box. |
| M4 | 3619 | `_roden_pillar_compensation_intro` | The `{{SC}}` sentence is replaced with the approved nursing-home paragraph. This also removes the unindexed $350k / $1.05M figures and "ordinary-negligence and intentional-tort theories escape the cap". |

## Template-rendered occurrences (theme; not edited)

`wordpress/wp-content/themes/roden-law/inc/firm-data.php`, the SC office `local_context` essays: "allows stacking" / "Stacking of UM/UIM coverage is permitted" with no § 38-77-160 limit.

| Line | Office |
|---|---|
| :375 | myrtle-beach |
| :383 | myrtle-beach, ES ("permite la acumulación") |
| :495 | moncks-corner |
| :518 | mount-pleasant |
| :590 | north-myrtle-beach |
| :613 | pawleys-island |

Lines :131 and :139 are Georgia § 33-7-11 "added-on" stacking; they were left alone as instructed.

Other theme items:

- **`inc/template-tags.php:1950–1953`.** The WD step-5 SC branch deliberately dropped "from the date of death" pending WD-G1. It may now be restored for ordinary WD (optional).
- **`languages/es_ES.po:3667`.** A stale msgid "stacking UM/UIM coverage" (template-pillar-sc-statewide.php no longer uses it). No action is needed.
- **Line 375 also carries "a 51% modified-comparative-fault bar".** That is the separate SC-threshold class.

## Drafts carrying the same classes (not in the batch; fix before publish)

- **A (2 drafts):** 5235 and 5238 (ES). "Seat-belt non-use cannot be used against you (O.C.G.A. § 40-8-76.1)" is now wrong for suits commenced on or after 2025-04-21.
- **C (38 drafts):** 3626, 3630, 3631, 3640, 3641, 3709–3711, 4541, 4543, 4557, 4704, 4707, 4709, 4711, 4717, 4723, 4725, 4729, 4731, 4733, 4735, 4738, 4766, 4772, 4776, 4785, 4791, 4902, 4918, 4962, 4978, 5163, 5184–5187, 5199.
- **G (17 drafts):** 4071, 4234–4236, 4558, 4740, 4772, 4966, 4968, 5007, 5010, 5041, 5043, 5190–5193.
- **D:** none.

## Left out (ambiguous or owner decision)

1. **6313 `/resources/south-carolina-helmet-laws/` and 6316 `/resources/south-carolina-moped-laws/`.** Both carry the helmet comparative-fault class:
   - 6313: the "How insurers argue about a missing helmet" section and FAQ[1]'s last sentence.
   - 6316: "the insurer's comparative-fault argument to prove — never an automatic bar".
   - Cutting them to the statute means rewriting a whole section of 6313, including a quote attributed to Gillin. That is an editorial rewrite, not a sentence swap; the owner or Gillin should approve the shape.
2. **Bicycle, e-bike and scooter helmet lines** (4087, 4088, 4578, 4639, 4898, 4899, 4364: "may be raised as comparative fault"). Gillin's answer was about motorcycle helmets, so it was not extended to bicycles.
3. **3639 "Insurers sometimes raise it anyway" and 4858 body "Insurers often try to blame the rider … not wearing a helmet".** These are practice observations, not statements of law, so they were left.
4. **Stacking arithmetic.** The approved wording does not settle whether the vehicle-involved limit caps each stacked amount or the total. 1757 and 1724 already use the per-stack reading ($100k × 3 → $300k). The new 4812/4931 example names no total. Ask Gillin if the site should ever state a stacked total.
5. **4350 FAQ[4] and the other ordinary-WD "from the date of death" lines** stay as published (Gillin 2(a)). Restoring "from the date of death" on 4337, 4339 and 4346, where NC-L4 cut it, is optional and not done here.
6. **Georgia items on the touched pages:** 4101 `_roden_sol_ga` / body cite § 9-3-33 for a malpractice death (§ 9-3-71 governs). This needs a Georgia reviewer.
7. **Stale review stamps on touched posts:**
   - 1874: 2026-08-31
   - 4877: 2026-08-03
   - 4937: 2026-08-03
   - 5352: 2026-09-19
   - 1649: 2026-09-24
   - 1724: 2026-09-24
   - 2647: 2026-09-23
   - 3493: 2026-09-25
   - 6318: 2026-09-29

   Decide whether to bump them to 2026-09-30 with the apply.

## Survivors seen, other classes (next batch)

- **"less than 51%" SC threshold:**
  - 4815 KT
  - 4927 KT
  - 4846 KT
  - 4644 KT (kept in G7)
  - 4858
  - 6313
  - 6316
- **SC "full value of the decedent's life":** 4478.

## Replay (`sweep-claims.mjs --fixtures`)

- **`approvals-replay-2026-09-30.json`: 104/104.** It has 98 corrected paragraphs/surfaces (94 batch + 4 meta), all expecting nothing. It also has 6 positive controls, which fired:
  - `seat-belt-percentage-cap` (×2)
  - `sc-seatbelt-limited-not-inadmissible`
  - `sc-medmal-cap-denied`
  - `sc-punitive-floor-unindexed`
  - `wrongful-death-deadline-cited-to-definitions`
- **Standing fixture sets are all at 100%:**
  - `gal-legal-claims` 22/22
  - `roden-comparison-table-2026-09-26` 22/22
  - `roden-tier1-2026-08-26` 36/36
- **The engine catches none of the 94 original strings.** The 94 published `from` strings, replayed as gaps, return 0 findings. None of these classes has a rule.

### False positives

None; the engine raised nothing on the corrected text.

### Pack-PR rule candidates

- `ga-seatbelt-no-commenced-limit` (Georgia § 40-8-76.1 stated without "commenced on or after")
- `sc-stacking-unqualified`
- `sc-medmal-death-from-date-of-death`
- `sc-helmet-comparative-fault`
- `ga-carseat-exceptions-exhaustive`
- `seat-belt-percentage-cap` does not fire on "no more than 5 percent" (an `assert` widening).
