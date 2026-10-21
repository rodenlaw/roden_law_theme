# Remediation plan: page 4574, Troubled Teen Industry Abuse (2026-10-21)

**Page:** https://rodenlaw.com/class-action-lawyers/troubled-teen-industry-abuse/ (type `page`, id 4574, 931 words, last modified 2024-05-10)
**Owner decision (2026-10-21):** this page stays in the migration. Every other mass-tort page is retired. **Do not pull the FAQs from the live page now.** Nothing in this plan has been applied, and no production edits were made.
**Ledger:** `data/seo/ledger.json` lists the page as `free` (last change 2024-05-10, `doNotTouchBefore` 2024-08-08), so it is outside any 90-day window. Each fix below still replaces only the sentence at fault.

## Inputs

- Sweep: `data/facts/sweep-2026-10-21.json`, run with `sweep-claims.mjs --client roden --fresh --json --warnings` against `data/content-cache/wp-export.json` (exported 2026-10-21T15:51Z). It reported 0 findings because no pack rule covered this claim class.
- Re-sweep with the pack branch from internal-ai-scripts PR #93 (`law/abuse-survivor-limitations`) against the same export: **1 error**, on this page (`faqs[4]`, rule `abuse-sol-extension-overbroad`). Nothing else sitewide. Warnings unchanged (113, same set).
- Manual class sweep across all 699 exported documents, every string meta key, EN and ES. I searched for abuse, neglect or mistreatment near deadline, limitation, extended or more-time language, and for the Spanish equivalents (abuso, maltrato, negligencia near plazo or prescripción). The only hit for this class is page 4574. The ES pages hold nursing-home deadline FAQs with the ordinary periods, and those are correct. Page 4574 has no Spanish twin.
- Live render, fetched 2026-10-21 (HTTP 200). The body and the six FAQs match the export word for word. The FAQPage JSON-LD (`#faqs`) carries the same six answers verbatim, so every FAQ fix below also fixes the structured data.

## Pack state (both packs have new entries awaiting sign-off)

| Authority | Pack | State |
|---|---|---|
| GA 9-3-33 (ordinary 2-year PI period) | GA | signed |
| SC 15-3-530 (ordinary 3-year PI period) | SC | signed (Gillin) |
| **GA 9-3-33.1** (childhood sexual abuse) | GA `pendingAuthorities` | **UNSIGNED.** Added in PR #93. I read the 2024 edition, history through 2019 Ga. Laws 30. The 2025 edition (2026 session) was bot-blocked today, so the currency read is still owed. |
| **GA 9-3-90** (minority tolling) | GA `pendingAuthorities` | **UNSIGNED.** Added in PR #93. Same currency caveat. |
| **SC 15-3-555** (sexual abuse or incest) | SC `pendingAuthorities` | **UNSIGNED.** Added in PR #93. Official code, 2001 Act No. 102, never amended. S. 148 and H. 5203 (2025-26) are still in committee. |
| **SC 15-3-40** (minority tolling) | SC `pendingAuthorities` | **UNSIGNED.** Added in PR #93. Official code. |

An unsigned authority cannot back a NEW claim. Each legal fix therefore comes in two versions. The **interim** version cites only signed authorities and can ship now. The **post-sign-off** version names the abuse statutes and ships only after the GA pack sign-off and Gillin (SC) sign the four entries above. Roden's page-wording review stays with Tyler Love (GA) and Gillin (SC).

## Where the claims live (claim class, not string)

| Surface | Present? | Carries a legal claim? |
|---|---|---|
| `post_content` | yes | yes. Limitation sentence, statistic, class-action framing, advertising language |
| `_roden_faqs` (6), which also renders as FAQPage schema | yes | yes. FAQ 5 (limitations), FAQ 6 (licensure and forum), FAQ 3 and FAQ 6 (fees) |
| `_roden_key_takeaways` | empty (export and live: no summary box rendered) | nothing |
| `post_excerpt` | empty | nothing. The Article/LegalService `description` and the meta description fall back to the body's first sentence ("Some teens lose their way…"), which carries no claim. |
| Other meta in `content/meta.json` | only `_roden_faqs` | none. No jurisdiction, SOL fields, author or lastReviewed are set. |
| Theme blocks on the rendered page | header "No Fees Unless We Win"; footer "$300M+ recovered…", disclaimer "Fees and costs apply only upon successful recovery. No fees or costs with no recovery." | sitewide theme text, outside this plan, except where it bears on F6(d) |

---

## F1. FAQ 5 says the abuse-survivor limitation rules "often extend the window" (ERROR)

- **URL / surface:** /class-action-lawyers/troubled-teen-industry-abuse/, `_roden_faqs[4]` (FAQ 5) **and** the FAQPage JSON-LD.
- **Rule that caught it:** `abuse-sol-extension-overbroad` (GA pack, PR #93). The current pack missed it (0 findings).
- **Why it is wrong:** In both states the extended limitation periods cover **sexual abuse only**. That is O.C.G.A. § 9-3-33.1 in Georgia ("childhood sexual abuse", the listed sexual offenses, victim under 18) and S.C. Code § 15-3-555 in South Carolina (sexual abuse or incest). This page lists physical abuse, starvation, isolation, neglect, chemical restraints and hard labor. Those claims run on the ordinary periods (§ 9-3-33, two years; § 15-3-530, three years), tolled for minority. A troubled-teen survivor now in their twenties or thirties is likely already outside them. The FAQ answer also contradicts the body ("In many cases, the statute of limitations may have expired or be close to expiring"). The body is the accurate one.
- **As published (exact stored string, `_roden_faqs[4].answer`):**
  > `It may not be too late. <strong>Statute-of-limitations rules for abuse survivors often extend the window to come forward</strong>, and these rules vary by state and circumstances.`
- **Corrected, interim (ship now; signed authorities only):**
  > `It may not be too late, but some claims may already have expired. <strong>Filing deadlines depend on the kind of claim and the state where it is filed</strong>, and they are strict.`
  - **Authority:** GA 9-3-33, SC 15-3-530 (signed). The sentence states only that deadlines differ by claim and state.
- **Corrected, after sign-off (replaces the same stored string):**
  > `It may not be too late, but it depends on what happened. <strong>Georgia and South Carolina allow longer filing periods only for claims based on sexual abuse</strong>: in Georgia, a claim for childhood sexual abuse can generally be filed until the survivor turns 23, or within two years after the survivor knew or had reason to know of the abuse and the injury it caused (O.C.G.A. § 9-3-33.1); in South Carolina, a claim for sexual abuse can be filed within six years after the survivor turns 21, or within three years after discovering the injury and its connection to the abuse, whichever is later (S.C. Code § 15-3-555). Claims for physical abuse, neglect and other mistreatment generally follow the ordinary personal-injury deadlines of two years in Georgia (O.C.G.A. § 9-3-33) and three years in South Carolina (S.C. Code § 15-3-530). For a survivor who was under 18, Georgia starts that clock at 18 (O.C.G.A. § 9-3-90), and South Carolina's tolling for minors cannot extend the deadline past one year after the survivor turns 18 (S.C. Code § 15-3-40).`
  - **Authority:** GA 9-3-33.1, SC 15-3-555, GA 9-3-90, SC 15-3-40 (all pending, UNSIGNED); GA 9-3-33 and SC 15-3-530 (signed).
- The rest of the answer ("Because timelines can be complicated, … still be available to you.") is unchanged.
- **Both versions replay clean** against the new rules: fixtures `ctrl-tti-faq5-interim` and `ctrl-tti-faq5-signed` in `law/fixtures/roden-abuse-sol-2026-10-21.json`.
- **For the attorney (GA):** § 9-3-33.1(c) adds proof limits against an **entity**. On the age-23 route, damages need a finding of negligence. On the discovery route, they need gross negligence and proof that the entity knew or should have known and took no remedial action. This page's claims are mostly against facilities. Tyler Love should decide whether FAQ 5 or FAQ 6 should mention it. I have not drafted it in.
- **Apply path (when the owner says go):** `bin/apply-faq-remediation.php` pattern, with an exact-match `str_replace` on the stored answer and `update_post_meta(... wp_slash(...))`. Set `_roden_content_modified`. Re-read the meta and the live JSON-LD afterwards. The owner's instruction not to pull the FAQs is respected: this edits one sentence of an answer and removes no FAQ.

## F2. Body limitation sentence contradicts FAQ 5 (resolved by F1; optional follow-up)

- **Surface:** `post_content`, section "Can Victims Abused in the Troubled Teen Industry Seek Compensation for Their Damages?"
- **Rule:** none. This is a cross-surface contradiction found on manual read. The sentence alone does not trip any rule and is not wrong.
- **As published:**
  > `In many cases, the <a href="https://rodenlaw.com/blog/georgia-statute-of-limitations/" rel="">statute of limitations</a> may have expired or be close to expiring.`
- **Interim:** **no change.** The sentence is hedged and accurate. Fixing F1 removes the contradiction.
- **Optional, after sign-off** (makes the body say why):
  > `In many cases, the <a href="https://rodenlaw.com/blog/georgia-statute-of-limitations/" rel="">statute of limitations</a> may have expired or be close to expiring, especially for claims based on physical abuse or neglect, which generally follow the ordinary personal-injury deadlines; Georgia and South Carolina allow longer filing periods only for claims based on sexual abuse.`
  - **Authority:** GA 9-3-33, SC 15-3-530 (signed); GA 9-3-33.1, SC 15-3-555 (pending, UNSIGNED). Fixture `ctrl-tti-body-signed` replays clean.
- **Owner note:** the link points to the **Georgia** limitations post on a page that serves both states. I left it alone, because pointing it elsewhere is a link change, not a legal fix. /resources/georgia-statute-of-limitations/ and /resources/south-carolina-statute-of-limitations/ both exist if the owner wants two links.

## F3. Unsourced, apparently inverted eating-disorder statistic (HIGH)

- **Surface:** `post_content`, "What Are the Long-Term Effects…" list.
- **Rule:** none. This is a statistic, not law. It is not in `data/statistics.json`.
- **As published:**
  > `<li><strong>Eating disorders:</strong> According to Psychology Today, an astonishing 30 to 65 percent of victims who suffered sexual abuse as a child or young teen suffer from anorexia.</li>`
- **Why it is wrong:** No source is linked, and I could not find or verify the figure today (search engines throttled the queries). Figures of this size in the literature describe the share of **people with eating disorders** who report a history of sexual abuse. They do not describe the share of abuse survivors who develop **anorexia**. Lifetime anorexia prevalence in population studies is on the order of 1% (National Comorbidity Survey Replication; I did not re-read it today). A claim that 30 to 65% of child sexual-abuse survivors develop anorexia is implausible by more than an order of magnitude. The page cites a magazine, not a study. Cut the figure and the attribution.
- **Corrected:**
  > `<li><strong>Eating disorders:</strong> Research has linked childhood sexual abuse to a higher risk of eating disorders later in life.</li>`
  - **Authority:** none needed. The sentence states no figure. Restoring a figure would require a primary study entered in `data/statistics.json` first.

## F4. FAQ 6 answers "Yes" with no forum or licensure caveat (MEDIUM)

- **Surface:** `_roden_faqs[5]` (FAQ 6) and its FAQPage JSON-LD.
- **Rule:** none (manual).
- **Why:** Troubled-teen programs are concentrated outside Georgia and South Carolina. Where a claim can be filed (personal jurisdiction and venue) and whose limitation period applies depend on where the abuse happened and where the defendants can be sued. Roden is licensed only in GA and SC (the site footer says so). An unqualified "Yes" promises representation in a case that may have to be filed in another state.
- **As published:**
  > `Yes. Roden Law is licensed in Georgia and South Carolina and has decades of experience advocating for injured and abused victims. Claims may proceed against the <strong>facilities and operators</strong> responsible for the abuse.`
- **Corrected:**
  > `Roden Law is licensed in Georgia and South Carolina and has decades of experience advocating for injured and abused victims. We can review a claim for a survivor in either state, but many of these programs operated in other states, and where a claim can be filed, and which state's deadlines apply, depends on where the abuse happened and where the facility and its operators can be sued. Claims may proceed against the <strong>facilities and operators</strong> responsible for the abuse.`
  - **Authority:** none in either pack for interstate forum or choice of limitations law. SC 15-7-30 covers only venue inside SC. **The attorney has to approve the sentence.** "Decades of experience" is left as published for the F6 ruling. Fixture `ctrl-tti-faq6` replays clean.
- **For the attorney (do not decide here):** (a) whether Roden refers out, co-counsels, or seeks pro hac vice on out-of-state facility cases; if it does, the FAQ could say so. (b) Whether a South Carolina borrowing statute or Georgia's lex-fori treatment of limitations should be mentioned. Neither is in the pack, and I have not verified either.

## F5. "Class action attorney" framing for individual claims (MEDIUM)

- **Surface:** `post_content`, opening CTA paragraph.
- **Rule:** none (manual).
- **Why:** The page describes individual injury claims ("you may be eligible to recover compensation"). It offers no class, names no class action, and gives no class representative. "Class action attorney" tells a survivor their claim will be pooled. The mass-tort pages that gave the term context have been retired.
- **As published:**
  > `Call Roden Law to discuss your situation with a compassionate, knowledgeable and experienced <a href="https://rodenlaw.com/class-action-lawyers/" rel="">class action attorney</a>.`
- **Corrected (recommended; the link to the retired-mass-tort hub is dropped):**
  > `Call Roden Law to discuss your situation with a compassionate, knowledgeable and experienced attorney.`
- **Alternative, if the owner wants to keep the link:** `… experienced <a href="https://rodenlaw.com/class-action-lawyers/" rel="">attorney</a>.`
- **Authority:** none (framing). "Knowledgeable and experienced" is left as published for F6(b).
- **Owner, structural, not in this plan:** the URL `/class-action-lawyers/…`, the breadcrumb and the "Class Actions" nav item all keep the framing. Changing them is a migration or redirect decision.

## F6. Advertising-rule items for attorney review: Tyler Love (GA), Gillin (SC). NOT decided here.

I flag these under Georgia Rule 7.1 and South Carolina Rules 7.1 and 7.2. I have not re-read the rule text for this plan, and the attorney should name the subsections. No wording changes are proposed until the attorney rules.

| # | Phrase (surface) | Question for the attorney |
|---|---|---|
| (a) | "Our firm has decades of experience advocating for the injured and a history of proven results." (body, last section) | Is "history of proven results" a results claim that needs the past-results disclaimer next to it, or should it go? The disclaimer is in the footer. |
| (b) | "compassionate, knowledgeable and experienced … attorney" (body CTA); "knowledgeable team of experienced and compassionate attorneys" (body); "compassionate and knowledgeable attorney" (body); "experienced attorney at our firm" (body CTA); "experienced, compassionate attorney" (FAQ 3) | Are "knowledgeable" and "experienced" acceptable descriptive terms, or comparative/unverifiable? The SC footer already disclaims "expert" under Rule 7.4(b). |
| (c) | "we have been fighting for injured victims for decades" (body); "decades of experience" (body, FAQ 6) | Is "decades" supportable for **the firm**? The profile's figure is "62 years combined experience" (attorneys), which is not the firm's age. |
| (d) | "If you have a case and we represent you, there are no upfront costs or fees to pay. We only get paid if you do." (body); "there are no upfront costs or fees to pay" (body, last section); "FREE case review. No Upfront costs." (body CTA); "there are no upfront costs or fees — we only get paid if you do" (FAQ 3); "there are no upfront fees" (FAQ 6) | These say nothing about whether the client owes case costs if there is no recovery. The firm's stated policy elsewhere is no fees or costs without a recovery (footer: "Fees and costs apply only upon successful recovery. No fees or costs with no recovery."; /blog/contingency-fee-system/). Does the contingent-fee statement on this page need the costs language inline? A possible wording, **for the attorney to approve or reject**: "If we represent you, there are no upfront costs, and you owe no fees or costs unless we recover compensation for you." |

## F7. Checked, no change

- **FAQ 1 / body:** "It may be possible to seek compensation against the institutions and/or individuals…" is hedged. It is accurate, but see the § 9-3-33.1(c) entity-proof note under F1.
- **FAQ 2, FAQ 4, the allegations list, the PTSD and substance-abuse bullets:** no legal claim beyond hedged eligibility language.
- **The body statement that government agencies placed teens in these programs:** the page makes no claim about suing those agencies. If it ever does, the ante-litem and Tort Claims Act deadlines apply (GA 50-21-26 / 36-11-1 / 36-33-5; SC 15-78-110).

---

## Counts by rule

| Rule / source | Findings | Severity |
|---|---|---|
| `abuse-sol-extension-overbroad` (GA pack, PR #93) | 1 (F1, FAQ 5 + schema) | error |
| manual: cross-surface contradiction | 1 (F2, resolved by F1) | low |
| manual: unsourced statistic | 1 (F3) | high |
| manual: forum / licensure | 1 (F4) | medium |
| manual: class-action framing | 1 (F5) | medium |
| attorney review (Rules 7.1 / 7.2) | 4 groups, 14 phrases (F6) | attorney |
| `physical-abuse-extended-sol`, `sc-abuse-sol-extension-overbroad`, `sc-physical-abuse-extended-sol` | 0 sitewide | — |

## False positives

None. The one rule hit (F1) is a true error. The new rules raised nothing else on 699 documents, and the controls for the two live nursing-home FAQs that discuss abuse and deadlines (posts 3619, 4163) replay clean.

## Unrelated finding from the class sweep (outside this page; next batch)

- /blog/nursing-home-abuse-charleston-signs-families/ (post 4348), `_roden_faqs[3]`, says "…three years from the date of injury or discovery (S.C. Code section 15-3-530). For wrongful death claims, the deadline is three years from the date of death (S.C. Code section 15-51-20)." Two problems. The discovery rule is § 15-3-535, not § 15-3-530. And § 15-51-20 governs who brings the wrongful-death action, not its deadline. The current sweep does not catch either. This needs its own entry and Gillin's review.

## Before any publish

Re-run `sweep-claims.mjs --client roden --fresh` with the PR #93 packs. Block on any error-level finding. Read FAQ 5 and FAQ 6 back from `_roden_faqs` **and** from the live FAQPage JSON-LD, then run `bin/check-unslashed-post-writes.php` against the live site.
