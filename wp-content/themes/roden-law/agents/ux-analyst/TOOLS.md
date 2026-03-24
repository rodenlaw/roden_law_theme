# Tools: UX Analyst

## Chrome Browser (Primary Tool)

You have Chrome browser access via `mcp__claude-in-chrome__*` tools. This is your primary instrument for UX evaluation.

**Key workflows:**

### Site Navigation
```
mcp__claude-in-chrome__tabs_context_mcp — get current browser state
mcp__claude-in-chrome__tabs_create_mcp — open a new tab
mcp__claude-in-chrome__navigate — go to a URL
mcp__claude-in-chrome__read_page — capture full page content
mcp__claude-in-chrome__get_page_text — get text-only content
```

### Visual Analysis
```
mcp__claude-in-chrome__computer — take screenshots, interact with page elements
mcp__claude-in-chrome__gif_creator — record multi-step interactions
mcp__claude-in-chrome__resize_window — test responsive breakpoints
```

### Technical Inspection
```
mcp__claude-in-chrome__javascript_tool — run JS to check DOM, compute styles, measure elements
mcp__claude-in-chrome__read_console_messages — check for JS errors
mcp__claude-in-chrome__read_network_requests — check page load performance
```

**Best practices:**
- Always call `tabs_context_mcp` first to understand browser state
- Create new tabs for each site you're reviewing
- Resize window to test mobile (375x812), tablet (768x1024), and desktop (1440x900) viewports
- Use `javascript_tool` to measure above-the-fold content, CTA positions, scroll depth to phone number
- Use `gif_creator` to document multi-step user flows (e.g., navigating from homepage to contact)
- Never trigger alerts or modal dialogs

---

## WebSearch

Use to find competitor sites and understand SERP landscape.

**Common patterns:**
```
WebSearch("personal injury lawyer Savannah GA")
WebSearch("car accident attorney Charleston SC")
WebSearch("best personal injury lawyer Columbia SC")
```

**What to look for:**
- Which firms rank in the top 5
- How their sites appear in search results (title, description)
- Whether they use rich results features

---

## WebFetch

Use to fetch page content for analysis when Chrome is not needed.

**Common patterns:**
```
WebFetch("https://rodenlaw.com/")
WebFetch("https://[competitor].com/practice-areas/car-accident-lawyers/")
```

---

## Read (File System)

Use to read local theme files for understanding the codebase.

**Key files:**
- `CLAUDE.md` — full architecture spec, design tokens, URL structure
- `templates/` — PHP template files showing current page structure
- `assets/css/main.css` — current styles
- `inc/firm-data.php` — office data, practice areas

---

## Paperclip API

Use for task coordination.

**Key endpoints:**
- `GET /api/agents/me` — identity check
- `GET /api/agents/me/inbox-lite` — get assignments
- `POST /api/issues/{id}/checkout` — claim task
- `GET /api/issues/{id}/heartbeat-context` — understand task context
- `PATCH /api/issues/{id}` — update status
- `POST /api/issues/{id}/comments` — post findings
- `POST /api/companies/{companyId}/issues` — create subtasks

---

## Data Store

Write UX audit findings to `agents/data/ux-audit/` as dated markdown files.

**File naming:** `YYYY-MM-DD-[audit-type].md` (e.g., `2026-03-21-homepage-audit.md`)

**Rules:**
- Read before writing — never clobber existing files
- Use ISO 8601 dates
- Structure findings with the recommendation format from AGENTS.md
