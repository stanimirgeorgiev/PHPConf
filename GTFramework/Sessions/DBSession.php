<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GTFramework\Sessions;

/**
 * Description of DBSession
 *
 * @author ACER
 */
class DBSession extends \GTFramework\DB\SimpleDB implements \GTFramework\Sessions\ISession{
    public function __construct($dbConnection = null, $TableName = 'session', $name = null, $lifetime = 3600,$path = null, $domain = null, $secure = false ,$httponly = TRUE ) {
        
    }

    public function __get($name) {
        
    }

    public function __set($name, $value) {
        
    }

    public function destroySession() {
        
    }

    public function getSessionId() {
        
    }

    public function saveSession() {
        
    }

}
