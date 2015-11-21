<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of App
 *
 * @author ACER
 */

namespace GTFramework;

include_once 'Loader.php';

class App {

    private static $_instance = null;

    /**
     *
     * @var \GTFramework\Config
     */
    private $_config = null;
    private $router;
    private $appConfig;

        /**
     *
     * @var \GTFramework\FrontController    
     */
    private $_frontController = null;
    
    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    private function __construct() {
        \GTFramework\Loader::registerNamespace('GTFramework', dirname(__FILE__) . DIRECTORY_SEPARATOR);
        \GTFramework\Loader::registerAutoLoad();
        $this->_config = \GTFramework\Config::getInstance();
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

//    public function getConfigFolder() {
//        echo 'getConfigFolder in App is called ' . $this->_counter++ . '<br>';
//        echo '<pre>' . print_r($this->_config, TRUE) . '</pre>';
//        return $this->_config->_configFolder;
//    }

    public function setConfigFolder($path) {
        $this->_config->setConfigFolder($path);
    }

    /**
     * 
     * @return \GTFramework\Config
     */
    public function getConfig() {
        return $this->_config;
    }

    public function run() {
        if ($this->_config->_configFolder == NULL) {
            $this->_config->setConfigFolder('../config');
        }
        $this->_frontController = \GTFramework\FrontController::getInstance();
        $this->appConfig = \GTFramework\App::getInstance()->getConfig()->app;
        if (isset($this->appConfig['default_router']) && $this->appConfig['default_router']) {
            if (!$this->router) {
            $this->router = '\\GTFramework\\Routers\\'.$this->appConfig['default_router'];
            } else {
                $this->router = '\\GTFramework\\Routers\\'.$this->router;
            }
            $this->_frontController->setRouter(new $this->router);
//            echo '<pre>' . print_r($this->router, TRUE) . '</pre>---!!!---<br />';
        } else {
            throw new \Exception('Default Router is not set', 500);
        }
        $this->_frontController->dispatch();
    }
    function get_frontController() {
        return $this->_frontController;
    }

    function set_frontController(\GTFramework\FrontController $_frontController) {
        $this->_frontController = $_frontController;
    }

    public function getRouterByName() {
        return $this->router;
    }

    public function setRouterByName($router) {
        $this->router = $router;
    }

    
    /**
     * 
     * @return \GTFramework\App
     */
    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new \GTFramework\App();
        }
        return self::$_instance;
    }

}
