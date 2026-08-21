# Owner checklist — rodenlaw.com SEO pre-emption

These cannot be done from the codebase. Two of them **block** work that is
otherwise ready to ship. From `SEO-PREEMPTION-PLAN-rodenlaw.md` Phase 0 and §7.

## Blockers

- [ ] **Approve `url-triage.csv`** — 1,659 URLs classified. Nothing is deleted or
      redirected until you sign off. 122 marked REMOVE, 117 EVALUATE, 11
      CONSOLIDATE. See "Decisions needed" below before approving.

- [ ] **Who owns / commissioned these three domains?**
      `rodenlovelaw.com` · `policylimitscharters.com` · `iluvgus.com`
      They point 119, 95 and 22 referring domains at rodenlaw.com with the bare
      domain name as anchor text, all appearing Nov 2025 – Jan 2026. That is not
      organic velocity. **If a vendor is doing this, identify and stop them** —
      the disavow cannot be completed either way until this is answered, because
      disavowing your own rebrand campaign is the wrong move.

## Do this week

- [ ] **Check GSC → Manual Actions** for rodenlaw.com. The sister site was clean;
      this one is unconfirmed. If an action exists, the plan becomes the
      reconsideration evidence package rather than a pre-emption exercise.

- [ ] **Upload the disavow file** — `docs/disavow-rodenlaw-2026-08-21.txt`,
      34 domains across 3 verified spam clusters. Partial by design (see the two
      exclusions noted in the file header).

- [ ] **Retag the website link in all six Google Business Profiles** — this moved
      up: it is now the *only* thing that fixes the indexed tracking variants,
      not a follow-up to a code change.

      Use `?ref=gmb_<market>`, **not** `utm_campaign=gmb_<market>` and **not** a
      bare clean URL. WP Engine strips `utm_*` before PHP, so the redirect can
      never fire on those; a bare clean URL would work for SEO but throw away
      GBP lead attribution entirely. `?ref=` 301s to the clean path *and* keeps
      attribution via a cookie.

      | Profile | Website link to set |
      |---|---|
      | Savannah GA | `/locations/georgia/savannah/?ref=gmb_sav` |
      | Darien GA | `/locations/georgia/darien/?ref=gmb_dar` |
      | Charleston SC | `/locations/south-carolina/charleston/?ref=gmb_chs` |
      | North Charleston SC | `/locations/south-carolina/north-charleston/?ref=gmb_nchs` |
      | Columbia SC | `/locations/south-carolina/columbia/?ref=gmb_col` |
      | Myrtle Beach SC | `/locations/south-carolina/myrtle-beach/?ref=gmb_mb` |

      The existing `?utm_campaign=` variants already in the index cannot be
      redirected from PHP. They decay once the profiles stop linking them.

- [ ] **Export the GSC baseline** — performance by page and by query, 16 months,
      plus the indexed-page list. This is the before-picture for `RECOVERY-LOG.md`
      and it is also the evidence the 117 EVALUATE rows are waiting on.

## Decisions needed

- [ ] **The 8 town pages published on 2026-08-20 are now flagged for removal.**
      Fort Mill, Greer, Hilton Head, Orangeburg, Rock Hill, Simpsonville,
      Spartanburg and Sumter got location pages the day before this plan was
      written. None is an office market, all are ~130–170 unique words, and being
      one day old they have no ranking history to justify keeping them. They are
      the exact page type the plan's guardrail now forbids creating. Confirm they
      go, or say what service history justifies keeping them.

- [ ] **The 117 EVALUATE rows** — this is what the end-state number now hinges on,
      and it splits cleanly in two:
      - **8 city-tier towns** (the ones published 2026-08-20, above). No ranking
        history, no office, forbidden page type. *Recommendation: remove.* You can
        decide these today — they need no data.
      - **109 municipalities nested under an office city** (Mount Pleasant,
        Summerville, Goose Creek, Brunswick, Conway, Lexington…). Plan rule 4 keeps
        only those with real rankings, traffic or genuine service history. That
        needs the GSC baseline export — it is the one decision genuinely blocked on
        data, and it is why the export is on this list.

- [ ] **Brand name** — the site says "Roden Law"; registrations and citations say
      "Roden + Love, LLC". One name everywhere. Domain migration stays frozen
      regardless (plan guardrail).

## Resolved — no longer needs your input

- [x] **The 250–350 URL acceptance criterion.** It was not a target but leftover
      arithmetic (`~1,500 total − ~1,145 doorway`), built on counts that were wrong:
      location is 219 pages not ~470, practice-area 449 not ~650–700, and the
      484-post blog went uncounted. Restated against the scope Phase 1 actually
      governs — **418–535 location + practice-area URLs, down from 668**. The plan
      and `RECOVERY-LOG.md` both carry the corrected figures and the derivation.

## Already shipped (no action needed)

- [x] Tracking-parameter URLs now 301 to their clean path, with lead-source
      attribution preserved through the redirect.
