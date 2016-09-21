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

	    function uploadpublicity()
	    {

			include('../../inc/SimpleImage.php');
			
			define ("MAX_SIZE","2048");
			
			$image 			=$_FILES['image']['name'];
			
			$photoLink 		= $this->COMMON->getRoot().$this->GLOBAL['linkslideshow'];
			
			$folder			= $photoLink;

			$action			= $this->COMMON->getEscapeString($_POST['action']);

			$status			= $this->COMMON->getEscapeString($_POST['status']);
			$name			= $this->COMMON->getEscapeString($_POST['name']);
			$DateIn			= $this->COMMON->getEscapeString($_POST['DateIn']);
			$DateOut		= $this->COMMON->getEscapeString($_POST['DateOut']);
			$urlWeb			= $this->COMMON->getEscapeString($_POST['urlWeb']);
			$Comment		= $this->COMMON->getEscapeString($_POST['Comment']);
			$publicityId	= $this->COMMON->getEscapeString($_POST['publicityId']);
			

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
						
						$size=filesize($_FILES['image']['tmp_name']);
				   						
						$bMaxSize = true;
						if ($size > MAX_SIZE*1024)
						{
							$answer = array("answer"=>'fail', "msg"=>$this->STR['Msg_UploadImageFail_size'],"state"=>$_POST['opt']);
							$bMaxSize = false;
						}
						
						if($bMaxSize)
						{
							   
							    $timeNow			= date('H:i:s');
							    $image_name 		= md5($this->accountId.$this->GLOBAL['token'].$timeNow);
							    $image_original 	= $image_name.'.'.$extension;
							    $image_50p			= $image_name.'_50p.'.$extension;
								
							    //we verify if the image has been uploaded, and print error instead
							    $copied = copy($_FILES['image']['tmp_name'], $folder.$image_original);
							    if (!$copied) 
							    {								    
								    $answer = array("answer"=>'fail', "msg"=>$this->STR['Msg_UploadImageFail'], "state"=>$_POST['opt']);
							    }							
							    
								$eImage = new SimpleImage();
							    $eImage->load($folder.$image_original);
							    
							    $eImage->resize(235,80);
							    $eImage->save($folder.$image_50p);
							    
							    $answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_UploadImageSuccess'], "photo"=>$image_50p, "state"=>$_POST['opt']);

								if($action == 'insert')
								{
									$rGetPublicity = $this->QUERY->getPublicity("WHERE a.ch_status ='".$this->GLOBAL['status_enable']['value']."'");


									$this->QUERY->insertPublicity(
											array(
													'nm_order'				=> $rGetPublicity->size()+1
													,'dt_registry' 			=> $this->STR['CurrentDate']
													,'tx_name' 				=> $name
													,'tx_description' 		=> $Comment
													,'tx_image' 			=> $image_name
													,'tx_url' 				=> $urlWeb
													,'dt_initpublication' 	=> $DateIn
													,'dt_finishpublication' => $DateOut
													,'ch_status' 			=> $status									
												)
										);
								}
								else
								{
									$rGetPublicity = $this->QUERY->getPublicity("WHERE a.id ='".$publicityId."'");
									$rDataPublicity = $rGetPublicity->fetch();

									if($rGetPublicity->size() > 0)
									{										
										@unlink( $this->COMMON->findPhoto($rDataPublicity['tx_image'], $this->GLOBAL['linkslideshow']) );
										@unlink( $this->COMMON->findPhoto($rDataPublicity['tx_image'].'_50p', $this->GLOBAL['linkslideshow']) );										
									}


									$this->QUERY->updatePublicity(
											array(														
														'tx_name' 				=> $name
														,'tx_description' 		=> $Comment
														,'tx_image' 			=> $image_name
														,'tx_url' 				=> $urlWeb
														,'dt_initpublication' 	=> $DateIn
														,'dt_finishpublication' => $DateOut
														,'ch_status' 			=> $status

											), "WHERE id ='".$publicityId."'");
								}						
						}
				   }
		       }
		       else
		       {			

								if($action == 'update')
								{
									$this->QUERY->updatePublicity(
											array(														
														'tx_name' 				=> $name
														,'tx_description' 		=> $Comment														
														,'tx_url' 				=> $urlWeb
														,'dt_initpublication' 	=> $DateIn
														,'dt_finishpublication' => $DateOut
														,'ch_status' 			=> $status

											), "WHERE id ='".$publicityId."'");
								
									$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_UploadImageSuccess'], "photo"=>"noupdatephoto", "state"=>$_POST['opt']);
								}
								else
								{
									$answer = array("answer"=>'fail', "msg"=>$this->STR['Msg_UploadImageFail'], "state"=>$_POST['opt']);	
								}					    			
		       }
		      
			echo json_Encode($answer);
	    }
}//end of class
	    $remote = new remote();
	    $option = $_POST['opt'];	    
	    switch($option)
	    {	

	    	case "uploadpublicity":
	    		$remote->uploadpublicity();
	    	break;    	    
	    	
			default:				    
				    die();
			break;
	    
	    }
	    
	    
?>