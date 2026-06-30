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
 * Instance configuration form for the Guidance block.
 *
 * @package    block_guidance
 * @copyright  2026 bdecent gmbh <https://bdecent.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Per-instance settings: title visibility, custom title and when to show the block.
 */
class block_guidance_edit_form extends block_edit_form {

    /**
     * Define the block-specific settings.
     *
     * @param MoodleQuickForm $mform
     */
    protected function specific_definition($mform) {
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Whether to show the block title at all.
        $mform->addElement('selectyesno', 'config_showtitle', get_string('config_showtitle', 'block_guidance'));
        $mform->setDefault('config_showtitle', 1);

        // Optional custom title, used instead of the default heading.
        $mform->addElement('text', 'config_title', get_string('config_title', 'block_guidance'), ['size' => 40]);
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', '');
        $mform->addHelpButton('config_title', 'config_title', 'block_guidance');
        $mform->hideIf('config_title', 'config_showtitle', 'eq', 0);

        // When the block should be visible.
        $mform->addElement('select', 'config_visibility', get_string('config_visibility', 'block_guidance'), [
            'always' => get_string('config_visibility_always', 'block_guidance'),
            'editing' => get_string('config_visibility_editing', 'block_guidance'),
        ]);
        $mform->setDefault('config_visibility', 'always');
        $mform->addHelpButton('config_visibility', 'config_visibility', 'block_guidance');
    }
}
