# Freshness refresh — post 1676, 2026-09-24

`/blog/medical-malpractice-limits-georgia/` — queue rank 21. Georgia-only post; reviewer Eric Roden (3729),
unchanged.

Facts pack: 46 claims, 22 keep / 23 update / 1 drop. Applied (14 edits: 9 body, key takeaways, 4 FAQ answers;
body +14.2%); `_roden_last_reviewed` = 2026-09-24. DB fields read back and matched; live page verified.

Corrections: the post's "discovery rule" does not exist in Georgia medical malpractice — the table row, the
H2 section, FAQ 2 and the "knew or should have known" sentence rebuilt around the new-injury rule (Amu v.
Barnes, 283 Ga. 549 (2008)) and § 9-3-96 fraud tolling (limitation only, never the repose); the H2 "The
Discovery Rule: When You Did Not Know Right Away" → "When the Clock Starts Later: Misdiagnosis and Fraud"
(id kept, TOC text updated). Limitation runs from the injury, almost always the negligent act (§ 9-3-71(a));
the retained-sponge example (backwards under § 9-3-72) replaced with a misread scan; foreign objects limited
per the statute (fixation devices and prosthetics excluded). Struck cap figures corrected to what § 51-13-1
said ($350,000 providers / $350,000 per facility / $1.05M total; Nestlehutt, 286 Ga. 731, decided March 22,
2010; still printed, void). Minors' tenth-birthday repose (§ 9-3-73); affidavit contents per § 9-11-9.1(a)
with the 30-day cure in (e), in body and FAQ 3; ER gross-negligence / clear-and-convincing standard
(§ 51-1-29.5) added; punitive-cap exception for product liability (body and FAQ 5); wrongful-death claimants
as spouse then children (§ 51-4-2), full value of the life (§ 51-4-1); one SB 68 sentence (§§ 9-10-184,
51-12-1.1); "some of the more complex rules in the Southeast" dropped; dead Cornell link fixed.

Flagged, not changed: FAQ 6 still lists medical device manufacturers among malpractice defendants (pack:
keep; those are product-liability claims).

Tooling: this post exposed a bug in `bin/freshness-build-patch.mjs` — two change runs separated by untouched
blocks were merged into one edit whose replacement re-included the untouched blocks. The simulation guard
stopped the dry run; the pairing loop now breaks on unchanged blocks. The previous batches were unaffected
(their simulations passed).
