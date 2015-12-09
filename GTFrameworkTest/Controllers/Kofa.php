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

    public function __construct() {
        $this->class = 'Controllers\Kofa';
        $this->method = 'index';
        $this->ref = new \ReflectionClass($this->class);
    }

    /**
     * 
     * *Authorized[Admin]* *
     * *Unauthorized[]* *
     * *Unauthorized[]* *
     * *Unauthorized[]* *
     * *Unauthorized[]* *
     * *http[GET Home]* * 
     * @param type $params
     * @return void proba
     * 
     */
    public function index($params) {
        $anno = $this->getAnnotation($this->method);
        echo '<pre>' . print_r($anno, TRUE) . '</pre><br />';
        if (empty($anno)) {
            echo '<pre>' . print_r('No annotations , 200', TRUE) . '</pre><br />';
            return ['No annotations', 200];
        }
        $annotationArray = [];
        foreach ($anno as $a) {
            $a = explode('[', trim($a));
            $arg = rtrim(array_pop($a), ']');
            $annotationArray[$a[0]] = $arg;

        }
        echo '<pre>' . print_r($annotationArray, TRUE) . ' annotation </pre><br />';
        foreach ($annotationArray as $k => $v) {
            if (isset($this->annotations[$k])) {
                
            }
        }
        $model = new \Models\RolesModel();
        $userModel = new \Models\UserModel();
        $model->getRoleUserLevel(0);
//        $userModel->addUser('Xoko', 'Validate@mam.com', '', '', 'sBabaNaSelo');
        var_dump($userModel->verifyPassword('sBabaNaSelo', 'Qoko'));
        echo '<pre>' . print_r('Otgore e verificiran userskata parola', TRUE) . '</pre><br />';
        
        $this->ref->getMethod('index');
        
        echo '<pre>' . print_r('Proba za Validation annotation na Kofa', TRUE) . '</pre><br />';
        
        $sss = new \GTFramework\AnnotationValidation('Controllers\Kofa');
        $isTrue = $sss ->validate('index');
        var_dump($isTrue);
        $ppo = new \Models\UserModel();
        var_dump($ppo->getUserBySession());
    }

    public function getAnnotation($method) {

        $docMethod = $this->ref->getMethod($method)->getDocComment();

        echo '<pre>' . print_r($docMethod, TRUE) . '</pre><br />';
        if (!$docMethod) {
            return [];
        }
        $docMethod = explode('* *', $docMethod);
        array_pop($docMethod);
        array_shift($docMethod);
        $docMethod = array_filter($docMethod, 'trim');
        return $docMethod;
    }

    /**
     * *Authorized[]* *
     */
    public function roro() {
        echo 'Roro is called';
    }
}
