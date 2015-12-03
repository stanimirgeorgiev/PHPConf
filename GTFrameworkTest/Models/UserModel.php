<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;

/**
 * Description of UserModel
 *
 * @author ACER
 */
class UserModel extends \GTFramework\DB\SimpleDB {

    private $dbTable = null;
    private $dbName = null;
    private $Username = null;
    private $Email = null;
    private $FirstName = null;
    private $LastName = null;
    private $Password = null;
    private $CreatedOn = null;
    private $LastLoged = null;
    private $SessionId = null;
    private $IsDeleted = null;

    public function __construct() {
        parent::__construct();
        $dbCfg = \GTFramework\App::getInstance()->getConfig()->db;
        $this->dbName = $dbCfg['Users']['dbName'];
        $this->dbTable = $dbCfg['Users']['dbTable'];
        $this->Username = $dbCfg['Users']['col']['UserName'];
        $this->Email = $dbCfg['Users']['col']['Email'];
        $this->FirstName = $dbCfg['Users']['col']['FirstName'];
        $this->LastName = $dbCfg['Users']['col']['LastName'];
        $this->Password = $dbCfg['Users']['col']['Password'];
        $this->CreatedOn = $dbCfg['Users']['col']['CreatedOn'];
        $this->LastLoged = $dbCfg['Users']['col']['LastLoged'];
        $this->SessionId = $dbCfg['Users']['col']['SessionId'];
        $this->IsDeleted = $dbCfg['Users']['col']['IsDeleted'];
    }

    public function addUser($userName = null) {
        if ($userName === null) {
            throw new \Exception('addUser in \Models\Administration recieved invalid user');
        }
        if (!$this->dbName && !$this->dbTable) {
            throw new \Exception('Invalid params dbName: ' . $this->dbName . ' and dbTable: ' . $this->dbTable, 500);
        }
        try {
            

        $this->beginTransaction()
                ->prepare(
                        'INSERT INTO '
                        . $this->dbName . '.' . $this->dbTable
                        . ' (UserName, Email, FirstName, LastName, Password, CreatedOn, LastLoged, SessionId, IsDeleted) VALUES (' 
                        . $this->Username 
                        . $this->Email 
                        . $this->FirstName 
                        . $this->LastName
                        . $this->Password 
                        . $this->CreatedOn 
                        . $this->LastLoged
                        . $this->SessionId 
                        . $this->IsDeleted 
                        . ')')
                ->execute([
                    ':userLevel' => $userName,
                    ':userLevel' => $userName,
                    ':userLevel' => $userName,
                    ':userLevel' => $userName,
                    ':userLevel' => $userName,
                    ':userLevel' => $userName,
                    ':userLevel' => $userName,
                    ':userLevel' => $userName,
                    ':userLevel' => $userName,
                    ':userLevel' => $userName,
                    ':userLevel' => $userName,
                    ':userLevel' => $userName,
                    ':userLevel' => $userName,
                ])
                ->getLastInsertId();
        } catch (\Exception $exc) {

            }
    }

}
