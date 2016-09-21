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

			$email				= $this->COMMON->getEscapeString($_POST['Email']);
			$chars				= $this->COMMON->getEscapeString($_POST['Chars']);
			$getCaptcha			= $this->COMMON->getCaptcha();
			

			if(strcmp(strtolower($chars) , $getCaptcha) != 0){
			    $answer = array("answer"=>'fail', "msg"=>$this->STR['ValidateChars_Error'], 'state'=>$_POST['opt']);
			    echo json_encode($answer);
			    return false;
			}

			$rGetUser = $this->QUERY->getUser("WHERE tx_email = '".$email."' AND nm_status = '".$this->GLOBAL['user_enable']['value']."' LIMIT 0,1"); 
			$rData = $rGetUser->fetch();

			if($rGetUser->size() == 0)
			{
				$answer = array("answer"=>'fail', "msg"=>$this->STR['UserNotFound_Error'], 'state'=>$_POST['opt']);
				echo json_encode($answer);
				return false;
			}

			$tx_newsign			= md5($this->STR['CurrentDate'].$rData['tx_name'].$email.$_SERVER['REMOTE_ADDR'].date("H:i:s"));
			$this->QUERY->updateUser(array('tx_sign' => $tx_newsign), "WHERE id ='".$rData['id']."'");

			$params = array(
					 '{userName}'				=> $rData['tx_name'].' '.$rData['tx_surname']					
					,'{logoLink}'				=> '<img src="'.$this->GLOBAL['domain-root'].'media/image/logoHikingMexico.png">'					
					,'{linktorecovery}'			=> $this->GLOBAL['domain-root'].'passwordrecovery/?validation='.$tx_newsign
					,'{supportMail}'			=> $this->GLOBAL['email_support']
				);

			$subject 			= $this->STR['PassRecover'];
			$sendTo 			= $arrayName = array('from' => $this->GLOBAL['email_support'], 'to' => $email, 'subject' => $subject, 'charset' => 'utf-8');
			$bodyMessage 		= $this->COMMON->str_replace($this->STR['User_Password_Recover'],$params);
			
			$answer = array("answer"=>'correct', "msg"=>$this->STR['SentEmailWithRecoverInstructions'].' '.$email, "state"=>$_POST['opt']);

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