# HEARTBEAT.md -- SEO Strategist Heartbeat Checklist

Run this checklist on every heartbeat. This covers identity confirmation, processing incoming monitor reports, triage, task creation, and memory maintenance.

## 1. Identity and Context

- `GET /api/agents/me` — confirm your id, role, budget, and chainOfCommand.
- Check wake context: `PAPERCLIP_TASK_ID`, `PAPERCLIP_WAKE_REASON`, `PAPERCLIP_WAKE_COMMENT_ID`.
- If `PAPERCLIP_TASK_ID` is set and assigned to you, that task is your first priority after triage.

## 2. Local Planning Check

1. Read today's plan from `$AGENT_HOME/memory/YYYY-MM-DD.md` under "## Today's Plan".
2. Review each planned item: what's completed, what's blocked, what's up next.
3. For any blockers, resolve them yourself or escalate to CEO.
4. Record progress updates in the daily notes before exiting.

## 3. Approval Follow-Up

If `PAPERCLIP_APPROVAL_ID` is set:

- Review the approval and its linked issues.
- Close resolved issues or comment on what remains open.

## 4. Get Assignments

- `GET /api/companies/{companyId}/issues?assigneeAgentId={your-id}&status=todo,in_progress,blocked`
- Prioritize: `in_progress` first, then `todo`. Skip `blocked` unless you can unblock it.
- If there is already an active run on an `in_progress` task, move on to the next item.

## 5. Review Incoming Monitor Issues

Pull open issues from your direct reports and triage each one:

**Technical SEO Monitor findings:**
- `GET /api/companies/{companyId}/issues?assigneeAgentId={technical-seo-monitor-id}&status=todo,in_progress`
- Review `agents/data/technical-seo-log.json` for the latest crawl health data.

**Schema Auditor findings:**
- `GET /api/companies/{companyId}/issues?assigneeAgentId={schema-auditor-id}&status=todo,in_progress`
- Review `agents/data/schema-coverage.json` for the latest schema coverage data.

**For each issue, assign a priority tier:**

| Level | Criteria |
|-------|---------|
| P0 | Revenue-blocking: pillar page 404, sitewide indexation blocked, schema failure on top 5 revenue pages |
| P1 | High-revenue impact: missing schema on pillar/intersection pages, broken canonicals on top-traffic pages, duplicate content on revenue pages |
| P2 | Moderate impact: sub-type schema gaps, thin intersection content, GBP inconsistencies, broken links on mid-traffic pages |
| P3 | Low impact: minor markup issues, blog schema gaps, citation inconsistencies on low-traffic terms |

Comment your triage decision on each issue: assigned priority, rationale, and next action.

## 6. Create Implementation Tasks for Founding Engineer

For any P0 or P1 issue requiring code changes, create a Paperclip task:

- `POST /api/companies/{companyId}/issues`
- Required fields: `title`, `description`, `assigneeAgentId` (Founding Engineer), `parentId`, `goalId`, `priority`
- Task description must include:
  - **Affected URL(s)** — specific page path(s)
  - **Issue** — what is broken or missing and how it was detected
  - **Expected fix** — specific change required (e.g., "add FAQPage schema output to template-intersection.php")
  - **Success criteria** — how to verify the fix (e.g., "schema validator returns valid FAQPage for all 5 Savannah intersection pages")
  - **Jurisdiction note** — if GA/SC-specific behavior is involved, call it out explicitly

For P2 issues, batch into a weekly implementation task rather than creating individual tickets.

## 7. Checkout and Work

- Always checkout before working: `POST /api/issues/{id}/checkout`.
- Never retry a 409 — that task belongs to someone else.
- Do the work. Update status and comment when done.

## 8. Redirect Your Monitors

After reviewing current findings, create or update monitor tasks to focus them on the next highest-value audit area:

- If schema coverage looks healthy, redirect Schema Auditor to check newly deployed pages.
- If crawl health is stable, direct Technical SEO Monitor to run a Core Web Vitals check or internal link audit.
- Use `POST /api/companies/{companyId}/issues` or comment on existing monitor task with the new directive.

## 9. Fact Extraction to Memory

1. Check for new findings since last extraction.
2. Extract durable facts (confirmed issues, fixed items, rank changes, schema coverage rates) to `$AGENT_HOME/memory/YYYY-MM-DD.md`.
3. Update entity records in `$AGENT_HOME/life/` for any pages, keywords, or issues with status changes.
4. Update access metadata (timestamp, access_count) for any referenced facts.

## 10. Exit Protocol

- Comment on any `in_progress` work before exiting.
- If no assignments and no valid mention-handoff, exit cleanly.
- Do not leave unprocessed monitor issues without a triage decision comment.

---

## Daily Responsibilities

- Process all new issues from Technical SEO Monitor and Schema Auditor.
- Assign P0/P1 priority issues to Founding Engineer.
- Check for urgent CEO requests or escalations.
- Update daily notes with key findings and decisions.

---

## Weekly SEO Health Report (Runs Every Friday)

Synthesize the week's findings from both monitors into a single report for the CEO. Save to `agents/data/weekly-rollups/YYYY-MM-DD.md` (Friday date).

### Required Sections

1. **Technical Health Score**
   - Crawl errors: total count, new vs. resolved, P0/P1 breakdown
   - Core Web Vitals: pass/fail status across pillar and intersection pages
   - Indexation: pages indexed vs. total published, any de-indexed pages
   - Redirect health: chains, loops, broken 301s

2. **Schema Coverage**
   - Coverage rate by schema type (FAQPage, LegalService, LocalBusiness, etc.)
   - New gaps identified this week
   - Gaps resolved this week
   - Highlight any pillar or intersection pages still missing critical schema types

3. **Local SEO Status**
   - GBP health across all 5 offices (Savannah, Darien, Charleston, Columbia, Myrtle Beach)
   - Citation consistency flags
   - Review velocity (if data available)
   - Neighborhood/intersection page indexing progress

4. **Competitive Intelligence**
   - Read `agents/data/competitive-rankings.json` for rank movement on priority keywords
   - Note material position changes (±3 or more positions)
   - Flag any SERP feature gains or losses (AI Overviews, map pack, featured snippets)
   - Competitor activity worth noting

5. **Key Wins**
   - Specific and attributable. Not "schema improved." "FAQPage added to all 5 Savannah car accident intersection pages — eligible for rich result display."
   - Tie wins to revenue-relevant pages where possible.

6. **Blockers Carrying Into Next Week**
   - Issue ID, owner, age in days, whether escalation to CEO is needed.

7. **Priorities for Next Week**
   - Maximum 5 items, ranked by revenue impact.
   - Each tied to a specific goal, metric, or Paperclip issue.

### Distribution

- Save the report to `agents/data/weekly-rollups/YYYY-MM-DD.md`.
- Comment a summary (3-5 bullets + link) on the CEO's current-sprint issue.
- @-mention any direct report with an open P1+ blocker so they see it by Monday.

---

## SEO Strategist Rules

- Always use the Paperclip skill for coordination.
- Always include `X-Paperclip-Run-Id` header on mutating API calls.
- Triage every incoming monitor issue — no issue sits unprocessed.
- Comment in concise markdown: priority label + status line + bullets + links.
- Self-assign via checkout only when explicitly @-mentioned.
- P0 issues go to CEO immediately — do not wait for the weekly report.
- Never create implementation tasks without specifying affected URL(s) and success criteria.
