<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kofa
 *
 * @author ACER
 */
namespace Controllers\Admin;
class Kofa implements \Controllers\IController {

    public function index($params) {
//        echo '<pre>' . print_r($params, TRUE) . '</pre><br />';
    echo 'Kofa is constructed inIndex';
}
public function roro(){
    echo 'Roro is called';
}
}
