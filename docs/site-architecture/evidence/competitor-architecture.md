# Competitor site architecture (sitemaps curled 2026-09-26; Semrush US top pages 2026-09-26)
Counts come from a heuristic URL classifier (classify.py) - approximate, +/-10%.
Organic traffic totals are derived from top-page traffic / traffic share (Semrush estimates).

| Firm (HQ) | URLs in sitemap | City hubs | Practice x city | Unlocalized/statewide practice | Blog/news | Spanish | Est. organic traffic/mo | Where the traffic is |
|---|---|---|---|---|---|---|---|---|
| treyhelps.com (Charleston/Summerville) | ~247 | ~12 (/summerville-personal-injury-lawyer/, /west-ashley-.../) | ~79 (~38 under /charleston-injury/ hub + ~40 Summerville/West Ashley x practice) | ~6 | ~105 | 0 | ~9,650 | GBP-tagged homepage 47%; GBP-tagged /charleston-injury/car-accident-lawyer/ 25%; homepage 8%; blog cost post 3%. ~80% via GBP landing URLs |
| steinberglawfirm.com (Charleston HQ; Lowcountry offices) | ~4,140 | ~22 (/locations/<city>/, /goose-creek/, /summerville/) | ~184 (/locations/<city>/<practice>/) + ~100 /personal-injury/{auto,truck}-accidents/south-carolina/<town>-lawyer/ | ~570 /personal-injury/... incl sub-types; 97 /workers-compensation/ | ~1,070 | ~2,070 (/es/ mirror) | ~44,700 | homepage 39%; /personal-injury/personal-injury-lawyers/ 19%; /goose-creek/ office page 14%; /summerville/ 3%; truck practice 2.7%; auto practice 1.5%; best town page (conway car) 0.45% |
| joyelawfirm.com (Charleston HQ; N.Chas, MB, Summerville, Columbia, Clinton) | ~2,200 | ~42 (/<city>/) | ~110 (/<city>/<practice>/) | ~330 (/accidents/..., /workers-compensation-lawyer/...) | ~1,300 (blog+news) | ~28 | ~16,000 | homepage 33%; /myrtle-beach/ 8.9%; /summerville/ 7.8%; /goose-creek hub 2.4%; /columbia/ 1.9%; /charleston/ 1.5%; /myrtle-beach/car-accident-lawyer/ 1.6% |
| sinklaw.com (~15 SC/GA offices) | ~1,200 | ~51 (/<city>/, /service-area/<city>/) | ~253 (/<city>/<practice>/) | ~215 (FAQ + practice) | ~456 | 0 | ~94,000 (brand-heavy) | /attorneys/ 32% + /attorneys/george-sink/ 10.5% (brand); homepage 27%; GBP-tagged /charleston/ 16%, /greenville/ 2.5%, /myrtle-beach/ 1.2%; /columbia/car-accident-lawyer/ 0.4% |
| farahandfarah.com (FL/GA; Savannah + Brunswick) | ~1,030 | ~47 | ~172 (/<city>/<practice>-lawyer/; 16 Savannah, 8 Brunswick) | ~81 (/florida/..., /georgia/...) | ~204 | ~61 | not pulled | #1 savannah car accident lawyer with /savannah/car-accident-lawyer/ |
| maguirelawfirm.com (Myrtle Beach HQ; Florence) | ~225 | ~5 (/locations/...) | ~27 (/myrtle-beach/<practice>/) | ~1 | ~76 + 87 podcast | 0 | ~4,400 | GBP-tagged homepage 38% + homepage 34% + Florence GBP homepage 7.6% = ~80% homepage; stat blog posts 4-8%; p x c pages <2% each |
| rodenlaw.com (for comparison) | n/a | 6 office + sub-city /locations/ | 0 live since 2026-09-19 (#143: 47 retired, 301 to two-state /practice-areas/ pillars) | ~22 two-state pillars + sub-types | n/a | yes | ~1,770 | homepage 26%; GBP-tagged Charleston city page 13%; blog 5% each; everything else <3% |

## Pattern
1. Homepage + GBP landing URL carry 40-80% of every competitor's non-brand traffic. Semrush traffic on `?utm=gmb` URLs is local-pack visibility, not the blue links.
2. Multi-office firms (Joye, Sink, Steinberg satellites) put the city hub (/<city>/) on the GBP. That hub is their second-biggest page. Their practice x city pages each carry ~0.4-1.6%.
3. Steinberg's ~100 programmatic town x practice pages under /personal-injury/*/south-carolina/ carry almost nothing (best: 0.45%).
4. AI answers (Radar 2026-09-11 cycles; raw domain-mention counts, includes brand probes, so not clean share): superlawyers ~75, justia 50-70, avvo ~60, lawyers.com ~60, expertise.com ~50, steinberglawfirm 56-75, joyelawfirm 61, sinklaw 23-31, derricklawfirm ~30, forthepeople ~30.
