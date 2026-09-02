# Tier-2 statute verification — 2026-09-02

Third verification pass, after the five high-exposure statutes in #97. Same
method: extract what the site actually **asserts** about each section, then read
the section.

**Result: three statutes verified correct. Zero substantive errors. One
consistency gap, documented below and deliberately not fixed.**

---

## Scope

Selected by page count from `bin/inventory-statute-citations.php`, excluding
sections already verified in #97.

| Statute | Pages | Subject |
|---|---:|---|
| S.C. Code § 38-77-150 | 47 | Uninsured motorist coverage |
| S.C. Code § 42-15-40 | 45 | Workers' compensation limitation |
| S.C. Code § 15-78-110 | 40 | Tort Claims Act limitation |

---

## § 38-77-150 / § 38-77-160 — UM mandatory, UIM offered ✅

> **§ 38-77-150:** "No automobile insurance policy or contract may be issued or
> delivered unless it contains a provision by endorsement or otherwise, herein
> referred to as the uninsured motorist provision…"

> **§ 38-77-160:** "Automobile insurance carriers shall offer, at the option of
> the insured, uninsured motorist coverage up to the limits of the insured's
> liability coverage in addition to the mandatory coverage prescribed by Section
> 38-77-150… Such carriers shall **also offer**, at the option of the insured,
> underinsured motorist coverage…"

The site distinguishes these correctly and consistently: UM is **required** under
§ 38-77-150 ("you likely carry it even if you never asked for it"), UIM **must be
offered** under § 38-77-160. That is the distinction, and 77 distinct assertions
across 47 pages get it right.

## § 42-15-40 / § 42-15-20 — two years to file, ninety days to report ✅

> **§ 42-15-40:** "The right to compensation under this title is barred unless a
> claim is filed with the commission **within two years** after an accident…"

> **§ 42-15-20:** "No compensation shall be payable unless such notice is given
> **within ninety days** after the occurrence of the accident or death…"

Both correct site-wide, and — importantly — the site consistently warns that the
workers' comp deadline is **not** the three-year tort statute of limitations,
which is the confusion this pairing invites.

## § 15-78-110 — Tort Claims Act ✅ on substance

> **§ 15-78-110:** "…forever barred unless an action is commenced **within two
> years** after the date the loss was or should have been discovered; provided,
> that if the claimant **first filed a claim** pursuant to this chapter then the
> action… is forever barred unless the action is commenced **within three years**
> of the date the loss was or should have been discovered."

The site states this correctly everywhere.

**The trap this statute sets, and which the site avoids.** The extension does
*not* stack — filing does not add a year to two. It **swaps** the two-year
deadline for a three-year one, and both run from the same date: when the loss was
or should have been discovered. A sweep for pages describing it as additive, or
measuring the three years from the claim rather than from discovery, returned
**zero**.

---

## The one gap: § 15-78-80 is where the one-year deadline lives

The verified claim that unlocks the three-year period is not described in
§ 15-78-110 at all. It is § 15-78-80:

> **§ 15-78-80(a):** "A **verified claim** for damages under this chapter…may be
> filed…"
> **§ 15-78-80(d):** "If filed, the claim must be received **within one year**
> after the loss was or should have been discovered."

**36 mentions across 22 published pages** state the verified-claim / one-year
requirement with § 15-78-110 cited nearby and **no reference to § 15-78-80**.
Twenty other pages do cite § 15-78-80, so this is an inconsistency, not ignorance.

**Why it is worth recording.** The one-year filing deadline is the actionable item
on those pages — miss it and the extension is gone — and a reader or an AI
following the citation to § 15-78-110 will not find it there.

**Why it is NOT fixed here.** Nothing on any of those pages is wrong. § 15-78-110
is correctly cited for what those sentences are mainly about, which is the
limitation period. Adding a second statutory citation to 36 sentences across 22
pages — six of them Spanish — is an editorial decision about citation density,
not a correction, and this repo has a standing lesson about changes that are
churn rather than improvement (`bin/link-act42-page.php`: "indiscriminate internal
linking is the habit this whole recovery has been unwinding"). It is the owner's
call.

---

## Method note: the third sentence-splitting false positive this session

The first count of the gap said 12 sentences. It was wrong. Sentence-bounded
matching cut citations at `(S.C.` — `/blog/i-526-expansion-construction-zone-accidents-charleston/`
**does** cite § 15-78-80, immediately after the fragment the splitter kept. The
window-based recount gave the real figure.

That is now three times in this session a sentence splitter has inflated a
finding: the ante litem alarm, the punitive-cap figure, and this. On content built
from HTML tables and JSON-encoded FAQ arrays, **sentence boundaries are not where
the meaning ends.** Use a character window and confirm against raw markup.

---

## Cumulative position

| Statute | Pages | Verdict |
|---|---:|---|
| S.C. Code § 15-3-530 | 606 | ✅ #97 |
| O.C.G.A. § 9-3-33 | 469 | ✅ #97 |
| O.C.G.A. § 51-12-33 | 289 | ✅ #97 |
| O.C.G.A. § 51-12-5.1 | 51 | ✅ #97 |
| S.C. Code § 38-77-150 | 47 | ✅ here |
| S.C. Code § 42-15-40 | 45 | ✅ here |
| S.C. Code § 15-78-110 | 40 | ✅ here (one citation gap) |

**Eight statutes, 1,587 page-instances, zero false statements of law.** Every
error found in this repo's verification passes so far has been the *authority*,
never the substance — a pattern consistent enough now to aim the next pass at
citations rather than rules.
