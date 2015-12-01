<?php
/**
 * Here are the remotly loaded jquery and bootstrap and some other miscellaneous links
 */
$cfg['script'] = [
    
    'jquery'=>'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js',
    'jquery1'=>'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js',
    'jquery2'=>'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js',
    'jquery3'=>'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js',
    'jquery4'=>'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js',
    'jquery5'=>'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js',
    'jquery6'=>'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js',
    'jquery7'=>'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js',
    
    ];

$cfg['css'] = [
    
    'bootstrap'=>'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous',
    'reset'=>'http://localhost/css/reset.css',
    'default'=>'/css/default.css',
    
    ];

$cfg['meta'] = [
    
    'charset' => ['UTF-8'],
    'name.content' => ['author','Stanimir Georgiev'],
    'http-equiv.content' => ['refresh','2000'],
    
    ];

$cfg['misc'] = [
    
    'stylesheet.text/css' => 'http://localhost/css/NoCSS.css',
    'author.image/png' => 'http://localhost/images/NoImage.png',
    
    ];

$cfg['loadOrder'] = [
    
    0 => 'loadCDNMisc',
    1 => 'loadCDNMeta',
    2 => 'loadCDNCSS',
    3 => 'loadCDNScripts',
    
    ];
        

return $cfg;
