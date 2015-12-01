<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Helpers;

/**
 * Description of Header
 *
 * @author ACER
 */
class Header {
    private $viewInstance = null;
    public function navBar() {
        $this->viewInstance = \GTFramework\View::getInstance();
        $this->viewInstance->appendToLayout('navBar', 'layouts/header');
        echo $this->viewInstance->_includeFile('layouts/header');
    }
}
