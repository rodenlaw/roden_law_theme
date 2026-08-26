# Workers' compensation and UM/UIM — verification pass, 2026-08-25

Undertaken to write the two remaining two-state guides. Writing them required
verifying the underlying law, and verifying the law turned up **ten false claims
across six published pages**. Those are fixed. One of the two guides is written;
the other is blocked, and the reason is recorded below rather than worked around.

## Sources

Primary only. No secondary summaries, per the standing rule from the SB 68 brief:
every secondary source reviewed for that brief got at least one thing wrong.

| Source | Used for |
|---|---|
| [scstatehouse.gov, S.C. Code Title 42 Ch. 15](https://www.scstatehouse.gov/code/t42c015.php) | SC notice and filing deadlines, physician selection |
| [scstatehouse.gov, S.C. Code Title 42 Ch. 9](https://www.scstatehouse.gov/code/t42c009.php) | SC disability rates, week caps, the § 42-9-10(C) exception |
| [scstatehouse.gov, S.C. Code Title 38 Ch. 77](https://www.scstatehouse.gov/code/t38c077.php) | SC UM mandate, UIM offer requirement |
| [Georgia SBWC Employee Handbook](https://sbwc.georgia.gov/document/publication/employee-handbook/download) | GA deadlines, benefit mechanics, panel-of-physicians rules |

## What was wrong, and what it now says

### 1. Georgia's two-year clock ran from the wrong event — `steps-after-work-injury` (1658)

> **Was:** "1 year from the date of injury under O.C.G.A. § 34-9-82, or 2 years
> from the last authorized medical treatment, whichever is later."

O.C.G.A. § 34-9-82 works two ways that are not interchangeable, and the SBWC
handbook states both plainly: *"If you received remedial treatment from your
employer for the injury, you have one year from the date of treatment... If you
received weekly income benefits... you have two years from the date of your last
payment of weekly income benefits."*

**One** year from treatment. **Two** years from payment. The page merged them and
attached the longer period to the more common event.

**This error runs in the direction that loses claims.** A worker whose last
treatment was eighteen months ago reads that page and concludes they have six
months left. They have none. The comparison table repeated it.

### 2. Georgia's doctor choice was reversed — `is-workers-compensation-an-employee-benefit` (1684)

> **Was:** "The employer or insurer selects the authorized treating physician from
> a posted panel of at least six doctors."

The opposite. The handbook: *"The law requires that you select from a list of
physicians posted by your company."* The worker chooses, and *"if you are
dissatisfied with your first selection, you may make one change to another
physician from the posted list"* — without permission.

The page told injured workers they had no say in their own medical care, and hid a
right they can exercise unilaterally. It also contradicted itself: further down,
the same page describes the Georgia panel correctly.

### 3. South Carolina's 500-week cap was described as extendable — 1677, 1682

> **Was:** "PTD benefits continue for 500 weeks, but may be extended if the worker
> proves continued total disability."

S.C. Code § 42-9-10(A): *"In no case may the period covered by the compensation
exceed five hundred weeks except as provided in subsection (C)."* Subsection (C)
is a closed list — paraplegia, quadriplegia, physical brain damage — paid for life.

There is no proving-continued-disability route. A worker told there is will value
their claim on a benefit stream that does not exist.

The same page listed **amputation** among the injuries qualifying for South
Carolina lifetime benefits. It is not on the subsection (C) list, however severe.

### 4. South Carolina UM/UIM, wrong in both directions — 1649, 1715

| Page | Was | § |
|---|---|---|
| 1649 | SC UM "required unless rejected in writing" | § 38-77-150 makes UM mandatory in **every** policy — it cannot be rejected |
| 1715 | SC UIM "is mandatory" | § 38-77-160 requires carriers to **offer** UIM at the insured's option |

The site asserted both halves of the truth and both halves of the error, on
different pages. 1715 states the UM rule correctly in a table and the UIM rule
incorrectly in prose four paragraphs later.

## The guide that shipped

**`/resources/georgia-vs-south-carolina-workers-compensation/`** — draft 5354.

Its spine is a point that only a two-state practice would notice. Both states cap
wage benefits (400 weeks Georgia, 500 South Carolina) and both have a route past
the cap — but the routes are built on opposite principles. Georgia's catastrophic
designation is a **functional test**: can this worker perform their prior work, or
any work available in substantial numbers in the national economy? That is argued,
and winnable. South Carolina's § 42-9-10(C) is a **categorical list** of three
conditions. You are on it or you are not.

So the headline comparison inverts. South Carolina's extra hundred weeks is worth
having for a moderate injury. For a catastrophic one, Georgia has a door South
Carolina does not.

Also updated: the filing-deadlines guide (5353) had a deliberate blank in its
South Carolina workers' compensation cell, left empty because the deadline was
unverified. It is now verified at two years under § 42-15-40 and filled in.

## The guide that is blocked, and why

**UM/UIM stacking — not written.** The South Carolina half is fully verified. The
Georgia half is not, and the missing piece is the one that matters most.

Georgia offers two structurally different forms of UM coverage — commonly called
**"added on"/excess** and **"reduced by"/set-off**. Under the first, UM pays on top
of the at-fault driver's liability limits. Under the second, it pays only the
difference. On the same crash with the same limits, the two can differ by the
whole value of the coverage. Which form applies, and whether the insured gets to
elect, is the single most consequential thing a UM guide can tell a Georgia reader.

I could not obtain the operative text of **O.C.G.A. § 33-7-11** from a primary
source:

| Attempted | Outcome |
|---|---|
| `ga.elaws.us` | serves a 2013 snapshot, and returns only navigation |
| `law.justia.com` | 403 to our user agent |
| Official O.C.G.A. | behind LexisNexis |
| Georgia OCI consumer auto guide | a multi-column Q&A; does not address the election |
| `rules.sos.ga.gov` (Ga. Comp. R. & Regs. 120-2-28-.06) | TLS handshake refused |
| Ga. Supreme Court, *First Acceptance* (S18G0517) | does not construe § 33-7-11 |

Writing the guide anyway would mean reconstructing a statute from memory and
secondary sources. **That is exactly the failure mode that left the Georgia
seat-belt rule wrong for sixteen months**, and it would be worse here, because
this is a number a reader might rely on when deciding whether to accept an offer.

**Exposure while it waits.** 33 published pages cite § 33-7-11; 86 mention
stacking. Two specific claims should be checked first once the text is in hand:

1. `car-insurance-add-ons` (1715): *"In both Georgia and South Carolina policies,
   UIM coverage pays the difference between the at-fault driver's liability limits
   and your UIM limits — not a separate, stacked benefit on top."* If Georgia
   permits an add-on election, that flat statement is wrong for add-on policies —
   and wrong in the direction that undervalues a claim.
2. `claims-against-at-fault-drivers-who-died` (1649) and 1715 both assert stacking
   rules ("yes, unless waived"; "insurer must offer stacked and unstacked
   options") that no primary source here supports.

**To unblock:** the current text of O.C.G.A. § 33-7-11 from LexisNexis or Westlaw —
which the firm has and I do not. A page or two of statute, and the guide is
half-written already.

## Addendum — the corrections were incomplete, and how that surfaced

After merging, the fixed pages were checked live. Eight of nine were clean.
`/steps-after-work-injury/` **still carried the false deadline**, on a page whose
body had just been corrected and whose `post_content` sweep came back clean.

It was in `_roden_faqs`. The sweep had only ever looked at `post_content`.

**FAQ answers are a second content surface, and a worse one to get wrong**, because
`inc/` renders them into FAQPage structured data. The false deadline was not merely
published — it was handed to search engines as a machine-readable answer to
"How long do I have to file a workers' compensation claim?"

Re-sweeping the meta by **claim class rather than by string** found two more real
errors that a string search could never have matched, because the FAQ wording
differs from the body wording every time:

| Page | The FAQ said | Verified |
|---|---|---|
| `steps-to-take-if-you-are-involved-in-a-bicycle-hit-and-run` (1698) | SC UM is "required unless specifically rejected" | § 38-77-150 makes it mandatory; it cannot be rejected |
| `how-to-maximize-your-car-accident-compensation-in-south-carolina` (4534) | *Q: "Does South Carolina require uninsured motorist coverage?"* — answered that insurers must **offer** it and "you must sign a written rejection to decline it" | The question is exactly right and the answer is exactly backwards. UM is mandatory under § 38-77-150; UIM is the optional one, under § 38-77-160 |
| `workers-compensation-lawyers` (3610) | a Georgia worker may "request" one change of panel physician | The SBWC handbook: they *may make* that change. No permission needed — and this is the practice-area pillar page |

That brings the pass to **thirteen false or materially misleading claims across
nine pages.**

### What was built in response

`bin/apply-faq-remediation.php` — a companion to `apply-stat-remediation.php` that
patches `_roden_faqs` with the same exact-match guard and read-back verification.
It exists because the older script structurally cannot see meta, and that gap let a
corrected claim survive on a page that had just been fixed.

**The rule it encodes:** when a claim is corrected in a body, sweep the meta for the
same claim *class*, never for the same string. The FAQ almost always words it
differently, which is precisely why a string sweep misses it.

One further note for whoever checks the next batch: the first live check of
`/steps-after-work-injury/` showed the corrected FAQ *and* the old one, because
Cloudflare was still serving an edge copy. A cache-buster query string did not
defeat it. Two clean fetches a few minutes apart are the check that means
something.

## Second addendum — the re-sweep, and two more surfaces

Re-sweeping the earlier statistical corrections against meta found **21 more
survivals across 15 pages**, and in doing so found that a claim on this site can
live in **four** places, of which the earlier rounds swept one.

| Surface | What it is | Swept before today |
|---|---|---|
| `post_content` | the article body | yes |
| `_roden_faqs` | FAQ answers — also FAQPage structured data | no (fixed earlier today) |
| `_roden_key_takeaways` | the summary box **above** the article | **no** |
| `post_excerpt` | rendered as the Article `description` in schema | **no** |

### The false negative that nearly ended the sweep early

After fixing the FAQ survivals I re-ran the sweep against the exported
`content/meta.json` and it reported **zero**. The live pages still showed the
claims.

`_roden_key_takeaways` was not in the export whitelist. The sweep read the field,
got nothing back because it had never been exported, and reported a clean pass.

**A sweep that cannot see a field does not report "unknown". It reports zero.**
Confirm a field is actually present in whatever you are sweeping before believing
a null result. The only reason this surfaced is that the live pages were checked
as well as the database.

Adding the field to the export immediately found two more. Adding `post_excerpt`
found the last two: both Ashley Phosphate pages still described the intersection
as *"the most dangerous in South Carolina"* in their excerpt — which
`roden_schema_article()` publishes as the Article `description` — on pages whose
own bodies say it ranked **second**.

### Not everything found was wrong

Three pages carry *"62 injuries between 2011 and 2015"* at the Rivers Avenue/I-526
interchange. Two cite the Post and Courier analysis. The third stated the same
figure with no source and a vague "five-year study period" — so it was **cited and
dated, not deleted**, per the standing rule that an uncited claim is usually a
sourcing failure rather than a fabrication.

Same for the Ashley Phosphate frequency: *"a crash every three days"* is real and
sourced. Only the superlative attached to it was false. The corrected pages now
carry the sourced figure **and** the true ranking.

### What was built

`bin/apply-faq-remediation.php` became **`bin/apply-meta-remediation.php`** one day
after it was written, generalised to patch FAQ entries, plain string meta, and
`post_excerpt`, all with the same exact-match guard and read-back. Writing a third
and fourth one-off script would have been the wrong answer to discovering a third
and fourth surface.

`content/meta.json` now versions `_roden_key_takeaways` (278 boxes) and
`excerpt` (483 pages). Both were invisible to review until today.

## The pattern

Every error above was found by checking a fact against its source in order to
write something new. None was found by reading the pages, which read fluently and
carry correct statute numbers beside incorrect statements of what those statutes
say. A citation is not a verification, and on this site it has repeatedly been
mistaken for one.
