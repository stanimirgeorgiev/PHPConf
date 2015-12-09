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
            throw new \Exception('addUser in \Models\UserModels received invalid username', 401);
        }
        if (!$this->dbName && !$this->dbTable) {
            throw new \Exception('Invalid params dbName: ' . $this->dbName . ' and dbTable: ' . $this->dbTable, 500);
        }

        $usernameUsed = $this->
                prepare(
                        'SELECT ' . $this->username . ', ' . $this->isDeleted . '  FROM '
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
            foreach ($usernameUsed as $user) {
                echo '<pre>' . print_r($user, TRUE) . '</pre><br />';
                if ($user[$this->isDeleted] == 0) {
                    throw new \Exception('User with name: ' . $username . ' exists', 400);
                    break;
                }
            }
        }

        $session = $this->getSession();
        if (!$session) {
            echo '<pre>' . print_r($session, TRUE) . ' session before ading usr in db</pre><br />';
            throw new \Exception('No session', 401);
        }

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
//                        ':Password' => substr(password_hash($password, 1), 7),
                        ':Password' => password_hash($password, 1),
                        ':CreatedOn' => time(),
                        ':LastLoged' => time(),
                        ':SessionId' => $session,
                        ':IsDeleted' => 0
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

    public function getUserBySession() {
        $sess = $this->getSession();
        if (!$sess) {
            return [];
        }
        $userBySession = $this->
                prepare(
                        'SELECT * FROM '
                        . $this->dbName . '.' . $this->dbTable
                        . ' WHERE '
                        . $this->sessionId
                        . ' LIKE :sessId'
                        . ' AND '
                        . $this->isDeleted
                        . ' = 0'
                )->
                execute([
                    ':sessId' => $sess
                ])->
                fetchAllAssoc();
        if (!$userBySession) {
            $userBySession = [];
        }
        if (empty($userBySession)) {
            return $userBySession;
        }

        if (count($userBySession) > 1) {
            $this->
                    prepare(
                            'UPDATE '
                            . $this->dbName . '.' . $this->dbTable
                            . ' SET ' . $this->sessionId . ' = null '
                            . ' WHERE '
                            . $this->sessionId
                            . ' LIKE :SessionId')->
                    execute([
                        ':SessionId' => $userBySession[0][$this->sessionId]
            ]);

            $userBySession = [];
        }
        if (empty($userBySession)) {
            return $userBySession;
        }
        if ($userBySession[0][$this->isDeleted] == 1) {
            return [];
        }
        return $userBySession;
    }

    public function getSession() {
        if (!isset($_COOKIE['__sess'])) {
            if (empty($_SESSION)) {
                return FALSE;
            }
            return $_SESSION['__sess'];
        }
        return $_COOKIE['__sess'];
    }

    public function verifyPassword($password, $username) {

        $dbPass = $this->
                        prepare(
                                'SELECT '
                                .$this->password
                                .' FROM '
                                . $this->dbName . '.' . $this->dbTable
                                . ' WHERE '
                                . $this->username
                                . ' LIKE :username'
                                . ' AND '
                                . $this->isDeleted
                                . ' = 0'
                        )->
                        execute([
                            ':username' => $username
                        ])->
                        fetchAllAssoc();
        if (count($dbPass) !== 1) {
            return false;
        }
        if (!password_verify($password, $dbPass[0][$this->password])) {
            return false;
        }
        return true;
    }

}
