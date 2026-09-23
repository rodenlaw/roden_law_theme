# Freshness refresh — post 1697, 2026-09-23

`/blog/what-happens-if-i-resign-while-on-workers-compensation/` — queue rank 3. Two-state workers' compensation
post; reviewer Graeham C. Gillin (3732) per the owner's rule (previously attributed to Eric Roden, who is GA-only).

Facts pack: 35 claims, 15 keep / 17 update / 3 drop. Applied through `bin/freshness-build-patch.mjs --apply`
(12 edits: 7 body, key takeaways, 4 FAQ answers; body +16%, over the ~15% mandate and under the 20% stop),
then `_roden_last_reviewed` = 2026-09-23 and `_roden_author_attorney` = 3732. Both caches flushed; DB fields
read back and matched the refreshed files exactly; live page verified.

Corrections: the Georgia retaliation claim was invented law — O.C.G.A. § 34-9-17 is "grounds for denial of
compensation", and Georgia has no retaliatory-discharge remedy for a workers' comp claim (*Evans v. Bibb Co.*,
178 Ga. App. 139 (1986)); the section now states the states differ and keeps S.C. Code § 41-1-80 with its actual
terms (discharge or demotion, lost wages and reinstatement, employee's burden, one-year deadline). "S.C. Code
§ 42-9-60" (intoxication / willful injury) → § 42-9-190 (refusal of Commission-approved suitable employment) in
five places including two FAQ answers. Georgia burden of proof corrected for the post's own scenario (*Maloney v.
Gordon County Farms*; *Padgett v. Waffle House* exception). "Constructive discharge preserves benefits" removed
from body, takeaways and FAQ. Georgia 400-week medical cap (§ 34-9-200, post-2013 non-catastrophic) added.
"Voluntary limitation of income" labelled as an insurer's phrase, not § 34-9-240 language.

Left as-is: the "Constructive Discharge" H2 and its bullet list (skeleton preserved; the corrective paragraph
beneath qualifies them). Candidate rename for a later pass: "Why You Left Matters".
