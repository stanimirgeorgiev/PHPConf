<?php
$cfg['test1'] = 'proba1';
$cfg['test2'] = 'proba2';
$cfg['namespaces'] = [
    'Controllers' => '../controllers'
];

$cfg['default_controller'] = 'Index';
$cfg['default_method'] = 'index';
$cfg['default_router'] = 'DefaultRouter';
/**
 * Maximum logging level = 2;
 * Default logging level = 1;
 * Minimum logging level = 0;
 */
$cfg['default_logging'] = 2;

/**
 * Session settings
 */
$cfg['session']['autostart']= true;
$cfg['session']['type']= 'database';
$cfg['session']['name']= '__sess';
$cfg['session']['lifetime']= 3600;
$cfg['session']['path']= DIRECTORY_SEPARATOR;
$cfg['session']['domain']= '';
$cfg['session']['secure']= FALSE;
$cfg['session']['HttpOnly']= true;
$cfg['session']['dbConnection']= 'default';
$cfg['session']['dbTable']= 'sessions';

return $cfg;
