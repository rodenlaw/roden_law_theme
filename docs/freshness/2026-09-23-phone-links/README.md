# Phone-link fix — 27 posts, 2026-09-23

Found during the police-report refresh (post 1679): the firm's toll-free number 1-844-RESULTS spells
844-737-8587 (`tel:+18447378587`, which the theme and 225 documents use), but 27 blog posts linked a
transposed number in their call-to-action:

| Wrong href | Posts | Dials |
|---|---:|---|
| `tel:+18442737858` | 22 | 844-273-7858 |
| `tel:+18442377858` | 5 | 844-237-7858 |

The visible text was "1-844-RESULTS" everywhere; only the href was wrong, so nobody would have seen it.

Applied 2026-09-23 through `bin/fix-phone-links.mjs --apply` (the content adapter's exact-match patcher,
one edit per post, each `before` verified to occur exactly once). `edits.json` lists every post and the
before/after href. Post-apply: zero wrong numbers left in published `post_content` or in `wp_postmeta`;
caches flushed; live pages spot-checked. No meta surfaces changed, so `content/meta.json` is unaffected.

The 22 posts with 844-273-7858 are the Charleston hyperlocal series (IDs 4336–4370, published together);
the 5 with 844-237-7858 are older explainers (1651, 1663, 1679, 2586, 2647). Two of those had already been
through the freshness refresh (2647, and 1679 in the pending batch) — the refresher does not check phone
hrefs against firm-facts, and it should.
