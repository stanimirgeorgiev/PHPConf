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
     * @var \GTFramework\Logger
     */
    private $logger;
    
    public function __construct(
            $name = null,
            $lifetime = 3600,
            $path = null,
            $domain = null,
            $secure = false ,
            $httponly = TRUE
            ) {
        if (strlen($name)<1) {
            $name = '_sess';
        }
        
        $this->logger = \GTFramework\App::getLogger();
        LOG < 2 ?: $this->logger->log('__construct in NativeSession created with params: name: '.$name.' lifetime: '. $lifetime.' path: '.$path.' domain: '.$domain.' secure: '.$secure.' httpOnly: '.$httponly);
        session_name($name);
        session_set_cookie_params($lifetime,$path, $domain, $secure, $httponly);
        session_start();
        $_COOKIE['__sess'] = session_id();
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

