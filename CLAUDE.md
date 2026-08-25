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

## The drift guard

`deploy.yml` compares production against the last-deployed tree before every deploy and **blocks**
if anyone edited the server directly. Verified working 2026-07-31: with a planted file on prod the
deploy is skipped and production is left untouched; with none it deploys normally.

It needs two secrets, because WP Engine keeps two independent key registries:

| Secret | Registry | Used for |
|---|---|---|
| `WPE_SSHG_KEY_PRIVATE` | git deploy keys (per environment) | pushing to `git@git.wpengine.com` |
| `WPE_GATEWAY_KEY_PRIVATE` | SSH Gateway keys (per user account) | reading prod for the drift comparison |

A key valid in one is **not** valid in the other. Do not assume one key covers both — and when
testing whether a key works, use `-o IdentityAgent=none`, because `IdentitiesOnly=yes` alone still
lets an agent key answer and will tell you a key works when it does not.

If the gateway key is missing or unreachable the check reports itself **inactive** in the job
summary and the deploy proceeds — it can never block shipping on its own failure.

## The content-meta record

`content/meta.json` is a generated snapshot of the post meta that carries legal
and SEO weight — jurisdiction, SOL citations, review dates, FAQ text, attorney
attribution, translation pairs — across `practice_area`, `location`, `resource`,
`post` and `page`. **Do not hand-edit it. Regenerate it:**

```bash
ssh rodenlawprod@rodenlawprod.ssh.wpengine.net \
  "wp --path=/home/wpe-user/sites/rodenlawprod eval-file -" \
  < bin/export-content-meta.php > content/meta.json
```

Commit it whenever you change content meta. `deploy.yml` regenerates it against
production on every deploy and **warns** (never blocks) when it has drifted —
the database is untouched by deploys, so drift is a review signal, not a hazard.

It exists because the database is where the legal errors keep hiding. Workers'
comp pages carried the *tort* statute of limitations in `_roden_sol_ga`/`_sc`;
that was fixed on the English posts on 2026-07-30 and then found again on the
Spanish twins on 07-31, three weeks later and only by accident. A diff on this
file surfaces that class of error immediately.

`post` and `page` were added on 2026-08-25 for the same reason. A false workers'
compensation filing deadline was corrected in a page body, a sweep of
`post_content` came back clean, and the claim was **still on the live page** — it
also lived in `_roden_faqs`, and blog posts were outside the export. The meta key
was already whitelisted; the post type was not, leaving 195 FAQ-carrying pages
(162 posts, 33 pages) unguarded. FAQ answers also render into FAQPage structured
data, so a wrong one is published twice over.

**When you correct a claim in a body, sweep the meta for the same claim *class*,
never for the same string** — the FAQ words it differently every time, which is
exactly why a string sweep misses it. `bin/apply-faq-remediation.php` patches FAQ
answers; `bin/apply-stat-remediation.php` handles bodies and structurally cannot
see meta.

Post **bodies** are deliberately not in it — ~8 MB of prose across 474 posts
that nobody would review. A periodic `wp db export` is the right protection for
those, and it is still not set up.

## Layout

| Path | Notes |
|---|---|
| `wordpress/wp-content/themes/roden-law/` | The theme. `git subtree split` makes `wordpress/` the deploy root. |
| `bin/` | Repo tooling. Piped to prod over stdin — never deployed. |
| `content/meta.json` | Generated content-meta record (see above) |
| `.github/workflows/deploy.yml` | Deploy to WP Engine prod (`rodenlawprod`) |
| `next/` | Separate migration workstream — not deployed by the WP workflow |

## `inc/` holds live code only

Every file in `wordpress/wp-content/themes/roden-law/inc/` is required by
`functions.php`. In July 2026 that directory also held **286 spent one-shot
scripts** — 6.1 MB of `seed-*`, `batch-*`, `fix-*`, `optimize-*` — that had
already run, were loaded by nothing, and had drifted from the content they
created. `seed-wc-charleston.php` still described South Carolina TTD in terms
the live page had not used for months.

They were removed (`bbae8f1`; git history is the archive). **Do not add
one-shot migration scripts back here.** Run them from `bin/` over stdin, or
delete them once applied — a spent script in `inc/` reads as authoritative and
is not.

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
