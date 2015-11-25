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
    private $router = null;
    private $appConfig = null;
    private static $loger = null;
    private $connectionsDB = [];
    private $_session = null;

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
        self::$loger = \GTFramework\Loger::getInstance();
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

        LOG < 0 ? : self::$loger->log('run method in App started.');
        $this->_frontController = \GTFramework\FrontController::getInstance();

        LOG < 2 ? : self::$loger->log('getInstance in App to FrontController called');
        $this->appConfig = \GTFramework\App::getInstance()->getConfig()->app;

        LOG < 2 ? : self::$loger->log('getConfig method in App called with app param.');
        if (isset($this->appConfig['default_router']) && $this->appConfig['default_router']) {
            if (!$this->router) {
                $this->router = '\\GTFramework\\Routers\\' . $this->appConfig['default_router'];
            } else {
                $this->router = '\\GTFramework\\Routers\\' . $this->router;
            }
            $this->_frontController->setRouter(new $this->router);
            LOG < 2 ? : self::$loger->log('Router in App set to: ' . $this->router);
        } else {
            LOG < 1 ? : self::$loger->log('Created exeption in App because of missing default_router key in app config', 1);
            throw new \Exception('Default Router is not set', 500);
        }

        $_sess = $this->appConfig['session'];
        LOG < 0 ? : self::$loger->log('run in App retrieved session configuration: ' . print_r($_sess, TRUE));
        if ($_sess['autostart'] === true) {
            if ($_sess['type'] === 'native') {
                $_s = new \GTFramework\Sessions\NativeSession(
                        $_sess['name'], $_sess['lifetime'], $_sess['path'], $_sess['domain'], $_sess['secure'], $_sess['HttpOnly'], self::$loger);

                LOG < 0 ? : $this->loger->log('run in App created session of type: ' . $_sess['type'] . ' with: ' . print_r($_sess, TRUE));
            } else if ($_sess['type'] === 'database') {
                $_s = new \GTFramework\Sessions\DBSession(
                        self::$loger, $_sess['dbName'], $_sess['dbConnection'], $_sess['dbTable'], $_sess['name'], $_sess['lifetime'], $_sess['path'], $_sess['domain'], $_sess['secure'], $_sess['HttpOnly']);
                LOG < 0 ? : self::$loger->log('run in App created session of type ' . $_sess['type'] . ' with: ' . print_r($_sess, TRUE));
            } else {
                throw new \Exception('Received invalid session type: ' . $_sess['type'], 500);
            }
            $this->setSession($_s);
        }

        LOG < 1 ? : self::$loger->log('run in App called dispatch method in FrontController');
        $this->_frontController->dispatch();
    }

    public function setSession(\GTFramework\Sessions\ISession $session) {
        $this->_session = $session;
    }

    public function getSession() {
        return $this->_session;
    }

    public function getConnectionToDB($connection = 'default') {
        if (!isset($this->connectionsDB)) {
            throw new \Exception('No Database connection identifier found', 500);
        }
        if (isset($this->connectionsDB[$connection])) {
            return $this->connectionsDB[$connection];
        }
        $_cfg = $this->getConfig()->db;
        if (!isset($_cfg[$connection])) {
            throw new \Exception('Provided identifier is invalid', 500);
        }
        $dbh = new \PDO($_cfg[$connection]['connection_uri'], $_cfg[$connection]['username'], $_cfg[$connection]['password'], $_cfg[$connection]['pdo_options']);
        $this->connectionsDB[$connection] = $dbh;
        return $dbh;
    }

    function get_frontController() {
        LOG < 1 ? : self::$loger->log('get_frontController method in App called.');
        return $this->_frontController;
    }

    function set_frontController(\GTFramework\FrontController $_frontController) {
        LOG < 1 ? : self::$loger->log('set_frontController method in App called with params: ' . $_frontController);
        $this->_frontController = $_frontController;
    }

    public function getRouterByName() {
        LOG < 2 ? : self::$loger->log('getRouterByName in App method called ');
        return $this->router;
    }

    public function setRouterByName($router) {
        self::$loger->setLogGlobal();
        LOG < 2 ? : self::$loger->log('setRouterByName in App method called with params: ' . $router);
        $this->router = $router;
    }

    public static function getLoger() {
        return self::$loger;
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
