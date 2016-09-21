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
        include('../../inc/common.inc.php');
        include($COMMON->getMySQL());
        include($COMMON->getQuery());
        $this->db = new MySQL($GLOBAL['db_host'], $GLOBAL['db_user'], $GLOBAL['db_password'], $GLOBAL['db_name']);
        $QUERY = new Query($this->db, $GLOBAL);

        $this->COMMON = $COMMON;
        $this->STR = $STR;
        $this->GLOBAL = $GLOBAL;
        $this->QUERY = $QUERY;
        $this->accountId = isset($_SESSION['enlaceemp_accountid']) ? $_SESSION['enlaceemp_accountid'] : null;
        $this->accountType = isset($_SESSION['enlaceemp_accounttype']) ? $_SESSION['enlaceemp_accounttype'] : null;
        $this->day_of_week = $day_of_week;
        $this->day_of_weekFull = $day_of_weekFull;
        $this->month = $month;
        $this->monthFull = $monthFull;
        $this->datefmt = $datefmt;
    }

    function sendComment() {

        $aParams = array();
        $getCaptcha = $this->COMMON->getCaptcha();

        foreach ($_POST as $key => $value)
            if ($key != 'opt' && $key != 'Chars')
                $aParams[$key] = $this->COMMON->getEscapeString($value);


        if (strcmp(strtolower($_POST['Chars']), $getCaptcha) != 0) {
            $answer = array("answer" => 'fail', "msg" => $this->STR['ValidateChars_Error'], 'state' => $_POST['opt']);
            echo json_encode($answer);
            return false;
        }



        $rGetComments = $this->QUERY->getComments("WHERE (a.tx_email = '" . $aParams['email'] . "' OR a.tx_ipaddress = '" . $_SERVER['REMOTE_ADDR'] . "') AND a.nm_status = 1");

        if ($rGetComments->size() > 0) {
            $answer = array("answer" => 'fail', "msg" => $this->STR['Msg_Comment_Added'], "state" => $_POST['opt']);
            echo json_encode($answer);
            return false;
        }

        $rGetComments = $this->QUERY->insertComments(
                array('tx_name' => $aParams['name']
                    , 'tx_email' => $aParams['email']
                    , 'tx_comment' => $aParams['comment']
                    , 'dt_registry' => $this->STR['CurrentDate']
                    , 'tm_registry' => $this->STR['CurrentHour']
                    , 'tx_ipaddress' => $_SERVER['REMOTE_ADDR']
                    , 'nm_status' => '1'
        ));

        $ticketId = $rGetComments->getLastInsertID();

        $params = array(
            '{logoLink}' => '<img src="' . $this->GLOBAL['domain-root'] . 'media/image/logoHikingMexico.png">'
            , '{ticketId}' => $ticketId
            , '{userName}' => $aParams['name']
            , '{dt_registry}' => $this->COMMON->getDateFormat($this->STR['CurrentDate'])
            , '{comment}' => $aParams['comment']
            , '{email}' => $aParams['email']
            , '{supportMail}' => $this->GLOBAL['email_support']
        );



        $subject = $this->COMMON->str_replace($this->STR['Email_Comment_Subject'], $params);
        $sendTo = $arrayName = array('from' => $this->GLOBAL['email_support'], 'to' => $aParams['email'], 'subject' => $subject, 'charset' => 'utf-8');
        $bodyMessage = $this->COMMON->str_replace($this->STR['Email_Comment'], $params);

        $this->COMMON->sendMail($sendTo, $bodyMessage, $params);

        $sendTo = $arrayName = array('from' => $aParams['email'], 'to' => $this->GLOBAL['email_support'], 'subject' => $subject, 'charset' => 'utf-8');
        $this->COMMON->sendMail($sendTo, $bodyMessage, $params);

        $sendTo = $arrayName = array('from' => $aParams['email'], 'to' => $this->GLOBAL['email_job'], 'subject' => $subject, 'charset' => 'utf-8');
        $this->COMMON->sendMail($sendTo, $bodyMessage, $params);

        $answer = array("answer" => 'correct', "msg" => $this->STR['Msg_Comment_Success'], "state" => $_POST['opt']);
        echo json_encode($answer);
    }

}

//end of class
$remote = new remote();
$option = $_POST['opt'];
switch ($option) {

    case 'sendComment':
        $remote->sendComment();
        break;

    default:
        die();
        break;
}
?>