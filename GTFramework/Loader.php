<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Loader
 *
 * @author ACER
 */

namespace GTFramework;

final class Loader {

    private static $namespaces = array();
    private static $check = false;

    private function __construct() {
        
    }

    public static function registerAutoLoad() {

        spl_autoload_register(array('\GTFramework\Loader', 'autoload'));
    }

    public static function autoload($class) {
        $counter = 0;
        self::loadClass($class);
    }

    public static function loadClass($class) {
        if ($class == 'Exception') {
            throw new \Exception('Unhandled exeption has occured and has been passed to autoload.', 500);
        }
        $isFound = FALSE;
        foreach (self::$namespaces as $key => $value) {
//            echo $key . '<br>'.$value . '<br>'.$class . '<br><hr>';
//            echo '<pre>' . print_r(self::$namespaces, TRUE) . '</pre><hr>';
            if (strpos($class, $key) === 0) {
//                echo str_replace('\\', DIRECTORY_SEPARATOR, $class).'<br>';
//                echo substr_replace(str_replace('\\', DIRECTORY_SEPARATOR, $class), $value, 0, strlen($key)) . '.php <br>';
                $file = realpath(substr_replace(str_replace('\\', DIRECTORY_SEPARATOR, $class), $value, 0, strlen($key)) . '.php');
//                echo '| '.$file.' |' . '<hr><br><hr><br>';

                if ($file && is_readable($file)) {
                    include $file;
                } else {
                    //TODO
//                    echo $file . 'Fila mai e prazen<br>'.$class;
                    throw new \Exception('File cannot be included ' . $key . $value, 404);
                }
                $isFound = TRUE;
                break;
            }
        }
        if (!$isFound) {
            throw new \Exception('Cannot load class ' . $class);
        }
    }

    public static function registerNamespace($namespace, $path) {
        $namespace = trim($namespace);
        if (strlen($namespace) > 0) {
            if (!$path) {
                throw new \Exception('Invalid path');
            }
            $_path = realpath($path);
            if ($_path && is_dir($_path) && is_readable($_path)) {
                self::$namespaces[$namespace . '\\'] = $_path . DIRECTORY_SEPARATOR;
            } else {
                //TODO
                throw new Exception('Namespace directory read error ' . $_path);
            }
        } else {
            //TODO
            throw new \Exception('Invalid namespace: ' . $namespace);
        }
    }

    public static function registerNameSpaces($ns) {
        if (is_array($ns)) {

            foreach ($ns as $k => $v) {
                self::registerNamespace($k, $v);
            }
        } else {
            throw new \Exeption('Invalid namespaces array ' . '<pre>' . print_r($ns, TRUE) . '</pre>');
        }
    }

    public static function getNamespaces() {
        return self::$namespaces;
    }

    public static function setCheck($chek) {
        self::$check = $chek;
    }

    public function removeNamespaces($namespace) {
        unset(self::$namespaces[$namespace]);
    }

    public function clearNamespaces() {
        self::$namespaces = array();
    }

}
