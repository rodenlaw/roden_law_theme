# Spanish Site — Phase 4 Activation

Date: 2026-07-07 · Spanish silo: 70 published pages (launched 2026-07-06)

## 1. Baseline (recorded 2026-07-07 — day 1 post-launch)

**Organic**: rodenlaw.com ranks for **zero Spanish keywords** (Semrush US database — clean pre-launch baseline; re-pull in 30/60/90 days filtered on "abogado").

**Demand + CPC (Semrush US, monthly)**:

| Keyword | Volume | CPC | Competition idx |
|---|---|---|---|
| abogados de accidentes | 18,100 | $126.79 | 0.22 |
| abogado de accidentes | 9,900 | $126.79 | 0.22 |
| abogado de lesiones personales | 9,900 | $66.48 | 0.11 |
| abogado de accidente de carro | 6,600 | $158.85 | 0.74 |
| abogado(s) de accidentes de auto | 5,400 ea | $118.54 | 0.28 |
| abogado de accidentes de camiones | 2,900 | $180.09 | **0.03** |
| abogado de compensacion laboral | 1,300 | $28.73 | 0.33 |
| abogado de accidentes de trabajo | 1,300 | $38.24 | 0.84 |

Read: high CPCs but low competition indices on several core terms (truck at 0.03 is nearly uncontested); workers-comp Spanish clicks are cheap ($29–38) relative to the case value — that's the arbitrage, and it's the audience the /es/ silo serves best.

**GBP**: 6 Spanish announcement posts scheduled via Postplanify for 2026-07-07 (one per office, 16:00–18:30 UTC), CTA → each office's /es/ page with `utm_campaign=es_launch_{city}`.

## 2. Manual steps for Brian (need account access I don't have)

**Search Console** (property already covers /es/):
- URL-inspect + Request Indexing: `/es/`, `/es/practice-areas/car-accident-lawyers/`, `/es/workers-compensation-lawyers/charleston-sc/`, `/es/south-carolina-workers-compensation-lawyer/`, `/es/resources/how-much-does-south-carolina-workers-comp-pay/`
- Watch Indexing → Pages and the hreflang signals over ~2 weeks. The sitemap already lists all /es/ URLs.

**GA4**: Admin → Custom definitions → Create custom dimension: name `Site Language`, scope Event, event parameter `site_language` (already pushed to dataLayer before GTM on every page). Optionally add a GTM variable + attach to the config tag if the parameter isn't flowing automatically. Annotate 2026-07-06 as the ES launch.

## 3. Fluent-speaker review checklist (~70 pages; priority order)

1. **Legal-weight strings first**: TCPA consent (contact form on any /es/ page), footer disclaimers (all /es/ pages), results disclaimer.
2. **Workers-comp figures**: /es/resources/ WC guides — 2025/2026 comp rates ($1,134.43 / $1,189.94), § 42-9-30 week table, mileage rate, Form 30 fee. Verify against the EN pages (figures were carried verbatim; check nothing drifted in phrasing).
3. **Statute statements** on pillars/intersections/statewide LPs: "2 años (O.C.G.A. § 9-3-33)" / "3 años (S.C. Code § 15-3-530)" / WC deadlines.
4. **Immigration-status reassurance wording** (WC + construction pages, FAQ hub) — tone check: reassuring, not promissory.
5. Spot-read one page per template type: homepage /es/, a pillar, an intersection, an office, a statewide LP, a resource, the FAQ hub.
- Corrections are ordinary WP edits (Pages / Practice Areas / Locations / Resources; chrome strings live in `languages/es_ES.po` → recompile + deploy).

## 4. Spanish intake brief (for the intake team / msimons)

- Every Spanish web lead arrives with **`lead_language: es`** on the Gravity Forms entry and **`language: "es"`** in the intake webhook payload (Railway). Leads from /es/ pages without the field also infer `es` from the source URL.
- The /es/ site promises: *consultas en español las 24 horas* and *su consulta es confidencial sin importar su estatus migratorio*. Intake must be able to honor both — Spanish-speaking first response (or immediate warm transfer), and no immigration-status questions beyond what the case requires.
- Speed-to-lead applies double: this audience gets fewer callbacks from competitors in Spanish; first firm to respond in-language usually signs.
- Suggested routing: filter/alert on `lead_language=es` → route to Spanish-capable staff; track sign rate separately.

## 5. Spanish PPC campaign draft (BLOCKED pending Brian's go — see note)

Automation note: the agent permission layer blocked Google Ads account access
(even read-only) as unauthorized ad-spend scope. To proceed, either say
"build the Ads drafts" in a session (approving the account access when prompted)
or run the toolkit manually. Draft spec, ready to transcribe into
`scripts/google-ads/configs/roden-es-search-2026-07-07.yaml` (Aithority repo,
`create_campaign.py`, validate-only default, campaign ships PAUSED):

- **Campaign**: `RL | ES | SC Spanish PI | Search` — daily budget $150, Maximize Conversions (tCPA ~$300), geo: South Carolina (id 21173, PRESENCE), **language: Spanish (1003)**, search only.
- **Ad groups → landing pages** (phrase match unless noted):
  1. *Auto* — abogado de accidentes, abogados de accidentes, abogado de accidentes de auto, abogado de accidente de carro, abogado de choques → `/es/south-carolina-car-accident-lawyers/`
  2. *Camiones* — abogado de accidentes de camiones, abogado de accidente de camion (+exact) → `/es/south-carolina-truck-accident-lawyers/`
  3. *Compensación Laboral* — abogado de compensacion laboral, abogado de accidentes de trabajo, abogado laboral, me lesione en el trabajo → `/es/south-carolina-workers-compensation-lawyer/`
  4. *Lesiones Personales* — abogado de lesiones personales, abogados de lesiones personales, abogado hispano cerca de mi → `/es/south-carolina-personal-injury-lawyer/`
- **RSA copy direction** (per ad group, via `create_rsa.py`): headlines rotating — "Abogados de Accidentes en SC", "Hablamos Español 24/7", "Sin Honorarios a Menos que Ganemos", "Consulta Gratuita Hoy", "$300M+ Recuperados", "Su Estatus Migratorio No Importa" (WC group only); descriptions — consulta gratuita/confidencial + no paga nada por adelantado + oficinas en Charleston, North Charleston, Columbia y Myrtle Beach.
- **Phase 2 of PPC** (after SC proves out): Savannah GA metro campaign → `/es/car-accident-lawyers/savannah-ga/` etc. (needs a geo-ID lookup for the Savannah DMA — do not guess IDs).
- **Negatives to seed**: gratis consulta only-info terms as data shows; cross-negate "trabajo" terms out of the Auto group.

## 6. Success metrics (review at 30 days: ~2026-08-06)

- GSC: /es/ pages indexed count; impressions/clicks for "abogado" queries.
- GA4: sessions + form submits where `site_language=es`; GBP UTM sessions.
- GF/intake: count of `lead_language=es` leads; contact→sign rate vs English.
- Semrush re-pull: rodenlaw.com Spanish keyword count (baseline: 0).

## 7. 30-day review — recorded 2026-08-01 (day 26)

**Semrush (US database, `rodenlaw.com/es/`). Baseline was zero.**

| Metric | Value |
|---|---|
| Unique Spanish keywords ranking | 75 |
| Ranking positions (keyword × URL rows) | 111 |
| Distinct `/es/` URLs ranking | 25 |
| Positions in the top 5 | 17 |

Best: `abogado de accidentes de camiones en carolina del sur` #2 ·
`abogado de accidentes de camion en columbia` #3 · `abogado de accidentes de
charleston` #3. Head terms are on page 2–3 and are the next lift:
`abogado de accidente de camion` (1,900/mo, $124 CPC) #27, `abogados de
accidentes de auto cerca de mi` (880) #20, `abogado de accidente de peatón`
(720) #28.

GSC, GA4 and `lead_language=es` counts still need Brian's account access (§2).

**What the ranking data says to build** — Google is substituting adjacent pages
for practice areas the Spanish silo does not have. Thirteen top-20 rankings are
served by the wrong practice area:

| Query intent | Page actually ranking | Rows | Vol/mo |
|---|---|---:|---:|
| motorcycle | car-accident page | 4 | 370 |
| car | truck / construction page | 5 | 330 |
| bus | truck pillar / location hub | 2 | 220 |
| personal injury | location hub / car page | 3 | 190 |

`/es/practice-areas/personal-injury-lawyers/` **404s** — the head term
"abogado de lesiones personales" is 9,900/mo and currently lands on location
hubs at positions 55–99.

### Structural fixes shipped 2026-08-01 (theme 1.4.17 → 1.4.20)

The silo was routing its own internal links back into English. Fixed across
four commits; measured English links in the page body, before → after:

| Page type | Before | After |
|---|---:|---:|
| ES pillar | 24 | 7 |
| ES intersection | 15 | 11 |
| ES location | 34 | 6–15 |
| ES blog post | 40 | 8 |

What was wrong:

1. `roden_es_exclusion_meta_query()` applied unconditionally at 16 call sites —
   correct on English pages, backwards on Spanish ones. Replaced with
   `roden_locale_meta_query()` (`inc/i18n.php`). `inc/llms-txt.php` keeps the
   exclusion on purpose and is commented to say so.
2. Both practice-area grids built URLs from hardcoded slug literals with
   `home_url()`, so they could never emit `/es/`.
3. The blog sidebar was entirely English on `/es/`, and its unfiltered
   Recent-Posts query leaked the *other* way — Spanish posts in the English
   sidebar of 446 EN posts.
4. `/es/{pillar}/{city}/` with no Spanish post 301'd to the **English
   car-accident page for that city** via core's 404 permalink guessing —
   114 combinations. They now 301 to the Spanish pillar; the guess is disabled
   on `/es/`.

The residual English links are the language switcher plus pages with no Spanish
counterpart (attorney bios, privacy). Verified after deploy: every ES page type
still returns 200, `lang="es-ES"`, self-canonical, the en/es/x-default hreflang
trio, `inLanguage: es`, and its FAQ entities. English pillar and intersection
link counts are byte-identical to the pre-deploy baseline.

### In-body links (2026-08-01)

Templates were only half the problem. 236 links inside ES post bodies — authored
by the Spanish writer agent — pointed at English URLs. `bin/es-relink-body-links.php`
rewrote the ones with a published Spanish twin: **62 in the first pass, 14 more
after the Phase B pages landed**, leaving 160 whose targets genuinely have no
Spanish counterpart. It is idempotent; **re-run it after publishing any Spanish
page.**

`/charleston/` and `/savannah/` needed explicit mappings — they are legacy pages
that 301 to the *English* `/practice-areas/` hub, so from a Spanish body they
were wrong twice over.

## 8. Phase B — 19 pages, published 2026-08-01

Built the pages the ranking data asked for. Spanish practice-area URLs: **43 → 62**.

- `/es/practice-areas/personal-injury-lawyers/` — previously a **404**, against
  9,900/mo for "abogado de lesiones personales".
- `/es/{motorcycle,bicycle,pedestrian}-accident-lawyers/{6 office cities}/`

All 19 verified live: 200, `lang="es-ES"`, self-canonical, hreflang trio,
`inLanguage: es`, 5 FAQ entities per city page and 8 on the pillar, correct
per-state deadline (2 años in Georgia, 3 in South Carolina). The EN↔ES parity
diff across all 77 Spanish CPT posts is clean — zero SOL, jurisdiction, author
or reciprocal-backlink discrepancies.

Seeded with `bin/es-seed-pages.php`, which **inherits all legal and structural
meta from the English twin** and localises statutes by translating only the unit
word, so a citation can never be retyped or hallucinated. Writers supply prose
only, checked by a validator before anything reaches the database.

Two findings from that pass:

1. **Dormant wrong data on the English bicycle pages.** Savannah and Darien —
   both Georgia — carry a populated `_roden_sol_sc`. It is inert today because
   `_roden_jurisdiction` gates it, and the live pages render only the GA
   citation and a "2 yr" badge. It becomes a real bug the day the resolver or a
   jurisdiction value changes. Worth clearing.
2. **The Georgia city pages are boilerplate — in English.** The six GA-city
   pages across these three practice areas run ~1,520 characters against
   3,420–4,400 for the twelve South Carolina ones, and each city's motorcycle
   and pedestrian pages are byte-identical once the practice-area words are
   neutralised. Savannah is the firm's home market. This is an English content
   problem that the Spanish pages inherited and had to work around.

### Still open

- **Phase C**: the FAQ deficit — 22 ES pillars at 5 questions against 10 in
  English, and the SC personal-injury FAQ hub at 22 against 95.
- **Georgia resources in Spanish**: all 9 ES resources are South Carolina.
- **Fluent-speaker review** of the whole silo (§3) — still not signed off.
