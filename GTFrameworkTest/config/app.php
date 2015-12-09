<?php
/**
 * @var array
 */
$cfg['namespaces'] = [
    'Controllers' => '../controllers',
    'Helpers' => '../helpers',
    'Views' => '../views',
    'Models' => '../models',
];

$cfg['host'] = [
  'domain' => 'localhost',  
];

$cfg['default_controller'] = 'Index';
$cfg['default_method'] = 'index';
$cfg['default_router'] = 'DefaultRouter';
$cfg['viewPath'] = '../views';

/**
 * Maximum logging level = 2;
 * Default logging level = 1;
 * Minimum logging level = 0;
 */
$cfg['default_logging'] = 2;

/**
 * Session settings
 * 
 * $cfg['session']['type']= 'database';
 * $cfg['session']['type']= 'native';
 */
$cfg['session']['autostart']= true;
$cfg['session']['type']= 'native';
$cfg['session']['name']= '__sess';
$cfg['session']['lifetime']= 5;
$cfg['session']['path']= DIRECTORY_SEPARATOR;
$cfg['session']['domain']= 'localhost';
$cfg['session']['secure']= FALSE;
$cfg['session']['HttpOnly']= true;
$cfg['session']['dbConnection']= 'session';
$cfg['session']['dbTable']= 'sessions';
$cfg['session']['dbName']= 'gtframework';

return $cfg;
