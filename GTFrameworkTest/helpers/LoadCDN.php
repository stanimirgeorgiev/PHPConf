<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoadAll
 *
 * @author ACER
 */

namespace Helpers;

class LoadCDN {

    private $content = null;
    private $loger;

    public function __construct() {
        $this->content = \GTFramework\View::getInstance()->getCDN();
        $this->loger = \GTFramework\App::getLoger();
    }

    public function loadCDNScripts() {
        $htmlContent = [];

        if ($this->content === NULL) {
            throw new \Exception('Problem loading configuration file cdn', 500);
        }
//        echo '<pre>' . print_r($this->content['script'], TRUE) . '</pre><br />';
        foreach ($this->content['script'] as $link) {

            if (!trim($link)) {
                throw new \Exception('Problem loading configuration file cdn', 500);
            }
//            echo '<pre>' . print_r($link, TRUE) . '</pre><br />';
            array_push($htmlContent, '<script src="' . $link . '"></script>');
        }

        foreach ($htmlContent as $v) {

            echo '        ' . $v;
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }

    public function loadCDNCSS() {
        $htmlContent = [];

        if ($this->content === NULL) {
            throw new \Exception('Problem loading configuration file cdn', 500);
        }
//        echo '<pre>' . print_r($this->content['script'], TRUE) . '</pre><br />';
        foreach ($this->content['css'] as $link) {

            if (!trim($link)) {
                throw new \Exception('Problem loading configuration file cdn', 500);
            }
            array_push($htmlContent, '<link rel="stylesheet" type="text/css" href="' . $link . '">');
        }

        foreach ($htmlContent as $v) {

            echo '        ' . $v;
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }

    public function loadCDNMeta() {
        $htmlContent = [];

        if ($this->content === NULL) {
            throw new \Exception('Problem loading configuration file cdn', 500);
        }

        foreach ($this->content['meta'] as $attr => $value) {
            if (count($value) < 1) {
                continue;
            }
            $attr = explode('.', $attr);
            $count = count($attr);
            $t = '<meta';
            
            for ($index = 0; $index < $count; $index++) {

                if (!isset($value[$index])) {
                    break;
                }
                
                $t .=' ' . $attr[$index] . '="' . $value[$index] . '"';
            }
            
            $t .= '>';
            
            array_push($htmlContent, $t);
        }

        foreach ($htmlContent as $v) {

            echo '        ' . $v;
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }

    public function loadCDNMisc() {
        $htmlContent = [];

        if ($this->content === NULL) {
            throw new \Exception('Problem loading configuration file cdn', 500);
        }

        foreach ($this->content['misc'] as $rel => $link) {
            $rel = explode('.', $rel);

            if (!trim($link)) {
                continue;
            }

            array_push($htmlContent, '<link rel="' . $rel[0] . '" type="' . $rel[1] . '" href="' . $link . '">');
        }

        foreach ($htmlContent as $v) {

            echo '        ' . $v;
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }

    public function loadAll() {
        foreach ($this->content['loadOrder'] as $value){
        $this->$value();
        }
    }

}
