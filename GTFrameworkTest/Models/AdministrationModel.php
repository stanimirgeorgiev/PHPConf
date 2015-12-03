<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;

/**
 * Description of Administration
 *
 * @author ACER
 */
class AdministrationModel extends \GTFramework\DB\SimpleDB {

    private $dbTable = null;
    private $dbName = null;
    private $dbRoles = null;
    private $dbUserId = null;

    public function __construct() {
        parent::__construct();
        $dbCfg = \GTFramework\App::getInstance()->getConfig()->db;
        $this->dbName = $dbCfg['Administration']['dbName'];
        $this->dbTable = $dbCfg['Administration']['dbTable'];
        $this->dbRoles = $dbCfg['Administration']['col']['Roles'];
        $this->dbUserId = $dbCfg['Administration']['col']['UserId'];
    }

    public function getRoleByName($role = null) {
        if (!$role) {
            throw new \Exception('getRoleByName in \Models\Administration recieved invalid role name');
        }
        if (!$this->dbName && !$this->dbTable) {
            throw new \Exception('Invalid params dbName: ' . $this->dbName . ' and dbTable: ' . $this->dbTable, 500);
        }
        $roles = $this->prepare(
                        'SELECT Privileges FROM '
                        . $this->dbName . '.' . $this->dbTable
                        . ' WHERE ' . $this->dbRoles . ' LIKE :role')
                ->execute([
                    ':role' => $role,
                          ])
                ->fetchAllAssoc();
        var_dump($roles);
        echo '<pre>' . print_r($roles, TRUE) . '</pre><br />';
    }

}
