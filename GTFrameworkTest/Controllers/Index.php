<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Index
 *
 * @author ACER
 */

namespace Controllers;

class Index implements \Controllers\IController {

    /**
     * *http[GET Home]* *
     * @param type \Controllers\Index
     */
    
    public function index($param) {
        $token = uniqid();
        $_SESSION['token'] = $token;
        $view = \GTFramework\View::getInstance();
        $view->username = 'Stanaka';
        $view->title = 'Home';
        $view->appendToLayout('body2', 'Admin/Index.php');
        $view->appendToLayout('body1', 'PartialViews/Register.php');
        $view->display('Layouts/Default.php', ['token' => [$token]]);
    }

}
