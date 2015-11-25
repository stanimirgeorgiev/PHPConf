<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GTFramework\Sessions;

/**
 * Description of DBSession
 *
 * @author ACER
 */
class DBSession extends \GTFramework\DB\SimpleDB implements \GTFramework\Sessions\ISession {

    private $dbName = null;
    private $tableName = null;
    private $sessionName = null;
    private $lifetime = 3600;
    private $path = null;
    private $domain = null;
    private $secure = false;
    private $httpOnly = TRUE;
    private $sessionId = null;
    private $sessionData = [];
    private $loger = null;

    public function __construct(\GTFramework\Loger $loger, $dbName = null, $dbConnection = null, $tableName = 'sessions', $sessionName = '__sess', $lifetime = 3600, $path = null, $domain = null, $secure = false, $httpOnly = TRUE) {
        $this->loger = $loger;
        LOG < 0 ?: $this->loger->log('__construct in DBSession called with params: ' . 'dbName: ' . $dbName . ', dbConnection = ' . $dbConnection . ', tableName = ' . $tableName . ', sessionName = ' . $sessionName . ', lifetime = ' . $lifetime . ', path = ' . $path . ', domain = ' . $domain . ', secure = ' . $secure . ', httpOnly = ' . $httpOnly);
        $this->dbName = $dbName;
        parent::__construct($dbConnection);
        $this->tableName = $tableName;
        $this->sessionName = $sessionName;
        $this->lifetime = $lifetime;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->httpOnly = $httpOnly;
        if (isset($_COOKIE[$sessionName])) {
            $this->sessionId = $_COOKIE[$sessionName];
        }
        if (strlen($this->sessionId) < 32) {
            $this->startNewSession();
        } else if (!$this->validateSession()) {
            $this->startNewSession();
        }
    }

    public function startNewSession() {
        $this->sessionId = md5(uniqid('GTFramework', TRUE));
        $this->prepare('INSERT INTO ' . $this->dbName . '.' . $this->tableName . '(SessionId, SessionName, ValidUntil) VALUES (:SessionId, :SessionName, :ValidUntil)')
                ->execute([':SessionId' => $this->sessionId, ':SessionName' => $this->sessionName, ':ValidUntil' => (time() + $this->lifetime)]);
        setcookie($this->sessionName, $this->sessionId, (time() + $this->lifetime), $this->path, $this->domain, $this->secure, $this->httpOnly);
    }

    private function validateSession() {
        if ($this->sessionId) {
            $pst = $this
                    ->prepare('SELECT * FROM ' . $this->dbName . '.' . $this->tableName . ' WHERE SessionId = :sessId AND ValidUntil <= :validTime')
                    ->execute([':sessId' => $this->sessionId, ':validTime' => time()+$this->lifetime])
                    ->fetchAllAssoc();
            if (is_array($pst) && count($pst) === 1 && isset($pst[0])) {
                $this->sessionData = unserialize($pst[0]['SessionData']);
                return true;
            }
        }
        return FALSE;
    }

    public function __get($name) {
        
    }

    public function __set($name, $value) {
        
    }

    public function destroySession() {
        
    }

    public function getSessionId() {
        
    }

    public function saveSession() {
        
    }

}
