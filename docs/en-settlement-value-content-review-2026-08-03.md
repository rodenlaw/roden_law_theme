# English settlement-value pages — content review

Date: 2026-08-03 · Scope: the 8 English `*-settlement-value` resource pages
Status: **all four applied 2026-08-03** (`bin/en-fix-ga-settlement-pages.php`), verified live
and diffed against the pre-change backup. Written first as a proposal; kept as the record of
what changed and why.

These surfaced while adapting the two Georgia guides into Spanish. Adapting content
is an audit of it: a writer working line by line, forced to restate every claim,
hits contradictions that nobody notices reading the page normally.

All four issues are on the **two Georgia pages**. The six South Carolina pages in
the same family are clean on every check below.

| # | Page | Issue | Severity |
|---|---|---|---|
| 1 | GA car | Misstates a case holding; contradicts the GA truck page | **High** |
| 2 | GA car | Contradicts its own severity table on case value | **High** |
| 3 | GA truck | Moderate tier priced 2–10× its siblings for a milder description | Medium |
| 4 | GA truck | Firm's own statistics written as third-party attribution | Medium |

---

## 1. *Nestlehutt* is misstated — and the two Georgia pages disagree

`/resources/georgia-car-accident-settlement-value/` says the Georgia Supreme Court
struck down "the state's noneconomic damages cap." It did not.

*Atlanta Oculoplastic Surgery, P.C. v. Nestlehutt*, 286 Ga. 731 (2010) struck
**O.C.G.A. § 51-13-1** — the $350,000 cap on noneconomic damages in **medical
malpractice** actions — as violating the constitutional right to jury trial.
Georgia has never had a general noneconomic cap covering ordinary negligence, so
there was no such cap for *Nestlehutt* to strike in a car-accident context.

The page's **conclusion is correct** (no cap on compensatory damages in car cases).
Only the reason given for it is wrong. The GA truck page already states it
correctly — "the noneconomic medical-malpractice cap was struck down in
*Atlanta Oculoplastic Surgery v. Nestlehutt* (2010)" — so the two pages currently
contradict each other on the same case.

Two places to change.

**1a — body, "Non-economic damages (general damages)" section**

> **From:** Georgia places `<strong>`no cap on compensatory damages`</strong>` in car
> accident cases — the Georgia Supreme Court struck down the state's noneconomic
> damages cap in `<em>`Atlanta Oculoplastic Surgery, P.C. v. Nestlehutt`</em>` (2010),
> so a jury is free to award the full measure of a victim's pain and loss.

> **To:** Georgia places `<strong>`no cap on compensatory damages`</strong>` in car
> accident cases, so a jury is free to award the full measure of a victim's pain and
> loss. The only statutory cap on noneconomic damages Georgia enacted applied to
> medical malpractice claims, and the Georgia Supreme Court struck it down in
> `<em>`Atlanta Oculoplastic Surgery, P.C. v. Nestlehutt`</em>` (2010).

**1b — FAQ 4, "Is there a cap on car accident damages in Georgia?"**

> **From:** No. Georgia places no cap on compensatory damages in car accident cases —
> the Georgia Supreme Court struck down the noneconomic damages cap in Atlanta
> Oculoplastic Surgery v. Nestlehutt (2010).

> **To:** No. Georgia places no cap on compensatory damages in car accident cases.
> The only statutory cap on noneconomic damages Georgia enacted applied to medical
> malpractice claims, and the Georgia Supreme Court struck it down in Atlanta
> Oculoplastic Surgery v. Nestlehutt (2010).

The rest of each passage — the $250,000 punitive cap under O.C.G.A. § 51-12-5.1 and
the DUI exception — is accurate and unchanged.

> Already corrected on the Spanish twin (`bin/es-fix-nestlehutt-framing.php`), so
> `/es/` and `/en` currently differ here. Applying 1a and 1b re-aligns them.

---

## 2. The GA car page contradicts its own severity table

The page states a headline settlement band **twice** — in `_roden_key_takeaways` and
in the body — that does not match its own table.

| | Moderate injuries |
|---|---|
| Key Takeaways + body prose | **$15,000 – $75,000** |
| Severity table on the same page | **$25,000 – $100,000** |

Neither endpoint agrees, and the prose band straddles the table's Minor/Moderate
boundary ($5,000–$25,000 / $25,000–$100,000). A prospective client reading both gets
two different answers to the question the page exists to answer.

This is unique to the GA car page. Every sibling anchors correctly — the SC car page
says "from roughly $3,000 for minor injuries" against a $3,000 Minor floor; the SC
truck page says "roughly $50,000 for moderate" against a $50,000 Moderate floor.

**Recommended — align the prose to the table.** One substitution, applied in both
`_roden_key_takeaways` and the body paragraph:

> **From:** Most Georgia car accident settlements fall between roughly **$15,000 and
> $75,000** for moderate injuries…

> **To:** Most Georgia car accident settlements fall between roughly **$25,000 and
> $100,000** for moderate injuries…

**Alternative — re-anchor across tiers, matching the SC car page.** A single
"most settlements fall between X and Y" is a stronger claim than a range spanning
tiers, and the SC page's phrasing avoids it:

> Most Georgia car accident settlements range from roughly **$5,000** for minor
> injuries to several hundred thousand dollars or more for severe and catastrophic
> ones…

Either resolves the contradiction. The first is minimal; the second is the pattern
the rest of the family already uses.

---

## 3. The GA truck "Moderate" tier reads high

The GA truck table prices tiers qualitatively rather than numerically:

| Tier | Characteristics | Value |
|---|---|---|
| Minor | Soft-tissue injuries, full recovery expected, short treatment | Tens of thousands |
| **Moderate** | **Broken bones, longer treatment, some time off work** | **Low-to-mid six figures** |
| Severe | Surgery, lasting impairment, significant lost income | High six to seven figures |

Two problems. The description is **milder** than what the sibling pages call
Moderate, yet priced far higher:

| Page | "Moderate" description | Value |
|---|---|---|
| GA truck | Broken bones, longer treatment, some time off work | ~$100k–$500k |
| SC truck | Broken bones, herniated discs, **surgery** with recovery | $50,000 – $250,000 |
| GA car | Broken bones, herniated discs, **surgery** with recovery | $25,000 – $100,000 |

And it leaves a gap: Minor tops out in the tens of thousands, Moderate starts at six
figures, with nothing in between.

Truck cases do carry higher values — bigger policies, worse crashes, FMCSA minimums —
so a step above the car page is expected. A 2–10× step for a description that omits
surgery is not, and this is the row most likely to be quoted back to the firm as a
promise of value.

**Recommended:**

> **From:** Broken bones, longer treatment, some time off work → **Low-to-mid six figures**

> **To:** Broken bones, herniated discs, surgery with recovery → **High five to low six figures**

That closes the gap under Minor, matches the sibling pages' description of the tier,
and keeps the qualitative style the rest of this table uses. The "Illustration Only"
column header and the caveat under the table both stay.

---

## 4. The GA truck page cites its own statistics as if a third party had

In the "Proven Results and What They Mean for Your Case" section, after the
$27,000,000 result, $300 million recovered, 5,000+ cases and 4.9-star average:

> **From:** According to those publicly reported firm figures, Roden Law's track
> record reflects substantial experience in serious injury and trucking litigation.

"According to those publicly reported firm figures" is the grammar of third-party
attribution applied to the firm's own numbers. The figures may well be published,
but the sentence reads as though an outside source is vouching for the conclusion
drawn from them.

**Recommended:**

> **To:** These are the firm's own reported figures. They reflect substantial
> experience in serious injury and trucking litigation.

The paragraph that follows — "These results are real, but they are not a forecast.
Past results do not guarantee future outcomes" — is good and should stay. This change
only removes the implied external endorsement.

The Spanish twin already renders it as a plain statement.

---

## Applied

All four are content edits to post bodies and post meta — **database, not theme**, so
they never went through the deploy. Applied 2026-08-03 via
`bin/en-fix-ga-settlement-pages.php`, which requires each replacement to match exactly
once and aborts without writing otherwise. `content/meta.json` regenerated, since #1b
and #2 touch `_roden_faqs` and `_roden_key_takeaways`.

All three Georgia pages — English car, English truck, Spanish car — now describe
*Nestlehutt* the same way.

### The first attempt broke two of them

Worth recording, because the failure was silent and the script reported success.

Two replacements contained literal dollar amounts. PHP reads `$25` and `$100` in a
`preg_replace` **replacement** as backreferences, up to two digits — not literals — so
`$25,000 and $100,000` was written to the live page as `,000 and 0,000`. A third used
`$1` against an apostrophe character class that was never parenthesised, so `the
firm's` became `the firms`. The script printed "All 6 replacements matched exactly
once" and was, on its own terms, correct: the *patterns* matched fine. The damage was
in the replacement strings.

Caught by verifying the rendered pages afterwards rather than trusting that output,
and repaired within minutes by `bin/en-fix-ga-settlement-repair.php` using
`str_replace` only. Then diffed both posts against the pre-change backup
(`data/es-relink-backups/2026-08-03-en-settlement-pages-before.json`) to confirm
exactly the six intended edits and nothing else.

**Rule: never put a `$` in a `preg_replace` replacement.** Use `str_replace` for
literal swaps, or `preg_replace_callback` and build the string yourself. And verify
content edits against the rendered page, not against the edit script's own report.
