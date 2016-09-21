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

			$rGetPostulant_Language = $this->QUERY->getPostulant_language("WHERE a.id_postulant = '".$this->accountId."'");
			
			$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
			$total = $rGetPostulant_Language->size();

			$rGetPostulant_Language = $this->QUERY->getPostulant_language("WHERE a.id_postulant = '".$this->accountId."'  ORDER BY a.id DESC LIMIT $limitINIT, $rp");

			$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

			while ($row = $rGetPostulant_Language->fetch())
			{
				$entry = array('id'=>$row['id']
								,'cell'=>array(								
								'edit'			=>"<img src='../media/icon/_edit_min.png' style='cursor: pointer;' id='edit_".$row['id']."'>"
								,'delete'		=>"<img src='../media/icon/_delete_min.png' style='cursor: pointer;' id='delete_".$row['id']."'>"								
								,'language'		=>$row['language_tx_description']
								,'speak'		=>$row['nm_speak'].' %'
								,'write'		=>$row['nm_write'].' %'
								,'read'			=>$row['nm_read'].' %'								
							),
					);

				



					
				$answer['rows'][] = $entry;	
			}

			echo json_encode($answer);
	    }

	    function getRecordInfo()
	    {
	    	$rGetPostulant_Language = $this->QUERY->getPostulant_language("WHERE  a.id_postulant = '".$this->accountId."'  AND a.id = '".$_POST['selectedRowID']."'");

	    	while ($row = $rGetPostulant_Language->fetch())
			{
				$answer  = array(		
								'id'				=>$row['id']
								,'language'			=>$row['nm_language']
								,'speak'			=>$row['nm_speak']
								,'write'			=>$row['nm_write']
								,'read'				=>$row['nm_read']
								,'state'			=>$_POST['opt']
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


	    	$rGetPostulant_Language = $this->QUERY->getPostulant_language("WHERE  a.id_postulant = '".$this->accountId."'");

	    	if($rGetPostulant_Language->size() >= $this->GLOBAL['postulant_MaxLanguages'])
				    $answer = array("answer"=>'fail', "msg"=>$this->STR['Msg_MaxRegistry'].' '.$this->GLOBAL['postulant_MaxLanguages'], "state"=>$_POST['opt']);


			if(!isset($answer))
			{
				$rGetPostulant_Language 	= $this->QUERY->insertPostulant_Language(
				    		array(  'id_postulant' 		=> $this->accountId									
									,'nm_language' 		=> $aParams['Language']
									,'nm_speak' 		=> $aParams['SpeakDomain']
									,'nm_write' 		=> $aParams['WriteDomain']
									,'nm_read' 			=> $aParams['ReadDomain']
						));

				if(isset($aParams['TOEFLScore']) && $aParams['TOEFLScore'] > 0)
				{
					$rGetPostulant 	= $this->QUERY->updatePostulant(
				    		array(  'nm_toeflscore' 		=> $aParams['TOEFLScore'] )
				    		, "WHERE  id_user = '".$this->accountId."'"
				    		);

				}

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
				$rGetPostulant_Language 	= $this->QUERY->updatePostulant_Language(
				    		array(  'nm_language' 		=> $aParams['Language']
									,'nm_speak' 		=> $aParams['SpeakDomain']
									,'nm_write' 		=> $aParams['WriteDomain']
									,'nm_read' 			=> $aParams['ReadDomain']
						), 
								"WHERE id_postulant ='".$this->accountId."' AND id = '".$_POST['selectedRowID']."'"
						);


				if(isset($aParams['TOEFLScore']) && $aParams['TOEFLScore'] > 0)
				{
					$rGetPostulant 	= $this->QUERY->updatePostulant(
				    		array(  'nm_toeflscore' 		=> $aParams['TOEFLScore'] )
				    		, "WHERE  id_user = '".$this->accountId."'"
				    		);

				}

				$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_Update_Success'], "state"=>$_POST['opt']);

			}

			echo json_Encode($answer);
	    }


	     function delete()
	    {
				$rGetPostulant_Language 	= $this->QUERY->deletePostulant_Language("WHERE id_postulant ='".$this->accountId."' AND id = '".$_POST['selectedRowID']."'");

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