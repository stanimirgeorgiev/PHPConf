<?php

/**
 * Here are the default dirrectories for the css, javascript and miscellaneous.
 * Default root directory (./) is where your web server servs your index.php.
 * All direcotries should be visible to the web server.
 */

$cfg['local']['dir'] = [
    
    'css'=>[
        
        './css/reset.css',
        './css/NoCSS.css',
        './css/default.css',
        
        ],
    
    'javascript'=>[
        
        './js/NoJavascript.js',
        
        ],
    
    'misc'=>[
        
        './misc/',
        
        ],
    
    ];


/**
 * If AllCSS is set to all then framework reads all of the content in css folder and includes all found readable files;
 * 
 * If AllCSS is set to none then framework will try to load only the files specified in the next lines in the array;
 */

$cfg['local']['css'] = [
    
    'AllCSS'=>'all',
    
//    'AllCSS'=>'none',
//    'FileName'=>'extension',
//    'CustomBootstrap'=>'css',
    
    ];

/**
 * If AllJavascript is set to all then framework reads all of the content in js folder and includes all found readable files;
 * If AllJavascript is set to none then framework will try to load only the files specified in the next lines in the array;
 */

$cfg['local']['javascript'] = [
    
    'AllJavascript'=>'all',
    
//    'AllJavascript'=>'none',
//    'FileName'=>'extension',
//    'CustomScript'=>'js',
    
    ];

/**
 * If AllMisc is set to all then framework reads all of the content in misc folder and includes all found readable files;
 * If AllMisc is set to none then framework will try to load only the files specified in the next lines in the array;
 * Only currently supported format is txt. Using other types of files will create unpredictable results;
 */

$cfg['local']['misc'] = [
    
    'AllMisc'=>'all',
    
//    'AllMisc'=>'none',
//    'FileName'=>'extension',
//    'CustomText'=>'txt',
    
    
    ];

return $cfg;
