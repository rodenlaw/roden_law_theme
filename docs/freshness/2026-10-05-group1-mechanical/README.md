# Group-1 follow-ups, mechanical fixes — 7 posts, 2026-10-05

Owner: "do the group 1 fixes", then "apply". These are the no-research items from the post-queue follow-up list.

| Post | URL | Fix |
|---|---|---|
| 1816 | /blog/benefits-of-hiring-personal-injury-lawyer/ | Key Takeaways: literal "SS" → "§" (2) |
| 4338 | /blog/savannah-highway-truck-accidents-west-ashley-us-17/ | Key Takeaways: "SS" → "§" |
| 4340 | /blog/boating-accidents-charleston-harbor-legal-rights/ | Key Takeaways: "SS" → "§" |
| 4341 | /blog/construction-worker-injuries-charleston-sc-rights/ | Key Takeaways: "SS" → "§" |
| 4342 | /blog/charleston-tourist-injuries-premises-liability-hotels-restaurants/ | Key Takeaways: "SS" → "§" |
| 4343 | /blog/golf-cart-accidents-charleston-island-resort-communities/ | Key Takeaways: "SS" → "§" |
| 1856 | /blog/pedestrian-safety-georgia/ | O.C.G.A. § 40-6-91 duty restated as "stop and remain stopped"; the overtaking ban cited to (d), not (c); SC comparative-fault row "51% or less" → "less than 51%"; Key Takeaways aligned |

Each post has `body.before.html`/`body.html`, `edits.json`, `meta.before.json`/`meta.json` and `prod-backup-before.json`
(taken immediately before the write). Applied through `bin/freshness-build-patch.mjs --apply`, read back from the DB
(`readback-mech.json`: all match), post_modified stamped 2026-10-05, both cache layers flushed.

Verified live in Chrome (`?nc=`): all seven return 200, every JSON-LD block parses, FAQPage intact (6 questions each),
dateModified 2026-10-05. `bin/check-unslashed-post-writes.php` PASS (static and live). `content/meta.json` regenerated.
