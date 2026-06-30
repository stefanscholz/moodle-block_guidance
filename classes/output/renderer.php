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

namespace block_guidance\output;

defined('MOODLE_INTERNAL') || die();

use block_guidance\local\recommendation;
use moodle_url;
use plugin_renderer_base;

/**
 * Renderer for the Guidance block.
 *
 * @package    block_guidance
 * @copyright  2026 bdecent gmbh <https://bdecent.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {

    /**
     * Render the recommended next step card.
     *
     * @param int $courseid Course id.
     * @param bool $showtitle Whether to render the block title row.
     * @param string $blocktitle The block title text to display.
     * @return string HTML.
     */
    public function render_next_step(int $courseid, bool $showtitle = true, string $blocktitle = ''): string {
        $rec = recommendation::for_course($courseid);

        // Title row data, shared by both states.
        $titledata = [
            'showtitle' => $showtitle,
            'blocktitle' => $blocktitle,
            'helpicon' => $this->help_icon('nextstep_heading', 'block_guidance'),
        ];

        // Every suggestion has been dismissed: offer to start over.
        if ($rec === null) {
            $reseturl = new moodle_url('/blocks/guidance/dismiss.php', [
                'courseid' => $courseid,
                'reset' => 1,
                'sesskey' => sesskey(),
            ]);
            return $this->render_from_template('block_guidance/next_step', $titledata + [
                'hasrecommendation' => false,
                'donemessage' => get_string('alldismissed', 'block_guidance'),
                'reseturl' => $reseturl->out(false),
                'resetlabel' => get_string('startover', 'block_guidance'),
            ]);
        }

        $context = \context_course::instance($courseid);
        $exporter = new next_step_exporter($courseid, $rec, $context);
        $data = (array) $exporter->export($this);
        $data['hasrecommendation'] = true;
        return $this->render_from_template('block_guidance/next_step', $titledata + $data);
    }
}
