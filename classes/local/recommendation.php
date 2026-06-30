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

namespace block_guidance\local;

defined('MOODLE_INTERNAL') || die();

/**
 * Static source of the recommended next step.
 *
 * This is the single swap-point for the block. A future implementation will
 * derive the recommendation from policies and/or AI; the rest of the block
 * depends only on the shape returned here.
 *
 * @package    block_guidance
 * @copyright  2026 bdecent gmbh <https://bdecent.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class recommendation {

    /** @var string Target node id in the tool_guidance decision tree. */
    public string $nodeid;

    /** @var string Language key for the recommendation title. */
    public string $titlekey;

    /** @var string Language key for the recommendation rationale. */
    public string $rationalekey;

    /** @var string Activity module name used for the card icon. */
    public string $modname;

    /**
     * Constructor.
     *
     * @param string $nodeid Decision-tree node to deep-link to.
     * @param string $titlekey Language key for the title.
     * @param string $rationalekey Language key for the rationale.
     * @param string $modname Activity module name for the icon.
     */
    private function __construct(string $nodeid, string $titlekey, string $rationalekey, string $modname) {
        $this->nodeid = $nodeid;
        $this->titlekey = $titlekey;
        $this->rationalekey = $rationalekey;
        $this->modname = $modname;
    }

    /**
     * Ordered list of candidate recommendations.
     *
     * Static prototype data: a future backend will derive and rank these from
     * policies and/or AI. Each entry deep-links to a result node in the
     * tool_guidance decision tree.
     *
     * @return self[]
     */
    private static function all(): array {
        return [
            new self('r_quiz', 'rec_quiz_title', 'rec_quiz_rationale', 'quiz'),
            new self('r_forum', 'rec_forum_title', 'rec_forum_rationale', 'forum'),
            new self('r_assign', 'rec_assign_title', 'rec_assign_rationale', 'assign'),
        ];
    }

    /**
     * User preference name holding how many recommendations the user has
     * dismissed for a given course.
     *
     * @param int $courseid Course id.
     * @return string
     */
    public static function dismissed_pref(int $courseid): string {
        return 'block_guidance_dismissed_' . $courseid;
    }

    /**
     * Return the current recommended next step for a course, or null when the
     * user has dismissed every suggestion.
     *
     * @param int $courseid Course id.
     * @return self|null
     */
    public static function for_course(int $courseid): ?self {
        $dismissed = (int) get_user_preferences(self::dismissed_pref($courseid), 0);

        return self::all()[$dismissed] ?? null;
    }
}
