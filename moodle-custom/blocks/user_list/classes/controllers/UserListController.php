<?php

/**
 * UserListController.php
 * Author: Andrii Molchanov
 * Email: andymolchanov@gmail.com
 * 02.10.2024
 */
include_once('AbstractController.php');

class UserListController extends AbstractController
{
    /**
     * @return array [
     *      'exampleActionName1' => \namespace\actionClass1,
     *      'exampleActionName2' => \namespace\actionClass2,
     *  ];
     */
    public static function actions()
    {
        return
            [
                'ActionListView' => 'actionIndex'
            ];
    }

}
