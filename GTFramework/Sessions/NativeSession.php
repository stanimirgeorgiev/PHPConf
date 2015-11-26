<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GTFramework\Sessions;

/**
 * Description of NativeSession
 *
 * @a thor ACER
 */
class NativeSession implements \GTFramework\Sessions\ISession{

    /**
     * @var \GTFramework\Loger
     */
    private $loger;
    
    public function __construct($name = null, $lifetime = 3600,$path = null, $domain = null, $secure = false ,$httponly = TRUE , \GTFramework\Loger $loger) {
        if (strlen($name)<1) {
            $name = '_sess';
        }
        
        $this->loger = $loger;
        LOG < 2 ?: $this->loger->log('__construct in NativeSession created with params: name: '.$name.' lifetime: '. $lifetime.' path: '.$path.' domain: '.$domain.' secure: '.$secure.' httpOnly: '.$httponly);
        echo '<pre>' . print_r($lifetime, TRUE) . '</pre><br />';
        session_name($name);
        session_set_cookie_params($name, $lifetime, $domain, $secure, $httponly);
        session_start();
    }

    public function __get($name) {
        return $_SESSION[$name];
    }

    public function __set($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function destroySession() {
        session_destroy();
    }

    public function getSessionId() {
        return session_id();
    }

    public function saveSession() {
        session_write_close();
    }
}

