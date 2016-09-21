<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var tagId 			= 'formID_waitdialog';var STATE_GETRECORDINFO = 'getRecordInfo';
var STATE_SAVE 			= 'save';var STATE_UPDATE 		= 'update';var STATE_DELETE 		= 'delete';$(document.body).ready(function(){	
	enableBasicTinyMCE('textarea', 950);	setCurrentState(STATE_SAVE);	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',
			dataType: 'json',						params:[{name:'opt', value: 'getList'}],			singleSelect:true,			colModel : [							{display: '<?php   echo  $STR['Edit'];  ?>', name : 'edit', width : 50, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Delete'];  ?>', name : 'delete', width : 50, sortable : false, align: 'center'},
				{display: '<?php   echo  $STR['Language'];  ?>', name : 'language', width : 355, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['SpeakDomain'];  ?>', name : 'speak', width : 135, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['WriteDomain'];  ?>', name : 'write', width : 135, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['ReadDomain'];  ?>', name : 'read', width : 135, sortable : false, align: 'center'}				],
			sortname: "",			sortorder: "",			usepager: false,			title: '<?php   echo  $STR['LenguageList'];  ?>',			useRp: false,			rp: 15,
			showTableToggleBtn: false,						height: 185	});	$('#tblRecorded').on('click', 'tr[id*="row"]', function()	{
		id = $(this).attr('id').substr(3);		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);	});
	$('img[id^="edit"]').live("click", function(e)	{		if(getSelectedRow()!= -1)	    {			getRecordInfo();				    }
	});	$('img[id^="delete"]').live("click", function(e)	{				if(getSelectedRow()!= -1)	    {
	    	setCurrentState(STATE_DELETE);	    	$('#confirmation_question').html('<div class="cleaner h10"></div><?php   echo  $STR['Msg_Delete_Dialog']; ?><div class="cleaner h30"></div>');			 			 openModal('confirmation_dialog', 360, 150);		    }	});
	$("#btnSubmit").live("click", function(e)	{		if(getCurrentState() == STATE_SAVE)			saveRecord();		else if(getCurrentState() == STATE_UPDATE)
			updateRecord();    });    $("#addNew").live("click", function(e)	{
		setCurrentState(STATE_SAVE);		clearForm("formID");    });});
function confirmationYes(){	if(getCurrentState() == STATE_DELETE)	{		deleteRecord();		closeModal();
	}}function confirmationNo(){	closeModal();
	setCurrentState(getPrevCurrentState());}function flexReload(){	$('#tblRecorded').flexOptions({params:[{name:'opt', value: 'getList'}], newp: 1 });
	$('#tblRecorded').flexReload();}function getRecordInfo(){	
	var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',	    data: 			{ 'opt': STATE_GETRECORDINFO, 'selectedRowID':getSelectedRow()}
	};		setAjaxRemoteRequest(params);}function saveRecord()
{	var params = 		{			url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',	        beforeSubmit:  	showRequest,	        success:       	showResponse,
	 		error:   		errorResponse,	 		type: 			'post',	 		dataType:      	'json',	        data: 			{ 'opt': STATE_SAVE}	    };
		setRemoteRequest('#formID', params);}function updateRecord(){		var params = 
		{			url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',	        beforeSubmit:  	showRequest,	        success:       	showResponse,	 		error:   		errorResponse,	 		type: 			'post',
	 		dataType:      	'json',	        data: 			{ 'opt': STATE_UPDATE, 'selectedRowID':getSelectedRow()}	    };		setRemoteRequest('#formID', params);}
function deleteRecord(){	var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',
		type: 			'post',		dataType:      	'json',	    data: 			{ 'opt': STATE_DELETE, 'selectedRowID':getSelectedRow()}	};	setAjaxRemoteRequest(params);
}function setRecordInfo(data){		$('#Language').val(data.language);	$('#SpeakDomain').val(data.speak);
	$('#ReadDomain').val(data.read);	$('#WriteDomain').val(data.write);		$('#btnSubmit').focus();}
function showRequest(formData, jqForm, options) {   		openOverlay();	displayPrompt('#'+tagId, '', 'wait_progress', false);    return true; } 
function showResponse(data)  { 	closeOverlay();
	if(isBlank(data))	{		displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;	}
	if(data.state == STATE_GETRECORDINFO)	{		setCurrentState(STATE_UPDATE);		setRecordInfo(data);		closePromt('#'+tagId);
	}	if(data.state == STATE_SAVE)	{		if(data.answer == 'fail')		{
		}		else if(data.answer = 'correct')		{			setCurrentState(STATE_SAVE);			flexReload();
			clearForm("formID");			}		displayPrompt('#'+tagId, data.msg, data.answer, false);	}
	if(data.state == STATE_UPDATE)	{		if(data.answer == 'fail')		{
		}		else if(data.answer = 'correct')		{			setCurrentState(STATE_UPDATE);			flexReload();		}
		displayPrompt('#'+tagId, data.msg, data.answer, false);	}	if(data.state == STATE_DELETE)	{
		setCurrentState(STATE_SAVE);		flexReload();		clearForm("formID");		displayPrompt('#'+tagId, data.msg, data.answer, false);	}
}function errorResponse(data){	closeOverlay();	displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
}
