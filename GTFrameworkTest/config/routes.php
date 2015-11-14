<?php
//TODO documentation;
/**
 * 
 * Array Key 'namespace' maps the array key 
 * that is written before it (left to right)
 * to the value which should be a namespace;
 * 
 * Array Key contruction 
 * ['controller']['some_controller_name']['to']
 * maps the 'some_controller_name' to the value
 * which should be a valid controller name;
 * 
 * Array Key construction 
 * ['controller']['some_controller_name']['method']['some_method_name']
 * maps the 'some_method_name' to the value which should be a valid
 * method from controller with name 'some_controller_name'
 * 
 */
$defaultBundle = 'administration';
$newBundle = 'Admin';
$newIndex = 'noviqMiIndeks';
/**
 * $cfg['*']['namespace'] default configuration for the namespace
 */

$cfg['*']['namespace'] = 'Controllers';
$cfg['*']['controller']['mama']['to'] = 'kofa';
$cfg['*']['controller']['kofa']['method']['koko'] = 'roro';

$cfg[$newBundle]['namespace'] = 'Controllers\Admin';
$cfg[$newBundle]['default_controller'] = 'index';
$cfg[$newBundle]['default_method'] = 'index';
$cfg[$newBundle]['controller']['start']['to'] = 'index';
$cfg[$newBundle]['controller']['index']['method']['new'] = 'index';

$cfg[$defaultBundle]['namespace'] = 'Controllers\Admin';
$cfg[$defaultBundle]['default_controller'] = 'index';
$cfg[$defaultBundle]['default_method'] = 'index';
$cfg[$defaultBundle]['controller']['new']['to'] = 'create';
$cfg[$defaultBundle]['controller']['ind']['to'] = $newIndex;
$cfg[$defaultBundle]['controller'][$newIndex]['method']['new'] = '_newMethod';
$cfg[$defaultBundle]['controller'][$newIndex]['method']['proba'] = 'raboti';

return $cfg;