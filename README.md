# block_guidance — Guidance next-step block

Static front-end prototype that surfaces a single recommended **next step**
(icon, title, short rationale, CTA) on course pages, helping teachers decide
what to do in a new, empty Moodle course.

> **Status: static interface only.** The recommendation is a hardcoded
> placeholder. The real data and AI/policy backend are built by a separate team
> and will be wired in later. Target: **Moodle 5.2** (PHP 8.2+).

The CTA deep-links into the companion [`tool_guidance`](https://github.com/stefanscholz/moodle-tool_guidance)
chooser at a specific decision-tree node. The recommendation comes from the
static `block_guidance\local\recommendation` class — the swap-point for the
future policy/AI backend.

## Installation

Clone (or copy) this repository into `blocks/guidance` inside your Moodle:

```sh
# From your Moodle root:
git clone git@github.com:stefanscholz/moodle-block_guidance.git blocks/guidance
```

Then visit **Site administration → Notifications** to install the plugin.

To exercise it: in a course, turn editing on, add the **Guidance** block, and
click its call-to-action — it opens the chooser at the recommended node.

## Wiring up the backend later

Replace `block_guidance\local\recommendation::for_course()` with the policy/AI-driven
recommendation. Everything else — exporter, renderable, template — depends only
on the `recommendation` shape, so it stays unchanged.
