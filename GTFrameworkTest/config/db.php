<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * @var array
 */
$cfg['default']['connection_uri'] = 'mysql:host=localhost;dbname = gtframework';
$cfg['default']['username'] = 'Buberun';
$cfg['default']['password'] = 'SoftUniConf2015';
$cfg['default']['pdo_options'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES 'UTF8'";
$cfg['default']['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

$cfg['session']['connection_uri'] = 'mysql:host=localhost;dbname = gtframework';
$cfg['session']['username'] = 'Buberun';
$cfg['session']['password'] = 'SoftUniConf2015';
$cfg['session']['pdo_options'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES 'UTF8'";
$cfg['session']['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

$cfg['MySQL'] = 'localhost';
$cfg['MSSQL'] = '127.0.0.1';

$cfg['Administration']['dbName'] = 'gtframework';
$cfg['Administration']['dbTable'] = 'Roles';
$cfg['Administration']['col']['Roles'] = 'RoleName';
$cfg['Administration']['col']['UserId'] = 'Privileges';

$cfg['Users']['dbName'] = 'gtframework';
$cfg['Users']['dbTable'] = 'Users';
$cfg['Users']['colUserName'] = 'UserName';
$cfg['Users']['col']['Email'] = 'Email';
$cfg['Users']['col']['FirstName'] = 'FirstName';
$cfg['Users']['col']['LastName'] = 'LastName';
$cfg['Users']['col']['Password'] = 'Password';
$cfg['Users']['col']['CreatedOn'] = 'CreatedOn';
$cfg['Users']['col']['LastLoged'] = 'LastLoged';

return $cfg;