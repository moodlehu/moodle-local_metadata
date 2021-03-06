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
 * Text profile field.
 *
 * @package    profilefield_text
 * @copyright  2007 onwards Shane Elliot {@link http://pukunui.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace metadatafieldtype_text;

defined('MOODLE_INTERNAL') || die;

/**
 * Class local_metadata_field_text
 *
 * @copyright  2007 onwards Shane Elliot {@link http://pukunui.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class metadata extends \local_metadata\fieldtype\metadata {

    /**
     * Constructor method.
     *
     * @param int $fieldid
     * @param int $instanceid
     */
    public function __construct($fieldid=0, $instanceid=0) {
        // First call parent constructor.
        parent::__construct($fieldid, $instanceid);

        // Set the name for display; will need to be a language string.
        $this->name = 'Text input';
    }

    /**
     * Overwrite the base class to display the data for this field
     */
    public function display_data() {
        // Default formatting.
        $data = parent::display_data();

        // Are we creating a link?
        if (!empty($this->field->param4) && !empty($data)) {

            // Define the target.
            if (! empty($this->field->param5)) {
                $target = 'target="'.$this->field->param5.'"';
            } else {
                $target = '';
            }

            // Create the link.
            $data = '<a href="'.str_replace('$$', urlencode($data), $this->field->param4).'" '.
                $target.'>'.htmlspecialchars($data).'</a>';
        }

        return $data;
    }

    /**
     * Add fields for editing a text profile field.
     * @param moodleform $mform
     */
    public function edit_field_add($mform) {
        
        $size = $this->field->param1;
        $maxlength = $this->field->param2;
        $metadata = ($this->field->param3 == 1 ? 'password' : 'text');

        // Create the form field.
        // zl_temp: to distinguish the difference between 'description' in 'general' and 'educational'(they have different translations
        if (strpos($this->inputname, 'general_description') !== false) {
            $mform->addElement($metadata, $this->inputname, format_string(get_string('general_description', 'local_lom')), 'maxlength="'.
                $maxlength.'" size="80"');
        } else {      
            $mform->addElement($metadata, $this->inputname, format_string(get_string($this->field->name, 'local_lom')), 'maxlength="'.
                $maxlength.'" size="80"');
        }

        $mform->setType($this->inputname, PARAM_TEXT);
        
        $this->add_help_button($mform, $this->inputname);
    }

    /**
     * Return the field type and null properties.
     * This will be used for validating the data submitted by a user.
     *
     * @return array the param type and null property
     * @since Moodle 3.2
     */
    public function get_field_properties() {
        return [PARAM_TEXT, NULL_NOT_ALLOWED];
    }

}


