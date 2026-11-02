# Site-health remediation, 2026-11-02

Input: `data/site-health/latest.json` (generated 2026-10-26T21:24Z, live mode against
https://rodenlaw.com). The only failing check is `a11y`: `/testimonials/: LINK_NO_NAME:10`.
The owner approved one PR for that finding class. Everything else below is recorded, not
changed.

Prod drift check before work: `inc/template-tags.php`, `functions.php`, `style.css` and
`template-parts/content-card.php` matched origin/main.

## Source

`template-parts/content-card.php` is the card for every post-type archive (archive.php,
home.php, index.php, category.php, tag.php, search.php). Each card renders three links to
the same post: the image (or placeholder) link, the title link inside `h2.blog-card-title`,
and "Read More →".

- The placeholder link (no featured image) holds only `roden_icon('scale')`, an
  `aria-hidden` SVG since #281 replaced the `⚖` text glyph, plus the category tag span when
  the post has a category. Testimonials have no category, so on `/testimonials/` the link has
  no accessible name: 10 per page, on every archive page. On `/blog/` the same link was named
  by its category tag ("North Charleston", "Medical Malpractice", "Uncategorized"), which
  says nothing about where it goes. This is why those names showed up as ambiguous links.
- "Read More →" was a hard-coded English string with no post context. It was the same name
  for 10 destinations per page, and it showed in English on `/es/blog/`.

`/testimonials/` is the `testimonial` post-type archive (`has_archive`, rewrite slug
`testimonials`), not the WP page of that name. `page-testimonials.php` never renders there.

## Fix (one PR)

- Both image links (thumbnail and placeholder) get `aria-hidden="true" tabindex="-1"`. They
  duplicate the title link, which carries the post title, so a screen reader meets each card
  once and keyboard users tab past one less stop per card.
- "Read More" is translatable and has a screen-reader-only suffix (`.sr-only`, style.css):
  `Read More<span class="sr-only">: {title}</span> <span aria-hidden="true">→</span>`. It
  looks the same as before. New msgid `Read More` → `Leer Más` in `es_ES.po` and
  `roden-law.pot`. `es_ES.mo` was recompiled locally; before the change the committed .mo
  was byte-identical to `msgfmt es_ES.po`, so the recompile adds only this entry.
- No CSS or JS change, so no `Version:` bump.

## Verification

Chain: (1) PHP CLI render of main vs patched `content-card.php` with stubbed WP helpers,
covering thumbnail/placeholder x category/none x author/none x EN/ES. (2) An HTML transform
reproduces the patched render exactly: 8/8 scenarios. (3) That transform was applied to live
production HTML and the result run through the package's own `auditHtml`.

| Page | Cards | Before | After | Read-more names |
|---|---|---|---|---|
| /testimonials/ | 10 | LINK_NO_NAME:10, AMBIGUOUS:1 | clean (LOW_MAIN_TEXT_RATIO 0.30 stays) | 10/10 unique |
| /testimonials/page/2/ | 10 | LINK_NO_NAME:10, AMBIGUOUS:1 | clean (LOW_MAIN_TEXT_RATIO 0.30 stays) | 10/10 unique |
| /blog/ | 10 | AMBIGUOUS:3 | clean | 10/10 unique |
| /blog/page/2/ | 10 | AMBIGUOUS:2 | clean | 10/10 unique |
| /es/blog/ | 5 | AMBIGUOUS:2, LOW_MAIN_TEXT_RATIO:0.34 | clean | 5/5 unique ("Leer Más: …") |
| /resources/ | 10 | AMBIGUOUS:1 | clean | 10/10 unique |
| /resources/page/2/ | 10 | AMBIGUOUS:1 | clean | 10/10 unique |
| 7 control pages without cards | 0 | unchanged | unchanged | — |

Fresh live run on 2026-11-02 (`a11y --base https://rodenlaw.com --concurrency 3`) gave the
same result as the 10-26 report: 636 audited, 635 clean, `/testimonials/: LINK_NO_NAME:10`,
AMBIGUOUS_LINK_NAME on 32 pages. Full sitemap with the transform applied: pages with issues
went from 1 to 0, AMBIGUOUS_LINK_NAME pages from 32 to 28 (all 4 card pages cleared; the 28
left are post bodies and nav/footer), and 0 pages without cards changed. Only 4 sitemap URLs
render the card: /testimonials/, /blog/, /es/blog/ and /resources/. The paginated pages above
are not in the sitemap.

No `ARIA_HIDDEN_FOCUSABLE` after, because tabindex=-1 takes the hidden links out of the
focus order. The `/es/blog/` text-ratio warning clears only because the screen-reader titles
add main-content text. That side effect is not counted as a fix.

## Findings

| Class | Status | Reason |
|---|---|---|
| a11y LINK_NO_NAME (/testimonials/, card placeholder link) | **fixed** (#293, deployed 2026-11-02) | `content-card.php`, see above |
| a11y AMBIGUOUS_LINK_NAME from the card template ("read more →", category-tag names) on /blog/, /es/blog/, /resources/, /testimonials/ and their pagination | **fixed** (#293) | same PR |
| a11y AMBIGUOUS_LINK_NAME in post bodies and nav/footer (28 of the 32 pages) | **deferred** | content and link strategy, notice tier, never gates; outside the approved scope |
| a11y TABLE_NO_TH on /blog/much-worth-ga-worker-compared-states/ | **fixed** 2026-11-02 (owner-approved) | post 1851: header row is now `<thead>` with `th scope=col`, row labels are `th scope=row`, cell text unchanged; `bin/fix-a11y-two-posts-2026-11-02.php` |
| a11y WEAK_ALT on /blog/workers-compensation-faqs/ | **fixed** 2026-11-02 (owner-approved) | post 1784: `walking-assistant-blog.jpg` alt changed from "Walker " to "Patient using a walker, steadied by a caregiver"; same script |
| a11y LOW_MAIN_TEXT_RATIO on 10 hubs (/testimonials/, /contact/, /attorneys/, /attorneys/nolan-alexander/, /practice-areas/, /locations/, /es/practice-areas/, /es/locations/, /es/resources/, /es/blog/) | **deferred** | warning tier. Hubs are mostly links by design; adding text only to raise a ratio is a content decision for the owner |
| Found: `page-testimonials.php` (page content + Trustindex reviews widget) is shadowed by the `testimonial` archive at /testimonials/ | **deferred** | not a report finding. Which of the two should own the URL is an owner decision |
| Found: `templates/parts/content-blog-card.php` has the same hard-coded "Read More &rarr;" | **not touched** | dead file, nothing loads it, so it renders nowhere |
| redirects | pass | 997 replayed, 0 chains, 0 lost |
| crawl | pass | 0 non-200, 0 broken/hop links, 0 orphans, 0 unreachable, 0 false affordances |
| canonicals | pass | 636/636 |
| granularity floor | pass | 13 kept by decision (siteHealth.floor.keep) |
| doorway ratio | pass | 19.5% (ceiling 25%) |
| link topics | pass | 0 cross-topic |
| Wikidata | pass | no references |

After deploy: flush `wp cache flush` and `wp page-cache flush`, then re-run
`node vendor/site-health/site-health.mjs a11y --repo . --base https://rodenlaw.com` and
check that /testimonials/ has no issues.

## After deploy (2026-11-02)

- #293 merged as `999acf2`. Deploy run 41467902109: the drift guard was clean and the deploy
  succeeded. The post-deploy site-health crawl gave all 8 checks PASS: a11y 636/636 clean,
  0 issues, 11 warnings, AMBIGUOUS_LINK_NAME on 28 pages.
- Posts 1851 and 1784 were patched on prod with `bin/fix-a11y-two-posts-2026-11-02.php`.
  The dry run matched, apply verified ok on both, and the pre-edit `post_content` is in
  `data/db-backups/2026-11-02-a11y-two-posts-before.json`.
  `check-unslashed-post-writes.php` passed, both caches were flushed, and the live pages show
  9 `<th scope>` and the new alt text. That crawl ran before this edit, so it still counts
  these two warnings; expect 9 on the next run.

