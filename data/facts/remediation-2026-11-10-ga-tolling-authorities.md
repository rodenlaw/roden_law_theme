# Remediation plan: GA tolling authorities § 9-3-92 and § 9-3-96 (2026-11-10)

- **Scope:** live sentences that state the rule of O.C.G.A. § 9-3-96 (fraud) on post 1840 and § 9-3-92 (unrepresented estate) on resource 5223, on every surface.
- **Input sweep:** `data/facts/sweep-2026-11-10.json` had 0 findings. The pack had no authority for either section, so the sweep could not see them. Its 1840/5223 warnings are authority-quantity false alarms on other sections (see the end of this file).
- **Pack:** both sections were added to `internal-ai-scripts/law/GA.json` `pendingAuthorities[]` with `verifiedBy: null`: blue-sky-studio/internal-ai-scripts#163 (not merged). They are pending, not in `authorities[]`, because the shared GA pack is signed and the validator rejects an unsigned entry there. The engine does not read pending entries yet.
- **Sign-off state:** **GA is UNSIGNED for Roden** (`law-signoff.json`: 0/33). Tyler Love's sign-off is outstanding. Neither authority can back a NEW claim until he signs.
- **Site text:** read from the live rendered pages (https://rodenlaw.com, fetched 2026-11-10), covering body, the FAQ accordion and FAQPage JSON-LD. Excerpts and FAQs were also read from `content/meta.json`. The FAQ JSON-LD matches the visible FAQ text on both pages.

## Primary text read

| Authority id | Text | Source (Internet Archive `id_` capture of Justia; read 2026-11-10) |
|---|---|---|
| GA 9-3-92 | "The time between the death of a person and the commencement of representation upon his estate or between the termination of one administration and the commencement of another shall not be counted against his estate in calculating any limitation applicable to the bringing of an action, provided that such time shall not exceed five years. At the expiration of the five years the limitation shall commence, even if the cause of action accrued after the person's death." | 2023 ed.: web.archive.org/web/20241110054529id_/https://law.justia.com/codes/georgia/title-9/chapter-3/article-5/section-9-3-92/. The 2022 ed. is identical, and its history ends at Code 1933 § 3-803. |
| GA 9-3-96 | "If the defendant or those under whom he claims are guilty of a fraud by which the plaintiff has been debarred or deterred from bringing an action, the period of limitation shall run only from the time of the plaintiff's discovery of the fraud." | 2022 ed.: web.archive.org/web/20240414215248id_/https://law.justia.com/codes/georgia/2022/title-9/chapter-3/article-5/section-9-3-96/. The annotated 2020 ed. is identical, and its history ends at Code 1933 § 3-807. |

**Currency caveat:** I did not read the 2024–2026 editions. law.justia.com refuses scripted fetches, and no capture of those editions exists. Neither section has been amended since codification, going by the history lines in the editions read.

## Findings

### 1. /blog/georgia-statute-of-limitations/ (post 1840): body, "Fraud or Concealment"

- **Published:** "If the defendant actively conceals the cause of injury or commits fraud to prevent the plaintiff from discovering the claim, the deadline can be extended in both states: in Georgia by statute (O.C.G.A. § 9-3-96), in South Carolina through the discovery rule (S.C. Code § 15-3-535)."
- **Verdict:** CORRECT for the Georgia half. The statute runs the period from discovery of the fraud where the fraud debarred or deterred suit, so "can be extended" fits. The annotated text says the section is strictly construed, and the hedge allows for that. I did not check the South Carolina half in this pass.
- **Authority:** GA 9-3-96 (pending).
- **Correction:** none.

### 2. /blog/georgia-statute-of-limitations/ (post 1840): FAQ 0 (and its FAQPage JSON-LD)

- **Published:** "... Georgia has no general discovery rule, but the deadline is paused for minors and people who are legally incompetent (O.C.G.A. § 9-3-90) and when the defendant's fraud hid the claim (O.C.G.A. § 9-3-96)."
- **Verdict:** CORRECT. Strictly, the statute delays the start ("shall run only from the time of the plaintiff's discovery of the fraud") rather than pausing a running clock. Georgia courts call this tolling, and for a reader the result is the same. Not an error.
- **Authority:** GA 9-3-96 (pending).
- **Correction:** none.

### 3. /blog/georgia-statute-of-limitations/ (post 1840): FAQ 3 (and its FAQPage JSON-LD)

- **Published:** "Yes. Both states pause the clock for minors and people who are legally incompetent, and when the defendant's fraud concealed the claim. ..."
- **Verdict:** CORRECT for Georgia. This FAQ does not actually cite § 9-3-96. It states the rule without a citation, which is consistent with the statute. I did not check the South Carolina half here.
- **Authority:** GA 9-3-96 (pending).
- **Correction:** none.

### 4. /blog/georgia-statute-of-limitations/ (post 1840): body, statute-of-repose paragraph (ATTORNEY)

- **Published:** "These hard deadlines cannot be extended by late discovery or, in Georgia, by fraud — the foreign-object statutes above are the one exception."
- **Verdict:** NOT SUPPORTED by the text read. Not filed as an error. § 9-3-96 speaks only to "the period of limitation" and says nothing about repose. Whether a provider's fraud tolls the § 9-3-71(b) repose, or estops the provider from relying on it, is decided by Georgia case law, which I did not read here. This is the same class as 1676 (`ga-Q-1676` in `reviews/2026-10-attorney/triage-2026-11-09.md`). On 1676 the decision was to delete ", but not the repose," so the page takes no side. Post 1840 still takes the opposite side.
- **Proposed minimal correction, for Tyler Love to confirm:** "These hard deadlines cannot be extended by late discovery — the foreign-object statutes above are the one exception." This deletes ", in Georgia, by fraud" and the "or" before it, and changes nothing else. Ledger: 1840 is not inside a 90-day window, and in any case this is a sentence-level correction.
- **Authority:** GA 9-3-96 (pending), for what the section does not say. GA 9-3-71 covers the repose.

### 5. /resources/georgia-statute-of-limitations/ (post 5223): body, wrongful-death paragraph

- **Published:** "Georgia has no dedicated wrongful-death limitations statute. The period for wrongful death claims derives from § 9-3-33 plus case law, and under O.C.G.A. § 9-3-92 the time before an estate representative is appointed does not count against the estate, capped at five years."
- **Verdict:** CORRECT as a statement of § 9-3-92: excluded time, counted against the estate, five-year cap. **Attorney question (not an error):** the sentence sits in a wrongful-death paragraph. A wrongful death claim under § 51-4-2 belongs to the surviving spouse or children, not the estate. § 9-3-92 protects claims "against his estate", which clearly covers the estate's own claims, including the § 51-4-5 claim where there is no spouse or child. Its text does not say it extends a spouse's or children's claim. I did not read the case law on this point. Ask Tyler whether the sentence should say "a claim brought by the estate" to avoid implying more.
- **Authority:** GA 9-3-92 (pending).
- **Correction:** none proposed pending Tyler's answer. If he wants it narrowed: "... and under O.C.G.A. § 9-3-92 the time before an estate representative is appointed does not count against the estate's claims, capped at five years."

### 6. /resources/georgia-statute-of-limitations/ (post 5223): body, "What happens if I miss the deadline?"

- **Published:** "The main statutory exceptions are narrow: minority and incompetency under O.C.G.A. § 9-3-90, an unrepresented estate under O.C.G.A. § 9-3-92, a pending criminal prosecution under O.C.G.A. § 9-3-99, and suspension while a municipal ante litem demand is pending under O.C.G.A. § 36-33-5."
- **Verdict:** CORRECT for § 9-3-92. I did not re-check the other items in this pass.
- **Authority:** GA 9-3-92 (pending).
- **Correction:** none.

### 7. /resources/georgia-statute-of-limitations/ (post 5223): FAQ 1 (and its FAQPage JSON-LD)

- **Published:** "... The main exceptions are narrow and statutory: minority (O.C.G.A. § 9-3-90), an unrepresented estate (O.C.G.A. § 9-3-92), or a pending criminal prosecution (O.C.G.A. § 9-3-99)."
- **Verdict:** CORRECT for § 9-3-92.
- **Authority:** GA 9-3-92 (pending).
- **Correction:** none.

## Counts by rule

| Rule | Findings |
|---|---|
| (no pack rule; manual check against GA 9-3-96) | 4 checked: 3 correct, 1 for the attorney (#4) |
| (no pack rule; manual check against GA 9-3-92) | 3 checked: 3 correct, 1 attorney question on scope (#5) |
| Error-level sweep findings | 0 |

No live sentence states either section incorrectly. #4 makes a repose claim that § 9-3-96 does not support and that conflicts with the 1676 decision. It goes to Tyler Love.

## False positives (pack PR candidates, not edits)

These are the sweep-2026-11-10 authority-quantity warnings on these two pages. All are warnings, not errors:

- **5223 body, GA 9-3-33 bound to "one year":** "O.C.G.A. § 9-3-33 produces three deadlines in one sentence: two years for injuries to the person, one year for injuries to the reputation, four years for loss of consortium." The sentence is probably correct: § 9-3-33 is generally understood to set one year for reputation and four years for loss of consortium. I did NOT re-read § 9-3-33 in this pass, so read it against primary text before any pack change. Candidate pack PR: add "1 year"/"one year" and "4 years"/"four years" to GA 9-3-33's `quantities` with a `quantityUnless` keyed to reputation and consortium, plus a fixture control. The attorney must sign because this edits a signed authority. Note that `quantities` is part of the digest, so the edit lapses that entry's existing signature, as the README's digest rule describes.
- **5223 excerpt and meta description, GA 9-3-33 bound to "1 year":** "workers' comp runs 1 year" is a contrast sentence about § 34-9-82. The existing `quantityUnless` does not catch "— but". This is a multi-statute false alarm.
- **1840 body and FAQ 5, SC 15-78-110 bound to "1 year"/"one year"; SC 15-3-40 bound to "three years":** multi-statute sentences (verified-claim option; the later of the 19th birthday or three years). These are SC pack candidates and out of scope here.
