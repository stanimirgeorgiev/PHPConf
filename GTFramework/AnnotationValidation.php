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

    /**
     * @var \GTFramework\Logger
     */
    private $logger = null;
    private $class = null;
    private $method = null;
    private $reflection = null;
    private $annotations = array(
        'alpha' => 0,
        'alphanum' => 0,
        'alphanumdash' => 0,
        'authorized' => 0,
        'different' => 0,
        'differentStrict' => 0,
        'email' => 0,
        'emails' => 0,
        'exactlength' => 0,
        'gt' => 0,
        'ip' => 0,
        'lt' => 0,
        'matches' => 0,
        'matchesStrict' => 0,
        'maxlength' => 0,
        'minlength' => 0,
        'numeric' => 0,
        'regexp' => 0,
        'required' => 0,
        'unauthorized' => 0,
        'url' => 0,
    );
    private $annotationsRetyrns = [
        'Authorized' => ['You are not authorized', 401],
        'Unauthorized' => [],
        'Required' => ['The field is required', 500],
    ];
    static $_instance = null;

    private function __construct(\GTFramework\Logger $loger, \ReflectionClass $reflection) {
        $this->logger = $loger;
        $this->reflection = $reflection;
    }

    public function getAnnotations() {
        
    }

    public function validate($class, $method) {
        $classAnnotation = $this->getMethodAnnotations();
        $methodAnnotation = $this->getMethodAnnotations();
    }

    public function getMethodAnnotations($method = null) {
        $docMethod = $this->reflection->getMethod($method)->getDocComment();
        if (!$docMethod) {
            return [];
        }
        $docMethod = explode('* *', $docMethod);
        array_pop($docMethod);
        array_shift($docMethod);
        $docMethod = array_filter($docMethod, 'trim');
        return $docMethod;
    }

    public function getClassAnnotations() {
        $docClass = $this->reflection->getDocComment();
        if (!$docClass) {
            return [];
        }
        $docClass = explode('* *', $docClass);
        array_pop($docClass);
        array_shift($docClass);
        $docClass = array_filter($docClass, 'trim');
        return $docClass;
    }

    public static function authorized($Role) {
        $roles = \Models\Administration::getInstance()->getByRole($role);
        return $val1 == $val2;
    }
  
    public static function matches($val1, $val2) {
        return $val1 == $val2;
    }

    public static function matchesStrict($val1, $val2) {
        return $val1 === $val2;
    }

    public static function different($val1, $val2) {
        return $val1 != $val2;
    }

    public static function differentStrict($val1, $val2) {
        return $val1 !== $val2;
    }

    public static function minlength($val1, $val2) {
        return (mb_strlen($val1) >= $val2);
    }

    public static function maxlength($val1, $val2) {
        return (mb_strlen($val1) <= $val2);
    }

    public static function exactlength($val1, $val2) {
        return (mb_strlen($val1) == $val2);
    }

    public static function gt($val1, $val2) {
        return ($val1 > $val2);
    }

    public static function lt($val1, $val2) {
        return ($val1 < $val2);
    }

    public static function alpha($val1) {
        return (bool) preg_match('/^([a-z])+$/i', $val1);
    }

    public static function alphanum($val1) {
        return (bool) preg_match('/^([a-z0-9])+$/i', $val1);
    }

    public static function alphanumdash($val1) {
        return (bool) preg_match('/^([-a-z0-9_-])+$/i', $val1);
    }

    public static function numeric($val1) {
        return is_numeric($val1);
    }

    public static function email($val1) {
        return filter_var($val1, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function emails($val1) {
        if (is_array($val1)) {
            foreach ($val1 as $v) {
                if (!self::email($val1)) {
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }

    public static function url($val1) {
        return filter_var($val1, FILTER_VALIDATE_URL) !== false;
    }

    public static function ip($val1) {
        return filter_var($val1, FILTER_VALIDATE_IP) !== false;
    }

    public static function regexp($val1, $val2) {
        return (bool) preg_match($val2, $val1);
    }

    public static function custom($val1, $val2) {
        if ($val2 instanceof \Closure) {
            return (boolean) call_user_func($val2, $val1);
        } else {
            throw new \Exception('Invalid validation function', 500);
        }
    }

    /**
     * 
     * @return \GTFramework\AnnotationValidation
     */
    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new \GTFramework\AnnotationValidation(\GTFramework\App::getLoger(), new \ReflectionClass);
        }
        return self::$_instance;
    }

}
