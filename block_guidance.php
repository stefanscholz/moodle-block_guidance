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
 * The Guidance block: shows the recommended next step for a course.
 *
 * @package    block_guidance
 * @copyright  2026 bdecent gmbh <https://bdecent.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Block that recommends a single next step and deep-links into the guidance chooser.
 */
class block_guidance extends block_base {

    /**
     * Initialise the block.
     */
    public function init() {
        $this->title = get_string('nextstep_heading', 'block_guidance');
    }

    /**
     * Apply the instance configuration to the block title.
     *
     * The title and help icon are rendered inside the block content (see the
     * template), so the standard block header is always suppressed via
     * {@see hide_header()}. We still keep $this->title meaningful for block
     * management screens.
     */
    public function specialization() {
        if (!empty($this->config->title)) {
            $this->title = format_string($this->config->title);
        } else {
            $this->title = get_string('nextstep_heading', 'block_guidance');
        }
    }

    /**
     * Render the title ourselves inside the content, so suppress the standard
     * block header (which would otherwise duplicate the title and its help icon
     * in the accessibility skip link).
     *
     * @return bool
     */
    public function hide_header() {
        return true;
    }

    /**
     * Enable the per-instance settings form even though only one instance is allowed.
     *
     * @return bool
     */
    public function instance_allow_config() {
        return true;
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
     * Build the block content.
     *
     * @return stdClass
     */
    public function get_content() {
        global $COURSE;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';
        $this->content->text = '';

        // No recommendation outside a real course (e.g. the front page).
        if (empty($COURSE->id) || $COURSE->id == SITEID) {
            return $this->content;
        }

        // Only show to users who can manage activities (e.g. teachers); the
        // recommendation is about setting up the course, not for students.
        $coursecontext = context_course::instance($COURSE->id);
        if (!has_capability('moodle/course:manageactivities', $coursecontext)) {
            return $this->content;
        }

        // Honour the "only while editing" visibility setting.
        $visibility = $this->config->visibility ?? 'always';
        if ($visibility === 'editing' && !$this->page->user_is_editing()) {
            return $this->content;
        }

        $showtitle = !isset($this->config->showtitle) || !empty($this->config->showtitle);

        $renderer = $this->page->get_renderer('block_guidance');
        $this->content->text = $renderer->render_next_step((int) $COURSE->id, $showtitle, $this->title);

        // Open the chooser in a modal when the call-to-action is clicked
        // (progressive enhancement; the link still works without JavaScript).
        $this->page->requires->js_call_amd('tool_guidance/chooser_modal', 'init');

        return $this->content;
    }

    /**
     * Only one Guidance block per context.
     *
     * @return bool
     */
    public function instance_allow_multiple() {
        return false;
    }

    /**
     * No global configuration in the static prototype.
     *
     * @return bool
     */
    public function has_config() {
        return false;
    }
}
