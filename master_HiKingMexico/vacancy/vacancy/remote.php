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
			$this->accountType 			= 	isset($_SESSION['enlaceemp_accounttype'])? $_SESSION['enlaceemp_accounttype']: null;
			$this->day_of_week 			= 	$day_of_week;
			$this->day_of_weekFull 		= 	$day_of_weekFull;
			$this->month 				= 	$month;
			$this->monthFull 			= 	$monthFull;
			$this->datefmt 				= 	$datefmt;

	    }

	    function apply()
	    {
			
			$companyId			= $this->COMMON->getEscapeString($_POST['companyId']);
			$vcn				= $this->COMMON->getEscapeString($_POST['vcn']);
			$rGetPostulation 	= $this->QUERY->getPostulation("WHERE id_postulant = '".$this->accountId."' AND id_vacancy = '$vcn'");	
			$CurrentDate 		= $this->STR['CurrentDate'];
			if($rGetPostulation->size() > 0)
		    {
		    	$rData = $rGetPostulation->fetch(); 
				$postulationDate = $rData['dt_registry'];
				$answer = array("answer"=>'fail', "msg"=>"<div class='ui-state-highlight ui-corner-all vcn_field' style='text-align: center;'>".$this->STR['PostulationAlreadyExist']."<div class='cleaner h10'></div>".$this->COMMON->getDateFormat($postulationDate)."</div>", "state"=>$_POST['opt']);
		    }
		    else if($this->accountType != $this->GLOBAL['user_postulant']['value'])
		    {									 
		    	$answer = array("answer"=>'fail', "msg"=>"<div class='ui-state-highlight ui-corner-all vcn_field' style='text-align: center;'>".$this->STR['PostulationNotAllowed']."</div>", "state"=>$_POST['opt']);
		    }
		    else
		    {
		    	$rGetPostulationInsert = $this->QUERY->insertPostulation(
		    		array(  'id_postulant' 	=> $this->accountId,
							'id_company' 	=> $companyId,
							'id_vacancy' 	=> $vcn,
							'dt_registry' 	=> $CurrentDate,
							'nm_status' 	=> $this->GLOBAL['vacancy_enable']['value']
					));	

				$postulationId = $rGetPostulationInsert->getLastInsertID(); 		    					

				$rGetVacancy 	= $this->QUERY->getVacancy("WHERE  a.id  = '$vcn'");
				$rData = $rGetVacancy->fetch();

				if($rData['ch_confidential'] == $this->GLOBAL['confidential_YES'])
					$companyName = $rData['tx_confidential_trademark'];
				else
					$companyName = $rData['tx_trademark'];

				$rGetVacancyStudyLevel 	= $this->QUERY->getVacancyStudyLevel("WHERE a.id_vacancy = '$vcn' GROUP BY a.id_studylevel ORDER BY b.id DESC");
				
				$studySpecs 	= null;
				while ($row = $rGetVacancyStudyLevel->fetch())
				{
					if(isset($studySpecs))
						$studySpecs 	.= ', ';

					$studySpecs 	.= $row['studylevel_tx_description'];

				}

				$rGetUser 	= $this->QUERY->getUser("WHERE id = '".$this->accountId."' ");
				$rGetUserData = $rGetUser->fetch();

				$params = array(
									'{yourName}' 			=> $rGetUserData['tx_name'].' '.$rGetUserData['tx_surname']
									,'{webpageLink}' 		=> $this->GLOBAL['domain-root']
									,'{postulationLink}' 	=> $this->GLOBAL['domain-root'].'postulant/?page=listpostulation'
									,'{logo}' 				=> $this->GLOBAL['domain-root'].'media/image/'.$this->GLOBAL['logo']
									,'{vacancyLbl}' 		=> $this->STR['Vacancy']
									,'{vacancyname}' 		=> $rData['tx_name']
									,'{vacancyInfoLbl}' 	=> $this->STR['Info']
									,'{companyNameLbl}' 	=> $this->STR['Company']
									,'{companyName}' 		=> $companyName
									,'{localizationLbl}' 	=> $this->STR['Location']
									,'{localization}' 		=> $rData['tx_city'].' '.$rData['tx_state'].', '.$rData['tx_country']
									,'{sectorLbl}' 			=> $this->STR['WorkArea']
									,'{sector}' 			=> $rData['workarea_tx_description']
									,'{vacancyTypeLbl}' 	=> $this->STR['VacancyType']
									,'{vacancyType}' 		=> $rData['vacancy_type_tx_description']
									,'{timeExperienceLbl}' 	=> $this->STR['ExperienceTime']
									,'{timeExperience}' 	=> $this->STR['ExperienceTimeList'][$rData['ch_timeexperience']]
									,'{studySpecsLbl}' 		=> $this->STR['StudySpecs']
									,'{studySpecs}' 		=> $studySpecs
									,'{referenceCodeLbl}' 	=> $this->STR['ReferenceCode']
									,'{referenceCode}' 		=> $rData['id']
					);

					$subject 			= $this->STR['PostulationRegistrySuccess'];
					$sendTo 			= $arrayName = array('from' => $this->GLOBAL['email_job'], 'to' => $rGetUserData['tx_email'], 'subject' => $subject, 'charset' => 'utf-8');
					$bodyMessage 		= $this->STR['mail_postulation_css'].$this->STR['mail_postulation_postulant'].$this->STR['mail_postulation_body'];
					
					//$answer = array("answer"=>'correct', "msg"=>$this->COMMON->str_replace($this->STR['Web_postulation_body'], $params), "state"=>$_POST['opt']);
					$answer = array("answer"=>'correct', "msg"=>$this->STR['Postulate_Success'], "state"=>$_POST['opt']);

					$this->COMMON->sendMail($sendTo, $bodyMessage, $params);

					
					$rGetUser 	= $this->QUERY->getUser("WHERE id = '".$rData['id_company']."' ");
					$rGetCompanyUserData = $rGetUser->fetch();


					$params = array(
									'{companyUserName}' 	=> $rGetCompanyUserData['tx_name'].' '.$rGetCompanyUserData['tx_surname']
									,'{newPostulantName}' 	=> $rGetUserData['tx_name'].' '.$rGetUserData['tx_surname']
									,'{newPostulantCVLink}' => $this->GLOBAL['domain-root'].'company/?page=listpostulation&ptl='.$postulationId
									,'{previewCV}' 			=> $this->STR['PreviewCV']
									,'{vacancyLbl}' 		=> $this->STR['Vacancy']
									,'{vacancyname}' 		=> $rData['tx_name']
									,'{postulationList}' 	=> $STR['PostulationList']
									,'{dt_registryLbl}' 	=> $this->STR['ApplyRegistry']
									,'{postulantNameLbl}' 	=> $this->STR['Name']
									,'{statusLbl}' 			=> $this->STR['Status']
									,'{viewCVLbl}' 			=> $this->STR['PreviewCV']
					);

					$bodyMessage 		= $this->STR['mail_postulation_css'].$this->STR['Mail_postulation_CompanyBody'];					
					
					$rGetPostulationList = $this->QUERY->getPostulationList("WHERE a.id_vacancy = '$vcn' AND c.nm_status = '".$this->GLOBAL['user_enable']['value']."' GROUP BY b.id_user");

					while ($row = $rGetPostulationList->fetch())
					{
						$bodyMessage 		.= "<tr><td>".$this->COMMON->getDateFormat($row['dt_registry'])."</td><td>".$row['tx_name']." ".
												$row['tx_surname']."</td><td>".$row['postulation_status_tx_description'].
												"</td><td><a href='".$this->GLOBAL['domain-root']."company/?page=listpostulation&ptl=".$row['id']."'>".$this->STR['PreviewCV']."</a></td></tr>";
					}

					$bodyMessage 		.= "</table>";

					$companyEmail 		= $rData['ch_confidential'] == $this->GLOBAL['confidential_YES']? $rData['tx_confidentialemail']: $rData['tx_companyemail'];
					
					$subject 			= $this->GLOBAL['site-min'].': '.$this->STR['NewPostulant'].', '.$rData['tx_name'];
					$sendTo 			= $arrayName = array('from' => $this->GLOBAL['email_job'], 'to' => $companyEmail, 'subject' => $subject, 'charset' => 'utf-8');

					$this->COMMON->sendMail($sendTo, $bodyMessage, $params);//Send To Company

		    }

		    echo json_encode($answer);
	    }

	    function share()
	    {
			$sharefrom			= $this->COMMON->getEscapeString($_POST['sharefrom']);
			$sendto				= $this->COMMON->getEscapeString($_POST['sendto']);
			$sharechars			= $this->COMMON->getEscapeString($_POST['sharechars']);
			$vcn				= $this->COMMON->getEscapeString($_POST['vcn']);
			$getCaptcha			= $this->COMMON->getCaptcha();

			$CurrentDate 		= $this->STR['CurrentDate'];
			

			if(strcmp(strtolower($sharechars) , $getCaptcha) != 0){
				    $answer = array("answer"=>'fail', "msg"=>$this->STR['ValidateChars_Error'], 'state'=>$_POST['opt']);
				    echo json_encode($answer);
				    return false;
			}

			$rGetVacancy 	= $this->QUERY->getVacancy("WHERE  a.id  = '$vcn'");
			$rData = $rGetVacancy->fetch();

			if($rData['ch_confidential'] == $this->GLOBAL['confidential_YES'])
				$companyName = $rData['tx_confidential_trademark'];
			else
				$companyName = $rData['tx_trademark'];

			$rGetVacancyStudyLevel 	= $this->QUERY->getVacancyStudyLevel("WHERE a.id_vacancy = '$vcn' GROUP BY a.id_studylevel ORDER BY b.id DESC");
				
			$studySpecs 	= null;
			while ($row = $rGetVacancyStudyLevel->fetch())
			{
				if(isset($studySpecs))
					$studySpecs 	.= ', ';

				$studySpecs 	.= $row['studylevel_tx_description'];

			}

			$params = array(
								'{yourName}' 			=> $sharefrom
								,'{webpageLink}' 		=> $this->GLOBAL['domain-root']
								,'{vacancyLink}' 		=> $this->GLOBAL['domain-root'].'vacancy/?vcn='.$vcn
								,'{logo}' 				=> $this->GLOBAL['domain-root'].'media/image/'.$this->GLOBAL['logo']
								,'{vacancyLbl}' 		=> $this->STR['Vacancy']
								,'{vacancyname}' 		=> $rData['tx_name']
								,'{vacancyInfoLbl}' 	=> $this->STR['Info']
								,'{companyNameLbl}' 	=> $this->STR['Company']
								,'{companyName}' 		=> $companyName
								,'{localizationLbl}' 	=> $this->STR['Location']
								,'{localization}' 		=> $rData['tx_city'].' '.$rData['tx_state'].', '.$rData['tx_country']
								,'{sectorLbl}' 			=> $this->STR['WorkArea']
								,'{sector}' 			=> $rData['workarea_tx_description']
								,'{vacancyTypeLbl}' 	=> $this->STR['VacancyType']
								,'{vacancyType}' 		=> $rData['vacancy_type_tx_description']
								,'{timeExperienceLbl}' 	=> $this->STR['ExperienceTime']
								,'{timeExperience}' 	=> $this->STR['ExperienceTimeList'][$rData['ch_timeexperience']]
								,'{studySpecsLbl}' 		=> $this->STR['StudySpecs']
								,'{studySpecs}' 		=> $studySpecs
								,'{referenceCodeLbl}' 	=> $this->STR['ReferenceCode']
								,'{referenceCode}' 		=> $rData['id']
						);

					$subject 			= $this->STR['Oportunity'];
					$sendTo 			= $arrayName = array('from' => $this->GLOBAL['email_no_reply'], 'to' => $sendto, 'subject' => $subject, 'charset' => 'utf-8');
					$bodyMessage 		= $this->STR['mail_postulation_css'].$this->STR['mail_postulation_share'].$this->STR['mail_postulation_body'];
					
					$answer = array("answer"=>'correct', "msg"=>$this->STR['ShareToCorrect'], "state"=>$_POST['opt']);

					$this->COMMON->sendMail($sendTo, $bodyMessage, $params);//Send To Friend

		    echo json_encode($answer);
	    }


}//end of class

	    $remote = new remote();
	    $option = $_POST['opt'];
	    
	    switch($option)
	    {

	    	
	    	case "apply":
	    		$remote->apply();
	    	break;

	    	case "share":
	    		$remote->share();
	    	break;

			default:			
				    die();
			break;
	    
	    }	    
?>