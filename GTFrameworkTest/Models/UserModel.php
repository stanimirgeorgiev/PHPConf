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
    private $username = null;
    private $email = null;
    private $firstName = null;
    private $lastName = null;
    private $password = null;
    private $createdOn = null;
    private $lastLoged = null;
    private $sessionId = null;
    private $isDeleted = null;

    public function __construct() {
        parent::__construct();
        $dbCfg = \GTFramework\App::getInstance()->getConfig()->db;
        $this->dbName = $dbCfg['Users']['dbName'];
        $this->dbTable = $dbCfg['Users']['dbTable'];
        $this->username = $dbCfg['Users']['col']['UserName'];
        $this->email = $dbCfg['Users']['col']['Email'];
        $this->firstName = $dbCfg['Users']['col']['FirstName'];
        $this->lastName = $dbCfg['Users']['col']['LastName'];
        $this->password = $dbCfg['Users']['col']['Password'];
        $this->createdOn = $dbCfg['Users']['col']['CreatedOn'];
        $this->lastLoged = $dbCfg['Users']['col']['LastLoged'];
        $this->sessionId = $dbCfg['Users']['col']['SessionId'];
        $this->isDeleted = $dbCfg['Users']['col']['IsDeleted'];
    }

    public function addUser(
    $username = null, $email = null, $firstName = null, $lastName = null, $password = null
    ) {
        if ($username === null) {
            throw new \Exception('addUser in \Models\Administration recieved invalid user');
        }
        if (!$this->dbName && !$this->dbTable) {
            throw new \Exception('Invalid params dbName: ' . $this->dbName . ' and dbTable: ' . $this->dbTable, 500);
        }

        $usernameUsed = $this->
                prepare(
                        'SELECT Username FROM '
                        . $this->dbName . '.' . $this->dbTable
                        . ' WHERE '
                        . $this->username
                        . ' LIKE :username'
                )->
                execute([
                    ':username' => $username
                ])->
                fetchAllAssoc();

        if (!empty($usernameUsed)) {
            throw new \Exception('User with name: ' . $username . ' exists', 400);
        }

        if (!isset($_COOKIE['__sess'])) {
            if (empty($_SESSION)) {
                throw new \Exception('No session is set', 500);
            }
            $session = $_SESSION['__sess'];
        }
        $session = $_COOKIE['__sess'];

        try {
            $this->
                    beginTransaction()->
                    prepare(
                            'INSERT INTO '
                            . $this->dbName . '.' . $this->dbTable
                            . ' (UserName, Email, FirstName, LastName, Password, CreatedOn, LastLoged, SessionId, IsDeleted)'
                            . ' VALUES '
                            . '( :UserName, :Email, :FirstName, :LastName, :Password, :CreatedOn, :LastLoged, :SessionId, :IsDeleted)')->
                    execute([
                        ':UserName' => $username,
                        ':Email' => $email,
                        ':FirstName' => $firstName,
                        ':LastName' => $lastName,
                        ':Password' => substr(password_hash($password, 1), 7),
                        ':CreatedOn' => time(),
                        ':LastLoged' => time(),
                        ':SessionId' => $session,
                        ':IsDeleted' => 1,
            ]);
            $lastId = $this->getLastInsertId();
            echo '<pre>' . print_r($lastId, TRUE) . '</pre><br />';
            $this->
                    prepare('INSERT INTO '
                            . $this->dbName . '.roles_users'
                            . ' (UserId, RoleId) VALUES '
                            . '(:UserId, :RoleId)')->
                    execute([
                        ':UserId' => $lastId,
                        ':RoleId' => 2,
            ]);
            $this->commit();
        } catch (\Exception $ex) {
            throw new \Exception('Problem adding user with username: ' . $username . ' with exception: ' . $ex, 500);
        }
    }

}
