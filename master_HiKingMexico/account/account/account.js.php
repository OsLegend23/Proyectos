<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>
    
var STATE_AUTENTICATE = 'autenticate';

$(document.body).ready(function() {
    $("#btnAutenticate").live("click", function(e) {
        var params = {
            url: 			'<?php   echo  $COMMON->getRoot(); ?>remote.php',
            beforeSubmit:  	showRequest,
            success:       	showResponse,
            error:   		errorResponse,
            type: 			'post',
	 		dataType:      	'json',
            data: 			{ 'opt': STATE_AUTENTICATE}
        };
        setRemoteRequest('#formID', params);
    });
    <?php if(isset($_REQUEST['validation'])) { echo  "showValidationAnswer();";	} ?>
});
    
function showValidationAnswer() {
    $('#validation_answer').html('<div class="cleaner h10"></div><?php   echo  $answer; ?>');
    openModal('validation_dialog', 460, 250);
}
    
function showRequest(formData, jqForm, options) {
    openOverlay();
    displayPrompt('#formID_waitdialog', '', 'wait_progress', false);
    return true; 
} 
    
function showResponse(data) {
    if(isBlank(data)) {
        closeOverlay();
        displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
        return false;
    }
	if(data.state == STATE_AUTENTICATE)	{
        if(data.answer == 'fail') {
            closeOverlay();
			change_captcha('Chars');
            displayPrompt('#formID_waitdialog', data.msg, data.answer, false);
        } else if(data.answer == 'correct')	{
            top.location.href="<?php   echo  $COMMON->getRoot(); ?>"+data.accounttype+"/";
        }
    }
}
    
function errorResponse(data) {	
    closeOverlay();	
    displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
}
