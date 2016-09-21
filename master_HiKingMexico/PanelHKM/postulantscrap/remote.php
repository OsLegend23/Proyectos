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
			
			$keyword 	= isset($_POST['keyword']) ? $_POST['keyword'] : null;
			$consult 	= isset($_POST['consult']) ? $_POST['consult'] : 'poorInfo';
			
			$condition = "WHERE a.nm_type = '".$this->GLOBAL['user_postulant']['value']."' ";

			if( !empty($keyword) )
				$condition .=" AND (a.tx_email LIKE '%$keyword%' || a.tx_name LIKE '%$keyword%' || a.tx_surname LIKE '%keyword%' ) ";

			if( $consult == 'pendingToDelete')
				$condition .=" AND  b.id_postulant = a.id AND b.ch_status = 'A'";

			if( $consult == 'pendingToDelete')
				$condition .= "GROUP BY a.id ORDER BY remainingdays ASC";
			else
				$condition .= "GROUP BY a.id ORDER BY a.id DESC";

			$rGetUser = $this->QUERY->searchPostulant_Scrap($condition);
			
			$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
			$total = $rGetUser->size();

			$condition .= " LIMIT $limitINIT, $rp";

			$rGetUser = $this->QUERY->searchPostulant_Scrap($condition);

			$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

			$totalCorrect = 0;

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

				
				$postulantAve = $this->getPostulantAverage($row['id']);
				

				if( ($postulantAve['aveAccountData'] < 100 || $postulantAve['aveJobExperience'] < 100 || $postulantAve['aveAcademic'] < 100) )
				{


					if(!empty($row['dt_notification']))
					{
						$days 	= 	$row['remainingdays'];
						$status = 	$this->COMMON->str_replace( $this->STR['PostulantScrap_remainingdays'], array('{days}'=>$days) );						
					}
					else
					{
						$status = 	$this->STR['ScrapCandidate'];
					}

					if( $consult == 'poorInfo' && !empty($row['dt_notification']))
					{
						//Nothing to do
					}
					else
					{
							
						$entry = array('id'=>$row['id']
									,'cell'=>array(
									'sendNotification'		=> "<img src='../media/icon/_notification.png' style='cursor: pointer;' id='notification_".$row['id']."'>"
									,'delete'				=>"<img src='../media/icon/_delete_min.png' style='cursor: pointer;' id='delete_".$row['id']."'>"
									,'viewcv'				=> "<img src='../media/icon/_viewcv_min.png' style='cursor: pointer;' id='viewcv_".$row['id']."'>"
									,'downloadcv'			=> $downloadCV
									,'date'					=> $this->COMMON->getDateFormat($row['dt_registry'])
									,'postulantname'		=> $this->COMMON->getUcwords($row['tx_name'].' '.$row['tx_surname']).'</br>'.$row['tx_email']
									
									,'email'				=> $this->STR['AccountData'].' '.$postulantAve['aveAccountData'].$this->STR['aveCompleted'].'</br>'.
																$this->STR['Academic'].' '.$postulantAve['aveAcademic'].$this->STR['aveCompleted'].'</br>'.
																$this->STR['Laborexperience'].' '.$postulantAve['aveJobExperience'].$this->STR['aveCompleted'].'</br>'

									,'status'				=> $status
								),
						);

						$totalCorrect++;

						$answer['rows'][] = $entry;	
					}
				}

				
			}
			$answer['total'] = $totalCorrect;
			echo json_encode($answer);
	    }

	    function getPostulantAverage($postulantId)
	    {
	    	$average = array();

	    	/***************************************/
					$rGetPostulant = $this->QUERY->getPostulant("WHERE a.id_user = '".$postulantId."'");
			    	$rDataPostulant = $rGetPostulant->fetch();

			    	$AccountData = count($rDataPostulant) - 6;

			    	foreach ($rDataPostulant as $key => $value) 
			    	{
			    		if(!isset($value) || $value == -1 || $value == '')
			    		{
			    			if($key!='nm_toeflscore' && $key!='tx_rfc' && $key!='id'  && $key!='id_user' && $key!='tx_image' && $key!='ch_firstjob')
			    				$AccountData --;
			    		}
			    			
			    	}
			    	$average['aveAccountData'] = number_format(( $AccountData / (count($rDataPostulant) - 6)) * 100, 0);

				/***************************************/
					$rGetPostulant_studies = $this->QUERY->getPostulant_studies("WHERE a.id_postulant = '".$postulantId."' ORDER BY a.id DESC");
			    	$rDataPostulant_studies = $rGetPostulant_studies->fetch();


					if($rGetPostulant_studies->size() <= 0)
			    		$average['aveAcademic'] = 0;
			    	else
			    	{
				    	$Academic = (count($rDataPostulant_studies) - 5);

				    	foreach ($rDataPostulant_studies as $key => $value) 
				    	{
				    		if(!isset($value) || $value == -1 || $value == '')
				    		{
				    			
				    			if($key!='tx_average' && $key!='tx_comment' && $key!='id'  && $key!='id_postulant' && $key != 'tx_graduate')
				    			{
				    					$Academic--;
				    			}
				    		}	    			
				    	}
							$average['aveAcademic'] = number_format(($Academic / (count($rDataPostulant_studies) - 5)) * 100, 0);
					}
				/***************************************/

					$rGetPostulant_experience = $this->QUERY->getPostulant_experience("WHERE a.id_postulant = '".$postulantId."' ORDER BY a.id DESC");
			    	$rDataPostulant_experience = $rGetPostulant_experience->fetch();

					if($rGetPostulant_experience->size() <= 0)			
			    		$average['aveJobExperience'] = 0;
			    	else
			    	{
				    	$JobExperience = (count($rDataPostulant_experience) - 2);

				    	foreach ($rDataPostulant_experience as $key => $value) 
				    	{
				    		if(!isset($value) || $value == -1 || $value == '')
				    		{
				    			if($key!='id'  && $key!='id_postulant')
				    				$JobExperience--;
				    		}	    			
				    	}

						$average['aveJobExperience'] = number_format(($JobExperience / (count($rDataPostulant_experience) - 2)) * 100, 0);
					}

					/***************************************/

			$rGetPostulant_informatic = $this->QUERY->getPostulant_informatic("WHERE a.id_postulant = '".$postulantId."' ORDER BY a.id DESC");
	    	$rDataPostulant_informatic = $rGetPostulant_informatic->fetch();


			if($rGetPostulant_informatic->size() <= 0)			
	    		$average['aveInformatic'] = 0;	    	
	    	else
	    	{
		    	$Informatic = (count($rDataPostulant_informatic) - 3);

		    	foreach ($rDataPostulant_informatic as $key => $value) 
		    	{
		    		if(!isset($value) || $value == -1 || $value == '')
		    		{
		    			if($key!='tx_description' && $key!='id'  && $key!='id_postulant')
		    				$Informatic--;
		    		}	    			
		    	}

				$average['aveInformatic'] = number_format(($Informatic / (count($rDataPostulant_informatic) - 3)) * 100, 0);
			}

			/***************************************/

			$rGetPostulant_knowledge = $this->QUERY->getPostulant_knowledge("WHERE a.id_postulant = '".$postulantId."' ORDER BY a.id DESC");
	    	$rDataPostulant_knowledge = $rGetPostulant_knowledge->fetch();


			if($rGetPostulant_knowledge->size() <= 0)			
	    		$average['aveKnowledge'] = 0;	    	
	    	else
	    	{
		    	$Knowledge = (count($rDataPostulant_knowledge) - 2);

		    	foreach ($rDataPostulant_knowledge as $key => $value) 
		    	{
		    		if(!isset($value) || $value == -1 || $value == '')
		    		{
		    			if($key!='id'  && $key!='id_postulant')
		    				$Knowledge--;
		    		}	    			
		    	}

				$average['aveKnowledge'] = number_format(($Knowledge / (count($rDataPostulant_knowledge) - 2)) * 100, 0);
			}

			/***************************************/

			$rGetPostulant_language = $this->QUERY->getPostulant_language("WHERE a.id_postulant = '".$postulantId."' ORDER BY a.id DESC");
	    	$rDataPostulant_language = $rGetPostulant_language->fetch();

			if($rGetPostulant_language->size() <= 0)			
	    		$average['aveLanguages'] = 0;	    	
	    	else
	    	{
		    	$language = (count($rDataPostulant_language) - 2);

		    	foreach ($rDataPostulant_language as $key => $value) 
		    	{
		    		if(!isset($value) || $value == -1 || $value == '')
		    		{
		    			if($key!='id'  && $key!='id_postulant')
		    				$language--;
		    		}	    			
		    	}

				$average['aveLanguages'] = number_format(($language / (count($rDataPostulant_language) - 2)) * 100, 0);
			}

			/***************************************/
			$rGetPostulant_expectative = $this->QUERY->getPostulant_expectative("WHERE a.id_postulant = '".$postulantId."' ORDER BY a.id DESC");
	    	$rDataPostulant_expectative = $rGetPostulant_expectative->fetch();

			if($rGetPostulant_expectative->size() <= 0)			
	    		$average['aveExpectatives'] = 0;	    	
	    	else
	    	{
		    	$Expectative = (count($rDataPostulant_expectative) - 3);

		    	foreach ($rDataPostulant_expectative as $key => $value) 
		    	{
		    		if(!isset($value) || $value == -1 || $value == '')
		    		{
		    			if($key != 'id'  && $key != 'id_postulant' && $key != 'tx_comment')
		    				$Expectative--;
		    		}	    			
		    	}

				$average['aveExpectatives'] = number_format(($Expectative / (count($rDataPostulant_expectative) - 3)) * 100, 0);
			}
			/***************************************/

			return $average;
	    }

	    function sendNotification()
	    {
    		$rGetUser	= $this->QUERY->getUser("WHERE a.id = '".$_POST['selectedRowID']."'");
    		$rDataUser	= $rGetUser->fetch();

			$rGetPostulant_Scrap	= $this->QUERY->getPostulant_Scrap("WHERE a.id_postulant = '".$_POST['selectedRowID']."'");

			$postulantAve = $this->getPostulantAverage($_POST['selectedRowID']);

			if($rGetPostulant_Scrap->size() == 0)
    		{
    			$rGetPostulant_Scrap 	= $this->QUERY->insertPostulant_Scrap(
    					    		array(  'id_postulant' 			=> $_POST['selectedRowID']
    										,'dt_notification' 		=> $this->STR['CurrentDate']
    										,'ch_status' 			=> 'A'												
    			));
    		}
    		else
    		{
    			$rGetPostulant_Scrap 	= $this->QUERY->updatePostulant_Scrap(
    					    		array(  
    										'dt_notification' 		=> $this->STR['CurrentDate']
    										,'ch_status' 			=> 'A'												
    					), "WHERE a.id_postulant = '".$_POST['selectedRowID']."' "
    			);
    		}
			
			$params = array(
				'{logoLink}'				=> '<img src="'.$this->GLOBAL['domain-root'].'media/image/logoHikingMexico.png">'				
				,'{userName}'				=> $rDataUser['tx_name'].' '.$rDataUser['tx_surname']
				,'{aveAccountData}'			=> $postulantAve['aveAccountData']
				,'{aveAcademic}'			=> $postulantAve['aveAcademic']
				,'{aveJobExperience}'		=> $postulantAve['aveJobExperience']
				,'{aveInformatic}'			=> $postulantAve['aveInformatic']
				,'{aveKnowledge}'			=> $postulantAve['aveKnowledge']
				,'{aveLanguages}'			=> $postulantAve['aveLanguages']
				,'{aveExpectatives}'		=> $postulantAve['aveExpectatives']
				,'{jobEmail}'				=> $this->GLOBAL['email_job']
				,'{linkSupport}'			=> $this->GLOBAL['domain-root'].'support/?postulant'
				);

			$subject 			= $this->GLOBAL['site'].', '.$this->STR['ScrapNotification_Subject'];
			$sendTo 			= $arrayName = array('from' => $this->GLOBAL['email_job'], 'to' => $rDataUser['tx_email'], 'subject' => $subject, 'charset' => 'utf-8');
			$bodyMessage 		= $this->COMMON->str_replace($this->STR['ScrapNotification'], $params);	

			$answer = array("answer"=>'correct', "msg"=>$this->STR['NotificationSended'], "state"=>$_POST['opt']);

			$this->COMMON->sendMail($sendTo, $bodyMessage, $params);
			
			echo json_encode($answer);
	    }

	    function deletePostulant()
	    {			
			$this->QUERY->updateUser(array('nm_status' => $this->GLOBAL['user_blocked']['value']), "WHERE id ='".$_POST['selectedRowID']."'");
			$this->QUERY->updatePostulant_Scrap(array('ch_status' => 'F'), "WHERE id_postulant ='".$_POST['selectedRowID']."'");

			$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_Delete_Success'], "state"=>$_POST['opt']);

			echo json_Encode($answer);	
	    }	    
}
	    $remote = new remote();
	    $option = $_POST['opt'];	    
	    switch($option)
	    {	    	    
	    	
	    	case 'getList':
	    			$remote->getList();
	    	break;

	    	case 'sendNotification':
	    			$remote->sendNotification();
	    	break;

	    	case 'deletePostulant':
	    			$remote->deletePostulant();
	    	break;

			default:
				    die();
			break;
	    }	    
?>