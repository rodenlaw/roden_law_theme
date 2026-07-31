# rodenlaw.com — working rules

## Edit this repo. Never edit production directly.

`.github/workflows/deploy.yml` deploys on every push to `main` touching `wordpress/**` (and on
manual `workflow_dispatch`). It runs:

```
git subtree split --prefix=wordpress -b deploy-branch
git push wpe-prod deploy-branch:main --force
```

That `--force` is the whole point of this file. **Anything changed on production but not
committed here is destroyed by the next deploy** — silently, with no warning and no diff.

This has already happened once. Between 2026-07-10 and 2026-07-31 the repo sat untouched while
28 theme files were edited directly on prod over SSH: an accessibility pass on 07-27/28 and a
workers'-compensation fix on 07-30. Both were one workflow run from being erased. They were
recovered and committed on 2026-07-31 (`b3557f6`, `5e2429b`).

## Layout

| Path | Notes |
|---|---|
| `wordpress/wp-content/themes/roden-law/` | The theme. `git subtree split` makes `wordpress/` the deploy root. |
| `.github/workflows/deploy.yml` | Deploy to WP Engine prod (`rodenlawprod`) |
| `next/` | Separate migration workstream — not deployed by the WP workflow |

## Before you start

Confirm prod hasn't drifted again:

```bash
H=rodenlawprod@rodenlawprod.ssh.wpengine.net
K=~/.ssh/wpengine_ed25519
T=/home/wpe-user/sites/rodenlawprod/wp-content/themes/roden-law
ssh -i $K $H "md5sum $T/inc/template-tags.php $T/functions.php $T/style.css"
md5 -q wordpress/wp-content/themes/roden-law/{inc/template-tags.php,functions.php,style.css}
```

Mismatch means someone edited prod. **Commit that drift before doing anything else** — pushing
first will erase it.

## Auditing tools that read the live site

Site audits (accessibility, SEO, schema) read `https://rodenlaw.com` and report findings against
live URLs. Remediate **here**, not on the server. The audit output tells you *what* is broken; the
fix belongs in this repo so the deploy carries it forward instead of overwriting it.

The a11y skill's guidance to "prefer a source-level companion auditor for repos we control"
applies to this client — it is WordPress *and* it has CI. Do not treat it as a no-CI WordPress
site.

## Gotchas

- **Cache busting is manual.** `inc/enqueue.php` versions assets off the `Version:` line in
  `style.css`. Any CSS/JS change must bump it. After deploy, flush both layers from
  `~/sites/rodenlawprod`: `wp cache flush` **and** `wp page-cache flush`.
- **Editing a translated string changes its msgid and silently drops the Spanish**, leaving
  English on `/es/` pages. Grep changed msgids against `languages/es_ES.po`, re-add with the prior
  wording, and recompile `es_ES.mo` — there is no `msgfmt` on the WP Engine host, so compile
  locally. WordPress reads the `.mo`; a `.po`-only change does nothing.
- **Four templates share the practice-area rendering** — `template-practice-area.php`,
  `template-intersection.php`, `template-subtype.php`, `single-location-neighborhood.php`. A fix
  applied to one is not applied to the others. This has bitten twice.
- **The database is not in this repo.** Post content, post meta and taxonomy are not files.
  Several fixes have been data-only, with no undo.

## Emergency SSH edits

If you must touch prod directly, back the file up first
(`cp <f> <f>.bak-$(date +%Y%m%d)`) and **commit the identical change here in the same session**.
An uncommitted prod edit is a scheduled deletion. `scp`/`sftp` are refused by this host — move
files with `ssh $H "cat > <path>" < <local>` and verify with `md5`.
