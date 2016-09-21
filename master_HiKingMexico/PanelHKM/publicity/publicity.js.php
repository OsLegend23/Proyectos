<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var STATE_UPLOADPUBLICITY 			= 'uploadpublicity';var tagId = '';
$(document.body).ready(function(){	  	 enableDatepicker();	 $("#DateIn").val('<?php   echo  $DateIn; ?>');	 $("#DateOut").val('<?php   echo  $DateOut; ?>');
	 enableBasicTinyMCE('textarea', 950);	 $("#btnUploadPublicity").live("click", function(e)	{					tagId = 'formID_waitdialog';
<?php  	if($action == 'insert')	{ ?>			var filename = $('#formID .archivo').html();
			if( filename.indexOf('Examinar...') == 0)			{				displayPrompt('#'+tagId, '<?php   echo  $STR['NeedSelectFile']; ?>', 'error', false);				return false;			}
			if (filename.indexOf(".exe") >= 0)			{				displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_UploadImageFail_format']; ?>', 'error', false);				return false;			}
<?php  	} ?>			var params = 			{
				url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		        beforeSubmit:  	showRequest,		        success:       	showResponse,		 		error:   		errorResponse,		 		type: 			'post',		 		dataType:      	'json',
		        data: 			{ 'opt': STATE_UPLOADPUBLICITY, 'action':'<?php   echo  $action; ?>', 'publicityId':'<?php   echo  $publicityid; ?>'}		    };			setRemoteRequest('#formID', params);
	});	 $( "#DateIn" ).datepicker({		showButtonPanel: true,		changeMonth: true,
		changeYear: true,        onClose: function( selectedDate )         {        	        $( "#DateOut" ).datepicker( "option", "minDate", selectedDate );			$( "#DateOut" ).datepicker( "option", "yearRange", '<?php   echo  $GLOBAL['date_currentYear'];  ?>:<?php   echo  $GLOBAL['date_currentYear']+3;  ?>' );			$( "#DateOut" ).datepicker( "option", "dateFormat", 'yy-mm-dd' );
      	},      	onSelect: function( selectedDate )         {        	      	}    });
	$( "#DateIn" ).datepicker( "option", "minDate", '<?php   echo  $STR['CurrentDate'];  ?>' );	$( "#DateOut" ).datepicker( "option", "yearRange", '<?php   echo  $GLOBAL['date_currentYear'];  ?>:<?php   echo  $GLOBAL['date_currentYear']+5;  ?>' );});
function showRequest(formData, jqForm, options) {   		openOverlay();			displayPrompt('#'+tagId, '', 'wait_progress', false);    return true; 
} function showResponse(data)  {	closeOverlay();
	if(isBlank(data))	{		displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;	}
	if(data.state==STATE_UPLOADPUBLICITY)	{		if(data.answer == 'fail')		{						displayPrompt('#'+tagId, data.msg, data.answer, false);		}
	    else if(data.answer == 'correct')	    {	    	top.location.href="<?php   echo  $php_self; ?>?page=publicitylist";	    	$('#formID .archivo').html('Examinar...');	    	closePromt('#'+tagId);	    	
	    }		}}function errorResponse(data){
	closeOverlay();	closePromt('#'+tagId);} 
