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
			$this->accountId 			= 	isset($_SESSION['enlaceemp_accountid'])? $_SESSION['enlaceemp_accountid']:null;

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

			$rGetInterviewDate = $this->QUERY->getInterviewDate("WHERE a.id_company = '".$this->accountId."'");
			
			$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
			$total = $rGetInterviewDate->size();

			$rGetInterviewDate = $this->QUERY->getInterviewDate(" WHERE a.id_company = '".$this->accountId."' ORDER BY a.id DESC LIMIT $limitINIT, $rp");

			$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

			while ($row = $rGetInterviewDate->fetch())
			{

				$entry = array('id'=>$row['id']
								,'cell'=>array(								
								'preview'			=>"<img src='../media/icon/_preview_min.png' style='cursor: pointer;' id='preview_".$row['id']."'>"
								,'edit'				=>"<img src='../media/icon/_edit_min.png' style='cursor: pointer;' id='edit_".$row['id']."'>"
								,'delete'		=>"<img src='../media/icon/_delete_min.png' style='cursor: pointer;' id='delete_".$row['id']."'>"
								,'status'			=>$this->GLOBAL['interview_status'][$row['ch_status']]['label']
								,'date'				=>$this->COMMON->getDateFormat($row['dt_registry'])
								,'period'			=>$this->STR['DateIn'].' '.$this->COMMON->getDateFormat($row['dt_start']).'</br>'.$this->STR['DateOut'].' '.$this->COMMON->getDateFormat($row['dt_end'])
								,'name'				=>$row['tx_vacancyname']
								,'postulations'		=>$row['tx_description']								
							),
					);
					
				$answer['rows'][] = $entry;	
			}

			echo json_encode($answer);
	    }	    

	    function getRecordInfo()
	    {
	    	$getInterviewDate = $this->QUERY->getInterviewDate("WHERE a.id = '".$_POST['selectedRowID']."' AND a.id_company = '".$this->accountId."' ");

	    	while ($row = $getInterviewDate->fetch())
			{
				$answer  = array(		
								'vacancyname'			=>$row['tx_vacancyname']
								,'start'				=>$row['dt_start']
								,'end'					=>$row['dt_end']
								,'vacancy'				=>$row['id_vacancy']
								,'status'				=>$row['ch_status']								
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

	    		$rGetInterviewDate = $this->QUERY->getInterviewDate(" WHERE a.id_company = '".$this->accountId."' AND a.id_vacancy = '".$aParams['Vacancy']."' AND a.id_vacancy != '-1' ");

			    if($rGetInterviewDate->size() > 0)
			    {
			    	$answer = array("answer"=>'fail', "msg"=>$this->STR['VacancyForInterviewDateExist'], "state"=>$_POST['opt']);
			    	echo json_Encode($answer);
			    	return;
			    }		

				$getInterviewDate 	= $this->QUERY->insertInterviewDate(
				    		array(
								'id_company'		=> $this->accountId
								,'tx_vacancyname'	=> $aParams['VacancyName']
								,'dt_registry'		=> $this->STR['CurrentDate']
								,'dt_start'			=> $aParams['DateIn']
								,'dt_end'			=> $aParams['DateOut']
								,'id_vacancy'		=> $aParams['Vacancy']
								,'tx_comment'		=> ''
								,'ch_status'		=> $this->GLOBAL['interview_enable']['value']
						));

				$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_Insert_Success'], "state"=>$_POST['opt']);




			echo json_Encode($answer);	

	    }

	    function update()
	    {
			$aParams 			= array();

	    	foreach ($_POST as $key => $value)
	    		if($key !='opt')
	    			$aParams[$key] = $this->COMMON->getEscapeString($value);

	    	$rGetInterviewDate = $this->QUERY->getInterviewDate(" WHERE a.id_company = '".$this->accountId."' 
	    						AND a.id_vacancy = '".$aParams['Vacancy']."' AND a.id_vacancy != '-1' 
								AND a.id_vacancy != '".$_POST['selectedRowID']."'
	    						");

		    if($rGetInterviewDate->size() > 0)
		    {
		    	$answer = array("answer"=>'fail', "msg"=>$this->STR['VacancyForInterviewDateExist'], "state"=>$_POST['opt']);
		    	echo json_Encode($answer);
		    	return;
		    }	

			
				$getInterviewDate 	= $this->QUERY->updateInterviewDate(
				    		array(  
								'tx_vacancyname'	=> $aParams['VacancyName']
								,'dt_registry'		=> $this->STR['CurrentDate']
								,'dt_start'			=> $aParams['DateIn']
								,'dt_end'			=> $aParams['DateOut']
								,'id_vacancy'		=> $aParams['Vacancy']
								,'tx_comment'		=> $aParams['Comment']
								,'ch_status'		=> $this->GLOBAL['interview_enable']['value']
						), 
								"WHERE id = '".$_POST['selectedRowID']."'"
						);

				$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_Update_Success'], "state"=>$_POST['opt']);
			

			echo json_Encode($answer);
	    }


	     function delete()
	    {
			$getInterviewDate 	= $this->QUERY->deleteInterviewDate("WHERE id = '".$_POST['selectedRowID']."' AND a.id_company = '".$this->accountId."' ");

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