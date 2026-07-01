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

namespace block_guidance\external;

use context_course;
use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_value;
use tool_guidance\local\dismissal_manager;
use tool_guidance\local\engine;
use tool_guidance\local\target_resolver;

defined('MOODLE_INTERNAL') || die();

/**
 * Web service: return the top activity suggestion for a course.
 *
 * @package    block_guidance
 * @copyright  2026 bdecent gmbh <https://bdecent.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class get_suggestion extends external_api {

    /**
     * Parameters.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'courseid' => new external_value(PARAM_INT, 'Course id'),
        ]);
    }

    /**
     * Return the suggestion, or hassuggestion=false.
     *
     * @param int $courseid
     * @return array
     */
    public static function execute(int $courseid): array {
        $params = self::validate_parameters(self::execute_parameters(), ['courseid' => $courseid]);

        $context = context_course::instance($params['courseid']);
        self::validate_context($context);
        require_capability('moodle/course:update', $context);

        $hasdismissals = (new dismissal_manager())->has_active_dismissals($params['courseid']);

        $suggestion = engine::instance()->get_suggestion($params['courseid']);
        if ($suggestion === null) {
            return ['hassuggestion' => false, 'hasdismissals' => $hasdismissals];
        }

        // Resolve where "Set this up" links, with the node -> activity -> settings
        // fallback. When it's a guidance-chooser (node) URL, the block opens it in a
        // modal; otherwise it's a normal navigation.
        $resolved = target_resolver::resolve($suggestion, $params['courseid']);

        return [
            'hassuggestion'  => true,
            'hasdismissals'  => $hasdismissals,
            'ruleid'         => $suggestion->ruleid,
            'modname'        => $suggestion->modname,
            'modnamedisplay' => get_string('pluginname', 'mod_' . $suggestion->modname),
            'name'           => $suggestion->name,
            'rationale'      => $suggestion->rationale,
            'signal'         => $suggestion->signaltype,
            'clickurl'       => $resolved['url']->out(false),
            'ischooser'      => $resolved['ischooser'],
        ];
    }

    /**
     * Returns.
     *
     * @return external_single_structure
     */
    public static function execute_returns(): external_single_structure {
        return new external_single_structure([
            'hassuggestion'  => new external_value(PARAM_BOOL, 'Whether a suggestion was found'),
            'hasdismissals'  => new external_value(PARAM_BOOL, 'Whether the course has dismissed suggestions to reset'),
            'ruleid'         => new external_value(PARAM_INT, 'Matched rule id', VALUE_OPTIONAL),
            'modname'        => new external_value(PARAM_PLUGIN, 'Suggested module name', VALUE_OPTIONAL),
            'modnamedisplay' => new external_value(PARAM_TEXT, 'Suggested module display name', VALUE_OPTIONAL),
            'name'           => new external_value(PARAM_TEXT, 'Default activity name', VALUE_OPTIONAL),
            'rationale'      => new external_value(PARAM_TEXT, 'Teacher-facing reason', VALUE_OPTIONAL),
            'signal'         => new external_value(PARAM_ALPHA, 'Signal category', VALUE_OPTIONAL),
            'clickurl'       => new external_value(PARAM_URL, 'Resolved call-to-action URL', VALUE_OPTIONAL),
            'ischooser'      => new external_value(PARAM_BOOL, 'Whether the CTA opens the guidance chooser (modal)', VALUE_OPTIONAL),
        ]);
    }
}
