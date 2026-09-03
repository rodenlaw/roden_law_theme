# Fact base — South Carolina punitive damages cap, S.C. Code § 15-32-530

**Read against the codified section at `scstatehouse.gov/code/t15c032.php` on 2026-09-03.**
Same form as `2026-08-26-sc-act42-liquor-liability.md` and
`2026-08-07-georgia-tort-reform-sb68.md`, and for the same reason.

---

# HEADLINE FINDING: FOUR PAGES STATED A FALSE RULE OF LAW. ALL FOUR ARE FIXED.

Unlike Act 42 — where the finding was that 25 pages were *incomplete* — this is an
actively false statement, of the same class as the Georgia seat-belt rule:

> "South Carolina has no statutory cap but requires clear and convincing evidence."

South Carolina has capped punitive damages since the 2011 tort reform. The sentence
was **boilerplate**: it appeared verbatim on three pages, in three different
surfaces — a key-takeaways box, a body paragraph, and an FAQ answer that also
renders into FAQPage structured data.

It was found while auditing Track C of the knowledge-base plan, on the site's
second-highest-traffic informational page (349,782 impressions). It was not the
thing being looked for.

---

## Allowlist — may be stated as written

### § 15-32-530(A) — the cap

> an award of punitive damages may not exceed **the greater of three times the
> amount of compensatory damages** awarded to each claimant entitled thereto **or
> the sum of five hundred thousand dollars**.

### § 15-32-530(B) — when the court may raise it

The trial court **may** increase the award to **four times compensatory damages**
or **$2,000,000**, whichever is greater, where the wrongful conduct involved
unreasonable financial gain with a known danger, or could constitute a felony.
This is a judicial discretion, not an entitlement.

### § 15-32-530(C) — when no cap applies at all

**Three circumstances only:**

1. the defendant **intended to harm** the claimant;
2. the defendant was **convicted of a felony** arising out of the same conduct; or
3. the defendant **acted under the influence of alcohol or drugs**, other than
   lawfully prescribed drugs taken as prescribed, to a degree that substantially
   impaired judgment.

### § 15-32-520 — the evidentiary standard

Punitive damages require **clear and convincing evidence**. This is true, and it
is what the false sentence got right. It is not a substitute for the cap.

### The neighbouring sections, for completeness

| Section | Subject |
|---|---|
| 15-32-210 | definitions |
| **15-32-220** | **non-economic** damages limit — *medical malpractice only* |
| 15-32-230 | emergency medical and obstetrical care exceptions |
| 15-32-510 | punitive damages must be prayed for |
| 15-32-520 | bifurcated trials; clear and convincing evidence |
| **15-32-530** | **punitive damages cap** |
| 15-32-540 | applicability |

---

## Forbidden — do not write these

- ❌ **"South Carolina has no statutory cap on punitive damages."** False since 2011.
- ❌ **"South Carolina has no cap"** stated without saying *cap on what*. The state
  caps **punitive** damages and does **not** cap compensatory damages — economic or,
  outside medical malpractice, non-economic. The unqualified sentence is the error;
  the distinction is the whole content.
- ❌ **"Generally no statutory cap; greater of $500K or 3x compensatory."** Both
  halves of that sentence were on the site, in one table cell, contradicting
  each other.
- ❌ Stating the (C) exceptions as though the cap is routinely lifted. It is three
  circumstances, and intoxication is the only one most claimants will meet.
- ❌ Applying § 15-32-220's **$350,000 / $1.05M** figures outside medical
  malpractice. Those are the non-economic med-mal caps and have nothing to do
  with punitive damages.
- ❌ Confusing this with **Georgia**. O.C.G.A. § 51-12-5.1(g) caps punitive damages
  at **$250,000**; (e) removes the cap in product liability; (f) removes it against
  an **active tort-feasor** who acted with specific intent or under the influence.
  Georgia's structure is not South Carolina's.

---

## What was corrected

| Page | Surface | Was |
|---|---|---|
| `/blog/compensatory-damages-vs-punitive-damages/` (1663) | `_roden_key_takeaways` | "…no statutory cap but requires clear and convincing evidence." |
| `/burn-injury-lawyers/defective-product-burn/` (4154) | `post_content` | identical sentence |
| `/boating-accident-lawyers/boating-under-influence/` (4144) | `_roden_faqs` | identical + "of reckless conduct" |
| `/blog/tips-for-choosing-a-motor-vehicle-accident-attorney/` (1681) | `post_content` | "Generally no statutory cap; greater of $500K or 3x compensatory" |

Backup: `docs/backups/2026-09-03-sc-punitive-cap-claim-before.json`.
Script: `bin/fix-sc-punitive-cap-claim.php` (dry-run by default).

The replacement wording follows `/golf-cart-accident-lawyers/golf-cart-dui/`, which
already stated the rule correctly and cited it. Correct pages were the model; no new
form was invented.

---

## What was flagged and deliberately not changed

**Everything else the sweep returned was correct** — 17 phrase-hits across the site
negate the cap on *compensatory* damages, describe Georgia, or state the (C)
exceptions accurately. Three items are imprecise rather than false, and are recorded
here instead of edited:

1. **Four wrongful-death pages** (3649, 3650, 3651, 4545) say South Carolina "places
   no cap on wrongful death damages in ordinary cases" — true of compensatory
   damages, and the two exceptions they list are right — then immediately mention
   punitive damages without noting that those *are* capped. Nothing false; the
   adjacency invites a wrong inference.
2. **`/blog/options-for-denied-injury-claims/`** (1720) says punitive damages in bad
   faith cases "are not capped at a fixed percentage of the claim." Literally true —
   the cap is a multiple of compensatory damages, not a percentage of the claim — but
   the passage implies unbounded exposure and never cites § 15-32-530.
3. **`/blog/how-to-maximize-your-car-accident-compensation-in-south-carolina/`**
   (4534) attributes the *willful, wanton, or reckless* conduct standard to
   **§ 15-33-135**, which sets the burden of proof rather than the conduct standard.
   A citation-precision question that needs § 15-33-135 read against § 15-32-520
   before anything is changed — not done here.

---

## Method note: two silent-zero failures in one session

Both are the failure mode `CLAUDE.md` already names, in new clothes:

- **`json_encode()` returns `false` on malformed UTF-8, and `echo false` prints
  nothing.** Three consecutive sweep runs produced exactly one byte of output and
  looked like they had found nothing. Always pass `JSON_INVALID_UTF8_SUBSTITUTE` and
  check the return value.
- **`_roden_faqs` is a JSON string on some posts and a PHP array on others.** Casting
  it with `(string)` yields `"Array"`, which matches nothing. The first sweep skipped
  the BUI page for exactly this reason and reported it clean.

And one verification failure: **Cloudflare returns a 403 challenge page to `curl`
even from the WP Engine host**, so a grep for the corrected string over a `GET`
counted occurrences in an error page and reported `0` for both the old *and* the new
text. Fetch the origin at **`rodenlawprod.wpengine.com`** instead — it bypasses
Cloudflare and returns the real rendered page. `HEAD` requests through the public
hostname do return honest status codes.

---

## Primary sources

| Source | Used for |
|---|---|
| [S.C. Code Title 15 Ch. 32](https://www.scstatehouse.gov/code/t15c032.php) | § 15-32-530(A)(B)(C) verbatim; chapter section list |

No secondary source was used for any statement above.
