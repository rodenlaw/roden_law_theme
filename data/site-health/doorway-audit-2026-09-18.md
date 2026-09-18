# Doorway-ratio audit — 2026-09-18

**Verdict: not compliant.** 499 of 1230 indexable URLs (40.6%) are location-targeted
against the 25% ceiling. Compliance needs either 256 location-targeted URLs
retired, 766 substantive non-location URLs added, or a mix (table below).

Source: production sitemap (`https://rodenlaw.com/wp-sitemap.xml`, 8 children) classified with the
vendored `vendor/site-health` doorway check, the same classifier the post-deploy site-health job
runs. Computed directly from the sitemap on 2026-09-18 without the page crawl. Spot-checked six
pages across the buckets for a robots `noindex` tag: none carry one, so the sitemap is the
indexable set.

## Change since the 2026-09-10 report

| | 2026-09-10 | 2026-09-18 |
|---|---|---|
| Indexable URLs | 1,230 | 1,230 |
| Location-targeted | 503 | 499 |
| Ratio | 40.9% | 40.6% |

No URL entered or left the sitemap. The four URLs that dropped out of the location-targeted set
did so because the classifier's generic-word lists were extended in the toolkit (`can-you-sue-
hospital-negligence` EN and ES, `summer-road-trip-safety`, `highway-road-construction-accident`).
The content has not moved.

## What makes up the 499

| Bucket | URLs | Below the municipality floor |
|---|---|---|
| Blog posts | 193 | 92 |
| City x practice intersections | 138 | 1 |
| Location pages | 51 | 13 |
| ES city x practice intersections | 39 | 0 |
| Resources (truck-corridor series) | 38 | 26 |
| ES blog posts | 28 | 24 |
| Legacy root city pages | 6 | 0 |
| ES location pages | 6 | 0 |
| **Total** | **499** | **156** |

Charleston carries the weight: 87 of the 193 location-targeted blog posts
and 46 of the 138 English intersections (the six office cities:
charleston 46, savannah 23, columbia 23, myrtle-beach 23, darien 22).

## Paths to 25%

| Scenario | Location-targeted | Indexable | Ratio |
|---|---|---|---|
| Today | 499 | 1230 | 40.6% |
| A. Retire the 156 sub-municipal URLs (the granularity-floor failures) | 343 | 1074 | 31.9% |
| B. Retire the 177 city x practice intersections (EN + ES) | 322 | 1053 | 30.6% |
| C. A + B | 166 | 897 | 18.5% |
| A + add non-location pages | 343 | 1074+298 | 25.0% |
| B + add non-location pages | 322 | 1053+235 | 25.0% |
| Add non-location pages only | 499 | 1230+766 | 25.0% |

Scenario A alone is the one already on the table (the 156 granularity-floor errors deferred in
`remediation-2026-09-11.md`) and it does **not** reach the ceiling on its own. Only C clears it
without new content. Note that excluding the 156 case-result pages from the sitemap, floated in
the 09-11 remediation as an alternative to linking them, would push the ratio **up** to
46.5% — they are a third of the non-location denominator.

## Classifier notes

- `/boating-accident-lawyers/dock-marina-injury/` is a practice sub-type page counted as a
  landmark doorway on the token `dock-marina`. False positive, one URL; fix belongs in the
  toolkit's generic-preceder list, not here.
- The `/resources/` truck-corridor series is 38 of the 62 resources and 26 of those
  are route-plus-city or street slugs below the floor. The Q4 strategy's assumption that
  `/resources/` pages "add no location-targeted URLs" holds for statewide guides and the
  corridor report, not for this series.
- Six legacy root pages (`/greenville-sc-…`, `/spartanburg-sc-…`, `/florence-sc-…`) target
  cities with no office and sit outside `/locations/`.

## Appendix — every location-targeted URL


### Blog posts (193)

- `/blog/18-wheeler-wrecks-on-the-arthur-ravenel-jr-bridge-us-17/` — below floor
- `/blog/a-cyclists-guide-after-a-ravenel-bridge-accident/` — below floor
- `/blog/a-drivers-guide-to-wildlife-accidents-near-charleston/`
- `/blog/a-guide-to-car-wrecks-on-aviation-avenue-near-charleston-airport/` — below floor
- `/blog/a-pedestrians-guide-to-claiming-lost-wages-in-charleston/`
- `/blog/a-pedestrians-guide-to-proving-negligence-in-charleston-parking-lots/`
- `/blog/a-step-by-step-guide-for-folly-road-car-accidents/` — below floor
- `/blog/accepting-a-cash-offer-after-savannah-car-crash/`
- `/blog/ashley-phosphate-i-26-south-carolinas-deadliest-intersection/` — below floor
- `/blog/ashley-phosphate-road-i-26-dangerous-intersection-charleston/` — below floor
- `/blog/atlantic-coastal-highway-us-17-rideshare-uber-lyft-crash-savannah-intermodal-transit-center/` — below floor
- `/blog/ben-sawyer-boulevard-bridge-accidents-sullivans-island/` — below floor
- `/blog/best-car-accident-lawyer-ashley-river-road-greenwood-park-west-ashley/` — below floor
- `/blog/boating-accidents-charleston-harbor-legal-rights/`
- `/blog/boeing-north-charleston-workplace-injuries-workers-comp/`
- `/blog/boys-estate-glynn-county-best-car-accident-lawyer/`
- `/blog/broad-river-road-pedestrian-accident-lawyer-harbison-columbia/` — below floor
- `/blog/brunswick-i-95-truck-accident-lawyer/` — below floor
- `/blog/brunswick-ocean-highway-us-17-underinsured-motorist-lawyer-glynn-county/` — below floor
- `/blog/bucksport-marina-waccamaw-intracoastal-boating-accident-lawyer/` — below floor
- `/blog/calculating-pain-and-suffering-after-a-charleston-pedestrian-accident/`
- `/blog/can-a-witness-be-forced-to-testify-for-a-savannah-car-crash-case/`
- `/blog/car-accident-attorney-near-me-west-ashley-citadel-mall/` — below floor
- `/blog/car-accidents-ladson-i-26-exit-203-danger-zone/` — below floor
- `/blog/car-accidents-on-coleman-boulevard-in-mount-pleasant/` — below floor
- `/blog/car-accidents-on-i-26-in-north-charleston/` — below floor
- `/blog/carriage-tour-accidents-downtown-charleston-liability/` — below floor
- `/blog/cayce-12th-street-uninsured-motorist-lawyer/` — below floor
- `/blog/charleston-car-crash-brain-injuries/`
- `/blog/charleston-delivery-truck-pedestrian-cyclist-accidents/`
- `/blog/charleston-historic-sidewalk-slip-fall-city-liable/`
- `/blog/charleston-lyft-driver-ran-red-light-and-hit-my-car/`
- `/blog/charleston-medical-malpractice-hospital-claim-south-carolina/`
- `/blog/charleston-parking-lot-car-accident-liability/`
- `/blog/charleston-parking-lot-parking-garage-accident/`
- `/blog/charleston-reckless-driving-crash/`
- `/blog/charleston-rideshare-brake-failure-accident/`
- `/blog/charleston-tourist-injuries-premises-liability-hotels-restaurants/`
- `/blog/chicora-cherokee-carner-avenue-us-52-car-accident-attorney-north-charleston/` — below floor
- `/blog/columbia-airport-expressway-us-378-truck-accident-springdale-lexington-county/` — below floor
- `/blog/columbia-dangerous-intersections-roads/`
- `/blog/compensation-for-car-crash-facial-injuries-charleston/`
- `/blog/compensation-for-chronic-pain-after-a-car-crash-in-charleston/`
- `/blog/construction-worker-injuries-charleston-sc-rights/`
- `/blog/credit-one-stadium-event-day-crashes-daniel-island-beekman-street/` — below floor
- `/blog/dangerous-rural-crashes-in-charleston/`
- `/blog/dangerous-savannah-intersections/`
- `/blog/dangers-of-emotional-driving-in-savannah-ga/`
- `/blog/daniel-island-accidents-event-traffic-golf-carts/` — below floor
- `/blog/daniel-island-i-526-wando-bridge-truck-accident-berkeley-county/` — below floor
- `/blog/darien-brunswick-dangerous-roads-i95-us17/` — below floor
- `/blog/darien-i-95-truck-accident-lawyer/` — below floor
- `/blog/darien-river-boating-accident-lawyer/`
- `/blog/determining-fault-in-a-charleston-golf-cart-accident/`
- `/blog/dick-pond-road-sc-544-truck-accident-lawyer-surfside-beach/` — below floor
- `/blog/dog-bite-laws-south-carolina-charleston/`
- `/blog/dog-bite-surfside-beach-29575/`
- `/blog/drunk-driver-crash-south-kings-highway-us-17-business-surfside-beach-29575/` — below floor
- `/blog/east-bay-street-savannah-pedestrian-accident-lawyer/` — below floor
- `/blog/eastern-wharf-savannah-pedestrian-bike-accidents/`
- `/blog/edmund-highway-lexington-county-car-accident-lawyer/` — below floor
- `/blog/emergency-room-errors-charleston-misdiagnosis-malpractice/`
- `/blog/eulonia-us-17-ocean-highway-rideshare-uber-accident-lawyer-mcintosh-county/`
- `/blog/feeling-fatigued-after-charleston-car-accident/`
- `/blog/filing-a-claim-after-a-hazmat-truck-crash-in-charleston/`
- `/blog/filing-an-emotional-distress-claim-after-a-ravenel-bridge-accident/` — below floor
- `/blog/filing-soft-tissue-injury-claims-in-charleston/`
- `/blog/five-points-columbia-uber-accident-lawyer/` — below floor
- `/blog/folly-road-car-accidents-james-island-charleston/` — below floor
- `/blog/garden-city-dean-forest-road-truck-accident-lawyer/` — below floor
- `/blog/garden-city-eden-loop-truck-accident-lawyer/`
- `/blog/garden-city-ga-21-augusta-road-car-accident-lawyer/` — below floor
- `/blog/golf-cart-accidents-charleston-island-resort-communities/`
- `/blog/golf-colony-south-reindeer-road-underinsured-motorist-lawyer/` — below floor
- `/blog/goose-creek-car-accidents-military-traffic-us-52/` — below floor
- `/blog/green-grove-dorchester-road-atv-accident-lawyer-north-charleston/` — below floor
- `/blog/green-grove-mark-clark-expressway-uninsured-motorist-lawyer-north-charleston/` — below floor
- `/blog/guide-after-a-car-accident-in-columbia-sc/`
- `/blog/hanahan-murray-avenue-highland-park-bicycle-accident-lawyer/` — below floor
- `/blog/hearing-loss-after-charleston-car-accident/`
- `/blog/highway-41-accidents-mount-pleasant-development/`
- `/blog/hip-pain-after-car-accident-in-savannah/`
- `/blog/hit-and-run-drunk-driver-crashes-ashley-river-road-sc-61-west-ashley-greenwood-park/` — below floor
- `/blog/how-delayed-injuries-could-impact-your-charleston-car-crash-claim/`
- `/blog/how-long-personal-injury-case-charleston-sc/`
- `/blog/how-loud-music-increases-crash-risk-charleston/`
- `/blog/how-poor-truck-maintenance-causes-charleston-accidents/`
- `/blog/how-to-spot-distracted-drivers-ten-signs-savannah-ga/`
- `/blog/how-to-talk-to-your-doctor-about-your-charleston-car-accident-injuries/`
- `/blog/i-16-port-freight-truck-accident-garden-city-savannah/` — below floor
- `/blog/i-20-bush-river-road-motorcycle-accident-lawyer-columbia/` — below floor
- `/blog/i-26-i-526-truck-accidents-what-to-do-whos-liable/`
- `/blog/i-526-expansion-construction-zone-accidents-charleston/` — below floor
- `/blog/i-526-mount-pleasant-wando-bridge-accident/` — below floor
- `/blog/i-77-truck-accident-northeast-columbia-richland-county/` — below floor
- `/blog/international-boulevard-airport-rideshare-uber-lyft-crash-north-charleston/` — below floor
- `/blog/islands-expressway-whitemarsh-island-motorcycle-accident-chatham-county/` — below floor
- `/blog/jet-ski-personal-watercraft-accidents-charleston/`
- `/blog/johns-island-accidents-no-hospital-emergency-room/` — below floor
- `/blog/kemira-plant-drive-savannah-fatal-truck-accident-lawyer/` — below floor
- `/blog/king-calhoun-intersection-car-collisions/`
- `/blog/legal-rights-after-memory-loss-savannah-crash/`
- `/blog/legal-rights-if-hit-by-driver-in-company-car-charleston/`
- `/blog/liability-and-causes-for-backing-up-crashes-in-charleston/`
- `/blog/liability-for-brake-checking-crashes-charleston/`
- `/blog/liability-for-charleston-underride-truck-crashes/`
- `/blog/liability-for-crash-due-to-tire-blowout-in-savannah/`
- `/blog/liability-for-roundabout-crashes-in-charleston/`
- `/blog/liability-in-head-on-collisions-savannah-ga/`
- `/blog/litchfield-beach-pawleys-island-us-17-car-accident-georgetown-county/` — below floor
- `/blog/litchfield-pawleys-island-golf-cart-accident-lawyer-georgetown-county/` — below floor
- `/blog/lower-king-street-pedestrian-safety/` — below floor
- `/blog/mark-clark-expressway-i-526-18-wheeler-accident-lawyer-north-charleston/` — below floor
- `/blog/maybank-highway-car-accidents-johns-island/` — below floor
- `/blog/mcintosh-county-drunk-driver-accident-lawyer/`
- `/blog/military-base-accidents-joint-base-charleston-rights/`
- `/blog/mistakes-charleston-slip-and-fall-victims-make/`
- `/blog/motorcycle-accident-i-95-glynn-county-brunswick-darien/` — below floor
- `/blog/motorcycle-accidents-dorchester-road-data/` — below floor
- `/blog/mount-pleasant-johnnie-dodds-us-17-uninsured-motorist-lawyer/` — below floor
- `/blog/mount-pleasant-johnnie-dodds-us-17-wrongful-death-car-accident-lawyer/` — below floor
- `/blog/mount-pleasant-mark-clark-expressway-i-526-motorcycle-accident-lawyer/` — below floor
- `/blog/murrells-inlet-jet-ski-accident-lawyer/` — below floor
- `/blog/myrtle-beach-dangerous-roads-intersections/`
- `/blog/n-lake-drive-dick-pond-road-sc-544-underinsured-motorist-lawyer/` — below floor
- `/blog/n-lake-drive-us-17-business-best-car-accident-lawyer/`
- `/blog/nerve-damage-after-charleston-car-crash/`
- `/blog/north-charleston-crime-rate-hit-and-run/`
- `/blog/north-rhett-avenue-truck-accident-hanahan-berkeley-county/` — below floor
- `/blog/nursing-home-abuse-charleston-signs-families/`
- `/blog/old-fort-jackson-savannah-fatal-truck-accident-lawyer/`
- `/blog/park-circle-east-montague-drunk-driving-accident-lawyer-north-charleston/` — below floor
- `/blog/pedestrian-accident-dorchester-road-school-zone-29418-north-charleston/` — below floor
- `/blog/pedestrian-accidents-musc-charleston-medical-district/`
- `/blog/pedestrian-safety-park-circle-north-charleston/` — below floor
- `/blog/personal-injury-claim-charleston-berkeley-dorchester-county/`
- `/blog/port-of-charleston-injury-claims-longshoremen-dock-workers/`
- `/blog/port-truck-accidents-charleston-liability/`
- `/blog/protecting-your-rights-after-a-myrtle-beach-car-accident/`
- `/blog/proving-a-tourist-was-at-fault-in-your-charleston-accident/`
- `/blog/proving-back-pain-after-savannah-car-crash/`
- `/blog/proving-your-pain-after-a-charleston-car-accident/`
- `/blog/recovering-lost-wages-after-a-truck-accident-on-i-526/`
- `/blog/returning-to-work-too-soon-charleston-crash/`
- `/blog/rideshare-accident-i-26-tenmile-north-charleston/` — below floor
- `/blog/rifle-range-road-mount-pleasant-car-accident-heritage-park-west/` — below floor
- `/blog/risk-of-refusing-medical-care-after-car-crash-charleston/`
- `/blog/rivers-avenue-northwoods-bus-accident-lawyer-north-charleston/` — below floor
- `/blog/rivers-avenue-pedestrian-deaths-north-charleston/` — below floor
- `/blog/savannah-dangerous-highways-i16-i95-abercorn/` — below floor
- `/blog/savannah-highway-truck-accidents-west-ashley-us-17/` — below floor
- `/blog/savannah-veterans-parkway-car-accident-lawyer/`
- `/blog/second-opinion-for-charleston-car-crash-injuries/`
- `/blog/seeking-justice-after-a-fatigued-trucker-accident-on-i-26/`
- `/blog/shem-creek-boating-dock-injuries-mount-pleasant/`
- `/blog/shoulder-injuries-after-charleston-car-crash/`
- `/blog/socastee-holmestown-road-underinsured-motorist-lawyer/` — below floor
- `/blog/south-kings-highway-us-17-business-underinsured-motorist-lawyer/` — below floor
- `/blog/southover-mills-b-lane-motorcycle-accident-lawyer/` — below floor
- `/blog/st-andrews-road-widewater-18-wheeler-accident-lawyer-richland-county/` — below floor
- `/blog/st-simons-island-kings-way-motorcycle-accident-lawyer/` — below floor
- `/blog/summer-dui-accidents-charleston-memorial-day-labor-day/`
- `/blog/summerville-i-26-18-wheeler-accident-lawyer-dorchester-county/` — below floor
- `/blog/sunset-boulevard-us-378-lexington-medical-center-accident/` — below floor
- `/blog/sunset-boulevard-west-columbia-drunk-driver-accident-lawyer/` — below floor
- `/blog/surfside-beach-golf-colony-golf-cart-accident-lawyer/`
- `/blog/tactics-insurers-use-to-deny-crash-claims-charleston/`
- `/blog/tenmile-i-26-best-car-accident-lawyer-north-charleston/` — below floor
- `/blog/understanding-eye-injuries-after-a-savannah-car-accident/`
- `/blog/us-17-i-95-darien-wrongful-death-mcintosh-county/` — below floor
- `/blog/us-17-truck-accident-broadfield-glynn-county/`
- `/blog/uturn-crash-liability-in-charleston/`
- `/blog/wando-gardens-faber-place-drive-best-car-accident-lawyer-north-charleston/` — below floor
- `/blog/wearing-headphones-while-driving-in-charleston/`
- `/blog/west-ashley-sam-rittenberg-boulevard-motorcycle-accident-lawyer/` — below floor
- `/blog/west-ashley-vs-downtown-charleston-driving-risks/` — below floor
- `/blog/what-are-my-legal-options-after-a-rideshare-crash-in-charleston/`
- `/blog/what-to-do-after-a-bike-crash-on-charlestons-ravenel-bridge/` — below floor
- `/blog/what-to-do-after-a-car-crash-on-savannah-highway/` — below floor
- `/blog/what-to-do-after-a-hit-and-run-in-downtown-charleston/` — below floor
- `/blog/what-to-do-after-a-truck-accident-on-i-526-in-charleston/` — below floor
- `/blog/what-to-know-about-chest-pain-after-a-savannah-car-crash/`
- `/blog/when-to-call-charleston-personal-injury-lawyer/`
- `/blog/who-pays-for-damages-from-t-bone-crashes-in-savannah/`
- `/blog/why-are-highway-road-shoulder-accidents-in-charleston-dangerous/`
- `/blog/why-car-crashes-happen-close-to-home-charleston/`
- `/blog/why-driving-while-hungover-is-a-dangerous-savannah-crash-risk/`
- `/blog/why-get-black-box-data-after-truck-crash-savannah/`
- `/blog/your-guide-to-documenting-a-james-island-parkway-car-accident/` — below floor
- `/blog/your-guide-to-justice-after-a-charleston-truck-accident/`
- `/blog/your-guide-to-recovering-lost-wages-after-a-charleston-car-accident/`
- `/blog/your-guide-to-rideshare-accidents-in-downtown-charleston/` — below floor
- `/blog/your-step-by-step-guide-after-a-downtown-columbia-truck-accident/` — below floor

### City x practice intersections (138)

- `/atv-side-by-side-accident-lawyers/charleston-sc/`
- `/atv-side-by-side-accident-lawyers/columbia-sc/`
- `/atv-side-by-side-accident-lawyers/darien-ga/`
- `/atv-side-by-side-accident-lawyers/myrtle-beach-sc/`
- `/atv-side-by-side-accident-lawyers/north-charleston-sc/`
- `/atv-side-by-side-accident-lawyers/savannah-ga/`
- `/bicycle-accident-lawyers/charleston-sc/`
- `/bicycle-accident-lawyers/columbia-sc/`
- `/bicycle-accident-lawyers/darien-ga/`
- `/bicycle-accident-lawyers/myrtle-beach-sc/`
- `/bicycle-accident-lawyers/north-charleston-sc/`
- `/bicycle-accident-lawyers/savannah-ga/`
- `/boating-accident-lawyers/charleston-sc/`
- `/boating-accident-lawyers/columbia-sc/`
- `/boating-accident-lawyers/darien-ga/`
- `/boating-accident-lawyers/dock-marina-injury/` — below floor
- `/boating-accident-lawyers/myrtle-beach-sc/`
- `/boating-accident-lawyers/north-charleston-sc/`
- `/boating-accident-lawyers/savannah-ga/`
- `/brain-injury-lawyers/charleston-sc/`
- `/brain-injury-lawyers/columbia-sc/`
- `/brain-injury-lawyers/darien-ga/`
- `/brain-injury-lawyers/myrtle-beach-sc/`
- `/brain-injury-lawyers/north-charleston-sc/`
- `/brain-injury-lawyers/savannah-ga/`
- `/burn-injury-lawyers/charleston-sc/`
- `/burn-injury-lawyers/columbia-sc/`
- `/burn-injury-lawyers/darien-ga/`
- `/burn-injury-lawyers/myrtle-beach-sc/`
- `/burn-injury-lawyers/north-charleston-sc/`
- `/burn-injury-lawyers/savannah-ga/`
- `/car-accident-lawyers/charleston-sc/`
- `/car-accident-lawyers/columbia-sc/`
- `/car-accident-lawyers/darien-ga/`
- `/car-accident-lawyers/myrtle-beach-sc/`
- `/car-accident-lawyers/north-charleston-sc/`
- `/car-accident-lawyers/savannah-ga/`
- `/construction-accident-lawyers/charleston-sc/`
- `/construction-accident-lawyers/columbia-sc/`
- `/construction-accident-lawyers/darien-ga/`
- `/construction-accident-lawyers/myrtle-beach-sc/`
- `/construction-accident-lawyers/north-charleston-sc/`
- `/construction-accident-lawyers/savannah-ga/`
- `/dog-bite-lawyers/charleston-sc/`
- `/dog-bite-lawyers/columbia-sc/`
- `/dog-bite-lawyers/darien-ga/`
- `/dog-bite-lawyers/myrtle-beach-sc/`
- `/dog-bite-lawyers/north-charleston-sc/`
- `/dog-bite-lawyers/savannah-ga/`
- `/electric-scooter-accident-lawyers/charleston-sc/`
- `/electric-scooter-accident-lawyers/columbia-sc/`
- `/electric-scooter-accident-lawyers/darien-ga/`
- `/electric-scooter-accident-lawyers/myrtle-beach-sc/`
- `/electric-scooter-accident-lawyers/north-charleston-sc/`
- `/electric-scooter-accident-lawyers/savannah-ga/`
- `/golf-cart-accident-lawyers/charleston-sc/`
- `/golf-cart-accident-lawyers/columbia-sc/`
- `/golf-cart-accident-lawyers/darien-ga/`
- `/golf-cart-accident-lawyers/myrtle-beach-sc/`
- `/golf-cart-accident-lawyers/north-charleston-sc/`
- `/golf-cart-accident-lawyers/savannah-ga/`
- `/maritime-injury-lawyers/charleston-sc/`
- `/maritime-injury-lawyers/columbia-sc/`
- `/maritime-injury-lawyers/darien-ga/`
- `/maritime-injury-lawyers/myrtle-beach-sc/`
- `/maritime-injury-lawyers/north-charleston-sc/`
- `/maritime-injury-lawyers/savannah-ga/`
- `/medical-malpractice-lawyers/charleston-sc/`
- `/medical-malpractice-lawyers/columbia-sc/`
- `/medical-malpractice-lawyers/darien-ga/`
- `/medical-malpractice-lawyers/myrtle-beach-sc/`
- `/medical-malpractice-lawyers/north-charleston-sc/`
- `/medical-malpractice-lawyers/savannah-ga/`
- `/motorcycle-accident-lawyers/charleston-sc/`
- `/motorcycle-accident-lawyers/columbia-sc/`
- `/motorcycle-accident-lawyers/darien-ga/`
- `/motorcycle-accident-lawyers/myrtle-beach-sc/`
- `/motorcycle-accident-lawyers/north-charleston-sc/`
- `/motorcycle-accident-lawyers/savannah-ga/`
- `/nursing-home-abuse-lawyers/charleston-sc/`
- `/nursing-home-abuse-lawyers/columbia-sc/`
- `/nursing-home-abuse-lawyers/darien-ga/`
- `/nursing-home-abuse-lawyers/myrtle-beach-sc/`
- `/nursing-home-abuse-lawyers/north-charleston-sc/`
- `/nursing-home-abuse-lawyers/savannah-ga/`
- `/pedestrian-accident-lawyers/charleston-sc/`
- `/pedestrian-accident-lawyers/columbia-sc/`
- `/pedestrian-accident-lawyers/darien-ga/`
- `/pedestrian-accident-lawyers/myrtle-beach-sc/`
- `/pedestrian-accident-lawyers/north-charleston-sc/`
- `/pedestrian-accident-lawyers/savannah-ga/`
- `/personal-injury-lawyers/charleston-sc/`
- `/personal-injury-lawyers/columbia-sc/`
- `/personal-injury-lawyers/myrtle-beach-sc/`
- `/personal-injury-lawyers/north-charleston-sc/`
- `/personal-injury-lawyers/savannah-ga/`
- `/premises-liability-lawyers/charleston-sc/`
- `/premises-liability-lawyers/columbia-sc/`
- `/premises-liability-lawyers/darien-ga/`
- `/premises-liability-lawyers/myrtle-beach-sc/`
- `/premises-liability-lawyers/north-charleston-sc/`
- `/premises-liability-lawyers/savannah-ga/`
- `/product-liability-lawyers/charleston-sc/`
- `/product-liability-lawyers/columbia-sc/`
- `/product-liability-lawyers/darien-ga/`
- `/product-liability-lawyers/myrtle-beach-sc/`
- `/product-liability-lawyers/north-charleston-sc/`
- `/product-liability-lawyers/savannah-ga/`
- `/slip-and-fall-lawyers/charleston-sc/`
- `/slip-and-fall-lawyers/columbia-sc/`
- `/slip-and-fall-lawyers/darien-ga/`
- `/slip-and-fall-lawyers/myrtle-beach-sc/`
- `/slip-and-fall-lawyers/north-charleston-sc/`
- `/slip-and-fall-lawyers/savannah-ga/`
- `/spinal-cord-injury-lawyers/charleston-sc/`
- `/spinal-cord-injury-lawyers/columbia-sc/`
- `/spinal-cord-injury-lawyers/darien-ga/`
- `/spinal-cord-injury-lawyers/myrtle-beach-sc/`
- `/spinal-cord-injury-lawyers/north-charleston-sc/`
- `/spinal-cord-injury-lawyers/savannah-ga/`
- `/truck-accident-lawyers/charleston-sc/`
- `/truck-accident-lawyers/columbia-sc/`
- `/truck-accident-lawyers/darien-ga/`
- `/truck-accident-lawyers/myrtle-beach-sc/`
- `/truck-accident-lawyers/north-charleston-sc/`
- `/truck-accident-lawyers/savannah-ga/`
- `/workers-compensation-lawyers/charleston-sc/`
- `/workers-compensation-lawyers/columbia-sc/`
- `/workers-compensation-lawyers/darien-ga/`
- `/workers-compensation-lawyers/myrtle-beach-sc/`
- `/workers-compensation-lawyers/north-charleston-sc/`
- `/workers-compensation-lawyers/savannah-ga/`
- `/wrongful-death-lawyers/charleston-sc/`
- `/wrongful-death-lawyers/columbia-sc/`
- `/wrongful-death-lawyers/darien-ga/`
- `/wrongful-death-lawyers/myrtle-beach-sc/`
- `/wrongful-death-lawyers/north-charleston-sc/`
- `/wrongful-death-lawyers/savannah-ga/`

### Location pages (51)

- `/locations/georgia/`
- `/locations/georgia/darien/`
- `/locations/georgia/darien/alma/`
- `/locations/georgia/darien/blackshear/`
- `/locations/georgia/darien/brunswick/`
- `/locations/georgia/darien/folkston/`
- `/locations/georgia/darien/harrietts-bluff/` — below floor
- `/locations/georgia/darien/hoboken/`
- `/locations/georgia/darien/jekyll-island/` — below floor
- `/locations/georgia/darien/jesup/`
- `/locations/georgia/darien/kings-bay/` — below floor
- `/locations/georgia/darien/kingsland/`
- `/locations/georgia/darien/nahunta/`
- `/locations/georgia/darien/sea-island/` — below floor
- `/locations/georgia/darien/st-simons-island/` — below floor
- `/locations/georgia/darien/waycross/`
- `/locations/georgia/darien/woodbine/`
- `/locations/georgia/savannah/`
- `/locations/georgia/savannah/bryan-county/`
- `/locations/georgia/savannah/hinesville/`
- `/locations/georgia/savannah/pooler/`
- `/locations/georgia/savannah/port-wentworth/`
- `/locations/georgia/savannah/skidaway-island/` — below floor
- `/locations/georgia/savannah/statesboro/`
- `/locations/georgia/savannah/whitemarsh-island/` — below floor
- `/locations/south-carolina/`
- `/locations/south-carolina/charleston/`
- `/locations/south-carolina/charleston/isle-of-palms/`
- `/locations/south-carolina/charleston/james-island/`
- `/locations/south-carolina/charleston/mount-pleasant/`
- `/locations/south-carolina/columbia/`
- `/locations/south-carolina/columbia/batesburg-leesville/`
- `/locations/south-carolina/columbia/cayce/`
- `/locations/south-carolina/columbia/chapin/`
- `/locations/south-carolina/columbia/elgin/`
- `/locations/south-carolina/columbia/forest-acres/`
- `/locations/south-carolina/columbia/lugoff/` — below floor
- `/locations/south-carolina/columbia/red-bank/` — below floor
- `/locations/south-carolina/columbia/west-columbia/`
- `/locations/south-carolina/myrtle-beach/`
- `/locations/south-carolina/myrtle-beach/andrews/`
- `/locations/south-carolina/myrtle-beach/carolina-forest/` — below floor
- `/locations/south-carolina/myrtle-beach/conway/`
- `/locations/south-carolina/myrtle-beach/georgetown/`
- `/locations/south-carolina/myrtle-beach/little-river/` — below floor
- `/locations/south-carolina/myrtle-beach/murrells-inlet/` — below floor
- `/locations/south-carolina/myrtle-beach/surfside-beach/`
- `/locations/south-carolina/north-charleston/`
- `/locations/south-carolina/north-charleston/goose-creek/`
- `/locations/south-carolina/north-charleston/ladson/` — below floor
- `/locations/south-carolina/north-charleston/summerville/`

### ES city x practice intersections (39)

- `/es/bicycle-accident-lawyers/charleston-sc/`
- `/es/bicycle-accident-lawyers/columbia-sc/`
- `/es/bicycle-accident-lawyers/darien-ga/`
- `/es/bicycle-accident-lawyers/myrtle-beach-sc/`
- `/es/bicycle-accident-lawyers/north-charleston-sc/`
- `/es/bicycle-accident-lawyers/savannah-ga/`
- `/es/car-accident-lawyers/charleston-sc/`
- `/es/car-accident-lawyers/columbia-sc/`
- `/es/car-accident-lawyers/myrtle-beach-sc/`
- `/es/car-accident-lawyers/north-charleston-sc/`
- `/es/car-accident-lawyers/savannah-ga/`
- `/es/construction-accident-lawyers/charleston-sc/`
- `/es/construction-accident-lawyers/columbia-sc/`
- `/es/construction-accident-lawyers/myrtle-beach-sc/`
- `/es/construction-accident-lawyers/north-charleston-sc/`
- `/es/construction-accident-lawyers/savannah-ga/`
- `/es/motorcycle-accident-lawyers/charleston-sc/`
- `/es/motorcycle-accident-lawyers/columbia-sc/`
- `/es/motorcycle-accident-lawyers/darien-ga/`
- `/es/motorcycle-accident-lawyers/myrtle-beach-sc/`
- `/es/motorcycle-accident-lawyers/north-charleston-sc/`
- `/es/motorcycle-accident-lawyers/savannah-ga/`
- `/es/pedestrian-accident-lawyers/charleston-sc/`
- `/es/pedestrian-accident-lawyers/columbia-sc/`
- `/es/pedestrian-accident-lawyers/darien-ga/`
- `/es/pedestrian-accident-lawyers/myrtle-beach-sc/`
- `/es/pedestrian-accident-lawyers/north-charleston-sc/`
- `/es/pedestrian-accident-lawyers/savannah-ga/`
- `/es/truck-accident-lawyers/charleston-sc/`
- `/es/truck-accident-lawyers/columbia-sc/`
- `/es/truck-accident-lawyers/myrtle-beach-sc/`
- `/es/truck-accident-lawyers/north-charleston-sc/`
- `/es/truck-accident-lawyers/savannah-ga/`
- `/es/workers-compensation-lawyers/charleston-sc/`
- `/es/workers-compensation-lawyers/columbia-sc/`
- `/es/workers-compensation-lawyers/darien-ga/`
- `/es/workers-compensation-lawyers/myrtle-beach-sc/`
- `/es/workers-compensation-lawyers/north-charleston-sc/`
- `/es/workers-compensation-lawyers/savannah-ga/`

### Resources (truck-corridor series) (38)

- `/resources/abercorn-street-truck-accidents-savannah/` — below floor
- `/resources/ashley-phosphate-i-26-truck-accidents/` — below floor
- `/resources/aviation-avenue-i-26-truck-accidents/` — below floor
- `/resources/bay-street-truck-accidents-savannah-historic-district/` — below floor
- `/resources/blythewood-i-77-truck-accidents/` — below floor
- `/resources/broad-river-road-truck-accidents-columbia/`
- `/resources/bush-river-road-i-26-truck-accidents-columbia/` — below floor
- `/resources/columbia-i-26-i-20-i-77-interchange-truck-accidents/` — below floor
- `/resources/dangerous-roads-north-charleston/`
- `/resources/dean-forest-road-truck-accidents-pooler/` — below floor
- `/resources/dorchester-road-truck-accidents-north-charleston/` — below floor
- `/resources/georgetown-county-us-17-truck-accidents/` — below floor
- `/resources/highway-22-truck-accidents-conway-bypass/` — below floor
- `/resources/i-16-i-95-construction-zone-truck-accidents/`
- `/resources/i-16-truck-accidents-savannah/` — below floor
- `/resources/i-20-truck-accidents-columbia/` — below floor
- `/resources/i-26-i-95-corridor-report/`
- `/resources/i-516-truck-accidents-port-savannah/` — below floor
- `/resources/i-526-construction-zone-truck-accidents-charleston/` — below floor
- `/resources/i-526-truck-accidents-charleston/` — below floor
- `/resources/i-77-truck-accidents-columbia-rock-hill/` — below floor
- `/resources/i-95-truck-accidents-savannah-brunswick/` — below floor
- `/resources/i-95-widening-construction-zone-ga-sc/`
- `/resources/jimmy-deloach-connector-truck-accidents-savannah/` — below floor
- `/resources/logging-truck-accidents-us-17-mcintosh-glynn/`
- `/resources/myrtle-beach-fatal-crashes/`
- `/resources/north-charleston-truck-accident-guide/`
- `/resources/pedestrian-bicycle-safety-north-charleston/`
- `/resources/personal-injury-claim-charleston-county-court/`
- `/resources/pooler-warehouse-district-truck-accidents/`
- `/resources/port-access-road-truck-accidents-leatherman-terminal/` — below floor
- `/resources/port-of-savannah-truck-routes/`
- `/resources/rivers-avenue-truck-accidents-north-charleston/` — below floor
- `/resources/spruill-avenue-port-trucks-north-charleston/` — below floor
- `/resources/summerville-truck-accidents-i-26-corridor/` — below floor
- `/resources/two-notch-road-truck-accidents-columbia/` — below floor
- `/resources/us-17-sc-544-truck-accidents-surfside-beach/` — below floor
- `/resources/us-52-truck-train-accidents-goose-creek/` — below floor

### ES blog posts (28)

- `/es/blog/boys-estate-glynn-county-best-car-accident-lawyer/`
- `/es/blog/brunswick-ocean-highway-us-17-underinsured-motorist-lawyer-glynn-county/` — below floor
- `/es/blog/car-accident-attorney-near-me-west-ashley-citadel-mall/` — below floor
- `/es/blog/cayce-12th-street-uninsured-motorist-lawyer/` — below floor
- `/es/blog/chicora-cherokee-carner-avenue-us-52-car-accident-attorney-north-charleston/` — below floor
- `/es/blog/dick-pond-road-sc-544-truck-accident-lawyer-surfside-beach/` — below floor
- `/es/blog/east-bay-street-savannah-pedestrian-accident-lawyer/` — below floor
- `/es/blog/eulonia-us-17-ocean-highway-rideshare-uber-accident-lawyer-mcintosh-county/`
- `/es/blog/garden-city-ga-21-augusta-road-car-accident-lawyer/` — below floor
- `/es/blog/golf-colony-south-reindeer-road-underinsured-motorist-lawyer/` — below floor
- `/es/blog/green-grove-dorchester-road-atv-accident-lawyer-north-charleston/` — below floor
- `/es/blog/green-grove-mark-clark-expressway-uninsured-motorist-lawyer-north-charleston/` — below floor
- `/es/blog/i-20-bush-river-road-motorcycle-accident-lawyer-columbia/` — below floor
- `/es/blog/kemira-plant-drive-savannah-fatal-truck-accident-lawyer/` — below floor
- `/es/blog/litchfield-pawleys-island-golf-cart-accident-lawyer-georgetown-county/` — below floor
- `/es/blog/mount-pleasant-johnnie-dodds-us-17-uninsured-motorist-lawyer/` — below floor
- `/es/blog/mount-pleasant-mark-clark-expressway-i-526-motorcycle-accident-lawyer/` — below floor
- `/es/blog/murrells-inlet-jet-ski-accident-lawyer/` — below floor
- `/es/blog/n-lake-drive-dick-pond-road-sc-544-underinsured-motorist-lawyer/` — below floor
- `/es/blog/n-lake-drive-us-17-business-best-car-accident-lawyer/`
- `/es/blog/old-fort-jackson-savannah-fatal-truck-accident-lawyer/`
- `/es/blog/rivers-avenue-northwoods-bus-accident-lawyer-north-charleston/` — below floor
- `/es/blog/southover-mills-b-lane-motorcycle-accident-lawyer/` — below floor
- `/es/blog/st-andrews-road-widewater-18-wheeler-accident-lawyer-richland-county/` — below floor
- `/es/blog/st-simons-island-kings-way-motorcycle-accident-lawyer/` — below floor
- `/es/blog/summerville-i-26-18-wheeler-accident-lawyer-dorchester-county/` — below floor
- `/es/blog/tenmile-i-26-best-car-accident-lawyer-north-charleston/` — below floor
- `/es/blog/wando-gardens-faber-place-drive-best-car-accident-lawyer-north-charleston/` — below floor

### Legacy root city pages (6)

- `/florence-sc-car-accident-lawyer/`
- `/florence-sc-workers-compensation-lawyer/`
- `/greenville-sc-car-accident-lawyer/`
- `/greenville-sc-workers-compensation-lawyer/`
- `/spartanburg-sc-car-accident-lawyer/`
- `/spartanburg-sc-workers-compensation-lawyer/`

### ES location pages (6)

- `/es/locations/georgia/darien/`
- `/es/locations/georgia/savannah/`
- `/es/locations/south-carolina/charleston/`
- `/es/locations/south-carolina/columbia/`
- `/es/locations/south-carolina/myrtle-beach/`
- `/es/locations/south-carolina/north-charleston/`

## GSC baseline for the 13 EVALUATE location pages (added 2026-09-18)

The triage held these 13 under plan rule 4 pending a Search Console baseline. That baseline
existed already: the 2026-08-24 API pull (`docs/gsc-2026-08-24/Pages-full-api.csv`, 13 months to
2026-08-22) that retired the 66 zero-click pages in #68 kept these because each had at least one
click. A fresh pull on 2026-09-18 adds a 16-month window and the post-cull window since
2026-08-26 (`docs/gsc-2026-09-18/`). The property is the URL-prefix `https://rodenlaw.com/`;
`sc-domain:rodenlaw.com`, as written in the October brief, returns 403.

| Page | Baseline (13 mo) | 16 mo to 2026-09-15 | Since 2026-08-26 |
|---|---|---|---|
| `/locations/georgia/darien/st-simons-island/` | 4 clicks / 1,727 imp / pos 8.3 | 4 / 2,058 / 8.8 | 0 / 300 / 11.2 |
| `/locations/south-carolina/myrtle-beach/murrells-inlet/` | 1 / 1,777 / 17.0 | 1 / 2,093 / 16.2 | 0 / 256 / 10.9 |
| `/locations/south-carolina/myrtle-beach/little-river/` | 1 / 1,499 / 7.7 | 1 / 1,694 / 8.0 | 0 / 187 / 10.0 |
| `/locations/georgia/darien/kings-bay/` | 1 / 712 / 8.2 | 1 / 729 / 8.2 | 0 / 15 / 8.5 |
| `/locations/south-carolina/columbia/lugoff/` | 1 / 587 / 8.3 | 1 / 629 / 9.6 | 0 / 39 / 29.6 |
| `/locations/south-carolina/north-charleston/ladson/` | 1 / 458 / 13.6 | 1 / 458 / 13.6 | 0 / 0 / — |
| `/locations/georgia/darien/jekyll-island/` | 2 / 355 / 12.5 | 2 / 388 / 13.8 | 0 / 33 / 27.6 |
| `/locations/georgia/savannah/skidaway-island/` | 1 / 329 / 15.9 | 1 / 517 / 22.5 | 0 / 165 / 27.0 |
| `/locations/south-carolina/columbia/red-bank/` | 1 / 319 / 9.4 | 1 / 339 / 9.2 | 0 / 10 / 6.2 |
| `/locations/georgia/darien/harrietts-bluff/` | 1 / 182 / 8.9 | 1 / 211 / 13.3 | 0 / 28 / 42.4 |
| `/locations/south-carolina/myrtle-beach/carolina-forest/` | 2 / 179 / 12.0 | 2 / 207 / 11.2 | 0 / 23 / 5.3 |
| `/locations/georgia/savannah/whitemarsh-island/` | 1 / 116 / 10.7 | 1 / 122 / 10.4 | 0 / 6 / 5.5 |
| `/locations/georgia/darien/sea-island/` | 2 / 63 / 8.8 | 2 / 70 / 8.6 | 0 / 7 / 6.6 |
| **Total** | **19 / 8,303** | **19 / 9,515** | **0 / 1,069** |

**Read.** The 16-month window adds no clicks to the 13-month baseline: 19 clicks in total, all of
them before the cull, and zero in the 24 days since. Against the site's own click-through at
matched positions (the test #68 used), the 13 earned 11 clicks on 5,089 impressions at positions
5–10 where the site rate predicts 24, and 2 on 2,106 at 15–20 where it predicts 4 or 5. They are
weaker than the site but not the flat zero that condemned the 66. Every one is an unincorporated
place (CDP, island, or naval base), so the granularity floor is right to flag them; none can be
rescued by adding it to the municipality list.

Plan rule 4's test is "real rankings, traffic or genuine service history". Rankings: yes, most
sit at 8–14. Traffic: 1.5 clicks per page over 16 months, and none since August. Service history:
Murrells Inlet is where the Myrtle Beach GBP is registered (open question in the Q4 strategy), and
St. Simons Island is the strongest of the set. The default under rule 4 is a 301 to the parent
office-city hub. Retiring all 13 moves the doorway ratio from 40.6% to 39.9%; it is a floor
cleanup, not a ratio fix.

Side note from the post-cull pull: 63 of the 79 location URLs retired in August still record
impressions (18,634) and 6 clicks since 2026-08-26. Search Console reports the redirected URL
until Google recrawls it, so this is expected and should fade; worth re-checking in the
October compare pull.
