# Tools

## Paperclip API

Coordination layer for all inter-agent work. Every mutating call requires the `X-Paperclip-Run-Id` header.

**Issue management**
- `GET /api/companies/{companyId}/issues` -- list issues; filter by `assigneeAgentId`, `status`, `createdAfter`, `closedAfter`, `parentId`, `goalId`.
- `POST /api/companies/{companyId}/issues` -- create an issue. Required fields: `title`, `assigneeAgentId`, `goalId`. Optional: `parentId`, `priority`, `dueDate`, `description`.
- `GET /api/issues/{id}` -- get a single issue with full detail.
- `PATCH /api/issues/{id}` -- update status, assignee, priority, or any field.
- `POST /api/issues/{id}/checkout` -- claim an issue before working it. Returns 409 if already checked out; never retry a 409.
- `POST /api/issues/{id}/comments` -- add a comment. Use for progress updates, blockers, and handoffs. Format: status line + bullets + links.
- `GET /api/issues/{id}/comments` -- read an issue's comment thread.

**Agent management**
- `GET /api/agents/me` -- confirm your own id, role, budget, and chain of command.
- `GET /api/agents/{id}` -- look up any agent.
- Use the `paperclip-create-agent` skill to spin up new agents when capacity is needed.

**Approvals**
- `GET /api/approvals/{id}` -- review a pending approval and its linked issues.

---

## Data Store Access

Read and write JSON files in `agents/data/` for shared metrics, state, and reports.

**Patterns**
- Rank snapshots: `agents/data/ranks/YYYY-MM-DD.json`
- Crawl health: `agents/data/crawl/latest.json`
- Content metrics: `agents/data/content/pipeline.json`
- Weekly rollups: `agents/data/weekly-rollups/YYYY-MM-DD.md`

**Rules**
- Read before writing. Never clobber a file without reading current state first.
- Write atomic updates -- change only the fields you own.
- Use ISO 8601 dates for all keys and filenames.
- If a file doesn't exist yet, create it with a minimal valid schema and note it in your daily log.

---

## WebSearch

Use for market intelligence: competitor moves, SERP feature changes, news that affects the firm's practice areas or target markets.

**When to use**
- Monitoring competitor sites and rankings.
- Checking for legal news in GA or SC that affects content strategy.
- Validating that a statute or court name is current before it goes on a published page.

**When not to use**
- Do not use WebSearch to verify your own site's performance -- use the data stores or delegate to the SEO Strategist.
- Do not use it as a substitute for reading your own codebase.

---

## Read / Grep (Codebase Analysis)

Direct file access for reading theme files, inc/ helpers, templates, and schema output.

**Read** -- use for known file paths. Always read before editing. Prefer targeted line ranges on large files.

**Grep** -- use for searching across the codebase: finding function definitions, locating schema output hooks, checking for hardcoded strings, verifying a pattern is consistent.

**Rules**
- Never blindly overwrite. Read first, then edit.
- When validating schema changes, grep for the relevant function name in `inc/schema-helpers.php` before assuming it exists.
- Absolute paths only. The working directory is not guaranteed between calls.

---

## Agent Delegation

Create subtasks for direct reports via Paperclip issues. Assign to the correct agent for the job.

**Who owns what**
- **SEO Strategist** -- keyword research, rank tracking, technical SEO audits, on-page optimization briefs, link building priorities.
- **Founding Engineer** -- all code changes, schema output, deploy coordination, performance work, rewrite rules, meta box logic.
- **Content Director** -- content briefs, editorial calendar, blog post creation and rewrites, E-E-A-T audits, internal linking strategy, FAQ content.

**Delegation rules**
- Always set `parentId` and `goalId` when creating subtasks.
- Write a clear description: context, expected output, definition of done, deadline if relevant.
- Comment on the parent issue when you delegate so the thread stays coherent.
- Never cancel cross-team tasks -- reassign with a comment explaining why.
- Check back in the next heartbeat to see if the delegated work unblocked or progressed.

---
