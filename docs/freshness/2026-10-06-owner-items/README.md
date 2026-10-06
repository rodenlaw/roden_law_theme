# Owner items from group 2 — posts 1697 and 1761, 2026-10-06

Owner: "repoint and rename".

- **1761** `/blog/workers-comp-for-carpal-tunnel-syndrome/`: "medical experts" (the insurer's own doctors) repointed from
  `/practice-areas/medical-malpractice-lawyers/` to `/blog/independent-medical-exams/`. This drops the post's only link to
  the malpractice page, which `bin/freshness-build-patch.mjs`'s link guard refuses (exit 3); the owner approved the
  exception, so it was written with `repoint-1761.php` (exact single match, wp_update_post( wp_slash() ), readback).
- **1697** `/blog/what-happens-if-i-resign-while-on-workers-compensation/`: the headings named a doctrine the post's own
  corrective paragraph says neither state's workers' compensation law has. H2 and TOC "Voluntary Resignation vs.
  Constructive Discharge" → "Why You Left Matters: Voluntary vs. Injury-Related Resignation" (id `voluntary-vs-constructive`
  kept); H3 "Constructive Discharge" → "When Your Employer Pushes You Out". Bullets and body unchanged. Builder: 3 edits,
  0 violations.

Backups (`prod-backup-before.json`) matched the dumped state. post_modified stamped 2026-10-06 13:26:38; both cache
layers flushed; DB readback matches. Live in Chrome (`?nc=`): both 200, new text present, old text gone, JSON-LD parses,
FAQPage 6 each. `bin/check-unslashed-post-writes.php` PASS (static and live). No meta fields changed.

Also closed: the other "overstating H2" (the SC 25/50/25 stacking H2) was on 4738, retired to draft 2026-09-25.
