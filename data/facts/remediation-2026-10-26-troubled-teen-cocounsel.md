# Applied: page 4574, Troubled Teen Industry Abuse, co-counsel wording (2026-10-26)

**Ruling:** Graeham C. Gillin (SC), by text to the owner, 2026-10-26, answering packet Q1/Q2
(`sc-signoff-packet-2026-10-21.md`). Q1: Roden co-counsels these cases on paper, which is what lets
it take a fee, but other firms handle them. Q2: he picked **option B**: add the co-counsel line
and drop "history of proven results" and "decades" from this page only, keeping "experienced" for
the firm. Owner, 2026-10-26: "he picked B, apply it".

**Script:** `bin/apply-troubled-teen-cocounsel-wording.php` (exact-match guards, `wp_slash`, read-back OK).
**Backups:** `docs/backups/4574-post-content-2026-10-26.html`, `docs/backups/4574-faqs-2026-10-26.json`
(the `post_content` write also left a WordPress revision).

## Changes

| Surface | Before | After |
|---|---|---|
| `post_content`, "Legal options" section | At Roden Law, we have been fighting for injured victims for decades. We have a knowledgeable team of experienced and compassionate attorneys who are prepared to manage your case with the tenacity it deserves. | At Roden Law, we fight for injured victims. We have a knowledgeable team of experienced and compassionate attorneys. Roden Law works with co-counsel firms that focus on institutional abuse cases nationwide. Our firm stays involved as co-counsel on your case. |
| `post_content`, last section | Our firm has decades of experience advocating for the injured and a history of proven results. | Our firm is committed to advocating for the injured. |
| `_roden_faqs[5]` (FAQ 6) + FAQPage JSON-LD | Yes. Roden Law is licensed in Georgia and South Carolina and has decades of experience advocating for injured and abused victims. | Yes. Roden Law is licensed in Georgia and South Carolina and advocates for injured and abused victims. Roden Law works with co-counsel firms that focus on institutional abuse cases nationwide. Our firm stays involved as co-counsel on your case. |

The "prepared to manage your case" clause was dropped with "decades" because it says Roden handles
the case, which the new co-counsel sentence corrects.

## Verification

- Live page (HTTP 200, after `wp cache flush` + `wp page-cache flush`): co-counsel sentence ×3 (body,
  FAQ 6, FAQPage JSON-LD); "decades" ×0; "proven results" ×0.
- `bin/check-unslashed-post-writes.php` against live: PASS.
- `content/meta.json` regenerated; the only diff is FAQ 6.
- `sweep-claims.mjs --client roden --fresh`: 0 errors (10-24: 1), 102 warnings (unchanged), none on 4574.
  Report: `data/facts/sweep-2026-10-26.json`.

## Closes / still open (10-21 plan)

- **F6(a)** "history of proven results": removed. **F6(c)** "decades" for the firm: removed on this page
  (the ruling is for this page only; "decades" elsewhere on the site was not swept or changed).
- **F6(b)** "knowledgeable"/"experienced": kept, per the ruling.
- **F4** FAQ 6 forum caveat: Q1 is answered and the co-counsel line now explains who handles out-of-state
  cases; the interstate-forum sentence in the 10-21 plan was not applied (not part of B).
- **F6(d)** costs language on the five no-fee lines: **closed, no change.** Gillin, via the owner, 2026-10-26: "there are no needs to address costs." The no-fee lines stay as published.
- **F5** "class action attorney" framing: unchanged, still open.
- Remaining wording that says Roden handles the case: FAQ 4 ("prepared to handle your case") and
  FAQ 6 ("We handle every case with sensitivity…"). Left as published ("keep the rest as is"); flag
  to Gillin if he wants them consistent with the co-counsel line.
- SC rows § 15-3-555 and § 15-3-40 (packet rows 1–2): still unsigned.
