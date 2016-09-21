<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>
    
var STATE_PASSWORDRECOVERY = 'passwordRecovery';

$(document.body).ready(function() {
    $("#btnSubmit").live("click", function(e) {
        var params = {
            url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',
            beforeSubmit:  	showRequest,
            success:       	showResponse,
            error:   		errorResponse,
            type: 			'post',
	 		dataType:      	'json',
            data: 			{ 'opt': STATE_PASSWORDRECOVERY}
        };
        
        setRemoteRequest('#formID', params);
    });
});

function showRequest(formData, jqForm, options) {   
	openOverlay();
    displayPrompt('#formID_waitdialog', '', 'wait_progress', false);
    return true;
}

function showResponse(data) {
    closeOverlay();
    
	if(isBlank(data)) {
        displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
        return false;
    }
    
	if(data.state == STATE_PASSWORDRECOVERY) {
        change_captcha('Chars');
        displayPrompt('#formID_waitdialog', data.msg, data.answer, false);
        clearForm('formID');
    }
}

function errorResponse(data) {
    closeOverlay();
	displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
}
