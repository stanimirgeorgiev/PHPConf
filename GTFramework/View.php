<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GTFramework;

/**
 * Description of Veiw
 *
 * @author ACER
 */
class View {

    private static $_instance = null;
    private $___viewPath = null;
    private $___data = [];
    private $___viewDir = null;
    private $___layoutParts = [];
    private $___layoutData = [];
    private $___loger = null;
    private $___cdn = null;
    private $___method = null;

    private function __construct(\GTFramework\Loger $loger) {

        $this->___viewPath = \GTFramework\App::getInstance()->getConfig()->app['viewPath'];

        if ($this->___viewPath === NULL) {
            $this->___viewPath = realpath('../views/');
        }

        $this->___loger = $loger;

        LOG < 2 ? : $this->___loger->log('__construct in View called with params: ' . $this->___viewPath);
    }

    public function display($name, $data = [], $returnAsString = FALSE) {

        LOG < 2 ? : $this->___loger->log('dispaly in View called with params: ' . $name . ', ' . print_r($data, true) . ', ' . $returnAsString);

        if (is_array($data)) {
            $this->___data = array_merge($this->___data, $data);
        }

        if (count($this->___layoutParts) > 0) {

            foreach ($this->___layoutParts as $k => $v) {

                $r = $this->_includeFile($v);

                if ($r) {
                    $this->___layoutData[$k] = $r;
                }
            }
        }

        if ($returnAsString) {
            return $this->_includeFile($name);
        } else {
            echo $this->_includeFile($name);
        }
    }

    public function getLayoutData($name) {
        return $this->___layoutData[$name];
    }

    public function appendToLayout($key, $template) {

        if (!$key && !$template) {
            throw new \Exception('Layout require valid key and template', 500);
        }
    
        $this->___layoutParts[$key] = $template;
    }

    public function _includeFile($file) {
        
        if ($this->___viewDir === NULL) {
            $this->setViewFolder($this->___viewPath);
        }

        $___fl = $this->___viewDir . str_replace('/', DIRECTORY_SEPARATOR, $file);

        if (!file_exists($___fl) && !is_readable($___fl)) {
            throw new \Exception('View file ' . $___fl . ' cannot be included', 500);
        }

        ob_start();
        include $___fl;
        return ob_get_clean();
    }

    public function helper($helperClass, $helperMethod) {

        if (!trim($helperClass) && !trim($helperMethod)) {
            throw new \Exception('Helpers require valid class full name and method name', 500);
        }

        if (!class_exists($helperClass)) {
            echo '<pre>' . print_r($helperClass, TRUE) . '</pre><br />';
            throw new \Exception('Class with name: ' . $helperClass . ' doesn\'t exist in namespace', 500);
        }

        $helperObject = new $helperClass;

        if (!method_exists($helperObject, $helperMethod)) {
            throw new \Exception('Method with name: ' . $helperMethod . ' do not exist in class: ' . print_r($helperObject, TRUE), 500);
        }

        return $helperObject->$helperMethod();
    }
    

    public function addView($viewClass, $viewMethod) {

        if (!trim($viewClass) && !trim($viewMethod)) {
            throw new \Exception('Views require valid class name and method name', 500);
        }

        if (!class_exists($viewClass)) {
            throw new \Exception('Class with name: ' . $viewClass . ' doesn\'t exist in namespace', 500);
        }

        $viewObject = new $viewClass;

        if (!method_exists($viewObject, $viewMethod)) {
            throw new \Exception('Method with name: ' . $viewMethod . ' do not exist in class: ' . print_r($viewObject, TRUE), 500);
        }

        $viewObject->$viewMethod();
    }
    
    public function __set($name, $value) {
        $this->___data[$name] = $value;
    }

    public function __get($name) {
        return isset($this->___data[$name]) ? $this->___data[$name] : '';
    }

    public function setViewFolder($path) {

        $path = trim($path);

        if (!$path) {
            throw new \Exception('Invalid view path: ' . $path, 404);
        }

        $path = realpath($path) . DIRECTORY_SEPARATOR;

        if (!is_readable($path) && !is_dir($path)) {
            throw new \Exception('Invalid view path: ' . $path, 404);
        }

        $this->___viewDir = $path;
    }
        
    /**
     * @var $cnd
     * @return \GTFrameworkTest\config\cdn
     * @throws \Exception
     */
    public function getCDN() {

        $this->___cdn = \GTFramework\App::getInstance()->getConfig()->cdn;

        if (!is_array($this->___cdn) && !count($this->___cdn['cdn']) < 4) {
            throw new \Exception('Problem to read CDN config file', 500);
        }

        return $this->___cdn;
    }

    /**
     * 
     * @return \GTFramework\View
     */
    public static function getInstance() {
        
        if (self::$_instance == NULL) {
            self::$_instance = new \GTFramework\View(\GTFramework\App::getLoger());
        }
        
        return self::$_instance;
    }

}
