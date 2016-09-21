<?php
/*
/controlpanel/controlpanel.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

    $rGetPostulant_Expectative = $QUERY->getPostulant_expectative("WHERE a.id_postulant = '".$accountId."'");
    $rDataExpectative = $rGetPostulant_Expectative->fetch();
	
	$gForm = new gForm();

    $gForm->setNameForm('formID');
    $gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');
	$gForm->setActionForm($viewpage.'/remote.php');
	$gForm->setStatus('New');	
	$gForm->setLegend($STR['LikeToWork']);
	
    $gForm->setField('COMBOBOX','WorkArea',$STR['WorkArea'],array(), array('MCLASS'=>$GLOBAL['vld_nm_req']));
    
    $gForm->setField('ICONBUTTON','AddExpectativeToWork','', array(), array('ICON'=>"_down_min.png", 'TITLE'=>$STR['AddToList'], 'WIDTH'=>'360px;'));
	$gForm->setField('TABLE','tblRecorded','', array(), array(), array());

    $gFormExpectatives = new gForm();
    $gFormExpectatives->setNameForm('formIDExpectatives');
    $gFormExpectatives->setRoot($COMMON->getRoot());
    $gFormExpectatives->setMethodForm('post');
    $gFormExpectatives->setActionForm('#');
    $gFormExpectatives->setStatus('New');
    $gFormExpectatives->setLegend($STR['Expectatives']);

    $gFormExpectatives->setButton(array(ID=>'btnSubmit', LABEL=>$STR['Save'],POSX=>'right', TYPE=>'SUBMIT'));

    $gFormExpectatives->setField('SEPARATOR','','', array(), array());
    $gFormExpectatives->setField('COMBOBOX','HierarchyLevel',$STR['HierarchyLevel'], $STR['HierarchyLevelList'], array('SELECTED'=>$rDataExpectative['nm_hierarchyLevel'], 'MCLASS'=>$GLOBAL['vld_nm_req']));
    $gFormExpectatives->setField('RADIOBUTTON','HomeChange',$STR['HomeChange'], $STR['QuestionYesNo'], array('CHECKED'=>$rDataExpectative['ch_changeresidence'], 'MCLASS'=>$GLOBAL['vld_ch_req_radio']));
    $gFormExpectatives->setField('RADIOBUTTON','WorkCompleteTime',$STR['WorkCompleteTime'], $STR['QuestionYesNo'], array('CHECKED'=>$rDataExpectative['ch_fulltimework'], 'MCLASS'=>$GLOBAL['vld_ch_req_radio']));
    $gFormExpectatives->setField('RADIOBUTTON','WorkMiddleTime',$STR['WorkMiddleTime'], $STR['QuestionYesNo'], array('CHECKED'=>$rDataExpectative['ch_parttimework'], 'MCLASS'=>$GLOBAL['vld_ch_req_radio']));
    $gFormExpectatives->setField('RADIOBUTTON','Workfees',$STR['Workfees'], $STR['QuestionYesNo'], array('CHECKED'=>$rDataExpectative['ch_workfees'], 'MCLASS'=>$GLOBAL['vld_ch_req_radio']));
    $gFormExpectatives->setField('RADIOBUTTON','WorkTemp',$STR['WorkTemp'], $STR['QuestionYesNo'], array('CHECKED'=>$rDataExpectative['ch_worktemporarily'], 'MCLASS'=>$GLOBAL['vld_ch_req_radio']));	
    $gFormExpectatives->setField('TEXTFIELD','WantMoney',$STR['WantMoney'].' ('.$STR['Moneda'].')', array($rDataExpectative['nm_monthlysalary']), array('MCLASS'=>$GLOBAL['vld_tx_req']));	
    $gFormExpectatives->setField('SEPARATOR','','', array(), array());
	$gFormExpectatives->setField('COMMENT','',$STR['Description'], array(), array());
    $gFormExpectatives->setField('TEXTAREA','Comment','', array($rDataExpectative['tx_comment']), array('MCLASS'=>$GLOBAL['vld_tx_opt_max600']));

	
?>