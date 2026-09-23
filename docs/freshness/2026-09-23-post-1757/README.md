# Freshness refresh — post 1757, 2026-09-23

`/blog/using-uninsured-underinsured-motorist-coverage-in-georgia/` — queue rank 5. Despite the slug, a two-state
post; reviewer changed from Eric Roden (GA-only) to Graeham C. Gillin (3732) per the owner's rule.

Facts pack: 43 claims, 19 keep / 21 update / 3 drop. Applied through `bin/freshness-build-patch.mjs --apply`
(19 edits: 14 body, key takeaways, 3 FAQ answers, 1 FAQ question; body +10.7%), then `_roden_last_reviewed` =
2026-09-23 and `_roden_author_attorney` = 3732. Caches flushed; DB fields read back and matched the refreshed
files; live page verified.

Corrections: Georgia stacking was inverted (separate policies stack, vehicles on one policy generally do not;
Crafter; anti-stacking clauses across policies unenforceable, Hancock); consent-to-settle advice was the opposite
of both statutes (O.C.G.A. § 33-24-41.1(c) and S.C. Code § 38-77-160 forbid a consent requirement; Georgia's
protection is the limited release) — rewritten in Step 3, the disputes list, the attorney section and FAQ 5;
"mandatory arbitration" removed (O.C.G.A. § 33-7-11(g) bars arbitration clauses in UM endorsements); South
Carolina UIM is excess coverage, not an "offset method" (Broome v. Watts; $75,000 example → up to $125,000); SC
UM cannot be rejected; SC stacking is a Class I insured rule capped at the vehicle involved (Carter v. Standard
Fire); hit-and-run: physical contact OR corroboration in both states (GA eyewitness § 33-7-11(b)(2); SC witness
affidavit or recording § 38-77-170 as amended 2024); "1 in 8" → IRC 2023 figures (15.4% national, GA 19.0%, SC
10.3%); "anti-stacking waivers" do not exist in either state; one FAQ question retitled to match its corrected
answer; two H3s retitled ("Negotiate or File Suit", "Challenging Anti-Stacking Provisions").

Left hedged for the owner: "after exhausting the at-fault driver's limits" (table cell and Step 3) — South
Carolina's UIM trigger is damages exceeding the limits, not payment.
