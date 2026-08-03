#!/usr/bin/env bash
# Build a self-contained seeder (payload + logic) for piping to prod over stdin.
#
#   bin/es-build-seed.sh drafts.json > /tmp/seed.php
#   SEEDER=es-update-faqs.php bin/es-build-seed.sh faqs.json > /tmp/faqs.php
#   ssh <prod> "wp --path=<site> eval-file -" < /tmp/seed.php          # dry run
#   ssh <prod> "wp --path=<site> eval-file - apply" < /tmp/seed.php    # apply
#
# Nothing outside the site directory persists on WP Engine between SSH sessions,
# and scp/sftp are refused by the host, so the payload has to travel inside the
# script itself rather than being staged on the server first.
set -euo pipefail
[ $# -eq 1 ] || { echo "usage: $0 <drafts.json>" >&2; exit 1; }
here="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# Heredoc delimiter must not appear in the payload.
if grep -q '^RODENJSON$' "$1"; then
  echo "error: payload contains the heredoc delimiter RODENJSON" >&2
  exit 1
fi

# No closing tag: PHP mode stays open so the seeder body below is parsed as
# code. Closing it would make the body HTML, and the first open tag inside a
# docblock example would then re-enter PHP mode mid-comment and fail to parse.
printf "<?php define('RODEN_SEED_JSON', <<<'RODENJSON'\n"
cat "$1"
printf "\nRODENJSON\n);\n"
tail -n +2 "$here/${SEEDER:-es-seed-pages.php}"
