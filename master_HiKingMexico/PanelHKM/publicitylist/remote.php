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

			$status 	= isset($_POST['status']) ? $_POST['status'] : $this->GLOBAL['status_enable']['value'];

			$rGetPublicity = $this->QUERY->getPublicity();
			
			$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
			$total = $rGetPublicity->size();

			$rGetPublicity = $this->QUERY->getPublicity("WHERE a.ch_status = '".$status."' ORDER BY a.nm_order ASC LIMIT $limitINIT, $rp");

			$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

			while ($row = $rGetPublicity->fetch())
			{

				$image = $this->COMMON->findPhoto($row['tx_image'].'_50p','media/image/slideshow');

				$image = str_replace('../../', '../', $image);

				$entry = array('id'=>$row['id']
								,'cell'=>array(								
								'edit'					=>"<img src='../media/icon/_edit_min.png' style='cursor: pointer;' id='edit_".$row['id']."'>"
								,'publicity'			=>"<img src='".$image."'>"
								,'order'				=>$row['nm_order']
								,'name'					=>$row['tx_name']
								,'Period'				=>$row['dt_initpublication'].' - '.$row['dt_finishpublication']
								,'status'				=>$this->GLOBAL['status'][$row['ch_status']]['label']
							),
					);



				$answer['rows'][] = $entry;	
			}

			echo json_encode($answer);
	    }	

	    function getsortablelist()
	    {
	    	
			$status 	= isset($_POST['status']) ? $_POST['status'] : $this->GLOBAL['status_enable']['value'];

			$rGetPublicity = $this->QUERY->getPublicity("WHERE a.ch_status = '".$status."' ORDER BY a.nm_order ASC");

			$answer = array("state"=>$_POST['opt']);

			while ($row = $rGetPublicity->fetch())
			{

				$image = $this->COMMON->findPhoto($row['tx_image'].'_50p','media/image/slideshow');
				$image = str_replace('../../', '../', $image);
				
				$entry = array(	
								'id'				=>$row['id']
								,'publicity'		=>"<img src='".$image."'>"
								,'order'			=>$row['nm_order'] 
							);

				$answer[] = $entry;	
			}

			echo json_encode($answer);
	    } 

	     function savesortablelist()
	    {
	    	
			$sort 	= isset($_POST['sort']) ? $_POST['sort'] : null;

			$sort 	= explode(',' ,$sort);

			$answer = array("state"=>$_POST['opt']);

			foreach ($sort as $key => $value) 
			{

				$positon = $key + 1;

				$this->QUERY->updatePublicity(
											array(														
													'nm_order' => $positon
				), "WHERE id ='".$value."'");
				
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

			case 'getsortablelist':
				$remote->getsortablelist();
			break;

			case 'savesortablelist':
				$remote->savesortablelist();
			break;

			default:				    
				    die();
			break;
	    
	    }
	    
	    
?>