<?php

/**
 * UserForm.php
 * Author: Andrii Molchanov
 * Email: andymolchanov@gmail.com
 * 25.09.2024
 */
// moodleform is defined in formslib.php
global $CFG;
require_once("$CFG->libdir/formslib.php");
require_once($CFG->dirroot . '/blocks/user_list/classes/models/User.php');

class UserForm extends moodleform
{
    // Add elements to form.
    public function definition()
    {
        $model = new User();


        if(is_string($userList = $model->getUserList()))
        {
            echo $userList;
            return;
        }
        $mform = $this->_form; // Don't forget the underscore!

        foreach ($userList as $user) {
            // Add elements to your form.
            $mform->addElement('hidden', 'user_id['. $user->id .']' , $user->id);
            $mform->addElement('text', 'estimate[' . $user->id .']', get_string('estimate'));
            $mform->addElement('text', 'username[' . $user->id . ']', get_string('username'));
            $mform->addElement('text', 'email[' . $user->id . ']', get_string('email'));
            $mform->addElement('header', 'estimate[' . $user->id . ']', get_string('estimate', 'modulename'));


            // Set type of element.
            $mform->setType('estimate[' . $user->id . ']', PARAM_NOTAGS);
            $mform->setType('username[' . $user->id. ']', PARAM_NOTAGS);
            $mform->setType('email[' . $user->id. ']', PARAM_NOTAGS);

            // Default value
            $mform->setDefault('estimate[' . $user->id. ']', $model->getUserEstimate($user->id)->user_expensive??1);
            $mform->setDefault('username[' . $user->id . ']', $user->username);
            $mform->setDefault('email[' . $user->id. ']', $user->username);
        }
        $this->add_action_buttons($cancel = false);

    }

    // Custom validation should be added here.
    function validation($data, $files)
    {
        return [];
    }
}
