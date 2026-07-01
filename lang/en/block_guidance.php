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
$string['privacy:metadata'] = 'The Guidance block does not store any personal data; dismissals are stored by the tool_guidance plugin.';

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

Use **Set this up** to open the guidance chooser for the suggested activity, or **Skip** to move on to a different suggestion.';
$string['addsuggested'] = 'Set up {$a}';
$string['dismiss'] = 'Not useful, skip this suggestion';
$string['nosuggestion'] = 'No suggestions right now. This course looks well rounded.';
$string['resetdismissed'] = 'Reset skipped suggestions';
$string['managerules'] = 'Manage suggestion rules';
