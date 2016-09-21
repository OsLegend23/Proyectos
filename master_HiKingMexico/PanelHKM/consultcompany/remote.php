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
			$findValue 	= isset($_POST['findValue']) ? $_POST['findValue'] : null;


			$condition = "WHERE b.nm_type = '".$this->GLOBAL['user_company']['value']."' ";

			if(!empty($findValue))
				$condition .=" AND (b.tx_email LIKE '%$findValue%' || b.tx_name LIKE '%$findValue%' || b.tx_surname LIKE '%findValue%' ) ";
			
			$condition .= "ORDER BY b.id DESC ";

			$rGetCompany = $this->QUERY->getCompany($condition);
			
			$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
			$total = $rGetCompany->size();

			$condition .= " LIMIT $limitINIT, $rp";

			$rGetCompany = $this->QUERY->getCompany($condition);

			$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

			while ($row = $rGetCompany->fetch())
			{
				
				$rGetAnnualPlan 		= $this->QUERY->getCompany_Plan(" WHERE a.id_company = '".$row['id_user']."' ");
				$rDataCompanyPlan		= $rGetAnnualPlan->fetch();
				
				$loginUserClass			= $row['nm_status'] 	== $this->GLOBAL['user_enable']['value']? 'passInfo':'warningInfo';
				$companyRegistryClass	= $row['ch_verified'] 	== $this->GLOBAL['Verified_YES']? 'passInfo':'warningInfo';
				$userClass				= $row['dt_registry'] 	!= $row['dt_sign']? 'passInfo':'warningInfo';


				$companyRegistry		= $row['ch_verified'] 	== $this->GLOBAL['Verified_YES']? $this->STR['Verified']:$this->STR['UnVerified'];
				$user					= $row['dt_registry'] 	!= $row['dt_sign']? $this->STR['Autenticated']:$this->STR['UnAutenticated'];

				$plan_statusClass		= $rDataCompanyPlan['ch_status'] == $this->GLOBAL['plan_enable']['value']? 'passInfo':'warningInfo';

				$entry = array('id'=>$row['id_user']
								,'cell'=>array(
								'signin'				=> "<img src='../media/icon/_preview_min.png' style='cursor: pointer;' id='signin_".$row['id_user']."'>"															
								,'date'					=> $this->COMMON->getDateFormat($row['dt_registry'])
								,'tradename'			=> $row['tx_tradename']
								,'status'				=> 	'<div class="'.$loginUserClass.'" >'.$this->STR['LoginUser'].': '.$this->GLOBAL['user_status'][$row['nm_status']]['label'].'</div></br>'.
															'<div class="'.$companyRegistryClass.'" >'.$this->STR['CompanyRegistry'].': '.$companyRegistry.'</div></br>'.
															'<div class="'.$userClass.'" >'.$this->STR['User'].': '.$user.'</div>'
								,'plan'					=> '<div class="'.$plan_statusClass.'" >'.$rDataCompanyPlan['tx_planname'].' - <strong>'.$this->GLOBAL['plan_status'][$rDataCompanyPlan['ch_status']]['label'].'</strong></div></br>'.$this->COMMON->getDateFormat($rDataCompanyPlan['dt_initialperiod']).' - '.$this->COMMON->getDateFormat($rDataCompanyPlan['dt_periodended'])
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