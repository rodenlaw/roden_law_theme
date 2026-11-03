# Pre-publish legal sweep: South Carolina medical malpractice law (DRAFT)

- **Draft:** `data/practice-area-drafts/2026-11/south-carolina-medical-malpractice-law.md`
- **Intended URL:** `/resources/south-carolina-medical-malpractice-law/`
- **Post meta:** `resource`, `_roden_jurisdiction` sc, `practice_category` medical-malpractice. Author Graeham C. Gillin.
- **Plan entry:** `content-plan/2026-11.md`, entry 1.
- **Swept:** 2026-11-03 by legal-accuracy-lead. Read-only. Nothing published, no draft or pack edited, no wp/ssh writes.
- **Law packs:**
  - SC: `internal-ai-scripts/law/SC.json` @ `e367d7c`. Signed by Graeham C. Gillin on 2026-09-26, 50/50 authorities, 0 pending. Roden's `law-signoff.json` does not declare SC, so the pack signature counts for Roden.
  - GA: loaded for the cross-jurisdiction check only. It is **UNSIGNED for Roden** (`law-signoff.json`, 0/33), but this page cites no Georgia authority, so that does not affect this page.

## Verdict: PASS-with-items

1. **Draft text.** The draft states no South Carolina law wrongly at error level, and it states no Georgia law.
   - The engine returned 0 findings and 0 warnings on every surface.
   - I traced every legal statement by hand. 27 of 40 claims trace to the signed pack and match primary text I read today.
   - Four sentences are incomplete or broader than the statute (W1–W4 below). They should be corrected before publish. None of them shortens a deadline or understates a cap to the reader's harm.
2. **Rendered page.** The page **as it would be built** carries one error-level item that is not in the draft (R1). The resource template's Filing Deadlines sidebar would publish "Statute of Limitations: 3 years (S.C. Code § 15-3-530)", which is the tort statute, on a medical malpractice page. Set `_roden_sol_sc` before publish.
3. **Publish path.** Two publish-path defects (P1, P2) block the documented publish route until fixed.
4. **VERIFY tags.** V1-1 and V1-3 match primary text word for word. V1-2 is not a statement of law. All three stay open for Gillin.

**Nothing ships until:** R1 fixed, P1 and P2 fixed, W1–W4 applied (or rejected by Gillin), V1-1 to V1-3 closed by Gillin, and the rendered page re-swept after seeding as a draft.

---

## 1. Per-surface coverage proof

### How the sweep was run

- **Surface split.** The draft was split into the surfaces the seeder publishes. The split mirrors `bin/build-resource-seed.py`: body = everything except "Key Takeaways" and "Frequently Asked Questions", with the "Last reviewed:" line and H1 stripped. Link URLs were removed so only anchor text is swept.
- **Fixture files.** Each surface became a separate fixture entry, and each key takeaway and each FAQ became its own entry.
  - Clean fixture: `fx-clean.json`
  - Planted fixture: `fx-planted.json`, the same entries plus one known-false SC sentence per surface
  - Builder: `tools/build-fixture.mjs`
  - All three are in the session scratchpad, `/private/tmp/claude-501/-Users-brianhaas-Code-blue-sky-studio-client-rodenlaw-website/0aec253d-7aff-46aa-9cf9-046f7c8b1d26/scratchpad/`.
- **Two runs:**
  - `node scripts/facts/sweep-claims.mjs --fixtures <file>`, which reports findings per entry.
  - A one-document run through `sweepDocument()`, which also reports warnings and sweeps the title (the fixture replay cannot carry a title).

**Results:**

| Run | Result |
|---|---|
| Clean fixture | **16/16 expectations met, 0 findings** (exit 0) |
| Planted fixture | **16/16 expectations met**. Every planted sentence was caught on its surface (exit 0, because the hits were expected) |
| One-document clean (all surfaces + title) | **0 findings, 0 warnings** |
| One-document planted | **6 findings, one per surface**, listed below |
| Engine sanity checks | A wrong quantity on `§ 15-79-125` ("45 days") and on `§ 15-3-530` ("two years") raised authority-quantity warnings. An `O.C.G.A. § 9-3-71` cite on an `sc` page raised `cross-GA-on-SC`. So "0 warnings" on the draft means the cite parser read the citations and found nothing, not that it saw none |

### Planted sentences (removed afterwards; the draft was never edited)

| Surface | What it contains in the draft | Planted false sentence | Rule that fired |
|---|---|---|---|
| Title | Topic only: Notice of Intent, expert affidavit, deadlines, damages cap. No figure | "Punitive damages are capped at three times compensatory damages or $500,000." | `sc-punitive-floor-unindexed` |
| Excerpt (`post_excerpt`, published as the Article `description`) | NOI with expert affidavit and mediation before suit; mentions the deadlines and the 2026 cap, with no figures | "South Carolina does not cap medical malpractice damages." | `sc-medmal-cap-denied` |
| Meta description (`_roden_meta_description`) | NOI, expert affidavit, mediation, "the three-year deadline", "the 2026 non-economic damages cap" | "Punitive damages are capped at three times compensatory damages or $500,000." | `sc-punitive-floor-unindexed` |
| Body (`post_content`, 10,446 chars of text) | Lead paragraph; definition; the pre-suit steps table; the expert affidavit; § 15-79-125(E); the deadline table; damages and the cap table; the CPI memo; exceptions; punitive damages; Tort Claims Act, charitable cap, emergency care, informed consent, comparative fault, wrongful death and survival; CTA; author box | "South Carolina does not cap medical malpractice damages." (appended after the author box, so the end of the body was read) | `sc-medmal-cap-denied` |
| Key takeaways (`_roden_key_takeaways`, 6 bullets joined as prose) | NOI + affidavit; tolling and the 90–120-day mediation; 3 years / 6 years / foreign object / minors; 2026 cap figures, economic damages not capped; cap exceptions; Tort Claims Act 2 years and limits | "South Carolina does not cap medical malpractice damages." in bullet 1 | `sc-medmal-cap-denied` |
| FAQs (`_roden_faqs`, also FAQPage structured data; 6 pairs) | Q1 NOI; Q2 deadlines; Q3 cap; Q4 mediation; Q5 public hospital (TCA); Q6 fees | "South Carolina does not cap medical malpractice damages." in FAQ 1 | `sc-medmal-cap-denied` |

**Frontmatter that does not render:** `draft_status`, `primary_keyword`, `word_count`, `internal_links`, `schema_feeds`, `page_type`, `target_url`, `suggested_slug`. Nothing to sweep.

- `_roden_author_attorney` becomes an attorney post ID in the seeder, not text.
- `draft_status` contains no law.

**FAQ text and FAQ structured data agree by construction.** `roden_faq_section()` and the FAQPage schema both read `_roden_faqs`.

### Surfaces the engine cannot see: rendered template blocks

I read `single-resource.php` and the helpers it calls.

| Block | Legal content on this page | Status |
|---|---|---|
| `roden_filing_deadlines_sidebar()` | **"Statute of Limitations: 3 years (S.C. Code § 15-3-530)"** and "Comparative Fault: Modified — recover if less than 51% at fault" | **R1, error.** See below |
| `roden_last_reviewed_html()` | Renders `_roden_last_reviewed` | **P2.** The converter hard-codes `2026-09-19` |
| `roden_inline_cta_banner()`, `roden_contact_form_sidebar()`, `roden_why_roden_sidebar()` | "No Fees Unless We Win", Georgia & South Carolina, trust stats | No statement of law |
| `roden_author_attribution()` | Gillin's bar admissions from the attorney post | No statement of law |
| Related guides / resources | Titles of other SC resources | Not swept here; already covered by the 2026-11-03 live sweep (PASS) |

---

## 2. Findings

### R1 — Filing Deadlines sidebar cites the tort statute on a medical malpractice page (error; rendered surface, not in the draft)

- **Surface:** the sidebar on `/resources/south-carolina-medical-malpractice-law/`, from `roden_filing_deadlines_sidebar()`.
- **As it would publish:** "South Carolina — Statute of Limitations: 3 years (S.C. Code § 15-3-530)"

**Why it would publish:**

1. `roden_resolve_statute()` applies the `medical-malpractice-lawyers` override (§ 15-3-545) only when `roden_current_pa_slug()` resolves a pillar.
2. `roden_pa_pillar_post()` returns `null` for any post that is not a `practice_area`, so a `resource` always falls back to the SC base row (`S.C. Code § 15-3-530`, `inc/firm-data.php`).
3. The `practice_category` term does not change this.
4. The seeder does not set `_roden_sol_sc`.

Confirmed on the live SC resource `/resources/south-carolina-comparative-negligence/`, whose sidebar reads "3 years (S.C. Code § 15-3-530)". That is correct there and wrong here.

This is the same error class as finding E1 on the Charleston medical malpractice page (2026-09-28), and it would contradict the page's own body, deadline table, key takeaway 3 and FAQ 2.

**Fix (meta only, no theme change):** set `_roden_sol_sc` in the seed payload to:

> 3 years from the treatment or discovery, no more than 6 years (S.C. Code § 15-3-545)

- **Authority:** `SC 15-3-545`, signed pack, read today at https://www.scstatehouse.gov/code/t15c003.php, § 15-3-545(A).
- **Rule that caught it:** none. The engine cannot see template output; the problem was found by reading the template. A proposed pack pairing is below (PK-6).
- **Theme follow-up for the owner:** a theme fix that lets resources resolve the override from `practice_category` would close this class for every future medical malpractice or workers' comp resource. That is a theme decision, separate from this page.

### W1 — Expert qualification sentence omits the statute's third route and overstates "must be licensed" (should fix)

- **Surface:** body, "The expert affidavit".
- **As drafted:**
  > According to the South Carolina Legislature's [text of S.C. Code § 15-36-100](https://www.scstatehouse.gov/code/t15c036.php), the expert must be licensed, and either board certified in the specialty the opinion concerns, or have practised or taught in that specialty for at least three of the last five years immediately before giving the opinion.
- **What § 15-36-100 actually says** (primary text read 2026-11-03, t15c036.php):
  - (A)(1)–(2) is the licensed route: board certified, or three of the last five years in practice. The teaching route requires at least half of professional time as employed faculty at an accredited institution.
  - **(A)(3)** adds a separate category: "an individual not covered by subsections (A)(1) or (2), that has scientific, technical, or other specialized knowledge which may assist the trier of fact". That expert's affidavit "must contain an explanation of the expert's credentials and why the expert is qualified".
  - So "must be licensed" is not the whole rule. The live blog says "must be licensed ... and usually qualifies through", which is closer.
- **Corrected sentence** (same register and citation format; one sentence added):
  > According to the South Carolina Legislature's [text of S.C. Code § 15-36-100](https://www.scstatehouse.gov/code/t15c036.php), the expert is usually a licensed professional who is board certified in the specialty the opinion concerns, or who has practised or taught in that specialty for at least three of the last five years immediately before giving the opinion. Another expert with the right specialized knowledge can qualify, but the affidavit must then explain the expert's credentials and why the expert is qualified.
- **Authority:** primary text § 15-36-100(A)(1)–(3), read today. The signed pack `SC 15-36-100` carries only (A)(1)–(2), so the pack claim is incomplete (PK-3).
- **Rule that caught it:** none (manual primary-text check).

### W2 — "every case needs an expert" ignores the statute's two exceptions (should fix; attorney question)

- **Surface:** body, "What counts as medical malpractice".
- **As drafted:** "That is why every case needs an expert, and why South Carolina makes you produce one before you file."
- **What § 15-36-100 actually says:**
  - (C)(1): if the limitation period will expire within ten days, the affidavit may follow within 45 days of filing.
  - (C)(2): no contemporaneous affidavit is required for "a pleaded specification of negligence involving subject matter that lies within the ambit of common knowledge and experience".
- **Corrected sentence:** "That is why almost every case needs an expert, and why South Carolina generally makes you produce one before you file."
- **Authority:** primary text § 15-36-100(C)(1)–(2), read today. Not in the pack (PK-3).
- **Question for Gillin:** do (C)(1) and (C)(2) carry into the § 15-79-125(A) Notice-of-Intent affidavit? § 15-79-125(A) makes the affidavit "subject to the affidavit requirements established in Section 15-36-100".
  - Until he answers, leave key takeaway 1, FAQ 1, FAQ 6 and the steps table as they are. They track the mandatory wording of § 15-79-125(A) ("shall contemporaneously file").
- **Rule that caught it:** none (manual).

### W3 — Nursing-home sentence applies "the rules below" more widely than the cited definition supports (should fix; open attorney item)

- **Surface:** body, "What counts as medical malpractice".
- **As drafted:** 'A "health care institution" includes a hospital, an ambulatory surgical facility and a **nursing home** (S.C. Code § 15-32-210(4)), so the rules below apply to nursing-home malpractice claims too.'
- **Why the scope is too wide:**
  - § 15-32-210 opens "As used in this article". It carries the cap to nursing homes, and nothing else.
  - The Notice of Intent chapter has its own identical definition, § 15-79-110(2) (read today). That one is not in the pack.
  - § 15-3-545(A) reaches a "licensed health care provider as defined in Article 5, Chapter 79, Title 38". That article (the Patients' Compensation Fund) was **repealed effective 2020-01-01** (read today at https://www.scstatehouse.gov/code/t38c079.php). Whether § 15-3-545, including its six-year repose, governs a claim against a nursing home is the open item recorded on 2026-09-26 ("SC nursing-home SOL").
- **Corrected sentence** (pack-backed citation only):
  > A "health care institution" includes a hospital, an ambulatory surgical facility and a **nursing home** (S.C. Code § 15-32-210(4)), so the damages cap below applies to nursing-home malpractice claims too.
- **Alternative after Gillin signs PK-2:** "...(S.C. Code §§ 15-32-210(4), 15-79-110(2)), so the Notice of Intent and the damages cap below apply to nursing-home malpractice claims too."
- **Authority:** `SC 15-32-220` (whose claim carries § 15-32-210(4)), plus primary text § 15-79-110(2).
- **Rule that caught it:** none (manual).

### W4 — The Tort Claims Act physician limit is per person *and* per occurrence (precision; should fix; two surfaces)

- **Problem:** both surfaces give "$300,000 per person ... or $1,200,000 per occurrence". A reader can take the per-person limit in a physician case to remain $300,000.
  - § 15-78-120(a)(3) sets **$1,200,000 per person** for a tort of a government-employed licensed physician or dentist.
  - § 15-78-120(a)(4) sets **$1,200,000 per occurrence** for the same.
  - Primary text read today at t15c078.php.
- **Body, Special rules / Government hospitals:**
  - As drafted: "...recovery is limited to $300,000 per person and $600,000 per occurrence, or $1,200,000 per occurrence where the harm was caused by a licensed physician or dentist employed by a governmental entity, and punitive damages are not available (S.C. Code § 15-78-120)."
  - Corrected: "...recovery is limited to $300,000 per person and $600,000 per occurrence, or $1,200,000 per person and per occurrence where the harm was caused by a licensed physician or dentist employed by a governmental entity, and punitive damages are not available (S.C. Code § 15-78-120)."
- **FAQ 5 answer** (also FAQPage):
  - As drafted: "...recovery is limited to $300,000 per person and $600,000 per occurrence, or $1,200,000 per occurrence for harm caused by a government-employed physician or dentist, and punitive damages are not available (S.C. Code § 15-78-120)."
  - Corrected: "...recovery is limited to $300,000 per person and $600,000 per occurrence, or $1,200,000 per person and per occurrence for harm caused by a government-employed physician or dentist, and punitive damages are not available (S.C. Code § 15-78-120)."
- **Authority:** `SC 15-78-120` (signed: "$1,200,000 for physicians and dentists"), plus primary text (a)(3)–(4).
- **Rule that caught it:** none (manual).

### Notes, no change required

- **N1, Nelson sentence.** "a patient whose own share of fault stays under 51% can still recover".
  - `Nelson v. Concrete Supply Co.` (signed) states the bar as "more than 50%", and the pack allows "51%".
  - The wording matches the live SC comparative-negligence resource ("less than 51% at fault — that is, 50% or less") and the sidebar ("recover if less than 51% at fault").
  - If Gillin prefers the exact holding: "a patient who is 50% or less at fault can still recover".
- **N2, mediation extension.** "a court may extend this by up to 60 days for good cause" matches § 15-79-125(C) ("based upon a finding of good cause").
- **N3, § 15-36-100 wording.** "must specify the negligent act or omission": the statute says "at least one negligent act or omission ... and the factual basis for each claim". Acceptable as a summary.
- **N4, § 15-78-120(a)(5).** It keeps a government physician personally liable for privately paid services. The draft's "a government-employed doctor follows the South Carolina Tort Claims Act" is right as a general rule. Gillin may want "generally".

---

## 3. Publish-path defects (not legal content; they block the plan's publish route)

### P1 — `bin/build-resource-seed.py` cannot read this draft's FAQs

- The converter's FAQ regex expects `**Q: question**` / `**A:** answer` (the 2026-09 drafts).
- This draft uses `**Q:** question`, a blank line, then `**A:** answer`.
- Run read-only today into the scratchpad, the converter parsed **0 FAQs** and stopped on `assert takeaways and len(faqs)>=6` (AssertionError). It fails loudly, not silently.
- Fix one or the other before publish: reformat the six FAQs to the converter's format, or widen the regex. Re-run this sweep on whichever payload results.

### P2 — The converter hard-codes `_roden_last_reviewed: '2026-09-19'`

- `bin/build-resource-seed.py` writes that date into every payload, and `single-resource.php` renders it as "Last reviewed".
- Published as-is, the page would claim an attorney review six weeks before it was drafted.
- Set it, and `_roden_reviewed_by`, to Gillin's actual review date (plan "Done-when" 4). Also add `_roden_sol_sc` (R1) to the payload's `meta`.

---

## 4. Claim table: every statement of South Carolina law in the draft

**Key to trace status:**

- **A:** in the signed SC pack and matches primary text I read in this session.
- **B:** in the signed SC pack only. Case law, not re-read today.
- **C:** primary text read today only; not in the pack.
- **D:** pack or primary-backed, but the draft's wording is incomplete or wider than the primary text (item above).
- **E:** traces to nothing.

**Surface key:** Bo = body, Ex = excerpt, MD = meta description, KT = key takeaways, F = FAQ.

**Primary sources read 2026-11-03:**

- scstatehouse.gov/code/ chapters: t15c079, t15c036, t15c032, t15c003, t15c078, t33c056, t15c051, t15c005, t15c033, t38c079.
- RFA memo of 2026-02-03. The draft's link (`rfa.sc.gov/sites/rfa/files/2026-03/...Memo signed.pdf`) resolves to the same file as `rfa.sc.gov/media/11477` (byte-identical; scanned, read as images).
- S.C. State Register Vol. 50, Issue 2, 2026-02-27, Notices p. 15.

| # | Claim (as the draft states it) | Surfaces | Authority id (pack) | Primary text read today | Status |
|---|---|---|---|---|---|
| 1 | Before suing, file a Notice of Intent to File Suit together with an expert affidavit | Bo intro, steps table, Ex, MD, KT1, F1, F6 | SC 15-79-125; SC 15-36-100 | § 15-79-125(A) "shall contemporaneously file" | A |
| 2 | In a county where venue would be proper | Bo table, F1 | SC 15-79-125 | § 15-79-125(A) | A |
| 3 | Serve the notice on all named defendants | Bo intro, table, F1 | SC 15-79-125 | § 15-79-125(A) | A |
| 4 | Filing the notice tolls all applicable statutes of limitations | KT2, Bo table, Bo deadlines | SC 15-79-125 | § 15-79-125(A) | A |
| 5 | Mediate within 90 days and no later than 120 days of service | KT2, Bo table, F4 | SC 15-79-125 | § 15-79-125(C) | A |
| 6 | A court may extend that by up to 60 days for good cause | Bo table, F4 | SC 15-79-125 | § 15-79-125(C) | A |
| 7 | If mediation fails, you may file the lawsuit | Bo table (E), F1, F4 | SC 15-79-125 | § 15-79-125(E) | A |
| 8 | Suit within 60 days after the mediator's impasse / not-viable / end determination, or before the limitation period runs, whichever is later | Bo (V1-3) | — (pack claim stops at "may then file") | § 15-79-125(E)(1)–(2), word for word | C |
| 9 | The affidavit must come from a qualified expert and specify the negligent act or omission | Bo | SC 15-36-100 | § 15-36-100(B) | A |
| 10 | Expert must be licensed, and board certified or 3 of last 5 years practising or teaching | Bo | SC 15-36-100 | § 15-36-100(A)(1)–(3) | **D (W1)** |
| 11 | "every case needs an expert", produced before you file | Bo | SC 15-36-100 (general rule) | § 15-36-100(C)(1)–(2) exceptions | **D (W2)** |
| 12 | Medical malpractice defined (quoted) | Bo (V1-1) | — | § 15-32-210(8), word for word; identical at § 15-79-110(6) | C |
| 13 | "Health care institution" includes a hospital, ambulatory surgical facility, nursing home | Bo | SC 15-32-220 (claim cites § 15-32-210(4)) | § 15-32-210(4) | A |
| 14 | So "the rules below" apply to nursing-home claims | Bo | SC 15-32-220 (cap only) | § 15-32-210 "this article"; § 15-79-110(2); Title 38 ch. 79 art. 5 repealed | **D (W3)** |
| 15 | Three years from treatment or discovery; no more than six years from the occurrence | Bo intro, table, KT3, F2, MD | SC 15-3-545 | § 15-3-545(A) | A |
| 16 | Foreign object: two years from discovery, never less than three from placement; six-year limit does not apply | Bo table, KT3, F2 | SC 15-3-545 | § 15-3-545(A) "other than actions controlled by (B)", (B) | A |
| 17 | Minors: not tolled more than seven years for minority, nor more than one year after majority | Bo table, KT3, F2 | SC 15-3-545 | § 15-3-545(D) | A |
| 18 | Government hospital: two years from discovery of the loss; three if a verified claim is filed first | Bo table, KT6, F2, F5 | SC 15-78-110 | § 15-78-110 | A |
| 19 | Cap base $350,000 per provider or institution, $1,050,000 total, per claimant | Bo | SC 15-32-220 | § 15-32-220(A)–(C) | A |
| 20 | 2026 caps $596,001 / $1,788,002 | Bo intro, cap table, KT4, F3 | SC 15-32-220 | RFA memo p. 1–2; State Register Vol. 50 No. 2 p. 15 | A |
| 21 | Adjusted every year for inflation | Bo, F3 | SC 15-32-220 | § 15-32-220(F) | A |
| 22 | CPI rose 70.3% from Dec 2004 to Dec 2025; memo dated 2026-02-03 | Bo | (pack evidence cites the memo; figure not in claim) | RFA memo p. 1 (190.3 to 324.054, +70.3%) and p. 2 table; Register p. 15 | C |
| 23 | Effective on publication in the State Register on 2026-02-27; changes yearly | Bo | SC 15-32-220 | § 15-32-220(F); Register cover and p. 15 | A |
| 24 | Economic damages are not limited by § 15-32-220 | Bo (D)(1), KT4, F3 | SC 15-32-220 | § 15-32-220(D)(1) | A |
| 25 | Economic damages = medical bills, future care, lost wages, lost earning capacity | Bo | — | § 15-32-210(3) | C |
| 26 | Non-economic damages = pain, suffering, mental anguish, loss of enjoyment of life | Bo | — | § 15-32-210(9) (pain, suffering, mental anguish listed; enjoyment of life falls under "other nonpecuniary damages") | C |
| 27 | Cap exceptions: gross negligence / wilful, wanton, reckless conduct causing the non-economic damages; fraud or misrepresentation related to the claim; altered or destroyed records | Bo, KT5, F3 | SC 15-32-220 | § 15-32-220(E), word for word | A |
| 28 | Punitive damages not limited by § 15-32-220 | Bo | SC 15-32-220 | § 15-32-220(D)(2) | A |
| 29 | Punitive damages require clear and convincing evidence | Bo | SC 15-33-135 | § 15-33-135 | A |
| 30 | Punitive cap: greater of 3× compensatory or $739,245 (2026); higher limits or no cap for certain conduct | Bo | SC 15-32-530 | § 15-32-530(A)–(D); Register p. 15 ($739,245) | A |
| 31 | A public hospital or government-employed doctor claim follows the Tort Claims Act | Bo, F5 | SC 15-78-30 ("State" includes state-supported health care facilities) | (§ 15-78-120(a)(5) carve-out, N4) | B |
| 32 | TCA limits $300,000 per person / $600,000 per occurrence; $1,200,000 per occurrence for a government-employed physician or dentist | Bo, F5 | SC 15-78-120 | § 15-78-120(a)(1)–(4) | **D (W4)** |
| 33 | No punitive damages under the TCA | Bo, F5 | SC 15-78-120 | § 15-78-120(b) | A |
| 34 | 501(c)(3) charity: actual damages only, within TCA limits $300,000 / $600,000 | Bo | SC 33-56-180 | § 33-56-180(A); § 33-56-170 | A |
| 35 | That reaches nonprofit hospitals and nursing homes | Bo | SC 33-56-180 | (application, not text) | B |
| 36 | Emergency care: physician liable only if grossly negligent; only while not medically stable; only before discharge; protects physicians, not hospitals | Bo | SC 15-32-230 | § 15-32-230(A), (C) | A |
| 37 | Informed consent: reasonable-practitioner standard (*Hook v. Rothstein*, 281 S.C. 541 (Ct. App. 1984)) | Bo | Hook v. Rothstein | not re-read | B |
| 38 | Comparative fault: under 51% recovers, reduced (*Nelson*) | Bo | Nelson v. Concrete Supply Co. | not re-read (N1) | B |
| 39 | Wrongful death action brought by the personal representative | Bo | SC 15-51-20 | § 15-51-20 ("executor or administrator") | A |
| 40 | The decedent's claim survives to the personal representative | Bo | SC 15-5-90 | § 15-5-90 | A |

**Counts by trace status (40 distinct claims):**

| Status | Count |
|---|---|
| A, signed pack + primary text read today | **27** |
| B, signed pack only | **4** (31, 35, 37, 38) |
| C, primary text only, not in the pack | **5** (8, 12, 22, 25, 26) |
| D, incomplete or over-broad against primary text | **4** (10, 11, 14, 32) → W1–W4 |
| E, untraceable | **0** |

**Not counted as law:**

- V1-2 attribution sentence (see section 6).
- Fees and contingency (FAQ 6).
- Office address and phones, which match `client.json`.
- Editorial lines ("stricter and slower than the law for a car crash").

---

## 5. Georgia law and the live blog

**No Georgia law on the page.**

- No `O.C.G.A.`, no Georgia case, and no "Georgia" anywhere in the draft (grep).
- The engine's cross-jurisdiction check, with GA loaded, raised nothing.
- The seeder's own guard (`S.C. Code §` present, no `O.C.G.A. §`) will pass for jurisdiction `sc`.

**No contradiction with `/blog/medical-malpractice-limits-south-carolina/`.**

- Read live today with curl, read-only. HTTP 200; body text, six FAQPage answers, Article description and meta description extracted.
- Every figure and rule shared with the draft agrees: $596,001 / $1,788,002 for 2026 with the $350,000 / $1,050,000 base; the (E) exceptions; uncapped economic damages; the punitive cap at 3× or $739,245; three years with a six-year repose; foreign object two years with no six-year cutoff; the minors rule; NOI with affidavit, tolling and 90–120-day mediation; § 15-79-125(E) 60 days or the limitation period, whichever is later; TCA two years, $300,000 / $600,000, $1.2 million for physicians, no punitive damages.
- The blog shows no § 15-3-530 anywhere.

**Where they differ, the draft is either more precise or is about to be corrected toward the blog:**

- **Expert qualification.** The blog says the expert "must be licensed ... and usually qualifies through" certification or practice. The draft says "must be ... either ... or". W1 brings the draft into line with the statute and closer to the blog.
- **Blog statement outside this PR (for the record).** The blog's own "must be licensed" has the same (A)(3) gap as W1. The plan says do not edit the blog in the same PR, so it goes to the next blog review as a W1-class item.
- **TCA physician limit.** The blog says "$1.2 million where a government-employed physician or dentist was negligent", with no per-person or per-occurrence. The draft says "per occurrence". W4 makes the draft exact. Neither is wrong on the dollar figure.

---

## 6. VERIFY tags: does the text match primary text? (tags left in place for Gillin)

| Tag | Text under the tag | Primary text read 2026-11-03 | Match |
|---|---|---|---|
| V1-1 | § 15-32-210(8) definition, quoted | t15c032.php, § 15-32-210(8): "'Medical malpractice' means doing that which the reasonably prudent health care provider or health care institution would not do or not doing that which the reasonably prudent health care provider or health care institution would do in the same or similar circumstances." The same text appears at § 15-79-110(6) | **Exact.** The paraphrase that follows ("a bad outcome is not malpractice on its own...") is a fair reading. Its next sentence is W2 |
| V1-2 | Gillin "notes that the expert review is the foundation of the case, not a formality, because the affidavit has to name what went wrong" | Not a statement of law, so there is no primary text for the quotation. The legal premise ("the affidavit has to name what went wrong") matches § 15-36-100(B), "specify at least one negligent act or omission claimed to exist and the factual basis for each claim" | Premise matches. The words themselves are Gillin's to approve |
| V1-3 | Suit within sixty days after the mediator determines mediation is not viable, an impasse exists or it should end, or before the statute of limitations runs, whichever is later | t15c079.php, § 15-79-125(E)(1)–(2), word for word on the three triggers and "whichever is later" | **Exact** |

---

## 7. Proposed pack changes (internal-ai-scripts `law/SC.json`). Not applied, no PR

**Constraints on how these go in:**

- SC is a signed pack. The validator fails a signed pack that holds an unsigned authority.
- Editing a signed authority resets its `verifiedBy`.
- So each item goes in as a `pendingAuthorities[]` entry (or a replacement text for re-signature) with `verifiedBy: null`, and rides to Gillin in the next sign-off packet.
- New rules and pairings need fixture positives and controls first, then both fixture sets re-run at 100%.

| Id | Change | Claim to add (summary) | Evidence |
|---|---|---|---|
| PK-1 | **New pending authority `SC 15-32-210`** | Definitions for the cap article: (3) economic damages; (4) health care institution includes a nursing home (today embedded in `SC 15-32-220`); (8) medical malpractice, the reasonably-prudent-provider standard; (9) noneconomic damages. Applies "as used in this article". Quantities: none | https://www.scstatehouse.gov/code/t15c032.php, read 2026-11-03 |
| PK-2 | **New pending authority `SC 15-79-110`** | Definitions for chapter 79 (Notice of Intent): (2) health care institution includes a nursing home; (6) the same medical malpractice definition. This is what carries the NOI requirement to nursing homes | https://www.scstatehouse.gov/code/t15c079.php, read 2026-11-03 |
| PK-3 | **Amend `SC 15-79-125`** (re-sign) | Add (E): if mediation fails, the action must be filed within sixty days after the mediator determines that mediation is not viable, an impasse exists or mediation should end, or before the statute of limitations expires, **whichever is later**. Add (B) subpoena/deposition after notice. (C) extension "upon a finding of good cause" (pack wording already right). Add quantity "sixty days" (already allowed) | t15c079.php § 15-79-125(A)–(F), read 2026-11-03. The live blog FAQ already states (E) |
| PK-4 | **Amend `SC 15-36-100`** (re-sign) | Add (A)(3): a non-(A)(1)/(2) expert with specialized knowledge, whose affidavit must explain the credentials. The teaching route requires at least half of professional time as employed faculty. Add (C)(1): limitation expiring within 10 days means the affidavit is due within 45 days of filing. Add (C)(2): no affidavit for negligence within common knowledge. Add (E): a defect may be cured by amendment within 30 days of the motion. Add (G): 22 listed professions incl. medical doctors and nurses. Quantities: "45 days", "forty-five days", "30 days", "thirty days", "ten days" | t15c036.php § 15-36-100, read 2026-11-03 |
| PK-5 | **Amend `SC 15-78-120`** (re-sign) | State that $1,200,000 is both the per-person ((a)(3)) and per-occurrence ((a)(4)) limit for torts of a government-employed licensed physician or dentist; add (a)(5), no limit on the physician's liability for privately paid services | t15c078.php § 15-78-120, read 2026-11-03 |
| PK-6 | **New banned pairing `medmal-deadline-cited-to-tort-statute`** (error) | `ifContext`: "medical malpractice", "malpractice claim", "notice of intent", "15-3-545", "15-79-125"; `forbidCites`: 15-3-530; `unless`: "not the\|rather than\|instead of\|unlike\|general personal injury\|car accident". **Fixtures first:** positive = this page's sidebar string "Statute of Limitations 3 years (S.C. Code § 15-3-530)" in a medical malpractice context. Controls = the Charleston medical malpractice page as corrected 2026-09-28, the live blog, and a contrast sentence ("the general three-year period in § 15-3-530 does not govern malpractice; § 15-3-545 does"). **Caveat:** the engine still cannot see the sidebar. The pairing protects content surfaces; the sidebar itself is protected only by `_roden_sol_sc` or a theme fix (R1) | E1 on the Charleston medical malpractice page (2026-09-28); R1 here |
| PK-7 | **Evidence note on `SC 15-32-220` and `SC 15-32-530`** (no claim change; does not reset the signature if confined to `evidence`) | "Inflation-adjusted every January" → "recalculated after each December CPI; effective on publication in the State Register (2026: memo 2026-02-03, Register 2026-02-27)". The figures change in late February, not January. The November plan's "go stale in January" should read "February" for the freshness lane | RFA memo; Register Vol. 50 No. 2 |

**Out of scope for packs but recorded:** the open question whether § 15-3-545 (and its repose) or § 15-3-530 governs a claim against a nursing home. § 15-3-545(A)'s cross-reference (Title 38, ch. 79, art. 5) points to a repealed article. That is a question for Gillin, not a pack edit.

---

## 8. Counts by rule

| Rule / check | Error | Warn | Notes |
|---|---|---|---|
| All 18 SC rules + 26 GA rules (engine) | 0 | 0 | Clean draft, all surfaces |
| Banned pairings (3) | 0 | 0 | |
| Authority-quantity | — | 0 | |
| Cross-jurisdiction / foreign | 0 | 0 | |
| Manual: rendered template (sidebar) | **1** (R1) | 0 | Engine-blind surface |
| Manual: primary-text completeness | 0 | **4** (W1–W4) | Should fix before publish |
| Publish path | — | — | P1, P2 (process blockers) |

**False positives:** none. The engine raised nothing on the clean draft, so no `unless` / `quantityUnless` / `contextUnless` change is proposed.

---

## 9. Before publish (checklist for the owner)

1. Apply W1–W4 to the draft (or record Gillin's rejection). These are minor sentence replacements; no restructure.
2. Gillin closes V1-1, V1-2 and V1-3. If V1-1 and V1-3 stay, PK-1 and PK-3 go into his next packet.
3. Fix P1 (FAQ format or converter) and P2 (real `_roden_last_reviewed` / `_roden_reviewed_by`). Add `_roden_sol_sc` per R1.
4. Re-run this sweep on the revised draft. The builder and both fixtures are in the session scratchpad listed in section 1; the planted set must again be caught 6/6 and the clean set must be 0/0.
5. Seed as a **draft**, then sweep the rendered preview. In particular, confirm the Filing Deadlines sidebar reads § 15-3-545. Then publish, run `bin/check-unslashed-post-writes.php` (static and live), and regenerate `content/meta.json`.
