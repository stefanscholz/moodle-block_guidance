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
 * Web service calls for the activity suggestion block.
 *
 * @module     block_guidance/repository
 * @copyright  2026 bdecent gmbh <https://bdecent.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import Ajax from 'core/ajax';

/**
 * Fetch the top suggestion for a course.
 *
 * @param {Number} courseid
 * @return {Promise}
 */
export const getSuggestion = (courseid) => Ajax.call([{
    methodname: 'block_guidance_get_suggestion',
    args: {courseid},
}])[0];

/**
 * Dismiss a suggestion rule for a course.
 *
 * @param {Number} courseid
 * @param {Number} ruleid
 * @return {Promise}
 */
export const dismiss = (courseid, ruleid) => Ajax.call([{
    methodname: 'block_guidance_dismiss',
    args: {courseid, ruleid},
}])[0];

/**
 * Clear all dismissed suggestions for a course.
 *
 * @param {Number} courseid
 * @return {Promise}
 */
export const reset = (courseid) => Ajax.call([{
    methodname: 'block_guidance_reset',
    args: {courseid},
}])[0];
