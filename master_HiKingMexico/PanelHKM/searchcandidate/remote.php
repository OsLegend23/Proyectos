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
			$keyword 	= isset($_POST['keyword']) ? $_POST['keyword'] : null;
			$consult 	= isset($_POST['consult']) ? $_POST['consult'] : null;
			$workArea 	= isset($_POST['workArea']) ? $_POST['workArea'] : null;
			$studyLevel = isset($_POST['studyLevel']) ? $_POST['studyLevel'] : null;
			$studyArea 	= isset($_POST['studyArea']) ? $_POST['studyArea'] : null;


			$condition = "WHERE a.nm_type = '".$this->GLOBAL['user_postulant']['value']."' ";

			if(!empty($keyword) && $consult == 'simplequery')
				$condition .=" AND (a.tx_email LIKE '%$keyword%' || a.tx_name LIKE '%$keyword%' || a.tx_surname LIKE '%keyword%' ) ";

			if(!empty($workArea)  && $consult == 'experience' )
				$condition .=" AND (c.id_workarea  = '$workArea') ";

			if(!empty($studyLevel) && $consult == 'educative' )
				$condition .=" AND (d.id_studylevel  = '$studyLevel') ";

			if(!empty($studyArea) && $consult == 'educative')
				$condition .=" AND (d.id_studyarea  = '$studyArea') ";
			
			$condition .= "GROUP BY a.id ORDER BY a.id DESC";

			$rGetUser = $this->QUERY->getCandidate($condition);
			
			$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
			$total = $rGetUser->size();

			$condition .= " LIMIT $limitINIT, $rp";

			$rGetUser = $this->QUERY->getCandidate($condition);

			$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

			while ($row = $rGetUser->fetch())
			{

				$rGetCVFile = $this->QUERY->getPostulant_CVFile("WHERE a.id_postulant = '".$row['id']."' ");
				
				$downloadCV = "<img src='../media/icon/_pdf_gray.png'>";
				
				if($rGetCVFile->size() > 0)
				{					
					$rData = $rGetCVFile->fetch();

					if( $this->COMMON->findFile($rData['tx_binaryname'], "media/cvfile/".$row['id']."", '../../') )
					{
						$downloadCV = "<img src='../media/icon/_pdf.png' style='cursor: pointer;' id='download_".$rData['id']."'>";	
					}						
				}

				$entry = array('id'=>$row['id']
								,'cell'=>array(
								'enlace'				=> "<img src='../media/icon/_postulation.png' style='cursor: pointer;' id='postulation_".$row['id']."'>"								
								,'viewcv'				=> "<img src='../media/icon/_viewcv_min.png' style='cursor: pointer;' id='viewcv_".$row['id']."'>"
								,'downloadcv'			=> $downloadCV
								,'date'					=> $this->COMMON->getDateFormat($row['dt_registry'])
								,'postulantname'		=> $this->COMMON->getUcwords($row['tx_name'].' '.$row['tx_surname'])
								,'email'				=> $row['tx_email']
								,'status'				=> $this->GLOBAL['user_status'][$row['nm_status']]['label']
							),
					);

				$answer['rows'][] = $entry;	
			}

			echo json_encode($answer);
	    }


	    function linkPostulantToVacancy()
	    {
			
			$postulantId		= $this->COMMON->getEscapeString($_POST['getSelectedRow']);			
			$vcn				= $this->COMMON->getEscapeString($_POST['vacancy']);
			
			$rGetPostulation 	= $this->QUERY->getPostulation("WHERE id_postulant = '".$postulantId."' AND id_vacancy = '".$vcn."'");	
			$CurrentDate 		= $this->STR['CurrentDate'];
			
			if($rGetPostulation->size() > 0)
		    {
		    	$rData = $rGetPostulation->fetch(); 
				$postulationDate = $rData['dt_registry'];
				$answer = array("answer"=>'fail', "msg"=>"<div class='ui-state-highlight ui-corner-all vcn_field' style='text-align: center;'>".$this->STR['PostulationAlreadyExist']."<div class='cleaner h10'></div>".$this->COMMON->getDateFormat($postulationDate)."</div>", "state"=>$_POST['opt']);
		    }		    
		    else
		    {
		    	$rGetVacancy 	= $this->QUERY->getVacancy("WHERE  a.id  = '$vcn'");
				$rData = $rGetVacancy->fetch();

		    	$rGetPostulationInsert = $this->QUERY->insertPostulation(
		    		array(  'id_postulant' 	=> $postulantId,
							'id_company' 	=> $rData['id_company'],
							'id_vacancy' 	=> $vcn,
							'dt_registry' 	=> $CurrentDate,
							'nm_status' 	=> $this->GLOBAL['vacancy_enable']['value']
					));	

				$postulationId = $rGetPostulationInsert->getLastInsertID(); 		    					

				

				/*if($rData['ch_confidential'] == $this->GLOBAL['confidential_YES'])
					$companyName = $rData['tx_confidential_trademark'];
				else
					$companyName = $rData['tx_trademark'];*/

			/*	$rGetVacancyStudyLevel 	= $this->QUERY->getVacancyStudyLevel("WHERE a.id_vacancy = '$vcn' GROUP BY a.id_studylevel ORDER BY b.id DESC");
				
				$studySpecs 	= null;
				while ($row = $rGetVacancyStudyLevel->fetch())
				{
					if(isset($studySpecs))
						$studySpecs 	.= ', ';

					$studySpecs 	.= $row['studylevel_tx_description'];

				}*/

				$rGetUser 	= $this->QUERY->getUser("WHERE id = '".$postulantId."' ");
				$rGetUserData = $rGetUser->fetch();

				/*$params = array(
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
										
					

					$this->COMMON->sendMail($sendTo, $bodyMessage, $params);*/

					$answer = array("answer"=>'correct', "msg"=>$this->STR['Postulate_Success'], "state"=>$_POST['opt']);
					
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
	    
}//end of class
	    $remote = new remote();
	    $option = $_POST['opt'];	    
	    switch($option)
	    {	    	    
	    	
	    	case 'getList':
	    			$remote->getList();
	    	break;

	    	case 'linkPostulantToVacancy':
	    			$remote->linkPostulantToVacancy();
	    	break;

			default:
				    die();
			break;
	    }	    
?>