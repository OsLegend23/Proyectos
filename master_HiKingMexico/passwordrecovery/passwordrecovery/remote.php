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
			
	    	$this->COMMON 				= 	$COMMON;
	    	$this->STR 					= 	$STR;
	    	$this->GLOBAL 				= 	$GLOBAL;
	    	$this->QUERY 				= 	$QUERY;
			$this->accountId 			= 	isset($_SESSION['enlaceemp_accountid'])? $_SESSION['enlaceemp_accountid']:null;

			$this->day_of_week 			= 	$day_of_week;
			$this->day_of_weekFull 		= 	$day_of_weekFull;
			$this->month 				= 	$month;
			$this->monthFull 			= 	$monthFull;
			$this->datefmt 				= 	$datefmt;

	    }

	    function passwordRecovery()
	    {
	    	
			$pass			= $this->COMMON->getEscapeString($_POST['Pass']);
			$ConfPass		= $this->COMMON->getEscapeString($_POST['ConfPass']);
			$chars			= $this->COMMON->getEscapeString($_POST['Chars']);
			$validation 	= $this->COMMON->getEscapeString($_POST['validation']);

			$getCaptcha			= $this->COMMON->getCaptcha();
			$CurrentDate 		= $this->STR['CurrentDate'];
			

			if(strcmp(strtolower($chars) , $getCaptcha) != 0){
			    $answer = array("answer"=>'fail', "msg"=>$this->STR['ValidateChars_Error'], 'state'=>$_POST['opt']);
			    echo json_encode($answer);
			    return false;
			}

			$rGetUser 			= $this->QUERY->getUser("WHERE tx_sign = '".$validation."' AND nm_status = '".$this->GLOBAL['user_enable']['value']."' LIMIT 0,1"); 
			
			if($rGetUser->size() == 0)
			{
				$answer = array("answer"=>'fail', "msg"=>$this->STR['UserNotFound_Error'], 'state'=>$_POST['opt']);
				echo json_encode($answer);
				return false;
			}

			$rData = $rGetUser->fetch();
			
			$params = array(
					 '{userName}'				=> $rData['tx_name'].' '.$rData['tx_surname']					
					,'{logoLink}'				=> '<img src="'.$this->GLOBAL['domain-root'].'media/image/logoHikingMexico.png">'					
					,'{linkSupport}'			=> $this->GLOBAL['domain-root'].'support/'
					,'{userEmail}'				=> $rData['tx_email']
					,'{password}'				=> $pass
					,'{supportMail}'			=> $this->GLOBAL['email_support']
				);

			$subject 			= $this->STR['PassRecoverSuccess'];
			$sendTo 			= $arrayName = array('from' => $this->GLOBAL['email_support'], 'to' => $rData['tx_email'], 'subject' => $subject, 'charset' => 'utf-8');
			$bodyMessage 		= $this->COMMON->str_replace($this->STR['Send_User_NewPassword'],$params);

			$tx_newsign			= md5($this->STR['CurrentDate'].$rData['tx_name'].$rData['tx_email'].$_SERVER['REMOTE_ADDR'].date("H:i:s"));
			$this->QUERY->updateUser(array('tx_sign' => $tx_newsign, 'tx_password' => md5($pass) ), "WHERE id ='".$rData['id']."'");
			
			$answer = array("answer"=>'correct', "msg"=>$this->STR['PassRecoverSuccess'], "state"=>$_POST['opt']);

			$this->COMMON->sendMail($sendTo, $bodyMessage, $params);//Send To postulant
			
			echo json_Encode($answer);
	    }

	    
}//end of class
		$remote = new remote();
	    $option = $_POST['opt'];
	    
	    switch($option)
	    {
	    	case "passwordRecovery":
	    		$remote->passwordRecovery();
	    	break;

			default:					
				    die();
			break;
	    
	    }
	    
	    
?>