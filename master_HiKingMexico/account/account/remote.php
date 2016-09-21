<?php

/*
  remote.php
 */
session_start();

class remote {

    var $accountId;
    var $COMMON;
    var $db;
    var $STR;
    var $GLOBAL;
    var $QUERY;
    var $day_of_week;
    var $day_of_weekFull;
    var $month;
    var $monthFull;
    var $datefmt;

    function __construct() {
        include('inc/common.inc.php');
        include($COMMON->getMySQL());
        include($COMMON->getQuery());
        $this->db = new MySQL($GLOBAL['db_host'], $GLOBAL['db_user'], $GLOBAL['db_password'], $GLOBAL['db_name']);
        $QUERY = new Query($this->db, $GLOBAL);

        $this->COMMON = $COMMON;
        $this->STR = $STR;
        $this->GLOBAL = $GLOBAL;
        $this->QUERY = $QUERY;
        $this->accountId = isset($_SESSION['enlaceemp_accountid']) ? $_SESSION['enlaceemp_accountid'] : null;

        $this->day_of_week = $day_of_week;
        $this->day_of_weekFull = $day_of_weekFull;
        $this->month = $month;
        $this->monthFull = $monthFull;
        $this->datefmt = $datefmt;
    }

}

//end of class
$remote = new remote();
$option = $_POST['opt'];
switch ($option) {

    default:
        die();
        break;
}
?>