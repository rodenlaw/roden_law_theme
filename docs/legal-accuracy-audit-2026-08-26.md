# Site-wide legal accuracy and consistency audit

**Date:** 2026-08-26
**Scope:** all 1,448 published posts, all eight content surfaces
**Corpus:** exported from production (11.6 MB incl. post bodies — bodies have never before been swept as a corpus)
**Method:** claim extraction → classification → verification against primary sources

---

## HEADLINE

**32 pages carry a false statement of law.** None of them was found by reading the pages.
They read fluently, and most carry the correct statute number beside the incorrect statement.

Two of the errors are the kind that lose a claim:

1. **Three pages tell South Carolina readers there is no cap on medical-malpractice
   non-economic damages.** S.C. Code § 15-32-220 imposes one. One of the three cites a
   South Carolina Supreme Court decision striking the caps down **that does not exist**.
   One of the three is the medical-malpractice **pillar page**.
2. **Six pages give a Georgia municipal ante litem deadline of 12 months.** O.C.G.A.
   § 36-33-5 gives **six**. A reader who relies on this misses the deadline by six months
   and the claim is barred.

The site also **contradicts itself** on both points: seven other pages state the SC
med-mal cap correctly, and the `/resources/georgia-statute-of-limitations/` table gets the
ante litem rules exactly right.

---

## WHAT WAS SWEPT

| Surface | Volume |
|---|---|
| `post_content` | 8.82 M chars |
| `_roden_faqs` | 4,213 Q/A pairs (also FAQPage structured data) |
| `_roden_key_takeaways` | 161 K chars |
| `post_excerpt` | 88 K chars |
| `_roden_why_hire` | 57 K chars |
| `_roden_meta_description`, `_roden_sol_ga`, `_roden_sol_sc` | all |

69,340 sentences extracted. 286 distinct statutory sections cited (157 O.C.G.A., 129 S.C. Code).

---

## TIER 1 — FALSE STATEMENTS OF LAW (32 pages)

### 1.1 South Carolina medical-malpractice cap denied — 3 pages

**Verified:** S.C. Code § 15-32-220 caps non-economic damages at **$350,000 per provider /
$1,050,000 aggregate (base)**, adjusted annually for CPI and published in the State Register.
Exceptions: gross negligence, wilful/wanton/reckless conduct, fraud, destruction of records.

| Page | What it says |
|---|---|
| `/blog/charleston-medical-malpractice-hospital-claim-south-carolina/` | "South Carolina does not impose a statutory cap on compensatory damages (economic or **non-economic**) in medical malpractice cases" — body **and** FAQ (schema) **and** comparison table |
| `/blog/emergency-room-errors-charleston-misdiagnosis-malpractice/` | "No cap (**SC Supreme Court struck down caps in 2012**)" + FAQ: "SC does not cap compensatory damages in medical malpractice cases" |
| `/practice-areas/medical-malpractice-lawyers/` | FAQ: "South Carolina also does not cap non-economic damages in medical malpractice cases" — **the pillar page**, in FAQPage schema |

The "SC Supreme Court struck down caps in 2012" claim appears to be a garbled import of
**Georgia's** *Atlanta Oculoplastic Surgery v. Nestlehutt* (2010), which struck **Georgia's**
$350,000 cap. The two states' rules have been swapped.

**Contradicted on-site by:** `/blog/medical-malpractice-limits-south-carolina/`,
`/blog/how-do-i-know-if-i-have-a-medical-malpractice-case/`, `/blog/value-of-pain-and-suffering/`,
`/blog/5-most-common-types-of-medical-malpractice-in-2023/`, `/blog/first-steps-in-a-medical-malpractice-case/`,
`/brain-injury-lawyers/birth-related-brain-injury/` — all of which state the cap correctly.

### 1.2 South Carolina punitive cap denied — 2 pages

**Verified:** § 15-32-530 caps punitive damages at the greater of **3× compensatory or
$500,000**; enhanced to 4×/$2,000,000 for financial-gain or felony-level conduct; uncapped
on intent to harm, felony conviction, or substance impairment.

- `/blog/5-benefits-of-hiring-a-truck-accident-attorney-in-2023/` — "South Carolina does not impose a statutory cap on punitive damages"
- `/blog/how-pain-and-suffering-is-calculated-after-an-accident-in-south-carolina/` — same

Roughly 15 other pages state the SC punitive cap correctly.

### 1.3 Fabricated BAC threshold — 1 page

`/blog/summer-dui-accidents-charleston-memorial-day-labor-day/` states twice that the punitive
cap lifts "if the defendant had a **BAC of 0.15% or higher**."

**Verified:** § 15-32-530(C)(3) uses a qualitative standard — "under the influence … **to the
degree that the defendant's judgment is substantially impaired**." There is no numeric BAC
threshold anywhere in the section. 0.15% is a threshold from South Carolina's **criminal** DUI
statutes (§ 56-5-2930 et seq.), imported into a civil damages rule where it does not belong.

### 1.4 Georgia ante litem — municipal claims given 12 months — 6 pages

**Verified:** municipality **6 months** (§ 36-33-5) · county **12 months** (§ 36-11-1) ·
State of Georgia **12 months** (§ 50-21-26).

| Page | What it says |
|---|---|
| `/blog/demand-letters-in-personal-injury-cases/` | "claim against a **city or county** government … within **12 months** … under **O.C.G.A. § 36-33-5**" |
| `/blog/when-is-the-right-time-to-hire-a-personal-injury-lawyer/` | "ante-litem notice within **12 months** (**§ 36-33-5**)" |
| `/blog/why-wont-a-personal-lawyer-take-my-case/` | "Ante-litem notice within **12 months** (**§ 36-33-5**)" |
| `/blog/liability-for-crashes-in-heavy-rainfall/` | cites **§ 36-33-1** as the notice statute (it is not) with **12 months** for municipalities |
| `/blog/what-to-do-after-car-accident-georgia/` | FAQ (schema): "Government claims need ante litem notice within 12 months" |
| `/wrongful-death-lawyers/pedestrian-cyclist-fatality/` | "Georgia's ante litem notice requirement typically requires notice within **12 months**" |

**This is the dangerous direction.** Every one of these tells a reader with a city claim they
have twice the time they actually have.

### 1.5 Georgia ante litem — county claims given 6 months — 3 pages

The inverse error. Understates, so it fails safe, but it is wrong and two instances are in
FAQPage schema.

- `/car-accident-lawyers/government-vehicle-accident/` — "**County and municipal** governments … within **6 months**" (body + FAQ)
- `/electric-scooter-accident-lawyers/road-hazard-escooter-crash/` — "written notice to the **city or county** within six months"
- `/blog/islands-expressway-whitemarsh-island-motorcycle-accident-chatham-county/` — applies § 36-33-5 / 6 months to a **county school bus**

### 1.6 SC Tort Claims Act — the deadline and the notice rule — 18 pages

**Verified:**
- § 15-78-110 — action barred unless commenced within **two years**; **three years** only if a
  verified claim was first filed.
- § 15-78-80 — the verified claim is **optional**; if used it must be filed within **one year**.
- § 15-78-90(b) — a claimant may sue "**whether or not the claim is filed**."
- § 15-78-120 — caps $300 K per person / $600 K per occurrence ($1.2 M physician/dentist); **no punitive damages**.

**The site has this backwards.** It repeatedly describes the SCTCA as imposing a *mandatory,
shorter notice deadline*. In fact it imposes a shorter **limitation period** (2 years), and the
optional filing *lengthens* your time to three. A reader told "notice deadlines are shorter" may
believe a claim is already lost when two full years remain.

**Implies the 3-year deadline governs a government claim (3 pages):**
`/blog/rivers-avenue-pedestrian-deaths-north-charleston/` ·
`/blog/car-accidents-ladson-i-26-exit-203-danger-zone/` ·
`/blog/maybank-highway-car-accidents-johns-island/` ("mandatory pre-suit notice")

**Asserts notice is required (15 pages):** `/blog/ashley-phosphate-i-26-south-carolinas-deadliest-intersection/`,
`/blog/ben-sawyer-boulevard-bridge-accidents-sullivans-island/`, `/blog/daniel-island-accidents-event-traffic-golf-carts/`,
`/blog/demand-letters-in-personal-injury-cases/`, `/blog/georgia-statute-of-limitations/`,
`/blog/i-526-expansion-construction-zone-accidents-charleston/`, `/blog/i-526-mount-pleasant-wando-bridge-accident/`,
`/blog/maybank-highway-car-accidents-johns-island/`, `/blog/pedestrian-accidents-musc-charleston-medical-district/`,
`/blog/personal-injury-claim-charleston-berkeley-dorchester-county/`,
`/blog/pedestrian-accident-dorchester-road-school-zone-29418-north-charleston/`,
`/blog/sunset-boulevard-us-378-lexington-medical-center-accident/`,
`/electric-scooter-accident-lawyers/escooter-intersection-crash/`, `/resources/dangerous-roads-north-charleston/`,
`/wrongful-death-lawyers/pedestrian-cyclist-fatality/`

> **The fix already exists on the site.**
> `/blog/green-grove-mark-clark-expressway-uninsured-motorist-lawyer-north-charleston/` states it
> correctly and completely: *"a suit against a government entity must be filed within two years of
> the loss, or three years if a verified claim was filed with the agency."*
> That sentence is the template. It is the only page of 42 that gets it right.

### 1.7 Georgia workers' comp maximum weekly benefit — three figures — 2 pages + 5

The site publishes **three different values for the same statutory maximum**:

| Figure | Where |
|---|---|
| **$383** "for injuries on or after July 1, 2016" | `/blog/workers-compensation-faqs/` |
| **$550** described as "**the current maximum**" | `/blog/much-worth-ga-worker-compared-states/` |
| **$800** "for injuries on or after July 1, 2023" (§ 34-9-261) | 5 pages incl. `/workers-compensation-lawyers/savannah-ga/`, `/darien-ga/`, and the Spanish twin |

At most one can be current. The rate is adjusted annually, so **$800 also needs confirmation** —
public sources disagree ($800 / $850 / $875). **Confirm against the Georgia State Board of
Workers' Compensation before publishing any figure.**

---

## TIER 2 — STALE OR INCOMPLETE (46 pages)

### 2.1 SC med-mal cap published as a fixed $350,000 — 7 of 8 pages

§ 15-32-220 is **CPI-indexed annually**. Only `/blog/how-do-i-know-if-i-have-a-medical-malpractice-case/`
says so ("adjusted periodically for inflation"). The other seven publish the 2005 base figures as
though current.

Secondary sources report the **2026** limits at **$596,001 per provider / $1,788,002 aggregate** —
**this needs confirming against the SC Revenue and Fiscal Affairs Office**, which publishes the
adjustment. If correct, the site understates a client's non-economic recovery ceiling by roughly
**$246,000 per provider**.

### 2.2 SCTCA "shorter notice deadlines" wording — 39 pages

The framing error from §1.6 without the false 3-year or "mandatory" element. Practical advice
("act fast, confirm your deadline") is sound; the mechanism described is wrong. Includes four
`/slip-and-fall-lawyers/*-sc/` FAQs, four `/wrongful-death-lawyers/*-sc/`, four
`/premises-liability-lawyers/*-sc/`, and `/south-carolina-car-accident-lawyers/`.

---

## TIER 3 — MARKETING AND PROFESSIONAL-CONDUCT

### 3.1 Two different recovery totals

`firm-data.php` carries the canonical `'recovered' => '$300M+'`, rendered on ~120 pages.
**13 blog posts hard-code "$250 million"** in prose instead of pulling from firm data:

`/blog/garden-city-dean-forest-road-truck-accident-lawyer/`, `/blog/darien-i-95-truck-accident-lawyer/`,
`/blog/park-circle-east-montague-drunk-driving-accident-lawyer-north-charleston/`,
`/blog/edmund-highway-lexington-county-car-accident-lawyer/`, `/blog/southover-mills-b-lane-motorcycle-accident-lawyer/`,
`/blog/eulonia-us-17-ocean-highway-rideshare-uber-accident-lawyer-mcintosh-county/`,
`/blog/summerville-i-26-18-wheeler-accident-lawyer-dorchester-county/`,
`/blog/litchfield-pawleys-island-golf-cart-accident-lawyer-georgetown-county/`,
`/blog/brunswick-ocean-highway-us-17-underinsured-motorist-lawyer-glynn-county/`,
`/blog/dick-pond-road-sc-544-truck-accident-lawyer-surfside-beach/`,
`/blog/st-simons-island-kings-way-motorcycle-accident-lawyer/`,
`/blog/car-accident-attorney-near-me-west-ashley-citadel-mall/`,
`/blog/boys-estate-glynn-county-best-car-accident-lawyer/`

Both cannot be true. A verifiable claim about results, stated two ways, engages GA Rule 7.1 /
SC Rule 7.1. The same posts hard-code "62 years of combined experience," "5,000+ cases," and
"4.9-star average across 500-plus reviews" — same drift class, same fix: **derive from
`firm-data.php`, never hand-keep in prose.**

### 3.2 "Leading personal-injury firm" — ~98 pages

Appears in FAQ answers (`faq0a`), so it renders into FAQPage structured data. An unsubstantiated
comparative claim. Low severity, trivially fixed by dropping one word.

---

## LATENT DEFECT — jurisdiction meta (309 pages)

`_roden_jurisdiction` holds **nine spellings for three values**: `both` (240), `south-carolina`
(119), `GA` (72), `south-carolina-only` (67), `sc` (61), `SC` (49), `georgia-only` (36), `ga` (26),
and **726 pages with none**.

`$firm['jurisdiction']` has exactly two case-sensitive keys, `GA` and `SC`. So:

| Consumer | Behaviour on an unmatched value |
|---|---|
| `inc/template-tags.php:1475` | `$state_key = ('sc'===$jur) ? 'SC' : 'GA'` — `south-carolina` resolves to **GEORGIA** |
| `inc/template-tags.php:2564` | `isset($firm['jurisdiction'][$key])` → `continue` — comparative-fault block renders **empty** |
| `inc/firm-data.php:1310` | `roden_get_jurisdiction()` returns **null** for 309 pages |
| `single-practice_area.php:36`, `inc/seo-meta.php:69` | SC-only page labelled "Georgia & South Carolina" |

**This is not currently producing wrong law, and I verified that rather than assuming it.**
All 119 bad `practice_area` values sit on **intersection (city) pages**, which resolve state from
`_roden_office_key` and route around this meta entirely. Live fetches of
`/car-accident-lawyers/charleston-sc/`, `/myrtle-beach-sc/` and `/medical-malpractice-lawyers/columbia-sc/`
all render correct South Carolina law and cite only S.C. Code. Every "Georgia & South Carolina"
string on those pages is firm-wide boilerplate, not a jurisdiction label.

It is a loaded gun, not a wound: one new consumer reading `_roden_jurisdiction` directly, or one
sub-type page created with `south-carolina`, and it silently serves Georgia law on a South
Carolina page. That is the failure mode CLAUDE.md records as having "bitten twice."

**Fix:** normalise the stored values to `GA`/`SC`/`both`, and make the resolver reject an
unrecognised value loudly instead of defaulting to Georgia.

---

## VERIFIED CLEAN

Checked thoroughly, no findings — worth recording so the next audit does not redo it:

| Class | Result |
|---|---|
| **Minimum liability limits** | 92 instances, **all** `25/50/25`, both states. No variants. |
| **UM/UIM** | SC mandatory (§ 38-77-150) / GA offered-but-rejectable (§ 33-7-11) — correct everywhere; no page reverses it |
| **Dog-bite liability** | No page describes Georgia as strict-liability; SC § 47-3-110 correct |
| **Comparative negligence** | GA 50% bar / SC 51% bar correct across ~294 pages. SB 68 did **not** amend § 51-12-33 (already verified in `docs/briefs/2026-08-07-georgia-tort-reform-sb68.md`) |
| **Seat-belt evidence / SB 68** | The earlier remediation **held across all four surfaces**. Every remaining "inadmissible" statement is South Carolina's § 56-5-6540(C), which SB 68 did not touch |
| **Jurisdiction cross-contamination** | Zero SC-geography pages citing only O.C.G.A.; zero GA-geography pages citing only S.C. Code |
| **Footer disclaimers** | Present and adequate: past results, gross-vs-net, testimonials, SC Rule 7.4(b) expert language, licensure, **and the costs disclaimer** — "Fees and costs apply only upon successful recovery." The 487 pages saying "no fee unless we win" are covered site-wide. |

---

## RECOMMENDED ORDER

1. **§1.1 and §1.4 first** — the two that cost a client money or a claim. 9 pages.
2. **§1.6** — 18 pages, one repeated sentence; copy the Green Grove wording.
3. **§1.2, §1.3, §1.5, §1.7** — 12 pages.
4. **§2.1** — confirm the current indexed figure with RFA, then correct 7 pages.
5. **§2.2** — 39 pages, wording-only, batchable with §1.6.
6. **§3.1** — repoint 13 posts at `firm-data.php`.
7. **Latent defect** — normalise the meta and harden the resolver.

Every Tier-1 correction must sweep **all four surfaces by claim class, not by string** — several
of these live in `post_content` *and* `_roden_faqs`, and the FAQ words them differently.

## SOURCES

- S.C. Code §§ 15-78-80, 15-78-90, 15-78-110, 15-78-120 — scstatehouse.gov
- S.C. Code §§ 15-32-220, 15-32-530 — scstatehouse.gov
- O.C.G.A. § 36-33-5 (municipal, 6 months); § 36-11-1 (county, 12 months); § 50-21-26 (state, 12 months)
- `docs/briefs/2026-08-07-georgia-tort-reform-sb68.md` — SB 68 applicability and § 51-12-33
