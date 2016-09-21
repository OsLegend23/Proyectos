<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var tagId 			= 'formID_waitdialog';var STATE_GETRECORDINFO = 'getRecordInfo';
var STATE_SAVE 			= 'save';var STATE_UPDATE 		= 'update';var STATE_DELETE 		= 'delete';var aArea 		= new ArrayCollection();<?php 
	$COMMON->fillArrayCollection('aArea' 		, $QUERY->getWorkArea('ORDER BY a.tx_description')		, array('id', 'workarea_tx_description')		, array('-1',$STR['SelectArea'])		, true );
 ?>$(document.body).ready(function(){		enableBasicTinyMCE('textarea', 950);
	setCurrentState(STATE_SAVE);	fillCombobox('#WorkArea', aArea, {'value':'0', 'label':'1'});	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',
			dataType: 'json',						params:[{name:'opt', value: 'getList'}],			singleSelect:true,			colModel : [							{display: '<?php   echo  $STR['Edit'];  ?>', name : 'edit', width : 40, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Delete'];  ?>', name : 'delete', width : 40, sortable : false, align: 'center'},
				{display: '<?php   echo  $STR['TradeName'];  ?>', name : 'companyname', width : 400, sortable : false, align: 'center'},								{display: '<?php   echo  $STR['WorkArea'];  ?>', name : 'workarea', width : 190, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['WorkPeriod'];  ?>', name : 'labortime', width : 210, sortable : false, align: 'center'}				],			sortname: "",			sortorder: "",
			usepager: false,			title: '<?php   echo  $STR['LaborExperienceList'];  ?>',			useRp: false,			rp: 15,			showTableToggleBtn: false,			height: 185
	});	$('#tblRecorded').on('click', 'tr[id*="row"]', function()	{		id = $(this).attr('id').substr(3);		rowID =	id != getSelectedRow()? id : getSelectedRow();
		setSelectedRow(rowID);	});	$('img[id^="edit"]').live("click", function(e)	{
		if(getSelectedRow()!= -1)	    {			getRecordInfo();				    }	});
	$('img[id^="delete"]').live("click", function(e)	{				if(getSelectedRow()!= -1)	    {	    	setCurrentState(STATE_DELETE);
	    	$('#confirmation_question').html('<div class="cleaner h10"></div><?php   echo  $STR['Msg_Delete_Dialog']; ?><div class="cleaner h30"></div>');			 			 openModal('confirmation_dialog', 360, 150);		    }	});	$("#btnSubmit").live("click", function(e)
	{		if(getCurrentState() == STATE_SAVE)			saveRecord();		else if(getCurrentState() == STATE_UPDATE)			updateRecord();
    });    $("#addNew").live("click", function(e)	{		setCurrentState(STATE_SAVE);		clearForm("formID");
    });    $("#ActualWork").live("change", function(e)	{				isActualWork($(this).val());					})
});function confirmationYes(){	if(getCurrentState() == STATE_DELETE)
	{		deleteRecord();		closeModal();	}}
function confirmationNo(){	closeModal();	setCurrentState(getPrevCurrentState());}
function flexReload(){	$('#tblRecorded').flexOptions({params:[{name:'opt', value: 'getList'}], newp: 1 });	$('#tblRecorded').flexReload();}
function getRecordInfo(){		var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',
		type: 			'post',		dataType:      	'json',	    data: 			{ 'opt': STATE_GETRECORDINFO, 'selectedRowID':getSelectedRow()}	};		setAjaxRemoteRequest(params);
}function saveRecord(){	var params = 		{
			url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',	        beforeSubmit:  	showRequest,	        success:       	showResponse,	 		error:   		errorResponse,	 		type: 			'post',	 		dataType:      	'json',
	        data: 			{ 'opt': STATE_SAVE}	    };		setRemoteRequest('#formID', params);}
function updateRecord(){		var params = 		{			url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',	        beforeSubmit:  	showRequest,
	        success:       	showResponse,	 		error:   		errorResponse,	 		type: 			'post',	 		dataType:      	'json',	        data: 			{ 'opt': STATE_UPDATE, 'selectedRowID':getSelectedRow()}	    };
		setRemoteRequest('#formID', params);}function deleteRecord(){
	var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',	    data: 			{ 'opt': STATE_DELETE, 'selectedRowID':getSelectedRow()}
	};	setAjaxRemoteRequest(params);}function setRecordInfo(data)
{		$('#TradeName').val(data.TradeName);		$('#Salary').val(data.Salary);	$('#WorkArea').val(data.WorkArea);	$('#JobTitle').val(data.JobTitle);	$('#HierarchyLevel').val(data.HierarchyLevel);
	if(!isBlank(data.ActualWork))	$("[name=ActualWork]").filter("[value="+data.ActualWork+"]").attr("checked","checked");	$('#DateInstrMonth').val(data.DateInstrMonth);	$('#DateInstrYear').val(data.DateInstrYear);
	$('#DateOutstrMonth').val(data.DateOutstrMonth);	$('#DateOutstrYear').val(data.DateOutstrYear);	if(!isBlank(data.ActualWork))		isActualWork(data.ActualWork);
	if(!isBlank(data.ActivityDetail))	$('#ActivityDetail').val(data.ActivityDetail);	$('#btnSubmit').focus();}
function isActualWork(value){	if(value == 'S')	{		$('#DateOutstrMonth').val(-1);
		$('#DateOutstrYear').val(-1);		$('#DateOutstrMonth').attr("disabled",true);		$('#DateOutstrYear').attr("disabled",true);	}	else	{
		$("#DateOutstrMonth").removeAttr("disabled");		$("#DateOutstrYear").removeAttr("disabled");	}}function showRequest(formData, jqForm, options) 
{   		var Salary = $('#Salary').val();    Salary = (Salary.replace("$","")).replace(",","");
    if(getCurrentState() != STATE_GETRECORDINFO)	if(Salary < <?php   echo  $GLOBAL['salaryOffered'];  ?> || !$.isNumeric(Salary) )    {    	displayPrompt('#formID_waitdialog', '<?php   echo  $COMMON->str_replace($STR['SalaryError'], array('{salaryOffered}' => $GLOBAL['salaryOffered']) ) ; ?>', 'fail', false);       	return false;    }
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

