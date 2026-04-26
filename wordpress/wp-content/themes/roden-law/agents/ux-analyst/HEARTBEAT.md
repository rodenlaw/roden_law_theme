# Heartbeat: UX Analyst

**Schedule:** On-demand (wakeOnDemand: true)

---

## Pre-Flight: Identity and Context Check

Before doing any work, confirm your operating context:

- [ ] Read `AGENTS.md` — confirm role, reporting structure, working rules
- [ ] Read `SOUL.md` — re-anchor UX analysis mindset
- [ ] Read `CLAUDE.md` — confirm site architecture, design tokens, URL structure, office data
- [ ] `GET /api/agents/me` — confirm identity, budget, chain of command
- [ ] Check wake context: `PAPERCLIP_TASK_ID`, `PAPERCLIP_WAKE_REASON`

---

## Step 1: Get Assignments

- `GET /api/agents/me/inbox-lite` — get assigned tasks
- Prioritize `in_progress` first, then `todo`
- If `PAPERCLIP_TASK_ID` is set and assigned to you, prioritize that task

---

## Step 2: Checkout and Understand Context

- `POST /api/issues/{id}/checkout` — claim the task before working
- `GET /api/issues/{id}/heartbeat-context` — understand what's needed
- Read the issue description and any parent issue context

---

## Step 3: Do the Work

### For Site UX Audits (rodenlaw.com):
1. Open Chrome and navigate to the target pages
2. Evaluate each page against UX criteria:
   - Visual hierarchy and content flow
   - CTA placement and visibility
   - Phone number / contact accessibility
   - Mobile responsiveness
   - Page load perception
   - Trust signal placement (badges, case results, testimonials)
   - Navigation flow and information architecture
   - Form design and friction points
3. Document findings with specific page references and screenshots where helpful

### For Competitor UX Benchmarks:
1. Identify top 3-5 competitors in the target market via search
2. Navigate their sites and evaluate the same UX criteria
3. Note what competitors do better or worse than Roden Law
4. Identify patterns across successful competitor sites

### For Conversion Optimization:
1. Map the user journey from landing to contact
2. Count clicks/scrolls to reach a CTA on each page type
3. Evaluate form design, phone number visibility, chat widgets
4. Identify drop-off points and friction

---

## Step 4: Write Recommendations

Structure all findings using the format in AGENTS.md:
- Priority (P0-P3), Impact category, Current State, Recommendation, Competitor Reference, Implementation Notes
- Save findings to `agents/data/ux-audit/` as dated markdown files
- Create Paperclip subtasks for P0/P1 items that need engineering implementation

---

## Step 5: Update Status and Exit

- Comment on the issue with a summary of findings
- Update issue status (`done` if complete, `blocked` if stuck)
- Create subtasks for any follow-up work identified
- Exit cleanly

---

## Rules

- Always checkout before working
- Never retry a 409
- Always comment on in_progress work before exiting
- Recommendations only — never modify code directly
- Always include specific page URLs and sections in findings
- Benchmark against competitors, not in isolation
