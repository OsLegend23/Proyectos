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

	    function addVacancy()
	    {
			$aParams 			= array();

	    	foreach ($_POST as $key => $value)
	    		if($key !='opt')
	    			$aParams[$key] = $this->COMMON->getEscapeString($value);

	    	$aParams['aStudies']	=	explode(',', $aParams['aStudies']);
			$aParams['aLanguages']	=	explode(',', $aParams['aLanguages']);

			$rGetVacancy = $this->QUERY->getVacancy("WHERE  a.id_company 			= '".$_POST['companyId']."' 
							AND a.tx_name 			= '".$aParams['VacancyName']."'
							AND a.id_location 		= '".$aParams['Location']."'
							AND a.dt_registry 		= '".$this->STR['CurrentDate']."'
							AND a.id_type 			= '".$aParams['VacancyType']."'							
							AND a.id_workarea 		= '".$aParams['WorkArea']."'
							");
			$rDataVacancy	= $rGetVacancy->fetch();

			if($rGetVacancy->size() > 0)
			{				    
				    $answer = array("answer"=>'fail', "msg"=>$this->STR['Msg_Insert_DuplicateData'].' #'.$rDataVacancy['id'], "state"=>$_POST['opt']);
				    echo json_encode($answer);
				    return false;	    
			}

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

			$rGetCompany  = $this->QUERY->getCompany("WHERE  a.id_user = '".$_POST['companyId']."'");
			$rDataCompany	= $rGetCompany->fetch();


			$rGetVacancy 	= $this->QUERY->insertVacancy(
				    		array(  
				    				'id_company'					=> $_POST['companyId']
									,'tx_name'						=> $aParams['VacancyName']
									,'id_location'					=> $aParams['Location']
									,'dt_registry'					=> $this->STR['CurrentDate']
									,'dt_update'					=> $this->STR['CurrentDate']
									,'tx_hour'						=> $this->STR['CurrentHour']
									,'ch_status'					=> $aParams['StatusVacancy']
									,'id_type'						=> $aParams['VacancyType']
									,'nm_minage'					=> $aParams['InitAge']
									,'nm_maxage'					=> $aParams['FinishAge']
									,'ch_gender'					=> $aParams['Gender']
									,'ch_maritalstatus'				=> $aParams['MaritalStatus']
									,'ch_studystatus'				=> isset($aParams['ActualStatus'])? $aParams['ActualStatus']:'X'
									,'tx_reqstudy'					=> $aParams['OtherStudyRequires']
									,'id_workarea'					=> $aParams['WorkArea']
									,'ch_timeexperience'			=> $aParams['ExperienceTime']
									,'tx_requirements'				=> $aParams['Requirements']
									,'tx_activitydetail'			=> $aParams['ActivityDetail']
									,'tx_salaryoffered'				=> $aParams['SalaryOffered']
									,'ch_relatedstudylevel'			=> isset($aParams['Relatedstudylevel'])? $aParams['Relatedstudylevel']:'N'
									,'ch_relatedworkexperience'		=> $aParams['Relatedworkexperience']
									,'ch_confidential'				=> $aParams['ConfidentialMode']
									,'nm_vacancypriority'			=> $this->GLOBAL['vacancy_normalPriority']
									,'nm_totalvacancies'			=> $aParams['JobsOffered']			
						));


			$id_vacancy = $rGetVacancy->getLastInsertID();

			$countStudyLevels = count($aParams['aStudies']) / 5;

			for ($i=0; $i < $countStudyLevels; $i++) 
			{ 

				$id_studylevel 	= $aParams['aStudies'][($i * 5 ) + 3];
				$tx_studyarea 	= $aParams['aStudies'][($i * 5 ) + 4];
				
				$rGetVacancy_StudyLevel = $this->QUERY->insertVacancy_StudyLevel(
							array(  'id_vacancy'				=> $id_vacancy
									,'id_studylevel'			=> $id_studylevel
									,'tx_studyarea'				=> $tx_studyarea

						));
			}
			
			$countLanguages = count($aParams['aLanguages']) / 5;

			for ($i=0; $i < $countLanguages; $i++) 
			{ 

				$id_language 	= $aParams['aLanguages'][($i * 5 ) + 3];
				$nm_domain 		= $aParams['aLanguages'][($i * 5 ) + 4];

					$rGetVacancy_StudyLevel = $this->QUERY->insertVacancy_Language(
								array(  'id_vacancy'				=> $id_vacancy
										,'id_language'				=> $id_language
										,'nm_domain'				=> $nm_domain

							));
			}

	    	$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_Insert_Success'], "state"=>$_POST['opt']);
			echo json_encode($answer);
	    }

}//end of class
	    $remote = new remote();
	    $option = $_POST['opt'];	    
	    switch($option)
	    {	    	    
	    	
			case 'addVacancy':
				$remote->addVacancy();
				break;

			default:
				    die();
			break;
	    
	    }
	    
	    
?>

	    