# Remediation 2026-11-10: SC cyclist-rights clause cited to § 56-5-3435

Narrow check, no sweep run. Source: `data/content-cache/wp-export.json`, exported 2026-11-10T20:34:12Z (646 docs).
Pack: `internal-ai-scripts/law/SC.json`, **signed** (Graeham C. Gillin, 2026-09-26).
Out of scope, not touched: the § 40-6-294 bullet and the helmet "comparative fault" FAQ on 4087, both held for attorney review.

## Primary text (Justia, 2025 S.C. Code, checked 2026-11-10)

- **§ 56-5-3435**, "Driver to maintain safe operating distance between motor vehicle and bicycle": "A driver of a motor vehicle must at all times maintain a safe operating distance between the motor vehicle and a bicycle." It says nothing about cyclists' rights.
  https://law.justia.com/codes/south-carolina/title-56/chapter-5/section-56-5-3435/
- **§ 56-5-3420**, "Rights and duties of bicyclists generally": "A person riding a bicycle upon a roadway must be granted all of the rights and is subject to all of the duties applicable to the driver of a vehicle by this chapter, except as to special provisions in this article and except as to those provisions of this chapter which by their nature can have no application."
  https://law.justia.com/codes/south-carolina/title-56/chapter-5/section-56-5-3420/

## Answers

**(a) Is the rights clause mis-cited under § 56-5-3435? Yes.** The rights-and-duties rule is § 56-5-3420. The pack has **no** authority for § 56-5-3420. It is not in `authorities` or `pendingAuthorities`. The only related pack id is `SC 56-5-3435`, and its claim is the safe-operating-distance rule alone. So the finding rests on `SC 56-5-3435`, which does not cover rights. It does not rest on a pack authority for the correct cite, because none exists. A deletion needs no authority. Any wording that adds a § 56-5-3420 claim does: under the signed pack an unsigned pending authority cannot back a new claim, so § 56-5-3420 has to go to `pendingAuthorities` and get Gillin's sign-off before anything cites it.

**(b) Is the passing half correct as written? Yes, in both places.**
- Bullet: "requires drivers to pass bicycles at a safe distance". This is correct. It is narrower than the statute, which says "at all times", not only when passing, but it matches the pack claim and the wording used elsewhere on the site. It names no number. No change needed.
- whyHire: "similarly requires safe passing distance". The statement itself is correct. But it follows straight after Georgia's 3-foot rule, so "similarly" can be read as South Carolina having a comparable fixed figure. The `SC 56-5-3435` pack note exists because twelve pages invented exactly that. Deleting the paragraph removes that reading as well.

## Findings

### F1: 4087 /practice-areas/bicycle-accident-lawyers/, body (SC bullet)
- Published: "South Carolina: S.C. Code § 56-5-3435 requires drivers to pass bicycles at a safe distance and grants cyclists all rights applicable to vehicle operators"
- Corrected (owner's deletion): "South Carolina: S.C. Code § 56-5-3435 requires drivers to pass bicycles at a safe distance"
- Authority: `SC 56-5-3435` (supports the sentence that remains).
- Caught by: manual check. No pack rule covers a § 56-5-3435 rights claim; `SC 56-5-3435`'s error rule fires only on three-foot assertions.

### F2: 4087, meta `_roden_why_hire` (whyHire), paragraph 2
- Published: "South Carolina law (S.C. Code § 56-5-3435) similarly requires safe passing distance and grants cyclists full road rights."
- Corrected (owner's deletion): delete paragraph 2 entirely.
- Authority: none needed for a deletion. The paragraph's Georgia sentences are correct; see the note below.
- Caught by: manual check (same gap as F1).

### F3: 4178 /bicycle-accident-lawyers/bicycle-vs-truck-accident/, body (SC bullet). Same mis-cite, NOT in the owner's fix
- Published: "South Carolina: S.C. Code § 56-5-3435 grants cyclists equal roadway rights and requires motorists, including truck drivers, to pass at a safe distance."
- Corrected (deletion in the same style): "South Carolina: S.C. Code § 56-5-3435 requires motorists, including truck drivers, to pass cyclists at a safe distance."
- Authority: `SC 56-5-3435`.
- Caught by: manual grep of the export.

## Other docs grepped (56-5-34xx near "rights"): clean

These docs state the rights rule under § 56-5-3420, which is correct against primary text but is not yet a pack authority. Use § 56-5-3435 only for passing.
- 1698 body ("Cyclists as vehicles (S.C. Code § 56-5-3420)")
- 4172 body; 4172 faqs[3].answer
- 4173 body; 4173 faqs[2].answer
- 4639 body; 4639 keyTakeaways
- 4087 pillarNegligenceIntro ("same rights and duties ... under S.C. Code § 56-5-3410 to -3450"). The range includes § 56-5-3420, so this is correct.

These docs use § 56-5-3435 for passing only, which is correct: 1698 faqs[3]; 4087 faqs[1], keyTakeaways; 4106 body; 4224 body; 4639 body/keyTakeaways; 4898 faqs[5] (ES).

## Is the owner's deletion correct and sufficient?

**Correct: yes.** Both cuts remove only the false citation. What remains is true and backed by `SC 56-5-3435`. No surface on 4087 contradicts itself after the cut: the FAQ, key takeaways and pillar intro already state the passing rule correctly, and the pillar intro keeps the rights rule under the correct range. The body lead-in "Both states grant bicyclists the same rights and responsibilities as vehicle operators" stays true (§ 56-5-3420), just without an SC cite in the list.

**Sufficient for 4087: yes. Sufficient overall: no.** 4178 carries the same mis-cite (F3), and the owner's fix does not cover it. Apply the same deletion there.

**Should anything replace it?** It doesn't have to. Deletion is the right call under the signed pack, because a replacement citing § 56-5-3420 is a new claim with no signed authority. Note on F2: deleting the whole paragraph also removes two correct Georgia sentences (O.C.G.A. § 40-6-291 rights; 3-foot passing). Losing them leaves nothing false, and the body and key takeaways still cover Georgia passing. If the owner would rather keep the Georgia half, the smaller change is to cut only the last sentence of paragraph 2. Either is acceptable. (`GA 40-6-291` is also not a pack authority, so the Georgia rights sentence is unbacked either way.)

**Optional follow-up (pack PR, not done here):** add `SC 56-5-3420` to `SC.json` `pendingAuthorities` with the Justia URL above and `verifiedBy: null`. Four published docs already rely on it, and once Gillin signs, the rights clause could be restored correctly cited. Consider also an error rule: `56-5-3435` within one sentence of "rights".

## Counts by rule

| Rule | Findings |
|---|---|
| (none, manual check; pack gap) | 3 (F1, F2, F3) |

## False positives

None. No sweep was run.
