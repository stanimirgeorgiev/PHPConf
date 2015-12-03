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
//    protected $loger = null;

    public function __construct($dbName = null, $dbConnection = null, $tableName = 'sessions', $sessionName = '__sess', $lifetime = 3600, $path = null, $domain = null, $secure = false, $httpOnly = TRUE) {
        $this->dbName = $dbName;
        parent::__construct($dbConnection);
        $this->tableName = $tableName;
        $this->sessionName = $sessionName;
        $this->lifetime = $lifetime;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->httpOnly = $httpOnly;
        LOG < 0 ? : $this->loger->log('__construct in DBSession called with params: ' . 'dbName: ' . $dbName . ', dbConnection = ' . $dbConnection . ', tableName = ' . $tableName . ', sessionName = ' . $sessionName . ', lifetime = ' . $lifetime . ', path = ' . $path . ', domain = ' . $domain . ', secure = ' . $secure . ', httpOnly = ' . $httpOnly);
        if (rand(0, 100) === 50) {
//            echo '<pre>' . print_r('------------------CLEAR-----CLEAR----CLEAR-------------', TRUE) . '</pre><br />';
            $this->dbClearOldSessions();
        }

        if (isset($_COOKIE[$sessionName])) {
            $this->sessionId = $_COOKIE[$sessionName];
        }

        if (strlen($this->sessionId) < 32) {
            LOG < 2 ? : $this->loger->log('__construct in DBSession check strlen of sessionId < 32 : ( ' . strlen($this->sessionId) . ' )');

            $this->startNewSession();
        } else if (!$this->validateSession()) {
            LOG < 2 ? : $this->loger->log('__construct in DBSession validate session');

            $this->startNewSession();
        }
    }

    public function startNewSession() {
        LOG < 2 ? : $this->loger->log('startNewSession in DBSession called');

        $this->sessionId = md5(uniqid('GTFramework', TRUE));

        LOG < 2 ? : $this->loger->log('startNewSession in DBSession created session with Id: ' . $this->sessionId);
        $this->prepare(
                        'INSERT INTO '
                        . $this->dbName . '.' . $this->tableName
                        . ' (SessionId, SessionName, ValidUntil)'
                        . ' VALUES (:SessionId, :SessionName, :ValidUntil)')
                ->execute([
                    ':SessionId' => $this->sessionId,
                    ':SessionName' => $this->sessionName,
                    ':ValidUntil' => (time() + $this->lifetime)
        ]);

        setcookie($this->sessionName, $this->sessionId, (time() + $this->lifetime), $this->path, $this->domain, $this->secure, $this->httpOnly);
    }

    private function validateSession() {
        LOG < 2 ? : $this->loger->log('validateSession in DBSession called');

        if ($this->sessionId) {
            $pst = $this
                    ->prepare('SELECT * FROM ' . $this->dbName . '.' . $this->tableName . ' WHERE SessionId = :sessId AND ValidUntil >= :validTime')
                    ->execute([':sessId' => $this->sessionId, ':validTime' => time()])
                    ->fetchAllAssoc();
            if (is_array($pst) && count($pst) === 1 && isset($pst[0])) {
                $this->sessionData = unserialize($pst[0]['SessionData']);

                LOG < 2 ? : $this->loger->log('validateSession in DBSession returned true');
                return true;
            }
        }
        LOG < 2 ? : $this->loger->log('validateSession in DBSession returned false');
        return FALSE;
    }

    public function __get($name) {
        LOG < 2 ? : $this->loger->log('__get in DBSession called with: ' . $name);

        return isset($this->sessionData[$name]) ? $this->sessionData[$name] : '';
    }

    public function __set($name, $value) {
        LOG < 2 ? : $this->loger->log('__set in DBSession called with: ' . $name . ', ' . $value);

        return $this->sessionData[$name] = $value;
    }

    public function destroySession() {
        LOG < 2 ? : $this->loger->log('destroySession in DBSession called');

        if ($this->sessionId) {
            $this->prepare('DELETE FROM ' . $this->dbName . '.' . $this->tableName . ' WHERE SessionId = :sessId')
                    ->execute([':sessId' => $this->sessionId]);
        }
    }

    public function getSessionId() {
        LOG < 2 ? : $this->loger->log('getSessionId in DBSession called');

        return $this->sessionId;
    }

    public function saveSession() {
        LOG < 2 ? : $this->loger->log('__saveSession in DBSession called');

        if ($this->sessionId) {
            LOG < 2 ? : $this->loger->log('setCookie called in saveSession in DBSession');
            $this->prepare('UPDATE ' . $this->dbName . '.' . $this->tableName . ' SET SessionData = :data, ValidUntil = :validUntil WHERE SessionId = :sessId')
                    ->execute([':data' => serialize($this->sessionData), ':validUntil' => time() + $this->lifetime, ':sessId' => $this->sessionId]);

            setcookie($this->sessionName, $this->sessionId, (time() + $this->lifetime), $this->path, $this->domain, $this->secure, $this->httpOnly);
        }
    }

    private function dbClearOldSessions() {
        LOG < 2 ? : $this->loger->log('dbClearOldSessions in DBSession called');

        $this->prepare('DELETE FROM ' . $this->dbName . '.' . $this->tableName . ' WHERE ValidUntil < :currTime')
                ->execute([':currTime' => time()]);
    }

}
