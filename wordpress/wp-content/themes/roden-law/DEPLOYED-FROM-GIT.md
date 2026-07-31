# STOP — do not edit this theme on the server

This theme is deployed from git. Editing files here is a **scheduled deletion**.

    Repo:    https://github.com/rodenlaw/roden_law_theme
    Path:    wordpress/wp-content/themes/roden-law/
    Deploy:  .github/workflows/deploy.yml
             push to main touching wordpress/**  ->  git push wpe-prod deploy-branch:main --force

That `--force` overwrites whatever is on this server with the repo's tree. Anything you change
here and do not commit is gone the next time anyone pushes to main or clicks "Run workflow".

This already happened: between 2026-07-10 and 2026-07-31 the repo sat untouched while 28 theme
files were edited here directly. They were one workflow run from being erased, and were only
recovered because the drift was noticed before a deploy fired.

## Do this instead

    git clone https://github.com/rodenlaw/roden_law_theme.git
    # edit wordpress/wp-content/themes/roden-law/..., commit, push to main
    # CI deploys here automatically

## If you genuinely must edit here (emergency only)

1. Back up:  cp <file> <file>.bak-$(date +%Y%m%d)
2. Commit the identical change to the repo **in the same session**
3. Confirm no drift remains:  md5sum <file>  vs the repo copy

See CLAUDE.md in the repo root for the full working rules.
