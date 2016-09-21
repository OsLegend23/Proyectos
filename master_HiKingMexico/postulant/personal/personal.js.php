<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var STATE_UPDATEPOSTULANT = 'updPostulant';var aState 		= new ArrayCollection();
<?php 	$COMMON->fillArrayCollection('aState' 		, $QUERY->getState('ORDER BY tx_state ASC')		, array('id_country','id','tx_state')		, null
		, true); ?>$(document.body).ready(function(){	  
	enableDatepicker();			fillCombobox('#State', aState, {'comboTrigger':'134', 'select':'2','value':'1', 'label':'2'});	fillFields();	$("#btnUpdPostulant").live("click", function(e)
	{		var params = 		{			url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',	        beforeSubmit:  	showRequest,	        success:       	showResponse,
	 		error:   		errorResponse,	 		type: 			'post',	 		dataType:      	'json',	        data: 			{ 'opt': STATE_UPDATEPOSTULANT}	    };
		setRemoteRequest('#formID', params);    });});
function showRequest(formData, jqForm, options) {   		openOverlay();	displayPrompt('#formID_waitdialog', '', 'wait_progress', false);    return true; } 
function showResponse(data)  { 	closeOverlay();
	if(isBlank(data))	{		displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;	}
	if(data.state == STATE_UPDATEPOSTULANT)	{    								displayPrompt('#formID_waitdialog', data.msg, data.answer, false);			}
}function errorResponse(data){	closeOverlay();	displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
}function fillFields(){	$('#BornDate').val('<?php   echo  $rDataPostulant['dt_borndate']; ?>');	$('#Nacionality').val('<?php   echo  $rDataPostulant['nm_nationality']; ?>');
	$('#Country').val('<?php   echo  $rDataPostulant['nm_country']; ?>');	$('#State').val('<?php   echo  $rDataPostulant['nm_state']; ?>');}
