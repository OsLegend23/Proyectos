<?php
/*
  remote.php
 */
session_start();

class remote
{
    public $accountId;
    public $COMMON;
    public $db;
    public $STR;
    public $GLOBAL;
    public $QUERY;
    public $day_of_week;
    public $day_of_weekFull;
    public $month;
    public $monthFull;
    public $datefmt;

    public function __construct()
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

    public function companyRegister()
    {
        $aParams = array();
        $tx_sign = md5($this->STR['CurrentDate'] . $aParams['first'] . $aParams['email'] . $_SERVER['REMOTE_ADDR'] . date('H:i:s'));
        $getCaptcha = $this->COMMON->getCaptcha();
        foreach ($_POST as $key => $value) {
            if ($key !== 'opt' && $key !== 'Chars') {
                $pos = strrpos($key, 'Benefits_');
                if ($pos === false) {
                    $aParams[$key] = $this->COMMON->getEscapeString($value);
                } else {
                    $aParams['Benefits'] .= $this->COMMON->getEscapeString($key) . ';';
                }
            }
        }
        //Valida Captcha
        if (strcmp(strtolower($_POST['Chars']), $getCaptcha) != 0) {
            $answer = array('answer' => 'fail', 'msg' => $this->STR['ValidateChars_Error'], 'state' => $_POST['opt']);
            echo json_encode($answer);
            return false;
        }

        $rGetUser = $this->QUERY->getUser('WHERE tx_email = "' . $aParams['email'] . '"');
        $rGetRFC = $this->QUERY->getRFC($aParams['RFC']);
        if ($rGetUser->size() > 0) {
            $answer = array('answer' => 'fail', 'msg' => $this->STR['Msg_DuplicateCompanyEmail'], 'state' => $_POST['opt']);
        } elseif ($rGetRFC->size()>0) {
            $answer = array('answer' => 'fail', 'msg' => $this->STR['Msg_DuplicateCompany'], 'state' => $_POST['opt']);
        } else {
            $rGetUser = $this->QUERY->insertUser(
                array('tx_email' => $aParams['email']
                , 'tx_password' => md5($aParams['password'])
                , 'tx_name' => $aParams['first']
                , 'tx_surname' => $aParams['last']
                , 'nm_status' => $this->GLOBAL['user_enable']['value']
                , 'nm_type' => $this->GLOBAL['user_company']['value']
                , 'tx_sign' => $tx_sign
                , 'dt_registry' => $this->STR['CurrentDate']
                , 'dt_sign' => $this->STR['CurrentDate']
                , 'dt_lastvisit' => $this->STR['CurrentDate']
                , 'tx_ipaddress' => $_SERVER['REMOTE_ADDR']
                ));

            $idUser = $rGetUser->getLastInsertID();

            $rGetCompany = $this->QUERY->insertCompany(
                array('id_user' => $idUser
                , 'tx_tradename' => $aParams['razonSocial']
                , 'tx_trademark' => $aParams['marca']
                , 'tx_companyemail' => $aParams['emailCV']
                , 'tx_confidentialemail' => $aParams['emailConf']
                , 'tx_rfc' => $aParams['RFC']
                , 'tx_colony' => $aParams['colonia']
                , 'tx_street' => $aParams['calle']
                , 'tx_number' => $aParams['numero']
                , 'tx_phone' => $aParams['phone']
                , 'id_state' => $aParams['State']
                , 'tx_city' => $aParams['ciudad']
                , 'id_worksector' => $aParams['Sector']
                , 'tx_activity' => $aParams['giro']
                , 'tx_web' => $aParams['URLWeb']
                , 'tx_about' => $aParams['CompanyAbout']
                , 'tx_image' => $this->GLOBAL['companyDefaultImage']
                , 'tx_benefits' => $aParams['Benefits']
                , 'ch_verified' => $this->GLOBAL['Verified_NO']
                , 'nm_employees' => $aParams['Employees']
                ));

            $rGetCompany_Plan = $this->QUERY->insertCompany_Plan(
                array(
                    'id_company' => $idUser
                , 'tx_planname' => $this->STR['Promotion']
                , 'nm_posts' => 9999
                , 'dt_registry' => $this->STR['CurrentDate']
                , 'dt_initialperiod' => $this->STR['CurrentDate']
                , 'dt_periodended' => date('Y-m-d', strtotime($this->STR['CurrentDate'] . ' + ' . $this->GLOBAL['promotionPlannRemainingDays'] . ' days'))
                , 'tx_description' => '*Sin limite de publicaciones, <br> solo te pedimos que la escolaridad mínima que solicites en tus vacantes sea técnico o bachillerato'
                , 'ch_status' => $this->GLOBAL['plan_enable']['value']
                ));

            $params = array(
                '{userName}' => $aParams['first'] . ' ' . $aParams['last']
            , '{daysToPost}' => $this->GLOBAL['promotionPlannRemainingDays']
            , '{logo}' => '<img src="' . $this->GLOBAL['domain-root'] . 'media/image/logoHikingMexico.png">'
            , '{goToAdmin}' => $this->GLOBAL['domain-root'] . 'account/'
            , '{periodInit}' => $this->COMMON->getDateFormat($this->STR['CurrentDate'])
            , '{periodEnded}' => $this->COMMON->getDateFormat(date('Y-m-d', strtotime($this->STR['CurrentDate'] . ' + ' . $this->GLOBAL['promotionPlannRemainingDays'] . ' days')))
            , '{userEmail}' => $aParams['email']
            , '{password}' => $aParams['password']
            , '{linkValidation}' => $this->GLOBAL['domain-root'] . 'account/?validation=' . $tx_sign
            , '{email}' => $aParams['email']
            , '{daysTolimitDate}' => $this->GLOBAL['emailVerificationRemainingDays']
            , '{limitDate}' => $this->COMMON->getDateFormat(date('Y-m-d', strtotime($this->STR['CurrentDate'] . ' + ' . $this->GLOBAL['emailVerificationRemainingDays'] . ' days')))
            , '{linkSupport}' => $this->GLOBAL['domain-root'] . 'support/?company'
            , '{asociatedEmail}' => $this->GLOBAL['email_associated']
            );

            $subject = $this->COMMON->str_replace($this->STR['Company_registry_subject'], array('{TradeName}' => $aParams['razonSocial']));
            $sendTo = $arrayName = array('from' => $this->GLOBAL['email_associated'], 'to' => $aParams['email'], 'subject' => $subject, 'charset' => 'utf-8');
            $bodyMessage = $this->COMMON->str_replace($this->STR['Email_Company_registry'], $params);

            $answer = array('answer' => 'correct', 'msg' => $this->COMMON->str_replace($this->STR['Email_Company_registryLocal'], $params), 'state' => $_POST['opt']);

            $_SESSION['enlaceemp_accountid'] = $idUser;
            $_SESSION['enlaceemp_accountname'] = $aParams['first'] . ' ' . $aParams['last'];
            $_SESSION['enlaceemp_accountmail'] = $aParams['email'];
            $_SESSION['enlaceemp_accounttype'] = $this->GLOBAL['user_company']['value'];
            $_SESSION['enlaceemp_loginon'] = 1;
            $_SESSION['enlaceemp_signed'] = 0;
            $_SESSION['enlaceemp_dtregistry'] = $this->STR['CurrentDate'];
            $_SESSION['enlaceemp_image'] = $this->GLOBAL['defaultImage'];
            $_SESSION['enlaceemp_verified'] = $this->GLOBAL['Verified_NO'];
            $_SESSION['enlaceemp_remainingdays'] = $this->GLOBAL['emailVerificationRemainingDays'];

            $this->COMMON->sendMail($sendTo, $bodyMessage, $params);

            $sendTo = $arrayName = array('from' => $this->GLOBAL['email_no_reply'], 'to' => $this->GLOBAL['email_associated'], 'subject' => $subject, 'charset' => 'utf-8');

            $this->COMMON->sendMail($sendTo, $bodyMessage, $params);
        }
        echo json_encode($answer);
    }
}

//end of class
$remote = new remote();
$option = $_POST['opt'];
switch ($option) {
    case 'companyRegister':
        $remote->companyRegister();
        break;
    default:
        die();
        break;
}