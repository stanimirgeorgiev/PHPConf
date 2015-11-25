<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InputData
 *
 * @author ACER
 */
namespace \GTFramework;

class InputData {

    private static $_instance = null;
    private $_get = null;
    private $_post = null;
    private $_cookie = null;
    private $loger = null;

    public function __construct(\GTFramework\Loger $loger) {
        
        $this->_cookie = $_COOKIE;
        $this->loger = $loger;
    }

    public function setGet($arr) {
        LOG < 2 ?: $this->loger->log('setGet in InputData called', 2);
        if (is_array($arr)) {
            $this->_get = $arr;
        }
    }

    public function setPost($arr) {
        LOG < 2 ?: $this->loger->log('setPost in InputData called', 2);
        if (is_array($arr)) {
            $this->_post = $arr;
        }
    }

    public function hasGet($id) {
        LOG < 2 ?: $this->loger->log('hasGet in InputData called', 2);
        return array_key_exists($id, $this->_get);
    }

    public function hasPost($name) {
        LOG < 2 ?: $this->loger->log('hasPost in InputData called', 2);
        return array_key_exists($name, $this->_post);
    }

    public function hasCookies($name) {
        LOG < 2 ?: $this->loger->log('hasCookies in InputData called', 2);
        return array_key_exists($name, $this->_cookie);
    }

    public function get($id, $normalize = null, $default = null) {
        LOG < 2 ?: $this->loger->log('get in InputData called with params: '.$id.' - '.$normalize.' - '.$default, 2);
        if ($this->hasGet($id)) {
            if ($normalize != null) {
                return \GTFramework\Common::normalize($this->_get[$id], $normalize);
            }
            return $this->_get[$id];
        }

        return $default;
    }

    public function post($name, $normalize = null, $default = null) {
        LOG < 2 ?: $this->loger->log('post in InputData called with params: '.$id.' - '.$normalize.' - '.$default, 2);
        if ($this->hasPost($name)) {
            if ($normalize != null) {
                return \GTFramework\Common::normalize($this->_post[$name], $normalize);
            }
            return $this->_post[$name];
        }

        return $default;
    }

    public function coocies($name, $normalize = null, $default = null) {
        LOG < 2 ?: $this->loger->log('coocies in InputData called with params: '.$id.' - '.$normalize.' - '.$default, 2);
        if ($this->hasCookies($name)) {
            if ($normalize != null) {
                return \GTFramework\Common::normalize($this->_cookie[$name], $normalize);
            }
            return $this->_cookie[$name];
        }

        return $default;
    }

    /**
     * 
     * @return \GTFramework\InputData
     */
    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new \GTFramework\InputData(\GTFramework\App::getLoger());
        }
        return self::$_instance;
    }

}
