# Pre-publish legal sweep: Truck-Crash Deaths in South Carolina, 2020–2024 (DRAFT, post 6465)

- **Draft:** post **6465**, `resource`, status `draft`, slug `south-carolina-truck-crash-deaths-2020-2024`.
- **Intended URL:** `/resources/south-carolina-truck-crash-deaths-2020-2024/`
- **Post meta on production (complete list, read 2026-11-03):**
  - `_roden_author_attorney` 3732 (Graeham C. Gillin)
  - `_roden_jurisdiction` `sc`
  - `_roden_meta_title`
  - `_roden_meta_description`
  - `_roden_last_refreshed` 2026-11-03
  - `_roden_dataset_url` …/2026/11/sc-truck-fatal-crashes-2020-2024.csv
- **Taxonomy:** `practice_category` truck-accidents (term 662).
- **CSV:** attachment 6466, `text/csv`, parent 6465. The served file's sha256 is `fbd3977c…5a0b`, the same as `research/sc-truck-fatal-crashes-2020-2024.csv`.
- **Plan entry:** `content-plan/2026-11.md`, entry 3, done-when 2.
- **Swept:** 2026-11-03 by legal-accuracy-lead. Production was read only: `wp post get`, `wp post meta list`, `wp post term list`, and an `eval-file` that renders `single-resource.php` into a buffer. Nothing was written to production. No draft, research file or law pack was edited. Nothing was committed.
- **Law packs:**
  - SC: `internal-ai-scripts/law/SC.json` @ `08e6bd9`, unchanged since `e367d7c`. Signed by Graeham C. Gillin on 2026-09-26; 50/50 authorities verified. Roden's `law-signoff.json` does not declare SC, so the pack signature counts for Roden.
  - GA: loaded only for the cross-jurisdiction check. It is **UNSIGNED for Roden** (0/33). This page states no Georgia law, so that does not affect it.

## Verdict: PASS-with-items

1. **Legal accuracy.** The page states no law on any surface its content controls: body, excerpt, title, meta title, meta description and Article schema. It also implies no legal conclusion: no fault, liability, negligence, "you can sue", compensation or deadline.
   - The body explicitly disclaims fault: "Involvement is not fault … The data does not say who caused it."
   - There is no comparison with Georgia.
   - The engine reported 0 findings and 0 warnings on all 13 surfaces.
2. **Template blocks.** The law the template adds is the Filing Deadlines sidebar: "3 years (S.C. Code § 15-3-530)" and "Modified — recover if less than 51% at fault".
   - Both are correct for a South Carolina truck-crash page, and both match the signed pack (`SC 15-3-530`, `Nelson v. Concrete Supply Co.`).
   - Nothing on the page contradicts them.
   - No Georgia law renders. "Georgia" appears only in firm-wide boilerplate and in two related-guide link titles (I1).
3. **Review claim.** No review is claimed. No "Last reviewed" line renders, and the schema carries no `lastReviewed` or `reviewedBy`.
4. **One non-legal accuracy item (N1).** The page says three times that the analysis code is "published", but the page links only the CSV. It does not block the legal sign-off. I recommend the owner resolve it before publish (options below).
5. **One theme defect found while testing (T1).** It does not affect this page, because this page needs no per-page deadline override. It **does** affect the fix proposed today for the SC medical malpractice draft (R1 in `remediation-2026-11-03-sc-medmal-draft.md`), so that fix needs changing before that page publishes. See T1.

**Nothing in the legal layer blocks publishing this page.** Before publish:

1. Owner decision on N1.
2. Record the review: 6465, graeham-c-gillin, 2026-10-26, sc, through `bin/record-attorney-reviews.php`.
3. Re-render after publish and check that the "Last reviewed" line and `lastReviewed` appear.

---

## 1. Per-surface coverage proof

### How the sweep was run

- **Source.** Every surface was read from production (post 6465), not from `research/`.
  - The production body differs from `research/sc-truck-study-body.html` in one place only: the dataset href (`/2026/10/` → `/2026/11/`). This is the expected difference.
- **Rendering.** The rendered surfaces come from a server-side render of the draft. The render ran a `WP_Query` for `p=6465, post_status=draft` and included `single-resource.php` into an output buffer (`is_singular('resource')` = true).
  - The render script writes nothing.
  - The theme's only render-path write, `roden_maybe_flush_rewrites()`, runs on every WP-CLI call and only acts when its version string changes.
- **Fixture files.** Each surface is a separate fixture entry.
  - Surfaces the fixture replay has no slot for (title, meta title, rendered blocks, schema) are replayed as `body` text in the fixtures, and as `extra.<surface>` in the one-document run.
  - Files, all in `/private/tmp/claude-501/-Users-brianhaas-Code-blue-sky-studio-client-rodenlaw-website/0aec253d-7aff-46aa-9cf9-046f7c8b1d26/scratchpad/truck/`:
    - `fx-clean.json`
    - `fx-planted.json`
    - `surfaces.json`
    - `render-6465.html`
    - builders `build.py` and `run-doc.mjs`

**Results:**

| Run | Result |
|---|---|
| `sweep-claims.mjs --fixtures fx-clean.json` | **13/13 expectations met, 0 findings** (exit 0) |
| `sweep-claims.mjs --fixtures fx-planted.json` | **12/12 expectations met**. Every planted sentence was caught on its surface (see the table below) |
| One-document clean (`sweepDocument`, all 13 surfaces, SC+GA packs) | **0 findings, 0 warnings** |
| One-document, GA cite planted in the sidebar | `cross-GA-on-SC` warning on `filingDeadlinesSidebar`. A Georgia statute on this page would be seen |
| One-document, sidebar quantity changed to "2 years (S.C. Code § 15-3-530)" | `authority-quantity` warning `SC 15-3-530` on `filingDeadlinesSidebar`. So the clean run's silence on "3 years (S.C. Code § 15-3-530)" means the cite was parsed and matched the pack, not that it went unread |

### What each surface contains, and the plant that proved it was read

The planted sentences exist only in the scratchpad fixtures. None was written to production.

| Surface | What it contains | Planted false sentence | Rule that fired |
|---|---|---|---|
| Title (`post_title`; also schema `headline`, breadcrumb) | "Truck-Crash Deaths in South Carolina, 2020–2024: What the Federal Crash Data Shows". No law | "South Carolina has no statutory cap on punitive damages." | `sc-punitive-cap-denied` |
| Meta title (`_roden_meta_title`; `<title>`, `og:title`) | "South Carolina Truck-Crash Deaths, 2020–2024: Data Study". No law | same | `sc-punitive-cap-denied` |
| Meta description (`_roden_meta_description`; `description`, `og:`, `twitter:`) | 669 deaths, 601 crashes, 64% rural, NHTSA data, dataset. No law | "A claim against SCDOT under the Tort Claims Act must be filed within three years." | `sctca-three-year-default` |
| Excerpt (`post_excerpt`, published as the BlogPosting `description`) | 669/601, 12.0%, 86% outside the truck, 64% rural, "with the dataset and code published" (N1). No law | punitive plant | `sc-punitive-cap-denied` |
| Body (`post_content`, 7,761 chars of text) | Statistics, two tables, the "What this does and doesn't show" caveats including "Involvement is not fault", the "After a truck crash" paragraph, methodology, data. No statute, no deadline, no fault rule, no Georgia | TCA plant | `sctca-three-year-default` |
| Rendered hero (byline bar) | Gillin, "Partner, COO", date, "5 min read", "Content updated: November 3, 2026" (I2). **No "Last reviewed"** | punitive plant | `sc-punitive-cap-denied` |
| Rendered article (body after `the_content`, charts, CTA banner, author box) | Body as above; chart captions are figures only; CTA "Free Case Review — No Fees Unless We Win / Available 24/7 · Georgia & South Carolina" | TCA plant | `sctca-three-year-default` |
| Filing Deadlines sidebar | "South Carolina — Statute of Limitations: 3 years (S.C. Code § 15-3-530); Comparative Fault: Modified — recover if less than 51% at fault; Deadlines may vary. Contact us for case-specific guidance." | GA cite / wrong quantity (one-document run) | `cross-GA-on-SC` / `authority-quantity` (warnings) |
| Whole sidebar (form, deadlines, Related Guides, Related Resources, Why Roden) | See I1 for the link titles; trust stats | punitive plant, prepended¹ | `sc-punitive-cap-denied` |
| Author box (`roden_author_attribution`) | Gillin, "Partner, COO", bar admissions "South Carolina \| North Carolina \| … ", bio excerpt. No law | punitive plant | `sc-punitive-cap-denied` |
| Article schema (BlogPosting `headline` + `description`) | Identical to the title and excerpt. No FAQPage, no DefinedTermSet, no `lastReviewed` | TCA plant | `sctca-three-year-default` |
| Page header | Site navigation, "Serving Georgia & South Carolina", "No Fees Unless We Win". Site-wide | punitive plant | `sc-punitive-cap-denied` |
| Page footer | Offices, site-wide disclaimers. Site-wide | hit-and-run plant² | `sc-hit-and-run-25-years-injury` |

¹ ² Placement, not blindness:
- ¹ Appended at the end, the punitive plant sat next to "Georgia & South Carolina". The rule's `unless: georgia` guard reads that as a Georgia contrast and correctly stayed silent. Prepended to the same surface, it fired.
- ² The TCA plant appended after the footer's last line was likewise suppressed by context. The footer was proven with the hit-and-run rule instead.
- Both are the designed behaviour of the `unless` guards, not a gap. No rule was changed.

**FAQs and key takeaways: none.** Confirmed three ways:
- `_roden_faqs` and `_roden_key_takeaways` are absent from `wp post meta list 6465`, which returns 6 keys in total.
- The render contains no `key-takeaways-box` and no FAQ section.
- The page emits no FAQPage JSON-LD.

The page also has no `_roden_see_also`, so no "Related Pages" block renders.

### Legal-conclusion check (body, excerpt, titles, meta, schema)

I ran a vocabulary scan for fault, liability, negligence, sue, lawsuit, claim, compensation, damages, statute, deadline, §, Georgia, cause, responsible, law/legal, rights, settle, insurance and recover. It hit only:

- **"Involvement is not fault. … The data does not say who caused it. A truck-involved crash may have been caused by the truck driver, by another driver, by the road or by the conditions."** This disclaims fault and is correct to keep.
- **"Roden Law's South Carolina truck accident lawyers and our Charleston truck accident team can explain your options."** An offer to explain, not a legal conclusion.
- "code" (FARS body-type code, route coding, analysis code). Not law.

The "After a truck crash" advice is practical, not legal: medical care first, keep photographs and paperwork, be careful about giving statements. It promises nothing and states no deadline.

Two data definitions, checked as facts rather than law:
- "died within 30 days" is the FARS inclusion criterion.
- "over 10,000 pounds gross vehicle weight rating" is NHTSA's large-truck definition. It matches body types 60–79 in the methodology, and type 67 is the medium/heavy pickup.

---

## 2. Findings

### No legal findings

There is no error-level or warning-level legal finding on any surface. The remaining items are below.

### Template blocks: what they print, and whether it is right for this page

| Block | Prints on 6465 | Correct? |
|---|---|---|
| `roden_filing_deadlines_sidebar()` (jurisdiction `sc` → SC only) | "Statute of Limitations: 3 years (S.C. Code § 15-3-530)" | **Yes.** The three-year limit covers both claims a fatal truck crash raises: personal injury under § 15-3-530(5), which runs from discovery under § 15-3-535, and wrongful death under § 15-3-530(6), which runs from the death. I read the primary text at scstatehouse.gov/code/t15c003.php today. So the sidebar holds for the deaths this page counts. Pack `SC 15-3-530` (signed). The resolver applies no override, because the post is a `resource` and no `_roden_sol_sc` is set, and none is needed. The page's other surfaces state no deadline, so nothing contradicts it. A claim against a government entity is shorter (two years, `SC 15-78-110`). The sidebar's own line "Deadlines may vary. Contact us for case-specific guidance." covers this, and the page says nothing about government defendants. |
| same block | "Comparative Fault: Modified — recover if less than 51% at fault" | **Yes.** Pack `Nelson v. Concrete Supply Co.` (signed): recovery is allowed at 50% or less. This is a general statement of the rule, not a conclusion about these crashes, and it sits beside a body that says the data assigns no fault. No conflict. |
| `roden_inline_cta_banner()`, header, footer, "Why Roden" | "No Fees Unless We Win", "Georgia & South Carolina", $300M+, 4.9, 170+ reviews, 6 offices | Site-wide marketing and firm identity, not law. Out of scope for this page. |
| `roden_author_attribution()` | Gillin's bar admissions, including **South Carolina** | Consistent with an SC page. When the review is recorded, `roden_page_reviewers()` will name him: he is admitted in SC, the only state the page covers. |
| `roden_schema_article()` | BlogPosting: headline = title, description = excerpt, author Person Gillin, `mainEntityOfPage` WebPage **without** `lastReviewed`/`reviewedBy` | Correct for an unreviewed draft. |
| Georgia anywhere | No Georgia statute, deadline or rule renders. "Georgia" appears only in firm-wide text and two link titles (I1). | Correct. |

### N1 — "the analysis code is published", but the page links no code (non-legal accuracy; owner decision before publish)

**Surfaces and the sentences as published:**
1. **Body, paragraph 2:** "The crash-level data file and the analysis code are published with it, so every figure below can be checked."
2. **Body, Methodology:** "**Reproducing this.** The analysis script is published with the report. Point it at the extracted FARS files and it regenerates every number here, and the dataset below."
3. **Excerpt**, and so the BlogPosting `description`: "Analysis of NHTSA FARS data, with the dataset and code published."

**What renders:**
- The page links the CSV (attachment 6466, which downloads and matches `research/` by sha256) and NHTSA. It links no script.
- The script is `bin/truck-study-analysis.py`. It is on `main` of `rodenlaw/roden_law_theme`, which is a **public** repository, so it does exist publicly. But a reader of this page cannot find it.
- The live I-26/I-95 Corridor Report (Study #1) has the same pattern: it says the analysis code is published and links no script.

**Why it is not mine to block:** it is not a statement of law. But it is a factual claim made on three surfaces that the rendered page does not back. The page's own methodology invites readers to reproduce the figures, so a missing script is the first thing a checking journalist would notice.

**Options (owner's call; none applied):**
- **(a) Keep Gillin's approved wording exactly, and add one link.** Make "analysis script" in the Methodology sentence link to the script.
  - Either upload `bin/truck-study-analysis.py` as a media attachment, as the CSV was, or link the public GitHub blob.
  - This changes markup only. The words Gillin approved on 2026-10-26 stay the same, so the review date still describes the text.
  - Apply the same link to the Corridor Report afterwards.
- **(b) Drop the claim.** Change the three sentences to "…the crash-level data file is published with it…", "The analysis script is available on request…", and "…with the dataset published."
  - This is a word change to the approved body. Under the plan's own rule ("If the body changes before publish, this date no longer holds") it needs Gillin's re-approval before `_roden_last_reviewed` 2026-10-26 can be recorded.

### I1 — Two related-guide link titles name Georgia (informational; no change)

The sidebar's "Related Guides" list is filtered to the same state, plus pages tagged `both`. It renders:
- "The I-26 / I-95 Corridor Report: Fatal Truck Crashes in Georgia and South Carolina, 2020–2024"
- "I-95 Widening Construction Zone: Georgia-South Carolina Border"

These are titles of other pages, not a comparison with Georgia, and not Georgia law. The plan's "no comparison with Georgia" applies to this page's content, which complies. I note them only so nobody is surprised at the live check.

### I2 — "Content updated: November 3, 2026" will precede the publish date (informational; not a review claim)

- The seeder sets `_roden_last_refreshed` to the seed date (`bin/seed-sc-truck-study.php`, line 185), and the hero prints it as "Content updated: November 3, 2026".
- If the page publishes on a later day, the byline will show a publish date after its "Content updated" date.
- It is not a review claim, and it is not law.
- If the owner prefers, set `_roden_last_refreshed` to the publish date, or clear it, at publish time.

### T1 — Theme: the per-page deadline override is ignored when `_roden_jurisdiction` is lower-case (no effect on 6465; **changes the SC med-mal R1 fix**)

`roden_filing_deadlines_sidebar()` (`inc/template-tags.php`, about lines 3213–3290) builds `$states` from the raw meta value. It then tests `'SC' === $state_key && $sol_sc_override` case-sensitively. `roden_resolve_statute()` upper-cases its argument, so the state row still renders, but **the `_roden_sol_sc` / `_roden_sol_ga` override is skipped whenever the stored value is `sc` or `ga`.**

**Proven by render, in memory only:**
- I injected `_roden_sol_sc` = `PLANTED-SOL-SC-OVERRIDE` through a `get_post_metadata` filter inside the render script, with no database write.
- With `_roden_jurisdiction` `sc` (as stored), the sidebar still printed "3 years (S.C. Code § 15-3-530)".
- With the jurisdiction also filtered to `SC`, it printed the override.

**Consequences:**
- **This page:** none. § 15-3-530 is the correct default, and no override is needed.
- **The SC medical malpractice draft (R1 in `data/facts/remediation-2026-11-03-sc-medmal-draft.md`):** that page's post meta is `_roden_jurisdiction` **sc**. Setting `_roden_sol_sc` alone, as R1 proposed, **would not change the sidebar**: it would still publish the tort statute on a malpractice page. Corrected R1 fix, either of:
  - **(i)** store `_roden_jurisdiction` **`SC`**, the value the editor meta box writes, together with `_roden_sol_sc` = "3 years from the treatment or discovery, no more than 6 years (S.C. Code § 15-3-545)"; then re-render and confirm before publish; or
  - **(ii)** a theme fix: normalise `$state_key` with `strtoupper()` before the override comparison, so lower-case values work. This is a one-line theme change, a PR, and a `style.css` bump is not needed (PHP only).
- **Related, for the owner (live, not this page):**
  - `content/meta.json` holds seven spellings of `_roden_jurisdiction`: `both`, `SC`, `sc`, `GA`, `ga`, `south-carolina`, `south-carolina-only`, `georgia-only`.
  - On a `resource`, `south-carolina-only` and `georgia-only` resolve to no state at all. The live Filing Deadlines box then shows only "Deadlines may vary." Verified on `/resources/south-carolina-helmet-laws/`.
  - Ten published resources do this, including `/resources/georgia-statute-of-limitations/`, which also carries a `_roden_sol_ga` that never shows.
  - This is an omission, not a false statement. It is a candidate for the same theme fix, which would map the spellings the way `roden_page_jurisdiction_states()` in `inc/schema-helpers.php` already does.

---

## 3. Byline and review claim (task item 4)

- **No review fields.** `_roden_last_reviewed` and `_roden_reviewed_by` are not set.
- **No review rendered.** `roden_last_reviewed_html()` returns '' (no `post-reviewed` element in the render), and `roden_schema_review_fields()` returns nothing, so the WebPage node carries no `lastReviewed` and no `reviewedBy`.
- **The byline is authorship only.** It shows author Gillin (Partner, COO) and the post date. It claims no review.
- **Next step:** record the 2026-10-26 approval with `bin/record-attorney-reviews.php` (6465, graeham-c-gillin, 2026-10-26, sc). The bar-admission guard will pass: Gillin is admitted in South Carolina, and the page's jurisdiction is `sc`.
- **Caveat:** the date holds only if the body words are unchanged. Option N1(a) keeps them unchanged; N1(b) does not.

## 4. Counts

| Rule / check | Findings on 6465 |
|---|---|
| Pack rules (SC 18, GA) | 0 |
| Pairings | 0 |
| Authority quantity | 0 (one cite parsed: `SC 15-3-530`, 3 years, matched) |
| Cross-jurisdiction | 0 |
| Manual: legal conclusion in body/excerpt | 0 |
| Manual: template blocks wrong for this page | 0 |
| Manual: review claimed without a record | 0 |
| Non-legal accuracy (N1) | 1 claim class, 3 surfaces |
| Theme defect found (T1) | 1. No effect here; it changes the med-mal R1 fix |

**False positives proposed for a pack PR:** none. The two plants that stayed silent when appended next to "Georgia & South Carolina" are the intended `unless` behaviour, not false negatives on real text.
