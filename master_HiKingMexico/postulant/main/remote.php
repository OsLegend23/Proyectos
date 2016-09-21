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
	    	$page 			= isset($_POST['page']) ? $_POST['page'] : 1;
			$rp 			= isset($_POST['rp']) ? $_POST['rp'] : 10;
			$sortname 		= isset($_POST['sortname']) ? $_POST['sortname'] : 'name';
			$sortorder 		= isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';

			$rGetExperience 	= $this->QUERY->getPostulant_experience("WHERE a.id_postulant = '".$this->accountId."'");
			$rGetExpectative 	= $this->QUERY->getPostulant_expectative_towork("WHERE a.id_postulant = '".$this->accountId."'");
			$rGetStudies 		= $this->QUERY->getPostulant_studies("WHERE a.id_postulant = '".$this->accountId."'");
			
				
				
				$condition = "WHERE a.ch_status = '".$this->GLOBAL['vacancy_enable']['value']."' AND k.nm_status = '".$this->GLOBAL['user_enable']['value']."' ";

				$sGetExperience = "";
				$sGetExpectative = "";
				$sGetStudies = "";

				$akin = "";

				while ($row = $rGetExperience->fetch())
				{
					if(!empty($sGetExperience))
						$sGetExperience .= " OR ";

					$sGetExperience .= " a.id_workarea = ".$row['id_workarea'];
				}

				if( $rGetExperience->size() > 0 )
				{
					$condition .= ' AND ('.$sGetExperience.' )';
				}


				while ($row = $rGetExpectative->fetch())
				{
					if(!empty($sGetExpectative))
						$sGetExpectative .= " OR ";

					$sGetExpectative .= " a.id_workarea = ".$row['id_workarea'];
				}

				if($rGetExpectative->size() > 0)
				{
					if( $rGetExperience->size() > 0 )
						$condition .= ' OR ';
					else
						$condition .= ' AND ';

						$condition .= ' ('.$sGetExperience.' )';
				}

				while ($row = $rGetStudies->fetch())
				{
					if(!empty($sGetStudies))
						$sGetStudies .= " OR ";

					$sGetStudies .= " l.tx_studyarea = ".$row['id_studyarea'];
				}

				if($rGetStudies->size() > 0)
				{
					if( $rGetExperience->size() > 0  || $rGetExpectative->size() > 0)
						$condition .= ' OR ';
					else
						$condition .= ' AND ';

						$condition .= ' ('.$sGetStudies.' )';

				}

				$condition .= "GROUP BY a.id ORDER BY a.id DESC ";
				
				$rGetVacancy = $this->QUERY->getVacancy($condition);


				$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
				$total = $rGetVacancy->size();

				$condition .= " LIMIT $limitINIT, $rp ";

				$rGetVacancy = $this->QUERY->getVacancy($condition);

				$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

				while ($row = $rGetVacancy->fetch())
				{					
					
					$entry = array('id'=>$row['id']
								,'cell'=>array(																
								'postulation'		=>"<img src='../media/icon/_postulation.png' style='cursor: pointer;' id='postulation_".$row['id']."'>"								
								,'date'		=> $row['dt_registry']								
								,'name'		=> $row['tx_name']	
								,'type'		=> $row['vacancy_type_tx_description']	
															
							),
					);

					$answer['rows'][] = $entry;
				}
			echo json_encode($answer);
	    }

	    function getCVList()
	    {
	    	$page 		= isset($_POST['page']) ? $_POST['page'] : 1;
			$rp 		= isset($_POST['rp']) ? $_POST['rp'] : 10;
			$sortname 	= isset($_POST['sortname']) ? $_POST['sortname'] : 'name';
			$sortorder 	= isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
			

			$rGetCVFile = $this->QUERY->getPostulant_CVFile("WHERE a.id_postulant = '".$this->accountId."'");
			
			$limitINIT = $page == -1 || $page == 1? 0:($page-1) * $rp;
			$total = $rGetCVFile->size();

			$rGetCVFile = $this->QUERY->getPostulant_CVFile("WHERE a.id_postulant = '".$this->accountId."'ORDER BY a.id DESC LIMIT $limitINIT, $rp");

			$answer = array('page'=>$page,'total'=>$total,'rows'=>array(), "state"=>$_POST['opt']);

			while ($row = $rGetCVFile->fetch())
			{					
					$entry = array('id'=>$row['id']
								,'cell'=>array(								
								'delete'	=>"<img src='../media/icon/_delete_min.png' style='cursor: pointer;' id='delete_".$row['id']."'>"
								,'download'	=>"<img src='../media/icon/_pdf.png' style='cursor: pointer;' id='download".$row['id']."'>"
								,'date'		=> $this->COMMON->getDateFormat($row['dt_registry'])
								,'name'		=> $row['tx_filename']								
							),
					);
					
				$answer['rows'][] = $entry;	

			}

			echo json_encode($answer);
	    }

	    function saveCVList()
	    {

	    }

	    function delCVList()
	    {

	    }

	    function uploadphoto()
	    {

			include('../../inc/SimpleImage.php');
			
			define ("MAX_SIZE","1024");
			
			$image=$_FILES['image']['name'];
			
			$photoLink 	= $this->COMMON->getRoot().$this->GLOBAL['linkPhotoPostulant'];
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
							    	copy($photoLink.'index_postulant.php', $folder.'/index.php');
							    }
							    
								$eImage = new SimpleImage();
							    $eImage->load($folder.$image_original);

							    $eImage->resize(128,128);							    
							    $eImage->save($folder.$image_50p);
							
							    $eImage->resize(64,64);
							    $eImage->save($folder.$image_30p);
							    
							    $answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_UploadImageSuccess'], "photo"=>$image_50p, "state"=>$_POST['opt']);

							    $this->QUERY->updatePostulant(array('tx_image' => $image_name), "WHERE id_user ='".$this->accountId."'");
						
								$_SESSION['enlaceemp_image']				= $image_name;
						}
				   }
		       }
		       else{			
				    $answer = array("answer"=>'fail', "msg"=>$this->STR['Msg_UploadImageFail'], "state"=>$_POST['opt']);
		       }
		      
			echo json_Encode($answer);
	    }
	    

	    function getstatus()
	    {
	    	$rGetPostulant = $this->QUERY->getPostulant("WHERE a.id_user = '".$this->accountId."'");
	    	$rDataPostulant = $rGetPostulant->fetch();

	    	$AccountData = count($rDataPostulant) - 5;

	    	foreach ($rDataPostulant as $key => $value) 
	    	{
	    		if(!isset($value) || $value == -1 || $value == '')
	    		{
	    			if($key!='nm_toeflscore' && $key!='tx_rfc' && $key!='id'  && $key!='id_user' && $key!='tx_image')
	    				$AccountData --;
	    		}
	    			
	    	}
	    	$aveAccountData = ( $AccountData / (count($rDataPostulant) - 5)) * 100;


			/***************************************/
			$rGetPostulant_studies = $this->QUERY->getPostulant_studies("WHERE a.id_postulant = '".$this->accountId."' ORDER BY a.id DESC");
	    	$rDataPostulant_studies = $rGetPostulant_studies->fetch();


			if($rGetPostulant_studies->size() <= 0)
	    		$aveAcademic = 0;
	    	else
	    	{
		    	$Academic = (count($rDataPostulant_studies) - 4);

		    	foreach ($rDataPostulant_studies as $key => $value) 
		    	{
		    		if(!isset($value) || $value == -1 || $value == '')
		    		{
		    			if($key!='tx_average' && $key!='tx_comment' && $key!='id'  && $key!='id_postulant' && $key != 'tx_graduate')
		    				$Academic--;
		    		}	    			
		    	}
					$aveAcademic = ($Academic / (count($rDataPostulant_studies) - 4)) * 100;
			}

			/***************************************/

			$rGetPostulant_informatic = $this->QUERY->getPostulant_informatic("WHERE a.id_postulant = '".$this->accountId."' ORDER BY a.id DESC");
	    	$rDataPostulant_informatic = $rGetPostulant_informatic->fetch();


			if($rGetPostulant_informatic->size() <= 0)			
	    		$aveInformatic = 0;	    	
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

				$aveInformatic = ($Informatic / (count($rDataPostulant_informatic) - 3)) * 100;
			}

			/***************************************/

			$rGetPostulant_knowledge = $this->QUERY->getPostulant_knowledge("WHERE a.id_postulant = '".$this->accountId."' ORDER BY a.id DESC");
	    	$rDataPostulant_knowledge = $rGetPostulant_knowledge->fetch();


			if($rGetPostulant_knowledge->size() <= 0)			
	    		$aveKnowledge = 0;	    	
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

				$aveKnowledge = ($Knowledge / (count($rDataPostulant_knowledge) - 2)) * 100;
			}

			/***************************************/

			$rGetPostulant_language = $this->QUERY->getPostulant_language("WHERE a.id_postulant = '".$this->accountId."' ORDER BY a.id DESC");
	    	$rDataPostulant_language = $rGetPostulant_language->fetch();

			if($rGetPostulant_language->size() <= 0)			
	    		$aveLanguages = 0;	    	
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

				$aveLanguages = ($language / (count($rDataPostulant_language) - 2)) * 100;
			}

			/***************************************/

			$rGetPostulant_experience = $this->QUERY->getPostulant_experience("WHERE a.id_postulant = '".$this->accountId."' ORDER BY a.id DESC");
	    	$rDataPostulant_experience = $rGetPostulant_experience->fetch();

			if($rGetPostulant_experience->size() <= 0)			
	    		$aveJobExperience = 0;	    	
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

				$aveJobExperience = ($JobExperience / (count($rDataPostulant_experience) - 2)) * 100;
			}

			/***************************************/

			$rGetPostulant_expectative = $this->QUERY->getPostulant_expectative("WHERE a.id_postulant = '".$this->accountId."' ORDER BY a.id DESC");
	    	$rDataPostulant_expectative = $rGetPostulant_expectative->fetch();

			if($rGetPostulant_expectative->size() <= 0)			
	    		$aveExpectatives = 0;	    	
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

				$aveExpectatives = ($Expectative / (count($rDataPostulant_expectative) - 3)) * 100;
			}
			/***************************************/

	    	$answer = array("answer"=>'correct', 
	    				"status"=>array(
						'AccountData' => number_format($aveAccountData, 0).$this->STR['aveCompleted']
						,'Academic' => number_format($aveAcademic, 0).$this->STR['aveCompleted']
						,'Informatic' => number_format($aveInformatic, 0).$this->STR['aveCompleted']
						,'Knowledge' => number_format($aveKnowledge, 0).$this->STR['aveCompleted']
						,'Languages' => number_format($aveLanguages, 0).$this->STR['aveCompleted']
						,'JobExperience' => number_format($aveJobExperience, 0).$this->STR['aveCompleted']
						,'Expectatives' => number_format($aveExpectatives, 0).$this->STR['aveCompleted']

	    				), "state"=>$_POST['opt']);

	    	echo json_Encode($answer);
	    }

	    function uploadCVFile()
	    {
	    	include('../../inc/Upload.class.php');

			$dt_upload 			= $this->STR['CurrentDate'];
			$folderLocation		= $this->COMMON->getRoot().$this->GLOBAL['postulantCVfile'].$this->accountId.'/';

			$upload 			= new Upload('CVFile',$folderLocation);						
			$upload->setMaxFileSize(4,UPLOAD_SIZE_MBYTES);						
			$upload->setTypes(array('*')); 


			$filename 			= $upload->getFileName();
		    $fileExtension 		= strtolower($this->COMMON->getExtension($filename));

			if(!file_exists($folderLocation))
			{							    
				mkdir($folderLocation, 0777);
				copy($this->COMMON->getRoot().$this->GLOBAL['postulantCVfile'].'index_cvfile.php', $folderLocation.'index.php');
			}

			$bExtension = false;
			foreach($this->GLOBAL['PDFfileType'] as $key => $ext)				    
				    if (($fileExtension == $ext)) 				    
						$bExtension = true;
				    
		    if(!$bExtension)
		    {
		    	$answer = array("answer"=>'fail', "msg"=>$this->STR['Msg_UploadFailFail_format'],"state"=>$_POST['opt']);
		    	echo json_encode($answer);
				return false;
		    }


			$process = $upload->process();
			
			if (! $process) 
			{
				$answer = array("answer"=>'fail', "msg"=>$upload->getMessage(), "state"=>$_POST['opt']);
				echo json_encode($answer);
				return false;
			}
			
			
				
			$rGetPostulant_CVFile = $this->QUERY->getPostulant_CVFile("WHERE a.id_postulant = '".$this->accountId."'");
	    	$rDataPostulant_CVFile = $rGetPostulant_CVFile->fetch();

	    	$binaryName = md5($this->accountId.$this->STR['CurrentHour']).'.'.$fileExtension;

			$upload->setRenameFile($binaryName);

	    	if($rGetPostulant_CVFile->size() <= 0)
	    	{	    		
	    		$rGetPostulant_CVFile 	= $this->QUERY->insertPostulant_CVFile(
				    		array(  'id_postulant' 			=> $this->accountId
									,'dt_registry' 			=> $dt_upload
									,'tx_filename' 			=> str_replace(' ','_',"cv_".$_SESSION['enlaceemp_accountname'].".pdf")
									,'tx_binaryname' 		=> $binaryName
				));
				
				$answer = array("answer"=>'correct', "msg"=>$this->STR['InsertCVFile'], "state"=>$_POST['opt']);
	    	}
	    	else
	    	{
				$filelocation = $folderLocation.$rDataPostulant_CVFile['tx_binaryname'];

	    		if(file_exists($filelocation))
							unlink($filelocation);


				$rGetPostulant_CVFile 	= $this->QUERY->updatePostulant_CVFile(
				    		array(  'dt_registry' 			=> $dt_upload
									,'tx_filename' 			=> $filename
									,'tx_binaryname' 		=> $binaryName
				));		
				
				$answer = array("answer"=>'correct', "msg"=>$this->STR['UpdateCVFile'], "state"=>$_POST['opt']);
	    	}

				
			echo json_encode($answer);
	    }

	    function deleteCVFile()
	    {
	    	$rGetPostulant_CVFile = $this->QUERY->deletePostulant_CVFile("WHERE id_postulant = '".$this->accountId."' AND id = '".$_POST['selectedRowID']."'");
	    	
	    	$answer = array("answer"=>'correct', "msg"=>$this->STR['DeleteCVFile'], "state"=>$_POST['opt']);

	    	echo json_encode($answer);
	    }

}//end of class
	    $remote = new remote();
	    $option = $_POST['opt'];	    
	    switch($option)
	    {	    	    
	    	case "getList":
				$remote->getList();
	    	break;

	    	case 'getCVList':
	    		$remote->getCVList();
	    	break;

	    	case 'uploadCVFile':
	    		$remote->uploadCVFile();
	    	break;

	    	case 'deleteCVFile':
	    		$remote->deleteCVFile();
	    	break;

	    	case "uploadphoto":
	    		$remote->uploadphoto();
	    	break;

	    	case "getstatus":
	    		$remote->getstatus();
	    	break;

			default:
				 die();
			break;
	    
	    }
	    

	    
?>