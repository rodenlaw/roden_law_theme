# Firm-fact answers applied — 15 pages and the office record, 2026-10-06

Owner's answers to the three firm questions: "1. usually, 2. Let's use Georgetown, 3. unsure".

## 1. Case expenses: "usually", not "all"

The contingency-fee post was the one flagged, but a class sweep (`sweep.php`, results `sweep.tsv`; English and Spanish,
across body, excerpt, Key Takeaways, local content and FAQs of every published post type) found the same absolute promise
on 14 pages. Every one now says the firm *typically* advances costs:

| Post | Surface | Was → now |
|---|---|---|
| 1753 /blog/contingency-fee-system/ | body | "We advance all case expenses" → "We typically advance the costs of your case" |
| 1816 /blog/benefits-of-hiring-personal-injury-lawyer/ | body | "Your attorney advances all case costs" → "…typically advances case costs" |
| 1705 /blog/benefits-of-an-accident-reconstruction-expert/ | Key Takeaways, FAQ 2 | "advances all expert costs" → "typically advances expert costs" (both) |
| 1813 /blog/how-do-i-know-if-i-have-a-medical-malpractice-case/ | FAQ 6 | "also advances all case expenses" → "typically advances case expenses" |
| 1646 /blog/first-steps-in-a-medical-malpractice-case/ | body | "We advance all costs of investigation…" → "We typically advance the costs of investigation…" |
| 1696 /blog/what-if-i-suspect-medical-malpractice/ | body, FAQ 6 | same |
| 1704 /blog/filing-a-claim-for-an-injured-minor/ | FAQ 6 | "We advance all case costs and expenses" → "We typically advance case costs and expenses" |
| 3608 /practice-areas/medical-malpractice-lawyers/ | FAQ 5 | "we advance all costs" → "we typically advance case costs" |
| 3615 /practice-areas/product-liability-lawyers/ | FAQ 9 | "we advance all case costs" → "we typically advance case costs" |
| 3619 /practice-areas/nursing-home-abuse-lawyers/ | FAQ 10 | "We fund all case expenses in advance" → "We typically advance case expenses" |
| 3620 /practice-areas/premises-liability-lawyers/ | FAQ 10 | "We advance all investigation costs" → "We typically advance investigation costs" |
| 4181 ATV product defect | body | "We advance all case costs" → "We typically advance case costs" |
| 4182 child ATV injury | body | "advance all case costs" → "typically advance case costs" |
| 4896 /es/practice-areas/burn-injury-lawyers/ | FAQ 10 | "nosotros adelantamos todos esos gastos" → "normalmente nosotros adelantamos esos gastos" |

The theme has no such line (grep of `wordpress/wp-content/themes/roden-law/`).

## 2. Murrells Inlet office county: Georgetown

The U.S. Census geocoder (re-run 2026-10-06 on both the street address and the office coordinates) places 631 Bellamy
Ave. in Georgetown County. `client.json` and `profiles/firm-facts.md` said Horry; both now say Georgetown, and
`local-seo.config.json` was regenerated with `gen-configs.mjs roden --write --only local-seo` (that address was the only
difference; `radar.config.json` already matched). No live page states the office's county. The listed court (Horry
County, Conway) is unchanged: venue follows the crash or the defendant, not the office.

## 3. "Handled dozens of cases": unsure → removed

4337 `/blog/ashley-phosphate-road-i-26-dangerous-intersection-charleston/`: "has handled dozens of cases from the Ashley
Phosphate/I-26 intersection" → "handles crash cases from the Ashley Phosphate/I-26 corridor". The sweep found no other
firm experience count (the remaining hits are generic advice or a manufacturer's settlements).

## Mechanics

Per-post prod backup (`prod-backup-before.json`, identical to the dumped state), `bin/freshness-build-patch.mjs --apply`
(17 edits, 0 violations), post_modified stamped 2026-10-06, both cache layers flushed, DB readback (`readback.json`)
matches every run file. Live in Chrome: all 15 return 200; no absolute-expense or "dozens" wording in rendered text or
JSON-LD; new wording present; JSON-LD parses; FAQ counts unchanged. `bin/check-unslashed-post-writes.php` PASS (static
and live). `content/meta.json` regenerated.
