# SB 68 propagation audit — 2026-08-25

Georgia Senate Bill 68 changed eight sections of state law on **21 April 2025**.
On 2026-08-25 one of those changes was found, by accident, to have gone
unpropagated for sixteen months on two published pages. This audit checks the
other seven.

**Result: one real failure, already fixed. Everything else is clean.**

## Method

For each section SB 68 touched, a `post_content LIKE` sweep across all published,
non-revision posts, then a read of how each page states the rule. Plus two
targeted checks: for the forbidden claim that SB 68 changed the 50% bar, and for
statements about a section the source brief had left unverified.

Re-runnable: the scan scripts are inline in the commit that added this file.

## Section-by-section

| SB 68 § | Amends | Pages citing it | Status |
|---|---|---:|---|
| 1 | § 9-10-184 (anchoring) | **0** | No exposure |
| 2 | § 9-11-12 (pleading timing) | **0** | No exposure |
| 3 | § 9-11-41 (dismissal) | **0** | No exposure |
| 4 | new, Title 9 Ch. 15 (fees) | **0** | No exposure |
| 5 | § 40-8-76.1 (seat-belt evidence) | 4 | **2 were outdated — fixed 2026-08-25** |
| 6 | new, Title 51 Ch. 3 (negligent security) | **0** | No exposure |
| 7 | new, Title 51 Ch. 12 (medical specials) | **0** | No exposure |
| 8 | new § 51-12-15 (bifurcation) | **0** | No exposure |

Seven of the eight sections are procedural — pleading deadlines, dismissal,
bifurcation, attorney's fees. The site is client-facing and does not discuss trial
procedure, so it never stated those rules and cannot have got them wrong. **The
one substantive change that reaches a client's case — whether a jury hears about
their seat belt — is exactly the one that failed to propagate.** That is not a
coincidence worth ignoring: the sections most likely to appear on the site are the
sections most likely to go stale.

## The negative claim: § 51-12-33 — 283 pages, all clean

The apportionment statute carrying Georgia's 50% bar appears on **283 published
pages**. SB 68 did **not** amend it, and the source brief records that the single
most common error in circulation is reporting that it did.

**No page makes that claim.** Only seven pages mention SB 68 at all, and each was
read. The one initial flag was a false positive: `/resources/georgia-statute-of-limitations/`
says *"SB 68 altered no deadline"* — the correct statement, caught by a regex
looking for the assertion rather than its negation.

## § 51-12-5.1 — verified, and the site is right

The source brief listed punitive damages as **unverified** and told writers not to
touch it. Fifty-four published pages cite the section anyway, so it was verified
here against the statutory text:

| Subsection | Provision |
|---|---|
| **(e)** | Product liability — **no limitation**; one punitive award per defendant per act |
| **(f)** | Specific intent to cause harm, **or** acting under the influence of alcohol or drugs — **no limitation against an active tort-feasor**, and such damages are not the liability of any defendant other than an active tort-feasor |
| **(g)** | All other tort actions — **capped at $250,000** |

SB 68 did not amend (e), (f) or (g); the bill references subsection (d)
procedurally without revising it.

**The site's usage holds up.** Of 61 sentences citing the section, 59 state it
accurately or neutrally. Two — `/practice-areas/golf-cart-dui/` and
`/resources/georgia-car-accident-settlement-value/` — say the cap does not apply
in a DUI case without noting that subsection (f) lifts it **only against the
active tort-feasor**. Both sentences are about the impaired driver, who *is* the
active tort-feasor, so both are correct as written. The omission matters only
where another defendant is in the case — a dram shop, or a trucking company whose
driver was impaired — and it is an imprecision rather than an error. Flagged, not
changed.

## What this audit does not cover

Only SB 68. Georgia and South Carolina both legislate every year, and nothing on
this site systematically tracks whether a statutory change has reached the pages
that state the old rule. This audit was written because one had not.

The cheapest standing version: after any statute the site cites is amended, sweep
every page citing that section — not just the page *about* it. The seat-belt
correction reached both dedicated seat-belt pages and missed two posts that
mentioned it in passing, which is how it survived sixteen months.
