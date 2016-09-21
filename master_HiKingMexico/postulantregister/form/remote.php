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

        $this->day_of_week = $day_of_week;
        $this->day_of_weekFull = $day_of_weekFull;
        $this->month = $month;
        $this->monthFull = $monthFull;
        $this->datefmt = $datefmt;

    }

    function postulantRegister()
    {

        $aParams = array();

        $tx_sign = md5($this->STR['CurrentDate'] . $aParams['Name'] . $aParams['Email'] . $_SERVER['REMOTE_ADDR'] . date("H:i:s"));
        $getCaptcha = $this->COMMON->getCaptcha();

        foreach ($_POST as $key => $value)
            if ($key != 'opt' && $key != 'Chars')
                $aParams[$key] = $this->COMMON->getEscapeString($value);


        if (strcmp(strtolower($_POST['Chars']), $getCaptcha) != 0) {
            $answer = array("answer" => 'fail', "msg" => $this->STR['ValidateChars_Error'], 'state' => $_POST['opt']);
            echo json_encode($answer);
            return false;
        }

        if ($this->COMMON->getYearAgo($aParams['BornDate']) < 17) {
            $answer = array("answer" => 'fail', "msg" => $this->STR['InvalidAgeOld'], 'state' => $_POST['opt']);
            echo json_encode($answer);
            return false;
        }


        $rGetUser = $this->QUERY->getUser("WHERE tx_email = '" . $aParams['Email'] . "' ");

        if ($rGetUser->size() > 0) {
            $answer = array("answer" => 'fail', "msg" => $this->STR['Msg_DuplicateEmail'], "state" => $_POST['opt']);
        } else {
            $rGetUser = $this->QUERY->insertUser(
                array('tx_email' => $aParams['Email']
                , 'tx_password' => md5($aParams['Pass'])
                , 'tx_name' => $aParams['Name']
                , 'tx_surname' => $aParams['Surname']
                , 'nm_status' => $this->GLOBAL['user_enable']['value']
                , 'nm_type' => $this->GLOBAL['user_postulant']['value']
                , 'tx_sign' => $tx_sign
                , 'dt_registry' => $this->STR['CurrentDate']
                , 'dt_sign' => $this->STR['CurrentDate']
                , 'dt_lastvisit' => $this->STR['CurrentDate']
                , 'tx_ipaddress' => $_SERVER['REMOTE_ADDR']
                ));

            $idUser = $rGetUser->getLastInsertID();


            $rGetPostulant = $this->QUERY->insertPostulant(
                array('id_user' => $idUser
                , 'ch_gender' => $aParams['Gender']
                , 'dt_borndate' => $aParams['BornDate_submit']//Este puede cambiar
                , 'tx_rfc' => $aParams['RFC']
                , 'ch_maritalstatus' => 'N'
                , 'nm_country' => '134'
                , 'nm_state' => $aParams['State']
                , 'tx_city' => $aParams['City']
                , 'tx_image' => $this->GLOBAL['postulantDefaultImage']
                , 'ch_firstjob' => $aParams['FirstJob']
                , 'ch_verified' => 'N'
                ));

            $rGetPostulant_Stydies = $this->QUERY->insertPostulant_Studies(
                array('id_postulant' => $idUser
                , 'id_studylevel' => $aParams['StudyLevel']
                , 'id_studyarea' => $aParams['StudyArea']
                , 'tx_institution' => $aParams['InstituteName']
                ));

            if ($aParams['FirstJob'] == 'N') {
                $rGetPostulant_Experience = $this->QUERY->insertPostulant_Experience(
                    array('id_postulant' => $idUser
                    , 'tx_tradename' => $this->STR['NotSpecificated']
                    , 'id_hierarchy' => '-1'
                    , 'tx_salary' => '0'
                    , 'dt_startdatemonth' => '-1'
                    , 'dt_enddatemonth' => '-1'
                    , 'id_workarea' => $aParams['WorkArea']
                    , 'tx_jobtitle' => $aParams['JobTitle']
                    , 'dt_startdateyear' => $aParams['DateInstrYear']
                    , 'dt_enddateyear' => $aParams['DateOutstrYear']
                    ));
            }

            $params = array(
                '{userName}' => $aParams['Name'] . ' ' . $aParams['Surname']
            , '{logo}' => '<img src="' . $this->GLOBAL['domain-root'] . 'media/image/logoHikingMexico.png">'
            , '{userEmail}' => $aParams['Email']
            , '{password}' => $aParams['Pass']
            , '{goToAdmin}' => $this->GLOBAL['domain-root'] . 'account/'
            , '{linkValidation}' => $this->GLOBAL['domain-root'] . 'account/?validation=' . $tx_sign
            , '{email}' => $aParams['Email']
            , '{daysTolimitDate}' => $this->GLOBAL['emailVerificationRemainingDays']
            , '{limitDate}' => $this->COMMON->getDateFormat(date('Y-m-d', strtotime($this->STR['CurrentDate'] . ' + ' . $this->GLOBAL['emailVerificationRemainingDays'] . ' days')))
            , '{linkSupport}' => $this->GLOBAL['domain-root'] . 'support/?postulant'
            , '{empleoEmail}' => $this->GLOBAL['email_job']
            );

            $subject = $this->COMMON->str_replace($this->STR['Postulant_registry_subject'], $params);
            $sendTo = $arrayName = array('from' => $this->GLOBAL['email_job'], 'to' => $aParams['Email'], 'subject' => $subject, 'charset' => 'utf-8');
            $bodyMessage = $this->COMMON->str_replace($this->STR['Email_Postulant_registry'], $params);

            $answer = array("answer" => 'correct', "msg" => $this->COMMON->str_replace($this->STR['Email_Postulant_registryLocal'], $params), "state" => $_POST['opt']);

            $_SESSION['enlaceemp_accountid'] = $idUser;
            $_SESSION['enlaceemp_accountname'] = $aParams['Name'] . ' ' . $aParams['Surname'];
            $_SESSION['enlaceemp_accountmail'] = $aParams['Email'];
            $_SESSION['enlaceemp_accounttype'] = $this->GLOBAL['user_postulant']['value'];
            $_SESSION['enlaceemp_loginon'] = 1;
            $_SESSION['enlaceemp_signed'] = 0;
            $_SESSION['enlaceemp_dtregistry'] = $this->STR['CurrentDate'];
            $_SESSION['enlaceemp_remainingdays'] = $this->GLOBAL['emailVerificationRemainingDays'];
            $_SESSION['enlaceemp_image'] = $this->GLOBAL['defaultImage'];
            $_SESSION['enlaceemp_verified'] = $this->GLOBAL['Verified_NO'];

            $this->COMMON->sendMail($sendTo, $bodyMessage, $params);//Send To postulant

        }

        echo json_encode($answer);

    }

}//end of class
$remote = new remote();
$option = $_POST['opt'];
switch ($option) {

    case 'postulantRegister':
        $remote->postulantRegister();
        break;

    default:
        die();
        break;

}


?>