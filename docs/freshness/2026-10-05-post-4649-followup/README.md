# Post 4649 follow-up — /resources/i-16-truck-accidents-savannah/, 2026-10-05

Owner: "push this then go to 4649", then "apply" (no retitle). These are the four items left open by the group-1 pass
(`docs/freshness/2026-10-05-group1-researched/`), plus every other unverified claim found on the page in the same sweep.
Research: `web-findings.json` (research agent; gaports.com, Justia, FindLaw and savannahnow.com refused fetches and were
not bypassed, so GPA figures are cited through WTOC/Container News reports of GPA releases) and `fars-truck-findings.json`
(NHTSA Large Trucks 2024 tables plus a local FARS tally). Combined pack: `facts-4649.json`.

| Was | Now | Authority |
|---|---|---|
| 5.9M TEUs "in 2023" (body, FAQ 2) | nearly 5.7M in 2025, second-busiest after 2022's ~5.9M record | GPA via WTOC 2026-01-27 |
| "$1.9 billion expansion", truck lanes 53→100 by 2030 | removed (stale figure; lane count only in search snippets) | — |
| "fastest-growing container port on the U.S. East Coast" | "fourth-busiest container port in the United States" | KBC Advisors 2025 (facts-4538) |
| "every container leaving by road travels I-16 westbound" | most leave by truck, rest by rail; trucks reach I-16 at Dean Forest Rd (exit 160) or via Jimmy DeLoach Pkwy (exit 152), which also feeds I-95 | GPA, WTOC |
| GA truck deaths "142 (2013) → 257 (2023), +81%" (body, Key Takeaways) | 197 died in GA large-truck crashes in 2024, 173 outside the truck | NHTSA DOT HS 813 816 Table 7 |
| construction "MP 156–164", interchange under reconstruction, 45 mph | I-16/I-95 interchange complete (P.I. 0012758); widening I-95→I-516, exits 157–164 (P.I. 0012757) under construction; 45 mph dropped | GDOT GeoPI 2026-10-05 |
| Jan 2026 crash "several semitrailers", "3 critical", Twiggs County | tractor-trailer, two box trucks, pickup; 1 dead, 2 seriously injured; Bleckley County near the Twiggs line | GSP via WGXA |
| H3 "Twiggs County (Milepost 40-60)", fatigue "peak", "minimal lighting" | "Rural Middle Georgia (Twiggs to Laurens Counties)"; only I-16 rest areas are MP 44/46 in Laurens | GDOT rest-area list |
| Bibb "6,103 crashes and 154 suspected serious injuries" | 6,103 crashes countywide, 2024; 154 in no GOHS sheet | GOHS 2024 |
| H2 "Most Dangerous Spots"; Chatham Pkwy "tied for the most dangerous interchange" | "High-Risk Spots on I-16"; ranking removed (none exists) | facts-4538 |
| "outside the metro area, I-16 narrows to two lanes" | two lanes each way for most of its length incl. Pooler; three only I-95→I-516 | GDOT/WTOC |
| "FMCSA violations constitute negligence per se" | GA adopted the FMCSRs; a violation can support negligence per se (§ 51-1-6) if it caused the crash | Parris v. Gooch (Ga. Ct. App. 2026); Parker v. R & L Carriers (2002) |
| "secondary crashes are a leading cause of death on I-16" | "a serious risk on I-16" | no source for the original |
| FAQ 4 names GDOT as a defendant | adds 12-month ante litem notice to the State (O.C.G.A. § 50-21-26) | facts-4715 |

14 edits (content 10, Key Takeaways 1, FAQs 3), body growth 9.6%, builder violations 0. Backup `prod-backup-before.json`;
applied with `bin/freshness-build-patch.mjs --apply`; post_modified stamped 2026-10-05 22:01:29; both cache layers flushed;
`verify.json` matches the run files on every surface.

Live in Chrome (`?nc=`): 200, no redirect, none of the removed claims in the rendered text, new text present (the § 50-21-26
line sits in a collapsed FAQ, confirmed in the DOM and JSON-LD), JSON-LD parses, FAQPage 5 questions, dateModified
2026-10-05T22:01:29. `bin/check-unslashed-post-writes.php` PASS (static and live). `content/meta.json` regenerated: only
this page changed.

**Retitled 2026-10-06** (owner: "retitle 4649"). "I-16 Truck Accidents: Savannah's Deadliest Freight Corridor" →
"I-16 Truck Accidents in Savannah: Port Freight, Construction Zones and Your Rights". The old title was contradicted by FARS
(Chatham 2020–24: I-95 26 deaths, I-16 14). Slug unchanged. Written with `retitle.php` (wp_update_post( wp_slash() ));
post_modified became 2026-10-06 12:31:27. The featured image (attachment 6405) carried the old title as its alt text, which
also rendered as og:image:alt and twitter:image:alt; `featured-alt.php` set it to the new title. The attachment's own
post_title still holds the old wording (not rendered on the page). Live in Chrome: <title>, H1, og:title, BlogPosting
headline and image alts all carry the new title; "Deadliest" no longer appears anywhere in the page HTML.

Not verified directly: the text of O.C.G.A. § 40-1-8 (Justia/FindLaw refused), so the page states the FMCSR adoption
without that cite.
