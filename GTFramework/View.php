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
    private $___extension = '.php';
    private $___layoutParts = [];
    private $___layoutData = [];
    private $___loger = null;

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
        if ($key && $template) {
            $this->___layoutParts[$key] = $template;
        } else {
            throw new \Exception('Layout require valid key and template', 500);
        }
    }

    public function _includeFile($file) {
        if ($this->___viewDir === NULL) {
            $this->setViewFolder($this->___viewPath);
        }
        $___fl = $this->___viewDir . str_replace('/', DIRECTORY_SEPARATOR, $file) . $this->___extension;
        if (file_exists($___fl) && is_readable($___fl)) {
            ob_start();
            include $___fl;
            return ob_get_clean();
        } else {
            throw new \Exception('View file ' . $___fl . ' cannot be included', 500);
        }
    }

    public function __set($name, $value) {
        $this->___data[$name] = $value;
    }

    public function __get($name) {
        return isset($this->___data[$name]) ? $this->___data[$name] : '';
    }

    public function setViewFolder($path) {
        $path = trim($path);
        if ($path) {
            $path = realpath($path) . DIRECTORY_SEPARATOR;
            if (is_readable($path) && is_dir($path)) {
                $this->___viewDir = $path;
            } else {
                throw new \Exception('Invalid view path: ' . $path, 404);
            }
        } else {
            throw new \Exception('Invalid view path: ' . $path, 404);
        }
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
