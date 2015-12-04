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
class RolesModel extends \GTFramework\DB\SimpleDB {

    private $dbTable = null;
    private $dbName = null;
    private $dbRoles = null;
    private $userLevel = null;

    public function __construct() {
        parent::__construct();
        $dbCfg = \GTFramework\App::getInstance()->getConfig()->db;
        $this->dbName = $dbCfg['Administration']['dbName'];
        $this->dbTable = $dbCfg['Administration']['dbTable'];
        $this->dbRoles = $dbCfg['Administration']['col']['Roles'];
        $this->userLevel = $dbCfg['Administration']['col']['UserLevel'];
    }

    public function getRoleByName($role = null) {
        if ($role === null) {
            return FALSE;
        }
        if (!$this->dbName && !$this->dbTable) {
            throw new \Exception('Invalid params dbName: ' . $this->dbName . ' and dbTable: ' . $this->dbTable, 500);
        }
        $roles = $this->prepare(
                        'SELECT ' . $this->userLevel . ' FROM '
                        . $this->dbName . '.' . $this->dbTable
                        . ' WHERE ' . $this->dbRoles . ' LIKE :role')
                ->execute([
                    ':role' => $role,
                ]);
        return $roles;
    }

    public function getRoleUserLevel($userLevel = null) {
        if ($userLevel === null) {
            throw new \Exception('getRoleUserLevel in \Models\Administration recieved invalid role UserLevel');
        }
        if (!$this->dbName && !$this->dbTable) {
            throw new \Exception('Invalid params dbName: ' . $this->dbName . ' and dbTable: ' . $this->dbTable, 500);
        }
        $roles = $this->prepare(
                        'SELECT ' . $this->dbRoles . ' FROM '
                        . $this->dbName . '.' . $this->dbTable
                        . ' WHERE ' . $this->userLevel . ' = :userLevel')
                ->execute([
                    ':userLevel' => $userLevel,
                ])
                ->getLastInsertId();
    }
}
