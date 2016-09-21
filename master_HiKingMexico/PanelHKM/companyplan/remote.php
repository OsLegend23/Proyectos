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

	    function getRequestList()
	    {
	    	$page 		= isset($_POST['page']) ? $_POST['page'] : 1;
			$rp 		= isset($_POST['rp']) ? $_POST['rp'] : 10;
			$sortname 	= isset($_POST['sortname']) ? $_POST['sortname'] : 'name';
			$sortorder 	= isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';

			$companyId 	= isset($_POST['companyId']) ? $_POST['companyId'] : '0';

			$rGetAnnualPlan = $this->QUERY->getCompany_request_plan(" WHERE a.id_company = '".$companyId."'  AND a.ch_status = '".$this->GLOBAL['plan_enable']['value']."' ");
			
			$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
			$total = $rGetAnnualPlan->size();

			$rGetAnnualPlan = $this->QUERY->getCompany_request_plan(" WHERE a.id_company = '".$companyId."' AND a.ch_status = '".$this->GLOBAL['plan_enable']['value']."' GROUP BY a.id ORDER BY a.dt_registry DESC LIMIT $limitINIT, $rp");

			$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

			while ($row = $rGetAnnualPlan->fetch())
			{

				$entry = array('id'=>$row['id']
							,'cell'=>array(								
							'tracking'				=>"<img src='../media/icon/_preview_min.png' style='cursor: pointer;' id='tracking_".$row['id']."'>"
							,'creationdate'			=>$this->COMMON->getDateFormat($row['dt_registry'])
							,'planname'				=>$row['tx_name']
							,'posts'				=>$row['nm_posts']
							,'cost'					=>$row['tx_cost']
							,'description'			=>$row['tx_description']
							,'status'				=>$this->GLOBAL['plan_status'][$row['ch_status']]['label']
							),
					);

				$answer['rows'][] = $entry;	
			}

			echo json_encode($answer);
	    }

	    function getAssignedList()
	    {
	    	$page 		= isset($_POST['page']) ? $_POST['page'] : 1;
			$rp 		= isset($_POST['rp']) ? $_POST['rp'] : 10;
			$sortname 	= isset($_POST['sortname']) ? $_POST['sortname'] : 'name';
			$sortorder 	= isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';

			$companyId 	= isset($_POST['companyId']) ? $_POST['companyId'] : '0';

			$rGetAnnualPlan = $this->QUERY->getCompany_Plan(" WHERE a.id_company = '".$companyId."' ");
			
			$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
			$total = $rGetAnnualPlan->size();

			$rGetAnnualPlan = $this->QUERY->getCompany_Plan(" WHERE a.id_company = '".$companyId."'  GROUP BY a.id ORDER BY a.id DESC LIMIT $limitINIT, $rp");

			$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

			while ($row = $rGetAnnualPlan->fetch())
			{

				$entry = array('id'=>$row['id']
							,'cell'=>array(								
							'edit'				=>"<img src='../media/icon/_edit_min.png' style='cursor: pointer;' id='edit_".$row['id']."'>"
							,'creationdate'			=>$this->COMMON->getDateFormat($row['dt_registry'])
							,'planname'				=>$row['tx_planname']
							,'posts'				=>$row['nm_posts'] == 9999? $this->STR['UnLimited']:$row['nm_posts']
							,'initialperiod'		=>$this->COMMON->getDateFormat($row['dt_initialperiod'])
							,'periodended'			=>$this->COMMON->getDateFormat($row['dt_periodended'])
							,'status'				=>$this->GLOBAL['plan_status'][$row['ch_status']]['label']
							),
					);

				$answer['rows'][] = $entry;	
			}

			echo json_encode($answer);
	    }

	    function getRequestRecordInfo()
	    {
	    	$getAnnualPlan = $this->QUERY->getCompany_request_plan("WHERE a.id = '".$_POST['selectedRowID']."'");

	    	while ($row = $getAnnualPlan->fetch())
			{
				$answer  = array(		
								'id'						=>$row['id']
								,'idplan'					=>$row['id_plan']
								,'dtregistry'				=>$this->COMMON->getDateFormat($row['dt_registry'])
								,'chstatus'					=>$this->GLOBAL['plan_status'][$row['ch_status']]['label']
								,'status'					=>$row['ch_status']
								,'txcomment'				=>$row['tx_company_comment']
								,'txname'					=>$row['tx_name']
								,'txcost'					=>$row['tx_cost']
								,'nmposts'					=>$row['nm_posts']
								,'txdescription'			=>$row['tx_description']
								,'state'					=>$_POST['opt']
						);
			}

			echo json_Encode($answer);
	    }

	    function getAssignedRecordInfo()
	    {
	    	$getAnnualPlan = $this->QUERY->getCompany_Plan("WHERE a.id = '".$_POST['selectedRowID']."'");

	    	while ($row = $getAnnualPlan->fetch())
			{
				$answer  = array(		
						'id'						=>$row['id']								
						,'dtregistry'				=>$this->COMMON->getDateFormat($row['dt_registry'])
						,'chstatus'					=>$this->GLOBAL['plan_status'][$row['ch_status']]['label']
						,'status'					=>$row['ch_status']
						,'txcomment'				=>$row['tx_description']
						,'txname'					=>$row['tx_planname']
						,'txcost'					=>$row['tx_cost']
						,'nmposts'					=>$row['nm_posts'] == 9999? $this->STR['UnLimited']:$row['nm_posts']
						,'datein'					=>$this->COMMON->getDateFormat($row['dt_initialperiod'])
						,'dateout'					=>$this->COMMON->getDateFormat($row['dt_periodended'])
						,'admincomment'				=>$row['tx_admin_comment']
						,'state'					=>$_POST['opt']
				);
			}

			echo json_Encode($answer);
	    }

	    function processRequestPlan()
	    {

			$aParams 			= array();
	    	foreach ($_POST as $key => $value)
	    		if($key !='opt')
	    			$aParams[$key] = $this->COMMON->getEscapeString($value);

	    	if($aParams['status'] == $this->GLOBAL['plan_enable']['value'])
	    	{
				$this->QUERY->updateCompany_Plan(array('ch_status'=>$this->GLOBAL['plan_outrange']['value']),"WHERE id_company = '".$aParams['companyId']."' AND ch_status = '".$this->GLOBAL['plan_enable']['value']."' ");
 	
	    		$this->QUERY->insertCompany_Plan(
					array( 
						'id_company'				=> $aParams['companyId']
						,'tx_planname'				=> $aParams['planTextSelected']
						,'tx_cost'					=> $aParams['postsCost']
						,'nm_posts'					=> $aParams['annualPosts']
						,'dt_registry'				=> $this->STR['CurrentDate']
						,'dt_initialperiod'			=> $aParams['DateIn']
						,'dt_periodended'			=> $aParams['DateOut']
						,'tx_description'			=> ''
						,'ch_status'				=> $aParams['status']						
						)
	    		);
	    	}
	    	
	    	$this->QUERY->updateCompanyRequestPlan(
					array( 'ch_status'				=> $this->GLOBAL['plan_outrange']['value'] ),
					"WHERE id = '".$_POST['selectedRowID']."'"
	    	);

	    	$answer = array("answer"=>'correct', "msg"=>$this->STR['AnnualPlanUpdated'], "state"=>$_POST['opt']);

			echo json_Encode($answer);	
	    }

	    function processAssignedPlan()
	    {
			$aParams 			= array();
	    	foreach ($_POST as $key => $value)
	    		if($key !='opt')
	    			$aParams[$key] = $this->COMMON->getEscapeString($value);

	    	
			$this->QUERY->updateCompany_Plan(
					array(
						'ch_status'=>$aParams['status']
						,'tx_admin_comment'=>$aParams['Comment']
						),"WHERE id_company = '".$aParams['companyId']."' AND ch_status = '".$this->GLOBAL['plan_enable']['value']."' ");
 	
	    		    	
	    	$answer = array("answer"=>'correct', "msg"=>$this->STR['AnnualPlanUpdated'], "state"=>$_POST['opt']);

			echo json_Encode($answer);
	    }
	    
}//end of class
	    $remote = new remote();
	    $option = $_POST['opt'];	    
	    switch($option)
	    {	    	    
	    	
			case 'getRequestList':
				$remote->getRequestList();
			break;

			case 'getAssignedList':
				$remote->getAssignedList();
			break;

			case 'getRequestRecordInfo':
				$remote->getRequestRecordInfo();
			break;

			case 'getAssignedRecordInfo':
				$remote->getAssignedRecordInfo();
			break;

			case 'processRequestPlan':
				$remote->processRequestPlan();
			break;
			case 'processAssignedPlan':
				$remote->processAssignedPlan();
			break;

			default:
				    die();				    
			break;
	    
	    }
	    
	    
?>