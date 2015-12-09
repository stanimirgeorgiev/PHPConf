<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GTFramework;

/**
 * Description of Kernel
 *
 * @author ACER
 */
class Kernel {

    private $params = null;
    private $method = null;
    private $logger = null;
    private $class = null;
    private static $_instance = null;

    private function __construct(\GTFramework\Logger $logger) {
        $this->logger = $logger;
    }

    public function findController($class = null, $method = null, $params = null) {
        $this->class = $class;
        $this->method = $method;
        $this->params = $params;

        if (!class_exists($class)) {
            throw new \Exception('Class: ' . $class . ' non existent', 404);
        }
        if (!method_exists($class, $method)) {
            throw new \Exception('Method: ' . $method . ' non existent', 404);
        }
        
        if (!\GTFramework\AnnotationValidation::getInstance()->validate($class, $method)) {
            throw new \Exception('Class: ' . $class . 'and Method: ' . $method . 'Invalidated by annotations: ' . \GTFramework\AnnotationValidation::getInstance()->getAnnotations($param));
        }
        $controller = new $class;
        if ($params !== null) {
            $controller->$method($params);
        }
        $controller->$method();
    }

    public function checkAnotations($class, $method) {
        
    }
    
    public function helper($helperClass, $helperMethod) {

        if (!trim($helperClass) && !trim($helperMethod)) {
            throw new \Exception('Helpers require valid class full name and method name', 500);
        }

        if (!class_exists($helperClass)) {
            throw new \Exception('Class with name: ' . $helperClass . ' doesn\'t exist in namespace', 500);
        }

        $helperObject = new $helperClass;

        if (!method_exists($helperObject, $helperMethod)) {
            throw new \Exception('Method with name: ' . $helperMethod . ' do not exist in class: ' . print_r($helperObject, TRUE), 500);
        }

        return $helperObject->$helperMethod();
    }
    
    /**
     * 
     * @return \GTFramework\Kernel
     */
    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new \GTFramework\Kernel(\GTFramework\App::getLogger());
        }
        return self::$_instance;
    }

}
