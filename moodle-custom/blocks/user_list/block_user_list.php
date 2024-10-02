<?php
/**
 * Author: Andrii Molchanov
 * Email: andymolchanov@gmail.com
 * 23.09.2024
 * @package block_user_list
 */

use core_privacy\local\request\userlist;

opcache_reset();
global $CFG;
require_once($CFG->dirroot . '/blocks/user_list/classes/form/UserForm.php');
require_once($CFG->dirroot . '/blocks/user_list/classes/models/User.php');
require_once($CFG->dirroot . '/blocks/user_list/classes/models/UserExpensive.php');
include_once($CFG->dirroot . '/blocks/user_list/classes/controllers/UserListController.php');
class block_user_list extends block_base
{
    /**
     * Initialises the block.
     *
     * @return void
     * @throws coding_exception
     */
    function init(): void
    {
        $this->title = get_string('user_list', 'block_user_list');
        $this->version = 2004111200;
    }

    public function html_attributes()
    {
        $attributes = parent::html_attributes();
        // Append our class to class attribute.
        $attributes['class'] .= ' block_' . $this->name();
        return $attributes;
    }

    public function get_content(): stdClass
    {
        global $OUTPUT;
        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = (object)[
            'items' => [],
            'icons' => [],
            'footer' => 'Footer here...',
        ];

        $this->content->text = (new UserListController('ActionListView'))->execute();

        return $this->content;
    }

}
