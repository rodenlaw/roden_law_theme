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

## Resolution and second fix (same day)

The 22 section-level dead paths were resolved by walking Justia's chapter and article index pages from inside the
browser (`map-dead-to-live.json`); the 7 article-level "et seq." links were resolved from the posts' own anchor
text (§ 20-2-324.1 → its section page; § 40-6-320 et seq. → Article 13 Part 2A; § 8-2-100 et seq. → Chapter 2
Article 1 Part 6; § 51-1-11 and § 51-1-40 → their section pages). Every replacement was fetched and returned a
live 2025 Code page. Applied through `bin/fix-justia-links.mjs` (79 edits across 66 documents; two posts linked
§ 51-1-11 twice, anchored on the full link tag; `edits-28-paths.json`). Post-apply fresh export: **zero** of the 28
dead paths remain in any surface.

**Not fixed — a citation problem, not a link problem:** six ATV pages cite "O.C.G.A. § 40-7-120 et seq." and link
Title 40 Chapter 7 Article 5. Justia's Chapter 7 index has no § 40-7-120 and no Article 5; the section does not
exist in the 2025 Code. The claim ("restricts ATV use on public roads") needs the legal-accuracy lead to find the
real authority (Title 40 Chapter 7 is Off-Road Vehicles, §§ 40-7-1 et seq.) before the link can be repaired.
Pages: /practice-areas/atv-side-by-side-accident-lawyers/ and five ATV subtype pages.
