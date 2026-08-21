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

- [ ] **Update the website link in all six Google Business Profiles** to the clean
      URL, with no `utm_campaign=gmb_*` appended. The code now 301s those
      variants, so leaving the GBP links as-is just means every visitor takes an
      extra hop. Profiles: Savannah GA · Darien GA · Charleston SC ·
      North Charleston SC · Columbia SC · Myrtle Beach SC.

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

- [ ] **The 250–350 URL acceptance criterion is not reachable** as written — see
      `RECOVERY-LOG.md` for the arithmetic. Guardrail-protected pages alone are
      991 URLs. Either the target was scoped to location + practice-area only
      (where the honest end state is 418–535), or it assumed cutting the blog and
      case results, which the guardrails forbid. Pick one before batch (a) ships.

- [ ] **Brand name** — the site says "Roden Law"; registrations and citations say
      "Roden + Love, LLC". One name everywhere. Domain migration stays frozen
      regardless (plan guardrail).

## Already shipped (no action needed)

- [x] Tracking-parameter URLs now 301 to their clean path, with lead-source
      attribution preserved through the redirect.
