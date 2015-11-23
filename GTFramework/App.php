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
    private $loger;

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
        if ($this->_config->_configFolder == NULL) {
            $this->_config->setConfigFolder('../config');
        }
        $this->loger = \GTFramework\Loger::getInstance();
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
        $this->loger->chekBeforeLog('run method in App started.', 0);
        $this->_frontController = \GTFramework\FrontController::getInstance();
        
        $this->loger->chekBeforeLog('getInstance in App to FrontController called', 2);
        $this->appConfig = \GTFramework\App::getInstance()->getConfig()->app;
        
        $this->loger->chekBeforeLog('getConfig method in App called with app param.', 2);
        if (isset($this->appConfig['default_router']) && $this->appConfig['default_router']) {
            if (!$this->router) {
                $this->router = '\\GTFramework\\Routers\\' . $this->appConfig['default_router'];
            } else {
                $this->router = '\\GTFramework\\Routers\\' . $this->router;
            }
            $this->_frontController->setRouter(new $this->router);
            $this->loger->chekBeforeLog('Router in App set to: ' . $this->router, 2);
        } else {
            $this->loger->chekBeforeLog('Created exeption in App because of missing default_router key in app config', 1);
            throw new \Exception('Default Router is not set', 500);
        }
        $this->loger->chekBeforeLog('run in App called dispatch method in FrontController.', 1);
        $this->_frontController->dispatch();
    }

    function get_frontController() {
        $this->loger->chekBeforeLog('get_frontController method in App called.', 1);
        return $this->_frontController;
    }

    function set_frontController(\GTFramework\FrontController $_frontController) {
        $this->loger->chekBeforeLog('set_frontController method in App called with params: ' . $_frontController, 1);
        $this->_frontController = $_frontController;
    }

    public function getRouterByName() {
        $this->loger->chekBeforeLog('getRouterByName in App method called ', 2);
        return $this->router;
    }

    public function setRouterByName($router) {
        $this->loger->chekBeforeLog('setRouterByName in App method called with params: ' . $router, 2);
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
