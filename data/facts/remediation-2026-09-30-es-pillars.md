# Live legal sweep: the 23 Spanish practice-area pillar twins, and post 1874 (Georgia car-seat blog)

- **Scope A (LIVE):** every published Spanish `practice_area` twin. There are 23: posts 4873–4882, 4890–4901 and 5200. Each carries `_roden_translation_of` pointing at its EN pillar (3604–3621, 4087–4090, 4692). No twin had ever been swept.
- **Scope B (LIVE):** post 1874, `/blog/georgia-car-seat-law-overview/`, which competes with the unpublished draft `/resources/georgia-car-seat-laws/` (301 decision).
- **Packs:** `internal-ai-scripts/law/SC.json` and `GA.json` (main at 328fe90).
  - **SC is signed** by Graeham C. Gillin, with 48 signed authorities.
  - **GA is signed**, with 22 signed and 10 pending authorities. Pending GA authorities touched here: `GA 51-12-5.1` (punitive), `GA 34-9-11` and `GA 34-9-17` (template table only), and `GA 15-10-2` (template table only). Under rule 1, none of them backs a new claim, and none is cited by a correction below.
  - The GA `40-8-76.1` signed claim still lacks the SB 69 applicability limit (`data/facts/ga-statute-currency-2026-09-30.md` § 2). That pack PR is still pending.
- **Nothing was written** to production, either pack or the theme. The only prod contact was two SELECT-only dumps and one applier **dry run** (see "Replay").

## What was read, and from where

| Source | How | Surfaces |
|---|---|---|
| DB, 23 ES twins + their 23 EN pillars | `scratchpad/es/dump.php` over SSH, `wp eval-file -`, read-only (2026-09-30) | `post_title`, `post_excerpt`, `post_content`, and every `_roden*` meta key: `_roden_faqs`, `_roden_meta_description`, `_roden_hero_intro`, `_roden_why_hire`, `_roden_common_injuries`/`_causes`, `_roden_sol_*`, and on 5200 `_roden_pillar_negligence_intro` / `_roden_pillar_compensation_intro` |
| DB, post 1874 | `scratchpad/es/dump1874.php`, read-only | title, excerpt, content, `_roden_key_takeaways`, `_roden_faqs`, `_roden_meta_description` |
| Rendered pages | `curl` with a browser UA (all 200). 23 ES pillars, 3 EN pillars (WD, med mal, WC) for comparison, and 1874 | Visible text minus DB text leaves the template strings. Every FAQPage JSON-LD block was parsed. |

**The four surfaces, checked, not assumed:**
- **`_roden_key_takeaways`** does not exist on any ES twin. The ES pillars render **no** KT box: 0 of 23 pages have `key-takeaways-box`, while the EN pillars do. So the sweep reads zero there because there is nothing to read, and it was confirmed on the rendered HTML.
- **`post_excerpt`** is set on 22 of 23 twins (5200 is empty). Every one is marketing copy with no legal claim.
- **`_roden_faqs`:** 214 answers. The FAQPage JSON-LD on all 23 rendered pages matches the DB answers one-for-one (0 mismatches), so every FAQ correction below is also a schema correction.
- **`post_content`:** all 23 bodies.

Source key:
- **body** means `post_content`.
- **FAQ[n]** means `_roden_faqs[n].answer` (0-based), which is also published in FAQPage JSON-LD.
- **META** means another `_roden_*` key. The batch applier cannot write META.
- **TEMPLATE** means theme code, `inc/firm-data.php` or `languages/es_ES.po`/`.mo`. TEMPLATE items need a theme PR.

Classes:
- **apply** means the correction only restores wording already signed or already live on the EN twin, and matches a signed pack claim.
- **attorney** means it needs Gillin (SC) or Eric Roden (GA). An attorney edit is written out in the batch file, but `bin/build-linked-pages-batch.py` embeds only `apply` edits.

## Engine baseline

`node scripts/facts/sweep-claims.mjs --client roden --fresh --json` (`scratchpad/es/sweep.json`):
- **0 findings, 132 warnings** site-wide.
- **On the 23 ES twins: 0 findings, 23 warnings.** Every warning is `authority-quantity` on `GA 51-12-33` ("bound to 51%"), which is the SC wording class (group M). Of the 28 batched "51%" strings (groups L and M), the engine flagged 24, on 23 surfaces. It missed 4: 4873 FAQ[5], 4877 FAQ[0], 4882 FAQ[8] and 4893 FAQ[2].
- **It caught none of the substantive errors.** The reason is structural: the pattern rules are English regexes, so Spanish text reaches only the citation-bound checks. The English control for every class found here fires (see "Replay"): `sc-medmal-cap-denied`, `sctca-mandatory-notice`, `sctca-notice-phrases`, `sc-punitive-floor-unindexed`, `wc-deadline-cited-to-tort-statute`, `ga-medmal-discovery-rule` and `municipal-ante-litem-12-months`. The Spanish sentence expressing the same claim passes silently.
  - Proposed: Spanish variants of those seven rules. Each needs a fixture control first (rule 2); no rule was changed here.

## Verdicts

| Post | ES pillar | Verdict | apply | attorney | Worst live error |
|---|---|---|---:|---:|---|
| 4881 | medical-malpractice | **FAIL** | 5 | 1 | FAQ[5]: "Carolina del Sur tampoco limita los daños no económicos" (the SC cap exists), plus an unindexed $500,000 punitive floor. GA SOL run from the negligent act, and repose called "absoluto". |
| 4878 | pedestrian | **FAIL** | 4 | 0 | FAQ[6]: the SC Tort Claims Act "impone su propio aviso previo" |
| 4899 | e-scooter | **FAIL** | 5 | 0 | FAQ[2]/[4] + body: government notice "a veces de pocos meses" stated for both states |
| 5200 | personal-injury | **FAIL** | 6 | 1 | FAQ[1] + body: government "aviso previo" for both states. FAQ[5]: SC punitive exceptions borrowed from GA. META intros (below). |
| 4879 | slip-and-fall | **FAIL** | 4 | 0 | FAQ[7]: Georgia sidewalk claim given 12 months (a city claim has 6) |
| 4875 | workers-comp | **FAIL** | 2 | 3 | body: the SC two-year filing deadline cited to the 90-day notice section § 42-15-20. FAQ[5]: flat § 34-9-82. |
| 4876 | construction | **FAIL** | 2 | 0 | same two WC errors (body, FAQ[6]) |
| 4882 | wrongful-death | **FAIL** | 5 | 0 | FAQ[2] + body: GA "desde el fallecimiento" plus criminal-case tolling stated for both states. FAQ[6]: § 51-4-2. FAQ[5]: full value of life, unscoped. |
| 4890 | brain-injury | **FAIL** | 2 | 0 | FAQ[6]: "puede aplicarse la regla del descubrimiento" |
| 4892 | product-liability | **FAIL** | 2 | 0 | FAQ[2]: recovery "siempre que no sea la mayor parte" (GA bars at 50%) |
| 4897 | nursing-home | **FAIL** | 2 | 1 | FAQ[7]: full value of life, unscoped. FAQ[3]: deadlines "desde el fallecimiento". |
| 4895 | boating | **FAIL** | 2 | 0 | FAQ[8]: full value of life for any death, admiralty included |
| 4898 | bicycle | **FAIL** | 3 | 0 | FAQ[5]: GA 3 feet "generalmente se interpreta", and SC "igualmente" |
| 4880 | dog-bite | **FAIL** | 1 | 0 | FAQ[8]: SOL "suspended while the child is a minor" in both states |
| 4873 4874 4877 4891 4893 4896 4900 4901 | car, truck, motorcycle, spinal, premises, burn, ATV, golf cart | PASS after alignment | 2/1/2/3/2/1/1/1 | 0 | only the "51%" wording (group M) |
| 4894 | maritime | **PASS** | 0 | 0 | federal only; no state-law claim at issue |

**Classes asked about and not found on any ES twin:** GA WC "10 days" (the twin says 30, correctly); hit-and-run "felony for any injury"; the helmet "adult" threshold (the motorcycle FAQ[1] correctly says SC applies "solo para menores de 21 años"); "allows stacking"; any seat-belt rule; the inverted § 51-4-2 one-third rule; and Georgia law on an SC-only page or the reverse (all 23 twins are two-state, `_roden_jurisdiction: both`). The ES twins carry no SC "by dependency" wording either: 4882 FAQ[6] says the beneficiaries are those "que fija la ley", which is consistent with `SC 15-51-40`.

---

# PART A: Spanish pillar twins (batch `data/facts/es-pillars-batch-2026-09-30.json`)

Every `from` below is an exact substring that occurs **once** in its field, and that was checked in sequence after the earlier edits to the same field. The dry run of the real applier against prod confirmed it (see "Replay"). The strings below are copied from the batch file; the batch file wins if the two ever differ.

### A. SC medical-malpractice caps denied; unindexed punitive floor

#### ES-MM3 · apply

- **Post / URL / surface:** 4881 · `/es/practice-areas/medical-malpractice-lawyers/` · FAQ[5] (`_roden_faqs[5]`), also FAQPage JSON-LD (batch field `faq5`). EN twin: 3608 `/practice-areas/medical-malpractice-lawyers/`.
- **Authority:** `SC 15-32-220`, `SC 15-32-530`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** TOP ERROR: says SC does NOT cap non-economic med-mal damages; § 15-32-220 does. Also the unindexed $500,000 punitive floor (sc-punitive-floor-unindexed class). The last sentence is cut because it rests on the no-cap premise. EN 3608 faq5 was corrected 2026-09-29 (PB-MM3); this restores the same claims in Spanish. The comparison table on the same page already shows the caps, so the page contradicts itself today.
- **Live:**

  > Carolina del Sur tampoco limita los daños no económicos en casos de negligencia médica, aunque sí limita los daños punitivos a la cantidad mayor entre $500,000 o tres veces los daños compensatorios (S.C. Code § 15-32-530). Por eso el valor de su caso depende de sus pérdidas reales y no de una cifra fijada de antemano.

- **Corrected:**

  > Carolina del Sur sí limita los daños no económicos en casos de negligencia médica: S.C. Code § 15-32-220 fija una base de $350,000 por proveedor o institución y de $1,050,000 en total, ajustada cada año por inflación ($596,001 y $1,788,002 en 2026). Los daños punitivos tienen un límite aparte: la cantidad mayor entre tres veces los daños compensatorios o $739,245, la cifra ajustada por inflación para 2026 (S.C. Code § 15-32-530).

### B. SCTCA notice stated for South Carolina; Georgia city claims given 12 months

#### ES-PED3 · apply

- **Post / URL / surface:** 4878 · `/es/practice-areas/pedestrian-accident-lawyers/` · FAQ[6] (`_roden_faqs[6]`), also FAQPage JSON-LD (batch field `faq6`). EN twin: 3621 `/practice-areas/pedestrian-accident-lawyers/`.
- **Authority:** `GA 36-33-5`, `GA 36-11-1`, `GA 50-21-26`, `SC 15-78-110`, `SC 15-78-80`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** ERROR: "the SC Tort Claims Act also imposes its own prior notice" is false (SC 15-78-80: filing a verified claim is optional; § 15-78-90(b)). GA half sends city/county road claims to the State Tort Claims Act (§ 50-21-20, not in pack); a city road claim has a 6-month ante litem. Wording follows the EN 4088/4692 key takeaways. EN twin 3621 faq4 carries the same GA error (EN residual).
- **Live:**

  > En Georgia, los reclamos contra agencias gubernamentales deben presentarse bajo la Ley de Reclamos Extracontractuales de Georgia (O.C.G.A. § 50-21-20), con requisitos de notificación específicos y plazos más cortos que los de un caso común. En Carolina del Sur, los reclamos contra entidades gubernamentales se rigen por la ley estatal de reclamos (South Carolina Tort Claims Act), que también impone su propio aviso previo y plazos más cortos.

- **Corrected:**

  > En Georgia, un reclamo contra el gobierno exige un aviso previo por escrito (ante litem): dentro de 6 meses contra una ciudad (O.C.G.A. § 36-33-5) y dentro de 12 meses contra un condado (O.C.G.A. § 36-11-1) o contra el Estado (O.C.G.A. § 50-21-26). En Carolina del Sur, la Ley de Reclamos contra el Gobierno (South Carolina Tort Claims Act) no exige un aviso previo, pero la demanda debe presentarse dentro de 2 años (S.C. Code § 15-78-110), o de 3 años si primero se presentó un reclamo verificado ante la entidad (S.C. Code § 15-78-80).

#### ES-SF3 · apply

- **Post / URL / surface:** 4879 · `/es/practice-areas/slip-and-fall-lawyers/` · FAQ[7] (`_roden_faqs[7]`), also FAQPage JSON-LD (batch field `faq7`). EN twin: 3606 `/practice-areas/slip-and-fall-lawyers/`.
- **Authority:** `GA 36-33-5`, `GA 36-11-1`, `GA 50-21-26`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** ERROR (municipal-ante-litem-12-months class): the question is about sidewalks, usually a city claim, which has a 6-month notice. EN twin 3606 faq7 and faq1 carry the same error (EN residual).
- **Live:**

  > En Georgia se rigen por la Ley de Reclamos Extracontractuales de Georgia (O.C.G.A. § 50-21-20), que exige dar un aviso previo (ante litem) dentro de los 12 meses del incidente.

- **Corrected:**

  > En Georgia exigen un aviso previo por escrito (ante litem): dentro de 6 meses contra una ciudad (O.C.G.A. § 36-33-5) y dentro de 12 meses contra un condado (O.C.G.A. § 36-11-1) o contra el Estado (O.C.G.A. § 50-21-26).

#### ES-SF4 · apply

- **Post / URL / surface:** 4879 · `/es/practice-areas/slip-and-fall-lawyers/` · FAQ[7] (`_roden_faqs[7]`), also FAQPage JSON-LD (batch field `faq7`). EN twin: 3606 `/practice-areas/slip-and-fall-lawyers/`.
- **Authority:** `SC 15-78-110`, `SC 15-78-80`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Not false, but narrow: the SCTCA covers political subdivisions, not only the State, and omits the three-year verified-claim path. Aligns to the EN PI key takeaway.
- **Live:**

  > Carolina del Sur tiene su propia ley de reclamos contra el Estado (S.C. Code § 15-78-110), con un plazo de presentación de 2 años.

- **Corrected:**

  > Carolina del Sur tiene su propia ley de reclamos contra el gobierno, que no exige aviso previo: la demanda debe presentarse dentro de 2 años (S.C. Code § 15-78-110), o de 3 si primero se presentó un reclamo verificado ante la entidad (S.C. Code § 15-78-80).

#### ES-ES3 · apply

- **Post / URL / surface:** 4899 · `/es/practice-areas/electric-scooter-accident-lawyers/` · FAQ[2] (`_roden_faqs[2]`), also FAQPage JSON-LD (batch field `faq2`). EN twin: 4088 `/practice-areas/electric-scooter-accident-lawyers/`.
- **Authority:** `GA 36-33-5`, `GA 36-11-1`, `SC 15-78-110`, `SC 15-78-80`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** SCTCA-notice class: a notice requirement stated for both states. Wording from the EN e-bike key takeaway (4088). EN 4088 faq5 carries the same class (EN residual).
- **Live:**

  > Ojo: los reclamos contra entidades de gobierno tienen requisitos de aviso previo con plazos mucho más cortos que los normales — a veces de pocos meses — así que consúltenos de inmediato.

- **Corrected:**

  > Ojo: en Georgia, un reclamo contra una ciudad exige un aviso previo por escrito (ante litem) dentro de 6 meses (O.C.G.A. § 36-33-5), y contra un condado, dentro de 12 meses (O.C.G.A. § 36-11-1). En Carolina del Sur no se exige aviso previo, pero la demanda contra el gobierno debe presentarse dentro de 2 años (S.C. Code § 15-78-110), o de 3 si primero se presentó un reclamo verificado (S.C. Code § 15-78-80). Consúltenos de inmediato.

#### ES-ES4 · apply

- **Post / URL / surface:** 4899 · `/es/practice-areas/electric-scooter-accident-lawyers/` · FAQ[4] (`_roden_faqs[4]`), also FAQPage JSON-LD (batch field `faq4`). EN twin: 4088 `/practice-areas/electric-scooter-accident-lawyers/`.
- **Authority:** `GA 36-33-5`, `GA 36-11-1`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Same class.
- **Live:**

  > y los reclamos contra el gobierno exigen aviso mucho antes.

- **Corrected:**

  > y en Georgia los reclamos contra una ciudad o un condado exigen un aviso previo mucho antes.

#### ES-ES5 · apply

- **Post / URL / surface:** 4899 · `/es/practice-areas/electric-scooter-accident-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 4088 `/practice-areas/electric-scooter-accident-lawyers/`.
- **Authority:** `GA 36-33-5`, `GA 36-11-1`, `SC 15-78-80`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Same class, in the body.
- **Live:**

  > — estos últimos con requisitos de aviso especiales y plazos más cortos.

- **Corrected:**

  > — estos últimos con reglas y plazos propios, como el aviso previo que exige Georgia.

#### ES-PI1 · apply

- **Post / URL / surface:** 5200 · `/es/practice-areas/personal-injury-lawyers/` · FAQ[1] (`_roden_faqs[1]`), also FAQPage JSON-LD (batch field `faq1`). EN twin: 4692 `/practice-areas/personal-injury-lawyers/`.
- **Authority:** `GA 36-33-5`, `GA 36-11-1`, `GA 50-21-26`, `SC 15-78-110`, `SC 15-78-80`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** SCTCA-notice class. Wording is the EN 4692 key takeaway, cited per clause (engine gotcha). EN 4692 faq1 carries the same class (EN residual).
- **Live:**

  > Los reclamos contra entidades del gobierno exigen un aviso previo mucho más corto.

- **Corrected:**

  > Los reclamos contra el gobierno avanzan más rápido: Georgia exige un aviso previo (ante litem) dentro de 6 meses contra una ciudad (O.C.G.A. § 36-33-5) y de 12 meses contra un condado (O.C.G.A. § 36-11-1) o el Estado (O.C.G.A. § 50-21-26); en Carolina del Sur, la demanda contra el gobierno debe presentarse dentro de 2 años (S.C. Code § 15-78-110), o de 3 si primero se presentó un reclamo verificado (S.C. Code § 15-78-80).

#### ES-PI7 · apply

- **Post / URL / surface:** 5200 · `/es/practice-areas/personal-injury-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 4692 `/practice-areas/personal-injury-lawyers/`.
- **Authority:** `GA 36-33-5`, `GA 36-11-1`, `SC 15-78-110`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** SCTCA-notice class, in the body.
- **Live:**

  > Los reclamos contra entidades del gobierno exigen avisos previos mucho más cortos.

- **Corrected:**

  > Los reclamos contra el gobierno tienen reglas propias: en Georgia exigen un aviso previo (ante litem) dentro de 6 meses contra una ciudad (O.C.G.A. § 36-33-5) o de 12 meses contra un condado (O.C.G.A. § 36-11-1), y en Carolina del Sur la demanda debe presentarse, por lo general, dentro de 2 años (S.C. Code § 15-78-110).

### C. Georgia med-mal deadline run from the negligent act; repose called absolute

#### ES-MM1 · apply

- **Post / URL / surface:** 4881 · `/es/practice-areas/medical-malpractice-lawyers/` · FAQ[1] (`_roden_faqs[1]`), also FAQPage JSON-LD (batch field `faq1`). EN twin: 3608 `/practice-areas/medical-malpractice-lawyers/`.
- **Authority:** `GA 9-3-71`, `SC 15-3-545`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** ERROR: GA § 9-3-71(a) runs from the date of injury or death, not from the negligent act (the act starts only the 5-year repose). "Límite absoluto" is the medmal-repose-absolute class (§§ 9-3-72/-73, § 15-3-545(B)/(D)). SC start rule restored from the signed claim, as EN 3608 faq1 (PB-MM1).
- **Live:**

  > En Georgia, generalmente 2 años (O.C.G.A. § 9-3-71) desde el acto negligente, con un límite absoluto de 5 años en la mayoría de los casos. En Carolina del Sur, generalmente 3 años (S.C. Code § 15-3-545). Existen excepciones limitadas, como objetos olvidados en el cuerpo.

- **Corrected:**

  > En Georgia, generalmente 2 años desde la fecha de la lesión o de la muerte, con un plazo máximo (statute of repose) de 5 años desde el acto negligente (O.C.G.A. § 9-3-71). En Carolina del Sur, 3 años desde el tratamiento, la omisión o la operación, o desde que la lesión se descubrió o debió descubrirse, con un plazo máximo de 6 años (S.C. Code § 15-3-545). Existen excepciones, como los objetos olvidados en el cuerpo y los casos de menores.

#### ES-MM2 · apply

- **Post / URL / surface:** 4881 · `/es/practice-areas/medical-malpractice-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3608 `/practice-areas/medical-malpractice-lawyers/`.
- **Authority:** `GA 9-3-71`, `SC 15-3-545`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Same error as ES-MM1, in the body.
- **Live:**

  > En Georgia, usted generalmente tiene 2 años (O.C.G.A. § 9-3-71) desde la fecha del acto negligente para presentar una demanda por negligencia médica, con un límite absoluto de 5 años en la mayoría de los casos. En Carolina del Sur, el plazo general es de 3 años (S.C. Code § 15-3-545).

- **Corrected:**

  > En Georgia, usted generalmente tiene 2 años desde la fecha de la lesión o de la muerte para presentar una demanda por negligencia médica, con un plazo máximo de 5 años desde el acto negligente (O.C.G.A. § 9-3-71). En Carolina del Sur, el plazo general es de 3 años desde el tratamiento o desde que la lesión se descubrió o debió descubrirse, con un plazo máximo de 6 años (S.C. Code § 15-3-545).

### D. Workers' comp: flat § 34-9-82 and the SC filing deadline cited to the notice section

#### ES-WC1 · apply

- **Post / URL / surface:** 4875 · `/es/practice-areas/workers-compensation-lawyers/` · FAQ[5] (`_roden_faqs[5]`), also FAQPage JSON-LD (batch field `faq5`). EN twin: 3610 `/practice-areas/workers-compensation-lawyers/`.
- **Authority:** `GA 34-9-82`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Flat one-year § 34-9-82 (Savannah WC E1 class). Restores the signed three-prong wording that EN 3610 faq0 carries since PB-WC1. Also FAQPage JSON-LD.
- **Live:**

  > y después tiene un año desde la fecha de la lesión para presentar un reclamo formal ante la Junta Estatal de Compensación Laboral (O.C.G.A. § 34-9-82)

- **Corrected:**

  > y después tiene un año desde la fecha de la lesión, un año desde el último tratamiento médico que le haya dado su empleador o dos años desde el último pago semanal de beneficios para presentar un reclamo formal ante la Junta Estatal de Compensación Laboral (O.C.G.A. § 34-9-82)

#### ES-WC3 · apply

- **Post / URL / surface:** 4875 · `/es/practice-areas/workers-compensation-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3610 `/practice-areas/workers-compensation-lawyers/`.
- **Authority:** `GA 34-9-80`, `GA 34-9-82`, `SC 42-15-20`, `SC 42-15-40`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Two errors: the SC two-year filing deadline is cited to the 90-day NOTICE section § 42-15-20 (it is § 42-15-40), and the GA one year is flat. GA wording is the theme es_ES msgstr already live on this page ("1 año desde la lesión, extendido si el empleador pagó tratamiento o beneficios").
- **Live:**

  > En Georgia, debe reportar su lesión a su empleador dentro de 30 días y presentar su reclamo dentro de 1 año (O.C.G.A. § 34-9-82). En Carolina del Sur, debe reportar dentro de 90 días y presentar su reclamo dentro de 2 años (S.C. Code § 42-15-20).

- **Corrected:**

  > En Georgia, debe reportar su lesión a su empleador dentro de 30 días (O.C.G.A. § 34-9-80) y presentar su reclamo, por lo general, dentro de 1 año desde la lesión, plazo que se extiende si el empleador pagó tratamiento o beneficios (O.C.G.A. § 34-9-82). En Carolina del Sur, debe reportar dentro de 90 días (S.C. Code § 42-15-20) y presentar su reclamo dentro de 2 años desde el accidente (S.C. Code § 42-15-40).

#### ES-CON1 · apply

- **Post / URL / surface:** 4876 · `/es/practice-areas/construction-accident-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3618 `/practice-areas/construction-accident-lawyers/`.
- **Authority:** `GA 34-9-80`, `GA 34-9-82`, `SC 42-15-20`, `SC 42-15-40`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Same two errors as ES-WC3: SC filing deadline cited to the notice section, GA flat one year.
- **Live:**

  > en Georgia debe reportar la lesión en 30 días y presentar el reclamo en 1 año (O.C.G.A. § 34-9-82); en Carolina del Sur, reportar en 90 días y presentar en 2 años (S.C. Code § 42-15-20).

- **Corrected:**

  > en Georgia debe reportar la lesión en 30 días (O.C.G.A. § 34-9-80) y presentar el reclamo, por lo general, en 1 año desde la lesión, plazo que se extiende si el empleador pagó tratamiento o beneficios (O.C.G.A. § 34-9-82); en Carolina del Sur, reportar en 90 días (S.C. Code § 42-15-20) y presentar el reclamo en 2 años desde el accidente (S.C. Code § 42-15-40).

#### ES-CON2 · apply

- **Post / URL / surface:** 4876 · `/es/practice-areas/construction-accident-lawyers/` · FAQ[6] (`_roden_faqs[6]`), also FAQPage JSON-LD (batch field `faq6`). EN twin: 3618 `/practice-areas/construction-accident-lawyers/`.
- **Authority:** `GA 34-9-80`, `GA 34-9-82`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Flat § 34-9-82. The EN construction KT says "generally due within one year".
- **Live:**

  > en Georgia usted debe reportar la lesión dentro de 30 días y presentar el reclamo dentro de 1 año (O.C.G.A. § 34-9-82)

- **Corrected:**

  > en Georgia usted debe reportar la lesión dentro de 30 días (O.C.G.A. § 34-9-80) y presentar el reclamo, por lo general, dentro de 1 año desde la lesión, plazo que se extiende si el empleador pagó tratamiento o beneficios (O.C.G.A. § 34-9-82)

### E. Discovery rule for a Georgia personal-injury claim

#### ES-BI1 · apply

- **Post / URL / surface:** 4890 · `/es/practice-areas/brain-injury-lawyers/` · FAQ[6] (`_roden_faqs[6]`), also FAQPage JSON-LD (batch field `faq6`). EN twin: 3612 `/practice-areas/brain-injury-lawyers/`.
- **Authority:** `GA 9-3-33`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** ERROR (ga-pi-discovery-rule class): a discovery rule for a Georgia traumatic injury is wrong. EN 3612 faq1 fixed as PB-BI1. SC § 15-3-535 is not in the pack, so nothing is said about the SC start (Gillin).
- **Live:**

  > Cuando el alcance completo de una lesión cerebral no es evidente de inmediato, puede aplicarse la regla del descubrimiento (discovery rule): el reloj empieza a correr cuando usted supo o debió haber sabido de la lesión.

- **Corrected:**

  > En Georgia, el plazo corre desde la fecha de la lesión aunque el alcance completo de una lesión cerebral todavía no sea evidente.

### F. Wrongful-death start date and the criminal-case tolling example

#### ES-WD1 · apply

- **Post / URL / surface:** 4882 · `/es/practice-areas/wrongful-death-lawyers/` · FAQ[2] (`_roden_faqs[2]`), also FAQPage JSON-LD (batch field `faq2`). EN twin: 3609 `/practice-areas/wrongful-death-lawyers/`.
- **Authority:** `GA 51-4-1`, `GA 9-3-33`, `SC 15-3-530`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** EN PB-WD1 wording (no death-based start in either signed claim). The criminal-case tolling example is Georgia-only (§ 9-3-99, not in the pack) and false for SC as written; EN 3609 faq2 no longer carries it. Eric Roden may restore it scoped to Georgia once § 9-3-99 is signed.
- **Live:**

  > En Georgia, generalmente 2 años (O.C.G.A. § 9-3-33) desde el fallecimiento; en Carolina del Sur, 3 años (S.C. Code § 15-3-530). Ciertos hechos pueden modificar el plazo, como un proceso penal pendiente contra el responsable.

- **Corrected:**

  > En Georgia, la demanda debe presentarse dentro de 2 años (O.C.G.A. § 9-3-33); en Carolina del Sur, el plazo es generalmente de 3 años (S.C. Code § 15-3-530). Estos plazos se aplican de forma estricta.

#### ES-WD2 · apply

- **Post / URL / surface:** 4882 · `/es/practice-areas/wrongful-death-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3609 `/practice-areas/wrongful-death-lawyers/`.
- **Authority:** `GA 51-4-1`, `GA 9-3-33`, `SC 15-3-530`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Same as ES-WD1, in the body.
- **Live:**

  > En Georgia, la familia generalmente tiene 2 años (O.C.G.A. § 9-3-33) desde la fecha del fallecimiento para presentar la demanda; en Carolina del Sur, el plazo general es de 3 años (S.C. Code § 15-3-530). Algunos hechos pueden acortar o pausar estos plazos — por ejemplo, si hay un proceso penal relacionado — así que es importante consultar pronto.

- **Corrected:**

  > En Georgia, la familia generalmente tiene 2 años (O.C.G.A. § 9-3-33) para presentar la demanda; en Carolina del Sur, el plazo general es de 3 años (S.C. Code § 15-3-530). Algunos hechos pueden cambiar estos plazos, así que es importante consultar pronto.

#### ES-NH3 · apply

- **Post / URL / surface:** 4897 · `/es/practice-areas/nursing-home-abuse-lawyers/` · FAQ[3] (`_roden_faqs[3]`), also FAQPage JSON-LD (batch field `faq3`). EN twin: 3619 `/practice-areas/nursing-home-abuse-lawyers/`.
- **Authority:** `GA 51-4-1`, `SC 15-3-530`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** PB-WD1/PB-PED3 class: neither signed claim carries a death-based start.
- **Live:**

  > y los plazos corren desde el fallecimiento — consúltenos pronto.

- **Corrected:**

  > y los plazos son estrictos — consúltenos pronto.

### G. "Full value of the life" stated for South Carolina; § 51-4-2 cited for the measure

#### ES-WD3 · apply

- **Post / URL / surface:** 4882 · `/es/practice-areas/wrongful-death-lawyers/` · FAQ[6] (`_roden_faqs[6]`), also FAQPage JSON-LD (batch field `faq6`). EN twin: 3609 `/practice-areas/wrongful-death-lawyers/`.
- **Authority:** `GA 51-4-1`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** EN PB-WD2: § 51-4-1 defines the measure; § 51-4-2 is not in the pack.
- **Live:**

  > (full value of the life, O.C.G.A. § 51-4-2)

- **Corrected:**

  > (full value of the life, O.C.G.A. § 51-4-1)

#### ES-WD5 · apply

- **Post / URL / surface:** 4882 · `/es/practice-areas/wrongful-death-lawyers/` · FAQ[5] (`_roden_faqs[5]`), also FAQPage JSON-LD (batch field `faq5`). EN twin: 3609 `/practice-areas/wrongful-death-lawyers/`.
- **Authority:** `GA 51-4-1`, `SC 15-51-40`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** "Full value of life" stated for both states. SC measures damages by the injury to each beneficiary (§ 15-51-40). EN 3609 faq3 carries the same unscoped phrase (EN residual).
- **Live:**

  > la compañía y el valor total de la vida de la persona fallecida.

- **Corrected:**

  > la compañía y, en Georgia, el valor total de la vida de la persona fallecida (O.C.G.A. § 51-4-1).

#### ES-BT2 · apply

- **Post / URL / surface:** 4895 · `/es/practice-areas/boating-accident-lawyers/` · FAQ[8] (`_roden_faqs[8]`), also FAQPage JSON-LD (batch field `faq8`). EN twin: 3616 `/practice-areas/boating-accident-lawyers/`.
- **Authority:** `GA 51-4-1`, `SC 15-51-40`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** "Full value of life" stated for both states and for admiralty. EN 3616 faq8 carries the same (EN residual). EN compensation intro already scopes it to "a Georgia state-water boating death".
- **Live:**

  > En casos de muerte injusta, los familiares sobrevivientes pueden recuperar el valor total de la vida de la persona fallecida.

- **Corrected:**

  > En casos de muerte, la familia puede presentar un reclamo por muerte injusta; cuando se aplica la ley de Georgia, la pérdida se mide por el valor total de la vida de la persona fallecida (O.C.G.A. § 51-4-1).

#### ES-NH1 · apply

- **Post / URL / surface:** 4897 · `/es/practice-areas/nursing-home-abuse-lawyers/` · FAQ[7] (`_roden_faqs[7]`), also FAQPage JSON-LD (batch field `faq7`). EN twin: 3619 `/practice-areas/nursing-home-abuse-lawyers/`.
- **Authority:** `GA 51-4-1`, `SC 15-51-40`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Same "full value of life" class; EN 3619 faq5 carries it too (EN residual).
- **Live:**

  > En los casos de muerte injusta también se pueden reclamar los gastos funerarios y el valor total de la vida de la persona fallecida.

- **Corrected:**

  > En los casos de muerte injusta también se pueden reclamar los gastos funerarios y, en Georgia, el valor total de la vida de la persona fallecida (O.C.G.A. § 51-4-1).

### H. Georgia 50% bar misstated as "not the greater part"

#### ES-PL1 · apply

- **Post / URL / surface:** 4892 · `/es/practice-areas/product-liability-lawyers/` · FAQ[2] (`_roden_faqs[2]`), also FAQPage JSON-LD (batch field `faq2`). EN twin: 3615 `/practice-areas/product-liability-lawyers/`.
- **Authority:** `GA 51-12-33`, `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** ERROR for GA: "as long as it is not the greater part" lets a 50% plaintiff recover; § 51-12-33 bars at 50%. Scoped to negligence claims per the EN A2 decision (SC strict-liability fault is a Gillin question).
- **Live:**

  > Y bajo la culpa comparativa de Georgia y Carolina del Sur, usted puede recuperar aunque tenga parte de la culpa, siempre que no sea la mayor parte.

- **Corrected:**

  > Y en un reclamo por negligencia, usted puede recuperar aunque tenga parte de la culpa: en Georgia, si su culpa es menor al 50% (O.C.G.A. § 51-12-33); en Carolina del Sur, si es del 50% o menos (Nelson v. Concrete Supply Co.).

### I. Minors: "tolled until 18" / "suspended while a minor"

#### ES-PED4 · apply

- **Post / URL / surface:** 4878 · `/es/practice-areas/pedestrian-accident-lawyers/` · FAQ[8] (`_roden_faqs[8]`), also FAQPage JSON-LD (batch field `faq8`). EN twin: 3621 `/practice-areas/pedestrian-accident-lawyers/`.
- **Authority:** none in a signed pack (see note)
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Restores the EN wording applied as PB-PED4 on 3621 faq8. "Tolled until 18" overstates SC (§ 15-3-40 limits the extension to one year after the disability ends). Neither § 15-3-40 nor § 9-3-90 is in a pack; clean cut.
- **Live:**

  > El plazo para demandar se suspende (se pausa) hasta que el menor cumple 18 años, pero recomendamos actuar pronto

- **Corrected:**

  > Existen reglas especiales de plazo para los menores, pero recomendamos actuar pronto

#### ES-DOG1 · apply

- **Post / URL / surface:** 4880 · `/es/practice-areas/dog-bite-lawyers/` · FAQ[8] (`_roden_faqs[8]`), also FAQPage JSON-LD (batch field `faq8`). EN twin: 3611 `/practice-areas/dog-bite-lawyers/`.
- **Authority:** none in a signed pack (see note)
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** PB-PED4 class: "suspended while the child is a minor" overstates SC § 15-3-40 (one year after majority). Neither tolling statute is in a pack. EN 3611 faq2 ("tolled until the age of majority") carries the same error (EN residual).
- **Live:**

  > Georgia y Carolina del Sur permiten suspender el plazo de prescripción mientras el niño es menor de edad, lo que da tiempo adicional para presentar la demanda.

- **Corrected:**

  > En Georgia y Carolina del Sur pueden aplicarse reglas especiales de plazo a los reclamos de menores, pero conviene actuar pronto.

### J. Bicycle passing distance

#### ES-BK1 · apply

- **Post / URL / surface:** 4898 · `/es/practice-areas/bicycle-accident-lawyers/` · FAQ[5] (`_roden_faqs[5]`), also FAQPage JSON-LD (batch field `faq5`). EN twin: 4087 `/practice-areas/bicycle-accident-lawyers/`.
- **Authority:** `GA 40-6-56`, `SC 56-5-3435`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** EN PB-BK1: the 3-foot rule is statutory, not an interpretation, and "igualmente" implies a matching SC distance.
- **Live:**

  > Georgia exige que los conductores rebasen a un ciclista dejando una distancia segura, que generalmente se interpreta como al menos 3 pies. Carolina del Sur exige igualmente una distancia de rebase segura (S.C. Code § 56-5-3435).

- **Corrected:**

  > Georgia exige que los conductores dejen al menos 3 pies de distancia al rebasar a un ciclista (O.C.G.A. § 40-6-56). Carolina del Sur exige una distancia de rebase segura, pero no fija ninguna distancia en pies (S.C. Code § 56-5-3435).

### K. SC punitive exceptions borrowed from Georgia

#### ES-PI4 · apply

- **Post / URL / surface:** 5200 · `/es/practice-areas/personal-injury-lawyers/` · FAQ[5] (`_roden_faqs[5]`), also FAQPage JSON-LD (batch field `faq5`). EN twin: 4692 `/practice-areas/personal-injury-lawyers/`.
- **Authority:** `SC 15-32-530`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** The product-liability exception is Georgia's (§ 51-12-5.1(e), pending, already published); the signed SC § 15-32-530 has no product exception. The GA half is unchanged. EN 4692 faq5 carries the same run-on (EN residual).
- **Live:**

  > limitados por O.C.G.A. § 51-12-5.1 en Georgia y S.C. Code § 15-32-530 en Carolina del Sur, con excepciones importantes para productos defectuosos y casos de intoxicación.

- **Corrected:**

  > limitados en Georgia por O.C.G.A. § 51-12-5.1, con excepciones importantes para productos defectuosos y casos de intoxicación, y en Carolina del Sur por S.C. Code § 15-32-530, con excepciones cuando hubo intención de causar daño, una condena por delito grave derivada de la conducta o alteración por alcohol o drogas.

### L. Boating: the state fault bar unconditioned

#### ES-BT1 · apply

- **Post / URL / surface:** 4895 · `/es/practice-areas/boating-accident-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3616 `/practice-areas/boating-accident-lawyers/`.
- **Authority:** `GA 51-12-33`, `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** EN A1 decision: condition the state fault bar where federal maritime law may govern. Plus SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > Ambos estados aplican culpa comparativa — recuperación con culpa menor al 50% en Georgia (O.C.G.A. § 51-12-33) y menor al 51% en Carolina del Sur.

- **Corrected:**

  > Bajo la ley estatal, ambos estados aplican culpa comparativa: recuperación con culpa menor al 50% en Georgia (O.C.G.A. § 51-12-33) y del 50% o menos en Carolina del Sur (Nelson v. Concrete Supply Co.).

### M. SC "51%" wording aligned to the Nelson house wording

#### ES-CAR1 · apply

- **Post / URL / surface:** 4873 · `/es/practice-areas/car-accident-lawyers/` · FAQ[5] (`_roden_faqs[5]`), also FAQPage JSON-LD (batch field `faq5`). EN twin: 3604 `/practice-areas/car-accident-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn. EN twin 3604 faq1 = PB-F6.
- **Live:**

  > En Carolina del Sur el umbral es de 51%.

- **Corrected:**

  > En Carolina del Sur puede recuperar si su culpa es del 50% o menos (Nelson v. Concrete Supply Co.).

#### ES-CAR2 · apply

- **Post / URL / surface:** 4873 · `/es/practice-areas/car-accident-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3604 `/practice-areas/car-accident-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > en Carolina del Sur, si fue menos del 51% culpable.

- **Corrected:**

  > en Carolina del Sur, si fue el 50% culpable o menos (Nelson v. Concrete Supply Co.).

#### ES-TRK1 · apply

- **Post / URL / surface:** 4874 · `/es/practice-areas/truck-accident-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3605 `/practice-areas/truck-accident-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > en Carolina del Sur, si fue menos del 51%.

- **Corrected:**

  > en Carolina del Sur, si fue el 50% culpable o menos (Nelson v. Concrete Supply Co.).

#### ES-MC1 · apply

- **Post / URL / surface:** 4877 · `/es/practice-areas/motorcycle-accident-lawyers/` · FAQ[0] (`_roden_faqs[0]`), also FAQPage JSON-LD (batch field `faq0`). EN twin: 3607 `/practice-areas/motorcycle-accident-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn. EN 3607 faq3 = PB-F5.
- **Live:**

  > en Carolina del Sur, menos del 51%.

- **Corrected:**

  > en Carolina del Sur, si fue el 50% culpable o menos (Nelson v. Concrete Supply Co.).

#### ES-MC2 · apply

- **Post / URL / surface:** 4877 · `/es/practice-areas/motorcycle-accident-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3607 `/practice-areas/motorcycle-accident-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > y en Carolina del Sur si fue menos del 51% —

- **Corrected:**

  > y en Carolina del Sur si fue el 50% culpable o menos (Nelson v. Concrete Supply Co.) —

#### ES-PED1 · apply

- **Post / URL / surface:** 4878 · `/es/practice-areas/pedestrian-accident-lawyers/` · FAQ[0] (`_roden_faqs[0]`), also FAQPage JSON-LD (batch field `faq0`). EN twin: 3621 `/practice-areas/pedestrian-accident-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn. EN 3621 faq1 = PB-PED1.
- **Live:**

  > en Carolina del Sur, menos del 51% —

- **Corrected:**

  > en Carolina del Sur, si fue el 50% culpable o menos (Nelson v. Concrete Supply Co.) —

#### ES-PED2 · apply

- **Post / URL / surface:** 4878 · `/es/practice-areas/pedestrian-accident-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3621 `/practice-areas/pedestrian-accident-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > y en Carolina del Sur si fue menos del 51%.

- **Corrected:**

  > y en Carolina del Sur si fue el 50% culpable o menos (Nelson v. Concrete Supply Co.).

#### ES-SF1 · apply

- **Post / URL / surface:** 4879 · `/es/practice-areas/slip-and-fall-lawyers/` · FAQ[2] (`_roden_faqs[2]`), also FAQPage JSON-LD (batch field `faq2`). EN twin: 3606 `/practice-areas/slip-and-fall-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > en Carolina del Sur, menos del 51%.

- **Corrected:**

  > en Carolina del Sur, si fue el 50% culpable o menos (Nelson v. Concrete Supply Co.).

#### ES-SF2 · apply

- **Post / URL / surface:** 4879 · `/es/practice-areas/slip-and-fall-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3606 `/practice-areas/slip-and-fall-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > y en Carolina del Sur si fue menos del 51%.

- **Corrected:**

  > y en Carolina del Sur si fue el 50% culpable o menos (Nelson v. Concrete Supply Co.).

#### ES-WD4 · apply

- **Post / URL / surface:** 4882 · `/es/practice-areas/wrongful-death-lawyers/` · FAQ[8] (`_roden_faqs[8]`), also FAQPage JSON-LD (batch field `faq8`). EN twin: 3609 `/practice-areas/wrongful-death-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`, `SC 15-51-10`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** EN PB-WD4. The fault is the decedent's.
- **Live:**

  > En Carolina del Sur el umbral es del 51%.

- **Corrected:**

  > Carolina del Sur permite recuperar siempre que la persona fallecida haya tenido el 50% o menos de la culpa (Nelson v. Concrete Supply Co.).

#### ES-BI2 · apply

- **Post / URL / surface:** 4890 · `/es/practice-areas/brain-injury-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3612 `/practice-areas/brain-injury-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > en Carolina del Sur, si es menor al 51%.

- **Corrected:**

  > en Carolina del Sur, si es del 50% o menos (Nelson v. Concrete Supply Co.).

#### ES-SCI1 · apply

- **Post / URL / surface:** 4891 · `/es/practice-areas/spinal-cord-injury-lawyers/` · FAQ[2] (`_roden_faqs[2]`), also FAQPage JSON-LD (batch field `faq2`). EN twin: 3613 `/practice-areas/spinal-cord-injury-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn. EN 3613 faq5 = PB-F4.
- **Live:**

  > y Carolina del Sur si es menor al 51%;

- **Corrected:**

  > y Carolina del Sur si es del 50% o menos (Nelson v. Concrete Supply Co.);

#### ES-SCI2 · apply

- **Post / URL / surface:** 4891 · `/es/practice-areas/spinal-cord-injury-lawyers/` · FAQ[7] (`_roden_faqs[7]`), also FAQPage JSON-LD (batch field `faq7`). EN twin: 3613 `/practice-areas/spinal-cord-injury-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > en Carolina del Sur el umbral es del 51%.

- **Corrected:**

  > en Carolina del Sur, si fue del 50% o menos (Nelson v. Concrete Supply Co.).

#### ES-SCI3 · apply

- **Post / URL / surface:** 4891 · `/es/practice-areas/spinal-cord-injury-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3613 `/practice-areas/spinal-cord-injury-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > en Carolina del Sur, si es menor al 51%.

- **Corrected:**

  > en Carolina del Sur, si es del 50% o menos (Nelson v. Concrete Supply Co.).

#### ES-PL2 · apply

- **Post / URL / surface:** 4892 · `/es/practice-areas/product-liability-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3615 `/practice-areas/product-liability-lawyers/`.
- **Authority:** `GA 51-12-33`, `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn. Scoped to negligence per EN A2.
- **Live:**

  > Ambos estados aplican culpa comparativa: en Georgia usted puede recuperar si su culpa es menor al 50% (O.C.G.A. § 51-12-33); en Carolina del Sur, si es menor al 51%.

- **Corrected:**

  > En un reclamo por negligencia, ambos estados aplican culpa comparativa: en Georgia usted puede recuperar si su culpa es menor al 50% (O.C.G.A. § 51-12-33); en Carolina del Sur, si es del 50% o menos (Nelson v. Concrete Supply Co.).

#### ES-PR1 · apply

- **Post / URL / surface:** 4893 · `/es/practice-areas/premises-liability-lawyers/` · FAQ[2] (`_roden_faqs[2]`), also FAQPage JSON-LD (batch field `faq2`). EN twin: 3620 `/practice-areas/premises-liability-lawyers/`.
- **Authority:** `GA 51-12-33`, `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > si su culpa es menor al 50% en Georgia y menor al 51% en Carolina del Sur

- **Corrected:**

  > si su culpa es menor al 50% en Georgia (O.C.G.A. § 51-12-33) y del 50% o menos en Carolina del Sur (Nelson v. Concrete Supply Co.)

#### ES-PR2 · apply

- **Post / URL / surface:** 4893 · `/es/practice-areas/premises-liability-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3620 `/practice-areas/premises-liability-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > y menor al 51% en Carolina del Sur

- **Corrected:**

  > y del 50% o menos en Carolina del Sur (Nelson v. Concrete Supply Co.)

#### ES-BN1 · apply

- **Post / URL / surface:** 4896 · `/es/practice-areas/burn-injury-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3617 `/practice-areas/burn-injury-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > y menor al 51% en Carolina del Sur.

- **Corrected:**

  > y del 50% o menos en Carolina del Sur (Nelson v. Concrete Supply Co.).

#### ES-BK2 · apply

- **Post / URL / surface:** 4898 · `/es/practice-areas/bicycle-accident-lawyers/` · FAQ[3] (`_roden_faqs[3]`), also FAQPage JSON-LD (batch field `faq3`). EN twin: 4087 `/practice-areas/bicycle-accident-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > y menor al 51% en Carolina del Sur.

- **Corrected:**

  > y del 50% o menos en Carolina del Sur (Nelson v. Concrete Supply Co.).

#### ES-BK3 · apply

- **Post / URL / surface:** 4898 · `/es/practice-areas/bicycle-accident-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 4087 `/practice-areas/bicycle-accident-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > menos del 51% en Carolina del Sur)

- **Corrected:**

  > 50% o menos en Carolina del Sur, Nelson v. Concrete Supply Co.)

#### ES-ES1 · apply

- **Post / URL / surface:** 4899 · `/es/practice-areas/electric-scooter-accident-lawyers/` · FAQ[3] (`_roden_faqs[3]`), also FAQPage JSON-LD (batch field `faq3`). EN twin: 4088 `/practice-areas/electric-scooter-accident-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > y menor al 51% en Carolina del Sur,

- **Corrected:**

  > y del 50% o menos en Carolina del Sur (Nelson v. Concrete Supply Co.),

#### ES-ES2 · apply

- **Post / URL / surface:** 4899 · `/es/practice-areas/electric-scooter-accident-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 4088 `/practice-areas/electric-scooter-accident-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > menos del 51% en Carolina del Sur)

- **Corrected:**

  > 50% o menos en Carolina del Sur, Nelson v. Concrete Supply Co.)

#### ES-ATV1 · apply

- **Post / URL / surface:** 4900 · `/es/practice-areas/atv-side-by-side-accident-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 4089 `/practice-areas/atv-side-by-side-accident-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > y menor al 51% en Carolina del Sur.

- **Corrected:**

  > y del 50% o menos en Carolina del Sur (Nelson v. Concrete Supply Co.).

#### ES-GC1 · apply

- **Post / URL / surface:** 4901 · `/es/practice-areas/golf-cart-accident-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 4090 `/practice-areas/golf-cart-accident-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > y menor al 51% en Carolina del Sur.

- **Corrected:**

  > y del 50% o menos en Carolina del Sur (Nelson v. Concrete Supply Co.).

#### ES-PI2 · apply

- **Post / URL / surface:** 5200 · `/es/practice-areas/personal-injury-lawyers/` · FAQ[2] (`_roden_faqs[2]`), also FAQPage JSON-LD (batch field `faq2`). EN twin: 4692 `/practice-areas/personal-injury-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn. EN 4692 faq2 = PB-F1.
- **Live:**

  > y en Carolina del Sur si tuvo menos del 51%, con la compensación reducida

- **Corrected:**

  > y en Carolina del Sur si tuvo el 50% o menos (Nelson v. Concrete Supply Co.), con la compensación reducida

#### ES-PI3 · apply

- **Post / URL / surface:** 5200 · `/es/practice-areas/personal-injury-lawyers/` · FAQ[2] (`_roden_faqs[2]`), also FAQPage JSON-LD (batch field `faq2`). EN twin: 4692 `/practice-areas/personal-injury-lawyers/`.
- **Authority:** `GA 51-12-33`, `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** EN PB-F1 wording.
- **Live:**

  > Al llegar al 50% en Georgia o al 51% en Carolina del Sur, la ley cierra la puerta por completo.

- **Corrected:**

  > Con el 50% o más de la culpa en Georgia, o con más del 50% en Carolina del Sur, la ley cierra la puerta por completo.

#### ES-PI6 · apply

- **Post / URL / surface:** 5200 · `/es/practice-areas/personal-injury-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 4692 `/practice-areas/personal-injury-lawyers/`.
- **Authority:** `Nelson v. Concrete Supply Co.`
- **Rule that caught it:** engine `authority-quantity` warn (GA 51-12-33 bound to "51%")
- **Why:** SC comparative-fault wording aligned to the house Nelson wording ('50% or less'), as on the EN pillars 2026-09-29 (PB-F class). 'menos del 51%' is not false for whole percentages but reads as a floor; engine authority-quantity warn.
- **Live:**

  > y en Carolina del Sur si tuvo menos del 51%, aunque

- **Corrected:**

  > y en Carolina del Sur si tuvo el 50% o menos (Nelson v. Concrete Supply Co.), aunque

### N. Med-mal expert-affidavit wording aligned to the EN twin

#### ES-MM4 · apply

- **Post / URL / surface:** 4881 · `/es/practice-areas/medical-malpractice-lawyers/` · FAQ[2] (`_roden_faqs[2]`), also FAQPage JSON-LD (batch field `faq2`). EN twin: 3608 `/practice-areas/medical-malpractice-lawyers/`.
- **Authority:** `SC 15-36-100`, `SC 15-79-125`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Not false; aligned to the EN 3608 faq2 wording (PB-MM2).
- **Live:**

  > y Carolina del Sur exige un proceso previo similar con declaración de experto.

- **Corrected:**

  > y Carolina del Sur exige presentar, antes de la demanda, un Aviso de Intención de Demandar junto con la declaración jurada de un experto calificado (S.C. Code §§ 15-36-100, 15-79-125).

#### ES-MM6 · apply

- **Post / URL / surface:** 4881 · `/es/practice-areas/medical-malpractice-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3608 `/practice-areas/medical-malpractice-lawyers/`.
- **Authority:** `SC 15-36-100`, `SC 15-79-125`
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Alignment with ES-MM4 and EN M-MM1.
- **Live:**

  > Carolina del Sur exige un proceso similar de presentación previa con declaración de experto.

- **Corrected:**

  > Carolina del Sur exige presentar, antes de la demanda, un Aviso de Intención de Demandar con la declaración jurada de un experto calificado (S.C. Code §§ 15-36-100, 15-79-125).

### O. Attorney items carried in the batch (not applied by the builder)

#### ES-WC2 · attorney

- **Post / URL / surface:** 4875 · `/es/practice-areas/workers-compensation-lawyers/` · FAQ[5] (`_roden_faqs[5]`), also FAQPage JSON-LD (batch field `faq5`). EN twin: 3610 `/practice-areas/workers-compensation-lawyers/`.
- **Authority:** none in a signed pack (see note)
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Occupational-disease triggers: GA § 34-9-281 not in pack (and has an outer limit after last exposure); SC 42-15-40 signed only as two years from the accident. Same open items as EN PB-WC2 (Eric Roden) and PB-WC3 (Gillin), which are still live on EN 3610. Clean cut unless both sign.
- **Live:**

  > En enfermedades ocupacionales, en Georgia el año empieza a correr cuando usted supo o debió saber que la condición era de trabajo, y en Carolina del Sur los dos años corren desde la fecha de la incapacidad o desde el día en que un médico le informó de la condición.

- **Corrected:**

  > (cut: delete the sentence)

#### ES-WC4 · attorney

- **Post / URL / surface:** 4875 · `/es/practice-areas/workers-compensation-lawyers/` · FAQ[4] (`_roden_faqs[4]`), also FAQPage JSON-LD (batch field `faq4`). EN twin: 3610 `/practice-areas/workers-compensation-lawyers/`.
- **Authority:** none in a signed pack (see note)
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** In SC a contractor can be the statutory employer (SC 42-1-400/-410 signed); whether that makes it immune from suit is not signed. GA § 34-9-11 (pending) also excludes co-employees. Same open item as EN 3610 faq5 (not changed on EN). Gillin + Eric Roden.
- **Live:**

  > (un subcontratista, un conductor negligente o el fabricante de un equipo defectuoso)

- **Corrected:**

  > (por ejemplo, un conductor negligente o el fabricante de un equipo defectuoso)

#### ES-WC5 · attorney

- **Post / URL / surface:** 4875 · `/es/practice-areas/workers-compensation-lawyers/` · body (`post_content`) (batch field `content`). EN twin: 3610 `/practice-areas/workers-compensation-lawyers/`.
- **Authority:** none in a signed pack (see note)
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Same statutory-employer item as ES-WC4.
- **Live:**

  > — por ejemplo, un subcontratista o el fabricante de una máquina defectuosa —

- **Corrected:**

  > — por ejemplo, un conductor negligente o el fabricante de una máquina defectuosa —

#### ES-MM5 · attorney

- **Post / URL / surface:** 4881 · `/es/practice-areas/medical-malpractice-lawyers/` · FAQ[2] (`_roden_faqs[2]`), also FAQPage JSON-LD (batch field `faq2`). EN twin: 3608 `/practice-areas/medical-malpractice-lawyers/`.
- **Authority:** none in a signed pack (see note)
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** EN M-MM2 open item: § 9-11-9.1 is not in the GA pack and dismissal is curable in some cases. Eric Roden.
- **Live:**

  > Sin ese respaldo experto, el caso se desestima.

- **Corrected:**

  > Sin ese respaldo experto, el caso puede ser desestimado.

#### ES-NH2 · attorney

- **Post / URL / surface:** 4897 · `/es/practice-areas/nursing-home-abuse-lawyers/` · FAQ[7] (`_roden_faqs[7]`), also FAQPage JSON-LD (batch field `faq7`). EN twin: 3619 `/practice-areas/nursing-home-abuse-lawyers/`.
- **Authority:** none in a signed pack (see note)
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Gross negligence is not enough for GA punitive damages (§ 51-12-5.1(b), pending) and SC's standard is recklessness, wilfulness or malice (only the WD form, § 15-51-40, is signed). EN 3619 faq5 carries the same. Eric Roden + Gillin.
- **Live:**

  > Cuando la conducta de la instalación fue intencional, temeraria o gravemente negligente, pueden otorgarse daños punitivos.

- **Corrected:**

  > Cuando la conducta de la instalación fue intencional o temeraria, pueden otorgarse daños punitivos.

#### ES-PI5 · attorney

- **Post / URL / surface:** 5200 · `/es/practice-areas/personal-injury-lawyers/` · FAQ[5] (`_roden_faqs[5]`), also FAQPage JSON-LD (batch field `faq5`). EN twin: 4692 `/practice-areas/personal-injury-lawyers/`.
- **Authority:** none in a signed pack (see note)
- **Rule that caught it:** none. Found by reading (the engine is silent)
- **Why:** Same punitive-standard item as ES-NH2 (GA § 51-12-5.1(b) pending; SC standard not signed). EN 4692 faq5 and the compensation intros carry it.
- **Live:**

  > Y los daños punitivos por conducta gravemente negligente o intencional,

- **Corrected:**

  > Y los daños punitivos por conducta intencional o temeraria,

## META fixes (not in the batch; the applier cannot write these keys)

These need a `bin/` patcher in the `bin/fix-pillar-meta-2026-09-29.php` pattern: exact-match `str_replace`, `update_post_meta( wp_slash() )` and a read-back. Then regenerate `content/meta.json`.

| # | Post / key | Live | Corrected | Authority | Class |
|---|---|---|---|---|---|
| M-ES-WD1 | 4882 `_roden_why_hire` | "calculamos el valor completo de la vida de su ser querido — ingresos futuros, cuidado de los hijos, compañía —" | "calculamos todo lo que la ley permite reclamar por la pérdida de su ser querido — ingresos futuros, cuidado de los hijos, compañía y, en Georgia, el valor completo de su vida —" | GA 51-4-1, SC 15-51-40 | apply |
| M-ES-PI1 | 5200 `_roden_pillar_negligence_intro` | "y la negligencia médica exige una declaración jurada de un experto presentada junto con la demanda" | "y la negligencia médica exige desde el inicio la declaración jurada de un experto calificado" | SC 15-36-100, SC 15-79-125 (in SC the affidavit goes with the Notice of Intent, before suit; the EN intro says "contemporaneous") | apply |
| M-ES-PI2 | 5200 `_roden_pillar_negligence_intro` | "y en Carolina del Sur si tuvo 51% o más" | "y en Carolina del Sur si tuvo más del 50%" | Nelson | apply (alignment; not false) |
| M-ES-PI3 | 5200 `_roden_pillar_compensation_intro` | "Los daños punitivos sí están limitados por ley en {state_full}, con excepciones importantes para productos defectuosos y para conducta relacionada con la intoxicación." | "Los daños punitivos sí están limitados por ley en {state_full}, con excepciones importantes.{{GA}} En Georgia incluyen los productos defectuosos y la conducta bajo los efectos del alcohol o drogas (O.C.G.A. § 51-12-5.1).{{/GA}}{{SC}} En Carolina del Sur incluyen la intención de causar daño, una condena por delito grave derivada de la conducta y la alteración por alcohol o drogas (S.C. Code § 15-32-530).{{/SC}}" | SC 15-32-530 (the SC branch). The GA branch restates already-published GA text resting on pending `GA 51-12-5.1`. | apply for SC. The GA branch is attorney (Eric Roden). |
| M-ES-PI4 | 5200 both intros | "cuando la conducta fue gravemente negligente o intencional, daños punitivos" | "cuando la conducta fue intencional o temeraria, daños punitivos" | none signed (see ES-NH2) | attorney |

- **M-ES-PI3** is rendered with `{state_full}` = South Carolina on SC intersections. There it tells a reader that SC has a product-liability exception, which the signed § 15-32-530 claim does not contain.
- **M-ES-PI3 and M-ES-PI4 are EN parity.** 4692 carries the identical English sentences.
- Confirm that the ES intro renderer honours `{{GA}}`/`{{SC}}` blocks before shipping M-ES-PI3. The EN intros use them; the ES intro has none today.

**META noted, no change:**
- 4881 `_roden_why_hire` cites O.C.G.A. § 9-11-9.1. That section is unsigned; it is the same open item as EN M-MM2 (Eric Roden).
- 4882 FAQ[0] and body give the GA order of plaintiffs. It rests on § 51-4-2, which is not in the pack (EN T-WD2, Eric Roden).

## TEMPLATE and es_ES.mo issues (theme PR; described separately as asked)

Each item was confirmed on the rendered ES pages on 2026-09-30.

| # | Where | What renders on /es/ | Why it matters | Fix |
|---|---|---|---|---|
| **T-ES1** | `inc/template-tags.php:1632` `roden_what_to_do_steps_es_ready` allowlist = `workers-compensation-lawyers` only | **22 of 23** ES pillars show the generic motor-vehicle checklist: "Garantice la seguridad y llame al 911… Intercambie información con todas las partes… número de placa… No admita culpa". It also goes into HowTo schema. | **Wrongful death** (4882) tells a grieving family to exchange plates with the other driver. **Med mal** (4881) gives crash steps. The EN twins have practice-specific steps (confirmed on the EN WD and med-mal pages). This is a legal-framing error, not just a missing translation. | Translate the curated sets and add the slugs to the allowlist, wrongful-death and medical-malpractice first. The EN med-mal step carries §§ 15-79-125, 15-36-100 (T-MM1, signed). The EN WD step 1 carries § 51-4-2 (unsigned: Eric Roden; ship the Spanish without the cite or wait). |
| **T-ES2** | `inc/template-tags.php:2186` (`'%s law requires accident reports…'` with `$state_label` = `__( 'State' )`), and `es_ES.po:3760` `msgid "State"` → `msgstr "La ley estatal"` | "**La ley de La ley estatal exige reportes de accidente…**" on the same 22 pages, and in HowTo schema | Garbled Spanish in a legal sentence, published twice. | Give the stateless branch its own msgid (`'State law requires accident reports…'` → "La ley estatal exige reportes de accidente…"), and stop sprintf-ing `__( 'State' )` into "La ley de %s". Recompile `.mo`. |
| **T-ES3** | `templates/template-practice-area.php:356` | WC ES pillar: "If you miss the filing deadline, your claim will be barred and you will permanently lose the right to pursue benefits. Because the employer-notice deadline comes first…" in **English** | A deadline warning left untranslated. The msgid is missing from `es_ES.po`. | Add the msgid. Suggested msgstr: "Si no presenta su reclamo dentro del plazo, el reclamo quedará prohibido y perderá para siempre el derecho a recibir beneficios. Como el plazo para avisar a su empleador llega primero y es mucho más corto, conviene hablar con un abogado en cuanto se lesione." |
| **T-ES4** | `inc/template-tags.php:617`, `:627` (hard-coded, no `__()`); case-result labels | "Results shown are gross settlement/verdict amounts before fees and costs. Past results do not guarantee similar outcomes." and "$27,000,000 Settlement \| Truck Accident" in English on all 23 | The results disclaimer is untranslated on Spanish pages. That is an advertising-rule concern next to prior results. | Wrap the string in `__()`, add the ES msgstr, and translate the type labels. |
| **T-ES5** | `inc/template-tags.php:1424` `roden_deadline_badges_sidebar()` uses `$statute['state_full']` from `firm-data.php` | "**South Carolina:** S.C. Code § 15-3-530" in the sidebar of every ES pillar | Untranslated state label. On WC the SC line is a bare cite with no duration (the T-WC3 class for SC). | Translate the label (`__( $state_full )`, or an ES field in firm-data). |
| **T-ES6** | `templates/template-practice-area.php` WC sol-card headings | "Plazo para Presentar su **Demanda** en Georgia / Carolina del Sur" on the WC pillar | "Demanda" means lawsuit; a WC claim is a "reclamo". This is the tort-framing class the EN side fixed. | msgstr → "Plazo para Presentar su Reclamo en …" |
| **T-ES7** | bottom CTA msgid | WC ES: "Si usted resultó lesionado y **cree que otra parte tiene la culpa**…". WD ES: "Si usted resultó lesionado…" | WC tort leakage and WD "injured" framing. Same class as the EN intersection CTA (2026-09-26), unfixed on both languages. | WC and WD branches, EN and ES. |
| **T-ES8** | WD comparison table SC SOL cell (`inc/template-tags.php:3672`, EN T-WD1) | "3 años desde la fecha del fallecimiento (S.C. Code § 15-3-530)" | The signed claim carries no death-based start. | **Gillin.** When EN T-WD1 ships, update the ES msgstr in the same PR. |
| **T-ES9** (EN parity) | WC steps 2–3 (the GA panel-of-physicians rule), and HowTo | "Su empleador debe tener publicado un panel de médicos…" on the two-state WC pillar | A Georgia-only rule (§ 34-9-201, not in the pack) stated for both states. In SC the employer selects the physician. The EN twin says the same. | State branch; **Eric Roden** for the GA wording. |
| **T-ES10** (EN parity) | WC comparison table | "No es un factor, salvo mala conducta intencional o intoxicación (O.C.G.A. § 34-9-17)" and "(O.C.G.A. §§ 34-9-11, 34-9-261)" | This cites **pending** `GA 34-9-17` and `GA 34-9-11`. The standing decision is never to cite § 34-9-17 until it is signed. | **Eric Roden** signs `GA 34-9-17` / `GA 34-9-11`, or the cells drop the cites. |
| T-ES11 | `inc/template-tags.php:1242` `roden_last_updated_date()` | "Última actualización: **July 6, 2026**" next to "Última revisión: 3 de agosto de 2026" | English month, and two different dates for one page (`post_modified` vs `_roden_last_reviewed`). Not legal, but a freshness signal that contradicts itself. | `date_i18n` with the ES locale, and one date source. |
| T-ES12 | `templates/template-practice-area.php:161` `.matrix-url` | "/es-workers-compensation-lawyers/savannah-ga/" printed as text | A path that does not exist. Cosmetic. | Print the real permalink path, or drop the span on ES. |

## Diff against the EN twins

**Corrected on EN through 2026-09-29 but still live on the ES twin:** all fixed in this batch.

| EN fix (2026-09-29) | ES survivor | Batch id |
|---|---|---|
| PB-WC1, flat § 34-9-82 | 4875 FAQ[5], body | ES-WC1, ES-WC3 |
| PB-MM1, repose "absolute" | 4881 FAQ[1], body (and GA run from the act) | ES-MM1, ES-MM2 |
| PB-MM2 / M-MM1, SC affidavit + NOI | 4881 FAQ[2], body | ES-MM4, ES-MM6 |
| **PB-MM3, SC med-mal caps** | 4881 FAQ[5]: the ES says there is **no** cap | ES-MM3 |
| PB-WD1, "from the date of death" | 4882 FAQ[2], body; 4897 FAQ[3] | ES-WD1, ES-WD2, ES-NH3 |
| PB-WD2, § 51-4-2 → § 51-4-1 | 4882 FAQ[6] | ES-WD3 |
| PB-WD4 and PB-F1…F6, SC "51%" | 28 strings on 17 twins | group M, and ES-BT1 |
| PB-BI1, discovery rule | 4890 FAQ[6] | ES-BI1 |
| PB-PED4, "tolled until 18" | 4878 FAQ[8]; 4880 FAQ[8] | ES-PED4, ES-DOG1 |
| PB-BK1, "generally interpreted as 3 feet" | 4898 FAQ[5] | ES-BK1 |
| Part A decisions A1 (boating) and A2 (product) | 4895 body; 4892 FAQ[2], body | ES-BT1, ES-PL1, ES-PL2 |

**Also on the ES twin with no EN counterpart:**
- The ES WD FAQ[2] and body add a criminal-case tolling example for both states (ES-WD1/2).
- The ES product FAQ[2] invents a "mayor parte" test (ES-PL1).
- The ES WC and construction bodies cite § 42-15-20 for the SC filing deadline (ES-WC3, ES-CON1).

**EN residuals found in passing** (live on the EN pillars today; not in this batch because the scope was ES). Each has the same fix as its ES counterpart:

| EN post / field | Live | Class | ES counterpart |
|---|---|---|---|
| 3621 FAQ[4] | GA government claims "must be filed under the Georgia Tort Claims Act (§ 50-21-20)" | wrong act for city/county roads | ES-PED3 |
| 3606 FAQ[1], FAQ[7] | GA "ante litem notice within 12 months" for government property / sidewalks | municipal-ante-litem-12-months | ES-SF3 |
| 4087 FAQ[4] | "Georgia's or South Carolina's Tort Claims Act procedures with specific notice deadlines" | SCTCA notice | ES-ES3 |
| 4088 FAQ[5]; 4090 FAQ[5] | "shorter notice deadlines may apply under the state tort claims acts" | SCTCA notice (hedged) | ES-ES3 |
| 4692 FAQ[1] | "Claims against government entities require shorter pre-suit notice." | SCTCA notice | ES-PI1 |
| 4692 FAQ[5] | SC punitive exceptions "for product liability" | SC 15-32-530 | ES-PI4 |
| 3611 FAQ[2] | "the statute may be tolled until the child reaches the age of majority" | minors | ES-DOG1 |
| 3609 FAQ[3]; 3616 FAQ[8]; 3619 FAQ[5] | "full value of the deceased's life" for both states | full value on SC | ES-WD5, ES-BT2, ES-NH1 |
| 3619 FAQ[5] | punitive for "grossly negligent" conduct | punitive standard | ES-NH2 |
| 3609 `_roden_common_injuries` | full value cited to § 51-4-2 | cite | ES-WD3 |

**EN parity items that are attorney questions on both languages** (not batched):
- The WC/construction/spinal/burn "subcontratista / contratista general / dueño del proyecto" as third parties. In SC these can be the statutory employer (`SC 42-1-400/-410` signed; immunity unsigned). Gillin and Eric Roden.
- The construction FAQ[5] OSHA violation "puede establecer negligencia per se" (EN 3618 FAQ[3]).
- The boating FAQ[6] no-wake violation "constituye negligencia per se" (EN 3616 FAQ[6]).
- The product FAQ[9] "estatuto de reposo varía según el tipo de producto" for SC (EN 3615 FAQ[2]).
- The nursing-home FAQ[5] implies a discovery start: "un abogado puede ayudarle a determinar cuándo empezó a correr el plazo" (EN 3619 FAQ[1]). This is the open nursing-home SOL question.
- The nursing-home FAQ[8] cites 42 CFR § 483.70(o). The arbitration paragraph's current letter should be verified against eCFR; it has been redesignated before.
- The pedestrian FAQ[7] "En Georgia la cobertura PIP es opcional" (EN 3621 FAQ[6]).
- The ATV FAQ[5] cites "O.C.G.A. § 40-7-120 et seq."; the EN negligence intro says § 40-7-1 et seq.
- The WC FAQ[6] (§ 34-9-201 panel) and FAQ[8] (the GA 25% fee cap) are unsigned but not contradicted.
- The truck FAQ[6] federal $750,000 minimum has no pack authority (federal claims are not in either pack).

---

# PART B: post 1874, `/blog/georgia-car-seat-law-overview/` (live, GA-only, author Eric Roden)

- **Surfaces:**
  - body
  - `post_excerpt`, which is also the BlogPosting `description` and equals `_roden_meta_description`
  - `_roden_key_takeaways`, which renders as the box above the article
  - `_roden_faqs` (5), which is also FAQPage JSON-LD (5 entries, matching)
- **Stamps:** `_roden_last_reviewed` 2026-08-31, `_roden_last_refreshed` 2026-08-25, published 2016-04-07.
- **Checked against:** § 40-8-76 as read in `ga-statute-currency-2026-09-30.md` (Justia 2025; history ends Ga. L. 2011, CONFIRMED CURRENT) and `remediation-2026-09-30-ga-resources.md` (CS-1, CS-2, CS-A1…A6).

## Verdict: FAIL on one class (the missing physician's-statement exception). Correct on everything else asked about.

| Item asked about | 1874 says | Verdict |
|---|---|---|
| "Other children under eight" for the front-seat exception | "occupied by **other children**" in the body, KT and FAQ[1] | **Correct.** The CS-1 error is not here. |
| Physician's-statement exception, (b)(1)(D) | **Missing.** The body says "There are **exactly two** exceptions"; the KT and FAQ[1] say front seat "**only if**"; the body says "Georgia gives **two paths** out" | **Error (CS-1 class).** CS1874-1…4, 6, 7 |
| 40-lb myth | Debunked correctly, and the lap-belt conditions match (b)(1)(A)(i)–(ii), including "not counting the driver's seat" | **Correct.** Engine control `carseat-40lb-front-seat` fires on the myth; the page is silent. |
| Fines | "not more than $50.00 … not more than $100.00 … no court shall impose additional fees or surcharges" | **Correct** ((b)(2)) |
| Negligence per se | "(c) … shall not constitute negligence per se nor contributory negligence per se". The table says "Admissible? GA: No statutory bar". | **Correct**, and it respects CS-A2 (not "inadmissible") |
| Seat belts without SB 69 | "Senate Bill 68 changed its evidentiary rule in 2025. That change applies to safety belts…" | **Incomplete (warn).** It states no rule, but it names SB 68 only and omits the "commenced on or after 2025-04-21" limit that SB 69 § 5(c)(2) imposes. CS1874-5. |
| SC law on a GA page | Body table and FAQ[4] quote S.C. Code § 56-5-6460 as a labelled comparison | **Correct** against signed `SC 56-5-6460`. The engine raises `cross-SC-on-GA` (warn ×2). See "False positives". |

**Advisory (1874):**
- The scope omits the taxicab / public-transit exclusion ((b)(1)).
- The installation requirement ((b)(1)(C), "in accordance with the manufacturer's directions") is omitted. The page only advises following the seat's limits (CS-2 class).
- "Keep children under 13 in the back seat" and the belt-fit sentences are labelled NHTSA safety guidance. That is acceptable as labelled; the draft deliberately carries no NHTSA claim.

## 1874 edits (in the batch file; 1 apply, 6 attorney)

#### CS1874-1 · apply

- **Surface:** body (`post_content`) (batch field `content`)
- **Authority:** `GA 40-8-76`
- **Rule that caught it:** none. Found by reading
- **Why:** "Exactly two exceptions" is false: § 40-8-76(b)(1)(D) exempts a child whose parent or guardian holds a physician's written statement. The rewording drops "exactly" and asserts nothing beyond the signed claim (the front-seat exception turns on rear-seat availability).
- **Live:**

  > `There are exactly two exceptions, and both are about seating availability:`

- **Corrected:**

  > `The statute allows a front seat in two situations, both about seating availability:`

#### CS1874-2 · attorney

- **Surface:** body (`post_content`) (batch field `content`)
- **Authority:** statute text (§ 40-8-76 / SB 69), not a signed pack claim
- **Rule that caught it:** none. Found by reading
- **Why:** CS-1 class. § 40-8-76(b)(1)(D), statute-text verified (Justia 2025, history ends Ga. L. 2011); not in the signed GA pack claim, so Eric Roden approves the wording (same pending item as draft CS-1d).
- **Live:**

  > `</ul>\n<p><strong>There is no weight threshold`

- **Corrected:**

  > `</ul>\n<p>Separately, the requirement does not apply when a parent or guardian obtains a physician&rsquo;s written statement that a physical or medical condition of the child prevents restraining the child in the way the statute requires.</p>\n<p><strong>There is no weight threshold`

#### CS1874-3 · attorney

- **Surface:** body (`post_content`) (batch field `content`)
- **Authority:** statute text (§ 40-8-76 / SB 69), not a signed pack claim
- **Rule that caught it:** none. Found by reading
- **Why:** Pairs with CS1874-4 (the medical path).
- **Live:**

  > `Georgia gives two paths out of the child-restraint requirement:`

- **Corrected:**

  > `Georgia gives three paths out of the child-restraint requirement:`

#### CS1874-4 · attorney

- **Surface:** body (`post_content`) (batch field `content`)
- **Authority:** statute text (§ 40-8-76 / SB 69), not a signed pack claim
- **Rule that caught it:** none. Found by reading
- **Why:** § 40-8-76(b)(1)(D); same as CS1874-2.
- **Live:**

  > `rather than a child restraint.</li>\n</ul>`

- **Corrected:**

  > `rather than a child restraint.</li>\n<li><strong>Medical</strong> &mdash; the requirement does not apply when a parent or guardian obtains a physician&rsquo;s written statement that a physical or medical condition of the child prevents restraining the child as the statute requires.</li>\n</ul>`

#### CS1874-5 · attorney

- **Surface:** body (`post_content`) (batch field `content`)
- **Authority:** statute text (§ 40-8-76 / SB 69), not a signed pack claim
- **Rule that caught it:** none. Found by reading
- **Why:** SB 69 § 5(c)(2) limits the revised § 40-8-76.1(d) to causes of action commenced on or after 2025-04-21, and the Code editor's note says SB 69 governs (ga-statute-currency-2026-09-30.md § 2). The signed GA 40-8-76.1 claim lacks the qualifier; a pack PR is pending. Warn-level: the page states no rule, only that one changed.
- **Live:**

  > `Senate Bill 68 changed its evidentiary rule in 2025.`

- **Corrected:**

  > `Senate Bills 68 and 69 changed its evidentiary rule in 2025, for lawsuits commenced on or after April 21, 2025.`

#### CS1874-6 · attorney

- **Surface:** key takeaway (`_roden_key_takeaways`) (batch field `takeaways`)
- **Authority:** statute text (§ 40-8-76 / SB 69), not a signed pack claim
- **Rule that caught it:** none. Found by reading
- **Why:** KT "only if" is false where a physician's statement applies. § 40-8-76(b)(1)(D); Eric Roden.
- **Live:**

  > `there is no weight condition for riding in front.`

- **Corrected:**

  > `there is no weight condition for riding in front. A physician&rsquo;s written statement that a physical or medical condition of the child prevents the required restraint is a separate exception.`

#### CS1874-7 · attorney

- **Surface:** FAQ[1] (`_roden_faqs[1]`), also FAQPage JSON-LD (batch field `faq1`)
- **Authority:** statute text (§ 40-8-76 / SB 69), not a signed pack claim
- **Rule that caught it:** none. Found by reading
- **Why:** Same, in FAQ[1] and FAQPage JSON-LD.
- **Live:**

  > `are occupied by other children. There is no weight threshold`

- **Corrected:**

  > `are occupied by other children. A physician's written statement that a medical condition of the child prevents the required restraint is a separate exception. There is no weight threshold`

## For the 301 decision: 1874 vs the draft `/resources/georgia-car-seat-laws/`

**What 1874 says that the draft does not:**
1. **The Georgia-vs-South-Carolina comparison.** It has a table and FAQ[4] on S.C. Code § 56-5-6460, where a SC violation is not admissible at all, and it links to the SC car-seat guide. The draft has no South Carolina content at all (0 mentions).
2. "Georgia's statute does not divide childhood into named stages". The draft instead carries a stage table labelled as guidance.
3. "Keep children under 13 in the back seat" (NHTSA, labelled guidance). The draft deliberately has no NHTSA claim.
4. The explicit sentence that the 2025 change "applies to safety belts, not to the child-restraint requirement in § 40-8-76". The draft covers seat belts in its own FAQ with the SB 69 limit.
5. Age and authority: published 2016-04-07 under Eric Roden, so it likely holds the older backlinks.

**What the draft has that 1874 lacks:**
- the physician's-statement exception
- the taxicab / public-transit exclusion
- the SB 69 "commenced on or after 2025-04-21" limit
- the § 9-3-33 two-year deadline
- a fee FAQ

**Recommendation for the owner.** 301 1874 to the resource once the draft publishes. Before that, carry the SC comparison (item 1) into the draft as a short labelled paragraph citing signed `SC 56-5-6460`, or accept losing it and link the SC guide instead.
- Until the redirect, apply CS1874-1 (apply) now. Put CS1874-2…7 in Eric Roden's packet next to draft CS-1. They are the same wording question.

---

# Replay

**ES twins** (`scratchpad/es/replay.mjs`, direct `sweepDocument` on body, excerpt, FAQs and meta description, jurisdiction `both`, both packs):

| Set | Findings | Warnings |
|---|---:|---:|
| Before (live) | 0 | 23 (`authority-quantity` GA 51-12-33) |
| After all 58 ES apply edits | **0** | **0** |
| English controls, one per missed class | **8/8 fired** across 6 controls | 0 |

- **The controls:** `sctca-mandatory-notice` + `sctca-notice-phrases`, `sc-medmal-cap-denied`, `sc-punitive-floor-unindexed`, `wc-deadline-cited-to-tort-statute` + `SC 15-3-530` context, `ga-medmal-discovery-rule` and `municipal-ante-litem-12-months`. Each fired on the English sentence whose Spanish counterpart was silent. That is the gap stated in "Engine baseline".
- **Wording note:** the first draft of ES-MM3 wrote "$1.05 millones". That raised `authority-quantity` on SC 15-32-220, because the pack allows `$1,050,000`, not "$1.05". The batch uses `$1,050,000`.

**FAQ gate** (`verify-faq-drafts.mjs --client roden … --migrate`, all 214 ES answers against their bodies):
- **Before: 44 failures. After: 39. The corrections introduce no new failure.**
- The 5 that cleared are the ungrounded "$350,000" (4881), the `GA 50-21-20` citation (4878, 4879), the `GA 51-4-2` citation (4882), and "51%" (4882).
- The 39 that remain are on untouched text. 18 are "10 FAQs (house pattern is 4-8)". The rest are EN-parity unregistered cites (§§ 34-9-201, 51-3-1, 51-1-11, 15-73-10, 52-7-8.2, 50-21-145, 40-7-120, 51-12-5.1) and example figures ($100,000/$70,000, $750,000, 25%, 60%, 20%).

**Post 1874** (`scratchpad/es/r1874.mjs`, jurisdiction `georgia-only`, all four surfaces):
- Before and after all 7 edits: 0 findings, 2 warnings (`cross-SC-on-GA`, the labelled comparison).
- The control `carseat-40lb-front-seat` fires.

**Applier dry run against prod** (read-only; no `apply` argument). `python3 bin/build-linked-pages-batch.py data/facts/es-pillars-batch-2026-09-30.json` embedded 59 apply edits. `wp eval-file -` then printed "Would fix: 59 edits across 23 posts" with **no abort**, so every apply `from` matched live exactly once.
- **To apply** (owner's call): build to a runnable script, then `ssh $H "wp --path=$P eval-file - apply" < run.php > docs/backups/es-pillars-batch-2026-09-30.json`. Regenerate `content/meta.json` afterwards.
- **Note:** `bin/apply-linked-pages-batch.php` hard-codes `'batch' => 'linked-pages-batch-2026-09-28'` in its backup header. That is cosmetic; rename it for this run if you want the backup self-describing.

# Counts

**Batch `es-pillars-batch-2026-09-30.json`: 71 entries on 23 posts** (22 ES twins + 1874).

| Class | ES twins | 1874 | Total |
|---|---:|---:|---:|
| apply | 58 | 1 | 59 |
| attorney | 6 | 6 | 12 |

- **ES surfaces:** 40 FAQ answers (each also FAQPage JSON-LD) and 24 bodies. Neither the excerpt nor the title changes.
- **1874 surfaces:** 5 body, 1 key takeaway, 1 FAQ.

**By rule:**

| Rule | Entries |
|---|---:|
| engine `authority-quantity` (warn), GA 51-12-33 bound to "51%" | 24 (the group M and ES-BT1 entries on the 23 warned surfaces; 4 more in group M were missed) |
| no rule (reading only) | 47 (40 ES + 7 on 1874) |
| engine error-level findings | 0 |

**Not batchable:**
- 5 META (M-ES-WD1, M-ES-PI1…4)
- 12 TEMPLATE (T-ES1…12)
- 10 EN residuals, listed for the next EN batch

# False positives

- **None in the rule sense.** Every `authority-quantity` warning on the ES twins pointed at a real wording issue (group M).
- **1874 `cross-SC-on-GA` (warn ×2)** is correct behaviour: SC law on a GA-only page. The page deliberately compares the two states, and the SC statement matches signed `SC 56-5-6460`. The decision is editorial and tied to the 301, so no `contextUnless` is proposed. If the owner keeps the comparison long-term, add a fixture control ("unlike South Carolina, where … § 56-5-6460 …") before any guard.

# Open attorney items raised here

**Gillin (SC):**
- ES-WC2: the occupational-disease trigger (with EN PB-WC3)
- ES-WC4/5: statutory-employer immunity for a subcontracting contractor or owner
- ES-NH2 / ES-PI5 / M-ES-PI4: the punitive conduct standard (is "gross negligence" enough?)
- T-ES8: § 15-3-530(6) "upon the death" (EN T-WD1)
- the SC product repose statement
- SC § 15-3-535 discovery and § 15-3-40 minors, if the pages are to state either

**Eric Roden (GA):**
- ES-WC2 (§ 34-9-281)
- ES-WC4/5 (§ 34-9-11 co-employees)
- ES-MM5 (§ 9-11-9.1 dismissal)
- ES-NH2 / ES-PI5 / M-ES-PI3 GA branch (§ 51-12-5.1)
- § 9-3-99 criminal-case tolling, if 4882 should say it for Georgia
- § 51-4-2 order of plaintiffs (4882 FAQ[0] and body; EN T-WD2)
- T-ES9 / T-ES10 (§§ 34-9-201, 34-9-17, 34-9-11 in the WC template)
- 1874 CS1874-2…7: the physician's-statement exception and the SB 69 limit. These are the same pending wording as draft CS-1 and the GA 40-8-76.1 pack amendment.
