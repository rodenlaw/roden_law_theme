# Remediation plan: page 4574, Troubled Teen Industry Abuse, FAQ 5 (2026-10-24)

**Page:** https://rodenlaw.com/class-action-lawyers/troubled-teen-industry-abuse/ (type `page`, WordPress id 4574; `modified` 2026-10-23 22:57, which is the #268 body edit that removed the link to the retired class-action hub)
**Status:** plan only. Nothing has been applied, and no production edits or SSH were made.
**Ledger:** `data/seo/ledger.json` lists the page as `free`. The last recorded change is 2024-05-10 and `doNotTouchBefore` is 2024-08-08, so the page is outside any 90-day window. The fix still replaces one sentence and touches nothing else.
**Supersedes:** finding F1 of `remediation-2026-10-21.md`, re-checked against today's export. The published string has not changed since 10-21. F2 through F7 of that plan are still open and are not repeated here.

## Inputs

- Sweep: `data/facts/sweep-2026-10-24.json`, run with `sweep-claims.mjs --client roden --fresh` against production (645 documents). **1 error.**
- Export: `data/content-cache/wp-export.json`, `exportedAt` 2026-10-24T17:37:03Z. The FAQ text below is read from document 4574, `meta.faqs[4].answer`, which is the `_roden_faqs` meta.
- Live render, fetched 2026-10-24 (HTTP 200). The six FAQ answers in the FAQPage JSON-LD match `_roden_faqs` word for word. So the FAQ 5 fix also fixes the structured data.
- Engine replay of the whole page, run in memory against the current GA and SC packs. As published: 1 finding (`abuse-sol-extension-overbroad`, `faqs[4]`). With correction A: 0 findings, 0 warnings. With correction B: 0 findings, 0 warnings, under `both`, `georgia-only` and `south-carolina`. Fixture set `law/fixtures/roden-abuse-sol-2026-10-21.json` replays 21/21 and already holds correction A as control `ctrl-tti-faq5-interim`. **No pack rule was changed.**

## Sign-off state (for Roden)

| Authority | Pack | Signed for Roden? |
|---|---|---|
| GA 9-3-33 (ordinary 2-year PI period) | GA `authorities` | **No.** `law-signoff.json` declares GA `unsigned` for Roden. Tyler Love signs for Roden (owner decision D6, 2026-10-21) and has not signed. The pack's shared signature does not count for Roden. |
| GA 9-3-33.1 (childhood sexual abuse) | GA `pendingAuthorities` | **No.** It is pending in the pack and unsigned for Roden. The 2025–26 currency read is also still owed. |
| GA 9-3-90 (minority tolling) | GA `pendingAuthorities` | **No.** Same status as GA 9-3-33.1. |
| GA 9-3-99 (tolling during a criminal prosecution) | GA `pendingAuthorities` | **No.** |
| SC 15-3-530 (ordinary 3-year PI period) | SC `authorities` | **Yes.** Signed by Graeham C. Gillin on 2026-09-26. |
| SC 15-3-555 (sexual abuse or incest) | SC `pendingAuthorities` | **No.** It is pending and unsigned. Gillin has the 2026-10-21 SC packet. |
| SC 15-3-40 (minority tolling) | SC `pendingAuthorities` | **No.** It is pending and unsigned. |

**For Roden, the whole GA pack is unsigned.** Only SC 15-3-530 is a signed authority on this subject. The pack rules still fail the build either way. An unsigned authority cannot back a NEW claim. That is why correction A says nothing specific, and why correction B has to wait.

## Claim-class sweep of every surface on page 4574

The class is any statement that abuse claims in general get a longer, extended or special deadline, or more time. I searched for it by meaning, not by matching the published string.

| Surface | Contents (export and live) | Instances of the class |
|---|---|---|
| `_roden_faqs[4]` (FAQ 5) + FAQPage JSON-LD | limitation answer | **1, finding F1 below** |
| `_roden_faqs[0]`, `[1]`, `[2]`, `[3]`, `[5]` + JSON-LD | legal options, damages, fees, abuse types, licensure | 0. None of them mentions a deadline. |
| `post_content` | 6,725 chars | 0. Its only limitation sentence is "In many cases, the statute of limitations may have expired or be close to expiring." That sentence is accurate and makes no claim of more time. It contradicts the published FAQ 5, and F1 removes the contradiction (see F2 of the 10-21 plan). |
| `post_excerpt` | empty | 0. The Service/Article `description` and the meta, og and twitter descriptions fall back to the body's opening sentences, which carry no claim. |
| `_roden_key_takeaways` | empty, and no summary box renders | 0 |
| `_roden_meta_description`, `_roden_jurisdiction`, `_roden_locale`, `_roden_sol_ga`, `_roden_sol_sc`, `_roden_last_reviewed`, `_roden_author_attorney` | all empty in the export | 0 |
| Every other whitelisted `_roden_*` key in `bin/export-content-meta.php` (`state_scope`, `reviewed_by`, `meta_title`, `accident_phrase`, `pa_office_key`, `translation_*`, `subtype_hidden`, `common_injuries`, `common_causes`, `why_hire`, `pillar_*_intro`, `glossary_terms`) | absent from `content/meta.json` for this page (regenerated 2026-10-23 in #268). Only `_roden_faqs` is set. | 0 |
| Rendered page text (live) | body, FAQs, theme blocks | 0 outside FAQ 5. The only deadline wording on the page is the body sentence above and FAQ 5. |

**Visibility limit:** a `_roden_*` key outside the export whitelist cannot be seen without SSH, and SSH was out of scope for this run. The live render shows no other deadline text, so if such a key exists, it is not rendering a claim.

**Sitewide check:** I ran the same class search across all 645 exported documents (body, excerpt, every exported meta field, EN and ES). It found only 4574 FAQ 5. The nursing-home pages that pair abuse with deadlines (3619, 4163, 4348, ES 4897) state the ordinary periods and are not this class. The separate § 15-3-535 and § 15-51-20 problem in 4348 FAQ 4 is still open from the 10-21 plan. Page 4574 has no Spanish twin.

---

## F1. FAQ 5 says limitation rules "for abuse survivors often extend the window" (ERROR)

- **URL / surface:** /class-action-lawyers/troubled-teen-industry-abuse/, `_roden_faqs[4]` (FAQ 5, "I was abused years ago — is it too late to file?"). The same text is published in the FAQPage JSON-LD.
- **Rule that caught it:** `abuse-sol-extension-overbroad` (GA pack, severity error).
- **Why it is wrong:** The extended limitation periods in both states cover **sexual abuse only**: O.C.G.A. § 9-3-33.1 (childhood sexual abuse) and S.C. Code § 15-3-555 (sexual abuse or incest). This page's own abuse list includes physical abuse, starvation, isolation, neglect, chemical restraints and hard labor. Those claims run on the ordinary periods (§ 9-3-33, two years; § 15-3-530, three years), with minority tolling. A survivor who reads this answer may believe they have time they do not have.
- **As published (exact stored string, `_roden_faqs[4].answer`):**

  ```
  It may not be too late. <strong>Statute-of-limitations rules for abuse survivors often extend the window to come forward</strong>, and these rules vary by state and circumstances. Because timelines can be complicated, we encourage you to reach out for a confidential consultation rather than assuming your time has passed. An attorney can review your situation and explain the options that may still be available to you.
  ```

- **Exact-match needle** (the part replaced; the last two sentences stay as they are):

  ```
  It may not be too late. <strong>Statute-of-limitations rules for abuse survivors often extend the window to come forward</strong>, and these rules vary by state and circumstances.
  ```

### Correction A: ship now (recommended)

```
It may not be too late, but some claims may already have expired. <strong>Filing deadlines depend on the kind of claim and the state where it is filed</strong>, and they are strict.
```

The full answer after the fix:

> It may not be too late, but some claims may already have expired. **Filing deadlines depend on the kind of claim and the state where it is filed**, and they are strict. Because timelines can be complicated, we encourage you to reach out for a confidential consultation rather than assuming your time has passed. An attorney can review your situation and explain the options that may still be available to you.

- **Authority:** SC 15-3-530 (signed for Roden). GA 9-3-33 is the pack entry for the Georgia side and is **unsigned for Roden**. The sentence names no period, no statute and no extension. It says only that deadlines are strict and depend on the claim and the state. It removes the false claim without adding a new one. It also lines FAQ 5 up with the body ("may have expired or be close to expiring").
- **Replay:** clean. This is fixture control `ctrl-tti-faq5-interim`, identical to the interim wording in the 10-21 plan.

### Correction B: only after sign-off (do not ship yet)

This is the version that names sexual abuse as the only extended category. It ships only once Tyler Love signs GA 9-3-33.1 and GA 9-3-33 for Roden and Gillin signs SC 15-3-555.

```
It may not be too late, but it depends on what happened. <strong>In Georgia and South Carolina, the longer filing periods written for abuse survivors cover sexual abuse only</strong>; claims for physical abuse, neglect and other mistreatment generally follow the ordinary personal-injury deadlines, which are short.
```

- **Authority:** GA 9-3-33.1 and SC 15-3-555 (pending, **UNSIGNED**). GA 9-3-33 (unsigned for Roden). SC 15-3-530 (signed).
- **Why it waits:** "cover sexual abuse only" is a new claim, and its only support is two unsigned authorities. It also leaves out minority tolling (GA 9-3-90, SC 15-3-40) and Georgia's criminal-prosecution tolling (GA 9-3-99). Under those, a physical-abuse claim can sometimes run longer than the bare two or three years. That is why the sentence says "generally", and why the attorney should decide whether to say it outright. The longer statute-specific version in the 10-21 plan ("after sign-off", fixture `ctrl-tti-faq5-signed`) is still the option if the attorneys want the figures on the page.
- **Replay:** clean under `both`, `georgia-only` and `south-carolina`. It has no fixture control yet. Add one to `law/fixtures/roden-abuse-sol-2026-10-21.json` before it ships.

### Apply path (when the owner says go; not done here)

Use the `bin/apply-faq-remediation.php` pattern: an exact-match `str_replace` of the needle above on `_roden_faqs[4].answer`, written with `update_post_meta( …, wp_slash( … ) )`. Do not use `preg_replace`, and do not put a `$` in the replacement (correction A contains none). Set `_roden_content_modified`. Afterwards:

1. Re-read `_roden_faqs` and the live FAQPage JSON-LD; both must carry the new text.
2. Run `bin/check-unslashed-post-writes.php` against the live site.
3. Regenerate `content/meta.json`.
4. Re-run `sweep-claims.mjs --client roden --fresh` and block on any error-level finding.

The owner's 2026-10-21 instruction not to pull the FAQs still holds: this edit changes one sentence and removes no FAQ.

---

## Counts by rule

| Rule | Findings on page 4574 | Severity |
|---|---|---|
| `abuse-sol-extension-overbroad` (GA) | 1 (F1, FAQ 5 + JSON-LD) | error |
| `physical-abuse-extended-sol`, `sc-abuse-sol-extension-overbroad`, `sc-physical-abuse-extended-sol` | 0 | — |
| manual claim-class sweep, other surfaces | 0 | — |

## False positives

None. F1 is a true error, and no rule was weakened or changed.

## Needs an attorney's read before it ships

1. **Correction A:** Tyler Love (GA) and Graeham C. Gillin (SC) should confirm "they are strict" and "some claims may already have expired". Both are general statements, and Gillin's signed SC 15-3-530 supports them. On the Georgia side no Roden signature exists yet.
2. **Correction B:** cannot ship until GA 9-3-33.1 and GA 9-3-33 are signed for Roden and SC 15-3-555 is signed. The attorneys also need to decide whether to mention minority tolling (GA 9-3-90, SC 15-3-40) and GA 9-3-99, all pending.
3. **§ 9-3-33.1(c) entity proof:** claims against a facility need negligence (age-23 route) or gross negligence plus knowledge and no remedial action (discovery route). Tyler Love should decide whether FAQ 5 should say so. It is not drafted in.
4. The rest of the 10-21 plan (F3 statistic, F4 forum and licensure, F5 framing, F6 Rule 7.1/7.2 items) is unchanged and still waiting.
