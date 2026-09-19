# South Carolina golf-cart law — verification pass, 2026-09-19

**Why this pass.** `KNOWLEDGE-BASE-PLAN-rodenlaw.md` §B3 names "SC golf cart law" as the
strongest reference-layer gap by demand (5 queries, 764 impressions, positions 6.6–11.7), held
back because its statutes `SC 56-2-100` and `SC 56-2-105` were on the tracker's unverified
list. The owner asked for the next reference-layer page to be verified before it is drafted.

## What the state code says

Read on scstatehouse.gov (Title 56 Chapters 2 and 3) and the bill page for H.3292, 2026-09-19.

| Section | Status | What it is |
|---|---|---|
| `§ 56-2-105` "Golf cart permit and the operation of a golf cart" (2012–2025) | **REPEALED 2025-05-22**, 2025 Act No. 64 §2: "Section 56-2-105 of the S.C. Code is repealed." | The section the site cites as current law |
| `§ 56-2-90` "Operating a golf cart on a public highway" | **Current**, added by Act 64 §1, eff 2025-05-22 | The golf-cart statute today |
| `§ 56-2-100` "Conditions for operation on street or highway" | Current (2005, amended 2012) | **Low-speed vehicles**, not golf carts |
| `§ 56-3-115` | Current (2021) | A deaf/hard-of-hearing notation on a vehicle registration; nothing to do with golf carts |

**`§ 56-2-90`, the rule as it stands:**

- **(A) Permit.** DMV permit decal and registration certificate; proof of ownership, proof of
  liability insurance, $5 fee; renew every five years or on a change of address.
- **(B) Operator.** At least **16**, valid driver's licence, carrying the registration, proof of
  insurance (§ 38-77-140) and the licence.
- **(C) Local ordinance.** A municipality, or a county in its unincorporated area, may set
  hours, methods and locations (only on highways posted **35 mph or less**), may permit **night
  operation** with working headlights and taillights, may designate separated cart paths, and
  may not demand proof of property ownership for a decal.
- **(D) Default, no ordinance.** Daylight only; secondary highways posted 35 mph or less;
  within **four miles** of the registered address (or a gated community's gate); may cross a
  faster highway at an intersection.
- **(E) Children.** Every passenger **under 12** must wear a fastened safety belt.

The 2025 act kept the permit, age, licence, 35 mph and four-mile rules, added the local
night-operation power, the separated-path power, the no-property-proof rule and the
under-12 belt requirement.

## What the site says — every surface, 18 pages carry golf-cart text

Sweep of `post_content`, `post_excerpt` and every `_roden_*` meta key on all published posts.
Most of the 18 are accident and liability prose with no statutory claim. These are the
divergences:

| Post | Surface | Says | Statute | Class |
|---|---|---|---|---|
| 4343 `/blog/golf-cart-accidents-charleston-island-resort-communities/` | body | "S.C. Code § 56-2-105: Permitted roads — … 35 mph or less; Crossing roads …" | § 56-2-105 repealed; rules now § 56-2-90(C)–(D) | **repealed section cited as law** |
| 4343 | body | "South Carolina does not require golf cart owners to carry liability insurance." | § 56-2-90(A) requires proof of liability insurance for the permit; (B) requires the operator to carry proof | **false statement of law** |
| 4364 `/blog/daniel-island-accidents-event-traffic-golf-carts/` | body ×2 | "(S.C. Code Section 56-2-105) permits golf carts on roads … 35 mph or less, provided the cart is registered and the operator holds a valid driver's license" | repealed; rule now § 56-2-90 | repealed section cited |
| 4364 | body | "…meaning minors under 15 cannot legally operate a golf cart on public roads" | § 56-2-90(B): at least **sixteen** | **wrong age threshold** |
| 4754 `/blog/surfside-beach-golf-colony-golf-cart-accident-lawyer/` | body ×2 | "under S.C. Code § 56-2-105" | repealed | repealed section cited |
| 4804 `/blog/litchfield-pawleys-island-golf-cart-accident-lawyer-georgetown-county/` | body | "§ 56-2-105 limits where a permitted golf cart may legally be driven" | repealed | repealed section cited |
| 4738 `/blog/litchfield-beach-pawleys-island-us-17-car-accident-georgetown-county/` | body ×2 | "§ 56-2-100 and § 56-3-115 strictly limit where these vehicles can legally operate" | § 56-2-100 is low-speed vehicles; § 56-3-115 is a hearing-loss registration notation | **miscitation, both sections** |
| 4185 `/golf-cart-accident-lawyers/golf-cart-rollover/` | body | "South Carolina does not have a comprehensive statewide golf cart statute, so regulation falls largely to local ordinances." | § 56-2-90 is a statewide golf-cart statute; ordinances operate inside it | **false statement of law** |
| 4186 `/golf-cart-accident-lawyers/golf-cart-vehicle-collision/` | body | "South Carolina regulates golf cart road use through local ordinances" | incomplete: the statute sets the frame, ordinances vary it | misleading |
| 4090 `/practice-areas/golf-cart-accident-lawyers/` | body, `_roden_why_hire` | "South Carolina has similar regulations that vary by municipality, with communities like Hilton Head Island, Kiawah Island, and Myrtle Beach having specific golf cart ordinances." | consistent with § 56-2-90(C); no statute cited | uncited, not wrong |

Georgia claims on the same pages (`O.C.G.A. § 40-6-330`, 25 mph / 35 mph, daylight, designated
roads) were **not** read in this pass and stay uncited-unverified.

## Demand, and where it lands today

Search Console, 16 months to 2026-09-15: 35 golf-cart URLs, 231 clicks, 56,003 impressions.
The two that earned most were law pages from the old site, `/blog/south-carolina-golf-cart-laws/`
(78 clicks, 17,873 impressions) and `/blog/myrtle-beach-golf-cart-laws/` (116 clicks, 13,544
impressions). Neither exists in WordPress; both are legacy URLs in `inc/legacy-redirects.php`
that **301 to the accident pillar**, which does not state the law. The demand the plan measured
is real, it has been arriving for sixteen months, and it lands on a lawyer page.

## Recommendation

1. **Remediate the eight divergences first**, as a claim-class pass across body and meta:
   replace `§ 56-2-105` with `§ 56-2-90` and restate the rule where the page states it; correct
   the insurance and age claims; correct the "no statewide statute" claims; re-cite 4738.
   Same mechanics as `bin/fix-helmet-claims.php`. No page needs retiring.
2. **Then commission `/resources/south-carolina-golf-cart-laws/`** as the reference-layer
   page: statewide, `south-carolina-only`, Graeham C. Gillin, built on `§ 56-2-90` with the
   2025 change explained (the page can say what changed and when, which nothing else on the web
   the site competes with is likely to do well), and **repoint the two legacy 301s** from the
   accident pillar to it. Slug is clean for the geo classifier (state name only). Keep the
   Myrtle Beach and North Myrtle Beach ordinances out of the slug and headings; they can be a
   section that cites the ordinances, if traced.
3. Put the repeal lesson into the verification method: re-read each section's HISTORY line on
   every pass (added to the tracker's watch items).
