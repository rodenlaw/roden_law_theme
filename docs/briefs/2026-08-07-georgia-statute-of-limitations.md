# Content brief — roden-content-writer

**Page:** Georgia statute of limitations for personal injury (new `resource` page)
**Brief date:** 2026-08-07

> Read this entire file **and** the companion verification record at
> `docs/briefs/2026-08-07-georgia-sol-statute-verification.md` before drafting.
> Write the page per your standard system-prompt patterns — Key Takeaways, According-to
> citations, comparison tables, prose attribution, FAQs, internal links, jurisdiction-stamped
> statutes, Last-reviewed line. **Those rules belong to you; this brief supplies facts.**
> Save to `docs/briefs/drafts/2026-08-07-georgia-statute-of-limitations-draft.md`.
> Claude Code only — no other vendor LLM.

---

## Why this page exists

Roden Law has a South Carolina statute/procedure layer and **nothing equivalent for Georgia**
— no SOL page, no comparative-negligence page, no Georgia personal-injury FAQ. The structural
consequence: every deep statute link on a both-jurisdiction page points to South Carolina,
because there is nothing in Georgia to point at. Georgia is also the firm's home state.

**Read this before you start.** The two SC pages this one parallels earn essentially nothing —
the SC SOL page ranks for 5 keywords (best position 38) with zero traffic; the SC comparative
negligence page ranks for 1 keyword at position 45. They are also thin: 1,397 and 1,065 words,
one table, 4–6 internal links, and no review date. **Do not write a Georgia version of those.**
The demand here is roughly ten times larger and the SERP is beatable, but only by a page that
is genuinely more useful than a blog post.

Target cluster: `statute of limitations georgia` (1,300/mo), `georgia statute of limitations
personal injury` (260/mo, KD 15, **$25.31 CPC**), `georgia personal injury statute of
limitations` (140/mo), plus `ocga 9-3-33`, `georgia ante litem notice`.

The ranking competitors are small Georgia firm **blog posts** plus Justia and FindLaw. Most
were published before Georgia's 2025 tort reform. Two things they consistently omit are where
this page wins: the **workers' comp deadline** and the **ante litem notice** traps.

---

## Page specification

| Field | Value |
|---|---|
| **Page type** | `resource` (CPT) |
| **Slug** | `georgia-statute-of-limitations` |
| **Target URL** | `/resources/georgia-statute-of-limitations/` (verified 404 — free) |
| **SEO title** | Georgia Statute of Limitations for Personal Injury Claims |
| **H1** | How Long Do I Have to File a Personal Injury Claim in Georgia? |
| **Jurisdiction** | `georgia-only` |
| **Attribution** | **Eric Roden** — Founding Partner, Savannah, admitted in Georgia |
| **Word target** | 2,000–2,400 |
| **Primary keyword** | `georgia statute of limitations personal injury` |

### Required frontmatter

```yaml
---
page_type: resource
target_url: /resources/georgia-statute-of-limitations/
jurisdiction: georgia-only
_roden_author_attorney: Eric Roden (Savannah, GA)
primary_keyword: georgia statute of limitations personal injury
word_count: <actual count>
internal_links: <count>
schema_feeds: [Article, FAQPage]
excerpt: "<140-160 char meta description>"
---
```

**Do not set `_roden_is_howto`.** On the truck settlement page it made the theme sweep every
H2/H3 into a 16-step HowTo and dropped the author node from the JSON-LD. Article carries
`author: Person`, which is the signal this page needs.

### Hard jurisdiction rule

This page is `georgia-only`. It must contain **zero `S.C. Code §` citations** — the QA gate
fails on any. Do not compare Georgia to South Carolina anywhere on the page, and do not link
to a South Carolina resource. Georgia law only, start to finish.

---

## The facts — all pre-verified, state them as written

**Everything in `docs/briefs/2026-08-07-georgia-sol-statute-verification.md` was read verbatim
from the code text on 2026-08-07 and may be stated without further checking.** That document
is the authority; this is the summary. Where the two differ, the verification record wins.

Anything **not** in that record — including the four items in its "Not verified" section — must
be verified against primary source before you write it, or omitted. Do not fill a gap from
memory or from a competitor page.

### The core deadlines table — build the page around this

| Claim type | Deadline | Statute |
|---|---|---|
| Personal injury | 2 years from the date of injury | O.C.G.A. § 9-3-33 |
| Injury to reputation (defamation) | 1 year | O.C.G.A. § 9-3-33 |
| Loss of consortium | 4 years | O.C.G.A. § 9-3-33 |
| Damage to personal property (your vehicle) | 4 years | O.C.G.A. § 9-3-32 |
| Damage to real property | 4 years | O.C.G.A. § 9-3-30 |
| Medical malpractice | 2 years, with a 5-year statute of repose | O.C.G.A. § 9-3-71 |
| Workers' compensation | 1 year — see the reset rule below | O.C.G.A. § 34-9-82 |
| Claim against a city | 6-month ante litem notice | O.C.G.A. § 36-33-5 |
| Claim against a county | 12-month presentation | O.C.G.A. § 36-11-1 |
| Claim against the state | 12-month ante litem notice | O.C.G.A. § 50-21-26 |

Note § 9-3-33 produces **three** different deadlines in a single sentence. Competitors cite
only the two years. Say all three.

Note also that a totalled vehicle is **§ 9-3-32 (personal property)**, not § 9-3-30 (realty).
Getting this backwards is a common error.

### The two sections that win this page

**1. Workers' compensation — § 34-9-82.** The tort SOL is not the comp deadline, and the
one-year clock *resets*:

- One year from the injury; **or**
- One year from the **last remedial treatment furnished by the employer**; **or**
- Two years from the **last payment of weekly benefits**
- Death claims: one year from the death
- Separate 30-day **notice** requirement under § 34-9-80, with excuses for incapacity, fraud,
  employer knowledge, or a reasonable excuse without prejudice

This exact confusion already put a live error on 13 pages of this site, which told Georgia
workers they had two years. Treat the reset rule as the section's headline.

**2. Ante litem notice.** For § 36-33-5 (cities), all of the following are verified and nearly
absent from the pages currently ranking:

- Six months from the event to present a **written** claim to the governing authority
- The notice must state the **specific dollar amount of damages sought** — it is an offer of
  compromise and is **not binding** on the claimant later
- The governing authority has 30 days to act
- The statute of limitations is **suspended** while the demand is pending
- Service must be on the **mayor or the chairperson of the city council or commission**,
  personally or by certified mail or statutory overnight delivery

For § 50-21-26 (state), notice goes by certified mail or statutory overnight delivery to the
**Risk Management Division of the Department of Administrative Services**, with a copy to the
state entity, and the complaint must attach the notice and receipt as exhibits or face
dismissal without prejudice if not cured within 30 days.

Make this a second table: government defendant / deadline / who to serve / statute.

### Tolling

- **§ 9-3-90** — minors get the same period after turning 18; legally incompetent persons get
  it after the disability is removed
- **§ 9-3-92** — time between death and appointment of an estate representative doesn't count,
  capped at five years
- **§ 9-3-99** — tort limitations tolled while a criminal prosecution from the same facts is
  pending, capped at six years
- **§ 9-3-73** — med-mal disability rules: a minor under five gets two years from the fifth
  birthday, with hard outer limits at the tenth birthday or five years

### Partial fault — § 51-12-33

Cover the 50% bar here rather than on a separate page; the standalone comparative-negligence
topic does not carry one. Verified: a plaintiff "shall not be entitled to receive any damages
if the plaintiff is 50 percent or more responsible." Damages are otherwise reduced in
proportion to the plaintiff's own fault, apportionment among defendants is **several, not
joint**, and the trier of fact may consider the fault of **nonparties**.

**Georgia's SB 68 (2025) did NOT amend § 51-12-33.** Secondary coverage implies otherwise. Do
not write that the tort reform changed the 50% bar — it cross-references the statute from the
new negligent-security provisions and leaves it intact. If you mention SB 68 at all, the only
safe statements are in the verification record's SB 68 table.

---

## Outline

H2s phrased as questions — that is the best feature of the SC page and it is what gets lifted
into AI answers. Answer-first opener under every one.

1. **`## How long do I have to file a personal injury lawsuit in Georgia?`** (~200w) — two
   years, O.C.G.A. § 9-3-33, from the date of injury. Say it in the first sentence.
2. **`## Georgia filing deadlines by claim type`** (~350w) — the core table plus the prose that
   explains the three deadlines inside § 9-3-33.
3. **`## When does the clock start?`** (~250w) — date of injury is the default. Be careful here:
   Georgia's discovery rule is largely judge-made and was **not verified**. Say only what
   § 9-3-71(a) and § 50-21-26 state on their own terms, and otherwise describe the general rule
   and advise verification. Do not assert a general discovery rule.
4. **`## What if my claim is against a city, county, or the state?`** (~400w) — the ante litem
   section, with its own table. The highest-value section on the page after workers' comp.
5. **`## What is the deadline for a workers' compensation claim?`** (~300w) — the reset rule and
   the 30-day notice. Lead by answering: one year, and it is not the same as the tort deadline.
6. **`## What if the injured person is a minor?`** (~200w) — § 9-3-90 and the med-mal carve-outs
   in § 9-3-73.
7. **`## Does a criminal case against the at-fault driver change my deadline?`** (~200w) —
   § 9-3-99, capped at six years.
8. **`## What if I was partly at fault?`** (~250w) — the 50% bar, § 51-12-33.
9. **`## What happens if I miss the deadline?`** (~200w) — dismissal, loss of leverage, and the
   narrow exceptions that actually exist.
10. **`## Talk to a Georgia injury attorney before your deadline runs`** (~150w) — free
    consultation, contingency fee, firm stats verbatim, Savannah and Darien offices.

Close with a plain prose paragraph, no emoji CTA — the theme adds its own banner.

---

## Citation targets — need ≥4 sentence-initial "According to X"

**No figure is supplied here. Pull the current published number from the source and cite the
edition or year.** If a source is unreachable, substitute another you *can* verify rather than
stating a number you cannot.

| Source | Supports |
|---|---|
| Georgia Governor's Office of Highway Safety | Georgia crash, injury and fatality counts (reachable — used successfully on the truck page) |
| Georgia Department of Transportation | State crash data |
| Georgia State Board of Workers' Compensation | Annual claim volumes, for the workers' comp section |
| National Center for State Courts | Civil caseload / time-to-disposition |
| Insurance Information Institute | Liability claim and litigation context |

FMCSA and NHTSA returned Akamai 403s from this environment on the last build — expect to
substitute. Format: must **start** the sentence with capital `According to` + a capitalized
proper-noun source.

**Firm figures are not third-party sources.** Say plainly that they are the firm's own
reported figures.

---

## Internal links — all 16 verified live (HTTP 200 at the requested URL) on 2026-08-07

Use **8–12**. Georgia targets only — this is a `georgia-only` page.

| Path | Suggested anchor | Purpose |
|---|---|---|
| `/practice-areas/personal-injury-lawyers/` | Georgia personal injury lawyers | Primary pillar up-link |
| `/practice-areas/car-accident-lawyers/` | car accident claims | Most common claim type |
| `/practice-areas/truck-accident-lawyers/` | truck accident claims | Cluster tie-in |
| `/practice-areas/workers-compensation-lawyers/` | Georgia workers' compensation claims | **Required** in the comp section |
| `/practice-areas/medical-malpractice-lawyers/` | medical malpractice claims | Required in the med-mal row |
| `/practice-areas/wrongful-death-lawyers/` | wrongful death claims | Required — but see the caution below |
| `/practice-areas/premises-liability-lawyers/` | premises liability claims | Ante litem tie-in |
| `/resources/truck-accident-settlement-process/` | how to start a truck accident settlement | Newest sibling resource |
| `/resources/georgia-truck-accident-settlement-value/` | what a Georgia truck accident case is worth | Value intent |
| `/resources/georgia-car-accident-settlement-value/` | what a Georgia car accident case is worth | Value intent |
| `/car-accident-lawyers/savannah-ga/` | Savannah car accident lawyers | Office |
| `/truck-accident-lawyers/savannah-ga/` | Savannah truck accident lawyers | Office |
| `/truck-accident-lawyers/darien-ga/` | Darien truck accident lawyers | Office |
| `/locations/georgia/` | our Georgia offices | Location hub |
| `/locations/georgia/savannah/` | Savannah office | Office |
| `/locations/georgia/darien/` | Darien office | Office |

**Do not invent any other internal URL.** If you want one that isn't listed, flag it in your
hand-off instead of guessing.

**Wrongful death caution:** link the practice-area page, but do **not** state a bare "2 years"
for wrongful death. Georgia has no dedicated wrongful-death limitations statute — the period
derives from § 9-3-33 plus case law and can be tolled up to five years by § 9-3-92 while an
estate is unrepresented. Describe the mechanism or omit the row.

---

## FAQs — 6 to 8 pairs

`**Q:**` / `**A:**`. Each answer 50+ words, first 1–2 sentences self-contained and liftable,
jurisdiction-stamped. Phrase them the way a worried person searches:

1. How long do I have to file a personal injury lawsuit in Georgia?
2. What happens if I miss the statute of limitations in Georgia?
3. Is the deadline different if I'm suing a city or a government agency?
4. How long do I have to file a workers' compensation claim in Georgia?
5. Does the deadline change if the accident involved a criminal charge like DUI?
6. What if the injured person is a child?
7. Can I still recover if I was partly at fault?
8. Do I have to file a lawsuit, or is a claim with the insurance company enough?

---

## Cannibalization guard

This page owns **"how long do I have."** It does not own what a case is worth — that belongs to
the two Georgia settlement-value resources. Answer any value question in one sentence and link
out. No H2 on this page may ask what a case is worth.

---

## Hard rules

- Never fabricate a statute number, a statistic, a court, or a case result.
- Zero `S.C. Code §` citations. No South Carolina comparisons or links.
- Do not pad to hit the word count. If short, add genuine depth — the ante litem and workers'
  comp sections can both carry more.
- Do not state that SB 68 changed § 51-12-33. It did not.
- No markdown blockquotes.

## Hand-off report

File written, word count, internal links used (path + anchor), statutes cited, count of
sentence-initial "According to" citations, attorney attributed, and **an explicit list of
anything you could not verify and therefore flagged or omitted.**
