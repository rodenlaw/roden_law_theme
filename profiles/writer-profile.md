# Writer profile — Roden Law

Read `profiles/firm-facts.md` (generated from `client.json`) alongside this file. Facts live there; this file is voice, content model, and house rules. Everything here overrides the generic rules in the shared writer agents. Memory namespace: `roden`.

## Who this firm is, in one paragraph

Roden Law (Roden Love LLC) is a six-office personal injury firm across coastal Georgia and South Carolina: Savannah and Darien in Georgia; Charleston, North Charleston, Columbia, and Myrtle Beach (Murrells Inlet) in South Carolina. Full PI practice including workers' compensation, but the local-SEO keyword universe is limited to vehicle and transport verticals. Two jurisdictions with different law, so every legal claim is stamped with its state.

## Platform and content model

- WordPress on WP Engine, a transitional platform: the pipeline publishes over SSH through the QA gate, and the firm moves to the standard Next.js build in Phase 5. You produce Markdown with YAML frontmatter; the pipeline converts it. You never touch the theme, the database, or WordPress admin.
- The firm is mid-way through an SEO pre-emption plan and a legal-accuracy remediation. No new location pages below city level, no city × practice pages in markets without an office, and every statute you cite must be one the brief supplies or one in the jurisdiction table below.

## House voice

- **Second person, direct, reassuring.** Real opener pattern: *"If you or a loved one has been injured in a car accident in Georgia or South Carolina, you deserve experienced legal representation that fights for maximum compensation."*
- **Empathy then authority.** Name the reader's situation before the law: *"A car accident in Savannah can change everything in an instant — mounting medical bills, lost income, and pain that disrupts every part of your life."*
- **Plain language, answer-first, short paragraphs.**
- **Zero-cost barrier, early and often.** "never charge upfront fees," "No fees unless we win," "you pay nothing upfront and no legal fees unless we win your case."
- **Concrete local color.** From the live Savannah page: "Abercorn Street and Truman Parkway are two of the most accident-prone corridors," "Chatham County Superior Court at 133 Montgomery Street," "Memorial Health University Medical Center on Waters Avenue — the region's only Level I trauma center." If you cannot ground a local claim in something real, cut it.
- **CTA style:** "📞 Call 844-RESULTS", "Free Case Review — No Fees Unless We Win".
- Not breathless, not fear-mongering, not padded. One authoritative guide beats five thin pages, but authoritative is not bloated.

## Firm stats (verbatim, never altered)

$300M+ recovered · 4.9-star average · 500+ client reviews · 5,000+ cases handled · 62 years combined experience · 6 offices · toll-free **1-844-RESULTS** · contingency fee, no fees unless we win. If a live Roden page contradicts a figure here, trust the live page and flag it.

## Jurisdiction rules (get these exactly right)

| | Georgia | South Carolina |
|---|---|---|
| PI statute of limitations | **2 years** — O.C.G.A. § 9-3-33 | **3 years** — S.C. Code § 15-3-530 |
| Claims against a government entity | per brief | **2 years** — S.C. Code § 15-78-110 (the Tort Claims Act imposes no pre-suit notice; a verified claim, if filed, must be received within one year under § 15-78-80) |
| Comparative fault | Modified; recover if **less than 50%** at fault — O.C.G.A. § 51-12-33 | Modified; recover if **less than 51%** at fault — *Nelson v. Concrete Supply Co.*; never cite § 15-38-15 for the plaintiff's bar (it governs apportionment among defendants) |
| Wrongful death | per brief | Filed by the estate's **personal representative** — S.C. Code § 15-51-20 |
| Uninsured motorist coverage | per brief | Mandatory — S.C. Code § 38-77-150 |
| Punitive damages | per brief | Capped — S.C. Code § 15-32-530 (greater of 3× compensatory or $500,000; never say SC has no cap) |
| Passing cyclists | per brief | SC has **no** three-foot passing law; § 56-5-3435 requires a safe operating distance only |

- Citation formats are strict: `O.C.G.A. § X-X-XX` and `S.C. Code § XX-X-XXX` (no "Ann."). Use the citations the brief supplies; flag anything else for verification rather than guessing a section.
- **Intersection and location pages show only the office's state.** Cross-jurisdiction law on a single-state page is an error and a template conflict. Pillars and most sub-type pages show both states side by side.
- Georgia seat-belt and child-restraint evidence rules changed under SB 68; use only what the brief says.

## Attribution (hard rule, corrected 2026-07-21)

- Georgia content: **Eric Roden**, founding partner. Inline prose: *"Eric Roden, Roden Law's founding partner, points out that …"*, placed after the section's direct answer.
- South Carolina content: an SC-barred attorney. Default **Graeham C. Gillin** (Charleston, North Charleston, Myrtle Beach) and **Ivy S. Montano** (Columbia). Eric Roden is not licensed in South Carolina; never attribute SC legal commentary or a "Last reviewed" line to him. Briefs sometimes hardcode Eric Roden on SC posts: swap to the SC attorney and keep the frontmatter consistent.
- Only attorneys in `firm-facts.md` exist. Departed attorneys must not appear.
- Every practice-area page gets an "About the Author" section; every blog post gets a visible byline.

## Local anchors per office (courts and service towns)

- **Savannah, GA** — Chatham County Superior Court · serves Savannah, Pooler, Richmond Hill, Hinesville, Statesboro, Brunswick.
- **Darien, GA** — McIntosh County Superior Court · serves Darien, Brunswick, St. Simons Island, Jekyll Island, Waycross.
- **Charleston, SC** — Charleston County Circuit Court (Court of Common Pleas) · serves Charleston, Summerville, Mount Pleasant, Goose Creek.
- **North Charleston, SC** — Charleston County Circuit Court · serves North Charleston, Hanahan, Ladson, the metro's northern corridor. A separate office and GBP from Charleston; keep their pages distinct.
- **Columbia, SC** — Richland County Circuit Court · serves Columbia, Lexington, Irmo, West Columbia, Cayce, Forest Acres.
- **Myrtle Beach, SC** — Horry County Circuit Court · office is in Murrells Inlet · serves Myrtle Beach, Murrells Inlet, Conway, Surfside Beach, Pawleys Island.

Addresses and phones are in `firm-facts.md`; use the office line for the post's territory plus 1-844-RESULTS.

## Page tiers

| Tier | URL pattern | Word target | Jurisdiction shown |
|---|---|---|---|
| Pillar | `/practice-areas/[slug]/` | 2,500+ | Both states |
| Intersection | `/[slug]/[city-state]/` | 1,500+ | The office's state only |
| Sub-type | `/[slug]/[sub-type]/` | 800+ (floor ~500) | Per brief, usually both |
| Blog (local-SEO cycle) | `/blog/[slug]/` | 1,500–2,400 (`config.writer.wordCountTarget`) | Per brief |

Pillars feed LegalService + FAQPage + BreadcrumbList + Speakable schema; intersections feed LegalService + LocalBusiness; sub-types must be materially differentiated from their pillar. The 22 practice-area slugs: car-accident, truck-accident, slip-and-fall, motorcycle-accident, medical-malpractice, wrongful-death, workers-compensation, dog-bite, brain-injury, spinal-cord-injury, maritime-injury, product-liability, boating-accident, burn-injury, construction-accident, nursing-home-abuse, premises-liability, pedestrian-accident, bicycle-accident, electric-scooter-accident, atv-side-by-side-accident, golf-cart-accident (each `-lawyers`).

## Output format — WordPress markdown

Pipeline blog drafts use exactly the frontmatter block the hand-off brief prints (`page_type`, `target_url`, `jurisdiction`, `_roden_author_attorney`, `primary_keyword`, `parent_weak_keyword`, `word_count`, `internal_links`, `schema_feeds`, `excerpt`, `imagePrompt`, `imageAlt`). The body's `# H1` becomes the post title. Attribution format is `<Name> (<office>, <bar>)`; the author slug is derived from the leading name.

Practice-area drafts for the content director use:

```
---
page_type: pillar | intersection | sub-type | blog
target_url: /practice-areas/dog-bite-lawyers/
jurisdiction: both | georgia-only | south-carolina-only
_roden_author_attorney: <attorney name> (<office>, <bar>)
_roden_office_key: <office slug, intersection pages only>
primary_keyword: <kw>
word_count: <actual>
internal_links: <count>
schema_feeds: [FAQPage, LegalService, ...]
---
```

FAQs use the `**Q:** … / **A:** …` bold-prefix format; the theme maps them to the FAQ repeater and to FAQPage structured data, so a wrong deadline in an FAQ is published twice. Never write JSON-LD yourself. No `>` blockquotes anywhere; the theme renders quote boxes the firm does not want.

## Internal linking

8–13 links per page from the brief's verified paths, with descriptive anchor text. Intersections and sub-types link up to their pillar. Anchors that promise one page and deliver another were the subject of a 2026-09 audit; the anchor names the destination's topic.

## Spanish content model (`pi-content-writer-es`)

- Output is a WordPress markdown draft at the path given (pipeline: `data/local-seo/runs/<run-id>/draft-<N>-es.md`). Frontmatter: `target_url: /es/blog/es-<english-slug>/` (the `es-` prefix is mandatory or the publish skips), `locale: es`, the same `jurisdiction` and attributed attorney as the English draft, Spanish `excerpt`. No `imagePrompt`/`imageAlt`/`featuredImage`: the twin reuses the English image.
- Patterns the Spanish QA gate checks: `Última revisión: YYYY-MM-DD` under the H1; `## Puntos Clave` first with 5–7 bullets; `## Preguntas Frecuentes` with ≥6 `**P:**`/`**R:**` pairs including "¿Cuánto cuesta contratar a Roden Law?"; ≥4 sentences starting `Según <Fuente>` (or `De acuerdo con`); one comparison table; 8–13 internal links.
- **Link each internal path to its `/es/` twin only after checking it**: `curl -sSL -o /dev/null -w '%{http_code} %{url_effective}\n' https://rodenlaw.com/es/<path>` and switch only on a 200 whose final URL is the one requested; otherwise keep the English URL and say why. City pages and pillars usually have twins; sub-types 301 to the pillar and most blog posts 404.
- Trust signals: "Atendemos en español." · "Su estatus migratorio NO le impide reclamar una compensación." · "Consulta gratis — no cobramos honorarios a menos que ganemos su caso." Phones: 1-844-RESULTS plus the office line.
- Spanish runs ~20% longer than English; draft to the low-middle of the word band. Never strip diacritics.
- Attribution in Spanish: GA → "Eric Roden, socio fundador de Roden Law, explica que …"; SC → "Graeham C. Gillin, socio y COO de Roden Law en Charleston, explica que …".

## Refresh specifics (`pi-content-refresher`)

The Roden freshness path does not exist yet; it arrives with the content adapter in Phase 2. Until then, refreshes are done by the operator's `bin/` remediation scripts, not by this agent.
