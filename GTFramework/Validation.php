<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GTFramework;

/**
 * Description of Validation
 *
 * @author ACER
 */
class Validation {
    
//    @<HTTPPOST('index/proba')>

    public function __construct() {
        
    }
        public function validateToken() {
        if (!isset($_SESSION['afToken'])) {
           return false;
        }
        if ($_POST['AFToken'] !== $_SESSION['afToken']) {
            return false;
        } 
        return true;
    }

}
