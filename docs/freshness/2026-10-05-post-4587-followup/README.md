# Post 4587 follow-up — /blog/car-totaled-in-accident-what-to-do/, 2026-10-05

Owner: "push and then do 4587", then "apply". These close the items left open by the group-1 pass
(`docs/freshness/2026-10-05-group1-researched/`): the resale discount, the gap-insurance cost and the III line, plus four
found in the same sweep. Research: `web-findings.json` (research agent; J.D. Power press pages and the NH DOI page refused
fetches and were not bypassed). Pack: `facts-4587.json`.

| Was | Now | Authority |
|---|---|---|
| III: collision payouts "climbed steadily … as vehicle values have risen", stakes "never been higher" | $3,377 (2015) → $5,521 (2023), dipping to $5,489 (2024); stakes "are high" | III Facts + Statistics: Auto insurance (ISO) |
| "a rebuilt title typically reduces resale value by 20% to 40%" | "a salvage or rebuilt title typically lowers a car's value by 20% to 40% (Kelley Blue Book)" | KBB Values FAQ ("industry rule of thumb") |
| gap "$20 to $40 per year"; dealer gap "tends to cost more" | about $20 a year on policies already carrying collision and comprehensive (III); insurers typically charge less than dealers | III, "What is gap insurance?" |
| appraisal: appraisers fail → umpire decides; "costs a few hundred dollars but can recover thousands" | the two appraisers choose an umpire; a decision agreed by any two of three binds; each pays its appraiser, umpire cost split; cost/recovery line dropped | NC DOI description of the standard personal auto policy |
| "Georgia Office of Insurance"; both "investigate bad faith valuation practices" | "Georgia Office of Commissioner of Insurance and Safety Fire"; both "review consumer complaints about how insurers handle claims" | oci.georgia.gov complaints page; doi.sc.gov/consumers |
| "NADA Guides" | "J.D. Power (formerly NADA Guides)" | jdpowervalues.com |
| "the insurer's own engineers concluded" | "the insurer's own appraiser concluded" | total losses are set by appraisers |

6 body edits, growth 1.6%, builder violations 0. Key Takeaways and FAQs unchanged, so `content/meta.json` is unchanged.
Backup `prod-backup-before.json`; applied with `bin/freshness-build-patch.mjs --apply`; post_modified stamped
2026-10-05 23:40:14; both cache layers flushed; `verify.json` matches on every surface.

Live in Chrome (`?nc=`): 200, no redirect; none of the old phrases render, all new phrases present; JSON-LD parses,
FAQPage 6 questions, dateModified 2026-10-05T23:40:14. `bin/check-unslashed-post-writes.php` PASS (static and live).
