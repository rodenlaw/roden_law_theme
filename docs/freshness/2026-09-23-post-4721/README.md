# Freshness refresh — post 4721, 2026-09-23

`/blog/motorcycle-accident-i-95-glynn-county-brunswick-darien/` — queue rank 2. Georgia-only post; reviewer Eric Roden (3729).

Facts pack: 40 claims, 29 keep / 7 update / 4 drop. Applied through `bin/freshness-build-patch.mjs --apply`
(14 edits: 11 body, 3 FAQ answers; body +1.4%), then `_roden_last_reviewed` = 2026-09-23. Both caches flushed;
DB fields read back and matched the refreshed files exactly; live page verified.

Corrections: NHTSA per-mile ratios 24× → almost 28× and 4× → almost 5× (DOT HS 813 732, 2023 data); GOHS share
2% → 0.7% of registered vehicles and >10% → about 12% of fatalities (221 of 1,797 in 2022; 196 in 2023); the
stabilize-then-transfer trauma-routing claim replaced with the two verifiable facts (Memorial is the Level I
center per the Georgia DPH list; SGHS Brunswick Campus holds no trauma designation); author bio "Georgia and
South Carolina" → "Georgia"; UM row restated to the § 33-7-11 floor and default; the hit-and-run FAQ now carries
the § 33-7-11(b)(2) physical-contact / eyewitness condition. Dropped as unverifiable: the "high uninsured-driver
rate" takeaway, the "common enough" hit-and-run FAQ sentence, the "$1K–$10K" MedPay figure, "two weeks before
evidence walks away". One remaining sentence of the same kind hedged ("is usually" → "may be").

Builder changes this run: the block splitter now treats unwrapped top-level text as blocks (the intro paragraph
had no `<p>`; the first build would have duplicated it), and a byte-exact simulation guard requires the
sequential patch to reproduce `body.html`.
