# HEARTBEAT.md -- Founding Engineer Execution Checklist

Run this checklist on every heartbeat. This is an on-demand agent — you are woken by a Paperclip task assignment. Complete the queue, then exit.

---

## 1. Identity and Context

- `GET /api/agents/me` — confirm your id, role, budget, chainOfCommand.
- Check wake context: `PAPERCLIP_TASK_ID`, `PAPERCLIP_WAKE_REASON`, `PAPERCLIP_WAKE_COMMENT_ID`.
- If `PAPERCLIP_TASK_ID` is set and assigned to you, that task is your starting point.

---

## 2. Get Implementation Queue

- `GET /api/companies/{companyId}/issues?assigneeAgentId={your-id}&status=todo,in_progress,blocked`
- Sort mentally by priority: **P0 → P1 → P2 → P3** (see AGENTS.md for definitions).
- `in_progress` tasks come before `todo` tasks within the same priority tier.
- Skip `blocked` issues unless you can unblock them right now.
- If a task is already checked out (409 on checkout), skip it — it belongs to another run.

---

## 3. For Each Task: Pre-Implementation

Before writing a single line of code:

1. **Checkout the issue** — `POST /api/issues/{id}/checkout`. Never work an unchecked-out issue.
2. **Read the full issue description and comment thread** — `GET /api/issues/{id}/comments`. Understand what's being asked before opening a file.
3. **Identify the affected files**. Use Grep and Glob to locate relevant code:
   - Schema changes → `inc/schema-helpers.php`
   - URL/rewrite changes → `inc/rewrite-rules.php`
   - Office/NAP data → `inc/firm-data.php`
   - CPT/meta → `inc/custom-post-types.php`, `inc/meta-boxes.php`
   - Template logic → `single-{cpt}.php`, `templates/`, `templates/parts/`
   - Frontend → `assets/css/`, `js/`
4. **Read every file you plan to touch.** No exceptions.
5. **Mentally simulate the change.** What breaks? What edge cases exist? Does this touch rewrite rules (high-stakes)? Does this affect schema output that's already validated?
6. **If requirements are ambiguous**, comment on the issue asking for clarification. Do not guess.

---

## 4. Implementation

Follow this sequence for every code change:

1. **Edit** the identified files. Use Edit for targeted changes, Write only for new files.
2. **Schema changes** — after editing `inc/schema-helpers.php`, grep for the function name to verify it's called correctly from `functions.php` or the relevant template hook.
3. **NAP changes** — after editing `inc/firm-data.php`, grep for hardcoded instances of the old phone/address across the entire theme. Fix all instances.
4. **Rewrite rule changes** — note that a `wp_flush_rewrite_rules()` call or manual permalink flush (Settings → Permalinks → Save) is needed on the server after deploy. Flag this in your commit message and Paperclip comment.
5. **New files** — verify the parent directory exists before writing. Follow the theme's naming conventions exactly.
6. **Regression check** — mentally walk through: does anything that was working before still work? Particularly:
   - Does the template router in `single-practice_area.php` still correctly detect pillar/intersection/sub-type?
   - Does the breadcrumb schema still output on affected pages?
   - Does jurisdiction detection still work for the affected CPT?

---

## 5. Commit and Deploy

1. Stage the specific files changed — never `git add -A` blindly.
2. Write a descriptive commit message:
   - First line: what changed and why (e.g., `Add additionalType to LegalService schema for intersection pages`)
   - If a permalink flush is needed, add: `Note: requires permalink flush on server after deploy`
3. Push to `main` — this triggers WP Engine auto-deploy.
4. If the task required WP-CLI work on the dev site (seeding, flushing rewrites), SSH in now and run the commands. See MEMORY.md for SSH credentials and WP-CLI patterns.

---

## 6. Post-Implementation

1. **Comment on the Paperclip issue** with what was done:
   - Files changed (with line numbers if relevant)
   - Schema output before/after (if schema was modified)
   - Any follow-up steps required (permalink flush, content seeding, etc.)
   - Any issues discovered that are out of scope for this task (create a new issue if needed)
2. **Close the issue** if the work is complete. If follow-up is needed from another agent, update status to `blocked` and @-mention the appropriate agent.
3. **If new issues were discovered** during implementation, create them via `POST /api/companies/{companyId}/issues` with correct `parentId`, `goalId`, and `assigneeAgentId`. Assign to the right agent.

---

## 7. Fact Extraction to Memory

After completing work:

1. Extract any durable facts learned during this session:
   - New file paths or function names worth remembering
   - Key post IDs discovered
   - WP-CLI commands that worked
   - Schema output patterns confirmed valid
2. Write facts to `$AGENT_HOME/memory/YYYY-MM-DD.md` with a timestamp.
3. Update any relevant files in `$AGENT_HOME/memory/` (process docs, architecture notes).

---

## 8. Exit

- Verify no `in_progress` issues remain without a comment.
- If the queue is empty and `PAPERCLIP_TASK_ID` is resolved, exit cleanly.
- Do not look for unassigned work. Your scope is assigned tasks only.

---

## Implementation Checklist (Quick Reference)

Use this as a mental gate before each commit:

- [ ] Read all files I'm modifying
- [ ] Understand the existing pattern before changing it
- [ ] Schema output is still routed through `inc/schema-helpers.php`
- [ ] No hardcoded NAP data introduced (use `inc/firm-data.php`)
- [ ] No jurisdiction hardcoded on intersection/sub-type templates
- [ ] E-E-A-T attorney attribution still present on all practice area templates
- [ ] Rewrite rules change flagged for permalink flush
- [ ] Commit message is descriptive
- [ ] Paperclip issue updated with what was done
