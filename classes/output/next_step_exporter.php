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
use core\external\exporter;
use moodle_url;
use renderer_base;

/**
 * Exports the recommended next step for the block template.
 *
 * @package    block_guidance
 * @copyright  2026 bdecent gmbh <https://bdecent.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class next_step_exporter extends exporter {

    /** @var int Course id. */
    protected $courseid;

    /** @var recommendation The recommendation to render. */
    protected $rec;

    /**
     * Constructor.
     *
     * @param int $courseid Course id.
     * @param recommendation $rec The recommendation.
     */
    public function __construct(int $courseid, recommendation $rec) {
        $this->courseid = $courseid;
        $this->rec = $rec;
        parent::__construct((object) []);
    }

    /**
     * Computed properties for the template.
     *
     * @return array
     */
    protected static function define_other_properties() {
        return [
            'heading' => ['type' => PARAM_TEXT],
            'title' => ['type' => PARAM_TEXT],
            'rationale' => ['type' => PARAM_TEXT],
            'iconurl' => ['type' => PARAM_URL],
            'ctaurl' => ['type' => PARAM_URL],
            'ctalabel' => ['type' => PARAM_TEXT],
        ];
    }

    /**
     * Build the template context.
     *
     * @param renderer_base $output
     * @return array
     */
    protected function get_other_values(renderer_base $output) {
        $ctaurl = new moodle_url('/admin/tool/guidance/chooser.php', [
            'courseid' => $this->courseid,
            'node' => $this->rec->nodeid,
        ]);

        return [
            'heading' => get_string('nextstep_heading', 'block_guidance'),
            'title' => get_string($this->rec->titlekey, 'block_guidance'),
            'rationale' => get_string($this->rec->rationalekey, 'block_guidance'),
            'iconurl' => $output->image_url('monologo', 'mod_' . $this->rec->modname)->out(false),
            'ctaurl' => $ctaurl->out(false),
            'ctalabel' => get_string('cta_default', 'block_guidance'),
        ];
    }
}
