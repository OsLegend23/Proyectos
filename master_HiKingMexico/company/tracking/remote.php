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
			$id_vacancy	= isset($_POST['vcn']) ? $_POST['vcn'] : 0;

			$rGetPostulation = $this->QUERY->getPostulation("WHERE a.id_vacancy = '".$id_vacancy."' AND a.nm_status != '5'");
			
			$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
			$total = $rGetPostulation->size();

			$rGetPostulation = $this->QUERY->getPostulation("WHERE a.id_vacancy = '".$id_vacancy."' AND a.nm_status != '5' ORDER BY a.id DESC LIMIT $limitINIT, $rp");

			$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

			while ($row = $rGetPostulation->fetch())
			{
				$entry = array('id'=>$row['id']
								,'cell'=>array(								
								'view'					=>"<img src='../media/icon/_preview_min.png' style='cursor: pointer;' id='view_".$row['id']."'>"								
								,'date'					=>$row['dt_registry']
								,'postulantname'		=>$row['postulatname'].' '.$row['tx_surname']
								,'status'				=>$row['postulation_status_tx_description']								
							),
					);

				$answer['rows'][] = $entry;	
			}

			echo json_encode($answer);
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
			break;
	    }	    
?>