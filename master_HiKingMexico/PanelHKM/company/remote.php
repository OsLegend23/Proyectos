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

	    function getList()
	    {
	    	$page 		= isset($_POST['page']) ? $_POST['page'] : 1;
			$rp 		= isset($_POST['rp']) ? $_POST['rp'] : 10;
			$sortname 	= isset($_POST['sortname']) ? $_POST['sortname'] : 'name';
			$sortorder 	= isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
			$findValue 	= isset($_POST['findValue']) ? $_POST['findValue'] : null;
			$companyId  = isset($_POST['companyId']) ? $_POST['companyId'] : 0;

			$condition = "WHERE a.id_company = '".$companyId."' ";

			if(!empty($findValue))
				$condition .=" AND (a.tx_name LIKE '%$findValue%' || a.dt_registry = '$findValue' || o.tx_description LIKE '%findValue%') ";

			$condition .= " GROUP BY a.id ORDER BY a.id DESC ";
			
			$rGetVacancy = $this->QUERY->getVacancy($condition);
			
			$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
			$total = $rGetVacancy->size();

			$condition .= " LIMIT $limitINIT, $rp";

			$rGetVacancy = $this->QUERY->getVacancy($condition);

			$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

			while ($row = $rGetVacancy->fetch())
			{

					$rGetPostulation = $this->QUERY->getPostulation("WHERE a.id_vacancy = '".$row['id']."'");

					$entry = array('id'=>$row['id']
								,'cell'=>array(								
								'edit'		=>"<img src='../media/icon/_edit_min.png' style='cursor: pointer;' id='edit_".$row['id']."'>"
								,'view'		=>"<img src='../media/icon/_preview_min.png' style='cursor: pointer;' id='view_".$row['id']."'>"
								,'renew'	=>"<img src='../media/icon/_postulation.png' style='cursor: pointer;' id='renew_".$row['id']."'>"
								,'status'	=> $row['vacanty_status_tx_description']
								,'date'		=> $this->COMMON->getDateFormat($row['dt_registry'])
								,'name'		=> $row['tx_name']
								,'postulations'	=> $rGetPostulation->size()
							),
					);
					
				$answer['rows'][] = $entry;	

			}

			echo json_encode($answer);
	    }

	    function renewpublication()
	    {
			$rGetCompanyPlan  = $this->QUERY->getCompany_Plan("WHERE  a.id_company = '".$_POST['companyId']."' AND a.ch_status = '".$this->GLOBAL['plan_enable']['value']."'");
			$rDataCompanyPlan	= $rGetCompanyPlan->fetch();

			if($rGetCompanyPlan->size() <= 0)
			{
				$answer = array("answer"=>'fail', "msg"=>$this->STR['CompanyPlanNotFound'].$this->GLOBAL['email_associated'], "state"=>$_POST['opt']);
				echo json_encode($answer);
				return false;
			}

			$Params = array(
				'{planName}' 			=> $rDataCompanyPlan['tx_planname']
				,'{initialPeriod}' 		=> $rDataCompanyPlan['dt_initialperiod']
				,'{periodEnded}' 		=> $rDataCompanyPlan['dt_periodended']
				,'{associatedMail}' 	=> $this->GLOBAL['email_associated']
			);

			if(!$this->COMMON->betweenDates($rDataCompanyPlan['dt_initialperiod'],$rDataCompanyPlan['dt_periodended']))
			{	
				$answer = array("answer"=>'fail', "msg"=>$this->COMMON->str_replace($this->STR['PlanPeriodEnded_Msg'], $Params), "state"=>$_POST['opt']);
				echo json_encode($answer);
				return false;
			}

			$rGetCountVacancies 	= $this->QUERY->getCountVacancies("WHERE a.id_company = '".$_POST['companyId']."' AND a.dt_registry BETWEEN '".$rDataCompanyPlan['dt_initialperiod']."' AND '".$rDataCompanyPlan['dt_periodended']."' AND a.id_type != '5' ");
			$rDataCountVacancies	= $rGetCountVacancies->fetch();

			if($rDataCountVacancies['total'] > $rDataCompanyPlan['nm_posts'])
			{
				$answer = array("answer"=>'fail', "msg"=>$this->STR['CompanyPlanMaxPostReached'].$this->GLOBAL['email_associated'], "state"=>$_POST['opt']);
				echo json_encode($answer);
				return false;
			}
				
				$rGetVacancy 	= $this->QUERY->updateVacancy(
				    		array(  				    													
									'dt_registry'					=> $this->STR['CurrentDate']
									,'tx_hour'						=> $this->STR['CurrentHour']
									,'dt_update'					=> $this->STR['CurrentDate']
									,'ch_status'					=> $this->GLOBAL['vacancy_enable']['value']
						),"WHERE id = '".$_POST['selectedRowID']."'"
				);

				$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_Renew_Success'], "state"=>$_POST['opt']);

				echo json_Encode($answer);
	    }

	    function autenticate()
	    {

	    		$date = strtotime("+1 day", strtotime($this->STR['CurrentDate']));

	    		$rGetUser 	= $this->QUERY->updateUser(
				    		array(  				    													
									'dt_sign'						=> date("Y-m-d", $date)
						),"WHERE id = '".$_POST['companyId']."'"
				);

				$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_Update_Success'], "state"=>$_POST['opt']);

				echo json_Encode($answer);

	    }
		function verifyaccount()
		{
			

				$rGetCompany 	= $this->QUERY->updateCompany(
				    		array(  				    													
							'ch_verified'					=> 'S'
						),"WHERE id_user = '".$_POST['companyId']."'"
				);


				$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_Update_Success'], "state"=>$_POST['opt']);

				echo json_Encode($answer);

		}
		function changeaccountstatus()
		{
				
				$rGetUser 	= $this->QUERY->getUser("WHERE a.id='".$_POST['companyId']."' AND a.nm_type = '".$this->GLOBAL['user_company']['value']."'");
				$rData 		=	$rGetUser->fetch();

				$newStatus = $rData['nm_status'] != $this->GLOBAL['user_enable']['value']? $this->GLOBAL['user_enable']['value']: $this->GLOBAL['user_disable']['value']; 

				$rGetUser 	= $this->QUERY->updateUser(
				    		array(  				    													
									'nm_status'						=> $newStatus
						),"WHERE id = '".$_POST['companyId']."'"
				);

				if($newStatus == $this->GLOBAL['user_enable']['value'])
					$msg = $this->STR['DisableAccount']; 
				else
					$msg = $this->STR['EnableAccount']; 

				$answer = array("answer"=>'correct', "msg"=>$msg, "state"=>$_POST['opt']);

				echo json_Encode($answer);

		}
	    
}//end of class
	    $remote = new remote();
	    $option = $_POST['opt'];	    
	    switch($option)
	    {	    	    
	    	
			case 'getList':
				$remote->getList();
			break;

			case 'renewpublication':
				$remote->renewpublication();
			break;

			case 'autenticate':
					$remote->autenticate();
				break;
			case 'verifyaccount':
					$remote->verifyaccount();
				break;
			case 'changeaccountstatus':
					$remote->changeaccountstatus();
				break;

			default:
				    die();				    
			break;
	    
	    }
	    
	    
?>