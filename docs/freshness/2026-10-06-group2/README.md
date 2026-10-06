# Freshness follow-ups, group 2 — 11 pages, 2026-10-06

Owner: "do group 2" (all of group 2 except the three firm-fact confirmations), then "apply and retitle".

| Post | Change |
|---|---|
| 4537 /blog/myrtle-beach-dangerous-roads-intersections/ | **Retitled** "The Most Dangerous Roads and Intersections in Myrtle Beach, South Carolina" → "Myrtle Beach's Highest-Crash Roads and Intersections: What the State Data Shows". FAQ 1/2 questions "What is the most dangerous road/intersection…" → "Which road has the most fatal crashes in the Myrtle Beach area?" / "Which Myrtle Beach-area intersection has the most crashes?" (answers already stated those measures). |
| 5398 /resources/myrtle-beach-fatal-crashes/ | "US-17 (45) and US-501 (31)" carrying "most of the crashes" → US-17 67, US-501 36, about 31% of Horry's 328 fatal crashes. Root cause: `bin/myrtle-beach-report-build.py` summed only the analysis's top-12 road labels; officers code US-17 a dozen ways. `bin/myrtle-beach-report-analysis.py` now emits `route_totals` over every row; the build uses it. Rerun against the same FARS files: every other statistic and the published CSV identical; `research/` outputs regenerated. Now agrees with 4537 (facts-4537). |
| 4344 /blog/folly-road-car-accidents-james-island-charleston/ | **Retitled** "…About James Island's Most Dangerous Corridor" → "…About James Island's Main Corridor"; H2 and TOC entry likewise (id kept). "Most crash-prone" H2 kept — supported by SCDOT's 2,103-crash audit count (facts-4344). |
| 3553 /blog/columbia-dangerous-intersections-roads/ | FAQ 1 question → "Which intersection in Columbia, SC has the most crashes?"; two body "most dangerous intersections/locations" → "highest-crash". |
| 4539 /blog/darien-brunswick-dangerous-roads-i95-us17/ | FAQ 1 question → "What are the highest-risk roads near Darien, Georgia?"; unsourced "among the most severe crashes in the region" → "can be especially severe". |
| 1761 /blog/workers-comp-for-carpal-tunnel-syndrome/ | "aggravation of pre-existing conditions" unlinked (it pointed at the personal-injury page); that link moved to "personal injury lawsuits". "medical experts" → medical-malpractice page left as is: repointing it drops the post's only link to that page, which the builder's link guard blocks. Owner decision pending. |
| 1864 /blog/dangerous-tools-garage/ | "Personal Injury Attorneys in Savannah" → "…in Georgia and South Carolina"; "Savannah personal injury attorneys" → "personal injury attorneys" (the post covers both states). |
| 1720 /blog/options-for-denied-injury-claims/ | Step 4 heading and TOC "File a Bad Faith Insurance Complaint" → "File a Complaint With Your State Insurance Regulator" (it describes a regulatory complaint; id kept). |
| 1769 /blog/taxes-on-car-crash-settlement-in-georgia/ | Advice-tone H2s (and TOC) "How Settlement Structuring Can Reduce Your Tax Burden" → "How Settlement Wording Affects Taxes"; "How an Attorney Can Help Maximize Your After-Tax Recovery" → "How an Attorney Can Help With Settlement Taxes" (ids kept). |
| 4337 /blog/ashley-phosphate-road-i-26-dangerous-intersection-charleston/ | Restored 4 of the 11 internal links lost in the 2026-10-02 merge, where text fits: pedestrian-accident, brain-injury, wrongful-death (crash-type table) and /car-accident-lawyers/charleston-sc/ ("Contact a lawyer" step). The other seven (truck, burn, spinal-cord, product-liability, Charleston location pages) have no matching text. |
| 1711 /blog/liens-and-your-personal-injury-claims/ | Restored the sentences trimmed 2026-09-24: Wos v. E.M.A. (2013) and Gallardo v. Marstiller (2022) after Ahlborn; Medicare Advantage plans assert the same secondary-payer rights (42 C.F.R. § 422.108). Wording from facts-1711 (verified 2026-09-24). Body +2.1%. |

Closed without an edit: surgery (1656) and insurer-tactics (1719) +16% growth accepted (under the 20% stop); the Hog Island
crash example stays out (owner's 2026-09-23 decision — operator charged, not convicted); the I-16 Garden City post (4715)
is retired, so its two South Carolina-topic links are not live.

Mechanics: per-post prod backup (`prod-backup-before.json`, confirmed identical to the dumped state), then
`bin/freshness-build-patch.mjs --apply` (24 edits, 0 violations); titles via `retitle.php` (wp_update_post( wp_slash() ));
post_modified stamped 2026-10-06 13:13:52; both cache layers flushed. DB readback (`readback.json`, per-post
`verify-db.json`) matches every run file. Three bodies (5398, 1864, 1769) are stored with CRLF line endings — edits were
made with newline-preserving I/O after a first draft normalised them and produced spurious whole-body diffs.

Live in Chrome (`?nc=`): all 11 return 200, no redirect, every new phrase present and every removed phrase absent,
JSON-LD parses, FAQ counts unchanged, dateModified 2026-10-06. `bin/check-unslashed-post-writes.php` PASS (static and
live). `content/meta.json` regenerated (also picks up the 4649 retitle).

Still open for the firm: "We advance all case expenses" (contingency-fee post), the Murrells Inlet office's county
(geocodes to Georgetown), "handled dozens of cases" on 4337.
