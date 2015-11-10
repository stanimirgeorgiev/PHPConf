<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 *
 * @author ACER
 */

namespace GTFramework;

class Config {

    private static $_instance = null;
    private $_configArray = array();
    public $_configFolder = null;

    private function __construct() {
        
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone() {
        
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup() {
        
    }

    public function setConfigFolder($configFolder) {
        if (!$configFolder) {
            throw new \Exception('Empty config folder path!');
        }
        $_configFolder = realpath($configFolder);
        if ($_configFolder != FALSE && is_dir($_configFolder) && is_readable($_configFolder)) {
            $this->_configArray = array();
            $this->_configFolder = $_configFolder . DIRECTORY_SEPARATOR;
            $ns = $this->app['namespaces'];
            if (is_array($ns)) {
//                echo '<pre>' . print_r($ns, TRUE) . '</pre>';
                \GTFramework\Loader::registerNamespaces($ns);
            }
        } else {
            throw new \Exception('Config directory read error: ' . $configFolder);
        }
    }

    public function includeConfigFile($path) {
        //TODO
        if (!$path) {
            throw new \Exception('Invalid config path!');
        }
        $_file = realpath($path);
        if ($_file != FALSE && is_file($_file) && is_readable($_file)) {
            $_baseName = explode('.php', basename($_file))[0];
            $this->_configArray[$_baseName] = include $_file;
        } else {
            throw new \Exeption('Config file read error' . $path);
        }
    }

    public function __get($name) {
        if (!array_key_exists($name, $this->_configArray)) {
            if (!$this->_configFolder) {
                throw new \Exception('Configuration folder is not set.');
            }
            $this->includeConfigFile($this->_configFolder . $name . '.php');
        }
        if (array_key_exists($name, $this->_configArray)) {
            return $this->_configArray[$name];
        }
        return NULL;
    }

    /**
     * 
     * @return \GTFramework\Config
     */
    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new \GTFramework\Config();
        }
        return self::$_instance;
    }

}
