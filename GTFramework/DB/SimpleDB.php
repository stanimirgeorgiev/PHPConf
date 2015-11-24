<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SimpleDB
 *
 * @author ACER
 */

namespace GTFramework\DB;

class SimpleDB {

    private $db = null;
    protected $connection = 'default';
    private $sql = null;
    private $stmt = null;
    private $logSql = null;
    private $params = [];
    private $logging = null;

    public function __construct($connection = NULL) {
        if ($connection instanceof \PDO) {
            $this->db = $connection;
        } else if ($connection != NULL) {
            $this->db = \GTFramework\App::getInstance()->getConnectionToDB($connection);
            $this->connection = $connection;
        } else {
            $this->db = \GTFramework\App::getInstance()->getConnectionToDB($this->connection);
        }
        if (!$this->logging) {

            $this->logging = \GTFramework\Loger::getInstance();
        }
        $this->logging->chekBeforeLog('__constructor in SimpleDB called with param: ' . print_r($connection),0);
    }

    /**
     * 
     * @param type $sql
     * @param type $params
     * @param type $pdoOptions
     * @return \GTFramework\DB\SimpleDB 
     */
    public function prepare($sql, &$params = [], &$pdoOptions = []) {
        $this->logging->chekBeforeLog('parepare in SimpleDB called with sql: ' . $sql . ' params: ' . print_r($params) . ' pdoOptions: ' . print_r($pdoOptions), 2);
        $this->stmt = $this->db->prepare($sql, $pdoOptions);
        $this->params = $params;
        $this->sql = $sql;
        $this->logSql = $sql;
        return $this;
    }

    /**
     * 
     * @param type $params
     * @return \GTFramework\DB\SimpleDB
     */
    public function execute($params = []) {
        if (isset($params)) {
            $this->params = $params;
        }
        if ($this->logSql) {
            $this->logging->chekBeforeLog('Executed sql: ' . $this->sql . ' with params: ' . print_r($params), 2);
        }
        $this->stmt->execute($this->params);
        return $this;
    }

    public function fetchAllAssoc() {
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function fetchRowAssoc() {
        return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }

}
