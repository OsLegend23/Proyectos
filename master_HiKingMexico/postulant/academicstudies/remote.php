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
			
			if($_SESSION['enlaceemp_accounttype'] == $this->GLOBAL['user_administrator']['value'])
			{
				$this->accountId 		= 	isset($_SESSION['enlaceemp_userid'])? $_SESSION['enlaceemp_userid']:null;	
			}
			
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
			

			$rGetPostulant_studies = $this->QUERY->getPostulant_studies("WHERE a.id_postulant = '".$this->accountId."'");
			
			$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
			$total = $rGetPostulant_studies->size();

			$rGetPostulant_studies = $this->QUERY->getPostulant_studies("WHERE a.id_postulant = '".$this->accountId."' ORDER BY a.id DESC LIMIT $limitINIT, $rp");

			$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

			while ($row = $rGetPostulant_studies->fetch())
			{

				$area = $row['id_studylevel']<=3? $row['studyarea_tx_description']:$row['tx_graduate'];

				if(!isset($area))
				{
					$area = '---';
				}				

				if(!isset($row['ch_status']) || !isset($row['dt_startdateyear']) || !isset($row['dt_enddateyear']))
				{
					$status = '---';
					$period = '---';
				}
				else
				{
					$status = $this->STR['StatusStudies'][$row['ch_status']];

					if($row['ch_status'] == 'C')
						$period = $this->STR['ActualStudy'];
					else
						$period = $this->monthFull[$row['dt_startdatemonth']].' '.$this->STR['From'].' '.$row['dt_startdateyear'].' '.$this->STR['Until'].' '.$this->monthFull[$row['dt_enddatemonth']].' '.$this->STR['From'].' '.$row['dt_enddateyear'];
				}
				$entry = array('id'=>$row['id'],
								'cell'=>array(								
								'edit'		=>"<img src='../media/icon/_edit_min.png' style='cursor: pointer;' id='edit_".$row['id']."'>",
								'delete'	=>"<img src='../media/icon/_delete_min.png' style='cursor: pointer;' id='delete_".$row['id']."'>",
								'instname'	=>$row['tx_institution'],
								'level'		=>$row['studylevel_tx_description'],
								'area'		=>$area,
								'status'	=>$status,
								'period'	=>$period
							),
					);
					
				$answer['rows'][] = $entry;	

			}

			echo json_encode($answer);
	    }

	    function getRecordInfo()
	    {
	    	$rGetPostulant_studies = $this->QUERY->getPostulant_studies("WHERE  a.id_postulant = '".$this->accountId."'  AND a.id = '".$_POST['selectedRowID']."'");

	    	while ($row = $rGetPostulant_studies->fetch())
			{
				$answer  = array(		
								'id'					=>$row['id']
								,'studylevel'			=>$row['id_studylevel']
								,'studyarea'			=>$row['id_studylevel']<=3? $row['id_studyarea']:$row['tx_graduate']//$row['id_studyarea']
								,'status'				=>$row['ch_status']
								,'institution'			=>$row['tx_institution']
								,'startdatemonth'		=>$row['dt_startdatemonth']
								,'startdateyear'		=>$row['dt_startdateyear']
								,'enddatemonth'			=>$row['dt_enddatemonth']
								,'enddateyear'			=>$row['dt_enddateyear']
								,'average'				=>$row['tx_average']
								,'comment'				=>$row['tx_comment']
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


	    	$rGetPostulant_Studies = $this->QUERY->getPostulant_studies("WHERE  a.id_postulant = '".$this->accountId."'");

	    	if($rGetPostulant_Studies->size() >= $this->GLOBAL['postulant_MaxStudies'])
				    $answer = array("answer"=>'fail', "msg"=>$this->STR['Msg_MaxRegistry'].' '.$this->GLOBAL['postulant_MaxStudies'], "state"=>$_POST['opt']);


			if(!isset($answer))
			{
				$rGetPostulant_Studies 	= $this->QUERY->insertPostulant_Studies(
				    		array(  'id_postulant' 			=> $this->accountId									
									,'id_studylevel'		=>	$aParams['StudyLevel']
									,'id_studyarea'			=>	$aParams['StudyArea']
									,'tx_graduate'			=>	$aParams['Graduate']
									,'ch_status'			=>	$aParams['ActualStatus']
									,'tx_institution'		=>	$aParams['InstituteName']
									,'dt_startdatemonth'	=>	$aParams['DateInstrMonth']
									,'dt_startdateyear'		=>	$aParams['DateInstrYear']
									,'dt_enddatemonth'		=>	$aParams['DateOutstrMonth']
									,'dt_enddateyear'		=>	$aParams['DateOutstrYear']
									,'tx_average'			=>	$aParams['ClasificationAVG']
									,'tx_comment'			=>	$aParams['Comment']

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
				$rGetPostulant_Studies 	= $this->QUERY->updatePostulant_Studies(
				    		array(  'id_studylevel'			=>	$aParams['StudyLevel']
									,'id_studyarea'			=>	$aParams['StudyArea']
									,'tx_graduate'			=>	$aParams['Graduate']
									,'ch_status'			=>	$aParams['ActualStatus']
									,'tx_institution'		=>	$aParams['InstituteName']
									,'dt_startdatemonth'	=>	$aParams['DateInstrMonth']
									,'dt_startdateyear'		=>	$aParams['DateInstrYear']
									,'dt_enddatemonth'		=>	$aParams['DateOutstrMonth']
									,'dt_enddateyear'		=>	$aParams['DateOutstrYear']
									,'tx_average'			=>	$aParams['ClasificationAVG']
									,'tx_comment'			=>	$aParams['Comment']
						), 
								"WHERE id_postulant ='".$this->accountId."' AND id = '".$_POST['selectedRowID']."'"
						);



				$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_Update_Success'], "state"=>$_POST['opt']);

			}

			echo json_Encode($answer);
	    }


	     function delete()
	    {
				$rGetPostulant_Studies 	= $this->QUERY->deletePostulant_Studies("WHERE id_postulant ='".$this->accountId."' AND id = '".$_POST['selectedRowID']."'");

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

			case 'getRecordInfo':
				$remote->getRecordInfo();
			break;

			case 'save':
				$remote->save();
			break;

			case 'update':
				$remote->update();
			break;

			case 'delete':
				$remote->delete();
			break;

			default:
				    die();
			break;
	    
	    }
	    
?>