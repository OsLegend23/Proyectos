<?php
/*
remote.php
*/
session_start();


class remote
{
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

    function __construct()
    {
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

    function autenticate()
    {

        $aParams = array();

        if (isset($_POST)) {
            foreach ($_POST as $key => $value) {
                $aParams[] = $value;
            }
        } else {
            $answer = array("answer" => 'fail', "msg" => $this->STR['LoginError_Error'], 'state' => $_POST['opt']);
            echo json_encode($answer);
            return false;
        }

        $getCaptcha = $this->COMMON->getCaptcha();

        $rGetUser = $this->QUERY->getUser("WHERE a.tx_email = '" . $aParams['0'] . "' AND a.tx_password = MD5('" . $aParams['1'] . "')
                                	AND a.nm_status = '" . $this->GLOBAL['user_enable']['value'] . "' LIMIT 0,1");

        if (strcmp(strtolower($aParams['2']), $getCaptcha) != 0) {
            $answer = array("answer" => 'fail', "msg" => $this->STR['ValidateChars_Error'], 'state' => $_POST['opt']);
        } else
            if ($rGetUser->size() == 0) {
                $answer = array("answer" => 'fail', "msg" => $this->STR['LoginError_Error'], 'state' => $_POST['opt']);
            } else if ($rGetUser->size() == 1) {
                $row = $rGetUser->fetch();

                $accounttype = $this->GLOBAL['user_list'][$row['nm_type']]['location'];

                $_SESSION['enlaceemp_accountid'] = $row['id'];
                $_SESSION['enlaceemp_accountname'] = $row['tx_name'] . ' ' . $row['tx_surname'];
                $_SESSION['enlaceemp_accountmail'] = $row['tx_email'];
                $_SESSION['enlaceemp_accounttype'] = $row['nm_type'];
                $_SESSION['enlaceemp_loginon'] = 1;
                $_SESSION['enlaceemp_signed'] = strcmp($row['dt_registry'], $row['dt_sign']) == 0 ? 0 : 1;
                $_SESSION['enlaceemp_dtregistry'] = $row['dt_registry'];

                $days = $this->COMMON->getDaysBetweenDates($this->STR['CurrentDate'], $row['dt_registry']);
                $_SESSION['enlaceemp_remainingdays'] = ($this->GLOBAL['emailVerificationRemainingDays'] + $days) <= 0 ? 0 : ($this->GLOBAL['emailVerificationRemainingDays'] + $days);

                $idUser = $row['id'];

                if ($row['nm_type'] == $this->GLOBAL['user_postulant']['value']) {
                    $rGetPostulant = $this->QUERY->getPostulant("WHERE a.id_user = '" . $idUser . "' ");
                    $row = $rGetPostulant->fetch();
                    $_SESSION['enlaceemp_image'] = $row['tx_image'];
                    $_SESSION['enlaceemp_verified'] = $row['ch_verified'];
                } else if ($row['nm_type'] == $this->GLOBAL['user_company']['value']) {
                    $rGetCompany = $this->QUERY->getCompany("WHERE a.id_user = '" . $idUser . "' ");
                    $row = $rGetCompany->fetch();
                    $_SESSION['enlaceemp_image'] = $row['tx_image'];
                    $_SESSION['enlaceemp_verified'] = $row['ch_verified'];
                }


                $tx_ipaddress = $_SERVER['REMOTE_ADDR'];
                $dt_lastvisit = Date(Y . "-" . m . "-" . d);

                $this->QUERY->updateUser(array('tx_ipaddress' => $tx_ipaddress, 'dt_lastvisit' => $dt_lastvisit), "WHERE id ='$idUser'");

                $answer = array("answer" => 'correct', "msg" => $this->STR['Autentication_success'], "accounttype" => $accounttype, 'state' => $_POST['opt']);

            } else
                $answer = array("answer" => 'fail', "msg" => $rGetUser->size(), "accounttype" => $accounttype, 'state' => $_POST['opt']);

        echo json_encode($answer);
    }

    function mailinglist()
    {

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

        $rGetMailingList = $this->QUERY->getMailingList("WHERE a.tx_email = '" . $aParams['email'] . "'");

        if ($rGetMailingList->size() > 0) {
            $answer = array("answer" => 'correct', "msg" => $this->COMMON->str_replace($this->STR['Mailinglist_AddSuccess'], array('{userName}' => $aParams['name'])), "state" => $_POST['opt']);
            echo json_encode($answer);
            return false;
        }

        $tx_binary = md5($aParams['name'] . $aParams['email'] . $this->STR['CurrentHour']);

        $rGetMailingList = $this->QUERY->insertMailingList(
            array('tx_name' => $aParams['name']
            , 'tx_email' => $aParams['email']
            , 'dt_registry' => $this->STR['CurrentDate']
            , 'ch_status' => 'A'
            , 'tx_binary' => $tx_binary
            ));

        $params = array(
            '{logoLink}' => '<img src="' . $this->GLOBAL['domain-root'] . 'media/image/logoHikingMexico.png">'
        , '{userName}' => $aParams['name']
        , '{userEmail}' => $this->COMMON->getDateFormat($this->STR['CurrentDate'])
        , '{postulantRegistry}' => $this->GLOBAL['domain-root'] . 'postulantregister/'
        , '{linkToCancel}' => $this->GLOBAL['domain-root'] . 'mailinglist/?mll=' . $tx_binary
        );

        $subject = $this->GLOBAL['site'] . ', ' . $this->STR['Oportunity'];
        $sendTo = $arrayName = array('from' => $this->GLOBAL['email_job'], 'to' => $aParams['email'], 'subject' => $subject, 'charset' => 'utf-8');
        $bodyMessage = $this->COMMON->str_replace($this->STR['Mailinglist_EmailSuccess'], $params);

        $this->COMMON->sendMail($sendTo, $bodyMessage, $params);

        $answer = array("answer" => 'correct', "msg" => $this->COMMON->str_replace($this->STR['Mailinglist_AddSuccess'], array('{userName}' => $aParams['name'])), "state" => $_POST['opt']);
        echo json_encode($answer);
    }

    function hitsCounter()
    {
        $rGetHitscounter = $this->QUERY->getHitscounter("WHERE a.tx_ipaddress = '" . $_SERVER['REMOTE_ADDR'] . "'
	    						 AND a.dt_registry = '" . $this->STR['CurrentDate'] . "' ORDER BY a.id DESC LIMIT 0,1");

        $rData = $rGetHitscounter->fetch();

        $canSave = true;

        if ($rGetHitscounter->size() > 0 && $rData['dif'] < 5)
            $canSave = false;

        if ($canSave) {

            $rGetHitsCounter = $this->QUERY->insertHitscounter(
                array('tx_ipaddress' => $_SERVER['REMOTE_ADDR']
                , 'dt_registry' => $this->STR['CurrentDate']
                , 'tx_hour' => $this->STR['CurrentHour']
                ));
        }

        $answer = array("answer" => 'hitsCounter', "msg" => 'hitsCounter ' . $rData['dif'], "state" => $_POST['opt']);
        echo json_encode($answer);
    }

    function sendCompanyAutentication()
    {

        $rGetUser = $this->QUERY->getUser("WHERE a.id = '" . $this->accountId . "' ");
        $row = $rGetUser->fetch();

        $days = $this->COMMON->getDaysBetweenDates($this->STR['CurrentDate'], $row['dt_registry']);
        $remainingdays = ($this->GLOBAL['emailVerificationRemainingDays'] + $days) <= 0 ? 0 : ($this->GLOBAL['emailVerificationRemainingDays'] + $days);

        $rGetCompany = $this->QUERY->getCompany("WHERE a.id = '" . $this->accountId . "' ");
        $rDataCompany = $rGetCompany->fetch();

        $rGetCompanyPlan = $this->QUERY->getCompany_Plan("WHERE  a.id_company = '" . $this->accountId . "' ORDER BY a.id DESC LIMIT 0,1");
        $rDataCompanyPlan = $rGetCompanyPlan->fetch();

        $tx_newsign = md5($this->STR['CurrentDate'] . $row['tx_name'] . $email . $_SERVER['REMOTE_ADDR'] . date("H:i:s"));
        $this->QUERY->updateUser(array('tx_sign' => $tx_newsign), "WHERE id ='" . $this->accountId . "'");

        $params = array(
            '{userName}' => $row['tx_name'] . ' ' . $row['tx_surname']
        , '{daysToPost}' => $this->GLOBAL['promotionPlannRemainingDays']
        , '{logo}' => '<img src="' . $this->GLOBAL['domain-root'] . 'media/image/logoHikingMexico.png">'
        , '{goToAdmin}' => $this->GLOBAL['domain-root'] . 'account/'
        , '{planName}' => $rDataCompanyPlan['tx_planname']
        , '{statusPlan}' => $this->GLOBAL['plan_status'][$rDataCompanyPlan['ch_status']]['label']
        , '{periodInit}' => $this->COMMON->getDateFormat($rDataCompanyPlan['dt_initialperiod'])
        , '{periodEnded}' => $this->COMMON->getDateFormat($rDataCompanyPlan['dt_periodended'])
        , '{linkValidation}' => $this->GLOBAL['domain-root'] . 'account/?validation=' . $tx_newsign
        , '{daysTolimitDate}' => $remainingdays
        , '{limitDate}' => $this->COMMON->getDateFormat(date('Y-m-d', strtotime($this->STR['CurrentDate'] . ' + ' . $this->GLOBAL['emailVerificationRemainingDays'] . ' days')))
        , '{linkSupport}' => $this->GLOBAL['domain-root'] . 'support/?company'
        , '{asociatedEmail}' => $this->GLOBAL['email_associated']
        );

        $subject = $this->COMMON->str_replace($this->STR['Company_registry_subject'], array('{TradeName}' => $rDataCompany['tx_tradename']));
        $sendTo = $arrayName = array('from' => $this->GLOBAL['email_associated'], 'to' => $row['tx_email'], 'subject' => $subject, 'charset' => 'utf-8');
        $bodyMessage = $this->COMMON->str_replace($this->STR['Email_Company_Resend'], $params);

        $this->COMMON->sendMail($sendTo, $bodyMessage, $params);//Send To Company

        $answer = array("answer" => 'correct', "msg" => $this->STR['MaliSendedTo'] . ' ' . $row['tx_email'], "state" => $_POST['opt']);

        echo json_Encode($answer);
    }

    function sendPostulantAutentication()
    {

        $rGetUser = $this->QUERY->getUser("WHERE a.id = '" . $this->accountId . "' ");
        $row = $rGetUser->fetch();

        $days = $this->COMMON->getDaysBetweenDates($this->STR['CurrentDate'], $row['dt_registry']);
        $remainingdays = ($this->GLOBAL['emailVerificationRemainingDays'] + $days) <= 0 ? 0 : ($this->GLOBAL['emailVerificationRemainingDays'] + $days);


        $tx_newsign = md5($this->STR['CurrentDate'] . $row['tx_name'] . $email . $_SERVER['REMOTE_ADDR'] . date("H:i:s"));
        $this->QUERY->updateUser(array('tx_sign' => $tx_newsign), "WHERE id ='" . $this->accountId . "'");

        $params = array(
            '{userName}' => $row['tx_name'] . ' ' . $row['tx_surname']
        , '{logo}' => '<img src="' . $this->GLOBAL['domain-root'] . 'media/image/logoHikingMexico.png">'
        , '{goToAdmin}' => $this->GLOBAL['domain-root'] . 'account/'
        , '{linkValidation}' => $this->GLOBAL['domain-root'] . 'account/?validation=' . $tx_newsign
        , '{daysTolimitDate}' => $remainingdays
        , '{limitDate}' => $this->COMMON->getDateFormat(date('Y-m-d', strtotime($this->STR['CurrentDate'] . ' + ' . $this->GLOBAL['emailVerificationRemainingDays'] . ' days')))
        , '{linkSupport}' => $this->GLOBAL['domain-root'] . 'support/?postulant'
        , '{empleoEmail}' => $this->GLOBAL['email_job']
        );

        $subject = $this->COMMON->str_replace($this->STR['Postulant_registry_subject'], array('{userName}' => $row['tx_name'] . ' ' . $row['tx_surname']));
        $sendTo = $arrayName = array('from' => $this->GLOBAL['email_job'], 'to' => $row['tx_email'], 'subject' => $subject, 'charset' => 'utf-8');
        $bodyMessage = $this->STR['Email_Postulant_Resend'];

        $answer = array("answer" => 'correct', "msg" => $this->STR['MaliSendedTo'] . ' ' . $row['tx_email'], "state" => $_POST['opt']);

        $this->COMMON->sendMail($sendTo, $bodyMessage, $params);//Send To postulant

        echo json_Encode($answer);
    }

}//end of class

$remote = new remote();
$option = $_POST['opt'];

switch ($option) {
    case "autenticate":
        $remote->autenticate();
        break;

    case "sendCompanyAutentication":
        $remote->sendCompanyAutentication();
        break;

    case "sendPostulantAutentication":
        $remote->sendPostulantAutentication();
        break;

    case "mailinglist":
        $remote->mailinglist();
        break;

    case "hitsCounter":
        $remote->hitsCounter();
        break;

    default:
        die();
        break;

}
