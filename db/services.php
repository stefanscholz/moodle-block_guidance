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
 * Web service functions for block_guidance.
 *
 * @package    block_guidance
 * @copyright  2026 bdecent gmbh <https://bdecent.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = [
    'block_guidance_get_suggestion' => [
        'classname'   => 'block_guidance\external\get_suggestion',
        'methodname'  => 'execute',
        'description' => 'Get the top activity suggestion for a course.',
        'type'        => 'read',
        'ajax'        => true,
    ],
    'block_guidance_dismiss' => [
        'classname'   => 'block_guidance\external\dismiss',
        'methodname'  => 'execute',
        'description' => 'Dismiss a suggestion rule for a course (course-wide cooldown).',
        'type'        => 'write',
        'ajax'        => true,
    ],
    'block_guidance_reset' => [
        'classname'   => 'block_guidance\external\reset',
        'methodname'  => 'execute',
        'description' => 'Clear all dismissed suggestions for a course.',
        'type'        => 'write',
        'ajax'        => true,
    ],
];
