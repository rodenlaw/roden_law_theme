# Statistics audit, round 2 — sitewide assessment

Round 1 fixed five claims found by accident and recorded that the audit had been
scoped too narrowly. This is the systematic pass.

**Result: 14 further edits across 11 pages.** One claim was *proven* false against
FARS, one was upgraded from an unsourced superlative to a sourced fact, and two
were checked and kept.

## Method

A sweep of every published, non-revision post pulled **1,004 candidate sentences**
carrying a number or a superlative near crash vocabulary. Most were noise — legal
thresholds (the 50%/51% comparative-negligence bars), dollar figures, statute
citations. Filtering to genuine crash statistics left **254 sentences across 163
pages**, then splitting by falsifiability:

| Class | Sentences | Disposition |
|---|---:|---|
| Road-specific superlatives | 62 | assessed individually |
| Generic superlatives ("left-turn crashes are among the most dangerous") | 63 | **left alone** — descriptive, not falsifiable |
| Road-specific quantities | 17 | assessed individually |
| Other quantities | 112 | mostly national-agency figures |

## The pattern that decided most of it

**Claims sourced to national agencies held up. Claims about specific local roads
did not.**

Verified and kept:

- *"563 of South Carolina's 1,038 traffic deaths in 2024"* — FARS 2024 gives SC
  exactly **1,038**. Correct.
- *"7,522 pedestrians were killed"* — matches NHTSA's published 2022 figure. The
  final FARS file shows 7,593 after revision; that is a revision, not an error,
  and the same lesson as the FMCSA snapshot problem in round 1: **cite the source
  and the vintage.**

Removed or corrected: every local ranking. None named a retrievable publication,
and the one that could be checked was wrong.

## Proven false

**"Chatham County reported 59 traffic deaths in 2022 — a top-5 county statewide"**
(`/resources/port-of-savannah-truck-routes/`).

FARS 2022 gives Chatham County **40** traffic deaths, ranked **#8** among Georgia's
152 counties. The figure 59 belongs to **Clayton County**, which is the actual #5.
Both halves of the claim are wrong.

## Upgraded rather than deleted

**"US-17 is the most dangerous road in Horry County"** turned out to be
*directionally supportable*. FARS 2024 shows US-17 carrying more fatal crashes
than any other Horry County roadway — 6 of the county's 57. The claim was replaced
with that sourced statement, citing the exact annual file and access date. The
accompanying *"2,181 motor vehicle accidents in a single year"* is all-severity,
is not in FARS, and was removed.

This is the outcome to aim for where the evidence allows it: an unsourced
superlative becomes a smaller, checkable, cited fact.

## Removed

| Page | Claim |
|---|---|
| `ashley-phosphate-i-26-truck-accidents` | "most dangerous intersection in all of South Carolina" + "a crash every 3 days" |
| `dangerous-roads-north-charleston` | same ranking, attributed to "SCDPS collision reports" with no publication named |
| `north-rhett-avenue-truck-accident-hanahan…` | the same ranking reused as link anchor text |
| `ladson` *(location page)* | "second most dangerous intersection in the tri-county Charleston area, with over 380 recorded accidents" |
| `surfside-beach` *(location page)* | "single most dangerous intersection in Horry County, with 240 crashes and 73 injuries or fatalities" |
| `us-17-sc-544-truck-accidents-surfside-beach` | county ranking ×2 + "2,181 accidents" ×2 + "over 11,000 crashes per year" |
| `columbia-dangerous-intersections-roads` | "229 collisions in a single recent year, injuring 56 people and killing one" |
| `i-16-i-95-construction-zone-truck-accidents` | "one of the most dangerous construction zones in the Southeast" |
| `abercorn-street-truck-accidents-savannah` | "#1 most dangerous intersection in the City of Savannah" + "1 in 4 crashes results in serious injury or fatality" |
| `port-of-savannah-truck-routes` | "10,000 intersection accidents in 2018" + the false Chatham County figure |

Two are **location pages** — guardrail-protected content asserting a ranking
nobody can source.

## Left alone, deliberately

**Generic superlatives.** "Left-turn crashes are among the most dangerous on this
road", "construction zones are among the most dangerous work environments" — these
describe a hazard rather than rank a named place. Not falsifiable, not a
liability.

**`/blog/myrtle-beach-dangerous-roads-intersections/`.** Its claims are attributed
to the South Carolina Highway Patrol and City of Myrtle Beach police records —
named institutional sources rather than a bare assertion. Weaker than a citation
with a publication and date, but a different class from the removals above. Worth
strengthening; not worth deleting.

**National-agency figures** (NHTSA, FHWA, IIHS, GOHS). Spot-checked and sound.

## Round 3 — the Ashley Phosphate headline, and three removals that were wrong

Reviewing the headline turned up a source neither earlier round found, and it
cuts both ways.

**The claim is false, and worse than "unsourced".** A *Post and Courier* analysis
of preliminary SCDPS data, 2011–2015, found **629 crashes** at Ashley Phosphate
and I-26 — the most of any intersection in Berkeley, Charleston or Dorchester
counties, but **second statewide** behind I-20 at US-176 in Columbia. And
decisively for a page calling it the *deadliest*: **none of the 629 crashes was
fatal.** 181 people were injured.

So the headline was wrong on both halves. It is not first in the state, and by
the only figures anyone has published it is not deadly at all — it is
high-frequency and low-severity, which is a more interesting fact than the one
the page was asserting.

Corrected rather than deleted: the post now reports the 629 crashes, the
tri-county ranking, the statewide second place and the zero-fatality finding, all
cited. Title changed from *"Why Ashley Phosphate & I-26 Is South Carolina's
Deadliest Intersection"* to *"…Is the Tri-County's Highest-Crash Intersection"* —
a superlative that is actually true. Anchor text on two posts, one English and one
Spanish, repeated the false ranking and was reworded.

### Three claims removed earlier today were accurate

The same article sources three of the figures rounds 1 and 2 took out as
unverifiable:

| Claim | Removed as | Actually |
|---|---|---|
| "one collision every 3 days" at Ashley Phosphate | unverifiable | **Accurate** — "one every three days on average" |
| I-26 Exit 203 / College Park Road, "over 380 accidents", 2nd in tri-county | unverifiable | **Accurate** — 381 collisions, 2nd tri-county, 9th statewide |
| "62 injuries" at Rivers Avenue / I-526 | unverifiable | **Accurate** — highest injury total in the top ten |

All three are **restored with the citation**. Removing them was defensible on the
evidence available at the time — they were uncited and nothing I could reach
confirmed them — but "I could not verify this" is not the same finding as "this is
false", and the remedy for the first is a source, not a deletion.

The lesson for the rest of the backlog: **search for the source before removing a
claim, not only for a contradiction.** A local newspaper analysing state data is
exactly the kind of source that does not surface from an agency portal query.

### Still open

The **slug** still reads `…south-carolinas-deadliest-intersection`. Changing it
means a 301 and the loss of an exact-match URL during an active recovery, so it is
recorded as a separate decision rather than taken alongside the title. The title
and body are what a reader sees; the slug is the weaker signal and can move in a
later URL-hygiene pass.

`/resources/rivers-avenue-truck-accidents-north-charleston/` still calls Rivers
Avenue "one of the four deadliest roads in Charleston County" — a falsifiable
ranking that neither round assessed. It belongs in the next pass.
