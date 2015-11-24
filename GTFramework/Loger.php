<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GTFramework;

/**
 * Description of Logger
 *
 * @author ACER
 */
class Loger {

    private static $_instance;
    private $_arrLogs = [];
    private  $loggingLevel = null;

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
    
    public function getLogs() {
        return $this->_arrLogs;
    }

    public function chekBeforeLog($log, $logLvl) {
        if ($this->loggingLevel == NULL) {
            if (isset(\GTFramework\App::getInstance()->getConfig()->app['default_logging'])) {
                $this->loggingLevel = \GTFramework\App::getInstance()->getConfig()->app['default_logging'];
            }
        }
        if ($this->loggingLevel >= $logLvl) {
//            echo '<pre>' . print_r($log, TRUE) . '</pre><br />';
            array_push($this->_arrLogs, date('Y M d h:s:') . gettimeofday()['usec'] . ': ' . $log);
        }
    }

    /**
     * 
     * @return \GTFramework\Loger
     */
    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new \GTFramework\Loger();
        }
        return self::$_instance;
    }

}
