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
