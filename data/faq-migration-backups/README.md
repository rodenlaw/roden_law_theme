# Content-change backups — 2026-09-09

Original `post_content` for every post whose body was edited on 2026-09-09 — the
FAQ campaign in PRs #120 and #121, plus the stale-TTD-figure correction. Captured by the apply run **before** any write, in the same
shape as `data/es-relink-backups/`.

`content/meta.json` records the FAQ meta these posts now carry. It does **not**
record their bodies, by design — see the note at the top of
`bin/export-content-meta.php`. These three files are the only copy of what those
bodies looked like before, which is why they are committed rather than left in a
scratch directory.

| File | Posts | What was changed |
|---|---|---|
| `2026-09-09-visible-faq-to-meta-before.json` | 29 | Visible in-body FAQ section removed; its Q&A written to `_roden_faqs` (#120) |
| `2026-09-09-embedded-schema-to-meta-before.json` | 87 | Inline JSON-LD `<script>` **and** the visible FAQ section removed; Q&A written to `_roden_faqs` (#121) |
| `2026-09-09-damaged-schema-replaced-before.json` | 3 | Backslash-damaged inline JSON-LD removed; freshly authored FAQs written to `_roden_faqs` (#121) |
| `2026-09-09-stale-ttd-figure-before.json` | 2 | Stale `$575` Georgia TTD weekly maximum replaced with the date-qualified figure |
| `2026-09-09-hardcoded-review-lines-before.json` | 112 | Hand-typed "Last reviewed" line removed from the body; date moved to `_roden_last_reviewed` (also records `meta_before`) |

## Shape

```json
{ "/blog/some-post/": { "id": 1234, "post_content": "…original body…" } }
```

## Restoring one post

`post_content` only. For the three FAQ files, restoring does **not** clear
`_roden_faqs`, so a post restored on its own will render its FAQ twice — delete
the meta in the same step. The TTD file touched no meta, so restoring it is just
the body write.

```php
$b  = json_decode( file_get_contents( 'backup.json' ), true );
$e  = $b['/blog/some-post/'];
wp_update_post( wp_slash( array(
    'ID'           => $e['id'],
    'post_content' => $e['post_content'],
) ) );
delete_post_meta( $e['id'], '_roden_faqs' );
```

`wp_slash()` is not optional here. `wp_update_post()` unslashes what you hand it,
and these bodies contain inline JSON-LD with escaped quotes — writing them back
bare is precisely the bug that broke four blocks in #118 and required PR #118 to
repair them. See the Gotchas section of `CLAUDE.md`.

## When these stop being useful

They reflect the bodies as of 2026-09-09. Once a post has been edited since, the
snapshot is a record rather than a safe restore target. Check `post_modified`
before restoring anything.
