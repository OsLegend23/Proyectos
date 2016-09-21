<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>
    
var aCountry 	= new ArrayCollection();
var aState 		= new ArrayCollection();
var aArea 		= new ArrayCollection();
var aStudyArea 	= new ArrayCollection();
<?php 	
$COMMON->fillArrayCollection('aState',
                             $QUERY->getState('ORDER BY tx_state ASC'),
                             array('id_country','id','tx_state'),
                             null,
                             true
                            );
$COMMON->fillArrayCollection('aArea' ,
                             $QUERY->getWorkArea('ORDER BY a.tx_description'),
                             array('id', 'workarea_tx_description'),
                             null,
                             true
                            );
$COMMON->fillArrayCollection('aStudyArea' ,
                             $QUERY->getStudyArea('WHERE id_studylevel != "9999" ORDER BY tx_description'),
                             array('id_studylevel','id','tx_description'), 
                             null,
                             true);
?>

var STATE_POSTULANTREGISTER			= 'postulantRegister';

$(document.body).ready(function() {
    
    //enableDatepicker();
    fillCombobox('#State', aState, {'comboTrigger':'134', 'select':'2','value':'1', 'label':'2'});
	fillCombobox('#WorkArea', aArea, {'value':'0', 'label':'1'});
    fillCombobox('#StudyArea', aStudyArea, {'comboTrigger': '3','value':'1', 'label':'2'});
    
    $('#StudyLevel').live("change", function(e)	{
        var studylevel = $(this).val() >= 3 ? 3: $(this).val();
        fillCombobox('#StudyArea', aStudyArea, {'comboTrigger': studylevel,'value':'1', 'label':'2'});
    });
    
	$('#FirstJob').live("change", function(e) {
        disableFormField('#formID', '#WorkArea, #JobTitle, #DateInstrYear, #DateOutstrYear', false);
        if($(this).val() == 'S')
            disableFormField('#formID', '#WorkArea, #JobTitle, #DateInstrYear, #DateOutstrYear', true);
	});
    
    $("#termsAndConditions").live("click", function(e) {
        $('#AceptPolitics').attr('checked', true);
	});
    
    $("#btnPostulate").live("click", function(e) {
        var params = 
        {
            url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',
            beforeSubmit:  	showRequest,
            success:       	showResponse,
            error:   		errorResponse,
            type: 			'post',
            dataType:      	'json',
            data: 			{ 'opt': STATE_POSTULANTREGISTER}
        };
        
        setRemoteRequest('#formID', params);
    });
    
    $("#btnGoToAdmin").live("click", function(e) {
        top.location.href="<?php   echo  $COMMON->getRoot(); ?>postulant/";
    });
});

function showRequest(formData, jqForm, options) {
    
    if ($('input[id=FirstJob]:checked', '#formID').val() == 'N') {
        var DateInstrYear = $('#DateInstrYear').val();
        var DateOutstrYear = $('#DateOutstrYear').val();
        if( DateOutstrYear < DateInstrYear)	{
            toast('<?php   echo  $STR['Msg_DateJobExperienceError']; ?>', 4000);
            //displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_DateJobExperienceError']; ?>', 'error', false);
			return false;
        }
    }
    //openOverlay();
	//displayPrompt('#formID_waitdialog', '', 'wait_progress', false);
    toast('Enviando...', 4000);
    return true; 
}

function showResponse(data) {
    //closeOverlay();
    
    if(isBlank(data)) {
        //displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
        toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000);
		return false;
    }
    
    if(data.state == STATE_POSTULANTREGISTER) {
        if(data.answer == 'fail') {
            change_captcha('Chars');
            //displayPrompt('#formID_waitdialog', data.msg, data.answer, false);
            toast(data.msg, 4000);
        } else if(data.answer == 'correct')	{
            //closePromt('#formID_waitdialog');
            clearForm('formID');
            //$("#registrySuccess_dialog > .main_iframe").html( data.msg );
            //openModal('registrySuccess_dialog', 750, 540);
            toast(data.msg, 4000);
        }
    }
}

function errorResponse(data){
    //closeOverlay();
    //displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
    toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000);
}
