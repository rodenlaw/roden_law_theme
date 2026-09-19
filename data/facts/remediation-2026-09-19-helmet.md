# Remediation — the helmet claim class — 2026-09-19

**Trigger.** The two helmet-law drafts commissioned from `content-plan/2026-10.md` (entries 1a
and 1b) each read the 20 pages carrying helmet claims and filed divergence lists. One item was a
false statement of law on a live pillar. The owner asked for the pillar fix and a claim-class
sweep.

**Authorities.** Only two helmet statutes are on the Verified table of
`docs/statute-verification-tracker.md`: `O.C.G.A. § 40-6-315` (every motorcycle rider and
passenger; pass 4) and `S.C. Code § 56-5-3660` (riders and passengers under 21; pass 3, #109).
Neither says anything about evidence or damages. The South Carolina writer traced the
secondary rules on scstatehouse.gov on 2026-09-19 (no bicycle helmet statute in Title 56 Ch. 5;
e-bikes ridden as bicycles under § 56-5-3520; no e-bike classes, § 56-1-10(29)); those are
tagged in the draft, not yet on the Verified table, and were used here only to decide that a
statement was *unqualified*, never to assert a new one.

## What the sweep read

Every published `post`, `page`, `practice_area`, `location` and `resource` on production:

| Surface | Pages with helmet text | Sentences |
|---|---:|---:|
| `post_content` | 45 | — |
| `_roden_faqs` | 25 | — |
| `_roden_key_takeaways` | 5 | — |
| `post_excerpt` | 0 | — |
| **subtotal, the four known surfaces** | **51** | **175** |
| `_roden_common_injuries` | 14 rows | |
| `_roden_why_hire` | 3 rows | |
| `_roden_pillar_negligence_intro` | 3 rows | |
| `_roden_common_causes` | 2 rows | |

**The fifth surface.** The false sentence on the motorcycle pillar was in none of the four
surfaces every previous sweep read. It was in `_roden_common_injuries`, a serialized array
rendered as a pillar section. A four-surface sweep of that page reports it clean while the
live page says the opposite. The fix has two halves: the sentence, and
`bin/export-content-meta.php`, which now exports all four extra fields so the next diff can
see them (2,037 lines added to `content/meta.json` on regeneration).

## Edits applied (9, across 5 posts)

`bin/fix-helmet-claims.php`, guarded on exact current text, meta through
`update_post_meta( wp_slash( … ) )` with a byte-for-byte read-back, bodies by direct column
write. Backup: `docs/backups/helmet-claims-2026-09-19.json`.

| # | Post | Surface | Was | Now | Class |
|---|---|---|---|---|---|
| 1 | 3607 `/practice-areas/motorcycle-accident-lawyers/` | `_roden_common_injuries[1]` | "Georgia does not require helmets for riders over 18" | Universal rule, § 40-6-315 cited | **false statement of law** |
| 2 | 4087 `/practice-areas/bicycle-accident-lawyers/` | `_roden_faqs[2]` | "South Carolina has no statewide helmet law" | "…no statewide **bicycle** helmet law" | unqualified |
| 3 | 4087 | `_roden_pillar_negligence_intro` | same | same | unqualified |
| 4 | 4088 `/practice-areas/electric-scooter-accident-lawyers/` | `post_content` | "…ordinances governing … and helmet requirements" | clause removed | unsourced, omitted |
| 5 | 4088 | `_roden_faqs[4]` | "Some South Carolina municipalities require helmets for scooter riders." | sentence removed | unsourced, omitted |
| 6 | 1667 `/blog/7-mistakes-to-avoid-after-a-motorcycle-accident/` | `post_content` | "Failure to wear a helmet can be used as evidence of comparative fault" | insurer-argument framing | evidentiary claim reframed |
| 7 | 1667 | `_roden_faqs[4]` | same | same | evidentiary claim reframed |
| 8 | 4088 | `_roden_pillar_negligence_intro` | "differ on … and helmet requirements" | clause removed | unsourced, omitted (found by the post-apply re-sweep) |
| 9 | 4644 `/blog/motorcycle-accidents-dorchester-road-data/` | `_roden_key_takeaways` | "riders over 21" | "riders 21 and older" | imprecise threshold |

Verified live after cache flush: every "was" string returns zero on its page, every "now"
string is present. Post-apply sweep of all bodies and all meta for the corrected strings:
zero survivals. Live JSON-LD guard PASS. `_roden_last_refreshed` set to 2026-09-19 on the five
posts; `post_modified` untouched.

## Read and left alone

- Descriptive uses (gear damage, dashcam and helmet-cam footage, "even with a helmet"): the
  large majority of the 175.
- Statements already framed as the insurer's argument ("the defense may argue", "may be raised
  as comparative fault", "could be used to argue"): 3607 FAQ, 4071, 4087, 4088, 4578, 4721,
  4814, 4815, 4858, 1664, 4644 body, and the Spanish twins. These match the framing the two
  drafts use.
- True statements: 4364 and 4639 (no adult bicycle helmet requirement in SC), 4578 FAQ ("no
  statewide helmet requirement" in the South Carolina e-bike context, where e-bikes ride as
  bicycles), 1667 ("no universal helmet law for riders 21 and older").

## Flagged for the attorneys, not changed

Uncited but not contradicted by anything verified. Trace or cut before the helmet pages ship;
the Georgia items could not be traced on 2026-09-19 because every free Georgia code host
returned 403 or 503.

- Georgia bicycle helmets for riders under 16 (`O.C.G.A. § 40-6-296` cited on 4087; uncited on
  1859 and 4578).
- Georgia e-bike helmet rules by class (4578 body, FAQ and `_roden_why_hire`: "Class III all
  ages, riders 15+, under-16 on Class I/II").
- ATV rental operators "must provide … helmets" (4089): a duty-of-care framing with no statute.
- The scooter municipal-ordinance claim, now omitted on all three surfaces of 4088: if an
  ordinance exists, cite it and restore.

## Process finding

**Every content sweep on this site must read every post-meta key, not the four it knows
about.** The four-surface rule in `CLAUDE.md` was itself written after the third surface was
found; this is the fourth time a claim survived on a surface the sweep did not read. The
export whitelist now carries the pillar-section fields, and `bin/fix-helmet-claims.php` shows
the shape of a sweep that starts from `SELECT … FROM postmeta WHERE meta_value LIKE` rather
than from a list of keys.
