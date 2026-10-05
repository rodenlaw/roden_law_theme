# Group-1 follow-ups, researched fixes — 9 pages, 2026-10-05

Owner: "do the group 1 fixes", then "apply" after reviewing the diffs (`post-<id>/diff.txt`).
Authorities are in `atv-findings.json`, `totalloss-findings.json`, `i16-findings.json` and each post's `facts-<id>.json`.

## ATV / side-by-side cluster (4089, 4179, 4180, 4182, 4183, 4184, 4900)

- **O.C.G.A. § 40-7-120 does not exist.** Georgia's Off-Road Vehicle Act is §§ 40-7-1 to 40-7-6. Replaced with the real
  provisions (§ 40-7-4 operating prohibitions, § 40-7-5 local ordinances, § 40-6-305/-306 farm-use road exception,
  § 40-1-1(3) ATV definition). Georgia has no statewide ATV age, course or engine-size rule; claims implying one removed.
- **S.C. Code § 56-15-10 is the dealer-regulation definitions section.** Replaced with Chandler's Law (§§ 50-26-10 to -70):
  under-6 ban, under-16 passenger rule, safety-course certificate and helmet for 15 and under, misdemeanor $50–$200.
  Chandler's Law covers handlebar ATVs only; UTV text says so.
- 4900 (Spanish hub): FAQ answer 6 corrected to match.
- 4180: the SC side-by-side FAQ describes the law as it stands today. **Revisit after SC Act 164 takes effect 2026-11-18.**

## 4587 — /blog/car-totaled-in-accident-what-to-do/ (11 edits)

- **O.C.G.A. § 33-34-6 is not a total-loss threshold, and Georgia has none.** Georgia's settlement rules are Ga. Comp. R. &
  Regs. r. 120-2-52-.06, which covers the reader's own policy only; the insurer decides total loss.
- **S.C. Code § 38-77-30 is a definitions section.** South Carolina's threshold is statutory: repair cost ≥ 75% of pre-loss
  fair market value (§ 56-19-480(G)). Lowball settlement as a general business practice is an improper claim practice.
- Salvage-title wording, loss-of-use (r. 120-2-52-.07) and the Commissioner arbitration path (r. 120-2-52-.03(6),
  conditional on a panel) corrected. Key Takeaways and FAQs 1 and 5 aligned.
- Still open (tracker): the 20–40% resale figure, the $20–$40 gap-insurance cost and the III line.

## 4649 — /resources/i-16-truck-accidents-savannah/ (7 edits)

- "I-16 is the 3rd deadliest highway in Georgia" dropped. FARS 2020–24 puts I-16 6th among Georgia interstates by deaths
  (66) and lowest of the six per mile. The only "3rd" sources are marketing pages.
- "30,000 truck trips daily" (I-16 carrying the majority) replaced with GPA's 14,000–16,000 truck moves a day, Mon–Fri
  (2025, via WTOC; gaports.com challenge not solved). The I-16 share is unsourced and was removed.
- "The Devil's Highway" removed everywhere: no documented basis outside law-firm marketing pages (facts-4538 verdict,
  reused). The H2 is now "I-16: A Main Truck Corridor Out of the Port of Savannah". Excerpt, Key Takeaways and FAQ 1 aligned.
- Still open (tracker): the title "Savannah's Deadliest Freight Corridor" is contradicted by the data; "every container
  travels I-16" is false; "5.9M TEUs in 2023" is the 2022 figure; the 81% truck-death claim is unchecked.

## Apply and verification

Prod backups (`prod-backup-before.json`) were taken first. Applied through `bin/freshness-build-patch.mjs --apply`,
post_modified stamped 2026-10-05 21:40:14, both cache layers flushed. Readback (`readback-research.json`): every post
matches, 0 bad cites, 0 "Devil's Highway".

Verified live in Chrome (`?nc=`): all nine return 200 with no redirect. None of `40-7-120`, `56-15-10`, `38-77-30`,
`33-34-6` or "Devil's Highway" appears in rendered text. Every JSON-LD block parses, FAQPage counts are intact, and
dateModified is 2026-10-05. `bin/check-unslashed-post-writes.php` PASS (static and live). `content/meta.json` regenerated:
the diff touches only group-1 pages (4179 and 4183 were body-only, so they don't appear).
