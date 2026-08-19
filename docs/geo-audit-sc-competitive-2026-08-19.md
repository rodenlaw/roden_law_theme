# GEO Audit + South Carolina Competitive Analysis — rodenlaw.com

**Date:** 2026-08-19
**Scope:** Live GEO/AI-search posture of rodenlaw.com, measured against the South Carolina
personal-injury market. Extends `seo-geo-audit-2026-07-08.md`, whose G1–G6 items shipped in
`1b96026` / `2f37142`.
**Method:** live fetches of production HTML + robots/llms/sitemaps; JSON-LD extraction across
30 SC intersection pages; `content/meta.json` (712 posts); Semrush US organic + SERP-feature
data; live Google Business Profile data via Local Falcon; AI-answer sampling on commercial and
informational SC queries.

---

## Executive summary

The on-page GEO work is genuinely ahead of this market. Roden is the **only firm in the SC
sample that cites primary law on its city pages**, the only one emitting `HowTo` and
`SpeakableSpecification`, and the only one with a hand-authored `llms.txt` carrying firm
credentials, jurisdiction facts and citation guidance. That investment is already being paid:
on the informational query *"how long do I have to file a car accident lawsuit in South
Carolina"*, rodenlaw.com is cited **twice in the top seven** — above Steinberg, Derrick and
every other firm in the market.

Three things are holding the SC market back, and none of them is content quality.

1. **The structured data contradicts Google.** Live `AggregateRating` on four office pages
   overstates the real review count — including a 4.9-star rating on a Darien profile that has
   **zero reviews**. This is the exact structured-data violation `schema-helpers.php:518`
   warns against; it arrived through data drift rather than a hardcoded fallback.
2. **Three of the four SC offices have effectively no Google reviews** (2, 2 and 2 against
   Charleston's 105). Review volume is a dominant input to both local pack and AI local
   answers. No amount of on-page schema compensates for it.
3. **Commercial-intent AI answers in SC are owned by directories, and Roden is not in them.**
   On "best/top lawyer" queries, 6–10 of every 12–15 sources an AI engine reads are Super
   Lawyers, Justia, Avvo, Expertise, Best Lawyers, FindLaw and Enjuris. Roden appears in none.

The pattern is consistent: **Roden wins where the answer comes from a page, and is absent
where the answer comes from a list.**

---

## Part 1 — GEO state of rodenlaw.com

### Verified healthy

| Area | Result |
|---|---|
| AI crawler access | robots.txt explicitly allows 13 AI user-agents (GPTBot, OAI-SearchBot, ChatGPT-User, PerplexityBot, Perplexity-User, ClaudeBot, Claude-SearchBot, anthropic-ai, Google-Extended, Applebot-Extended, cohere-ai, Amazonbot, Bytespider) |
| `llms.txt` | 200, `text/plain`, 16.6 KB, regenerated 2026-08-17 |
| `llms-full.txt` | 200, `text/plain`, 72.6 KB, same date |
| Class actions in llms.txt | Present — the 2026-07-08 **G1** finding is closed |
| Schema depth (intersection) | 21 distinct types incl. `HowTo`, `SpeakableSpecification`, `City`/`State`/`Place`, `FAQPage`, `LegalService`, `LocalBusiness`, `Person` |
| Statutory citation | Roden cites primary law on city pages; **0 of 4** SC competitors scanned cite any |
| Jurisdiction accuracy | SC pages correctly render 3 years / S.C. Code § 15-3-530 / SCDOT Tort Claims Act; GA pages render 2 years / O.C.G.A. § 9-3-33. No cross-contamination found. |

Note on crawler naming: `User-agent: *` only disallows `/wp-admin/`, so unnamed bots
(CCBot, meta-externalagent, DuckAssistBot, YouBot) are **already allowed by default**. Adding
them is cosmetic, not a fix — no action needed.

---

### F1 — `AggregateRating` contradicts live Google data — **HIGH (compliance)**

`firm-data.php` hardcodes a per-office `review_count` that has drifted from the real Google
Business Profile numbers. The sum feeds schema `AggregateRating` on every office and
intersection page.

| Office | Schema (live HTML) | Live GBP | Assessment |
|---|---|---|---|
| Savannah, GA | 4.9 ★ / 58 | 4.9 ★ / 59 | accurate |
| **Darien, GA** | **4.9 ★ / 12** | **0.0 ★ / 0 reviews** | **rating asserted for a profile with no reviews** |
| Charleston, SC | 4.9 ★ / 80 | 4.9 ★ / 105 | under-reported by 25 |
| North Charleston, SC | *(none emitted)* | 5.0 ★ / 2 | inconsistent with siblings |
| **Columbia, SC** | **4.9 ★ / 18** | **5.0 ★ / 2** | **9× over-reported** |
| **Myrtle Beach, SC** | **4.9 ★ / 22** | **5.0 ★ / 2** | **11× over-reported** |
| **Total** | **205** | **170** | |

Source: `inc/firm-data.php` lines 95, 151, 199, 247, 294, 342 vs. live GBP.
Verified live on `/locations/georgia/darien/`, `/locations/south-carolina/columbia/`,
`/locations/south-carolina/myrtle-beach/`, `/locations/south-carolina/charleston/`.

Risk is twofold: Google strips review rich results for inflated counts, and for a law firm an
unverifiable public rating claim is an advertising-accuracy problem in its own right.

**Fix:** update the six `review_count` values to live GBP figures; suppress `AggregateRating`
entirely where `review_count < 5` (Darien, North Charleston, Columbia, Myrtle Beach) rather
than emitting a firm-wide 4.9 over a 2-review profile; use each office's own `rating` instead
of the global 4.9.

---

### F2 — Three of four SC offices have no review base — **HIGH (root cause)**

| SC office | Reviews | Rating |
|---|---|---|
| Charleston | 105 | 4.9 |
| North Charleston | 2 | 5.0 |
| Columbia | 2 | 5.0 |
| Myrtle Beach (Murrells Inlet) | 2 | 5.0 |

Charleston is competitive. The other three are functionally invisible to both the local pack
and to AI assistants answering "who should I call in Columbia." This is the single biggest
constraint on SC visibility and it is not a website problem.

Related GBP defects found in the same data:

- **Columbia's GBP carries no phone number.**
- **Category coverage is uneven:** Charleston has 4 categories (personal injury attorney, law
  firm, legal services, trial attorney); Columbia, Myrtle Beach, Savannah and Darien have 1
  each; North Charleston has 2. Secondary categories drive local and AI local answers.
- **Three profile names carry keyword suffixes** — "Roden Law Personal Injury and Car Accident
  Law Firm" (Myrtle Beach), "Roden Law | North Charleston Personal Injury Lawyers", "Roden Law
  | Darien Personal Injury Lawyers". This is common practice but is against Google's GBP
  naming guidelines and is competitor-reportable.
- Charleston, North Charleston and Myrtle Beach are **not in the "Roden Law" location group**;
  Savannah, Columbia and Darien are.

---

### F3 — 45% of every H2 is site chrome — **HIGH (AI extraction)**

Measured across 30 SC intersection pages. "Chrome" here means headings carrying a
navigation, form, sidebar-widget, footer or CTA-banner class (`nap-name`, `form-title`,
`matrix-title`, `widget-title`, `footer-heading`, `text-white`); section headings such as
`section-title` and `key-takeaways-title` are counted as content.

| Metric | Roden (SC avg, n=30) | Hughey Law (same query) |
|---|---|---|
| H2 elements per page | 29.1 | 10 |
| …that are chrome | **13.0 (45%)** | 0 |
| …that are content | 16.1 | 10 |
| Index of first *content* H2 | **3 on all 30 pages** | 0 |

On every SC page the first three headings an extractor meets are `nap-name`
("Roden Law — Charleston"), `form-title` ("Free Case Review") and `matrix-title`
("Car Accident Lawyers — All Locations"). "Free Case Review" appears as an H2 **three times**
per page. Sidebar and footer widgets add the rest.

By contrast Hughey's page opens with three literal questions as H2s — *"What to Do After a Car
Accident in Charleston, SC"*, *"What If I Was Partially at Fault…"*, *"How Long Do I Have to
File…"* — and carries no chrome headings at all. Heading hierarchy is how both Google's passage
ranking and LLM chunkers segment a page into answerable units; Roden is spending half of that
signal on furniture.

Emitters are few and localized:

**45 emitters across 16 files** — the four templates that share the practice-area rendering
(`template-practice-area.php`, `template-intersection.php`, `template-subtype.php`,
`single-location-neighborhood.php`) each carry their own copy, which is the duplication
`CLAUDE.md` warns about. The full set:

| Class | Where | Count |
|---|---|---|
| `widget-title` | 4 shared PA templates, `single-location.php`, `single.php`, `home.php`, `index.php`, `category.php`, `tag.php`, `search.php`, `template-attorney.php`, `page-class-action-lawyers.php`, `template-tags.php`, 4 × `register_sidebar()` in `functions.php` | 34 |
| `footer-heading` | `footer.php` | 5 |
| `matrix-title` | `template-intersection.php`, `template-practice-area.php` | 2 |
| `nap-name` | `template-intersection.php` | 1 |
| `form-title` | `inc/template-tags.php` | 1 |
| `footer-state-heading` | `footer.php` (re-nested to `h4` under its new `h3` column) | 1 |

**Fix:** demote to `h3` (`h4` for the footer's nested state heading). Every one of these classes
sets `font-size`, `font-weight`, `font-family` and `color` at class specificity, which beats the
bare element rule — so the change is visually neutral. They sit inside `aside`/`footer`
landmarks, so nothing is lost for accessibility.

One deliberate exception: `page-class-action-lawyers.php:81` keeps its `h2`. On the class-action
hub the tort matrix *is* the page's content, not cross-link navigation.

---

### F4 — Duplicate `What to Do After` H2s on 3 SC pages — **MEDIUM**

`/car-accident-lawyers/charleston-sc/`, `/columbia-sc/` and `/myrtle-beach-sc/` each carry two
near-identical consecutive H2s:

```
What to Do After a Car Accident in Charleston        ← post body prose
What to Do After a Car Accident in Charleston, SC    ← template, roden_what_to_do_steps()
```

`inc/template-tags.php:2066` emits the second inside a `data-ai-extractable="true"` block. Two
competing answers to one question splits the extraction signal.

**Correction (2026-08-19, during execution):** this audit's first recommendation — "remove the
body-authored heading; the template block is canonical" — was **backwards**, and checking the
two blocks side by side is what showed it. The template's list is the same generic six steps on
every car-accident page ("Ensure safety and call 911", "Document the scene"…). The body's list
is locally specific on all three pages:

| Page | What only the body version says |
|---|---|
| Charleston | Charleston PD / county sheriff / SCHP by crash location; MUSC Health as the Lowcountry's only Level I trauma centre; the Charleston office number |
| Columbia | Columbia PD / Richland County Sheriff / SCHP; Midlands highway crash context; the Columbia office number |
| Myrtle Beach | Myrtle Beach PD / Horry County police / SCHP; Grand Strand Medical Center and Tidelands Waccamaw; "call before you leave town" for out-of-state visitors |

The body copy is the differentiated content. But the template block is what feeds the `HowTo`
JSON-LD — a schema type no competitor in this market emits — so deleting it would trade a real
GEO asset for a heading fix.

**Fix applied:** retitle the body heading so the two stop competing, keeping both the local copy
and the HowTo schema. `bin/retitle-what-to-do-duplicates.php` sets "Your {City} Crash Checklist"
on posts 3624 / 3625 / 3626. Idempotent, verifies each write, and skips rather than guesses if
the expected heading is not found exactly once. Bodies backed up to `data/db-backups/` first.

**Open question, not a today fix:** the generic template steps are weaker content than the local
ones on every page that has both. Feeding the `HowTo` schema from local steps instead would be
the better end state — but that is a template refactor touching ~400 pages and a content call,
not a bug fix.

---

### F5 — Entity graph is thin — **MEDIUM**

- `Organization` `sameAs` lists **5 social profiles only** (Facebook, Instagram, LinkedIn,
  YouTube, X). No BBB, no Wikidata, no Crunchbase.
- `firm-data.php:443` declares `legal_directories` with `bbb`, `wikidata` and `crunchbase` all
  set to `''` — **while a live BBB profile exists** at
  `bbb.org/us/sc/charleston/profile/legal-malpractice-attorney/roden-law-0663-34348463`.
  That profile is filed under **"legal malpractice attorney"** — the wrong practice. Roden is a
  plaintiff-side PI firm. A third-party directory is currently telling AI engines the firm does
  something it does not.
- Per-office `sameAs` uses opaque `share.google/…` shortlinks rather than canonical
  `google.com/maps/place/?q=place_id:…` URLs. All six Place IDs are known:

  | Office | Place ID |
  |---|---|
  | Savannah | `ChIJITbCLWSe-4gRMCR5SgvdFxk` |
  | Darien | `ChIJXQbDRmsr-4gRjV1Mk7Zh4-k` |
  | Charleston | `ChIJkx4ENNF7_ogRd1O08AhaJSw` |
  | North Charleston | `ChIJS2CVHEh7_ogRIEA4SfdJ3A8` |
  | Columbia | `ChIJQZdkRQCl-IgRVi202Pu6b1I` |
  | Myrtle Beach | `ChIJXV6kZKE5AIkRS6GJSoJ0xAA` |

Third-party profiles are also carrying a **"Roden Love LLC"** name variant (trustindex.io) and
a Charleston-only footprint (accidentlawyerreview.com lists one city, one state, two practice
areas).

---

### F6 — Freshness and authorship coverage — **MEDIUM**

`_roden_last_reviewed` is rendered by the theme (`#28`, `#30`) but populated on only
**101 of 703 published posts (14%)**:

| Type | Published | Has review date | Has author |
|---|---|---|---|
| practice_area | 414 | 81 (20%) | 414 (100%) |
| resource | 78 | 14 (18%) | 78 (100%) |
| location | 211 | 6 (3%) | **0 (0%)** |

The 211 location pages carry no author attribution at all — no E-E-A-T signal on the pages that
target the highest-commercial-intent local queries.

---

### F7 — 201 two-state pages bylined to Georgia-only attorneys — **MEDIUM (E-E-A-T)**

| Attorney | Bar admissions | `jurisdiction: both` pages |
|---|---|---|
| Eric Roden | Georgia only | 195 |
| Tyler Love | Georgia only | 6 |

SC-specific pages are attributed correctly (Graeham Gillin — 184; Ivy Montano — 9; both
SC-licensed). The gap is the 201 pages that discuss **South Carolina and Georgia law** under
the byline of an attorney not admitted in South Carolina. `606d820` made the byline render
actual admissions, which is honest — but it now visibly reads "Licensed in Georgia" on pages
covering SC law.

**Fix:** co-attribute the two-state pages (reviewing attorney per state), or reassign the
SC-touching subset to Dorminy (GA + SC).

---

### F8 — Jurisdiction meta has six spellings for three values — **LOW (latent trap)**

`content/meta.json` holds `both`, `GA`, `ga`, `SC`, `sc`, `south-carolina`, `georgia-only`.
The admin UI (`inc/meta-boxes.php:239`) only ever writes `both`/`GA`/`SC`; the rest came from
seeders.

`inc/template-tags.php:1447` resolves sub-type pages with:

```php
$jur       = strtolower( (string) ( get_post_meta( $post_id, '_roden_jurisdiction', true ) ?: 'both' ) );
$state_key = ( 'sc' === $jur ) ? 'SC' : 'GA';
```

Any sub-type page carrying `south-carolina` would silently resolve to **Georgia**.

**Currently no page is affected** — all 119 `south-carolina` pages also carry
`_roden_pa_office_key`, so they take the office-driven branch above it, and the 15 sub-type
pages use `sc`. Verified live: SC pages render SC statutes correctly. This is a trap, not a
live bug — but it is precisely the failure mode `CLAUDE.md` documents recurring.

**Fix:** normalize the meta to `both`/`GA`/`SC`, and make the resolver fail loudly on an
unrecognized value instead of defaulting to Georgia.

---

### F9 — Smaller items

- **`llms.txt` cites no authority for the SC comparative-fault rule.** Georgia's gets
  `O.C.G.A. § 51-12-33`; South Carolina's is a bare sentence. The authority is
  **Nelson v. Concrete Supply Co., 303 S.C. 243, 399 S.E.2d 783 (1991)** (verified), which
  adopted modified comparative negligence for causes of action arising on or after 1991-07-01.
  The precise standard is that a plaintiff recovers when their negligence is *"not greater
  than"* the defendant's — compared against the **combined** negligence of all defendants where
  there is more than one. Roden's current "less than 51%" phrasing is functionally correct but
  loses the multi-defendant nuance.
- **Myrtle Beach NAP mismatch.** Labeled "Myrtle Beach, SC" everywhere; the address is
  631 Bellamy Ave., **Murrells Inlet**, SC 29576 (~15 mi south). Deliberate market targeting is
  reasonable, but the label/address split is a citation-consistency risk.
- **`llms.txt` practice-area descriptions are boilerplate.** Fifteen of ~24 open with the same
  "Roden Law's X Lawyers represent injury victims across Georgia and South Carolina. With over
  $300 million recovered and 5,000+ cases handled…" string. Low information density for a file
  whose entire purpose is machine comprehension.
- **Duplicate FAQ questions on 10 published pages** — all in the Savannah GA cluster
  (Bloomingdale, Bryan County, Eastside Savannah, Guyton, Isle of Hope, Skidaway Island,
  Springfield, Thunderbolt, Westside Savannah, Whitemarsh Island). One repeated question each.
- **`Organization` on `/es/`** — no issue found; the ES home schema shipped in `1b96026`.

---

## Part 2 — South Carolina competitive analysis

### Scale (Semrush, US database, 2026-08-19)

| Domain | Organic KW | Est. traffic | KW with AI Overview | Featured snippets | Local pack |
|---|---|---|---|---|---|
| **rodenlaw.com** | **5,703** | **1,470** | **2,749 (48%)** | **56** | 2,785 |
| joyelawfirm.com | 18,637 | 14,242 | 9,664 (52%) | 201 | 8,995 |
| steinberglawfirm.com | 27,696 | 40,291 | 10,347 (37%) | 197 | 19,533 |
| derricklawfirm.com | 9,485 | 47,088 | 3,190 (34%) | 57 | 7,186 |
| goingslawfirm.com | 6,836 | 287,553 | 2,774 (41%) | 53 | 4,636 |

Two readings matter.

**Traffic per keyword.** Roden converts 0.26 visits per ranking keyword; Joye 0.76, Steinberg
1.45, Derrick 4.96. Roden ranks broadly and shallowly — the footprint exists, the positions
don't.

**Featured snippets.** Roden holds 56 against Joye's 201 and Steinberg's 197 — roughly
3.5× fewer, despite a demonstrably better answer-first content system. Featured snippets are
the closest available proxy for "Google successfully extracted a discrete answer from this
page," and they feed AI Overviews directly. **F3 (chrome headings) is the most likely
explanation and the most direct lever.**

### Content footprint

| | Roden | Steinberg |
|---|---|---|
| Indexed pages (sitemap) | 703 published | **1,940** |
| Truck-accident pages | — | 168 |
| Auto-accident pages | — | 90 |
| SC city × auto-accident pages | 4 SC cities | **50** |
| Spanish pages | 79 | **970 (50% mirror)** |

Steinberg has built a statewide city grid — Walterboro, Pawleys Island, McClellanville, Folly
Beach, Awendaw, Kiawah Island, Kingstree, Barnwell, Camden, Travelers Rest and 40 more — while
Roden covers four SC cities. That gap explains most of the 27,696 vs 5,703 keyword difference.

Steinberg's 970-page Spanish mirror also means **Roden's Spanish program is not the
differentiator it is in the Georgia market.** Roden has 79 translated pages against Steinberg's
970.

### GEO posture across the market

| Domain | `llms.txt` | Source | AI bots named in robots.txt |
|---|---|---|---|
| **rodenlaw.com** | **16.6 KB** | **hand-authored** | **13** |
| hawklawfirm.com | 107 KB (+2.2 MB full) | AIOSEO Pro v5.0.0.1 | 0 |
| stromlaw.com | 634 KB | AIOSEO Pro v5.0.0.1 | 0 |
| joyelawfirm.com | 7.5 KB | Yoast SEO v28.2 | 0 |
| justiceislovely.com | 2.4 KB | Yoast SEO | 0 |
| hugheylawfirm.com | 6.8 KB | — | 0 |
| goingslawfirm.com | 2.5 KB | Yoast SEO v28.2 | 0 |
| steinberglawfirm.com | 79 bytes | stub | 0 |
| derricklawfirm.com | absent | — | 0 |
| scinjurylawfirm.com | absent | — | 0 |

**7 of 10 competitors now publish `llms.txt` — but every one is an auto-generated link dump.**
None carries firm credentials, jurisdiction facts, statutory citations or citation guidance.
Roden's file is the only curated one in the market.

The corollary: *having* an `llms.txt` is no longer a differentiator, and explicit AI-crawler
naming never was one (a default-allow `robots.txt` already permits every AI bot). **The moat is
the structured facts inside the file, not the file.**

### Page-level head-to-head — "Charleston car accident lawyer"

| | Roden | Steinberg | Joye | Hughey | Derrick |
|---|---|---|---|---|---|
| Words | 3,334 | 2,222 | 3,236 | **7,348** | 2,045 |
| Content H2s | 18 (+13 chrome) | 1 | 10 | **10 (0 chrome)** | 14 |
| Question headings | 3 | 0 | 6 | 3 | 1 |
| **Statute citations** | **2** | **0** | **0** | **0** | **0** |
| FAQPage schema | ✅ 6 Q | ❌ | ✅ 5 Q | ✅ 4 Q | ❌ |
| Key takeaways | ✅ | ❌ | ❌ | ✅ | ❌ |
| Author byline | ✅ | ✅ | ✅ | ❌ | ❌ |
| `HowTo` / `Speakable` | ✅ | ❌ | ❌ | ❌ | ❌ |
| Distinct schema types | **21** | 20 | 18 | 21 | 7 |

Roden's page is the most richly marked-up in the market and the only one grounded in primary
law. Hughey wins on depth (2.2× the words) and on heading discipline.

### What AI engines actually cite in SC

**Informational intent — Roden wins.**
Query: *"how long do I have to file a car accident lawsuit in South Carolina"*

| # | Source |
|---|---|
| 1 | nolo.com |
| **2** | **rodenlaw.com/blog/south-carolina-statute-of-limitations-personal-injury/** |
| 3 | hammacklawfirm.com |
| … | |
| **7** | **rodenlaw.com/resources/south-carolina-statute-of-limitations/** |
| 14 | scstatehouse.gov (primary source) |

Both Roden pages were extracted at length — the statute table, the tolling rules, the Tort
Claims Act carve-out. This is the answer-first + cited-authority + table format working exactly
as designed, and it is beating every competitor in the market.

**Commercial intent — Roden is absent.**

Query: *"best car accident lawyer Charleston South Carolina"* — **6 of 15** sources are
directories (Super Lawyers, Avvo, Expertise, Lawyers.com, FindLaw, Attorney at Law Magazine).
Firms cited: Kahn, Sanders, Steinberg ×2, Sink, Hughey, Hoffman, Pierce Sloan, John Price.
**Roden: not cited.**

Query: *"top personal injury attorney Columbia SC and Myrtle Beach best law firm"* — **10 of
12** sources are directories and listicles (Super Lawyers ×2, Justia ×2, Enjuris, Best Lawyers,
BestLawFirms, Cornell, Lawyers.com, lawfirmsquare, getcodeshealth). **Roden: not cited.**
Goings Law Firm is cited repeatedly across them — which is what its 287k traffic and rank
8,162 actually reflect.

This is the strategic finding of the audit. For high-commercial-intent queries the AI answer is
**assembled from third-party lists, not from firm websites**. Roden's on-site excellence cannot
reach those answers. Semrush corroborates it independently: superlawyers.com and justia.com are
Roden's #1 and #2 organic competitors by shared keywords.

---

## Part 3 — Recommendations

### Run today

| # | Action | Where | Why |
|---|---|---|---|
| **1** | Correct the six `review_count` values to live GBP (59 / 0 / 105 / 2 / 2 / 2) and suppress `AggregateRating` where count < 5 | `inc/firm-data.php` 95–342; `inc/schema-helpers.php` 518 | Removes a live structured-data violation, incl. a 4.9★ claim on a 0-review profile |
| **2** | Demote the 45 chrome `<h2>` emitters to `h3`/`h4` | 16 files — see F3 | Removes ~45% of heading noise sitewide; most direct lever on the 56-vs-200 featured-snippet gap |
| **3** | Delete the duplicated `What to Do After…` H2 from the body of the 3 SC car-accident pages | wp-admin (editorial) | Stops two headings competing to answer one question |
| **4** | Add `Nelson v. Concrete Supply Co., 303 S.C. 243, 399 S.E.2d 783 (1991)` to the SC comparative-fault line, with the "not greater than the defendants' combined negligence" standard; bump `RODEN_LLMS_TXT_VERSION` | `inc/llms-txt.php` | Only firm in the market citing SC authority; the file is stale without the version bump |
| **5** | Add Columbia's phone number to its GBP; add secondary categories to the five single-category profiles | GBP (needs owner access) | Columbia is a live office with an incomplete listing |
| **6** | Claim/correct the BBB profile — it currently files Roden under **"legal malpractice attorney"** — then wire `bbb` into `legal_directories` and `Organization.sameAs` | BBB + `inc/firm-data.php` 443 | A directory is telling AI engines the wrong practice area |
| **7** | Replace `share.google/…` shortlinks with canonical `?q=place_id:` URLs (all six IDs in F5) | office `gbp_url` in `firm-data.php` | Binds each office to its Google entity unambiguously |

Items 1–4 and 7 are code and ship through the normal deploy. **Do not edit production
directly** — `deploy.yml` force-pushes and the drift guard will block.

Item 5 and 6 need account access; hand those to the client via `!`.

### Next (this cycle)

8. **Launch an SC review-generation push.** Three offices at 2 reviews each is the ceiling on
   everything else. Target Columbia, North Charleston and Myrtle Beach specifically. This
   outranks every remaining item on this list in expected impact.
9. **Get listed where the AI answers come from.** Super Lawyers, Justia, Avvo, Expertise,
   Best Lawyers, Enjuris and Lawyers.com are the actual sources for SC "best lawyer" queries.
   Roden's SC-licensed attorneys (Gillin, Reidy, Stohr, Montano) need complete, review-bearing
   profiles on each. This is the only route into commercial-intent AI answers.
10. **Populate `_roden_last_reviewed`** across the 602 published posts without one — location
    pages first (6/211).
11. **Attribute the 211 location pages.** They carry no author at all; assign the SC ones to
    Gillin/Montano and the GA ones to Roden/Dorminy.
12. **Resolve the 201 two-state bylines** — co-attribute per state, or move the SC-touching
    subset to Dorminy (GA + SC).
13. **Normalize `_roden_jurisdiction`** to `both`/`GA`/`SC` and make the sub-type resolver fail
    loudly rather than defaulting to Georgia (F8).
14. **Rewrite the boilerplate practice-area descriptions in `llms.txt`** — 15 near-identical
    openers is wasted space in the one file written purely for machine consumption.
15. **Fix the 10 duplicate FAQ questions** in the Savannah location cluster.

### Strategic

16. **Close the SC city gap.** Steinberg holds 50 SC city × auto-accident pages to Roden's 4.
    A statewide SC city grid is the largest single organic opportunity in this market — but
    build it with Roden's cited-authority template, not Steinberg's thin one.
17. **Reassess the Spanish program in SC.** Steinberg runs a 970-page Spanish mirror against
    Roden's 79 pages. Spanish is a differentiator in Georgia; in South Carolina it is table
    stakes and Roden is well behind.
18. **Defend the informational win.** Roden already outranks the entire market on SC
    informational queries. That is the current beachhead — the SOL, comparative-fault and
    Tort Claims Act cluster should be expanded and kept fresh before chasing new ground.

---

## Execution log — 2026-08-19

| # | Item | Outcome |
|---|---|---|
| 1 | Review counts + `AggregateRating` gate | **Live** (PR #33). Verified: Savannah 4.9/59, Charleston 4.9/105, Darien / N.Charleston / Columbia / Myrtle Beach suppressed. |
| 2 | Demote chrome headings | **Live** (PR #33). 45 emitters across 16 files. Re-measured on the same 30 SC pages: chrome H2 **13 → 0**, content H2 16.1 → 16.1 (nothing lost), first content H2 index **3 → 0** on all 30. |
| 3 | Retitle duplicate `What to Do After` | **Live** (DB, `bin/retitle-what-to-do-duplicates.php`). All three self-verified; no near-duplicate H2 pairs remain and the `HowTo` schema is intact with 7 steps. |
| 4 | Cite *Nelson v. Concrete Supply Co.* | **Live** (PR #33), present in both the Jurisdiction and Key Legal Facts sections. |
| 5 | Canonical Place ID URLs | **Live** (PR #33), all six offices. |
| 6 | Columbia GBP phone + categories | Open — needs client account access. |
| 7 | BBB category + `sameAs` | Open — needs client account access. |

Also fixed in passing: the location-page sentence that rendered *"Rated 4.9 stars from
Hundreds of 5-Star Reviews client reviews"* on all 211 location pages now reads
"from 170+ verified Google client reviews", derived from the same live sum as the schema.

### F10 — `llms.txt` published 404s for both SC attorneys — **HIGH (found during verification)**

`inc/llms-txt.php` built `/attorneys/{key}/` from the `firm-data.php` array key. For five of
seven attorneys the key equals the WP post slug; for two it does not:

| Published in `llms.txt` | Real post slug | Status |
|---|---|---|
| `/attorneys/graeham-gillin/` | `graeham-c-gillin` | **404** |
| `/attorneys/ivy-montano/` | `ivy-s-montano` | **404** |
| `/attorneys/kiley-reidy/` | `kiley-reidy` | 301 — post is a **draft** |
| `/attorneys/zach-stohr/` | `zach-stohr` | 301 — post is a **draft** |

Both 404s were the South Carolina attorneys, and **Graeham C. Gillin carries the byline on 202
SC pages**. The site's own bylines were always correct — templates and `roden_schema_person()`
resolve via `get_permalink()` — so `llms.txt`, the file written specifically for AI engines,
was the only place on the site publishing a dead link for the firm's SC partner. An engine
following it to verify authorship found nothing.

**Fixed** in PR #34: resolves each permalink the way the schema does, matching on `post_title`
so there is no second hand-maintained slug field to drift. Attorneys whose bio is unpublished
are listed without a link rather than linked to a redirect.

**Open (editorial):** Kiley Reidy's and Zach Stohr's bio posts are drafts. Publishing them is
the real fix — both are SC-licensed, and the SC roster is exactly the E-E-A-T signal F7 is
about.

This is the same failure class as F1 and F8: a hand-maintained value in `firm-data.php` quietly
becoming a false published claim.

---

## Appendix — what shipped since 2026-07-08

`1b96026` (class-action visibility, ES home schema, dead-LP 301s) and `2f37142` (class-action
FAQs) closed **G1**, **G2** and **G3**. Class actions are present in `llms.txt`; `/es/` carries
a full schema graph. **G5** (case-result titles) remains open and is unchanged from the prior
audit's assessment: an editorial task, not a code task.
