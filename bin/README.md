# `bin/` — repo tooling

Piped to production over stdin, never deployed:

```bash
ssh $H "wp --path=$P eval-file -" < bin/<script>.php > backup.json
```

## Retired 2026-08-25 — do not restore without reading this

Four scripts and two payloads were removed because they recreate exactly what the
SEO cull spent four batches removing:

| Removed | Recreated |
|---|---|
| `seed-sc-town-locations.php`, `build-town-location-seed.sh`, `data/sc-town-locations-2026-08-20.json` | the 8 non-office town pages retired by batch (b) |
| `seed-sc-intersections.php`, `build-sc-intersection-seed.sh`, `data/sc-intersections-2026-08-19.json` | the 35 town × practice pages, 34 of which batch (d) retired |

They worked, they were idempotent, and the payloads were still on disk. One run
would have undone 42 URLs of cull work, and nothing in the repo said not to.

Git history is the archive — `git log --diff-filter=D --` finds them. They are not
gone, only out of reach of a tab-complete.

The enforcement that replaced them is `inc/content-guardrails.php`, which blocks
the Publish click itself rather than relying on a script being absent. Tests:
`php bin/test-content-guardrails.php`.

## The rule this follows

`CLAUDE.md` says spent one-shot scripts must not linger in `inc/`, because "a spent
script reads as authoritative and is not." The same reasoning applies here with an
edge: in `inc/` a stale script is merely misleading, while in `bin/` it is
executable against production.

**Do not add new location, neighbourhood, road or permutation seeders while the
recovery is running.** Content seeders for one-off legal-reference pages — such as
`en-seed-resource-page.php` — are fine and are deliberately kept.

`es-seed-pages.php` is kept but sits in between: it seeds Spanish pillars *and*
practice-area × city intersections, and `docs/es-phase4-activation.md` documents a
workflow around it. Today every `/es/` intersection belongs to one of the six
office cities, which are guardrail keeps. **Use it for pillars and office-city
pages only — never to add an intersection for a town without an office.**
