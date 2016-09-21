<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var tagId 						= 'AddExpectativeToWork';var STATE_GETRECORDINFO 		= 'getRecordInfo';
var STATE_UPDATE 				= 'update';var STATE_SAVE_EXPTOWORK		= 'saveExpToWork';var STATE_UPDATE_EXPTOWORK 		= 'updateExpToWork';var STATE_DELETE_EXPTOWORK 		= 'deleteExpToWork';
var aArea 		= new ArrayCollection();<?php 	$COMMON->fillArrayCollection('aArea' 		, $QUERY->getWorkArea('ORDER BY a.tx_description')
		, array('id', 'workarea_tx_description')		, array('-1',$STR['SelectArea'])		, true ); ?>$(document.body).ready(function()
{		enableBasicTinyMCE('textarea', 950);	setCurrentState(STATE_SAVE_EXPTOWORK);	fillCombobox('#WorkArea', aArea, {'value':'0', 'label':'1'});
	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',						params:[{name:'opt', value: 'getList'}],			singleSelect:true,
			colModel : [							{display: '<?php   echo  $STR['Edit'];  ?>', name : 'edit', width : 100, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Delete'];  ?>', name : 'delete', width : 100, sortable : false, align: 'center'},												{display: '<?php   echo  $STR['WorkArea'];  ?>', name : 'workarea', width : 640, sortable : false, align: 'center'}								],
			usepager: false,						useRp: false,			rp: 15,			showTableToggleBtn: false,						height: 200	});
	$('#tblRecorded').on('click', 'tr[id*="row"]', function()	{		id = $(this).attr('id').substr(3);		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);
	});	$('img[id^="edit"]').live("click", function(e)	{		if(getSelectedRow()!= -1)
	    {			getRecordInfo();				    }	});	$('img[id^="delete"]').live("click", function(e)
	{				if(getSelectedRow()!= -1)	    {	    	setCurrentState(STATE_DELETE_EXPTOWORK);	    	$('#confirmation_question').html('<div class="cleaner h10"></div><?php   echo  $STR['Msg_Delete_Dialog']; ?><div class="cleaner h30"></div>');			 
			 openModal('confirmation_dialog', 360, 150);		    }	});	$("#AddExpectativeToWork").live("click", function(e)	{
		if(getCurrentState() == STATE_SAVE_EXPTOWORK)			saveExpToWorkRecord();		else if(getCurrentState() == STATE_UPDATE_EXPTOWORK)			updateExpToWorkRecord();    });
    $("#btnSubmit").live("click", function(e)	{					updateRecord();			    });
});function confirmationYes(){	if(getCurrentState() == STATE_DELETE_EXPTOWORK)	{
		deleteExpToWorkRecord();		closeModal();	}}function confirmationNo()
{	closeModal();	setCurrentState(getPrevCurrentState());}function flexReload()
{	$('#tblRecorded').flexOptions({params:[{name:'opt', value: 'getList'}], newp: 1 });	$('#tblRecorded').flexReload();}
function getRecordInfo(){		var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',
		dataType:      	'json',	    data: 			{ 'opt': STATE_GETRECORDINFO, 'selectedRowID':getSelectedRow()}	};		setAjaxRemoteRequest(params);}
function saveExpToWorkRecord(){	tagId 						= 'AddExpectativeToWork';	var params = 
		{			url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',	        beforeSubmit:  	showRequest,	        success:       	showResponse,	 		error:   		errorResponse,	 		type: 			'post',
	 		dataType:      	'json',	        data: 			{ 'opt': STATE_SAVE_EXPTOWORK}	    };		setRemoteRequest('#formID', params);}
function updateExpToWorkRecord(){		tagId 						= 'AddExpectativeToWork';	var params = 
		{			url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',	        beforeSubmit:  	showRequest,	        success:       	showResponse,	 		error:   		errorResponse,	 		type: 			'post',
	 		dataType:      	'json',	        data: 			{ 'opt': STATE_UPDATE_EXPTOWORK, 'selectedRowID':getSelectedRow()}	    };		setRemoteRequest('#formID', params);}
function deleteExpToWorkRecord(){	tagId 						= 'AddExpectativeToWork';	var params = 
	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',	    data: 			{ 'opt': STATE_DELETE_EXPTOWORK, 'selectedRowID':getSelectedRow()}	};
	setAjaxRemoteRequest(params);}function updateRecord()
{		tagId 						= 'formIDExpectatives_waitdialog';		var params = 		{			url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',	        beforeSubmit:  	showRequest,
	        success:       	showResponse,	 		error:   		errorResponse,	 		type: 			'post',	 		dataType:      	'json',	        data: 			{ 'opt': STATE_UPDATE}	    };
		setRemoteRequest('#formIDExpectatives', params);}function setRecordInfo(data){	
	$('#WorkArea').val(data.WorkArea);}
function showRequest(formData, jqForm, options) {   	var WantMoney = $('#WantMoney').val();    WantMoney = (WantMoney.replace("$","")).replace(",","");	if(tagId == 'formIDExpectatives_waitdialog')
	if(WantMoney < <?php   echo  $GLOBAL['salaryOffered'];  ?> || !$.isNumeric(WantMoney) )    {    	displayPrompt('#'+tagId, '<?php   echo  $COMMON->str_replace($STR['SalaryError'], array('{salaryOffered}' => $GLOBAL['salaryOffered']) ) ; ?>', 'fail', false);    	return false;    }
	openOverlay();	displayPrompt('#'+tagId, '', 'wait_progress', false);    return true; } 
function showResponse(data)  { 	closeOverlay();	if(isBlank(data))
	{		displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;	}	if(data.state == STATE_GETRECORDINFO)
	{		setCurrentState(STATE_UPDATE_EXPTOWORK);		setRecordInfo(data);		closePromt('#'+tagId);	}
	if(data.state == STATE_SAVE_EXPTOWORK)	{		if(data.answer == 'fail')		{		}
		else if(data.answer = 'correct')		{			setCurrentState(STATE_SAVE_EXPTOWORK);			flexReload();			clearForm("formID");			}
		displayPrompt('#'+tagId, data.msg, data.answer, false);	}	if(data.state == STATE_UPDATE_EXPTOWORK)
	{		if(data.answer == 'fail')		{		}		else if(data.answer = 'correct')
		{			setCurrentState(STATE_SAVE_EXPTOWORK);			flexReload();			clearForm("formID");		}
		displayPrompt('#'+tagId, data.msg, data.answer, false);	}	if(data.state == STATE_DELETE_EXPTOWORK)	{		setCurrentState(STATE_SAVE_EXPTOWORK);
		flexReload();		clearForm("formID");		displayPrompt('#'+tagId, data.msg, data.answer, false);	}	if(data.state == STATE_UPDATE)
	{				displayPrompt('#'+tagId, data.msg, data.answer, false);	}}
function errorResponse(data){	closeOverlay();	displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);}
