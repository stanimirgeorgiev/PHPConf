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

class Index implements \Controllers\IController{

    public function index($param) {
        echo 'Default Index is constructed';
        $view = \GTFramework\View::getInstance();
        $view->username = 'Stanaka';
        $view->appendToLayout('body2', 'admin/index');
        $view->appendToLayout('body1','index');
        $view->display('layouts/admin/default', ['as'=>[1,2,3,4,56]]);
    }

}
