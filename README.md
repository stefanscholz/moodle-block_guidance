# block_guidance — Guidance next-step block

Surfaces a single recommended **next step** (rationale + call-to-action) on course pages,
helping teachers decide what to set up next. Teacher-facing (needs
`moodle/course:manageactivities`); one instance per course.

The recommendation is **engine-driven**: the block asks
[`tool_guidance`](../../admin/tool/guidance)'s suggestion engine for the top activity for the
course, loads it asynchronously via web service, and renders a card with:

- **Set this up** — deep-links into the guidance chooser at the presets for the suggested
  activity (`tool_guidance/chooser_modal` opens it in a modal, in place).
- **Skip** — dismisses the suggestion course-wide (with a cooldown) and shows the next one.
- **Reset skipped suggestions** — clears the course's dismissals so everything can reappear.

Managers see a link to the rule editor in the block footer.

## Depends on

`tool_guidance` (the engine, rules and chooser). Install that first.

## Web services

`block_guidance_get_suggestion`, `block_guidance_dismiss`, `block_guidance_reset` — all
capability-checked and delegating to `tool_guidance`'s engine and dismissal manager.
