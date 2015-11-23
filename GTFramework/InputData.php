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

    public function __construct() {

        $this->_cookie = $_COOKIE;
        $this->loger = \GTFramework\Loger::getInstance();
    }

    public function setGet($arr) {
        $this->loger->chekBeforeLog('setGet in InputData called', 2);
        if (is_array($arr)) {
            $this->_get = $arr;
        }
    }

    public function setPost($arr) {
        $this->loger->chekBeforeLog('setPost in InputData called', 2);
        if (is_array($arr)) {
            $this->_post = $arr;
        }
    }

    public function hasGet($id) {
        $this->loger->chekBeforeLog('hasGet in InputData called', 2);
        return array_key_exists($id, $this->_get);
    }

    public function hasPost($name) {
        $this->loger->chekBeforeLog('hasPost in InputData called', 2);
        return array_key_exists($name, $this->_post);
    }

    public function hasCookies($name) {
        $this->loger->chekBeforeLog('hasCookies in InputData called', 2);
        return array_key_exists($name, $this->_cookie);
    }

    public function get($id, $normalize = null, $default = null) {
        $this->loger->chekBeforeLog('get in InputData called with params: '.$id.' - '.$normalize.' - '.$default, 2);
        if ($this->hasGet($id)) {
            if ($normalize != null) {
                return \GTFramework\Common::normalize($this->_get[$id], $normalize);
            }
            return $this->_get[$id];
        }

        return $default;
    }

    public function post($name, $normalize = null, $default = null) {
        $this->loger->chekBeforeLog('post in InputData called with params: '.$id.' - '.$normalize.' - '.$default, 2);
        if ($this->hasPost($name)) {
            if ($normalize != null) {
                return \GTFramework\Common::normalize($this->_post[$name], $normalize);
            }
            return $this->_post[$name];
        }

        return $default;
    }

    public function coocies($name, $normalize = null, $default = null) {
        $this->loger->chekBeforeLog('coocies in InputData called with params: '.$id.' - '.$normalize.' - '.$default, 2);
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
            self::$_instance = new \GTFramework\InputData();
        }
        return self::$_instance;
    }

}
