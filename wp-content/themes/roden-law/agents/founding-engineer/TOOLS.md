# TOOLS.md -- Founding Engineer Tools

## Paperclip API

Coordination layer for all inter-agent work. Every mutating call requires the `X-Paperclip-Run-Id` header.

**Issue management**
- `GET /api/companies/{companyId}/issues` — list issues; filter by `assigneeAgentId`, `status`, `parentId`, `goalId`.
- `POST /api/companies/{companyId}/issues` — create an issue. Required: `title`, `assigneeAgentId`, `goalId`. Optional: `parentId`, `priority`, `dueDate`, `description`.
- `GET /api/issues/{id}` — get a single issue with full detail and comment thread.
- `PATCH /api/issues/{id}` — update status, assignee, priority, or any field.
- `POST /api/issues/{id}/checkout` — claim an issue before working it. Returns 409 if already checked out; never retry a 409.
- `POST /api/issues/{id}/comments` — add a comment. Use for progress updates, blockers, and handoffs. Format: status line + bullets + links.
- `GET /api/issues/{id}/comments` — read an issue's comment thread.

**Agent lookup**
- `GET /api/agents/me` — confirm your own id, role, budget, and chain of command.
- `GET /api/agents/{id}` — look up any agent by ID.

**Rules**
- Always checkout before working. Never work an unchecked-out issue.
- Comment with specifics: file changed, function modified, schema output if relevant.
- Close issues only when work is fully complete and verified.

---

## Read / Edit / Write (Codebase Modification)

These are your primary tools. The codebase is the work.

**Read** — use for any known file path. Always read before editing. Use `offset` and `limit` for large files; don't read 500 lines when you need 50.

**Edit** — use for targeted changes to existing files. Preferred over Write for modifications. Provide sufficient context in `old_string` to be unambiguous.

**Write** — use only for new files. Never use Write to overwrite an existing file you haven't fully read and understood.

**Rules**
- Absolute paths only. Never relative paths.
- Read every file before modifying it — no exceptions.
- When editing `inc/schema-helpers.php`, re-read the full function before changing it; schema functions are often interdependent.

---

## Grep / Glob (Code Search)

Use before editing to understand scope of a change and after editing to verify no missed instances.

**Grep** — full regex search across file contents. Use for:
- Finding function definitions: `roden_output_legal_service_schema`
- Locating hardcoded NAP data when a phone/address needs to change
- Verifying a pattern is consistent across templates
- Checking for existing schema output before adding new hooks

**Glob** — file pattern matching. Use for:
- Finding all template files: `templates/**/*.php`
- Locating all single-CPT routers: `single-*.php`
- Finding all schema-related includes: `inc/schema-*.php`

**Rules**
- Grep before assuming a function doesn't exist.
- After a NAP change, grep the entire theme for the old value to catch hardcoded instances.
- Use Glob to confirm file paths before writing new files (avoid duplicate names).

---

## Bash (SSH, WP-CLI, Git, Validation)

Use Bash for operations that require a shell: git commands, SSH to WP Engine, WP-CLI task, npm builds.

**Git workflow**
```bash
# Stage specific files (never git add -A blindly)
git add inc/schema-helpers.php templates/template-intersection.php

# Commit with descriptive message
git commit -m "Fix LegalService schema on intersection pages — add areaServed field"

# Deploy — push to main triggers WP Engine auto-deploy
git push origin main
```

**WP-CLI via SSH** (only when explicitly needed)
```bash
# Connect to WP Engine dev site
ssh -i ~/.ssh/wpengine_ed25519 rodenlawdev1@rodenlawdev1.ssh.wpengine.net

# Run WP-CLI commands
cd sites/rodenlawdev1 && wp <command>

# Flush permalinks after rewrite rule changes
cd sites/rodenlawdev1 && wp rewrite flush

# Run a seeder script
cd sites/rodenlawdev1 && wp eval-file wp-content/themes/roden-law/inc/<script>.php
```

**Rules**
- Do not SSH into WP Engine unless the task explicitly requires it (WP-CLI seeding, permalink flush, data migration).
- Never run WP-CLI locally — there is no local WordPress installation.
- Use absolute paths in all Bash commands.
- Quote paths with spaces.

---

## Data Store Access

Read and write JSON/Markdown files in `agents/data/` for shared metrics and state.

**Patterns**
- Rank snapshots: `agents/data/ranks/YYYY-MM-DD.json`
- Crawl health: `agents/data/crawl/latest.json`
- Content pipeline: `agents/data/content/pipeline.json`
- Weekly rollups: `agents/data/weekly-rollups/YYYY-MM-DD.md`

**Rules**
- Read before writing. Never clobber without reading current state first.
- Write atomic updates — change only the fields you own.
- Use ISO 8601 dates for all keys and filenames.

---

## Tool Scope: What You Use and When

| Tool | Use Case |
|------|----------|
| Read | Always before editing. Targeted file reads. |
| Edit | Modifying existing theme files. |
| Write | Creating new theme files only. |
| Grep | Finding code patterns, locating functions, NAP audits. |
| Glob | Discovering file paths, checking naming conventions. |
| Bash (git) | Staging, committing, pushing to main (deploy). |
| Bash (SSH/WP-CLI) | Permalink flush, content seeding — only when required. |
| Paperclip | Task checkout, status updates, closing issues, creating subtasks. |

**What you do NOT use**
- WebSearch — not your domain. Delegate intelligence tasks to SEO Strategist or Competitor Intelligence.
- WebFetch — do not fetch the live or dev site to verify changes. Write, commit, push. Verification is the developer's job.
- No schema plugins, no page builders, no external schema validators during implementation (validate mentally against the JSON-LD spec).
