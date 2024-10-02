<?php

/**
 * actionIndex.php
 * Author: Andrii Molchanov
 * Email: andymolchanov@gmail.com
 * 02.10.2024
 */
require_once  ('AbstractAction.php');
require_once($CFG->dirroot . '/blocks/user_list/classes/form/UserForm.php');
require_once($CFG->dirroot . '/blocks/user_list/classes/models/UserExpensive.php');


class actionIndex extends AbstractAction
{

    public function execute()
    {
        $form = new UserForm();

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
        return $form->render();
    }
}
