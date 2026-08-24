# Architecture & Authority Plan — rodenlaw.com
## Rebuilding on the Steinberg model

**Handoff document for Claude Code + content team.** Companion to `SEO-PREEMPTION-PLAN-rodenlaw.md` (the cull). That plan removes the doorway layer before the next core update; this plan defines the architecture and authority program the surviving site grows into. Execute the cull first.

**Prepared:** 2026-08-21 · based on structural analysis of steinberglawfirm.com — Roden Law's direct Charleston competitor (27,356 keywords, 948 top-3, AS 39, 1,215 ref. domains; roughly tripled its visibility in the Dec 2025 update window while this site was stepped down). Note what that means: the model isn't theoretical — it is beating this firm in its home market right now.

---

## 1. The four principles being adopted (structure, never content)

1. **Ratio.** Location-genre pages ≤ 25% of indexable URLs (today: ~75%). Steinberg's city pages are a minority feature of a domain dominated by blog, research, attorney, and firm content. The sitewide classifier averages the domain; this ratio is the primary lever.
2. **Granularity floor: real municipalities.** Steinberg's floor is towns with courthouses (Walterboro, Camden, Sumter). Roden Law's floor is its six office cities plus genuinely served towns — never again neighborhoods (Old Village), subdivisions (Liberty Hall Plantation), or master-planned communities (Nexton, Carolina Park).
3. **Hierarchy, not permutation.** Steinberg nests: `/personal-injury/auto-accidents/south-carolina/[city]-car-accident-attorney/` — practice → sub-practice → state → city, a browseable tree. Roden's flat `{practice}-lawyers/{city}-{st}/` pile becomes a two-state tree (§2). Roden Law has something Steinberg doesn't — **two states** — and the hierarchy should make that a feature: GA and SC law differ (fault rules, caps, statutes of limitation), and pages that explain the differences are unique value no single-state competitor can copy.
4. **Linkable assets fund the domain.** Steinberg's SC car-accident and pedestrian studies earn the editorial links that let their templated town pages ride. Roden Law builds its own research engine (§3) — with a two-state, ports-and-corridors angle Steinberg can't match.

## 2. Target site architecture (~300 indexable URLs)

```
rodenlaw.com/
├── /                                     (1)   homepage
├── /about/  /contact/  /results/  etc.  (~8)  firm + class actions + legal pages
├── /attorneys/                           (~14) hub + partners/associates — bar no.,
│                                               admissions, verdicts, Person schema
│                                               (pages exist today — deepen them)
├── /practice-areas/                      (~40) one hub per REAL practice (the 17),
│   ├── car-accidents/                          sub-types as children where each has
│   │   ├── trucking/  motorcycle/  rideshare/  unique substance; single-employer and
│   │   ├── pedestrian-bicycle/                 single-road pages are gone (converted
│   ├── workers-compensation/                   to research/blog per the cull)
│   │   ├── maritime-jones-act/  port-workers/
│   ├── medical-malpractice/  dog-bites/
│   ├── premises-liability/  wrongful-death/
├── /locations/                           (~20) two state hubs + city tier ONLY:
│   ├── georgia/                                GA: Savannah (office), Darien (office),
│   │                                           Brunswick, + evaluated keeps from cull
│   ├── south-carolina/                         SC: Charleston (office), N. Charleston
│   │                                           (office), Columbia (office), Myrtle
│   │                                           Beach (office), + evaluated keeps
│   │                                           Office cities: full NAP, photos, GBP
│   │                                           embed, county courts, local results.
│   │                                           Non-office keeps: honest "served from X"
├── /research/                            (~8)  THE NEW ENGINE — see §3
├── /legal-guides/                        (~14) the two-state advantage (see §4):
│   │                                           GA-vs-SC fault, caps, deadlines, comp
├── /blog/                                (~90) comparison cluster + survivors (§4)
├── /resources/                           (~10) converted road/corridor studies (§3)
└── /es/                                  (~80) practice + office cities + top guides;
                                                Spanish pages that outrank English
                                                twins keep their standing per the cull
```

Rules: every page ≤3 clicks from home, one parent per page, new location pages require a partner-approved business case (new office or documented caseload), sub-city pages banned permanently.

## 3. The linkable research program — the two-state, ports-and-corridors edition

Public data: SCDPS collision statistics, GDOT crash portal, NHTSA FARS, USACE/GPA port data, FMCSA carrier data. Each study: methodology, downloadable data, embeddable charts, attorney byline + analyst credit. Pitch on publication (Post & Courier, Savannah Morning News, WTOC/WCSC/WIS, trucking + maritime trade press).

| Priority | Asset | Data source | Why it wins links |
|---|---|---|---|
| 1 | **The I-26 / I-95 Corridor Report** — fatal + serious truck crashes, annual | FARS, SCDPS, GDOT | Absorbs the culled road pages' real value (Two Notch, Ashley Phosphate become chapters, their links 301 here); recurring annual refresh |
| 2 | **Port Worker Injury Report: Savannah & Charleston** | OSHA, USACE, GPA/SCPA stats | Nobody else owns this niche; maritime + logistics trade press; feeds the Jones Act practice hub |
| 3 | **GA vs SC: The Border Crash Gap** — how outcomes differ by which side of the Savannah River you crash on | Both states' data + statutes | Unique to a two-state firm; irresistible local-news framing |
| 4 | **Golf Cart & LSV Injury Study** (Lowcountry + coastal GA) | SCDPS, local citations | The culled golf-cart pages had real traffic; this is their legitimate reincarnation |
| 5 | **SC's Deadliest Intersections** (annual, by metro) | SCDPS | Direct answer to Steinberg's studies in their shared market — refresh yearly |

Cadence: one flagship per quarter. Homepage placement; every practice and city page cites the relevant stat with an internal link.

## 4. Content: double down on what's already winning

The data says the blog comparison cluster is this site's best non-brand asset (compensatory-vs-punitive 14% of traffic, fault-vs-no-fault 8%). That's the seed of topical authority — grow it deliberately:

- **Two-state comparison cluster** (`/legal-guides/`): GA vs SC on fault/comparative negligence, damage caps, statute of limitations, UM/UIM requirements, workers' comp systems, dram shop. Nobody serving only one state can write these credibly. Each co-bylined by a GA-barred and SC-barred attorney — that's E-E-A-T no template can fake.
- **Money cluster:** whiplash compensation (already ranks), diminished value (already ranks), settlement timelines, lien negotiation, what adjusters actually do.
- **Process cluster:** police reports, IMEs, recorded statements, court timelines per state.

Cadence: 2–3 posts/month, every legal claim carrying a "reviewed by [attorney]" credit. No city-targeted posts. Spanish: translate the top 20 performers properly (the /es/ pages already outrank some English twins — this audience is real; serve it deliberately, not programmatically).

## 5. Links: earn, never buy — portfolio-wide

- **Hard rule across ALL firm properties** (rodenlaw, georgiaautolaw, and whatever policylimitscharters/iluvgus are): no paid links, PBNs, or citation blasts. The disavowed networks were bought by someone still active as of Aug 2026 — identifying and terminating that vendor is a prerequisite for everything in this section.
- Channels: research PR (§3) → GA + SC bar associations, trial lawyer associations (two states = double the ecosystem) → maritime/logistics trade press via the port study → community sponsorships with real pages → named-attorney expert commentary (HARO-style, local TV legal segments).
- Brand prerequisite: resolve Roden Law vs Roden + Love naming (one name, everywhere) so earned mentions consolidate on one entity. Domain migration stays frozen until two stable quarters.
- KPI: +10–15 editorial referring domains/quarter. Steinberg's moat is 1,215 referring domains vs this site's 491 — the gap closes through §3, nothing else closes it.

## 6. Sequencing & measurement

1. **Prereq:** `SEO-PREEMPTION-PLAN-rodenlaw.md` Phases 0–1 complete (manual-action check, vendor shutdown, disavow ✅ done, GBP fix, doorway cull).
2. **Weeks 1–4:** restructure practice tree (301 flat slugs into the hierarchy); deepen attorney pages; stand up `/legal-guides/` with the first 4 GA-vs-SC guides.
3. **Weeks 4–10:** Study #1 (I-26/I-95 Corridor Report), built partly from the culled road pages' material; PR push; 301 those pages' URLs to it.
4. **Quarterly:** one study; 2–3 posts/month; one new two-state guide/month.
5. **Measure in `RECOVERY-LOG.md`:** doorway ratio (target ≤25%), editorial ref. domains/quarter (baseline 491 total), pos 1–3 count (baseline 68 — the number that must survive the next core update), non-brand clicks. Judge across update boundaries only.

**The one-line version:** Steinberg wins the shared market with ~50 town pages riding on a research-and-reputation engine; Roden Law flips to the same shape — and differentiates with the two assets Steinberg can't copy: two states and two ports.
