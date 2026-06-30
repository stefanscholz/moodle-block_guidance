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
 * Dismiss the current guidance recommendation (or reset all dismissals) and
 * return to the course. Works without JavaScript.
 *
 * @package    block_guidance
 * @copyright  2026 bdecent gmbh <https://bdecent.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../config.php');

use block_guidance\local\recommendation;

$courseid = required_param('courseid', PARAM_INT);
$reset = optional_param('reset', 0, PARAM_BOOL);

$course = get_course($courseid);
require_login($course);
require_sesskey();

$pref = recommendation::dismissed_pref($courseid);

if ($reset) {
    unset_user_preference($pref);
} else {
    $dismissed = (int) get_user_preferences($pref, 0);
    set_user_preference($pref, $dismissed + 1);
}

redirect(new moodle_url('/course/view.php', ['id' => $courseid]));
