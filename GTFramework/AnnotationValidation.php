<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GTFramework;

/**
 * Description of AnnotationValidation
 *
 * @author ACER
 */
class AnnotationValidation {

    private $class;
    private $method;
    private $reflection;
    private $annotationsList = [
        'Authorized' => ['You are not authorized', 401 ],
        'Unauthorized' => [],
        'Required' => ['The field is required', 500],
    ];
    static $_instance = null;

    private function __construct() {
    }

    public function getAnnotations($param) {
        
    }
    public function validate($class, $method) {
        $ref = new \ReflectionClass($class);
        $classAnnotation = $reflection->getDocComment();
        $methodAnnotation = $reflection->getMethod($method)->getDocComment();
        $doc = explode('* *', $ref->getMethod('index')->getDocComment());
        array_pop($doc);
        array_shift($doc);
        $doc= array_filter($doc,'trim');
        foreach ($this->annotationsList as $annotation => $error) {
            if ($methodAnnotation === $annotation) {
                
            }
        }
        
        
    }
    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new \GTFramework\AnnotationValidation(\GTFramework\App::getLoger());
        }
        return self::$_instance;
    }

}
