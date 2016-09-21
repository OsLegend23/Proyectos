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

			$rGetAnnualPlan = $this->QUERY->getAnnualPlan();
			
			$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
			$total = $rGetAnnualPlan->size();

			$rGetAnnualPlan = $this->QUERY->getAnnualPlan("ORDER BY a.id DESC LIMIT $limitINIT, $rp");

			$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

			while ($row = $rGetAnnualPlan->fetch())
			{

				$entry = array('id'=>$row['id']
								,'cell'=>array(								
								'edit'				=>"<img src='../media/icon/_edit_min.png' style='cursor: pointer;' id='edit_".$row['id']."'>"
								,'delete'			=>"<img src='../media/icon/_delete_min.png' style='cursor: pointer;' id='delete_".$row['id']."'>"								
								,'planname'			=>$row['tx_name']
								,'cost'				=>$row['tx_cost']
								,'numposts'			=>$row['nm_posts']
								,'description'		=>$row['tx_description']
								,'totaldays'		=>$row['nm_totaldays']
							),
					);
					
				$answer['rows'][] = $entry;	
			}

			echo json_encode($answer);
	    }	    

	    function getRecordInfo()
	    {
	    	$getAnnualPlan = $this->QUERY->getAnnualPlan("WHERE a.id = '".$_POST['selectedRowID']."'");

	    	while ($row = $getAnnualPlan->fetch())
			{
				$answer  = array(		
								'id'					=>$row['id']
								,'planname'				=>$row['tx_name']
								,'cost'					=>$row['tx_cost']
								,'numposts'				=>$row['nm_posts']
								,'description'			=>$row['tx_description']
								,'totaldays'			=>$row['nm_totaldays']
								,'state'				=>$_POST['opt']
						);
			}

			echo json_Encode($answer);
	    }

	    function save()
	    {

			$aParams 			= array();

	    	foreach ($_POST as $key => $value)
	    		if($key !='opt')
	    			$aParams[$key] = $this->COMMON->getEscapeString($value);


	    	$getAnnualPlan = $this->QUERY->getAnnualPlan("WHERE  a.tx_name = '".$aParams['plan']."'");

	    	if($getAnnualPlan->size() > 0)
				    $answer = array("answer"=>'fail', "msg"=>$this->STR['AnnualPlanDuplicatedName_Error'], "state"=>$_POST['opt']);

			if(!isset($answer))
			{
				$getAnnualPlan 	= $this->QUERY->insertAnnualPlan(
				    		array(  'tx_name' 				=> 	$aParams['plan']									
									,'tx_cost'				=>	$aParams['annualPosts']
									,'nm_posts'				=>	$aParams['postsCost']
									,'tx_description'		=>	$aParams['AnnualPlanTotalDays']
									,'nm_totaldays'			=>	$aParams['Description']								
						));

				$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_Insert_Success'], "state"=>$_POST['opt']);

			}

			echo json_Encode($answer);	

	    }

	    function update()
	    {
			$aParams 			= array();

	    	foreach ($_POST as $key => $value)
	    		if($key !='opt')
	    			$aParams[$key] = $this->COMMON->getEscapeString($value);

			if(!isset($answer))
			{
				$getAnnualPlan 	= $this->QUERY->updateAnnualPlan(
				    		array(  'tx_name' 				=> 	$aParams['plan']									
									,'tx_cost'				=>	$aParams['annualPosts']
									,'nm_posts'				=>	$aParams['postsCost']
									,'tx_description'		=>	$aParams['AnnualPlanTotalDays']
									,'nm_totaldays'			=>	$aParams['Description']	
									
						), 
								"WHERE id = '".$_POST['selectedRowID']."'"
						);



				$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_Update_Success'], "state"=>$_POST['opt']);

			}

			echo json_Encode($answer);
	    }


	     function delete()
	    {
				$getAnnualPlan 	= $this->QUERY->deleteAnnualPlan("WHERE id = '".$_POST['selectedRowID']."'");

				$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_Delete_Success'], "state"=>$_POST['opt']);

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

			default:
				    die();
				    die();
			break;
	    
	    }
	    
	    
?>