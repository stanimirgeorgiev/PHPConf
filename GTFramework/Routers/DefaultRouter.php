<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DefaultRouter
 *
 * @author ACER
 */

namespace GTFramework\Routers;

class DefaultRouter implements \GTFramework\Routers\IRouter {
    
    public function getURI() {
//        echo '<pre>' . print_r('Tova e DefaultRouter', TRUE) . '</pre><br />';
        return substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1);
    }

}
