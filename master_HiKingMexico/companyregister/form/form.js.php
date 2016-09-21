<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>
    
var aState 		= new ArrayCollection();
var aSector 	= new ArrayCollection();
<?php
	$COMMON->fillArrayCollection('aState', 
                                 $QUERY->getState('ORDER BY tx_state ASC'),
                                 array('id_country','id','tx_state'),
                                 array('9999','9999', $STR['OutOfCountry']),
                                 true);
	$COMMON->fillArrayCollection('aSector', 
                                 $QUERY->getSector('WHERE id != "9999" ORDER BY tx_description ASC'),
                                 array('id','tx_description'),
                                 array('-1', $STR['SelectSector']),
                                 true);
 ?>
var STATE_COMPANYREGISTER	= 'companyRegister';

$(document.body).ready(function() {
    enableBasicTinyMCE('textarea', '100%');
    fillCombobox('#Sector', aSector, {'value':'0', 'label':'1'});
    fillCombobox('#State', aState, {'comboTrigger':'134', 'select':'2','value':'1', 'label':'2'});
	
    $("#termsAndConditions").live("click", function(e) {
        $('#AceptPolitics').attr('checked', true);
    });
    
	$("#btnRegistry").live("click", function(e)	{
        var params = 		{
            url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',
            beforeSubmit:  	showRequest,
	        success:       	showResponse,
            error:   		errorResponse,
            type: 			'post',
            dataType:      	'json',
            data: 			{ 'opt': STATE_COMPANYREGISTER}
        };
		setRemoteRequest('#formID', params);
    });
    
    $("#btnGoToAdmin").live("click", function(e) {
        top.location.href="<?php   echo  $COMMON->getRoot(); ?>company/";
    });
});

function showRequest(formData, jqForm, options) {
    var DateInstrYear = $('#DateInstrYear').val();
    var DateOutstrYear = $('#DateOutstrYear').val();
    
    if( DateOutstrYear < DateInstrYear) {
        //displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_DateError']; ?>', 'error', false);
        toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000)
        return false;
    }
    
	//openOverlay();
    //displayPrompt('#formID_waitdialog', '', 'wait_progress', false);
    toast('Enviando...', 4000)
    return true;
}

function showResponse(data) {
    //closeOverlay();
    
	if(isBlank(data)) {
        //displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
        toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000)
        return false;
    }
    
	if(data.state == STATE_COMPANYREGISTER)	{
        if(data.answer == 'fail') {
            change_captcha('Chars');
            //displayPrompt('#formID_waitdialog', data.msg, data.answer, false);
            toast(data.msg, 4000)
		} else if(data.answer == 'correct') {
            //closePromt('#formID_waitdialog');
            clearForm('formID');            
	    	//$("#registrySuccess_dialog > .main_iframe").html( data.msg );
            //openModal('registrySuccess_dialog', 750, 540);
            toast(data.msg, 4000)
        }
    }
}

function errorResponse(data){
    //closeOverlay();
	//displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
    toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000)
}
