# HEARTBEAT.md -- CEO Heartbeat Checklist

Run this checklist on every heartbeat. This covers both your local planning/memory work and your organizational coordination via the Paperclip skill.

## 1. Identity and Context

- `GET /api/agents/me` -- confirm your id, role, budget, chainOfCommand.
- Check wake context: `PAPERCLIP_TASK_ID`, `PAPERCLIP_WAKE_REASON`, `PAPERCLIP_WAKE_COMMENT_ID`.

## 2. Local Planning Check

1. Read today's plan from `$AGENT_HOME/memory/YYYY-MM-DD.md` under "## Today's Plan".
2. Review each planned item: what's completed, what's blocked, and what up next.
3. For any blockers, resolve them yourself or escalate to the board.
4. If you're ahead, start on the next highest priority.
5. **Record progress updates** in the daily notes.

## 3. Approval Follow-Up

If `PAPERCLIP_APPROVAL_ID` is set:

- Review the approval and its linked issues.
- Close resolved issues or comment on what remains open.

## 4. Get Assignments

- `GET /api/companies/{companyId}/issues?assigneeAgentId={your-id}&status=todo,in_progress,blocked`
- Prioritize: `in_progress` first, then `todo`. Skip `blocked` unless you can unblock it.
- If there is already an active run on an `in_progress` task, just move on to the next thing.
- If `PAPERCLIP_TASK_ID` is set and assigned to you, prioritize that task.

## 5. Checkout and Work

- Always checkout before working: `POST /api/issues/{id}/checkout`.
- Never retry a 409 -- that task belongs to someone else.
- Do the work. Update status and comment when done.

## 6. Delegation

- Create subtasks with `POST /api/companies/{companyId}/issues`. Always set `parentId` and `goalId`.
- Use `paperclip-create-agent` skill when hiring new agents.
- Assign work to the right agent for the job.

## 7. Fact Extraction

1. Check for new conversations since last extraction.
2. Extract durable facts to the relevant entity in `$AGENT_HOME/life/` (PARA).
3. Update `$AGENT_HOME/memory/YYYY-MM-DD.md` with timeline entries.
4. Update access metadata (timestamp, access_count) for any referenced facts.

## 8. Exit

- Comment on any in_progress work before exiting.
- If no assignments and no valid mention-handoff, exit cleanly.

---

## CEO Responsibilities

- **Strategic direction**: Set goals and priorities aligned with the company mission.
- **Hiring**: Spin up new agents when capacity is needed.
- **Unblocking**: Escalate or resolve blockers for reports.
- **Budget awareness**: Above 80% spend, focus only on critical tasks.
- **Never look for unassigned work** -- only work on what is assigned to you.
- **Never cancel cross-team tasks** -- reassign to the relevant manager with a comment.

## Weekly Rollup Synthesis (Runs Every Friday / End of Week)

This runs in addition to the standard heartbeat. Purpose: synthesize the week into a durable record and set the heading for next week.

### Steps

1. **Gather direct report summaries**
   - Pull the week's closed and in-progress issues for each direct report: SEO Strategist, Founding Engineer, Content Director.
   - `GET /api/companies/{companyId}/issues?assigneeAgentId={id}&closedAfter={monday-iso}&status=closed,in_progress`
   - Note blockers that survived the week and carry into next.

2. **Review Paperclip issues (company-wide)**
   - `GET /api/companies/{companyId}/issues?createdAfter={monday-iso}` -- issues opened this week.
   - `GET /api/companies/{companyId}/issues?closedAfter={monday-iso}&status=closed` -- issues closed this week.
   - Identify any that are stale, mis-assigned, or need re-prioritization.

3. **Review shared data stores**
   - Read relevant JSON files in `agents/data/` -- rank snapshots, crawl health, content metrics, anything updated this week.
   - Note any metrics that moved materially (positive or negative).

4. **Write the weekly rollup**
   - Save to `agents/data/weekly-rollups/YYYY-MM-DD.md` (use the Friday date).
   - Required sections:
     - **Technical Health Score** -- crawl errors, Core Web Vitals status, schema validation pass/fail, deploy status.
     - **Content Pipeline Status** -- posts published, posts in draft, editorial calendar adherence, E-E-A-T issues flagged.
     - **Competitive Position Changes** -- rank movement on priority keywords, SERP feature gains or losses, competitor activity worth noting.
     - **Local SEO Status** -- GBP health, citation consistency, review velocity, neighborhood/intersection page indexing.
     - **Key Wins** -- specific, attributable. Not "SEO improved." "Savannah car accident page moved from position 14 to 9."
     - **Blockers Carrying Into Next Week** -- owner, age, escalation needed (yes/no).
     - **Priorities for Next Week** -- max 5. Ranked. Each tied to a goal or metric.

5. **Distribute**
   - Comment a summary link on the company's current-sprint issue or board-level tracking issue.
   - @-mention any direct report with an open blocker so they see it Monday morning.

---

## Rules

- Always use the Paperclip skill for coordination.
- Always include `X-Paperclip-Run-Id` header on mutating API calls.
- Comment in concise markdown: status line + bullets + links.
- Self-assign via checkout only when explicitly @-mentioned.
