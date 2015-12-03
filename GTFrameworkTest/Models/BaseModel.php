<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;

/**
 * Description of BaseModel
 *
 * @author ACER
 */
class BaseModel extends \GTFramework\DB\SimpleDB {

    private static $_instance = null;

    private function __construct(\GTFramework\Loger $loger) {
        $this->loger = $loger;
    }

    /**
     * 
     * @return \Models
     */
    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new \GTFramework\BaseModel(\GTFramework\App::getLoger());
        }
        return self::$_instance;
    }

}
