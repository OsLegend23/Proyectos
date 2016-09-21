<?php
/*
/main/main.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

	include($COMMON->getMySQL());	
	$db = new MySQL($GLOBAL['db_host'], $GLOBAL['db_user'], $GLOBAL['db_password'], $GLOBAL['db_name']);
	include($COMMON->getQuery());
	include($COMMON->getGenForm());


	$gForm = new gForm();
	$gForm->setNameForm('formID');
	$gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');
	$gForm->setActionForm('#');
	$gForm->setStatus('New');
	$gForm->setLegend($STR['accountData']);
	$gForm->setAlignForm('left');

	$gForm->setButton(array('ID'=>'btnSubmit', 'ICON'=>'', 'LABEL'=>$STR['RegistryMe'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));	

	$gForm->setField('COMMENT', '',$STR['CommentUserInfo'], array(), array());	
	$gForm->setField('TEXTFIELD', 'Email',$STR['Email'], array(), array());	
	$gForm->setField('PASSWORD', 'Pass',$STR['Pass'], array(), array());
	$gForm->setField('PASSWORD', 'ConfPass',$STR['ConfPass'], array(), array());	
	$gForm->setField('TEXTFIELD', 'Name',$STR['Name'], array(), array());
	$gForm->setField('TEXTFIELD', 'Surname',$STR['Surname(s)'], array(), array());
	$gForm->setField('TEXTFIELD', 'SurnameMaternal',$STR['SurnameMaternal'], array(), array());
	
	$gForm->setField('SEPARATOR', '','', array(), array());
	$gForm->setField('COMMENT',	'',$STR['CommentCompanyInfo'], array(), array());	
	$gForm->setField('TEXTFIELD','CompanyName',$STR['TradeName'], array(), array());
	$gForm->setField('TEXTFIELD','RFC',$STR['RFC'], array(), array());
	$gForm->setField('COMBOBOX','Sector',$STR['Sector'], array() , array());	
	$gForm->setField('COMBOBOX','Activity',$STR['Activity'], array(), array());
    $gForm->setField('TEXTFIELD','WorkMail',$STR['WorkMail'], array(), array());
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['About'], array(), array());	

	$gForm->setField('TEXTAREA','About',"", array(), array());
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['ActualAddress'], array(), array());	
	$gForm->setField('COMBOBOX','Country',$STR['Country'], array(), array());
	$gForm->setField('COMBOBOX','State',$STR['State'],array(), array());
	$gForm->setField('TEXTFIELD','City',$STR['City'], array(), array());
	$gForm->setField('TEXTFIELD','Colony',$STR['Colony'], array(), array());
	$gForm->setField('TEXTFIELD','Street',$STR['Street'], array(), array());
	$gForm->setField('TEXTFIELD','Number',$STR['Number'], array(), array());
	$gForm->setField('TEXTFIELD','PostalCode',$STR['PostalCode'], array(), array());	
	$gForm->setField('TEXTFIELD','Phone',$STR['Phone'], array(), array());
	$gForm->setField('TEXTFIELD','Mobil',$STR['Mobil'], array(), array());
	
	$gForm->setField('SEPARATOR','','', array(), array());	
	$gForm->setField('TEXTFIELD','URLWeb',$STR['URLWeb'], array(), array());
	$gForm->setField('TEXTFIELD','LinkFacebook',$STR['LinkFacebook'], array(), array());
	$gForm->setField('TEXTFIELD','LinkTwitter',$STR['LinkTwitter'], array(), array());
	
	
?>

