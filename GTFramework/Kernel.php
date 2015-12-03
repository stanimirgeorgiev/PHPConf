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

    private $params =null;
    private $method = null;
    private $loger = null;
    private $class = null;

    public function __construct(\GTFramework\Loger $loger) {
        $this->loger = $loger;
    }
    public function findController($class, $method) {
        $this->class = $class;
        $this->method= $method;
        if (!class_exists($class)) {
            throw new \Exception('Class: '. $class.' non existent', 500);
        }
        if (!method_exists($class, $method)) {
            throw new \Exception('Method: '. $method.' non existent', 500);
        }
        if (!\GTFramework\AnnotationValidation::getInstance()->validate($class, $method)) {
            throw new \Exception('Class: '.$class.'and Method: '.$method.'Invalidated by annotations: '.\GTFramework\AnnotationValidation::getInstance()->getAnnotations($param));
        }
        
    }
    public function checkAnotations($class, $method) {
        
    }
}
