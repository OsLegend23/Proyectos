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
			

			$rGetVacancy = $this->QUERY->getVacancy("WHERE a.id_company = '".$this->accountId."'");
			
			$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
			$total = $rGetVacancy->size();

			$rGetVacancy = $this->QUERY->getVacancy("WHERE a.id_company = '".$this->accountId."' GROUP BY a.id ORDER BY a.dt_update DESC LIMIT $limitINIT, $rp");

			$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

			while ($row = $rGetVacancy->fetch())
			{

					$rGetPostulation = $this->QUERY->getPostulation("WHERE a.id_vacancy = '".$row['id']."'");

					$entry = array('id'=>$row['id']
								,'cell'=>array(								
								'edit'		=>"<img src='../media/icon/_edit_min.png' style='cursor: pointer;' id='edit_".$row['id']."'>"
								,'view'		=>"<img src='../media/icon/_preview_min.png' style='cursor: pointer;' id='view_".$row['id']."'>"
								,'renew'	=>"<img src='../media/icon/_postulation.png' style='cursor: pointer;' id='renew_".$row['id']."'>"
								,'status'	=> $this->GLOBAL['vacancy_status'][$row['ch_status']]['label']
								,'date'		=> $this->COMMON->getDateFormat($row['dt_update'])
								,'name'		=> $row['tx_name']
								,'postulations'	=> $rGetPostulation->size()
							),
					);
					
				$answer['rows'][] = $entry;	

			}

			echo json_encode($answer);
	    }

	    function uploadphoto()
	    {

			include('../../inc/SimpleImage.php');
			
			define ("MAX_SIZE","1024");
			
			$image=$_FILES['image']['name'];
			
			$photoLink 	= $this->COMMON->getRoot().$this->GLOBAL['linkPhotoCompany'];
			$folder 	= $photoLink.$this->accountId;
			
			if ($image) 
			{
				    //get the original name of the file from the clients machine
					    $filename = stripslashes($_FILES['image']['name']);
				    //get the extension of the file in a lower case format
					    $extension = $this->COMMON->getExtension($filename);
					    $extension = strtolower($extension);
				    //if it is not a known extension, we will suppose it is an error and will not  upload the file,  
				    //otherwise we will do more tests
				    
				    $bExtension = false;
				    
				    foreach($this->GLOBAL['photoTypes'] as $key => $ext)				    
				    if (($extension == $ext)) 				    
						$bExtension = true;
				    
				    if(!$bExtension)
						$answer = array("answer"=>'fail', "msg"=>$this->STR['Msg_UploadImageFail_format'],"state"=>$_POST['opt']);
						
				    if($bExtension)
				    {
						//get the size of the image in bytes
						//$_FILES['image']['tmp_name'] is the temporary filename of the file
						//in which the uploaded file was stored on the server
						$size=filesize($_FILES['image']['tmp_name']);
				   
						//compare the size with the maxim size we defined and print error if bigger
						$bMaxSize = true;
						if ($size > MAX_SIZE*1024)
						{
							$answer = array("answer"=>'fail', "msg"=>$this->STR['Msg_UploadImageFail_size'],"state"=>$_POST['opt']);
							$bMaxSize = false;
						}
						
						if($bMaxSize)
						{
							    $folder = $photoLink.$this->accountId."/";

							    //we will give an unique name, for example the time in unix time format
							    $timeNow			= date('H:i:s');
							    $image_name 		= md5($this->accountId.$this->GLOBAL['token'].$timeNow);
							    $image_original 	= $image_name.'.'.$extension;
							    $image_50p			= $image_name.'_50p.'.$extension;
								$image_30p			= $image_name.'_30p.'.$extension;
							    
							    if(!file_exists($folder))							    
									mkdir($folder, 0777);
							    
							    if(file_exists($folder)){
									$handle=opendir($folder);
									while (($file = readdir($handle))!==false) {									
									@unlink($folder.'/'.$file);
									}
									closedir($handle);									
							    }
							    
							    //we verify if the image has been uploaded, and print error instead
							    $copied = copy($_FILES['image']['tmp_name'], $folder.$image_original);
							    if (!$copied) 
							    {								    
								    $answer = array("answer"=>'fail', "msg"=>$this->STR['Msg_UploadImageFail'], "state"=>$_POST['opt']);
							    }

							    if(!file_exists($folder.'/index.php'))
							    {
							    	copy($photoLink.'index_company.php', $folder.'/index.php');
							    }
							    
								$eImage = new SimpleImage();
							    $eImage->load($folder.$image_original);
								
								$eImage->resize(430,130);
								$eImage->save($folder.$image_original);

							    $eImage->resize(140,100);							    
							    $eImage->save($folder.$image_50p);
							
							    $eImage->resize(130,74);
							    $eImage->save($folder.$image_30p);
							    
							    $answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_UploadImageSuccess'], "photo"=>$image_original, "state"=>$_POST['opt']);

							    $this->QUERY->updateCompany(array('tx_image' => $image_name), "WHERE id_user ='".$this->accountId."'");

							    $_SESSION['enlaceemp_image']				= $image_name;
						}
				   }
		       }
		       else{			
				    $answer = array("answer"=>'fail', "msg"=>$this->STR['Msg_UploadImageFail'], "state"=>$_POST['opt']);
		       }
		      
			echo json_Encode($answer);
	    }

	    function renewpublication()
	    {

			$rGetCompanyPlan  = $this->QUERY->getCompany_Plan("WHERE  a.id_company = '".$this->accountId."' AND a.ch_status = '".$this->GLOBAL['plan_enable']['value']."'");
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

			$rGetCountVacancies 	= $this->QUERY->getCountVacancies("WHERE a.id_company = '".$this->accountId."' AND a.dt_registry BETWEEN '".$rDataCompanyPlan['dt_initialperiod']."' AND '".$rDataCompanyPlan['dt_periodended']."' AND a.id_type != '5' ");
			$rDataCountVacancies	= $rGetCountVacancies->fetch();

			if($rDataCountVacancies['total'] > $rDataCompanyPlan['nm_posts'])
			{
				$answer = array("answer"=>'fail', "msg"=>$this->STR['CompanyPlanMaxPostReached'].$this->GLOBAL['email_associated'], "state"=>$_POST['opt']);
				echo json_encode($answer);
				return false;
			}
				
				$rGetVacancy 	= $this->QUERY->updateVacancy(
				    		array(  				    													
									'dt_registry'					=> $this->STR['CurrentDate']
									,'tx_hour'						=> $this->STR['CurrentHour']
									,'dt_update'					=> $this->STR['CurrentDate']
									,'ch_status'					=> $this->GLOBAL['vacancy_enable']['value']
						),"WHERE id = '".$_POST['selectedRowID']."'"
				);

				$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_Renew_Success'], "state"=>$_POST['opt']);

				echo json_Encode($answer);
	    }

	    
	    

}//end of class
	    $remote = new remote();
	    $option = $_POST['opt'];	    
	    switch($option)
	    {	    	    
	    	case "getList":
				$remote->getList();
	    	break;

	    	case "uploadphoto":
	    		$remote->uploadphoto();
	    	break;

	    	case "renewpublication":
	    		$remote->renewpublication();
	    	break;

	    	

			default:
				 die();
			break;
	    
	    }
	    
	    
?>