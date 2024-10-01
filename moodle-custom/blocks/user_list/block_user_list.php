<?php
/**
 * Author: Andrii Molchanov
 * Email: andymolchanov@gmail.com
 * 23.09.2024
 * @package block_user_list
 */
opcache_reset();
global $CFG;
require_once($CFG->dirroot . '/blocks/user_list/classes/form/UserForm.php');
require_once($CFG->dirroot . '/blocks/user_list/classes/models/User.php');
require_once($CFG->dirroot . '/blocks/user_list/classes/models/UserExpensive.php');

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

        // Instantiate the userForm form from within the plugin.

        $form = new UserForm();

// Form processing and displaying is done here.
        if ($form->is_cancelled()) {
            // If there is a cancel element on the form, and it was pressed,
            // then the `is_cancelled()` function will return true.
            // You can handle the cancel operation here.
        } else {
            if ($fromform = $form->get_data()) {
                // When the form is submitted, and the data is successfully validated,
                // the `get_data()` function will return the data posted in the form.
                $model = new UserExpensive();

                foreach ($fromform->user_id as $id) {
                    $dataObject = new stdClass();
                    if ((bool)(($estimate = $model->getRecord($id)))) {
                        $dataObject->id = $estimate->id;
                        $dataObject->user_expensive = ($estimate->user_estimate)??$fromform->estimate[$id];
                    } else {
                        $dataObject->user_expensive = $fromform->estimate[$id];
                        $dataObject->user_id = $id;
                    }
                    $model->save($dataObject, $id);

                }
            } else {
                // This branch is executed if the form is submitted but the data doesn't
                // validate and the form should be redisplayed or on the first display of the form.

                // Set anydefault data (if any).
                $form->set_data($toform);
            }
        }

        $this->content->text = $form->render();

        return $this->content;
    }

}
