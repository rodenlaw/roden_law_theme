# Moped law, Georgia and South Carolina — verification pass, 2026-09-19

**Why this pass.** `KNOWLEDGE-BASE-PLAN-rodenlaw.md` §B3 line 290: "Moped law (GA + SC) — Real
gap. Zero pages." The last reference-layer candidate on the B3 list after helmet and golf-cart
law. No recorded query demand in Search Console; the value is the knowledge base. The owner
asked for the full cycle ("do that moped law now").

## Sources

- **Georgia:** codes.findlaw.com, current as of 2024-03-28 (the tracker's accepted GA source;
  Justia and LegiScan 403). Sections read verbatim: `O.C.G.A. § 40-1-1(28)` and `(30)`,
  `§ 40-6-350`, `§ 40-6-351`, `§ 40-6-352`, `§ 40-6-353`, `§ 40-2-20(b)`.
- **South Carolina:** scstatehouse.gov Title 56 Chapter 2 (the moped article,
  `§§ 56-2-3000` to `56-2-3080`, verbatim with HISTORY lines) and the moped definition
  `§ 56-1-10(26)`. The Chapter 1 page truncates before `§ 56-1-1720`, and the Chapter 5 page
  before `§ 56-5-2930`, so the licence sections and `§ 38-77-30` were read from the **enrolled
  text of 2017 Act No. 89 (H.3247)**, ratified 2017-05-15, effective eighteen months after
  approval (2018-11-19). The DUI section could not be read from any primary source reachable
  today and is not cited on either page.

## Georgia, the rule

| Rule | Text | Section |
|---|---|---|
| What a moped is | Motor driven cycle, two or three wheels, with or without pedals, max **2 brake hp**; combustion engine ≤ **50 cc** (3.05 cu in); unassisted top speed ≤ **30 mph** on level road; automatic drive | `§ 40-1-1(28)` |
| Motor driven cycle | Every motorcycle ≤ 5 bhp, and every moped | `§ 40-1-1(30)` |
| Rights and duties | A moped operator has a vehicle driver's rights and duties, except the headlight/taillight rule `§ 40-6-312(e)` and the windshield/eye-protection rule `§ 40-6-315(b)` | `§ 40-6-350` |
| Who may ride | No one under **15**; a valid driver's licence, instruction permit or limited permit of **any class** | `§ 40-6-351` |
| Helmet | **Every operator and passenger**, at any age, protective headgear meeting the Commissioner of Public Safety's standards; approved motorcycle helmets comply | `§ 40-6-352` |
| Local prohibition | DOT commissioner or a local authority may bar mopeds from roads in its jurisdiction for safety | `§ 40-6-353` |
| Registration | Mopeds **exempt** from registration | `§ 40-2-20(b)(6)` |
| Insurance | Not addressed by any section read; the pages say so and assert nothing | — |

## South Carolina, the rule

| Rule | Text | Section |
|---|---|---|
| What a moped is | A cycle "**defined as a motor vehicle**", ≤ 3 wheels, with or without pedals; a **50 cc** motor, or electric input **over 750 W and not more than 1,500 W** | `§ 56-1-10(26)` |
| Who may ride | A valid driver's licence **or** a moped operator's licence, issued at **15 or older**; eligibility "without regard to" any other licence's status; DMV may suspend it only for moped violations | `§ 56-1-1720`, `§ 56-1-1730` |
| Carry | The licence and the moped registration | `§ 56-2-3000` |
| Registration, title, insurance | Registered and licensed like passenger vehicles; "**Mopeds are not required to be titled or insured in this State**"; exempt from property tax | `§ 56-2-3010` |
| Nonresidents | Home-state registration honoured until domicile or 180 days | `§ 56-2-3020` |
| Operation | Astride a permanent seat; **farthest right lane** on multilane highways except to turn left or when unsafe; **no faster than 35 mph**; **not on highways posted above 55 mph**; headlight and lights on at all times | `§ 56-2-3070(A)–(B), (D)–(F)` |
| Helmet | **Under 21**, a `§ 56-5-3660` helmet | `§ 56-2-3070(C)` |
| Penalty | Misdemeanor, up to $200 or 30 days | `§ 56-2-3070(G)` |
| Dealers | Must sell, lease or rent with operable pedals (if fitted), a mirror, head- and running lights, brake lights | `§ 56-2-3080` |
| UM/UIM | A motor vehicle for uninsured and underinsured motorist coverage **only** | `§ 38-77-30` |

## What the site says — every surface

Three pages mention mopeds. Two are the new helmet pages, which say mopeds are out of scope.
The third is the e-bike pillar (4578):

| Surface | Said | Statute | Fixed |
|---|---|---|---|
| body | over-threshold e-bikes "may be reclassified as mopeds, requiring title, registration, and insurance" | `§ 56-2-3010`: registered, **not titled or insured** | yes — `bin/fix-moped-claims.php`, backup `docs/backups/moped-claims-2026-09-19.json` |
| `_roden_why_hire` | "reclassified as mopeds requiring registration and insurance" | same | yes |
| `_roden_faqs[1]` | "reclassified as mopeds requiring registration" | correct; citation added | yes |

Three edits, three surfaces, one post; verified live; JSON-LD guard PASS.

## The pages — published 2026-09-19

Commissioned as `content-plan/2026-10.md` entries 3a and 3b and published the same day: **post
6315 `/resources/georgia-moped-laws/`** (Eric Roden, `georgia-only`) and **post 6316
`/resources/south-carolina-moped-laws/`** (Graeham C. Gillin, `south-carolina-only`), review
date 2026-09-19 on the owner's word. Both slugs clean in the geo classifier. Seeder guards
passed; live 200, FAQPage schema, `lastReviewed` in schema, cross-links both ways, both in the
resource sitemap. Doorway ratio 243 of 980, 24.8%.

**Late correction to the sources note above.** The writer of the South Carolina page reached
`§ 56-1-1720` on the chapter page itself, and a direct `curl` of the page confirmed it: the
page is 383 KB and the fetch tool truncates it, but a plain download does not. `§ 56-1-1720(B)`
adds a rule the enrolled-act reading had not surfaced: a licensed rider under 16 may ride alone
in daylight only, and at night only with a licensed driver 21 or older with a year's
experience; (D) makes a violation a misdemeanor at $100, then $200. Both pages state it; the
tracker row is updated.

Neither writer found a divergence between its page and the e-bike pillar as corrected or the
state's helmet page. The Georgia writer noted the e-bike pillar's Georgia FAQ reads looser than
the statute on when an over-threshold e-bike becomes a moped; reviewed and fixed 2026-09-21,
below.

## DUI citations — read and added 2026-09-21

Both sections were unreadable on the 19th; a direct download of the 696 KB South Carolina
chapter page and a FindLaw read from this environment settled them the same way the licence
sections were settled.

- **`O.C.G.A. § 40-6-391(a)`:** "A person shall not drive or be in actual physical control of
  **any moving vehicle** while" impaired. No definition of "vehicle" in the section; it reaches
  a moped without any chain. Added to the Georgia moped page as a rules-table row and a
  takeaway.
- **`S.C. Code § 56-5-2930(A)`:** "unlawful for a person to drive **a motor vehicle** within this
  State while under the influence". A moped is "defined as a motor vehicle" (`§ 56-1-10(26)`),
  and the same chapter's ignition-interlock provisions carve out "a moped or motorcycle" by
  name (inserted by 2017 Act No. 89 §34), which confirms mopeds sit inside the DUI scheme.
  Added to the South Carolina moped page's body sentence and takeaway, which had said
  "including DUI" without a section.

`bin/backfill-dui-citations.php`, backup `docs/backups/dui-citations-2026-09-21.json`; the same
run cited the golf-cart pages (see `golf-cart-verification-2026-09-19.md`). Verified live,
JSON-LD guard PASS.

## E-bike classification precision — reviewed and applied 2026-09-21

The pillar (4578) made **speed** the trigger for an e-bike becoming a moped ("exceeding the
750W or 20 mph thresholds", "a modified Class III capable of 28 mph") and offered "a moped or
motor vehicle" as alternatives. Against the definitions:

- Georgia's e-bike is a motor of 750 W or less (`§ 40-1-1(15.3)`); the classes cap assistance
  at 20/20/28 mph (`§ 40-6-300`). Its moped is a motor driven cycle of at most 2 brake
  horsepower, unassisted top speed 30 mph or less, automatic drive (`§ 40-1-1(28)`); above
  2 bhp it is a motor driven cycle to 5 bhp, then a motorcycle (`(29)`, `(30)`). A moped **is**
  a motor vehicle in Georgia — `§ 40-1-1(33)` excludes e-bikes and EPAMDs, not mopeds — so
  "moped or motor vehicle" was a category error there. Read `(29)` and `(33)` on
  codes.findlaw.com for this pass; both added to the Verified table.
- South Carolina's moped hinges on wattage alone: over 750 W up to 1,500 W (`§ 56-1-10(26)`).
  A 750 W bike whose motor alone exceeds 20 mph leaves the e-bike definition (`§ 56-1-10(29)`)
  without becoming a moped; and a Class III is pedal-assist, so the 28 mph example was the
  wrong kind of speed.

Not false in the way the seat-belt or repealed-statute claims were; imprecise on the one page
that is the firm's statement of the rule, and on the point a reader with a modified bike asks.
Five edits, three surfaces (body ×2, `_roden_why_hire`, `_roden_faqs[1]`, `[3]`),
`bin/fix-ebike-classification.php`, backup `docs/backups/ebike-classification-2026-09-21.json`.
Verified live: the four loose phrasings gone, `§ 56-1-10(26)` and `§ 40-1-1(28)` cited; JSON-LD
guard PASS; `post_modified` untouched.
