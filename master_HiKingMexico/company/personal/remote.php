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

	    function update()
	    {
	    	$aParams 			= array();

	    	foreach ($_POST as $key => $value)
	    	{
	    		if($key !='opt')
	    			$aParams[$key] = $this->COMMON->getEscapeString($value);

	    		$pos = strrpos($key, "Benefits_");

    			if($pos === false)	    			
    				$aParams[$key] = $this->COMMON->getEscapeString($value);
    			else
    				$aParams['Benefits'] .= $this->COMMON->getEscapeString($key).';';

	    	}

	    	$rGetUser 	= $this->QUERY->getUser("WHERE a.id = '".$this->accountId."' ");
			$rDataUser	= $rGetUser->fetch();

			if(strcmp($aParams['Pass'], $this->GLOBAL['passwordNotChanged']) != 0)
				   $aParams['Pass'] =  md5($aParams['Pass']); 
			else
				   $aParams['Pass'] = $rDataUser['tx_password'];
			

				$rGetUser = $this->QUERY->updateUser(
							array(								
								'tx_password' 			=> $aParams['Pass']
								,'tx_name' 				=> $aParams['Name']
								,'tx_surname' 			=> $aParams['Surname']								
								,'dt_lastvisit' 		=> $this->STR['CurrentDate']
								,'tx_ipaddress' 		=> $_SERVER['REMOTE_ADDR']
								), 

								"WHERE id ='".$this->accountId."'"
								);
				
				$rGetPostulant 	= $this->QUERY->updateCompany(
				    		array(  'tx_tradename' 			=> $aParams['TradeName']
				    				,'tx_trademark' 		=> $aParams['TradeMark']
									,'tx_companyemail' 		=> $aParams['CompanyMail']
									,'tx_confidentialemail' => $aParams['ConfidentialMail']
									,'tx_rfc' 				=> $aParams['RFC']
									,'tx_colony' 			=> $aParams['Colony']
									,'tx_street' 			=> $aParams['Street']
									,'tx_number' 			=> $aParams['Number']
									,'tx_phone' 			=> $aParams['Phone']
									,'tx_mobil' 			=> $aParams['Mobil']
									,'id_state' 			=> $aParams['State']
									,'tx_city' 				=> $aParams['City']
									,'id_worksector' 		=> $aParams['Sector']
									,'tx_activity' 			=> $aParams['Activity']
									,'tx_web' 				=> $aParams['URLWeb']
									,'tx_gmap' 				=> $aParams['tx_gmap']
									,'tx_facebook' 			=> $aParams['LinkFacebook']
									,'tx_twitter' 			=> $aParams['LinkTwitter']
									,'tx_about' 			=> $aParams['CompanyAbout']									
									,'tx_benefits'			=> $aParams['Benefits']
									,'nm_employees'			=> $aParams['Employees']
									,'tx_confidential_trademark' => $aParams['ConfidentialTradeMark']
									
						), "WHERE id_user = '".$this->accountId."'");
	
				$answer = array("answer"=>'correct', "msg"=>$this->STR['Msg_Update_Success'], "state"=>$_POST['opt']);


			echo json_encode($answer);

	    }
	    
}//end of class
	    $remote = new remote();
	    $option = $_POST['opt'];	    
	    switch($option)
	    {	    	    
	    	
			case 'update':
				$remote->update();
				break;

			default:
				    die();
			break;
	    
	    }
	    
	    
?>