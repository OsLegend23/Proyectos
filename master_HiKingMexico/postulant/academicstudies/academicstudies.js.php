<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var aStudyArea 	= new ArrayCollection();var tagId = '';
var tagId 			= 'formID_waitdialog';var STATE_GETRECORDINFO = 'getRecordInfo';var STATE_SAVE 			= 'save';var STATE_UPDATE 		= 'update';var STATE_DELETE 		= 'delete';<?php 
	$COMMON->fillArrayCollection('aStudyArea' 		, $QUERY->getStudyArea('WHERE id_studylevel != "9999" ORDER BY tx_description')		, array('id_studylevel','id','tx_description')		, array('9999','-1',$STR['SelectStudyArea'])		, true);
 ?>$(document.body).ready(function(){		enableBasicTinyMCE('textarea', 950);	setCurrentState(STATE_SAVE);
	fillCombobox('#StudyArea', aStudyArea, {'comboTrigger': '1','value':'1', 'label':'2'});	studyLevel(1);	$('#StudyLevel').live("change", function(e){		studyLevel($(this).val());
	});	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',						params:[{name:'opt', value: 'getList'}],
			singleSelect:true,			colModel : [							{display: '<?php   echo  $STR['Edit'];  ?>', name : 'edit', width : 30, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Delete'];  ?>', name : 'delete', width : 30, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['InstituteName'];  ?>', name : 'instname', width : 200, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['StudyLevel'];  ?>', name : 'level', width :120, sortable : false, align: 'center'},
				{display: '<?php   echo  $STR['StudyArea'];  ?>', name : 'area', width : 190, sortable : false, align: 'center'},								{display: '<?php   echo  $STR['ActualStatus'];  ?>', name : 'status', width : 70, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['StudyPeriod'];  ?>', name : 'period', width : 210, sortable : false, align: 'center'}								],			sortname: "",
			sortorder: "",			usepager: false,			title: '<?php   echo  $STR['AcademicStudiesList'];  ?>',			useRp: false,			rp: 15,			showTableToggleBtn: false,			
			height: 185	});	$('#tblRecorded').on('click', 'tr[id*="row"]', function()	{		id = $(this).attr('id').substr(3);
		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);	});	$('img[id^="edit"]').live("click", function(e)
	{		if(getSelectedRow()!= -1)	    {			getRecordInfo();				    }	});
	$('img[id^="delete"]').live("click", function(e)	{				if(getSelectedRow()!= -1)	    {	    	setCurrentState(STATE_DELETE);
	    	$('#confirmation_question').html('<div class="cleaner h10"></div><?php   echo  $STR['Msg_Delete_Dialog']; ?><div class="cleaner h30"></div>');			 			 openModal('confirmation_dialog', 360, 150);		    }	});
	$("#btnSubmit").live("click", function(e)	{		if(getCurrentState() == STATE_SAVE)			saveRecord();		else if(getCurrentState() == STATE_UPDATE)			updateRecord();
    });    $("#addNew").live("click", function(e)	{		setCurrentState(STATE_SAVE);
		clearForm("formID");    });    $("#ActualStatus").live("change", function(e)	{		var status = $(this).val();
		actualStatus(status);    });});
function actualStatus(status){	if(status == 'C')	{
		disableFormField('#formID', '#DateInstrMonth, #DateInstrYear', true);		$('#DateInstrMonth, #DateInstrYear').val(-1);	}else		disableFormField('#formID', '#DateInstrMonth, #DateInstrYear', false);
}function confirmationYes(){	if(getCurrentState() == STATE_DELETE)	{
		deleteRecord();		closeModal();	}}function confirmationNo()
{	closeModal();	setCurrentState(getPrevCurrentState());}function flexReload()
{	$('#tblRecorded').flexOptions({params:[{name:'opt', value: 'getList'}], newp: 1 });	$('#tblRecorded').flexReload();}function studyLevel(level)
{	fillCombobox('#StudyArea', aStudyArea, {'comboTrigger': level,'value':'1', 'label':'2'});	if(level <= 3)	{
		$('#formrow_StudyArea').show();		$('#formrow_Graduate').hide();	}	else	{		$('#formrow_Graduate').show();
		$('#formrow_StudyArea').hide();	}}
function getRecordInfo(){		var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',
		dataType:      	'json',	    data: 			{ 'opt': STATE_GETRECORDINFO, 'selectedRowID':getSelectedRow()}	};		setAjaxRemoteRequest(params);}
function saveRecord(){	var params = 		{			url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',	        beforeSubmit:  	showRequest,
	        success:       	showResponse,	 		error:   		errorResponse,	 		type: 			'post',	 		dataType:      	'json',	        data: 			{ 'opt': STATE_SAVE}	    };
		setRemoteRequest('#formID', params);}function updateRecord(){	
	var params = 		{			url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',	        beforeSubmit:  	showRequest,	        success:       	showResponse,	 		error:   		errorResponse,
	 		type: 			'post',	 		dataType:      	'json',	        data: 			{ 'opt': STATE_UPDATE, 'selectedRowID':getSelectedRow()}	    };		setRemoteRequest('#formID', params);
}function deleteRecord(){	var params = 	{
		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',	    data: 			{ 'opt': STATE_DELETE, 'selectedRowID':getSelectedRow()}	};
	setAjaxRemoteRequest(params);}function setRecordInfo(data){		$('#StudyLevel').val(data.studylevel);
	studyLevel(data.studylevel);	if(data.studylevel <= 3)	{		$('#StudyArea').val(data.studyarea);		$('#Graduate').val('');
	}	else	{		$('#StudyArea').val(-1);		$('#Graduate').val(data.studyarea);		}	
	if(!isBlank(data.status))		$("[name=ActualStatus]").filter("[value="+data.status+"]").attr("checked","checked");
	$('#InstituteName').val(data.institution);	$('#DateInstrMonth').val(data.startdatemonth);	$('#DateInstrYear').val(data.startdateyear);	$('#DateOutstrMonth').val(data.enddatemonth);	$('#DateOutstrYear').val(data.enddateyear);	$('#ClasificationAVG').val(data.average);
	actualStatus(data.status);	if(!isBlank(data.comment))		$('#Comment').val(data.comment);
	$('#btnSubmit').focus();}function showRequest(formData, jqForm, options) {   		
	openOverlay();	displayPrompt('#'+tagId, '', 'wait_progress', false);    return true; } 
function showResponse(data)  { 	closeOverlay();
	if(isBlank(data))	{		displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;	}
	if(data.state == STATE_GETRECORDINFO)	{		setCurrentState(STATE_UPDATE);		setRecordInfo(data);		closePromt('#'+tagId);	}
	if(data.state == STATE_SAVE)	{		if(data.answer == 'fail')		{
		}		else if(data.answer = 'correct')		{			setCurrentState(STATE_SAVE);			flexReload();			clearForm("formID");	
		}		displayPrompt('#'+tagId, data.msg, data.answer, false);	}
	if(data.state == STATE_UPDATE)	{		if(data.answer == 'fail')		{		}
		else if(data.answer = 'correct')		{			setCurrentState(STATE_UPDATE);			flexReload();		}
		displayPrompt('#'+tagId, data.msg, data.answer, false);	}	if(data.state == STATE_DELETE)	{		setCurrentState(STATE_SAVE);
		flexReload();		clearForm("formID");		displayPrompt('#'+tagId, data.msg, data.answer, false);	}}
function errorResponse(data){	closeOverlay();	displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);}

