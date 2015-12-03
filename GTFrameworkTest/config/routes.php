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
$defaultBundle = 'admin';

/**
 * $cfg['*']['namespace'] default configuration for the namespace
 */

$cfg['*']['namespace'] = 'Controllers';
$cfg['*']['controller']['mama']['to'] = 'kofa';
$cfg['*']['controller']['register']['to'] = 'autho';
$cfg['*']['controller']['kofa']['method']['koko'] = 'roro';

$cfg[$defaultBundle]['namespace'] = 'Controllers\Admin';
$cfg[$defaultBundle]['default_controller'] = 'index';
$cfg[$defaultBundle]['default_method'] = 'index';
$cfg[$defaultBundle]['controller']['new']['to'] = 'create';

return $cfg;