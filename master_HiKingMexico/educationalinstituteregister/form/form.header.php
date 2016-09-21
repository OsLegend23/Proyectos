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
	$gForm->setLegend($STR['RegistryNow']);
	$gForm->setAlignForm('left');

	$gForm->setButton(array('ID'=>'btnSubmit', 'ICON'=>'', 'LABEL'=>$STR['RegistryMe'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));

	$gForm->setField('TEXTFIELD',	'Email',$STR['Email'], array(), array('MCLASS'=>$GLOBAL['vld_tx_email']));
	$gForm->setField('TEXTFIELD',	'Confemail',$STR['Confemail'], array(), array('MCLASS'=>$GLOBAL['vld_confirm_tx_email']));
	$gForm->setField('PASSWORD','Pass',$STR['Pass'], array(), array('MCLASS'=>$GLOBAL['vld_tx_password']));
	$gForm->setField('PASSWORD','ConfPass',$STR['ConfPass'], array(), array('MCLASS'=>$GLOBAL['vld_confirm_tx_password']));

	$gForm->setField('TEXTFIELD',	'Name',$STR['Name'], array(), array('MCLASS'=>$GLOBAL['vld_tx_name']));
	$gForm->setField('TEXTFIELD',	'Surname',$STR['Surname(s)'], array(), array('MCLASS'=>$GLOBAL['vld_tx_surname']));
	$gForm->setField('TEXTFIELD',	'SurnameMaternal',$STR['SurnameMaternal'], array(), array('MCLASS'=>$GLOBAL['vld_tx_surnamematernal']));
	$gForm->setField('RADIOBUTTON',	'Sex',$STR['Gender'], array("F"=>$STR['GenderFemale'],"M"=>$STR['GenderMale']), array('MSTYLE'=>"", 'CHECKED'=>"", 'MCLASS'=>$GLOBAL['vld_ch_gender']));

	$gForm->setField('TEXTFIELD',	'Birthday',$STR['BornDate'], array(), array('MCLASS'=>$GLOBAL['vld_dt_borndate']));
	$gForm->setField('TEXTFIELD',	'RFC',$STR['RFC'], array(), array('MCLASS'=>$GLOBAL['vld_tx_rfc'], 'HELP'=>"Indica tu Registro Federal de Contribuyentes"));
	$gForm->setField('COMBOBOX',	'Nacionality',$STR['Nacionality'], $aCountry, array('SELECTED'=>"134",  'MCLASS'=>$GLOBAL['vld_nm_nationality']));
	$gForm->setField('RADIOBUTTON',	'MaritalStatus',$STR['MaritalStatus'], array("S"=>$STR['MaritalStatusSingle'],"C"=>$STR['MaritalStatusMarried'],"D"=>$STR['MaritalStatusDivorced'], "V"=>$STR['MaritalStatusWidowed']), array('MSTYLE'=>"", 'CHECKED'=>"",  'MCLASS'=>$GLOBAL['vld_ch_maritalstatus']));	
	$gForm->setField('COMBOBOX',	'NumSons',$STR['NumSons'], array("-1"=>$STR['SelectNumSons'], "0"=>$STR['NumSonsNone'], "1"=>$STR['NumSonsOne'], "2"=>$STR['NumSonsTwo'], "3"=>$STR['NumSonsThree'], "4"=>$STR['NumSonsFour'], "5"=>$STR['NumSonsFive']), array('SELECTED'=>"-1", 'MCLASS'=>$GLOBAL['vld_nm_numsons']));

	$gForm->setField('RADIOBUTTON',	'OwnCar',$STR['OwnCar'], array("S"=>$STR['Yes'],"N"=>$STR['No']), array('MSTYLE'=>"", 'CHECKED'=>"", 'MCLASS'=>$GLOBAL['vld_ch_owncar']));
	$gForm->setField('TEXTFIELD',	'Driverlicense',$STR['Driverlicense'], array(), array('MCLASS'=>$GLOBAL['vld_tx_driverlicense']));

	$gForm->setField('SEPARATOR',	'','', array(), array());	

	$gForm->setField('COMBOBOX',	'Country',$STR['Country'], $aCountry , array('SELECTED'=>"134",  'MCLASS'=>$GLOBAL['vld_nm_country']));
	$gForm->setField('COMBOBOX',	'State',$STR['State'], $aStates , array('SELECTED'=>"",  'MCLASS'=>$GLOBAL['vld_nm_state']));

	$gForm->setField('TEXTFIELD',	'City',$STR['City'], array(), array( 'MCLASS'=>$GLOBAL['vld_tx_city']));
	$gForm->setField('TEXTFIELD',	'Colony',$STR['Colony'], array(), array( 'MCLASS'=>$GLOBAL['vld_tx_colony']));
	$gForm->setField('TEXTFIELD',	'Street',$STR['Street'], array(), array('MCLASS'=>$GLOBAL['vld_tx_street']));
	$gForm->setField('TEXTFIELD',	'Number',$STR['Number'], array(), array('MCLASS'=>$GLOBAL['vld_tx_number']));
	$gForm->setField('TEXTFIELD',	'PostalCode',$STR['PostalCode'], array(), array( 'MCLASS'=>$GLOBAL['vld_tx_postalcode']));

	$gForm->setField('TEXTFIELD',	'Phone',$STR['Phone'], array(), array( 'MCLASS'=>$GLOBAL['vld_tx_phone']));
	$gForm->setField('TEXTFIELD',	'Mobil',$STR['Mobil'], array(), array('MCLASS'=>$GLOBAL['vld_tx_mobil']));	
	$gForm->setField('CAPTCHA',		'ValidateChars',$STR['ValidateChars'], array(), array('MCLASS'=>$GLOBAL['vld_tx_validatechars'], 'HELP'=>$STR['TypeCharsComment'], 'MSTYLE'=>"width:170px;"));
	$gForm->setField('SEPARATOR',	'','', array(), array());
		
	$gForm->setField('CHECKBOX',	'AceptPolitics',$STR['AceptPolitics'], array(""=>'<a href="#" id="showPolitics"><h4>'.$STR['ReadPolitics'].'</h4></a>'),  array('MSTYLE'=>"",  'MCLASS'=>$GLOBAL['vld_ch_accept']));

	
?>

