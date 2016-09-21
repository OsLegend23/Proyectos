<?php

class boss_security
{

    var $sessionInactiveTime = 150000; //1200 = 20 mins

    function __construct()
    {
        $this->init_session();
    }

    function init_session()
    {
        if (!isset($_SESSION['enlaceemp_accountid']))
            $_SESSION['enlaceemp_accountid'] = '';

        if (!isset($_SESSION['enlaceemp_userid']))
            $_SESSION['enlaceemp_userid'] = '';

        if (!isset($_SESSION['enlaceemp_accountname']))
            $_SESSION['enlaceemp_accountname'] = '';

        if (!isset($_SESSION['enlaceemp_accountmail']))
            $_SESSION['enlaceemp_accountmail'] = '';

        if (!isset($_SESSION['enlaceemp_accounttype']))
            $_SESSION['enlaceemp_accounttype'] = '';

        if (!isset($_SESSION['enlaceemp_loginon']))
            $_SESSION['enlaceemp_loginon'] = 0;

        if (!isset($_SESSION['enlaceemp_signed']))
            $_SESSION['enlaceemp_signed'] = 0;

        if (!isset($_SESSION['enlaceemp_dtregistry']))
            $_SESSION['enlaceemp_dtregistry'] = 0;

        if (!isset($_SESSION['enlaceemp_remainingdays']))
            $_SESSION['enlaceemp_remainingdays'] = 0;

        if (!isset($_SESSION['enlaceemp_image']))
            $_SESSION['enlaceemp_image'] = '';

        if (!isset($_SESSION['enlaceemp_verified']))
            $_SESSION['enlaceemp_verified'] = '';
    }

    function getAccountId()
    {
        return $_SESSION['enlaceemp_accountid'];
    }

    function getUserId()
    {
        return $_SESSION['enlaceemp_userid'];
    }

    function getAccountName()
    {
        return $_SESSION['enlaceemp_accountname'];
    }

    function getAccountMail()
    {
        return $_SESSION['enlaceemp_accountmail'];
    }

    function getAccountType()
    {
        return $_SESSION['enlaceemp_accounttype'];
    }

    function getLoginOn()
    {
        return $_SESSION['enlaceemp_loginon'];
    }

    function getSigned()
    {
        return $_SESSION['enlaceemp_signed'];
    }

    function getDtRegistry()
    {
        return $_SESSION['enlaceemp_dtregistry'];
    }

    function getRemainingDays()
    {
        return $_SESSION['enlaceemp_remainingdays'];
    }

    function getImage()
    {
        return $_SESSION['enlaceemp_image'];
    }

    function getVerified()
    {
        return $_SESSION['enlaceemp_verified'];
    }

    /*     * ********************************************************** */

    function setAccountId($accountId)
    {
        $_SESSION['enlaceemp_accountid'] = $accountId;
    }

    function setUserId($userId)
    {
        $_SESSION['enlaceemp_userid'] = $userId;
    }

    function setAccountName($accountName)
    {
        $_SESSION['enlaceemp_accountname'] = $accountName;
    }

    function setAccountMail($accountMail)
    {
        $_SESSION['enlaceemp_accountmail'] = $accountMail;
    }

    function setAccountType($accountType)
    {
        $_SESSION['enlaceemp_accounttype'] = $accountType;
    }

    function setLoginOn($loginOn)
    {
        $_SESSION['enlaceemp_loginon'] = $loginOn;
    }

    function setSigned($signed)
    {
        $_SESSION['enlaceemp_signed'] = $signed;
    }

    function setDtRegistry($dtRegistry)
    {
        $_SESSION['enlaceemp_dtregistry'] = $dtRegistry;
    }

    function setRemainingDays($remainingDays)
    {
        $_SESSION['enlaceemp_remainingdays'] = $remainingDays;
    }

    function setImage($image)
    {
        $_SESSION['enlaceemp_image'] = $image;
    }

    function setVerified($verified)
    {
        $_SESSION['enlaceemp_verified'] = $verified;
    }

    /*     * ********************************************************** */

    function get_session_id()
    {
        return session_id();
    }

    function isTimeOut()
    {

        if (isset($_SESSION['enlaceemp_timeout'])) {
            $session_life = time() - $_SESSION['enlaceemp_timeout'];

            if ($session_life > $this->sessionInactiveTime) {
                $this->close_session();
                $this->destroy_session();
            }
        }

        $_SESSION['enlaceemp_timeout'] = time();
    }

    function close_session()
    {
        session_unset();
    }

    function destroy_session()
    {
        session_destroy();
    }

    function validateAccess($root, $aUserType, $accountType)
    {
        $domain = explode($root, $_SERVER['SCRIPT_FILENAME']);
        $domain = explode('/', $domain[1]);

        $validate = false;

        foreach ($domain as $key => $value)
            if (strcasecmp($aUserType[$accountType]['location'], $value) == 0)
                $validate = true;


        if ($accountType == $aUserType['4000']['value'])
            return true;

        return $validate;
    }

    function __destruct()
    {

    }

}

session_start();
$boss = new boss_security();

$boss->isTimeOut();

if ($boss->getLoginOn()) {
    if (!$boss->validateAccess($GLOBAL['root'], $GLOBAL['user_list'], $boss->getAccountType())) {
        $location = $COMMON->getRoot() . $GLOBAL['user_list'][$boss->getAccountType()]['location'] . '/';
        ?>
        <body onLoad=window.setTimeout("top.location.href='<?php echo $location; ?>'",0)></body>
        <?php
        die();
    }
} else
    if (!$boss->getLoginOn()) {
        ?>
        <body onLoad=window.setTimeout("top.location.href='<?php echo $GLOBAL['domain-root']; ?>account/'",0)></body>
        <?php
        die();
    }
?>