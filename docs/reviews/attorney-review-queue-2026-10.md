# Attorney review queue: legal posts with no covering review (2026-10)

Generated 2026-10-22 from production (read-only) and `data/gsc/latest.json` (28 days, 2026-09-21 to 2026-10-18). Full list: `attorney-review-queue-2026-10.csv`, ranked by clicks then impressions.

**What this is.** `reviewedBy` on a page claims a named attorney checked it. This list is every published blog post and resource where that claim can't honestly be made yet:
- 271 with no review on record;
- 16 whose credited lawyer isn't admitted in every state the page covers (they keep their review date but publish no name since #234).

**How a review gets recorded.** An attorney reads the page and confirms it's accurate (or sends corrections, which are fixed first). Brian relays it, and `bin/record-attorney-reviews.php` records `{post_id, reviewer, date, jurisdiction, source}`. It refuses a reviewer who isn't admitted where the page applies, a missing source, or a made-up date. Nothing is recorded without that relay.

**Jurisdiction.** 233 posts had none recorded. The suggestion comes from the post's own text (statute citations weighted over state and city names) and is for routing only. The reviewer confirms it, and the recording script stores it. 8 posts have no state signal and need a decision.

## Load by reviewer

| Suggested reviewer | Posts | With clicks (28d) | Clicks | Impressions | Words to read |
|---|---:|---:|---:|---:|---:|
| Eric Roden | 123 | 20 | 52 | 17415 | 98,361 |
| Graeham C. Gillin | 85 | 26 | 129 | 14656 | 107,175 |
| Pair: Joshua Dorminy (GA) + Graeham C. Gillin (SC) | 71 | 23 | 80 | 14230 | 140,250 |
| (needs a decision) | 8 | 1 | 2 | 902 | 6,167 |
| **Total** | **287** | **70** | **263** | **47203** | **351,953** |

Routing: GA → the author if a GA reviewer, else Tyler Love; SC → Graeham C. Gillin; **both states → a pair, one GA reviewer and Gillin.** Updated 2026-10-22: Dorminy is a designated reviewer but admitted in Georgia only, Ivy S. Montano is Georgia only, and no attorney at the firm is admitted in both states. **The theme names one reviewer and requires that lawyer to cover every state on the page, so two-state pages cannot publish `reviewedBy` until it accepts two reviewers.** A pair of reviews can still be recorded; the date publishes either way.

Traffic is concentrated: 258 of 287 pages had any impressions in 28 days, and 70 had a click. The first batch below covers most of the traffic.

## Batch 1: the 25 pages with the most search traffic

| # | Page | Clicks | Impr. | Jurisdiction | Reviewer | Words |
|---|---|---:|---:|---|---|---:|
| 1 | [South Carolina Workers’ Comp Body Part Value Chart](https://rodenlaw.com/resources/south-carolina-workers-comp-body-part-values/) | 40 | 2427 | sc | Graeham C. Gillin | 826 |
| 2 | [How Much Is a HIPAA Violation Lawsuit Worth?](https://rodenlaw.com/blog/hipaa-violation-lawsuit-worth/) | 24 | 1650 | both | Dorminy (GA) + Gillin (SC) | 1773 |
| 3 | [Stacking UM and UIM Coverage in South Carolina](https://rodenlaw.com/resources/south-carolina-um-uim-stacking/) | 21 | 834 | sc | Graeham C. Gillin | 1031 |
| 4 | [HIPAA Violation Lawyer for Patients in Georgia and South Carolina](https://rodenlaw.com/blog/hipaa-violation-lawyer/) | 19 | 779 | both | Dorminy (GA) + Gillin (SC) | 1535 |
| 5 | [How Much Is a SC Wrongful Death Case Worth?](https://rodenlaw.com/resources/south-carolina-wrongful-death-settlement-value/) | 9 | 411 | sc | Graeham C. Gillin | 1177 |
| 6 | [Why Should I Hire a Medical Malpractice Lawyer?](https://rodenlaw.com/blog/advantages-of-a-medical-malpractice-attorney/) | 7 | 5246 | ga* | Eric Roden | 790 |
| 7 | [How Much Is a SC Car Accident Case Worth?](https://rodenlaw.com/resources/south-carolina-car-accident-settlement-value/) | 7 | 1289 | sc | Graeham C. Gillin | 1593 |
| 8 | [Does Employer Bankruptcy Halt Workers’ Comp Benefits?](https://rodenlaw.com/blog/what-happens-to-workers-comp-if-employer-bankrupts/) | 7 | 82 | ga* | Eric Roden | 615 |
| 9 | [What to Do After a Car Accident in Georgia: A Complete Legal Guide](https://rodenlaw.com/blog/what-to-do-after-car-accident-georgia/) | 6 | 1319 | ga* | Eric Roden | 2487 |
| 10 | [I-95 Widening Construction Zone: Georgia-South Carolina Border](https://rodenlaw.com/resources/i-95-widening-construction-zone-ga-sc/) | 6 | 598 | ga | Eric Roden | 1149 |
| 11 | [How Much Is a SC Slip and Fall Case Worth?](https://rodenlaw.com/resources/south-carolina-slip-and-fall-settlement-value/) | 6 | 371 | sc | Graeham C. Gillin | 1324 |
| 12 | [How Much Does South Carolina Workers’ Comp Pay?](https://rodenlaw.com/resources/how-much-does-south-carolina-workers-comp-pay/) | 5 | 836 | sc | Graeham C. Gillin | 883 |
| 13 | [Can You Sue for a HIPAA Violation in Georgia or South Carolina?](https://rodenlaw.com/blog/can-you-sue-hipaa-violation/) | 5 | 460 | both | Dorminy (GA) + Gillin (SC) | 1837 |
| 14 | [¿Una violación de HIPAA es negligencia médica?](https://rodenlaw.com/es/blog/is-hipaa-violation-medical-malpractice/) | 5 | 357 | both | Dorminy (GA) + Gillin (SC) | 1915 |
| 15 | [What South Carolina’s 2026 Liquor Liability Law Changed](https://rodenlaw.com/resources/south-carolina-liquor-liability-2026/) | 5 | 157 | sc | Graeham C. Gillin | 1146 |
| 16 | [South Carolina Pedestrian Right-of-Way Laws: What Accident Victims Need to Know](https://rodenlaw.com/blog/south-carolina-pedestrian-right-of-way-laws/) | 4 | 1038 | sc* | Graeham C. Gillin | 2524 |
| 17 | [What to Know About Workers’ Compensation for Burn Injuries](https://rodenlaw.com/blog/burn-injury-workers-compensation/) | 4 | 623 | ga* | Eric Roden | 827 |
| 18 | [North Charleston Pedestrian & Bicycle Safety: Know Your Rights](https://rodenlaw.com/resources/pedestrian-bicycle-safety-north-charleston/) | 4 | 191 | sc | Graeham C. Gillin | 647 |
| 19 | [Types of Major Injuries From ‘Minor’ Car Accidents](https://rodenlaw.com/blog/major-injuries-from-minor-car-accidents/) | 3 | 1027 | ga* | Eric Roden | 633 |
| 20 | [Can You Sue a Hospital for Negligence in Georgia or South Carolina?](https://rodenlaw.com/blog/can-you-sue-hospital-negligence/) | 3 | 1023 | both | Dorminy (GA) + Gillin (SC) | 1833 |
| 21 | [How Much Is a SC Truck Accident Case Worth?](https://rodenlaw.com/resources/south-carolina-truck-accident-settlement-value/) | 3 | 934 | sc | Graeham C. Gillin | 1475 |
| 22 | [How a Liability Waiver May Affect Your Ability to File a Lawsuit After an Injury](https://rodenlaw.com/blog/liability-waivers-and-injury-lawsuits/) | 3 | 289 | ga* | Eric Roden | 737 |
| 23 | [How Arbitration Works in Personal Injury Cases](https://rodenlaw.com/blog/resolving-claims-through-arbitration/) | 3 | 229 | both* | Dorminy (GA) + Gillin (SC) | 2565 |
| 24 | [Blythewood & I-77 Truck Accidents North of Columbia](https://rodenlaw.com/resources/blythewood-i-77-truck-accidents/) | 3 | 174 | sc | Graeham C. Gillin | 1219 |
| 25 | [South Carolina Statute of Limitations for Personal Injury Claims](https://rodenlaw.com/resources/south-carolina-statute-of-limitations/) | 3 | 68 | sc | Graeham C. Gillin | 1406 |

\* suggested from the text, not recorded.

Batch 1 covers 205 of 263 clicks and 22412 of 47203 impressions in the queue, for 33,947 words of reading.

## Needs a decision before routing

- [Lowering the Risk of Choking Accidents in Nursing Homes](https://rodenlaw.com/blog/choking-at-nursing-homes/) (#1826): no state signal in the text
- [4 Dangerous Types of Construction Accidents](https://rodenlaw.com/blog/four-common-construction-accidents/) (#1822): no state signal in the text
- [How to Handle Calls From Insurance Companies After an Accident](https://rodenlaw.com/blog/how-to-handle-calls-from-insurance-companies/) (#1743): no state signal in the text
- [What Documents Do I Need to Prove My Personal Injury Claim?](https://rodenlaw.com/blog/documents-for-personal-injury-claim/) (#1794): no state signal in the text
- [What is a Deposition in a Personal Injury Claim?](https://rodenlaw.com/blog/deposition-in-a-personal-injury-claim/) (#1755): no state signal in the text
- [Tips on Safe Driving and Readying a Car for Road Trips](https://rodenlaw.com/blog/summer-road-trip-safety/) (#1825): no state signal in the text
- [7 Tips for Driving Safe During the Holiday Season](https://rodenlaw.com/blog/seven-safe-driving-tips/) (#1803): no state signal in the text
- [Steps to Take After a Truck Accident](https://rodenlaw.com/blog/steps-after-truck-accident/) (#1832): no state signal in the text

## Recording format

```json
[{ "post_id": 4839, "reviewer": "graeham-c-gillin", "date": "YYYY-MM-DD", "jurisdiction": "sc", "source": "Brian, YYYY-MM-DD: <attorney> reviewed batch 1" }]
```

## Second-state reviews: 62 pages (added 2026-10-22)

These 62 pages have a review on record from one lawyer, but they state both states' law. Their jurisdiction was read and recorded as `both` (owner-approved, 2026-10-22; see `confirm-jurisdiction-2026-10.md`). Since then each one shows its review date with no reviewer name. A second-state review brings both names back, recorded as a pair with `bin/record-attorney-reviews.php`:

- **54 reviewed by Gillin (SC):** a Georgia lawyer (Eric Roden or Joshua Dorminy) reviews the Georgia sections. That's 165 clicks in 28 days.
- **8 reviewed by Eric Roden (GA):** Gillin reviews the South Carolina sections. That's 6 clicks.

Full list, ranked by traffic: `second-state-reviews-2026-10.csv`. The 10 with the most traffic:

| Page | Clicks | Reviewed by | Needs |
|---|---:|---|---|
| [Reasons Why Insurance Companies May Ignore Your Demand Letter](https://rodenlaw.com/blog/insurance-company-ignoring-demand-letter/) | 21 | Gillin | GA lawyer, Georgia sections |
| [Average Personal Injury Settlement Amounts: What to Realistically Expect](https://rodenlaw.com/blog/average-personal-injury-settlement-amounts/) | 11 | Gillin | GA lawyer, Georgia sections |
| [Can an Insurance Company Go Against a Police Report in Georgia or South Carolina?](https://rodenlaw.com/blog/can-an-insurance-company-go-against-a-police-report/) | 11 | Gillin | GA lawyer, Georgia sections |
| [Gym Liability Explained](https://rodenlaw.com/blog/gym-injury-liability/) | 10 | Gillin | GA lawyer, Georgia sections |
| [Epilepsy & Driving: Liability for Seizure-Related Crashes](https://rodenlaw.com/blog/liability-for-epilepsy-related-car-accidents/) | 8 | Gillin | GA lawyer, Georgia sections |
| [How to Answer Insurance Company Questions After a Car Accident in Georgia or South Carolina](https://rodenlaw.com/blog/answering-insurance-questions-after-crash/) | 8 | Gillin | GA lawyer, Georgia sections |
| [Seeking Workers’ Compensation for a Sprained Ankle at Work](https://rodenlaw.com/blog/when-does-a-sprained-ankle-become-a-work-injury/) | 7 | Gillin | GA lawyer, Georgia sections |
| [Do Traffic Tickets Determine Fault in a Car Accident?](https://rodenlaw.com/blog/traffic-tickets-and-car-accident-claims/) | 6 | Gillin | GA lawyer, Georgia sections |
| [What Do Fault and No-Fault Mean in Car Insurance?](https://rodenlaw.com/blog/fault-vs-no-fault-car-insurance/) | 5 | Gillin | GA lawyer, Georgia sections |
| [How Surgery Impacts Your Personal Injury Claim: What You Need to Know](https://rodenlaw.com/blog/impact-of-surgery-recommendation/) | 5 | Gillin | GA lawyer, Georgia sections |
