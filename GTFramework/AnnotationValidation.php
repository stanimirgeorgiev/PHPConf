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
     * @var \ReflectionClass
     */
    private $logger = null;
    private $reflection = null;
    private $httpVerbs = array(
        'GET' => 0,
        'POST' => 0,
        'PUT' => 0,
        'DELETE' => 0
    );
    private $docMethod = null;
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
        'http' => 0,
        'ip' => 0,
        'lt' => 0,
        'matches' => 0,
        'matchesStrict' => 0,
        'maxlength' => 0,
        'minlength' => 0,
        'numeric' => 0,
        'regexp' => 0,
//        'required' => 0,
        'unauthorized' => 0,
        'url' => 0
    );

//    private static $_instance = null;
//    private function __construct(\GTFramework\Logger $logger) {
//        $this->logger = $logger;
//    }

    public function __construct($class) {
        $this->logger = \GTFramework\App::getLogger();
        $this->reflection = new \ReflectionClass($class);
    }

    public function getAnnotations() {
        
    }

    public function validate($method) {
        $classAnnotation = $this->getClassAnnotations();
        $methodAnnotation = $this->getMethodAnnotations($method);
        $isClassValid = TRUE;
        foreach ($classAnnotation as $method => $params) {
            echo '<pre>' . print_r($classAnnotation, TRUE) . '</pre><br />';
            echo '<pre>' . print_r($method . '(' . $params . ')', TRUE) . '</pre><br />';
            $validate = $this->$method($params);
            if (!$validate) {
                $isClassValid = FALSE;
                break;
            }
        }
        $isMethodValid = TRUE;
        foreach ($methodAnnotation as $method => $params) {
            $validate = $this->$method($params);
            if (!$validate) {
                $isMethodValid = FALSE;
                break;
            }
        }
        if ($isMethodValid && $isClassValid) {
            return TRUE;
        }
        return FALSE;
    }

    public function getMethodAnnotations($method) {
        $docMethod = $this->reflection->getMethod($method)->getDocComment();
        if (!$docMethod) {
            return [];
        }
        $docMethod = explode('* *', $docMethod);
        array_pop($docMethod);
        array_shift($docMethod);
        $docMethod = array_filter($docMethod, 'trim');
        $annotationArray = [];
        foreach ($docMethod as $a) {
            $a = explode('[', trim($a));
            $arg = rtrim(array_pop($a), ']');
            $annotationArray[strtolower($a[0])] = $arg;
        }
        return $annotationArray;
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
        $annotationArray = [];
        foreach ($docClass as $a) {
            $a = explode('[', trim($a));
            $arg = rtrim(array_pop($a), ']');
            $annotationArray[strtolower($a[0])] = $arg;
        }
        return $annotationArray;
    }

    public static function authorized($role = 30) {
        $userLevel = new \Models\RolesModel();
        $userLevel->getRoleByName($role);
//        $loggedUser = new \Models\UserModel();
//        $loggedUser->
        return (bool) $userLevel;
    }

    public static function unauthorized() {
        return TRUE;
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

    public function http($http = NULL) {

        $http = explode(' ', $http);
        if (isset($this->httpVerbs[$http[0]])) {
            return TRUE;
        }
        return FALSE;
    }

    public static function custom($val1, $val2) {
        if ($val2 instanceof \Closure) {
            return (boolean) call_user_func($val2, $val1);
        } else {
            throw new \Exception('Invalid validation function', 500);
        }
    }

//
//    /**
//     * 
//     * @return \GTFramework\AnnotationValidation
//     */
//    public static function getInstance() {
//        if (self::$_instance == null) {
//            self::$_instance = new \GTFramework\AnnotationValidation(\GTFramework\App::getLogger());
//        }
//        return self::$_instance;
//    }
}
