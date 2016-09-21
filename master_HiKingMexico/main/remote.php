<?php
/*
remote.php
*/
session_start();


class remote
{
    var $accountId;
	    
	function __construct()
	{			
        $this->accountId = $_SESSION['enlaceemp_accountid'];
    }
	    
}//end of class

$remote = new remote();
$option = $_POST['opc'];	    
switch($option)
{	    	    
    default:
        die();
        break;
	    
}
	    
	    
?>