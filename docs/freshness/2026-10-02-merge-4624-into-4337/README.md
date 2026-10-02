# Merge — post 4624 into post 4337, 2026-10-02

Owner: "merge this and do the 301", then "Keep 4337's URL" (offered three directions; this was the recommended one).

| | 4337 `/blog/ashley-phosphate-road-i-26-dangerous-intersection-charleston/` | 4624 `/blog/ashley-phosphate-i-26-south-carolinas-deadliest-intersection/` |
|---|---|---|
| Clicks / impressions, 2025-06-01 → 2026-09-30 | 28 / 4,339 (pos 8.9) | 20 / 1,610 (pos 7.6) |
| Clicks / impressions, 2026-07-01 → 2026-09-30 | 8 / 1,435 | 5 / 559 |
| Queries only this page ranked for | 93 | 16 (4 shared) |

The CSVs are the gsc-fetch.py exports. 4624's slug ("deadliest") is false on the 2024 SCDPS Fact Book (174 collisions,
#2 in the tri-county, #5 statewide, no deaths) — see `../2026-10-02-post-4624/`.

What moved: 4624's freshness-verified title, body, excerpt, Key Takeaways, FAQs, meta description, `_roden_jurisdiction`,
`_roden_last_reviewed` and `_roden_author_attorney` were copied onto 4337 by `bin/merge-ashley-phosphate-4624-into-4337.php`
(wp_update_post / update_post_meta with wp_slash). 4337 keeps its slug, publish date and author; post_modified stamped
2026-10-02. The script's own same-request read-back reported a mismatch; an independent field-by-field comparison run
immediately after showed all nine fields identical (title, content, excerpt and the six meta keys), so the copy is
complete — the in-script check most likely read a cached value. Backups of both posts before the copy:
`prod-backup-before-4337.json`, `prod-backup-before-4624.json`.

Pre-flight (read-only): no published page links to 4624 — 19 references, all drafts or revisions; no post-meta or option
references. One published page (4540, the North Charleston car-accident page) links 4337 and keeps working.

Redirect: `roden_ashley_phosphate_fold_urls()` in `inc/legacy-redirects.php`, PR #207. 4624 retired to draft after deploy
(`… eval-file - retire apply`), marked `_roden_retired`.

Internal links 4337's old body had that the merged body does not (the old body is in the 4337 backup if any should be
restored): /car-accident-lawyers/charleston-sc/, /locations/south-carolina/charleston/, /truck-accident-lawyers/charleston-sc/,
/practice-areas/{brain-injury, burn-injury, car-accident, pedestrian-accident, product-liability, spinal-cord-injury,
truck-accident, wrongful-death}-lawyers/.
