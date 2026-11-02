# Roden Law: visibility read, November 2026

Written 2026-11-01 by local-visibility-lead. This is a proposal document. It schedules nothing, publishes nothing, and changes no config.

**Instruments**
- Radar cycle `2026-11-01-e59200` (probe set **1.2.0**, radar 1.0.0, engine perplexity / `sonar`, 72/72 probes, $0.36), compared with cycle `2026-10-01-7442d1`.
- `data/local-seo/rank-history.json` (51 snapshots, latest 2026-10-30).
- `data/local-seo/runs/*/scans/*.json`: competitor rating and review counts come from the map-pack results in these files.
- `data/local-seo/post-outcomes.json` (34 outcomes).
- `data/local-seo/gbp-audit-2026-09-23.md`.
- The standing contract is `plays/2026-10.json` (status applied). November plays are due 2026-11-03.

**Guard.** `localSeo.recovery` in `config.overlay.json` has a block (since 2026-08-28) but **no `paused` key**, so the gate is not raised. Hyperlocal, Spanish, GBP and freshness are off under the October plays. The autorun is disabled (`autorun.state.json`, paused 2026-08-28).

---

## 1. Can October and November be compared?

**Yes, fully.** I was told the October cycle used a different probe set. The files say otherwise:
- Both cycles carry `probeSetVersion: "1.2.0"`.
- Both have the same 12 probe ids across the same 6 markets.
- All 72 prompt strings match exactly (`*.answers.json`).
- Both used the same model string (`sonar`).
- `radar.mjs --diff 2026-10-01-7442d1 2026-11-01-e59200` pairs all 72 probes: 18 changed, 54 unchanged, none new.

The probe set that does not line up is the **2026-09-07 baseline** (probe set 1.0.0, 3 probes). The October plays' Radar target, "0/3 → 1/3 by 2026-12", is written against that 3-probe set. **It cannot be scored on the 1.2.0 set.** The November plays need to restate it, for example as discovery naming out of 30.

**One real confound: the engine's retrieval collapsed between cycles.** The model string and the prompts are unchanged, but the answers changed shape:

| | Oct cycle | Nov cycle |
|---|---|---|
| Sources cited per answer | 23.4 | 7.2 |
| Firms named per answer | 4.36 | 3.40 |

Every directory's citation count fell with it. Read the citation counts below as a share of answers, not as raw totals.

## 2. What moved: AI answers, by band

"Named" means Roden appears in an answer to a prompt that does not name Roden. The 12 reputation checks name Roden in the prompt (12/12 both cycles) and are not counted. That is why the headline "22 named" is really **10 of 60**.

| Band | Oct `7442d1` | Nov `e59200` |
|---|---|---|
| Discovery (30) | 11/30 | **7/30** |
| Selection, excluding self-referential (18) | 4/18 | **1/18** |
| Demand (12) | 2/12 | 2/12 |

Discovery naming by market (5 probes each):

| Market | Oct | Nov | What changed |
|---|---|---|---|
| Savannah | 3/5 | **1/5** | Lost `hire-incident-specific` (was #4) and `spanish-generic` (was #7). `truck-vertical` moved from #2 to **#1**. |
| Darien | 5/5 | 4/5 | Lost `hire-generic-city` (was #1). Still #1 in the other four. |
| Charleston | 1/5 | 1/5 | `truck-vertical` fell from #1 to **#5**. |
| North Charleston | 1/5 | **0/5** | Lost `truck-vertical` (was #1). Now invisible in every discovery probe. |
| Columbia | 1/5 | 1/5 | Lost `truck-vertical` (was #7). Gained `hire-incident-specific` at #4. |
| Myrtle Beach | 0/5 | 0/5 | Invisible in both cycles. |

- **Selection:** `after-hours` was lost in Savannah (was #4), North Charleston (#4) and Columbia (#7). It held in Darien at #1.
- **Demand:** `spanish-fear` was lost in North Charleston (was #1) and gained in Columbia (#4). Darien moved from #2 to #1.

**Why it moved.** Across all 60 non-self answers in both cycles, Roden was **never named unless rodenlaw.com was among the retrieved sources**:

| | Named, rodenlaw.com cited | Named, not cited | Cited, not named |
|---|---|---|---|
| Oct | 17 | 0 | 17 |
| Nov | 10 | 0 | 2 |

The answers that retrieved rodenlaw.com fell from 34 to 12, in step with the drop from 23.4 to 7.2 sources per answer. On this engine, Roden's AI presence rides on its own pages being retrieved. Directories carry the other firms: in the 48 November answers that did not retrieve rodenlaw.com, the firms named are the ones on the directory pages below.

This is the second cycle on probe set 1.2.0. That makes November the first comparison, not a trend. Two points do not make a direction.

**Firms named that are not on the configured competitor lists** (radar render): Hughey Law Firm (6), George Sink (9, under two name forms), Chattahoochee Injury Law (4), Jebaily Law Firm (4), Gunn Law Group (3), Ted Law Firm (3), Howe.Law (3). These are context only, and copy must never name them.

## 3. What moved: the map grid

**Only one office grid has been measured since August**, because the autorun was the scanner. Age of each office's latest valid full-grid scan on 2026-11-01:

| Office | Latest valid scan | Age | Green-pin share | ARP | Zero-SoLV keywords |
|---|---|---|---|---|---|
| Savannah | `scan-2026-08-17-88948a` (LF) | 76 d | 41.06% | 5.63 | 5 |
| Darien | `scan-2026-07-13-2c75d8` (LF) | 111 d | 50.00% | 6.87 | 2 |
| Charleston | `scan-2026-10-30-e33087` (LD) | 2 d | **14.78%** | 8.10 | 1 |
| North Charleston | `scan-2026-08-14-4fc57c` (LF) | 79 d | 0.65% | 16.88 | 18 |
| Columbia | `scan-2026-07-14-e15445` (LF) | 110 d | 0.00% | 21 | 23 |
| Myrtle Beach (office grid) | `scan-2026-08-10-4ef622` (LF) | 83 d | 21.77% | 7.31 | 2 |
| Myrtle Beach (downtown, 11x11) | `scan-2026-10-24-7895af` (LD, 4 kw) | 8 d | 0.62% | 9.17 | 2 |

(LF = Local Falcon, LD = Local Dominator.)

**Charleston, 17.96% → 14.78% green, ARP 8.20 → 8.10** (2026-08-21 LF to 2026-10-30 LD). The provider changed between the two scans. The owner recorded the October scan as the November baseline (`data/local-seo/baselines/charleston-2026-11.json`).
- The losses are spread across verticals:
  - `uber accident lawyer` SoLV 18.37 → 6.12
  - `atv accident lawyer` 26.53 → 16.33
  - `bicycle accident lawyer` 46.94 → 36.73
  - `drunk driver accident lawyer` 12.24 → 6.12
  - `hit and run accident lawyer` 14.29 → 8.16
- ARP is flat, so Roden is still on the pins it held, just lower on some of them.
- The GBP website link was the bare homepage from 2026-09-18 to 2026-10-30 and was retagged on 2026-10-30. The next Charleston scan is the first that can show whether that mattered.

**North Charleston's "0% / 25 of 25 zero-SoLV" is a failed scan.**
- `scan-2026-08-24-abdf97` returned **zero results at every pin** (`count: 0`, `results: []`). It was written to rank history as a real 0%.
- The October plays carried that number as evidence (E12).
- The real level is 0.5–0.65% green. Every Local Falcon scan from May to August shows `car accident lawyer` at SoLV 2.04 and ARP 12–15.7.
- The single-keyword Local Dominator read on 2026-09-29 (`scan-2026-09-29-7c56b5`, not in rank history) agrees: SoLV 2.04, ARP 13.67.
- North Charleston is structurally near-absent, not newly collapsed.

**Columbia is not ranking because the listing is not in the results.**
- Across 1,127 pins and 23 keywords (`scan-2026-07-14-e15445`), and in every earlier Columbia scan, no Roden listing appears in any top 20.
- The 2026-09-23 GBP audit found the Columbia profile `needs_verification: true`. All 24 of its posts have sat in PROCESSING since April.
- No content, review or directory play can move Columbia's grid until the firm verifies that profile.

**Myrtle Beach: the office grid has never measured Myrtle Beach.** It is a 5-mile radius on the Murrells Inlet pin, 12.9 miles from downtown (RECOVERY-LOG 2026-10-24). The downtown scan reads 0.62% green (3 of 484 pins).

**Plays target, Savannah green-pin share held at or above 38% by 2026-12:** unmeasured since 41.06% on 2026-08-17. It cannot be judged without a Savannah rescan before December.

**Keyword that measures nothing:** `wrongful death car accident lawyer` has SoLV 0 and ARP 21 in **35 of 35** scans, at all six offices, since May.
- Google answers it as a name match, not a local search.
- In the Charleston 2026-10-30 scan, every one of 49 pins returns a single result: a Louisiana tourist attraction with "Death" in its name.
- In Savannah (2026-08-17), the top results are Atlanta firms with "Wrongful Death" in the business name.
- The autorun's 2026-08-21 Charleston cycle picked this keyword as its weak target, and the resulting draft (post 5339) never published.

## 4. Directory and aggregator targets (open items for a person)

Share of the 60 non-self answers citing each directory (any subdomain), Oct → Nov:

| Directory | Oct | Nov | Markets cited (Nov) |
|---|---|---|---|
| lawinfo.com | 47% | **27%** | all 6 |
| lawyers.com | 57% | 25% | all 6 |
| justia.com | 72% | 20% | 5 (not Charleston) |
| avvo.com | 77% | 18% | all 6 |
| superlawyers.com | 70% | 17% | 5 (not Darien) |
| martindale.com | 35% | 17% | all 6 |
| findlaw.com | 58% | 15% | 4 |
| bestlawyers.com | 32% | 10% | Charleston, North Charleston, Columbia |
| abogado.com | 20% | 8% | 5 |
| bestinhood.com | 0% | 5% | Charleston, Columbia (new) |
| lawfirmsquare.com | 0% | 2% | Savannah (new) |
| expertise.com | 50% | **0%** | none |
| enjuris.com | 15% | 2% | Darien |

**Radar measurement gap.** Radar's "watched aggregators" match on the exact host (`radar.mjs` line 239). Two things follow:
- `attorneys.superlawyers.com` and `lawyers.findlaw.com` are never counted. Radar's render lists Super Lawyers as never cited and FindLaw as "no longer cited", yet the November answers cite them 10 and 9 times.
- `lawinfo.com`, `martindale.com`, `bestlawyers.com` and `abogado.com` are not on the watch list at all. LawInfo is November's most-cited directory.

The table above uses registrable domains, so it is not affected.

Each item below is a person's task. Check whether Roden (firm and office) is listed on the exact page the AI answers cited. Claim or complete the profile where the directory allows it. Paid placement is the owner's call.

1. **LawInfo** (cited by 12 of 30 discovery answers; no ranking or paid product assumed):
   - https://www.lawinfo.com/car-accident/georgia/darien/
   - https://www.lawinfo.com/car-accident/georgia/savannah/
   - https://www.lawinfo.com/car-accident/south-carolina/charleston/
   - https://www.lawinfo.com/car-accident/south-carolina/north-charleston/
   - https://www.lawinfo.com/car-accident/south-carolina/myrtle-beach/
2. **Lawyers.com, Martindale and abogado.com** (one network; abogado.com is the Spanish surface, and Roden is absent from 5 of 6 `spanish-generic` answers):
   - https://www.lawyers.com/auto-accidents/savannah/georgia/law-firms/
   - https://www.lawyers.com/personal-injury/north-charleston/south-carolina/law-firms/
   - https://www.martindale.com/automobile-accidents-lawyers/savannah/c-georgia/
   - https://www.martindale.com/automobile-accidents-lawyers/north-charleston/south-carolina/
   - https://www.martindale.com/automobile-accidents-lawyers/myrtle-beach/south-carolina/
   - https://www.abogado.com/accidente-de-automovil/south-carolina/charleston/
   - https://www.abogado.com/accidente-de-automovil/georgia/savannah/
3. **Avvo** (attorney-level profiles; claim them for the GA and SC attorneys by bar admission):
   - https://www.avvo.com/car-accidents-lawyer/ga/savannah.html
   - https://www.avvo.com/car-accidents-lawyer/ga/darien.html
   - https://www.avvo.com/car-accidents-lawyer/sc/north_charleston.html
   - https://www.avvo.com/car-accidents-lawyer/sc/myrtle_beach.html
4. **Justia** (free attorney profiles):
   - https://www.justia.com/lawyers/georgia/darien
   - https://www.justia.com/lawyers/personal-injury/georgia/savannah
   - https://www.justia.com/lawyers/personal-injury/south-carolina/north-charleston
5. **Super Lawyers and Best Lawyers** (selection-based, not purchasable; already proposed for Myrtle Beach in the October plays' open item):
   - https://attorneys.superlawyers.com/motor-vehicle-accidents/south-carolina/north-charleston/
   - https://attorneys.superlawyers.com/motor-vehicle-accidents/south-carolina/myrtle-beach/
   - https://attorneys.superlawyers.com/motor-vehicle-accidents/georgia/savannah/
   - https://www.bestlawyers.com/united-states/south-carolina/personal-injury-litigation-plaintiffs
6. **FindLaw directory:**
   - https://lawyers.findlaw.com/motor-vehicle-accidents-plaintiff/south-carolina/north-charleston/
   - https://lawyers.findlaw.com/motor-vehicle-accidents-plaintiff/georgia/savannah/
7. **Listicles** (lower priority; one or two citations each, inclusion is editorial):
   - https://www.bestinhood.com/charleston/lawyers/best-car-accident-lawyers-in-charleston/
   - https://www.bestinhood.com/columbia/lawyers/best-personal-injury-lawyers-in-columbia/
   - https://lawfirmsquare.com/blog/top-10-personal-injury-lawyers-in-savannah/

**Priority by market.** North Charleston (0/5) and Myrtle Beach (0/5) come first: their answers cite LawInfo, Lawyers.com, Martindale, Avvo, Super Lawyers and FindLaw market pages, and Roden appears in none. Darien needs the least: Roden is already #1 in 4 of 5 answers there.

## 5. Review moat by office

How to read this table:
- Roden's counts are from Radar cycle `e59200` (Local Dominator, 2026-11-01).
- The competitor set is the businesses holding the most top-3 map positions on that office's latest grid scan, not the configured lists, which diverge a lot (Charleston's top five holders are all missing from its configured list).
- Velocity is the change in review count for the same Google place between two scans of the same office.
- Floor is 20 reviews (under 20 loses about 47% of consumers). The trust band is 4.75–4.99 with depth.

| Office | Roden | Roden velocity | Competitor set (top-3 map holders: reviews @ rating, velocity) | Set median | Gap |
|---|---|---|---|---|---|
| **Savannah** | 59 @ 4.9 | ~0/mo (60 on 2026-07-13, 59 on 2026-11-01) | Bowen Painter 92 @ 4.9 (0.9/mo); Farah & Farah 240 @ 4.7 (5.1/mo); The Brown Firm 722 @ 5.0 (29/mo); The Mike Hostilo Law Firm 993 @ 4.6 (26/mo); Hasner Law 253 @ 4.9 (2.6/mo); Justin T. Jones 39 @ 4.8. Scan 2026-08-17; velocity over 35 d. | ~250 | In band and over the floor, but flat. The two fastest competitors add 26–29 a month. |
| **Darien** | **0 @ none** | 0 | Joshua W. Branch 2 @ 5.0; Forsyth Law 47 @ 4.9; Farah & Farah Brunswick 86 @ 4.9; Mayfield Law 95 @ 4.9; Boyd Law 464 @ 5.0; Morgan & Morgan Brunswick 1,076 @ 4.8. Scan 2026-07-13; velocity near 0. | ~90 | No moat at all. Yet Roden holds 50% of pins and is #1 in 4 of 5 AI answers. The in-town competitor has 2 reviews, so 20 would set Roden apart in Darien. |
| **Charleston** | 107 @ 4.9 | ~0.9/mo (105 → 107 over 70 d) | Ty Robinson 150 @ 4.9 (0.4/mo); Bringardner 228 @ 5.0 (0.9); The Thumbs Up Guys 99 @ 4.9 (5.1); Riders Law Group 78 @ 5.0 (0.9); Trey Harrell 388 @ 5.0 (0); Joe Cunningham 147 @ 5.0 (7.3); Derrick 468 @ 5.0 (1.3). Scan 2026-10-30; velocity over 70 d. | ~150 | The only office at par. Velocity matches the set median (~1.1/mo); depth trails it by about 40. |
| **North Charleston** | **2 @ 5.0** | 0 (2 since 2026-08-14) | Steinberg 519 @ 4.9 (6.5/mo); The Thumbs Up Guys 475 @ 4.9; Ted Law 383 @ 5.0 (4.6/mo); Gus Anastopoulo 277 @ 5.0; Derrick 464 @ 5.0; Morgan & Morgan 1,140 @ 4.8. Scan 2026-09-29 (one keyword, 49 pins); velocity over 46 d. | ~470 | 18 short of the floor. A thin 5.0 reads as less trustworthy than 4.75–4.99 with depth. Structurally the thinnest moat. |
| **Columbia** | **2 @ 5.0** | 0 | Jeffcoat 2,541 @ 5.0 (10/mo); Goings 813 @ 5.0 (5/mo); The Stanley Law Group 786 @ 4.9 (10/mo); Burriss Ridgeway 530 @ 4.9; Cavanaugh & Thickens 380 @ 4.9; The Louthian Law Firm 216 @ 4.9. Scan 2026-07-14; velocity over 18 d. | ~650 | 18 short of the floor, against the deepest set. **Profile unverified, so reviews are not the binding constraint yet.** |
| **Myrtle Beach** | **3 @ 4.7** | +1 since 2026-09-07 | Downtown: Derrick 1,537 @ 5.0 (5.2/mo); The Lovely Law Firm 1,429 @ 4.9 (21/mo); Sansbury 260 @ 5.0; Morris Law 178 @ 5.0; Morgan & Morgan 700 @ 4.7 (11/mo). Office grid: Morgan & Morgan 672 @ 4.8 (18/mo); David L. Hood 108 @ 4.9; Morris Law 175 @ 4.8. Scans 2026-10-24 and 2026-08-10. | ~700 downtown, ~110 office grid | 17 short of the floor, and **4.7 is below the trust band**. Every new 5-star review moves the average a lot at n=3. |

**Which moats are structurally thin:**
- North Charleston, Columbia and Myrtle Beach face competitor sets in the hundreds to thousands. Getting to 20 earns credibility, not parity.
- Darien is the cheapest win: a thin local field, Roden already ranked, and AI answers already naming Roden.
- Savannah is not thin but has stalled. A 59-review profile adding nothing for four months is losing ground to competitors adding 26–29 a month.

## 6. Keyword universe: proposed, not written

`data/local-seo/keyword-input.json` was **not written**:
- That path holds the keyword-agent's research bundle (generated 2026-05-15, 85 KB, **gitignored and untracked**). Overwriting it is unrecoverable.
- `finalize-keyword-universe.mjs` does not read it. It takes a full proposal via `--proposal <path>`.
- The universe is not consumed while hyperlocal is off.

These are the changes the evidence supports, for whoever next composes the proposal:

| Change | Keyword | Reason |
|---|---|---|
| Remove from tracking_set | `wrongful death car accident lawyer` | SoLV 0 and ARP 21 in 35 of 35 scans at 6 offices. Google returns name matches, not local results, so the grid measures nothing. Keep it as a theme core term for content. |
| Add to tracking_set (replacement) | `auto accident attorney` | Already a core term of `passenger-vehicle-collisions` and in scope. It keeps the set at 25 with a keyword that returns a real local pack. |
| Remove from long_tail | `charleston harbor boating accident lawyer` | Landmark plus city, below the granularity floor. |
| Remove from long_tail | `intracoastal waterway boating accident lawyer` | Landmark keyword, below the granularity floor. |
| Remove from long_tail | `i 95 truck accident lawyer`, `i 26 truck accident lawyer` | Route keywords become route-plus-city slugs in the pipeline (`darien-i-95-truck-accident-lawyer` in the outcomes ledger). |

**No theme is doubled down on or dropped on outcomes.** In `post-outcomes.json`, **27 of 34 verdicts were scored against checkpoint scans from a different office than the post's baseline**. For example, the Columbia `edmund-highway` post's 2-week checkpoint is a Savannah scan, and its 4-week checkpoint is a Myrtle Beach scan. Those verdicts carry no information. The 7 clean ones:

| Keyword (office) | Verdict |
|---|---|
| `underinsured motorist lawyer` (Myrtle Beach) | lift, +8.16 adjusted SoLV, medium |
| `car accident lawyer` (Myrtle Beach) | flat |
| `truck accident lawyer` (Myrtle Beach) | flat |
| `uninsured motorist lawyer` (Myrtle Beach) | decline |
| `bus accident lawyer` (North Charleston) | flat |
| two posts | inconclusive, no checkpoints |

One clean lift is not a theme verdict.

## 7. GBP posts I would propose (not a plan, not scheduled)

The November plays decide whether the GBP lane is on. Three facts limit any GBP work:
- Google has **rejected every post since 2026-07-07** on Charleston, Darien, Myrtle Beach and North Charleston (33 posts, `gbp-audit-2026-09-23.md`). The cause is not exposed.
- **Columbia is unverified**, and nothing posted there has ever gone live.
- The caption template in `config.overlay.json` (`autorun.gbpCaptionTemplates`) still carries a phone number, which Google's post policy discourages. The pipeline also put the raw slug on line 1 of every caption.

So the only profile worth regular posts is Savannah. The other four verified profiles each get one diagnostic post to learn whether rejection persists. Rules for every post:
- Plain caption, no phone, no UTM, with an image.
- The link is a live page with no open legal-accuracy items.
- Calendar rules apply: 14:00 UTC, one post per office per slot, at least 2 days apart, no more than 3 a week, within `maxQueueDepthDays` (21).
- Dates are placeholders after the 2026-11-03 plays. The scheduler re-slots them against the live PostPlanify calendar.

| Office | Date (placeholder) | Topic | URL | Reason |
|---|---|---|---|---|
| Savannah | 2026-11-05 | How fault splits a claim when a Georgia crash crosses into South Carolina | https://rodenlaw.com/resources/georgia-vs-south-carolina-comparative-negligence/ | Attorney-reviewed 2026-09-19; every legal statement traced to verified sources; live (200). Savannah is the only profile still accepting posts. |
| Savannah | 2026-11-10 | Filing deadlines after a crash: Georgia vs South Carolina | https://rodenlaw.com/resources/georgia-vs-south-carolina-filing-deadlines/ | Same provenance as above; live (200). |
| Charleston | 2026-11-06 | Charleston office: car accident help | https://rodenlaw.com/car-accident-lawyers/charleston-sc/ | Diagnostic post. Does the July-onward rejection persist with a clean caption? |
| North Charleston | 2026-11-06 | North Charleston office: car accident help | https://rodenlaw.com/car-accident-lawyers/north-charleston-sc/ | Diagnostic post, same test. |
| Myrtle Beach | 2026-11-07 | Myrtle Beach office (Murrells Inlet) | https://rodenlaw.com/locations/south-carolina/myrtle-beach/ | Diagnostic post. The office's car-accident city URL 301s to the generic pillar, so the post links the location page. |
| Darien | 2026-11-07 | Darien office | https://rodenlaw.com/locations/georgia/darien/ | Diagnostic post. The office's car-accident city URL 301s to the generic pillar. |
| Columbia | none | none | none | Nothing until the profile is verified. |

The I-26 / I-95 corridor report is **left out**: its Georgia half still lacks Joshua Dorminy's read. The truck study is unpublished.

## 8. Scans I would propose (not scheduled)

Run these one at a time, by a person, between 10:00 and 12:00 CT on a Tuesday or Thursday. That window keeps clear of:
- another client's daily 08:47 CT autorun;
- Roden's own Mon/Wed/Fri 12:47 CT slot (idle while paused, but reserved);
- the Radar slots on the 1st (07:10 / 07:40 CT).

The scans, in order:
1. **Savannah full grid**, before the December judgment on the 38% hold target.
2. **Darien full grid** (111 days stale).
3. **North Charleston full grid**, to replace the failed 2026-08-24 snapshot as the latest reading.
4. **Myrtle Beach downtown re-run** (same series, `--centre 33.689,-78.887 --grid 11 --radius 10`), per the October open item.

Columbia waits for verification: a scan of an unverified listing will read 0 again.

Note on today's Radar cycle: it started at 15:41 UTC (09:41 CT), not in its 07:40 CT slot, because the earlier run was stopped. Its review moat ran Local Dominator scans. The 07:10 / 07:40 slots on the 1st exist to keep scan processes apart, so an off-slot re-run should be checked against the other client's 08:47 CT run.

## 9. Items for the owner

1. **Verify the Columbia GBP** (firm-side). Nothing else moves Columbia.
2. **Decide on the rejected posts.** 33 posts have been rejected on four profiles since 2026-07-07. Approve or decline the diagnostic posts above, and decide whether to drop the phone number from `gbpCaptionTemplates`.
3. **Review asks**, in this order:
   - Darien: 0 → 20. The cheapest differentiation.
   - Myrtle Beach: 3 @ 4.7, below the trust band.
   - North Charleston: 2.
   - Savannah: restart velocity.
   - Columbia: after verification.
4. **Directory inclusion** (section 4). This is a person's work. Paid placements are the owner's call.
5. **`recovery.paused`** is still absent, as the October plays noted. The only hold is the autorun pause note plus the $0 spend cap.
6. **Measurement fixes** for the toolkit owner. I did not make them:
   - `post-outcomes.json` checkpoints are pulled from other offices' scans (27 of 34).
   - `rank-history.json` records the empty North Charleston scan of 2026-08-24 as a real 0%.
   - Radar's exact-host aggregator match misses `attorneys.superlawyers.com` and `lawyers.findlaw.com`, and the watch list lacks LawInfo, Martindale, Best Lawyers and abogado.com.
7. **Restate the Radar target** in the November plays on probe set 1.2.0. The 0/3 baseline is a different instrument.
