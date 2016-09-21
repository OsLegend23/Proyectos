<?php
/*
/main/main.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

	$rGetUser 			= $QUERY->getUser("WHERE a.id = '".$accountId."'");
	$rDataUser			= $rGetUser->fetch();
	$rGetCompany 		= $QUERY->getCompany("WHERE a.id_user = '".$accountId."'");
	$rDataCompany		= $rGetCompany->fetch();

	$benefits 			= explode(';', $rDataCompany['tx_benefits']);

	$gForm = new gForm();
	$gForm->setNameForm('formID');
	$gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');
	$gForm->setActionForm('#');
	$gForm->setStatus('New');
	$gForm->setLegend($STR['accountData']);
	$gForm->setAlignForm('left');

	$gForm->setButton(array('ID'=>'btnUpdate', 'ICON'=>'', 'LABEL'=>$STR['Save'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));

	$gForm->setField('COMMENT','',	$STR['accountData'], array(), array());
	$gForm->setField('TEXTFIELD',	'Name',$STR['UserName'], array($rDataUser['tx_name']), array('MCLASS'=>$GLOBAL['vld_tx_req_max50']));
	$gForm->setField('TEXTFIELD',	'Surname',$STR['Surname(s)'], array($rDataUser['tx_surname']), array('MCLASS'=>$GLOBAL['vld_tx_req_max50']));	
	$gForm->setField('TEXTFIELD',	'Email',$STR['Email'], array($rDataUser['tx_email']), array('DISABLED'=>'DISABLED', 'MCLASS'=>$GLOBAL['vld_tx_email']));	
	$gForm->setField('PASSWORD',	'Pass',$STR['Pass'], array($GLOBAL['passwordNotChanged']), array('MCLASS'=>$GLOBAL['vld_tx_password']));
	$gForm->setField('PASSWORD',	'ConfPass',$STR['ConfPass'], array($GLOBAL['passwordNotChanged']), array('MCLASS'=>$GLOBAL['vld_confirm_tx_password']));
	
	$gForm->setField('SEPARATOR',	'','', array(), array());
	$gForm->setField('COMMENT','',	$STR['CommentCompanyInfo'], array(), array());
	$gForm->setField('TEXTFIELD',	'TradeName',$STR['TradeName'], array($rDataCompany['tx_tradename']), array('MCLASS'=>$GLOBAL['vld_tx_req_max150']));
	$gForm->setField('TEXTFIELD',	'TradeMark',$STR['TradeMark'], array($rDataCompany['tx_trademark']), array('MCLASS'=>$GLOBAL['vld_tx_req_max150']));

	$gForm->setField('TEXTFIELD',	'ConfidentialTradeMark',$STR['ConfidentialTradeMark'], array($rDataCompany['tx_confidential_trademark']), array('MCLASS'=>$GLOBAL['vld_tx_req_max150']));
	

	$gForm->setField('TEXTFIELD',	'RFC',$STR['RFC'], array($rDataCompany['tx_rfc']), array('MCLASS'=>$GLOBAL['vld_tx_req_max16']));	
	$gForm->setField('COMBOBOX',	'Sector',$STR['Sector'], array(), array('SELECTED'=>$rDataCompany['id_worksector'], 'MCLASS'=>$GLOBAL['vld_nm_req']));			
	$gForm->setField('TEXTFIELD',	'Activity',$STR['Activity'], array($rDataCompany['tx_activity']), array('MCLASS'=>$GLOBAL['vld_tx_req_max150']));
	$gForm->setField('TEXTFIELD',	'Employees',$STR['Employees'], array($rDataCompany['nm_employees']), array('MCLASS'=>$GLOBAL['vld_nm_req_on']));
	$gForm->setField('COMMENT','',	'<h6 style="color:red;">'.$STR['EmailForReceiptOfCurriculum'].'</h6>', array(), array());
	
	$gForm->setField('TEXTFIELD',	'CompanyMail',$STR['CompanyMail'], array($rDataCompany['tx_companyemail']), array('MCLASS'=>$GLOBAL['vld_tx_email']));
	$gForm->setField('TEXTFIELD',	'ConfidentialMail',$STR['ConfidentialMail'], array($rDataCompany['tx_confidentialemail']), array('MCLASS'=>$GLOBAL['vld_tx_email']));

	$gForm->setField('TEXTAREA',	'CompanyAbout','', array($rDataCompany['tx_about']), array('MCLASS'=>$GLOBAL['vld_tx_req_max600']));

	$gForm->setField('SEPARATOR',	'','', array(), array());	
	$gForm->setField('COMMENT','',	$STR['Location'], array(), array());	
	$gForm->setField('COMBOBOX',	'State',$STR['State'], array() , array('SELECTED'=>"",  'MCLASS'=>$GLOBAL['vld_nm_req']));

	$gForm->setField('TEXTFIELD',	'City',$STR['City'], array($rDataCompany['tx_city']), array( 'MCLASS'=>$GLOBAL['vld_tx_req_max25']));
	$gForm->setField('TEXTFIELD',	'Colony',$STR['Colony'], array($rDataCompany['tx_colony']), array( 'MCLASS'=>$GLOBAL['vld_tx_req_max50']));
	$gForm->setField('TEXTFIELD',	'Street',$STR['Street'], array($rDataCompany['tx_street']), array('MCLASS'=>$GLOBAL['vld_tx_req_max50']));
	$gForm->setField('TEXTFIELD',	'Number',$STR['Number'], array($rDataCompany['tx_number']), array('MCLASS'=>$GLOBAL['vld_tx_req_max10']));	
	$gForm->setField('TEXTFIELD',	'Phone',$STR['Phone'], array($rDataCompany['tx_phone']), array( 'MCLASS'=>$GLOBAL['vld_tx_req_max15']));
	$gForm->setField('TEXTFIELD',	'Mobil',$STR['Mobil'], array($rDataCompany['tx_mobil']), array('MCLASS'=>$GLOBAL['vld_tx_opt_max15']));
	$gForm->setField('TEXTFIELD',	'URLWeb',$STR['URLWeb'], array($rDataCompany['tx_web']), array('MCLASS'=>$GLOBAL['vld_tx_opt_max150']));
	$gForm->setField('TEXTFIELD',	'LinkFacebook',$STR['LinkFacebook'], array($rDataCompany['tx_facebook']), array('MCLASS'=>$GLOBAL['vld_tx_opt_max150']));
	$gForm->setField('TEXTFIELD',	'LinkTwitter',$STR['LinkTwitter'], array($rDataCompany['tx_twitter']), array('MCLASS'=>$GLOBAL['vld_tx_opt_max150']));

	$gForm->setField('SEPARATOR',	'','', array(), array());
	$gForm->setField('COMMENT','',	$STR['BenefitsAndEntitlements'], array(), array());
	$gForm->setField('BNFCHECKBOX',	'Benefits',$STR['Sector'], $STR['BenefitsList'], array('CHECKED'=>$benefits, 'MCLASS'=>$GLOBAL['vld_ch_req_checkbox_min1']));
	
	
	
?>

