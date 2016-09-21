<?php

class MySQL {

    var $host;
    var $dbUser;
    var $dbPass;
    var $dbName;
    var $dbConn;
    var $connectError;
    var $sqlQuery;

    function MySQL($host, $dbUser, $dbPass, $dbName) {
        $this->host = $host;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbName = $dbName;
        $this->conect();
    }

    function changeDataBase($host, $dbUser, $dbPass, $dbName) {
        $this->host = $host;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbName = $dbName;
        $this->conect();
    }

    function conect() {
        if (!$this->dbConn = @mysql_connect($this->host, $this->dbUser, $this->dbPass)) {
            trigger_error('Error No DataBase Conection');
            $this->connectError = true;
        } else if (!@mysql_select_db($this->dbName, $this->dbConn)) {
            trigger_error('Error No DataBase Selected');
            $this->connectError = true;
        }
    }

    function isError() {
        if ($this->connectError)
            return true;
        $error = mysql_error($this->dbConn);
        if (empty($error))
            return false;
        else
            return true;
    }

    function query($sql) {
        /* if (!$queryResource=mysql_query($sql,$this->dbConn))
          trigger_error ('Fail SQL'
          .mysql_error($this->dbConn).' SQL: '
          .$sql
          ); */
        $this->sqlQuery = $sql;

        if (!$queryResource = mysql_query($sql, $this->dbConn)) {
            // $answer = array("answer"=>'fail', "msg"=>mysql_error($this->dbConn)); 
            // json_Encode($answer);            
        }

        return new MySQLResult($this, $queryResource);
    }

    function getEscapeString($string) {

        return str_replace("'", "", $string);
    }

}

class MySQLResult {

    var $mysql;
    var $query;

    function MySQLResult(& $mysql, $query) {
        $this->mysql = & $mysql;
        $this->query = $query;
    }

    function fetch() {
        if ($row = mysql_fetch_array($this->query, MYSQL_ASSOC)) {
            return $row;
        } else if ($this->size() > 0) {
            mysql_data_seek($this->query, 0);
            return false;
        } else {
            return false;
        }
    }

    function fetch_row() {
        if ($row = mysql_fetch_row($this->query)) {
            return $row;
        } else if ($this->size() > 0) {
            mysql_data_seek($this->query, 0);
            return false;
        } else {
            return false;
        }
    }

    function size() {
        return mysql_num_rows($this->query);
    }

    function getLastInsertID() {
        return mysql_insert_id($this->mysql->dbConn);
    }

    function isError() {
        return $this->mysql->isError();
    }

    function getError($isModeDebug = true) {
        if ($isModeDebug) {
            return 'SQL Fail: ' . preg_replace('/\s\s+/', '', $this->mysql->sqlQuery) . ' ===> Error: ' . mysql_error($this->mysql->dbConn);
        } else
            return 'Error: al consultar';
    }

    function slashesFix($value) {
        return @addslashes($value);
    }

}

?>