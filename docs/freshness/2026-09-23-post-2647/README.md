# Freshness refresh — post 2647, 2026-09-23

`/blog/rollover-crashes-and-what-they-do-to-your-body/` — the first post through the
WordPress Tier B path (audit item a2, queue rank 1 in `data/local-seo/freshness-queue-2026-09-23.json`).

| File | What |
|---|---|
| `facts-2647.json` | Facts pack: 27 claims verified against primary sources, 17 keep / 10 update / 0 drop |
| `body.before.html`, `meta.before.json` | The post as exported before the refresh |
| `body.html`, `meta.json` | The refreshed surfaces (after the owner's cut of the attribution quote) |
| `edits.json` | The 12 exact-match edits the adapter applied (8 body, 1 key takeaways, 3 FAQ answers) |
| `verify.json` | Provenance report: 0 violations, body +9.2% |
| `prod-backup-before.json` | `wp post get` + `wp post meta list` taken immediately before apply |

Applied 2026-09-23 through `bin/freshness-build-patch.mjs --apply` (patch-content.php, `wp_slash`).
**The first apply lost 9 of the 12 edits:** the toolkit's `patch-content.php` computed every edit from the
original field value and wrote them in turn, so only the last body edit and the last FAQ edit survived while
the dry run reported all twelve verified. Fixed in internal-ai-scripts (`fix/patch-content-accumulate`: one
working copy per field, written once) and re-applied; every edit then verified in the database and on the
live page. Any run of the adapter from a toolkit checkout without that fix will repeat the loss.
Then
then `_roden_last_reviewed` = 2026-09-23 and `_roden_author_attorney` = 3732 (Graeham C. Gillin —
owner's rule: anything stating SC law is reviewed by Gillin). Attribution quote cut on the owner's
instruction. Both caches flushed; live page verified; JSON-LD validated; `content/meta.json` regenerated.

Legal corrections carried: Georgia punitive cap exceptions (§ 51-12-5.1(e)/(f)); wrongful-death standing
by state (§ 51-4-2, § 15-51-20); government-claim deadlines by state (§§ 36-33-5, 36-11-1, 50-21-26;
§§ 15-78-80, 15-78-110); SC 51% bar cited to *Nelson v. Concrete Supply Co.*; the unsupported "8 times"
ejection figure replaced with NHTSA DOT HS 813 700; the intro's dead NHTSA link replaced with DOT HS 813 723.
