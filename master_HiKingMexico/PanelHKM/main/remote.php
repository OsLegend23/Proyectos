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

	    function getpostulantinfo()
	    {
	    	
			$rGetUser = $this->QUERY->getCountUser("WHERE a.nm_type = '".$this->GLOBAL['user_postulant']['value']."' 
	    		AND a.nm_status = '".$this->GLOBAL['user_enable']['value']."' ");
			$rDataUser = $rGetUser->fetch();

			$totalPostulantUser = $rDataUser['totalUsers'];

	    	$rGetUser = $this->QUERY->getCountUser("WHERE a.nm_type = '".$this->GLOBAL['user_postulant']['value']."' 
	    		AND a.nm_status = '".$this->GLOBAL['user_enable']['value']."' AND a.dt_registry != a.dt_sign");
			$rDataUser = $rGetUser->fetch();

			$totalAutenticatedPostulantUser = $rDataUser['totalUsers'];

			$totalUnAutenticatedPostulantUser = $totalPostulantUser - $totalAutenticatedPostulantUser;			
	    	
	    	$rGetPostulant = $this->QUERY->getCountPostulant("WHERE b.nm_type = '".$this->GLOBAL['user_postulant']['value']."' 
	    		AND b.nm_status = '".$this->GLOBAL['user_enable']['value']."' AND a.ch_verified = 'N'");
			$rDataPostulant = $rGetPostulant->fetch();

			$totalUnVerified	= $rDataPostulant['totalPostulants'];

	    	$answer  = array(		
								'totalPostulants'		=>$totalPostulantUser
								,'totalAutenticated'	=>$totalAutenticatedPostulantUser
								,'totalUnAutenticate'	=>$totalUnAutenticatedPostulantUser
								,'unVerified'			=>$totalUnVerified								
								,'state'				=>$_POST['opt']
						);

	    	echo json_encode($answer);
	    }

	    function getcompanyinfo()
	    {

	    	$rGetUser = $this->QUERY->getCountUser("WHERE a.nm_type = '".$this->GLOBAL['user_company']['value']."' 
	    		AND a.nm_status = '".$this->GLOBAL['user_enable']['value']."' ");
			$rDataUser = $rGetUser->fetch();

			$totalCompanyUser = $rDataUser['totalUsers'];


			$rGetUser = $this->QUERY->getCountUser("WHERE a.nm_type = '".$this->GLOBAL['user_company']['value']."' 
	    		AND a.nm_status = '".$this->GLOBAL['user_enable']['value']."' AND a.dt_registry != a.dt_sign");
			$rDataUser = $rGetUser->fetch();

			$totalAutenticatedCompanyUser = $rDataUser['totalUsers'];

			$totalUnAutenticatedCompanyUser = $totalCompanyUser - $totalAutenticatedCompanyUser;			
	    	
	    	$rGetCompany = $this->QUERY->getCountCompany("WHERE b.nm_type = '".$this->GLOBAL['user_company']['value']."' 
	    		AND b.nm_status = '".$this->GLOBAL['user_enable']['value']."' AND a.ch_verified = 'N'");
			$rDataCompany = $rGetCompany->fetch();

			$totalUnVerified	= $rDataCompany['totalCompanies'];

			
			$answer  = array(		
								'totalCompanies'				=>$totalCompanyUser
								,'totalAutenticatedCompanies'	=>$totalAutenticatedCompanyUser
								,'totalUnAutenticateCompanies'	=>$totalUnAutenticatedCompanyUser
								,'unVerifiedCompanies'			=>$totalUnVerified								
								,'state'						=>$_POST['opt']
						);

	    	echo json_encode($answer);	    	
	    }

	    function gethitscounter()
	    {
	    	$rGetHitsCounter = $this->QUERY->getHitscounter(" ORDER BY a.dt_registry DESC");
			
	    	$aYear = array();

	    	$currentYear = 0;

	    	while ($row = $rGetHitsCounter->fetch())
			{
				
				$dt_registry 			= date("j-n-Y", strtotime($row['dt_registry']));
				$dt_registry 			= explode('-',$dt_registry);
				$dt_registry_month		= $dt_registry[1];
				$dt_registry_year		= $dt_registry[2];

				if($currentYear != $dt_registry_year)
				{
						$aYear[$dt_registry_year] = array($dt_registry_year,'0','0','0','0','0','0','0','0','0','0','0','0','0');
						$currentYear = $dt_registry_year;
				}

				$aYear[$dt_registry_year][$dt_registry_month] += 1;
				$aYear[$dt_registry_year]['13'] += 1;
			}

			$aYear['state'] = $_POST['opt'];
		      
			echo json_Encode($aYear);
	    	
	    }

	    function getvacancyinfo()
	    {

	    	$rGetCountVacancies = $this->QUERY->getCountVacancies("");
			$rDataCountVacancy = $rGetCountVacancies->fetch();

	    	$rGetVacanciesInfo = $this->QUERY->getCountVacanciesInfo(" GROUP BY a.id_company ORDER BY COUNT( a.id ) DESC LIMIT 0 , 10");
			
	    	$answer = array();

	    

	    	$answer['totalVacancies'] = array($rDataCountVacancy['total']);

	    	while ($row = $rGetVacanciesInfo->fetch())
			{
				$answer[] = array($row['tx_tradename'],$row['totalvacancies']);
			}

			$answer['state'] = $_POST['opt'];
		      
			echo json_Encode($answer);

	    }
	    
}//end of class
	    $remote = new remote();
	    $option = $_POST['opt'];	    
	    switch($option)
	    {	    	
	    	case 'getpostulantinfo':
	    		$remote->getpostulantinfo();
	    	break;

	    	case "getcompanyinfo":
	    		$remote->getcompanyinfo();
	    	break;

	    	case "gethitscounter":
	    		$remote->gethitscounter();
	    	break;

	    	case "getvacancyinfo":
	    		$remote->getvacancyinfo();
	    	break;

			default:
				    die();
			break;
	    
	    }
	    
	    
?>