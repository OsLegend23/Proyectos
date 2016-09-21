<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>
    
var tagId               = 'formID_waitdialog';
var STATE_MAILINGLIST   = 'mailinglist';

$(document.body).ready(function() {
    
    $("#btnSearch").live("click", function(e) {
        var key = $("#key").val();
        var location = $("#location").val();
        top.location.href="<?php   echo  $COMMON->getRoot(); ?>search/?opt=simplequery&keyword="+key+"&city="+location;
        return false;
    });
    
    $("#btnMailingList").live("click", function(e) {
        var params = {
            url:            '<?php   echo  $COMMON->getRoot(); ?>remote.php',
            beforeSubmit:   showRequest,
            success:        showResponse,
            error:          errorResponse,
            type:           'post',
            dataType:       'json',
            data:           { 'opt': STATE_MAILINGLIST}
        };
        tagId   = 'formID_waitdialog';
        setRemoteRequest('#formID', params);
    });
});

function showRequest() {
    //openModalOverlay();
    //displayPrompt('#'+tagId, '', 'wait_progress', false);
    toast('Enviando...', 2000);
    return true; 
}

function showResponse(data) {
    //closeModalOverlay();
    
    if(isBlank(data)) {
        //displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
        toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000);
        return false;
    }
    
    if(data.state == STATE_MAILINGLIST) {
        change_captcha('Chars');
        //displayPrompt('#'+tagId, data.msg, data.answer, false);
        toast(data.msg, 4000)
    }
}

function errorResponse(data) {
    //closeModalOverlay();
    //displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
    toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000);
}
