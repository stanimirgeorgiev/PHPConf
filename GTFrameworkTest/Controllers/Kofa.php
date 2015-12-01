<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kofa
 *
 * @author ACER
 */

namespace Controllers;

/**
 * 
 * *Authorized[]* *
 */
class Kofa implements \Controllers\IController {

    private $ref = null;
    private $methods = null;
    private $method = null;
    private $class = null;

    public function __construct() {
        $this->class = 'Controllers\Kofa';
        $this->method = 'index';
        $this->ref = new \ReflectionClass($this->class);
    }

    /**
     * 
     * *Authorized[Admin]* *
     * *Unauthorized[]* *
     * 
     * @param type $params
     * @return void proba
     * 
     */
    public function index($params) {
        $anno = $this->gerAnnotation($this->class, $this->method);
        if (empty($anno)) {
            return ['No annotations', 200];
        }
        foreach ($anno as $a) {
            $a = explode('[', trim($a));
            $arg = rtrim(array_pop($a),']');
//            $this->
            $a = $a[0];
            $this->verify($a, $arg);
            echo '<pre>' . print_r($arg, TRUE) . '</pre><br />';
            echo '<pre>' . print_r($a, TRUE) . '</pre><br />';
        }
//        switch ($a);
        echo '<pre>' . print_r($anno, TRUE) . '</pre><br />';
    }

    public function gerAnnotation($class, $method) {
        $doc = $this->ref->getMethod($method)->getDocComment();
        if (!$doc) {
            return [];
        }
        $doc = explode('* *', $doc);
        array_pop($doc);
        array_shift($doc);
        $doc = array_filter($doc, 'trim');
        return $doc;
    }

    /**
     * *Authorized[]* *
     */
    public function roro() {
        echo 'Roro is called';
    }

    public function verify($a, $arg) {
        switch ($a) {
            case 'Authorized':
                echo '<pre>' . print_r('Method ?????? is authorized', TRUE) . '</pre><br />';
                break;
            
            case 'Unauthorized':
                echo '<pre>' . print_r('Method ?????? is unauthorized', TRUE) . '</pre><br />';
                break;
            
            case 'Required':
                echo '<pre>' . print_r('Method ?????? is required', TRUE) . '</pre><br />';
                break;
            
            default:
                break;
        }
    }

}
