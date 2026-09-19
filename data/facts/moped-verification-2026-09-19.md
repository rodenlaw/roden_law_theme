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

## The pages

Commissioned as `content-plan/2026-10.md` entries 3a (Georgia, Eric Roden,
`/resources/georgia-moped-laws/`) and 3b (South Carolina, Graeham C. Gillin,
`/resources/south-carolina-moped-laws/`), one state per page as the helmet pages were. Both
slugs are the state name plus the topic. Expected ratio after both: 243 of 980, 24.8%.
