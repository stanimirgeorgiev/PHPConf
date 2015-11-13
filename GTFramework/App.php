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
        echo dirname(__FILE__) . DIRECTORY_SEPARATOR.'<br />';
        \GTFramework\Loader::registerNamespace('GTFramework', dirname(__FILE__) . DIRECTORY_SEPARATOR);
        echo 'popopopo<br />';
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
            echo $this->_config->_configFolder.'ooooooooooooooo<br />';
            $this->_config->setConfigFolder('../config');
        echo 'ppppppppppppppppppp<br />';
            
        }
        $this->_frontController = \GTFramework\FrontController::getInstance();
        
        $this->_frontController->dispatch();
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
