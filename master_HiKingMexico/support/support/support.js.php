<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>

var STATE_SENDCOMMENT = 'sendComment';
var tagId = '';

$(document.body).ready(function () {

    /*$('#btnContact').live("click", function(e) {
     //openModal('dialog_contact', 780, 510);
     enableBasicTinyMCE('textarea', 600);
     return false;
     });*/

    $("#btnSendComment").live("click", function (e) {
        tagId = 'formID_waitdialog';

        if (isBlank($('#comment').val())) {
            displayPrompt('#' + tagId, '<?php   echo  $STR['EnterComments']; ?>', 'fail', false);
            return false;
        }
        var params = {
            url: '<?php   echo  $viewpage.'/'; ?>remote.php',
            beforeSubmit: showRequest,
            success: showResponse,
            error: errorResponse,
            type: 'post',
            dataType: 'json',
            data: {'opt': STATE_SENDCOMMENT}
        };
        setRemoteRequest('#formID', params);
    });

    <?php if(isset($_REQUEST['contact'])) echo  "$('#btnContact').trigger('click');";	 ?>
});

function showRequest(formData, jqForm, options) {
    openModalOverlay();
    displayPrompt('#' + tagId, '', 'wait_progress', false);
    return true;
}

function showResponse(data) {
    closeModalOverlay();

    if (isBlank(data)) {
        displayPrompt('#' + tagId, '<?php   echo  $STR['Msg_Comment_Fail']; ?>', 'error', false);
        return false;
    }

    if (data.state == STATE_SENDCOMMENT) {
        if (data.answer == 'fail') {
            displayPrompt('#' + tagId, data.msg, data.answer, false);
            change_captcha('Chars');
        } else if (data.answer == 'correct') {
            displayPrompt('#' + tagId, data.msg, data.answer, false);
            clearForm("formID");
        }
    }
}

function errorResponse(data) {
    closeModalOverlay();
} 
