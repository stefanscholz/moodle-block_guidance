<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * The Guidance block: surfaces the engine's recommended next step for a course.
 *
 * @package    block_guidance
 * @copyright  2026 bdecent gmbh <https://bdecent.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Block that recommends a single next step (from tool_guidance's engine) and deep-links
 * its call-to-action into the guidance chooser's templates.
 */
class block_guidance extends block_base {

    /**
     * Initialise the block title.
     */
    public function init() {
        $this->title = get_string('nextstep_heading', 'block_guidance');
    }

    /**
     * Apply the instance configuration to the block title.
     */
    public function specialization() {
        if (!empty($this->config->title)) {
            $this->title = format_string($this->config->title);
        } else {
            $this->title = get_string('nextstep_heading', 'block_guidance');
        }
    }

    /**
     * Hide the standard block header only when the teacher has turned the title off.
     *
     * @return bool
     */
    public function hide_header() {
        return isset($this->config->showtitle) && !$this->config->showtitle;
    }

    /**
     * Enable the per-instance settings form.
     *
     * @return bool
     */
    public function instance_allow_config() {
        return true;
    }

    /**
     * Only one Guidance block per course.
     *
     * @return bool
     */
    public function instance_allow_multiple() {
        return false;
    }

    /**
     * Restrict the block to course pages, where a next step is meaningful.
     *
     * @return array
     */
    public function applicable_formats() {
        return [
            'course-view' => true,
            'site' => false,
            'my' => false,
        ];
    }

    /**
     * No global configuration; the engine's settings live in tool_guidance.
     *
     * @return bool
     */
    public function has_config() {
        return false;
    }

    /**
     * Build the block content: an empty region filled asynchronously by JS.
     *
     * @return stdClass
     */
    public function get_content() {
        global $COURSE, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        // No recommendation outside a real course (e.g. the front page).
        if (empty($COURSE->id) || $COURSE->id == SITEID) {
            return $this->content;
        }

        // The recommendation is about setting up the course, so it is teacher-facing.
        $coursecontext = context_course::instance($COURSE->id);
        if (!has_capability('moodle/course:manageactivities', $coursecontext)) {
            return $this->content;
        }

        // Honour the "only while editing" visibility setting.
        $visibility = $this->config->visibility ?? 'always';
        if ($visibility === 'editing' && !$this->page->user_is_editing()) {
            return $this->content;
        }

        $this->content->text = html_writer::div(
            html_writer::tag('div', '', ['data-region' => 'suggestion-card']),
            'block-guidance',
            ['data-region' => 'guidance']);

        // Our controller fills the region; the tool's chooser_modal opens the CTA in a modal.
        $this->page->requires->js_call_amd('block_guidance/control', 'init', [(int) $COURSE->id]);
        $this->page->requires->js_call_amd('tool_guidance/chooser_modal', 'init');

        // Managers can jump to the rule editor.
        if (has_capability('tool/guidance:managerules', context_system::instance())) {
            $manageurl = new moodle_url('/admin/tool/guidance/manage_rules.php');
            $this->content->footer = html_writer::link($manageurl,
                $OUTPUT->pix_icon('t/edit', '') . ' ' . get_string('managerules', 'block_guidance'),
                ['class' => 'small text-muted']);
        }

        return $this->content;
    }
}
