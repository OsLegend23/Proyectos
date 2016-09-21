<?php
/*
/main/main.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

	$rGetUser 			= $QUERY->getUser("WHERE a.id = '".$accountId."'");
	$rDataUser			= $rGetUser->fetch();
	$rGetPostulant 		= $QUERY->getPostulant("WHERE a.id_user = '".$accountId."'");
	$rDataPostulant		= $rGetPostulant->fetch();

	$gForm = new gForm();
	$gForm->setNameForm('formID');
	$gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');
	$gForm->setActionForm('#');
	$gForm->setStatus('New');
	$gForm->setLegend($STR['accountData']);
	$gForm->setAlignForm('left');

	$gForm->setButton(array('ID'=>'btnUpdPostulant', 'ICON'=>'', 'LABEL'=>$STR['Save'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));

	$gForm->setField('TEXTFIELD',	'Email',$STR['Email'], array($rDataUser['tx_email']), array('DISABLED'=>'DISABLED'));	
	$gForm->setField('PASSWORD',	'Pass',$STR['Pass'], array($GLOBAL['passwordNotChanged']), array('MCLASS'=>$GLOBAL['vld_tx_password']));
	$gForm->setField('PASSWORD',	'ConfPass',$STR['ConfPass'], array($GLOBAL['passwordNotChanged']), array('MCLASS'=>$GLOBAL['vld_confirm_tx_password']));
	
	$gForm->setField('SEPARATOR',	'','', array(), array());
	$gForm->setField('COMMENT','',	$STR['PersonalInfo'], array(), array());
	$gForm->setField('TEXTFIELD',	'Name',$STR['Name(s)'], array($rDataUser['tx_name']), array('MCLASS'=>$GLOBAL['vld_tx_req_max50']));
	$gForm->setField('TEXTFIELD',	'Surname',$STR['Surname(s)'], array($rDataUser['tx_surname']), array('MCLASS'=>$GLOBAL['vld_tx_req_max50']));	
	$gForm->setField('TEXTFIELD',	'RFC',$STR['RFC'], array($rDataPostulant['tx_rfc']), array('MCLASS'=>$GLOBAL['vld_tx_opt_max16']));
	$gForm->setField('RADIOBUTTON',	'Gender',$STR['Gender'], array("F"=>$STR['GenderFemale'],"M"=>$STR['GenderMale']), array('MSTYLE'=>"", 'CHECKED'=>$rDataPostulant['ch_gender'], 'MCLASS'=>$GLOBAL['vld_ch_req_radio']));
	$gForm->setField('TEXTFIELD',	'BornDate',$STR['BornDate'], array($rDataPostulant['dt_borndate']), array('MCLASS'=>$GLOBAL['vld_dt_req'].' datepicker'));
	
	$gForm->setField('RADIOBUTTON',	'MaritalStatus',$STR['MaritalStatus'], array("S"=>$STR['MaritalStatusSingle'],"C"=>$STR['MaritalStatusMarried'],"D"=>$STR['MaritalStatusDivorced'], "V"=>$STR['MaritalStatusWidowed']), array('MSTYLE'=>"", 'CHECKED'=>$rDataPostulant['ch_maritalstatus'],  'MCLASS'=>$GLOBAL['vld_ch_req_radio']));		
	$gForm->setField('SEPARATOR',	'','', array(), array());	
	$gForm->setField('COMMENT','',	$STR['Location'], array(), array());	

	$gForm->setField('COMBOBOX',	'State',$STR['State'], array() , array('SELECTED'=>"",  'MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('TEXTFIELD',	'City',$STR['City'], array($rDataPostulant['tx_city']), array( 'MCLASS'=>$GLOBAL['vld_tx_req_max25']));
	$gForm->setField('TEXTFIELD',	'Colony',$STR['Colony'], array($rDataPostulant['tx_colony']), array( 'MCLASS'=>$GLOBAL['vld_tx_req_max50']));
	$gForm->setField('TEXTFIELD',	'Street',$STR['Street'], array($rDataPostulant['tx_street']), array('MCLASS'=>$GLOBAL['vld_tx_req_max50']));
	$gForm->setField('TEXTFIELD',	'Number',$STR['Number'], array($rDataPostulant['tx_number']), array('MCLASS'=>$GLOBAL['vld_tx_req_max10']));
	
	$gForm->setField('TEXTFIELD',	'Phone',$STR['Phone'], array($rDataPostulant['tx_phone']), array( 'MCLASS'=>$GLOBAL['vld_tx_req_max15']));
	$gForm->setField('TEXTFIELD',	'Mobil',$STR['Mobil'], array($rDataPostulant['tx_mobil']), array('MCLASS'=>$GLOBAL['vld_tx_opt_max15']));
	
?>