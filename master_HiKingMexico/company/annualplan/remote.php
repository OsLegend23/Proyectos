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
			$this->accountId 			= 	isset($_SESSION['enlaceemp_accountid'])? $_SESSION['enlaceemp_accountid']: null;

			$this->day_of_week 			= 	$day_of_week;
			$this->day_of_weekFull 		= 	$day_of_weekFull;
			$this->month 				= 	$month;
			$this->monthFull 			= 	$monthFull;
			$this->datefmt 				= 	$datefmt;

	    }

	    function sendannualplan()
	    {

	    	$aParams 			= array();

	    	foreach ($_POST as $key => $value)
	    		if($key !='opt')
	    			$aParams[$key] = $this->COMMON->getEscapeString($value);

	    	$aParams['aAnnualPlan'] 	= json_decode($aParams['aAnnualPlan']);

	    	$rGetCompanyRequestPlan = $this->QUERY->getCompany_request_plan("WHERE a.id_company = '".$this->accountId."' AND ch_status = 'A'");

	    	if($rGetCompanyRequestPlan->size() > 0)
	    	{
	    		$answer = array("answer"=>'fail', "msg"=>$this->STR['RequestPlanOnProcess'], "state"=>$_POST['opt']);
				echo json_encode($answer);
				return false;
	    	}

	    	$rGetInsertRequestPlan = $this->QUERY->insertCompanyRequestPlan(
				array(  'id_company'				=> $this->accountId
						,'dt_registry'				=> $this->STR['CurrentDate']
						,'ch_status'				=> 'A'
						,'id_plan'					=> $aParams['plan']
						,'tx_company_comment'		=> $aParams['comment']
						,'tx_admin_comment'			=> ''
			));

			$idRequestPlan = $rGetInsertRequestPlan->getLastInsertID();

			$rGetCompany = $this->QUERY->getCompany("WHERE a.id_user = '".$this->accountId."'");
			$rData = $rGetCompany->fetch();

			$params = array(
							'{logoLink}'			=> "<img src='".$this->GLOBAL['domain-root'].'media/image/'.$this->GLOBAL['logo']."'>"
							,'{userName}'			=> $_SESSION['enlaceemp_accountname']
							,'{requestId}'			=> $idRequestPlan
							,'{status}'				=> $this->GLOBAL['plan_enable']['label']
							,'{dt_registry}'		=> $this->COMMON->getDateFormat($this->STR['CurrentDate'])
							,'{planName}'			=> $aParams['aAnnualPlan'][$aParams['plan']][1]
							,'{cost}'				=> $aParams['aAnnualPlan'][$aParams['plan']][2]
							,'{totalPosts}'			=> $aParams['aAnnualPlan'][$aParams['plan']][3]
							,'{company_comment}'	=> $aParams['comment']
							,'{companyName}'		=> $rData['tx_tradename']
							,'{userName}'			=> $_SESSION['enlaceemp_accountname']
							,'{phone}'				=> $rData['tx_phone']
							,'{email}'				=> $_SESSION['enlaceemp_accountmail']
							,'{location}'			=> $rData['tx_city']
							,'{associatedMail}'		=> $this->GLOBAL['email_associated']
					);

			$subject 			= $this->STR['RequestAnnualPlan'].', '.$aParams['aAnnualPlan'][$aParams['plan']][1];
			$sendTo 			= $arrayName = array('from' => $this->GLOBAL['email_associated'], 'to' => $_SESSION['enlaceemp_accountmail'], 'subject' => $subject, 'charset' => 'utf-8');
			
			$bodyMessage 		= $this->COMMON->str_replace($this->STR['RequestPlan_Msg'], $params);
			
			$this->COMMON->sendMail($sendTo, $bodyMessage, $params);

			$sendTo 			= $arrayName = array('from' => $_SESSION['enlaceemp_accountmail'], 'to' => $this->GLOBAL['email_associated'], 'subject' => $subject, 'charset' => 'utf-8');

			$this->COMMON->sendMail($sendTo, $bodyMessage, $params);


			$answer = array("answer"=>'correct', "msg"=>$this->STR['RequestSended'], "state"=>$_POST['opt']);
			echo json_encode($answer);
	    }
	    
}//end of class
	    $remote = new remote();
	    $option = $_POST['opt'];	    
	    switch($option)
	    {	    	    
	    	
			case 'sendannualplan':
				$remote->sendannualplan();
			break;

			default:
				    die();
			break;
	    
	    }
	    
	    
?>