<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var aAnnualPlan 		= new ArrayCollection();var tagId 				= 'formID_waitdialog';
var STATE_GETRECORDINFO = 'getRecordInfo';var STATE_SAVE 			= 'save';var STATE_UPDATE 		= 'update';var STATE_DELETE 		= 'delete';<?php  
	$COMMON->fillArrayCollection('aAnnualPlan' 		, $rGetAnnualPlan		, array('id','tx_name','tx_cost', 'tx_description')		, array('-1',$STR['SelectPlan'])		, true); ?>
$(document.body).ready(function(){	  	 fillCombobox('#plan', aAnnualPlan, {'value':'0', 'label':'1'});
	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',						params:[{name:'opt', value: 'getList'}],			singleSelect:true,			colModel : [			
				{display: '<?php   echo  $STR['Edit'];  ?>', name : 'edit', width : 30, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Delete'];  ?>', name : 'delete', width : 30, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['AnnualPlanName'];  ?>', name : 'planname', width : 200, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['PostsCost'];  ?>', name : 'cost', width :120, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['AnnualPosts'];  ?>', name : 'numposts', width : 190, sortable : false, align: 'center'},								{display: '<?php   echo  $STR['Description'];  ?>', name : 'description', width : 220, sortable : false, align: 'center'},
				{display: '<?php   echo  $STR['AnnualPlanTotalDays'];  ?>', name : 'totaldays', width : 80, sortable : false, align: 'center'}								],			sortname: "",			sortorder: "",			usepager: false,
			title: '<?php   echo  $STR['AnnualPlans'];  ?>',			useRp: false,			rp: 15,			showTableToggleBtn: false,						height: 250	});
	$("#btnSubmit").live("click", function(e)	{		if(getCurrentState() == STATE_SAVE)			saveRecord();
		else if(getCurrentState() == STATE_UPDATE)			updateRecord();    });    $("#addNew").live("click", function(e)
	{		setCurrentState(STATE_SAVE);		clearForm("formID");    });
 	 enableBasicTinyMCE('textarea', 950);   });function confirmationYes(){
	if(getCurrentState() == STATE_DELETE)	{		deleteRecord();		closeModal();	}}
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
{	$('#btnSubmit').focus();	$('#plan').val(data.TradeName);		$('#annualPosts').val(data.Salary);
	$('#postsCost').val(data.WorkArea);	$('#AnnualPlanTotalDays').val(data.JobTitle);	if(!isBlank(data.ActivityDetail))	$('#Description').val(data.HierarchyLevel);
}function showRequest(formData, jqForm, options) {   		openOverlay();
	displayPrompt('#'+tagId, '', 'wait_progress', false);    return true; } function showResponse(data)  
{ 	closeOverlay();	if(isBlank(data))	{
		displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;	}	if(data.state == STATE_GETRECORDINFO)	{
		setCurrentState(STATE_UPDATE);		setRecordInfo(data);		closePromt('#'+tagId);	}	if(data.state == STATE_SAVE)
	{		if(data.answer == 'fail')		{		}		else if(data.answer = 'correct')
		{			setCurrentState(STATE_SAVE);			flexReload();			clearForm("formID");			}
		displayPrompt('#'+tagId, data.msg, data.answer, false);	}	if(data.state == STATE_UPDATE)	{
		if(data.answer == 'fail')		{		}		else if(data.answer = 'correct')		{
			setCurrentState(STATE_UPDATE);			flexReload();		}		displayPrompt('#'+tagId, data.msg, data.answer, false);	}
	if(data.state == STATE_DELETE)	{		setCurrentState(STATE_SAVE);		flexReload();		clearForm("formID");
		displayPrompt('#'+tagId, data.msg, data.answer, false);	}}function errorResponse(data)
{	closeOverlay();	displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);}
