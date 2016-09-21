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

			$rGetPostulant_Experience = $this->QUERY->getPostulant_experience("WHERE a.id_postulant = '".$this->accountId."'");
			
			$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
			$total = $rGetPostulant_Experience->size();

			$rGetPostulant_Experience = $this->QUERY->getPostulant_experience("WHERE a.id_postulant = '".$this->accountId."'  ORDER BY a.id DESC LIMIT $limitINIT, $rp");

			$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

			while ($row = $rGetPostulant_Experience->fetch())
			{

				if(!isset($row['ch_isactualwork']) || !isset($row['dt_startdatemonth']) || !isset($row['dt_enddatemonth']))
				{
					
					$laborTime = '---';
				}
				else
				{					

					if($row['ch_isactualwork'] == 'S')
						$laborTime = $this->STR['ActualWork'];
					else
						$laborTime = $this->monthFull[$row['dt_startdatemonth']].' '.$this->STR['From'].' '.$row['dt_startdateyear'].' '.$this->STR['Until'].' '.$this->monthFull[$row['dt_enddatemonth']].' '.$this->STR['From'].' '.$row['dt_enddateyear'];
				}

				$entry = array('id'=>$row['id']
								,'cell'=>array(								
								'edit'				=>"<img src='../media/icon/_edit_min.png' style='cursor: pointer;' id='edit_".$row['id']."'>"
								,'delete'			=>"<img src='../media/icon/_delete_min.png' style='cursor: pointer;' id='delete_".$row['id']."'>"								
								,'companyname'		=>$row['tx_tradename']
								/*,'sector'			=>isset($row['worksector_tx_description'])? $row['worksector_tx_description']:"---"
								,'activity'			=>isset($row['workactivity_tx_description'])? $row['workactivity_tx_description']:"---"*/
								,'workarea'			=>isset($row['workarea_tx_description'])? $row['workarea_tx_description']:"---"
								,'labortime'		=>$laborTime																
							),
					);

					
				$answer['rows'][] = $entry;	
			}

			echo json_encode($answer);
	    }

	    function getRecordInfo()
	    {
	    	$rGetPostulant_Experience = $this->QUERY->getPostulant_experience("WHERE  a.id_postulant = '".$this->accountId."'  AND a.id = '".$_POST['selectedRowID']."'");

	    	while ($row = $rGetPostulant_Experience->fetch())
			{
				$answer  = array(		
								'id'					=> $row['id']
								,'TradeName'			=> $row['tx_tradename'] == $this->STR['NotSpecificated']? "":$row['tx_tradename']								
								,'Salary'				=> $row['tx_salary']
								,'WorkArea'				=> $row['id_workarea']
								,'JobTitle'				=> $row['tx_jobtitle']
								,'HierarchyLevel'		=> $row['id_hierarchy']
								,'ActualWork'			=> $row['ch_isactualwork']
								,'DateInstrMonth'		=> $row['dt_startdatemonth']
								,'DateInstrYear'		=> $row['dt_startdateyear']
								,'DateOutstrMonth'		=> $row['dt_enddatemonth']
								,'DateOutstrYear'		=> $row['dt_enddateyear']
								,'ActivityDetail'		=> $row['tx_activitydetail']
								,'state'				=> $_POST['opt']
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


	    	$rGetPostulant_Experience = $this->QUERY->getPostulant_experience("WHERE  a.id_postulant = '".$this->accountId."'");

	    	if($rGetPostulant_Experience->size() >= $this->GLOBAL['postulant_MaxLanguages'])
				    $answer = array("answer"=>'fail', "msg"=>$this->STR['Msg_MaxRegistry'].' '.$this->GLOBAL['postulant_MaxLanguages'], "state"=>$_POST['opt']);

			if(strlen($aParams['ActivityDetail']) <= 0)
					$answer = array("answer"=>'fail', "msg"=>$this->STR['ActivityDescribed'], "state"=>$_POST['opt']);

			if(!isset($answer))
			{
				$rGetPostulant_Experience 	= $this->QUERY->insertPostulant_Experience(
				    		array(  'id_postulant' 			=> $this->accountId
									,'tx_tradename'			=> $aParams['TradeName']
									,'tx_salary'			=> $aParams['Salary']
									,'id_workarea'			=> $aParams['WorkArea']
									,'tx_jobtitle'			=> $aParams['JobTitle']
									,'id_hierarchy'			=> $aParams['HierarchyLevel']
									,'ch_isactualwork'		=> $aParams['ActualWork']
									,'dt_startdatemonth'	=> $aParams['DateInstrMonth']
									,'dt_startdateyear'		=> $aParams['DateInstrYear']
									,'dt_enddatemonth'		=> $aParams['DateOutstrMonth']
									,'dt_enddateyear'		=> $aParams['DateOutstrYear']
									,'tx_activitydetail'	=> $aParams['ActivityDetail']
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

	    	if(strlen($aParams['ActivityDetail']) <= 0)
					$answer = array("answer"=>'fail', "msg"=>$this->STR['ActivityDescribed'], "state"=>$_POST['opt']);

			if(!isset($answer))
			{
				$rGetPostulant_Experience 	= $this->QUERY->updatePostulant_Experience(
				    		array(  'tx_tradename'			=> $aParams['TradeName']
									,'tx_salary'			=> $aParams['Salary']
									,'id_workarea'			=> $aParams['WorkArea']
									,'tx_jobtitle'			=> $aParams['JobTitle']
									,'id_hierarchy'			=> $aParams['HierarchyLevel']
									,'ch_isactualwork'		=> $aParams['ActualWork']
									,'dt_startdatemonth'	=> $aParams['DateInstrMonth']
									,'dt_startdateyear'		=> $aParams['DateInstrYear']
									,'dt_enddatemonth'		=> $aParams['DateOutstrMonth']
									,'dt_enddateyear'		=> $aParams['DateOutstrYear']
									,'tx_activitydetail'	=> $aParams['ActivityDetail']
						), 
								"WHERE id_postulant ='".$this->accountId."' AND id = '".$_POST['selectedRowID']."'"
						);

				$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_Update_Success'], "state"=>$_POST['opt']);

			}

			echo json_Encode($answer);
	    }


	     function delete()
	    {
				$rGetPostulant_Experience 	= $this->QUERY->deletePostulant_Experience("WHERE id_postulant ='".$this->accountId."' AND id = '".$_POST['selectedRowID']."'");

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