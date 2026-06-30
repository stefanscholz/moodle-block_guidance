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
 * Strings for the Guidance block.
 *
 * @package    block_guidance
 * @copyright  2026 bdecent gmbh <https://bdecent.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Guidance';
$string['guidance:addinstance'] = 'Add a new Guidance block';
$string['guidance:myaddinstance'] = 'Add a new Guidance block to the Dashboard';
$string['privacy:metadata'] = 'The Guidance block does not store any personal data.';

// Instance settings.
$string['config_showtitle'] = 'Show the block title';
$string['config_title'] = 'Custom block title';
$string['config_title_help'] = 'A title to show instead of the default "Recommended next step". Leave blank to use the default.';
$string['config_visibility'] = 'When to show this block';
$string['config_visibility_help'] = 'Choose "Only while editing" to hide the block from students and show it to teachers just while they have editing turned on.';
$string['config_visibility_always'] = 'Always show';
$string['config_visibility_editing'] = 'Only while editing';

// Next step card.
$string['nextstep_heading'] = 'Recommended next step';
$string['nextstep_heading_help'] = 'This shows a single suggested next step for building out your course, based on what it currently contains.

As you add activities and resources, the suggestion updates to point you at a sensible next thing to set up.

Use **Set this up** to jump straight into creating the suggested item, or **Dismiss** to move on to a different suggestion.';
$string['cta_default'] = 'Set this up';
$string['dismiss'] = 'Dismiss';
$string['alldismissed'] = "You've reviewed all our suggestions for now.";
$string['startover'] = 'Start over';
$string['nostep'] = 'No recommendation available yet.';

// Static sample recommendations (replaced by the backend later).
$string['rec_quiz_title'] = 'Add a diagnostic quiz';
$string['rec_quiz_rationale'] = 'Your course has no activities yet. A short auto-graded quiz is a quick way to find out what your students already know.';
$string['rec_forum_title'] = 'Start a discussion forum';
$string['rec_forum_rationale'] = 'A forum gives students a place to introduce themselves and ask questions, building a sense of community early on.';
$string['rec_assign_title'] = 'Set up an assignment';
$string['rec_assign_rationale'] = 'An assignment lets students submit work for feedback and a grade — a solid next step once the basics are in place.';
