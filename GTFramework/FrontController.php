<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FrontController
 *
 * @author ACER
 */
namespace GTFramework;

class FrontController {

    private static $_instance = null;
    private $ns = null;
    private $controller = null;
    private $method = null;

    private function __construct() {
        
    }

    public function dispatch() {
        $dc = new \GTFramework\Routers\DefaultRouter();
        $_uri = $dc->getURI();
        $_rc = null;
        $routes = \GTFramework\App::getInstance()->getConfig()->routes;
                echo $_uri.'||||||<br />';
//        '<pre>'.var_dump($routes).'</pre>'.'<br />';
        var_dump($_uri).'<br />';
        if (is_array($routes) && count($routes) > 0) {
            foreach ($routes as $k => $v) {
                echo '<pre>' . print_r($k, TRUE) . '</pre>'.'<br />';
                echo '<pre>' . print_r($v, TRUE) . '</pre>'.'<br />';
                if (stripos($_uri, $k) === 0 && (stripos($_uri, $k . '/') === 0 || $_uri === $k ) ) {
//                        echo $_uri.'<br />';
                    if (isset($v['namespace'])) {
                        $this->ns = $v['namespace'];
                        echo $this->ns.'<br />';
                    }
                    $_uri = substr($_uri, strlen($k) + 1);
                    if (isset($v['controller'])) {
                        $_rc = $v['controller'];
                    }
                    break;
                }
            }
        } else {
            throw new \Exception('Missing default routes confiuration', 500);
        }
        if ($this->ns == NULL && $routes['*']['namespace']) {
            $this->ns = $routes['*']['namespace'];
            if (isset($routes['*']['controller'])) {
                $_rc = $routes['*']['controller'];
            }
        } else if ($this->ns == NULL && !$routes['*']['namespace']) {
            throw new \Exeption('Default configuration for namespace is missing', 500);
        }
        if (substr($_uri, -1) === '/') {
            $_uri = substr($_uri, 0, -1);
//            echo $_uri . '---sub<br>';
        }
        $_params = explode('/', $_uri);
        echo '<pre>' . print_r($_params, TRUE) . '</pre>'.'<br />';
        if (isset($_params[0]) && trim($_params[0])) {
            echo trim($_params[0]) . '----<br>';
            $this->controller = strtolower($_params[0]);
            unset($_params[0]);
        } else {
            $this->controller = $this->getDefaultControler();
        }
        if (isset($_params[1]) && trim($_params[1])) {
            $this->method = strtolower($_params[1]);
            unset($_params[1]);
        } else {
            $this->method = $this->getDefaultMethod();
        }
        $_params = array_values($_params);
//        var_dump($_rc).'<br />';
        if ($_rc && is_array($_rc) && isset($_rc[$this->controller]['to'])) {
            $this->controller = strtolower($_rc[$this->controller]['to']);
//        echo $this->controller.'<br />';
        }
        if (isset($_rc[$this->controller]['method'][$this->method]) && trim($_rc[$this->controller]['method'][$this->method])) {
            $this->method = strtolower($_rc[$this->controller]['method'][$this->method]);
        }
      echo '<pre>' . print_r($_params, TRUE) . '<br>' . $this->controller . '<br>' . $this->method . '<br>' . '</pre>';
        $f = $this->ns.'\\'.ucfirst($this->controller);
        $newController = new $f();
        if (!$this->method) {
        $newController->{$this->method}();
        }
    }

    public function getDefaultControler() {
        $controller = \GTFramework\App::getInstance()->getConfig()->app['default_controller'];
        if (trim($controller)) {
            return strtolower($controller);
        }
        return 'index';
    }

    public function getDefaultMethod() {
        $method = \GTFramework\App::getInstance()->getConfig()->app['default_method'];
        if (trim($method)) {
            return strtolower($method);
        }
        return 'index';
    }

    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new \GTFramework\FrontController();
        }
        return self::$_instance;
    }

}
