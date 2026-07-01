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
 * Controls the activity suggestion block: load, render, dismiss.
 *
 * @module     block_guidance/control
 * @copyright  2026 bdecent gmbh <https://bdecent.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import * as Repository from 'block_guidance/repository';
import Templates from 'core/templates';
import Notification from 'core/notification';

const SELECTORS = {
    region: '[data-region="guidance"]',
    card: '[data-region="suggestion-card"]',
    dismiss: '[data-action="dismiss"]',
    reset: '[data-action="reset"]',
};

let courseId;
let root;

/**
 * Render the suggestion data into the card and wire the dismiss button.
 *
 * @param {Object} data
 * @return {Promise}
 */
const render = (data) => {
    const target = root.querySelector(SELECTORS.card);
    return Templates.renderForPromise('block_guidance/suggestion', data)
        .then(({html, js}) => {
            Templates.replaceNodeContents(target, html, js);
            const dismissButton = target.querySelector(SELECTORS.dismiss);
            if (dismissButton) {
                dismissButton.addEventListener('click', onDismiss);
            }
            const resetButton = target.querySelector(SELECTORS.reset);
            if (resetButton) {
                resetButton.addEventListener('click', onReset);
            }
            return true;
        });
};

/**
 * Load (or reload) the current top suggestion.
 *
 * @return {Promise}
 */
const load = () => Repository.getSuggestion(courseId).then(render).catch(Notification.exception);

/**
 * Handle a thumbs-down: dismiss then load the next suggestion.
 *
 * @param {Event} e
 */
const onDismiss = (e) => {
    e.preventDefault();
    const ruleid = parseInt(e.currentTarget.dataset.ruleid, 10);
    Repository.dismiss(courseId, ruleid).then(load).catch(Notification.exception);
};

/**
 * Handle a reset: clear all skipped suggestions then reload.
 *
 * @param {Event} e
 */
const onReset = (e) => {
    e.preventDefault();
    Repository.reset(courseId).then(load).catch(Notification.exception);
};

/**
 * Initialise the block for a course.
 *
 * @param {Number} id course id
 */
export const init = (id) => {
    courseId = id;
    root = document.querySelector(SELECTORS.region);
    if (root) {
        load();
    }
};
