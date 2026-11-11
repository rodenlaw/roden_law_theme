# Legal-accuracy review: the two retired Spanish office hubs (2026-11-11)

**Scope.** Two posts are reviewed here. Both are `draft`, location CPT, and marked `_roden_retired: 2026-09-26 dead-es-hubs`.

- **4869** `es-darien` (`/es/locations/georgia/darien/`). English twin: **3598** `/locations/georgia/darien/`.
- **4883** `es-north-charleston` (`/es/locations/south-carolina/north-charleston/`). English twin: **3763** `/locations/south-carolina/north-charleston/`, the neighbourhood-template hub.

The owner asked for this review before deciding whether to republish them. It was read-only: prod was read with `wp eval-file`, and nothing was written, published or re-statused.

**Method.** I read by hand every surface of each post:

- title and excerpt
- `post_content`
- `_roden_meta_description`
- `_roden_service_area`
- `_roden_local_content`
- `_roden_faqs` (these feed the FAQPage JSON-LD, so they were checked as published text)
- the template blocks that `templates/template-location.php` renders around them

I checked them against `internal-ai-scripts/law/GA.json` and `SC.json`, both at `34400e5`, and against `law-signoff.json`. The sweep could not do this. Draft posts are not in its export, and its pattern rules are English-only. Two of the findings below also sit on the **live English twins**, and the 2026-11-10 sweep reported 0 findings on both pages.

**Sign-off status:**

| State | Signer for Roden | Status |
|---|---|---|
| SC | Graeham C. Gillin | **Signed.** Counts for Roden. |
| GA | Tyler Love (owner decision D6) | **UNSIGNED for Roden.** See `law-signoff.json`. The packet `ga-signoff-packet-2026-10-21.md` is still open. Until Love signs, no new Roden GA claim may cite the pack, and every GA claim on 4869 is advisory. |

---

## Publishing either page is more than a content decision

Both pages were retired on the owner's instruction of 2026-09-26: "retire (but don't delete) those two spanish pages". Each had 0 clicks in 16 months. To republish either page, all of the following must happen. These are not legal items, but they block publication whatever the content says.

1. **Redirects.** Remove both URLs from `roden_dead_es_hub_urls()` in `inc/legacy-redirects.php` (lines 2512–2513, PR #160). Until then, a published post still 301s to the English hub, and the Spanish page is unreachable.
2. **Retired marker.** Delete the `_roden_retired` meta and re-run the 09-26 relink in reverse: 4 links on 4862 and 4864. `docs/backups/dead-es-hub-relink-2026-09-26.json` is the record.
3. **Doorway ratio.** Two geo pages come back. On 09-26 the ratio was 155 / 669 = 23.17%. Re-check the doorway ratio before publishing.
4. **Review date.** `_roden_last_reviewed` reads **2026-08-03** on both pages. That date predates this review and any attorney review of the corrections. Don't re-stamp it until the attorney items below are answered.

---

## 4869 `es-darien` (Georgia)

**Verdict: NEEDS ATTORNEY (Love), then publishable after the listed fixes.** Every statement of Georgia law on the page is correct as written. Each one rests on GA authority that is **unsigned for Roden**: A1 `GA 9-3-33` and A3 `GA 51-12-33` in Love's open packet. Under `law-signoff.json` the page cannot publish those claims until Love signs. The immigration-status claim has no pack authority at all.

### D1. Statute of limitations: correct, but unsigned for Roden (blocks publish)

- **Surfaces:** body ¶4 and FAQ[2], which is also FAQPage JSON-LD.
- **As published (body):** "No espere: en Georgia, por lo general usted tiene **2 años** desde la fecha del accidente para presentar su demanda (O.C.G.A. § 9-3-33)."
- **As published (FAQ[2]):** "En general, 2 años desde la fecha del accidente (O.C.G.A. § 9-3-33)."
- **Correction:** none. The text matches the authority, and the English twin's FAQ[3] says the same.
- **Authority:** `GA 9-3-33` (packet A1). **UNSIGNED for Roden.**
- **Rule:** sign-off (`law-signoff.json`, GA unsigned).

### D2. Comparative fault: correct, but unsigned for Roden (blocks publish)

- **Surface:** FAQ[6].
- **As published:** "Usted puede recuperar una compensación siempre que su responsabilidad en el accidente sea menor al 50% … Si su culpa llega al 50% o más, no recupera nada."
- **Correction:** none. This is a faithful translation of the English twin's FAQ[4].
- **Authority:** `GA 51-12-33` (packet A3). **UNSIGNED for Roden.**
- **Rule:** sign-off.

### D3. Immigration status: no authority in either pack (needs Love)

**Surfaces and text as published:**

- **Body ¶3:** "…y su estatus migratorio no le impide reclamar una compensación: su consulta es siempre confidencial."
- **FAQ[1]:** "Sí. Su estatus migratorio no le impide reclamar una compensación por lesiones en Georgia. Su información se mantiene confidencial durante todo el proceso."

**Problems:**

- The English twin makes neither claim.
- No pack carries an authority for it, so under rule 4 the claim cannot be backed.
- "Durante todo el proceso" overpromises. Once lost wages are claimed, a plaintiff's immigration status can become a discovery question in litigation. Privilege covers communications with the lawyer, not every fact in the case.
- The live Savannah hub (`/es/locations/georgia/savannah/`) already uses a narrower confidentiality line.

**Interim correction (no legal claim, publishable before Love answers):**

- **Body ¶3:** "…y atendemos a todas las personas sin importar su estatus migratorio: su consulta es siempre confidencial."
- **FAQ[1]:** "Sí, puede consultarnos. Atendemos a todas las personas sin importar su estatus migratorio, y lo que nos cuente está protegido por el secreto profesional entre abogado y cliente."

**After Love confirms the law:** the Savannah wording, "Sí. Su estatus migratorio no le impide presentar un reclamo por lesiones personales en Georgia. Todo lo que nos cuente es confidencial y está protegido por el secreto profesional entre abogado y cliente.", together with a new pending authority.

**Candidate authority** (not verified in this pass; it needs a primary-text read before it enters `pendingAuthorities`): *Continental PET Technologies, Inc. v. Palacias*, 269 Ga. App. 561 (2004), on whether undocumented workers are covered by workers' compensation. Georgia has no statute that bars a tort claim on immigration status.

- **Authority:** none in the pack.
- **Rule:** rule 4 (no authority), plus parity with the English twin.

### D4. "Especialmente preparada" over-translates the English (minor)

- **Surface:** FAQ[4].
- **As published:** "…la oficina de Darien está especialmente preparada para atender lesiones marítimas y accidentes de bote en el área de las Golden Isles."
- **English twin:** "especially well-positioned to serve…", which is a claim about geography, not competence.
- **Why it matters:** "especialmente preparada" reads as a competence or specialization claim (Georgia RPC 7.1, and 7.4 on specialization).
- **Correction:** "…la oficina de Darien está bien ubicada para atender lesiones marítimas y accidentes de bote en el área de las Golden Isles."
- **Authority:** n/a (parity).
- **Rule:** parity; ethics wording.

### D5. Results claim added in Spanish (Love, Rule 7.1; non-blocking)

- **Surface:** body ¶3.
- **As published:** "Con más de $300 millones recuperados para nuestros clientes, sabemos cómo hacer que las aseguradoras respondan."
- **Problem:** "sabemos cómo hacer que las aseguradoras respondan" appears only in the Spanish. It reads as a promise of outcome.
- **Correction:** "Hemos recuperado más de $300 millones para nuestros clientes."
- The $300M figure matches firm data (`recovered`) and the English twin's FAQ[7]. FAQ[7] in Spanish is a faithful translation and needs no change.
- **Rule:** ethics (results and expectations).

### D6. Fee wording (shared open item, Love; non-blocking)

- **Surface:** FAQ[0], and the same line in the excerpt and meta description.
- **As published:** "No paga nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos un porcentaje si ganamos su caso."
- **English twin FAQ[5]** goes further: "no out-of-pocket costs… zero financial risk".
- The Spanish is the safer of the two and matches the live Spanish office hubs, but it is silent on costs. That is the open Rule 7.1 / 7.2 "no-fee lines silent on costs" question already before the attorneys. No change until it is answered.

### Checked and clean on 4869

- **Contact details:** the address (1108 North Way, Darien, GA 31305), phone ((912) 303-5850, the same line as the English twin and firm data), service area and community list all match `inc/firm-data.php` and the English twin.
- **Author:** Eric Roden, who is GA-licensed (same as the English twin).
- **Statistics:** no crash statistics on the page, so there was nothing to check against `data/statistics.json`.
- **Local content:** "Los casos … se presentan generalmente ante el McIntosh County Superior Court" matches the English FAQ[7] framing. Venue actually turns on the defendant, but "generalmente" covers that.
- **Results disclaimer:** the case-results grid renders the Spanish disclaimer (`es_ES.po` msgid "Results shown are gross…").
- **Parity:** the Spanish FAQs leave out the English twin's FAQ[3] workers' comp and med-mal deadlines. That omission is correct, because the English sentence is wrong (see E1).

---

## 4883 `es-north-charleston` (South Carolina)

**Verdict: PUBLISHABLE AFTER THE LISTED FIXES** (N1 and N2, both resting on signed SC authority), with the immigration-status line handled per N3. N3 has an interim wording that needs no attorney; the fuller claim needs Gillin.

### N1. ERROR: SC government claims described as "notice deadlines"

- **Surface:** FAQ[2], also FAQPage JSON-LD.
- **As published:** "En casos contra entidades del gobierno los plazos de notificación son más cortos, así que no espere para llamar."
- **Problem:** this is the `sctca-mandatory-notice` / `sctca-shorter-notice-hedge` class. The SC Tort Claims Act imposes **no** pre-suit notice. The verified claim under § 15-78-80 is optional and **lengthens** the period. What is shorter is the limitation period: two years under § 15-78-110.
- The sweep cannot catch this, because the sentence is in Spanish.
- The English twin carries the same error (see E2). The live Myrtle Beach, Charleston and Columbia Spanish hubs say "plazos" (deadlines), not "plazos de notificación", and are correct.
- **Correction:** "En general, 3 años desde la fecha del accidente (S.C. Code § 15-3-530). Los reclamos contra entidades del gobierno tienen un plazo más corto, por lo general 2 años (S.C. Code § 15-78-110), así que no espere para llamar."
- **Authority:** `SC 15-78-110` (signed, Gillin). The first sentence rests on `SC 15-3-530` (signed).
- **Rule:** `sctca-mandatory-notice` (error class); the engine is blind to Spanish.

### N2. Comparative fault stated as "less than 51%" (house wording)

- **Surface:** FAQ[5].
- **As published:** "Si usted tiene menos del 51% de la culpa del accidente, todavía puede recibir una compensación … Si su culpa es del 51% o más, no recupera nada."
- **Problem:** *Nelson* bars a plaintiff who is **more than 50%** at fault. "Menos del 51%" and "51% o más" leave fractional fault between 50 and 51 on the wrong side. The house wording since 2026-09-29 is "50% or less (Nelson)". The English twin carries the same phrasing (see E3).
- **Correction:** "Si su culpa en el accidente es del 50% o menos, todavía puede recibir una compensación, pero el monto se reduce según su porcentaje de culpa: por ejemplo, una indemnización de $100,000 reducida en un 20% por culpa parcial paga $80,000. Si su culpa es de más del 50%, no recupera nada."
- **Authority:** `Nelson v. Concrete Supply Co.` (signed, Gillin).
- **Rule:** house wording for the SC bar.

### N3. Immigration status, including workers' comp (needs Gillin)

**Surfaces and text as published:**

- **Body ¶3:** "…y su estatus migratorio no le impide reclamar una compensación por sus lesiones — su consulta es siempre confidencial."
- **FAQ[1]:** "Sí. Su estatus migratorio no le impide reclamar una compensación por un accidente o una lesión en el trabajo en Carolina del Sur. Su información se mantiene confidencial."

**Problems:**

- No pack authority supports the claim.
- FAQ[1] also makes a workers' compensation eligibility claim ("una lesión en el trabajo").
- The English twin makes neither claim.
- The live Myrtle Beach Spanish hub carries the identical FAQ.

**Interim correction (no legal claim):**

- **Body ¶3:** "…y atendemos a todas las personas sin importar su estatus migratorio: su consulta es siempre confidencial."
- **FAQ[1]:** "Sí, puede consultarnos. Atendemos a todas las personas sin importar su estatus migratorio, y lo que nos cuente es confidencial."

**After Gillin confirms the law:** keep the current FAQ[1] text with a new pending authority.

**Candidate authorities** (not verified in this pass, because the primary-text fetch was not available): S.C. Code § 42-1-130 (the definition of "employee" includes aliens), and *Curiel v. Environmental Management Services*, S.C. Supreme Court (2007), on whether undocumented workers are covered.

- **Rule:** rule 4 (no authority), plus parity.

### N4. "En la zona de Park Circle": location claim not in the English or firm data

- **Surface:** `_roden_local_content` ¶2.
- **As published:** "Nuestra oficina está en Spruill Avenue, en la zona de Park Circle, con estacionamiento gratuito para clientes."
- **Problem:** neither the firm data nor the English twin places the office in Park Circle. The firm-data coordinates (32.8473, −79.9612) sit roughly 3 km south of the Park Circle roundabout.
- **Correction:** "Nuestra oficina está en 2703 Spruill Avenue, con estacionamiento gratuito para clientes."
- **Rule:** factual parity (contact and location details).

### N5. Results line not on the English twin (Gillin, Rule 7.1; non-blocking)

- **Surface:** body ¶3.
- **As published:** "Nuestro bufete ha recuperado más de $300 millones para sus clientes."
- The figure matches firm data and the template hero, but it is not on 3763. It is acceptable as firm-wide data. This is listed for Gillin's 7.1 review together with D5, and no change is proposed.

### Checked and clean on 4883

- **Statute of limitations:** "**3 años** … (S.C. Code § 15-3-530)" in body ¶4 and FAQ[2] matches `SC 15-3-530` (signed).
- **Fees:** FAQ[0] matches the live Spanish hubs. The cost-silence item is the same as D6.
- **Contact details:** address (2703 Spruill Ave, North Charleston, SC 29405), phone (843) 612-6561, court (Charleston County Circuit Court) and service area all match firm data and the English twin's FAQs.
- **Author:** Graeham C. Gillin (SC-licensed; same as the English twin).
- **Statistics:** no statistics on the page. "una de las zonas con más tráfico industrial y de camiones de todo el estado" is a qualitative paraphrase of the English "some of the highest traffic volumes in the state".
- **Pack rules:** no bicycle § 56-5-3435, BUI or boating claims.

---

## Live English errors found while reading the twins (not drafts; the engine misses all three)

These pages are published and outside their 90-day window (`data/seo/ledger.json`: 3598 has been free since 2026-05-25, 3763 since 2026-05-31). Each fix replaces one sentence. Owner approval is needed before any script is applied; the script is in a separate PR.

### E1. 3598 FAQ[3]: Georgia med-mal "discovery rule" (error)

- **As published:** "Medical malpractice cases follow a discovery rule but have a 5-year outer limit."
- **Problem:** this is the `ga-medmal-discovery-rule` class. § 9-3-71(a) runs from the date of injury, and Georgia has no general discovery rule. The rule's regex needs "9-3-71" or "injury or discovery", so this phrasing slips past it.
- **Interim (removes the false claim, adds no new GA claim):** "Medical malpractice cases have their own, different deadlines."
- **After Love signs A15:** "Medical malpractice claims generally must be filed within 2 years of the injury, with a 5-year outer limit (O.C.G.A. § 9-3-71)."
- **Authority:** `GA 9-3-71` (packet A15, **unsigned for Roden**).

### E2. 3763 FAQ[2]: SC government claims as "notice periods" (error)

- **As published:** "Shorter notice periods apply if a government entity is involved (a city, county, or state agency)."
- **Problem:** same class as N1. `sctca-shorter-notice-hedge` needs a modal ("may apply") plus "deadlines/requirements/rules", so "notice periods apply" escapes it.
- **Correction:** "A claim against a government entity (a city, county, or state agency) has a shorter deadline, generally two years under the South Carolina Tort Claims Act (S.C. Code § 15-78-110)."
- **Authority:** `SC 15-78-110` (signed).

### E3. 3763 FAQ[3]: "less than 51%" (house wording)

- **As published:** "If you are less than 51% at fault for the accident, you can still recover compensation, but…" and "If you are 51% or more at fault, you recover nothing."
- **Correction:** "If you are 50% or less at fault for the accident, you can still recover compensation, but…" and "If you are more than 50% at fault, you recover nothing."
- **Authority:** `Nelson v. Concrete Supply Co.` (signed).

### E4. 3763 body: wrong office phone (not legal; same fix script)

- **As published:** "Contact us at (843) 790-8999 for a free case review."
- **Problem:** (843) 790-8999 is the **Charleston** office line. The North Charleston office is (843) 612-6561 (firm data; the twin's own FAQs).
- **Correction:** "Contact us at (843) 612-6561 for a free case review."

### Template-level item for the owner (not in either draft's text)

`inc/firm-data.php` `jurisdiction.SC.comp_fault_rule` = "Modified — recover if less than 51% at fault". This renders in the "South Carolina Personal Injury Law" box of `templates/template-location.php` on every SC office hub, including 4883 if it is published. It is the same class as N2 and E3, and `es_ES.po` already carries a "50% or less" msgid for it. The house wording would be "Modified — recover if 50% or less at fault". This is a theme PR, and the msgid change needs the `.po`/`.mo` round trip.

---

## Questions for the attorneys

**Tyler Love (GA): 4869 cannot publish until Q1 is answered.**

1. **Sign A1 (§ 9-3-33) and A3 (§ 51-12-33)** in `ga-signoff-packet-2026-10-21.md`. These are the only Georgia authorities 4869 relies on. Also sign **A15 (§ 9-3-71)**, so that E1 can carry the cited sentence instead of the interim one.
2. **Immigration status (D3).** May the page say that immigration status does not bar a Georgia personal-injury claim? Does that extend to workers' compensation (*Continental PET Technologies v. Palacias*, 2004)? Should anything be said about lost-wage exposure?
3. **Rule 7.1 / 7.4 wording (D4, D5).** Is "especialmente preparada" acceptable, or should it be "bien ubicada"? Is "sabemos cómo hacer que las aseguradoras respondan" acceptable?
4. **Fee lines (D6).** Is "solo cobramos un porcentaje si ganamos su caso" with no mention of costs acceptable under the Georgia advertising rules? Is the English "no out-of-pocket costs… zero financial risk" accurate?

**Graeham C. Gillin (SC): 4883 can publish on N1, N2 and the N3 interim wording without him.**

1. **Immigration status and SC workers' comp (N3).** Confirm § 42-1-130 and *Curiel v. Environmental Management Services* (2007) before FAQ[1] keeps "o una lesión en el trabajo". The same text is live on the Spanish Myrtle Beach hub.
2. **Results line (N5) and fee lines (D6 equivalent).** Same Rule 7.1 / 7.2 question as Q3–Q4 above, for South Carolina.

---

## Pack follow-ups (proposed; none applied)

All of these tighten the rules; none weakens them. Each control or catch sentence goes into `law/fixtures/*.json` first.

- **`sctca-mandatory-notice`:** add a Spanish catch sentence ("los plazos de notificación son más cortos" with "entidades del gobierno") and an English catch ("Shorter notice periods apply if a government entity is involved"). The Myrtle Beach wording ("los plazos son más cortos") is the Spanish control and must pass.
- **`ga-medmal-discovery-rule`:** add a catch for "malpractice … follow(s) a discovery rule".
- **New pending authorities for the next packets:** GA immigration and workers' comp (*Palacias*); SC § 42-1-130 / *Curiel*. Each needs a primary-text read first (`evidence`, `verifiedBy: null`).

---

## Counts

| Rule / class | 4869 | 4883 | English twins (live) | Severity |
|---|---|---|---|---|
| sign-off: GA unsigned for Roden | 2 (D1, D2) | — | 1 (E1, after-sign wording) | blocks 4869 |
| `sctca-mandatory-notice` class (engine blind) | — | 1 (N1) | 1 (E2) | error |
| `ga-medmal-discovery-rule` class (engine blind) | — | — | 1 (E1) | error |
| SC bar house wording ("less than 51%") | — | 1 (N2) | 1 (E3) + template | warn |
| no authority: immigration status (rule 4) | 1 (D3, 2 surfaces) | 1 (N3, 2 surfaces) | — | needs attorney |
| parity / ethics wording | 2 (D4, D5) | 2 (N4, N5) | — | minor |
| fee / costs (open attorney item) | 1 (D6) | shared | — | attorney |
| office contact details | — | — | 1 (E4 phone) | minor |
| **Total** | **6** | **5** | **4** + 1 template | |

**False positives:** none. The sweep produced no findings on these pages. The engine cannot read the drafts, and on the twins it missed E1–E3.
