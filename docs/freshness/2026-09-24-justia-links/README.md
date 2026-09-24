# Justia statute links — check and fixes, 2026-09-24

While refreshing post 1654, the § 51-12-33 link path the facts pack offered (`…/chapter-12/article-1/…`) was
checked in the browser and is a Justia "Page not found"; the correct path is `…/chapter-12/article-2/…`. The live
site linked the dead path 36 times (35 legacy pages plus post 1707, refreshed 2026-09-23 from a pack carrying the
same path). Fixed through `bin/fix-justia-links.mjs` (the content adapter's exact-match patcher, one edit per
document; `edits-51-12-33.json`). Post-apply: zero dead § 51-12-33 links in `post_content` or `wp_postmeta`.

Then every distinct Justia URL on the site (114 across 364 links) was fetched from inside a Justia page in the
browser (Justia blocks scripted fetches; same-origin `fetch` from a loaded page works). **30 of 114 are dead**
(`dead-links-2026-09-24.json`): after the § 51-12-33 fix, 29 dead URLs remain across 85 links on 71 documents.
Three known-good variants also redirect to a year edition (§§ 36-11-1, 36-33-5 → the 2022 Code) and still resolve.

Resolution of the remaining 29 continues in the same session: section-level paths are looked up on Justia's
chapter and article index pages; article-level "et seq." links are resolved from the anchor text in the posts.
