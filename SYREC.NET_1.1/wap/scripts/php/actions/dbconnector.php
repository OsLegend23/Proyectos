<?php
	//dbconnector.php

	//Define the mysql connection variables.
	
	$workAsRemote=true;
	
	if($workAsRemote){
		define ("MYSQLHOST", "localhost");
		define ("MYSQLUSER", "root");
		define ("MYSQLPASS", "1XQXQfZnh");
		define ("MYSQLDB", "abonocel");
	}else{
		define ("MYSQLHOST", "localhost");
		define ("MYSQLUSER", "root");
		define ("MYSQLPASS", "");
		define ("MYSQLDB", "agbservi_servicel");
	}
	
	function opendatabase(){
		@$db = mysql_connect (MYSQLHOST,MYSQLUSER,MYSQLPASS);
		try {
			if (!$db){
				$exceptionstring = "Error connection to database <br />";				
				throw new exception ($exceptionstring);
			} else {
				mysql_select_db (MYSQLDB,$db) or die(mysql_error());
			}
			return $db;
		} catch (exception $e) {
			echo $e->getmessage();
			die();
		}
	}
		
	function getQueryString($idQuery){
			$querystr="SELECT SQLString FROM sqlstrings WHERE idSQLString=".$idQuery;
			$myquery=mysql_query($querystr);
			$rsQuery = mysql_fetch_array($myquery);
			return $rsQuery["SQLString"];
	}
?>