<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var STATE_UPDATE = 'update';var aCountry 	= new ArrayCollection();
var aState 		= new ArrayCollection();var aSector 	= new ArrayCollection();<?php 	$COMMON->fillArrayCollection('aState' 
		, $QUERY->getState('ORDER BY tx_state ASC')		, array('id_country','id','tx_state')		, null		, true);	$COMMON->fillArrayCollection('aSector' 
		, $QUERY->getSector('WHERE id != "9999" ORDER BY tx_description ASC')		, array('id','tx_description')		, array('-1',$STR['SelectSector'])		, true); ?>
$(document.body).ready(function(){	    	enableBasicTinyMCE('textarea', 950);
  	fillCombobox('#Sector', aSector, {'value':'0', 'label':'1'});		fillCombobox('#State', aState, {'comboTrigger':'134', 'select':'2','value':'1', 'label':'2'});    fillFields();
	$("#btnUpdate").live("click", function(e)	{		var params = 		{			url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',	        beforeSubmit:  	showRequest,
	        success:       	showResponse,	 		error:   		errorResponse,	 		type: 			'post',	 		dataType:      	'json',	        data: 			{ 'opt': STATE_UPDATE}	    };
		setRemoteRequest('#formID', params);    });});
function showRequest(formData, jqForm, options) {   		openOverlay();	displayPrompt('#formID_waitdialog', '', 'wait_progress', false);    return true; 
} function showResponse(data)  { 
	closeOverlay();	if(isBlank(data))	{		displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;
	}	if(data.state == STATE_UPDATE)	{    								displayPrompt('#formID_waitdialog', data.msg, data.answer, false);			}
}function errorResponse(data){	closeOverlay();
	displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);}function fillFields(){		$('#Sector').val('<?php   echo  $rDataCompany['id_worksector']; ?>');	
	$('#State').val('<?php   echo  $rDataCompany['id_state']; ?>');}
