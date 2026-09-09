# Internal link audit — anchor text and redirect hops, 2026-09-08

Follow-up to the dead-link pass (#111), which fixed 23 targets returning 404.
This one asks two narrower questions: **does the anchor text describe where the
link actually goes**, and **do links reach their destination in one hop**.

## What was fixed in code

Two guards, both tested against production before shipping:

| Guard | Closes |
|---|---|
| `inc/link-guardrails.php` | pillar links written without the `/practice-areas/` prefix — the habit behind 82 of the 156 rewrites in #111 |
| `roden_redirect_dest_or_fallback()` in `inc/legacy-redirects.php` | redirects that compose a destination and never check it exists |

## Finding 1 — three redirects landed on a 404

56 internal links reached a dead end **through a redirect**, which #111 missed
because it checked one hop and stopped:

| Links | From | To |
|---:|---|---|
| 51 | `/savannah/personal-injury-lawyers/` | `/personal-injury-lawyers/savannah-ga/` (404) |
| 3 | `/brunswick/personal-injury-lawyer/` | `/personal-injury-lawyers/darien-ga/` (404) |
| 2 | `/practice-areas/savannah/personal-injury-lawyers/` | same 404 |

None was a typo. The city-and-practice pattern rules **compose** a destination
(`/{practice}/{city-state}/`) and never verify it. That composition is correct for
most pairs — `/car-accident-lawyers/savannah-ga/` is a real page — but the
permutations were only ever built for the four South Carolina cities, so personal
injury in the two Georgia markets composes a URL that does not exist.

Patching the four map entries would have left the generator that produces the
fifth. The guard now degrades an unresolvable destination to the practice-area
pillar. **A redirect to a 404 is worse than no redirect** — the visitor follows it
and ends up one hop further from anything that would have told them so.

## Finding 2 — 858 internal links take a redirect hop

858 of 4833 internal link instances (18%) point at a URL that 301s.
Not broken, but every one dilutes and slows. The largest:

| Links | From | To |
|---:|---|---|
| 65 | `/contact-us/` | `/contact/` |
| 64 | `/` | `/` |
| 55 | `/charleston/car-accident-lawyers/` | `/car-accident-lawyers/charleston-sc/` |
| 52 | `/savannah/car-accident-lawyers/` | `/car-accident-lawyers/savannah-ga/` |
| 51 | `/savannah/personal-injury-lawyers/` | `/personal-injury-lawyers/savannah-ga/` |
| 37 | `/charleston/personal-injury-lawyer/` | `/personal-injury-lawyers/charleston-sc/` |
| 26 | `/wrongful-death-lawyers/` | `/practice-areas/wrongful-death-lawyers/` |
| 20 | `/product-liability-lawyers/` | `/practice-areas/product-liability-lawyers/` |
| 19 | `/charleston/truck-accident-lawyers/` | `/truck-accident-lawyers/charleston-sc/` |
| 18 | `/savannah/workers-compensation-lawyers/` | `/workers-compensation-lawyers/savannah-ga/` |

**FIXED 2026-09-08**, after the guards shipped in #112 so the map could be built
against corrected destinations.

| | Targets | Links | → 200 | → 301 |
|---|---:|---:|---:|---:|
| Before | 805 | 4,836 | 3,978 | **858** |
| After | 662 | 4,823 | 4,759 | **64** |

**858 → 64, and the 64 are not real.** They are links to `/`, which the WP Engine
origin hostname 301s to the canonical domain; a visitor already on `rodenlaw.com`
gets the homepage directly. Measured from the origin it looks like a hop. It is
not one, and it was deliberately excluded from the rewrite.

Distinct targets fell from 805 to 662 because 143 superseded URL shapes collapsed
onto the canonical ones they had been redirecting to.

The map was **generated, not hand-written**: every target resolved, every 301's
`Location` read, and every destination re-tested for 200. A preflight refuses if
any destination is itself a redirect source — none was, which is why this pass
could not introduce a new hop. Shapes collapsed:

| Targets | Shape |
|---:|---|
| 98 | `/practice-areas/{city}/{practice}/` → `/{practice}/{city-state}/` |
| 40 | `/{city}/{practice}/` → `/{practice}/{city-state}/` |
| 11 | `/blog-{slug}/` → `/blog/{slug}/` |
| 6 | bare pillar roots → `/practice-areas/{slug}/` |
| 27 | `/contact-us/`, `/who-we-are/*`, `/es/` city pages, slug renames |

Script: `bin/fix-redirect-hops.php`.

## Finding 3 — anchor text pointing at pillars

1,798 internal links point at one of the 24 practice-area pillars. An automated
matcher flagged 68; **most were false positives** — "slip and fall injuries" pointing
at the slip-and-fall pillar is correct, and generic descriptive anchor text on a
pillar is exactly right. Reading them by hand leaves two real groups.

### 3a. Anchor names a specific page that exists — repoint

| Anchor | Points at | Should be |
|---|---|---|
| "Savannah port worker injury lawyers" | workers-comp pillar | `/workers-compensation-lawyers/port-worker-injury/` |
| "Ashley Phosphate Road" | car-accident pillar | `/resources/ashley-phosphate-i-26-truck-accidents/` |
| "Rivers Avenue pedestrian accidents" | pedestrian pillar | `/blog/rivers-avenue-pedestrian-deaths-north-charleston/` |
| "Road hazard accidents" | premises pillar | `/blog/road-hazard-car-accident-liability/` |
| "Charleston car accident attorneys" ×2 | car-accident pillar | `/car-accident-lawyers/charleston-sc/` |
| "Charleston personal injury attorneys" | PI pillar | `/personal-injury-lawyers/charleston-sc/` |
| "statute of limitations for personal injury claims" | **car-accident pillar** | `/resources/south-carolina-statute-of-limitations/` |
| "spinal cord injury" | **brain-injury pillar** | `/practice-areas/spinal-cord-injury-lawyers/` |

The last two are the worst: the anchor promises one subject and the link delivers
an unrelated one. Spinal cord and brain injury are different pillars.

### 3b. Anchor names a page that does not exist — a content gap, not a link bug

These anchors promise a page the site has never had. Repointing them at a pillar
would keep the promise broken; the honest options are to rewrite the anchor or to
write the page.

| Anchor | On | Note |
|---|---:|---|
| "Port of Charleston Truck Routes" | 5 pages | `/resources/port-of-savannah-truck-routes/` exists; **the Charleston equivalent does not.** Almost certainly copied from the Savannah template |
| "US-17 Truck Accidents on the Grand Strand" | 3 pages | |
| "Savannah personal injury attorneys" | 1 page | `/personal-injury-lawyers/` city pages exist only for the four SC cities |
| "Highway 501 Truck Accidents" | 1 page | |
| "Lexington County Truck Accidents" | 2 pages | |
| "I-26 car accident attorneys" | 1 page | |
| "Road rash and abrasion injuries" | 1 page | |

The Port of Charleston one is the most interesting: the site has a Savannah port
truck-routes resource and five pages linking to a Charleston twin that was never
written. That is a content opening the link graph found by itself.

**RESOLVED 2026-09-09.** 19 anchors across 14 pages, in two different ways:

- **"Savannah personal injury attorneys"** had **6,110 impressions of query demand**
  and a culled URL still earning **50,500**. That one got its page —
  `/personal-injury-lawyers/savannah-ga/`.
- **The rest have zero search demand.** No impression anywhere in the 13-month
  export for Port of Charleston truck routes, US-17 Grand Strand, Highway 501,
  Lexington County truck accidents, or road rash. Writing six pages to satisfy six
  links is backwards, so each anchor was rewritten to name the page it actually
  reaches.

**Both the href and the anchor text changed.** Repointing alone would only relocate
the mismatch — the reader would still be promised "Port of Charleston Truck Routes"
and still not get it.

One was unlinked rather than repointed: "Road rash and abrasion injuries" pointed at
the burn-injury pillar. Road rash is not a burn, its list siblings are unlinked bold
text, and no page covers it — so the link came out and the words stayed.

Deliberately out of scope: roughly eighteen anchors of the form "I-26 car accident
lawyers" that the local-SEO pipeline emits, pointing at the car or truck pillar.
Those are descriptive rather than title-shaped, and rewriting a pipeline's standard
cross-link pattern is a decision about the pipeline.

Script: `bin/fix-phantom-page-anchors.php`.

## Method notes

**Following a redirect from the WP Engine host is unreliable.** Redirect targets use
the canonical `rodenlaw.com`, which Cloudflare 403s from the origin. A first attempt
to follow all 183 chains reported *every one* landing on 200 — an artifact. Strip the
host and re-test the **path** on the origin instead; that is what surfaced the three
404s.

**A token-similarity matcher is not good enough for this.** It routed Conway to North
Charleston, Columbia pages to Charleston, and rated correct pillar links as errors.
The 68 hits needed reading; 8 survived.
