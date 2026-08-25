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
      and it is also the evidence the EVALUATE rows are waiting on.

      **Delivered 2026-08-24** — `docs/gsc-2026-08-24/`. Analysis in
      `docs/gsc-evidence-2026-08-24.md`. Two caveats worth knowing: the window
      is 13 months, not 16, and `Pages.csv` caps at 1,000 rows with a 1-click
      minimum, so zero-click pages are absent and their impressions unknown.

## Decisions needed

- [ ] **The 8 town pages published on 2026-08-20 are now flagged for removal.**
      Fort Mill, Greer, Hilton Head, Orangeburg, Rock Hill, Simpsonville,
      Spartanburg and Sumter got location pages the day before this plan was
      written. None is an office market, all are ~270–320 unique words against a median of 843 for the office-city
      pages, and being one day old they have no ranking history to justify
      keeping them. They are
      the exact page type the plan's guardrail now forbids creating. Confirm they
      go, or say what service history justifies keeping them.

- [ ] **The EVALUATE rows — now answerable.** The data landed; see
      `docs/gsc-evidence-2026-08-24.md` for the full per-URL tables. Two decisions,
      and the evidence points in opposite directions:

      - **109 live nested location pages: 66 earned ZERO clicks in 13 months.**
        The 43 that earned anything produced 91 clicks between them — 0.8 per page
        over more than a year, and only Woodbine (21) and Folkston (6) clear five.
        *(The triage lists 117; eight are stale rows for pages batch (b) already
        removed and which already 301.)*
        `/locations/south-carolina/north-charleston/goose-creek/` is the pattern in
        one row: 13,248 impressions, 2 clicks. *Recommendation: remove the 66, 301
        to the parent office-city hub.* **The API data landed 2026-08-25 and
        settles it:** those 66 pages took **21,548 impressions and earned 1
        click** — CTR 0.005% against the site's own 0.48% at the same positions.
        They are not invisible; they are shown constantly and refused. **Approved 2026-08-25;
        batch built and open as a PR.** Redirects deploy first, then the CMS
        step — the PR carries the ordered commands.

      - **48 corridor `/resources/` pages: keep most of them.** This one came back
        against expectation. 37 of 48 earn clicks at page-one positions, 311 total
        — more than the whole legal library earns on 19 pages. Folding them all into
        the Corridor Report, as the Steinberg plan assumes, would throw away working
        long-tail. *Recommendation: fold only the 11 zero-click pages into Study #1;
        keep the rest.* **APPROVED 2026-08-24** — shipped as the corridor-fold PR.

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
