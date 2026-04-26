# Paperclip Bootstrap — Roden Law SEO Agent Company

> **Instructions for CEO agent:** Read this file and execute each section in order using the Paperclip API. This creates the full company structure, registers all agents, and sets up the coordination system.

---

## 1. Create Company

```
POST /api/companies
{
  "name": "Roden Law SEO",
  "description": "Autonomous SEO monitoring and optimization system for Roden Law (rodenlaw.com) — a personal injury law firm serving Georgia and South Carolina across 5 office locations. 450+ pages, 12 schema types, three-tier URL architecture."
}
```

Save the returned `companyId` — all subsequent calls use it.

---

## 2. Register Agents (10 total)

Register each agent in order. The `chainOfCommand` field defines the reporting hierarchy.

### 2.1 CEO

```
POST /api/companies/{companyId}/agents
{
  "name": "CEO",
  "role": "chief-executive",
  "description": "Strategic oversight, priority arbitration, weekly rollup synthesis. Owns P&L and final decision authority.",
  "heartbeat": "daily",
  "cronExpression": "0 10 * * *",
  "homeDirectory": "agents/ceo",
  "chainOfCommand": []
}
```

### 2.2 SEO Strategist

```
POST /api/companies/{companyId}/agents
{
  "name": "SEO Strategist",
  "role": "director-seo",
  "description": "Director managing Technical SEO Monitor and Schema Auditor. Prioritizes technical fixes, synthesizes weekly SEO reports for CEO. Expert in Local SEO and AI-SEO for personal injury law.",
  "heartbeat": "daily",
  "cronExpression": "0 10 * * *",
  "homeDirectory": "agents/seo-strategist",
  "chainOfCommand": ["{ceo-agent-id}"]
}
```

### 2.3 Founding Engineer

```
POST /api/companies/{companyId}/agents
{
  "name": "Founding Engineer",
  "role": "engineer",
  "description": "Sole agent with write access to the roden-law WordPress theme codebase. Executes all implementation tasks — PHP templates, schema, CSS/JS, WP Engine deployment.",
  "heartbeat": "on-demand",
  "cronExpression": null,
  "homeDirectory": "agents/founding-engineer",
  "chainOfCommand": ["{ceo-agent-id}"]
}
```

### 2.4 Content Director

```
POST /api/companies/{companyId}/agents
{
  "name": "Content Director",
  "role": "director-content",
  "description": "Director managing Local Q&A Scout and Content Refresher. Creates content briefs, maintains editorial calendar, manages internal linking strategy and FAQ coverage across 177 practice area pages.",
  "heartbeat": "72h",
  "cronExpression": "0 8 */3 * *",
  "homeDirectory": "agents/content-director",
  "chainOfCommand": ["{ceo-agent-id}"]
}
```

### 2.5 Technical SEO Monitor

```
POST /api/companies/{companyId}/agents
{
  "name": "Technical SEO Monitor",
  "role": "monitor-technical-seo",
  "description": "Infrastructure watchdog. Monitors crawlability, indexation, Core Web Vitals, broken links, redirect chains, sitemap health across 450+ pages on WP Engine.",
  "heartbeat": "48h",
  "cronExpression": "0 6 */2 * *",
  "homeDirectory": "agents/technical-seo-monitor",
  "chainOfCommand": ["{seo-strategist-agent-id}", "{ceo-agent-id}"]
}
```

### 2.6 Schema Auditor

```
POST /api/companies/{companyId}/agents
{
  "name": "Schema Auditor",
  "role": "auditor-schema",
  "description": "Validates 12 JSON-LD schema types, identifies missing opportunities, ensures Google structured data compliance, optimizes for AI citation readiness.",
  "heartbeat": "weekly",
  "cronExpression": "0 7 * * 2",
  "homeDirectory": "agents/schema-auditor",
  "chainOfCommand": ["{seo-strategist-agent-id}", "{ceo-agent-id}"]
}
```

### 2.7 Local Q&A Scout

```
POST /api/companies/{companyId}/agents
{
  "name": "Local Q&A Scout",
  "role": "scout-qa",
  "description": "Discovers questions people ask about personal injury law in GA/SC markets. Mines PAA, Reddit, forums. Identifies FAQ gaps across 22 practice areas x 5 cities (110 combinations).",
  "heartbeat": "72h",
  "cronExpression": "0 9 */3 * *",
  "homeDirectory": "agents/local-qa-scout",
  "chainOfCommand": ["{content-director-agent-id}", "{ceo-agent-id}"]
}
```

### 2.8 Content Refresher

```
POST /api/companies/{companyId}/agents
{
  "name": "Content Refresher",
  "role": "auditor-content",
  "description": "Audits existing 450+ pages for staleness, statute accuracy, internal linking gaps, keyword cannibalization, thin content. Rotates through 18 practice area clusters.",
  "heartbeat": "weekly",
  "cronExpression": "0 8 * * 4",
  "homeDirectory": "agents/content-refresher",
  "chainOfCommand": ["{content-director-agent-id}", "{ceo-agent-id}"]
}
```

### 2.9 Competitor Intelligence

```
POST /api/companies/{companyId}/agents
{
  "name": "Competitor Intelligence",
  "role": "analyst-competitive",
  "description": "Tracks competing PI firms across 5 markets. Monitors rankings, content gaps, backlink opportunities, AI Overview presence. Dual-reports to SEO Strategist (strategy) and Founding Engineer (implementation).",
  "heartbeat": "weekly",
  "cronExpression": "0 7 * * 3",
  "homeDirectory": "agents/competitor-intelligence",
  "chainOfCommand": ["{seo-strategist-agent-id}", "{founding-engineer-agent-id}", "{ceo-agent-id}"]
}
```

### 2.10 Citation & GBP Monitor

```
POST /api/companies/{companyId}/agents
{
  "name": "Citation & GBP Monitor",
  "role": "monitor-local-seo",
  "description": "Local SEO specialist. Audits NAP consistency across directories for all 5 Roden Law offices, monitors GBP signals, tracks review counts, monitors local pack positions.",
  "heartbeat": "weekly",
  "cronExpression": "0 7 * * 6",
  "homeDirectory": "agents/citation-gbp-monitor",
  "chainOfCommand": ["{seo-strategist-agent-id}", "{founding-engineer-agent-id}", "{ceo-agent-id}"]
}
```

---

## 3. Create Goals (4 top-level objectives)

```
POST /api/companies/{companyId}/goals
{
  "name": "Local SEO Dominance",
  "slug": "local-seo-dominance",
  "description": "Dominate local pack rankings across all 5 office markets. Ensure NAP consistency, GBP optimization, citation coverage, and review velocity.",
  "ownerAgentId": "{seo-strategist-agent-id}",
  "metrics": [
    "Local pack position for top 22 PA keywords x 5 cities",
    "NAP accuracy rate across all directories (target: 100%)",
    "Review count growth (target: 500+ on Google per office)",
    "Citation coverage (target: present on all major legal directories)"
  ]
}
```

```
POST /api/companies/{companyId}/goals
{
  "name": "AI-SEO Visibility",
  "slug": "ai-seo-visibility",
  "description": "Maximize Roden Law's presence in AI-generated answers (AI Overviews, ChatGPT, Perplexity). Ensure schema compliance, speakable content, and citation-ready FAQ answers.",
  "ownerAgentId": "{seo-strategist-agent-id}",
  "metrics": [
    "Schema validation pass rate (target: 100% of pages)",
    "Rich Results eligibility for all practice area pages",
    "AI Overview citation count for tracked keywords",
    "FAQ AI-citation readiness score (target: 8+/10 average)"
  ]
}
```

```
POST /api/companies/{companyId}/goals
{
  "name": "Content Authority",
  "slug": "content-authority",
  "description": "Build unassailable topical authority for personal injury law in GA and SC. Close content gaps, maintain freshness, maximize internal linking equity.",
  "ownerAgentId": "{content-director-agent-id}",
  "metrics": [
    "Content gap coverage (target: 0 high-value gaps)",
    "Average word count per practice area page (target: 1500+)",
    "Internal links per page (target: 8+ inbound)",
    "Content decay rate (target: 0 pages with 30%+ impression decline)",
    "FAQ coverage (target: 6+ per practice area page)"
  ]
}
```

```
POST /api/companies/{companyId}/goals
{
  "name": "Technical Health",
  "slug": "technical-health",
  "description": "Maintain perfect technical SEO foundation. Zero crawl errors, full indexation, fast page speeds, clean redirect chains, accessible to all crawlers.",
  "ownerAgentId": "{seo-strategist-agent-id}",
  "metrics": [
    "Indexed pages vs total pages (target: 100%)",
    "GSC crawl errors (target: 0)",
    "Core Web Vitals pass rate (target: 100% Good)",
    "Redirect chain count (target: 0 chains > 2 hops)",
    "Internal 404s (target: 0)",
    "AI crawler access (GPTBot, ClaudeBot, PerplexityBot all allowed)"
  ]
}
```

---

## 4. Create Labels (8 issue labels)

```
POST /api/companies/{companyId}/labels
[
  { "name": "technical-seo",    "color": "#E74C3C", "description": "Crawlability, indexation, speed, redirects, sitemap issues" },
  { "name": "schema",           "color": "#9B59B6", "description": "JSON-LD structured data validation, compliance, and optimization" },
  { "name": "content",          "color": "#3498DB", "description": "New content creation, content briefs, FAQ additions" },
  { "name": "content-refresh",  "color": "#2ECC71", "description": "Existing content updates, staleness fixes, statute verification" },
  { "name": "competitor-intel", "color": "#F39C12", "description": "Competitive analysis findings, ranking changes, gap opportunities" },
  { "name": "local-seo",        "color": "#1ABC9C", "description": "NAP consistency, GBP, citations, local pack, reviews" },
  { "name": "qa-discovery",     "color": "#34495E", "description": "New questions discovered from PAA, Reddit, forums" },
  { "name": "quick-win",        "color": "#E67E22", "description": "Low-effort, high-impact optimization opportunities (positions 4-10)" }
]
```

---

## 5. Create Priority Levels

If Paperclip supports custom priority definitions:

```
POST /api/companies/{companyId}/priorities
[
  { "level": "P0", "name": "Revenue-Impacting",  "description": "Broken pages, deindexed content, wrong NAP data. Fix within 24 hours.", "sla_hours": 24 },
  { "level": "P1", "name": "Ranking-Impacting",  "description": "Missing schema, content gaps for high-value keywords, CWV failures. Fix within 72 hours.", "sla_hours": 72 },
  { "level": "P2", "name": "Optimization",        "description": "Content refresh, new FAQs, citation submissions, internal linking. Fix within 1 week.", "sla_hours": 168 },
  { "level": "P3", "name": "Nice-to-Have",         "description": "Minor enhancements, cosmetic improvements, low-traffic page updates. Fix when capacity allows.", "sla_hours": null }
]
```

---

## 6. Seed Initial Issues (optional — kickstart the first cycle)

These seed issues give each agent something to work on during their first heartbeat.

### Technical SEO Monitor — first audit

```
POST /api/companies/{companyId}/issues
{
  "title": "[technical-seo] Initial full-site technical SEO baseline audit",
  "body": "## Task\nRun the complete HEARTBEAT.md checklist for the first time. Establish baselines for:\n- Indexed page count in GSC\n- Core Web Vitals for all 22 pillar pages\n- robots.txt AI crawler directives\n- Sitemap completeness\n- Legacy redirect chain health (all 122 rules)\n- Internal link 404 sample\n\n## Expected Output\n- Populated `agents/data/technical-seo-log.json` with baseline data\n- Paperclip issues for any P0/P1 findings\n\n## Priority\nP1 — establishes the monitoring baseline",
  "labels": ["technical-seo"],
  "priority": "P1",
  "assigneeAgentId": "{technical-seo-monitor-agent-id}",
  "goalId": "{technical-health-goal-id}"
}
```

### Schema Auditor — first audit

```
POST /api/companies/{companyId}/issues
{
  "title": "[schema] Initial schema coverage baseline audit",
  "body": "## Task\nRun the complete HEARTBEAT.md checklist for the first time. Validate JSON-LD on one page of each type:\n- Homepage (Organization, LawFirm, WebSite, AggregateRating)\n- Pillar practice area (LegalService, FAQPage, BreadcrumbList, Speakable)\n- Intersection page (LegalService, LocalBusiness)\n- Sub-type page (LegalService)\n- Location page (LocalBusiness)\n- Attorney page (Person)\n- Blog post (Person author schema)\n\n## Expected Output\n- Populated `agents/data/schema-coverage.json`\n- Paperclip issues for any missing required fields or compliance gaps\n\n## Priority\nP1 — establishes the schema baseline",
  "labels": ["schema"],
  "priority": "P1",
  "assigneeAgentId": "{schema-auditor-agent-id}",
  "goalId": "{ai-seo-visibility-goal-id}"
}
```

### Local Q&A Scout — first discovery run

```
POST /api/companies/{companyId}/issues
{
  "title": "[qa-discovery] Initial Q&A discovery for top 3 practice areas",
  "body": "## Task\nRun first discovery cycle for the 3 highest-value practice area × city combos:\n1. car-accident-lawyers × savannah-ga\n2. truck-accident-lawyers × charleston-sc\n3. wrongful-death-lawyers × columbia-sc\n\nFor each, extract PAA questions, search Reddit, cross-reference existing FAQs.\n\n## Expected Output\n- Populated `agents/data/qa-discoveries.json`\n- Paperclip issues for high-value Q&A gaps (score >= 6)\n\n## Priority\nP2 — content opportunity discovery",
  "labels": ["qa-discovery"],
  "priority": "P2",
  "assigneeAgentId": "{local-qa-scout-agent-id}",
  "goalId": "{content-authority-goal-id}"
}
```

### Citation & GBP Monitor — first office audit

```
POST /api/companies/{companyId}/issues
{
  "title": "[local-seo] Initial NAP audit — Savannah office",
  "body": "## Task\nDeep-audit the Savannah GA office (primary/HQ) as the first rotation cycle.\n\nCanonical data:\n- Name: Roden Law — Savannah\n- Address: 333 Commercial Dr., Savannah, GA 31406\n- Phone: (912) 303-5850\n\nCheck: Avvo, Martindale-Hubbell, FindLaw, Justia, Super Lawyers, Yelp, BBB, Google Maps.\n\n## Expected Output\n- Populated `agents/data/citation-inventory.json` for Savannah\n- Paperclip issues for any NAP discrepancies (P0 for wrong data)\n\n## Priority\nP1 — NAP accuracy directly impacts local rankings",
  "labels": ["local-seo"],
  "priority": "P1",
  "assigneeAgentId": "{citation-gbp-monitor-agent-id}",
  "goalId": "{local-seo-dominance-goal-id}"
}
```

### Competitor Intelligence — first competitive scan

```
POST /api/companies/{companyId}/issues
{
  "title": "[competitor-intel] Initial competitor identification across 5 markets",
  "body": "## Task\nIdentify the top 5-8 competing PI firms in each of the 5 office markets:\n- Savannah, GA\n- Darien, GA (Brunswick/Golden Isles area)\n- Charleston, SC\n- Columbia, SC\n- Myrtle Beach, SC\n\nSearch for '[practice area] lawyer [city]' for the top 5 practice areas. Record firm names, domains, and initial ranking positions.\n\n## Expected Output\n- Populated `agents/data/competitive-rankings.json` with competitor list\n- Initial keyword position snapshot for top 10 keywords per market\n\n## Priority\nP2 — establishes competitive baseline",
  "labels": ["competitor-intel"],
  "priority": "P2",
  "assigneeAgentId": "{competitor-intelligence-agent-id}",
  "goalId": "{content-authority-goal-id}"
}
```

### Content Refresher — first cluster audit

```
POST /api/companies/{companyId}/issues
{
  "title": "[content-refresh] Initial content health audit — Car Accident cluster",
  "body": "## Task\nDeep-audit the Car Accident Lawyers cluster (highest-value practice area):\n- Pillar: /practice-areas/car-accident-lawyers/\n- All 5 intersection pages (savannah-ga, darien-ga, charleston-sc, columbia-sc, myrtle-beach-sc)\n- All sub-type pages (drunk-driver, rear-end, head-on, etc.)\n\nCheck: word count, statute citations, FAQ count, internal links, E-E-A-T attribution, firm stats.\n\n## Expected Output\n- Populated `agents/data/content-health.json` for car-accident cluster\n- Paperclip issues for any thin content, missing citations, or linking gaps\n\n## Priority\nP2 — establishes content health baseline for highest-traffic cluster",
  "labels": ["content-refresh"],
  "priority": "P2",
  "assigneeAgentId": "{content-refresher-agent-id}",
  "goalId": "{content-authority-goal-id}"
}
```

---

## 7. Verify Setup

After completing steps 1-6, verify:

- [ ] `GET /api/companies/{companyId}` returns company details
- [ ] `GET /api/companies/{companyId}/agents` returns all 10 agents with correct chain of command
- [ ] `GET /api/companies/{companyId}/goals` returns all 4 goals
- [ ] `GET /api/companies/{companyId}/labels` returns all 8 labels
- [ ] `GET /api/companies/{companyId}/issues` returns all 6 seed issues with correct assignments
- [ ] Each agent can call `GET /api/agents/me` and see their role, budget, and chain of command
- [ ] Cron expressions are registered and will fire on schedule

---

## 8. Agent Home Directory Map

After registration, update each agent's `AGENTS.md` with their Paperclip agent ID so they can reference it in API calls.

| Agent | Home Directory | Cron |
|-------|---------------|------|
| CEO | `agents/ceo` | `0 10 * * *` (daily 10am) |
| SEO Strategist | `agents/seo-strategist` | `0 10 * * *` (daily 10am) |
| Founding Engineer | `agents/founding-engineer` | on-demand |
| Content Director | `agents/content-director` | `0 8 */3 * *` (every 72h) |
| Technical SEO Monitor | `agents/technical-seo-monitor` | `0 6 */2 * *` (every 48h) |
| Schema Auditor | `agents/schema-auditor` | `0 7 * * 2` (Tue 7am) |
| Local Q&A Scout | `agents/local-qa-scout` | `0 9 */3 * *` (every 72h) |
| Content Refresher | `agents/content-refresher` | `0 8 * * 4` (Thu 8am) |
| Competitor Intelligence | `agents/competitor-intelligence` | `0 7 * * 3` (Wed 7am) |
| Citation & GBP Monitor | `agents/citation-gbp-monitor` | `0 7 * * 6` (Sat 7am) |

---

## Org Chart Reference

```
                          ┌──────────┐
                          │   CEO    │
                          └────┬─────┘
                               │
            ┌──────────────────┼──────────────────┐
            │                  │                  │
   ┌────────▼────────┐  ┌─────▼──────┐  ┌────────▼────────┐
   │ SEO Strategist  │  │ Founding   │  │   Content       │
   │                 │  │ Engineer   │  │   Director      │
   └──┬──────────┬───┘  └────────────┘  └──┬──────────┬───┘
      │          │                         │          │
┌─────▼───┐ ┌───▼────────┐        ┌───────▼───┐ ┌───▼──────────┐
│Technical│ │  Schema    │        │ Local Q&A │ │  Content     │
│SEO Mon. │ │  Auditor   │        │ Scout     │ │  Refresher   │
└─────────┘ └────────────┘        └───────────┘ └──────────────┘

        ┌─────────────┐    ┌──────────────────┐
        │ Competitor  │    │ Citation & GBP   │
        │ Intelligence│    │ Monitor          │
        └─────────────┘    └──────────────────┘
        (dual-reports to     (dual-reports to
         SEO Strategist +     SEO Strategist +
         Founding Engineer)   Founding Engineer)
```
