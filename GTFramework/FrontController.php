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
    private $bundle = null;
    private $routes = null;
    private $router = null;

    private function __construct() {
        
    }

    public function getRouter() {
        return $this->router;
    }

    public function setRouter(\GTFramework\Routers\IRouter $router) {
        $this->router = $router;
    }

    public function dispatch() {
        if ($this->router == NULL) {
            throw new \Exception('Router is not set', 500);
        }
//        $defaultRouter = \GTFramework\App::getInstance()->getConfig()->app;
//        echo '<pre>' . print_r($defaultRouter['default_router'], TRUE) . '</pre>'.'<br />';
//        $routerPath = '\\GTFramework\\Routers\\'.$defaultRouter['default_router'];
//        $dr = new $routerPath();
//        echo '<pre>' . print_r($this->router, TRUE) . '</pre>'.'<br />';
        $_uri = $this->router->getURI();
        $_rc = null;
        $this->routes = \GTFramework\App::getInstance()->getConfig()->routes;
//                echo $_uri.'||||||<br />';
//        '<pre>'.var_dump($this->routes).'</pre>'.'<br />';
//        var_dump($_uri).'<br />';
        if (is_array($this->routes) && count($this->routes) > 0) {
            foreach ($this->routes as $k => $v) {
//                echo '<pre>' . print_r($_uri, TRUE) . '</pre><br />';
                $checkIsBundle = explode('/', $_uri)[0];
//                echo '<pre>' . print_r($checkIsBundle, TRUE) . '</pre><br />';
//                echo '<pre>' . print_r($k, TRUE) . '</pre>'.'<br />';
//                echo '<pre>' . print_r($v, TRUE) . '</pre>'.'<br />';
                if (stripos(strtolower($checkIsBundle), strtolower($k)) === 0 && (stripos(strtolower($checkIsBundle), strtolower($k) . '/') === 0 || strtolower($checkIsBundle) === strtolower($k) )) {
//                        echo $_uri.'<br />';
                    if (isset($v['namespace'])) {
                        $this->ns = $v['namespace'];
//                        echo $this->ns.'<br />';
                    } else {
                        throw new \Exception('Namespace is missing in config for the ' . $k . ' bundle', 500);
                    }
                    $_uri = substr($_uri, strlen($k) + 1);
//                    echo '<pre>-----' . print_r($_uri, TRUE) . '</pre>Urii sled kato sme mahnali dylvinata na osnowniq bundyl<br />';
                    if (isset($v['controller'])) {
                        $_rc = $v['controller'];
                    }
                    $this->bundle = strtolower($k);
//                    echo $this->bundle.'??????????????????????????????????<br />';
                    break;
                }
            }
        } else {
            throw new \Exception('Missing default routes confiuration', 500);
        }
        if ($this->ns == NULL && isset($this->routes['*']['namespace'])) {
            $this->ns = $this->routes['*']['namespace'];
            if (isset($this->routes['*']['controller'])) {
                $_rc = $this->routes['*']['controller'];
            }
        } else if ($this->ns == NULL) {
            throw new \Exception('Default configuration for namespace is missing', 500);
        }
        if (substr($_uri, -1) === '/') {
            $_uri = substr($_uri, 0, -1);
//            echo $_uri . '---sub<br>';
        }
        $_params = explode('/', $_uri);
//        echo '<pre>' . print_r($_params, TRUE) . '</pre>'.'<br />';
//        '<pre>'.var_dump($this->routes[$this->bundle]).'</pre>'.'<br />';
        if (isset($_params[0]) && trim($_params[0])) {
//            echo trim($_params[0]) . '----<br>';
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
//      echo '<pre>' . print_r($_params, TRUE) . '<br>' . $this->controller . '<br>' . $this->method . '<br>' . '</pre>';
        $f = $this->ns . '\\' . ucfirst($this->controller);
        $newController = new $f();
        if (method_exists($newController, $this->method)) {
            $newController->{$this->method}($_params);
        } else {
            throw new \Exception('Called nonexistent method: ' . $this->method, 404);
        }
    }

    public function getDefaultControler() {
        if ($this->bundle != NULL && $this->bundle != '*') {
            if (isset($this->routes[$this->bundle])) {
                if (isset($this->routes[$this->bundle]['default_controller'])) {

                    return strtolower(trim($this->routes[$this->bundle]['default_controller']));
                } else {
                    throw new \Exception('Default controller must be provided in routes for the ' . $this->bundle . ' bundle', 500);
                }
            } else {
                if (isset($this->routes[ucfirst($this->bundle)]['default_controller'])) {

                    return strtolower(trim($this->routes[ucfirst($this->bundle)]['default_controller']));
                } else {
                    throw new \Exception('Default controller must be provided in routes for the ' . $this->bundle . ' bundle', 500);
                }
            }
        }
        $controller = \GTFramework\App::getInstance()->getConfig()->app['default_controller'];
        if (trim($controller)) {
            return strtolower($controller);
        }
        return 'index';
    }

    public function getDefaultMethod() {
        if ($this->bundle != NULL && $this->bundle != '*') {
            if (isset($this->routes[$this->bundle])) {
                if (isset($this->routes[$this->bundle]['default_method'])) {

                    return strtolower(trim($this->routes[$this->bundle]['default_method']));
                } else {
                    throw new \Exception('Default method must be provided in routes for the ' . $this->bundle . ' bundle', 500);
                }
            } else {
                if (isset($this->routes[ucfirst($this->bundle)]['default_method'])) {

                    return strtolower(trim($this->routes[ucfirst($this->bundle)]['default_method']));
                } else {
                    throw new \Exception('Default method must be provided in routes for the ' . $this->bundle . ' bundle', 500);
                }
            }
        }
        $method = \GTFramework\App::getInstance()->getConfig()->app['default_method'];
        if (trim($method)) {
            return strtolower($method);
        }
        return 'index';
    }

    /**
     * 
     * @return \GTFramework\FrontController
     */
    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new \GTFramework\FrontController();
        }
        return self::$_instance;
    }

}
