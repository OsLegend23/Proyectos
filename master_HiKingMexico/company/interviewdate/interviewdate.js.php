<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var aVacancies 		= new ArrayCollection();var tagId 			= 'formIDInterviewDate_waitdialog';
var STATE_GETRECORDINFO = 'getRecordInfo';var STATE_SAVE 			= 'save';var STATE_UPDATE 		= 'update';var STATE_DELETE 		= 'delete';
<?php  $COMMON->fillArrayCollection('aVacancies' 		, $QUERY->getVacancy("WHERE a.ch_status = '".$GLOBAL['vacancy_enable']['value']."' AND k.nm_status = '".$GLOBAL['user_enable']['value']."'  AND a.id_company = '".$accountId."' GROUP BY a.id ")		, array('id', 'tx_name')		, array('-1',$STR['DontWantSelectVacancyForInterviewDate'])
		, true ); ?>$(document.body).ready(function(){	
	enableDatepicker();	fillCombobox('#Vacancy', aVacancies, {'value':'0', 'label':'1'});  	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',
			dataType: 'json',						params:[{name:'opt', value: 'getList'}],			singleSelect:true,			colModel : [							{display: '<?php   echo  $STR['GiveInterviewTracking'];  ?>', name : 'preview', width : 60, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Edit'];  ?>', name : 'edit', width : 40, sortable : false, align: 'center'},
				{display: '<?php   echo  $STR['Delete'];  ?>', name : 'delete', width : 40, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Status'];  ?>', name : 'status', width : 100, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['CreationDate'];  ?>', name : 'date', width :140, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['InterviewPeriod'];  ?>', name : 'period', width :210, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['VacancyName'];  ?>', name : 'name', width : 200, sortable : false, align: 'left'},												{display: '<?php   echo  $STR['Postulants'];  ?>', name : 'postulations', width : 60, sortable : false, align: 'left'}
				],						sortname: "",			sortorder: "",			usepager: true,			title: '<?php   echo  $STR['PublicatedVacancies'];  ?>',			useRp: false,
			rp: 25,			showTableToggleBtn: false,						height: 500	});	$('#Vacancy').live("change", function(e){
		if($(this).val() == -1)			$('#VacancyName').val('');		else				$('#VacancyName').val($("#Vacancy option:selected").text());		return false;
	});	$('#tblRecorded').on('click', 'tr[id*="row"]', function()	{		id = $(this).attr('id').substr(3);
		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);	});	$('img[id^="edit"]').live("click", function(e)
	{				if(getSelectedRow()!= -1)	    {			openModal('dialog_addNew_interviewdate', '750', '500');			clearForm("formIDInterviewDate");			getRecordInfo();
	    }	});	$('img[id^="view"]').live("click", function(e)	{		if(getSelectedRow()!= -1)
	    {			top.location.href="<?php   echo  $php_self; ?>?page=postulation&vcn="+getSelectedRow();	    }	});
	$('img[id^="revert_"]').hide();	$('img[id^="revert_"]').live("click", function(e)	{		$('#search').val('');		flexReload();		$(this).hide();	    
	});	$('#btnFindValue').live("click", function(e)	{
		$('img[id^="revert_"]').show();		flexReload();		return false;	});
	$('#btnAddNew').live("click", function(e)	{		openModal('dialog_addNew_interviewdate', '750', '500');		setCurrentState(STATE_SAVE);		disableFormField('#formIDInterviewDate','#Status', true);		clearForm("formIDInterviewDate");
		return false;	});	$('img[id^="delete"]').live("click", function(e)	{				if(getSelectedRow()!= -1)
	    {	    	setCurrentState(STATE_DELETE);	    	$('#confirmation_question').html('<div class="cleaner h10"></div><?php   echo  $STR['Msg_Delete_Dialog']; ?><div class="cleaner h30"></div>');			 			 openModal('confirmation_dialog', 360, 150);		    }
	});	$("#btnSubmit").live("click", function(e)	{		if(getCurrentState() == STATE_SAVE)			saveRecord();
		else if(getCurrentState() == STATE_UPDATE)			updateRecord();    });});
function flexReload(){	var findValue = $('#search').val();	$('#tblRecorded').flexOptions({params:[{name:'opt', value: 'getList'}, {name:'findValue', value: findValue }], newp: 1 });
	$('#tblRecorded').flexReload();}function confirmationYes(){	if(getCurrentState() == STATE_DELETE)
	{		deleteRecord();		closeModal();	}}
function confirmationNo(){	closeModal();	setCurrentState(getPrevCurrentState());}
function getRecordInfo(){		var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',
		dataType:      	'json',	    data: 			{ 'opt': STATE_GETRECORDINFO, 'selectedRowID':getSelectedRow()}	};		setAjaxRemoteRequest(params);}
function saveRecord(){	var params = 		{			url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',
	        beforeSubmit:  	showRequest,	        success:       	showResponse,	 		error:   		errorResponse,	 		type: 			'post',	 		dataType:      	'json',	        data: 			{ 'opt': STATE_SAVE}
	    };		setRemoteRequest('#formIDInterviewDate', params);}function updateRecord()
{		var params = 		{			url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',	        beforeSubmit:  	showRequest,	        success:       	showResponse,
	 		error:   		errorResponse,	 		type: 			'post',	 		dataType:      	'json',	        data: 			{ 'opt': STATE_UPDATE, 'selectedRowID':getSelectedRow()}	    };
		setRemoteRequest('#formIDInterviewDate', params);}function deleteRecord(){	var params = 
	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',	    data: 			{ 'opt': STATE_DELETE, 'selectedRowID':getSelectedRow()}	};
	setAjaxRemoteRequest(params);}function setRecordInfo(data){
	$('#Vacancy').val(data.vacancy);	$('#VacancyName').val(data.vacancyname);	$('#DateIn').val(data.start);	$('#DateOut').val(data.end);			$('#Status').val(data.status);
	disableFormField('#formIDInterviewDate','#Status', false);	$('#btnSubmit').focus();}function showRequest(formData, jqForm, options) 
{   		openOverlay();	displayPrompt('#'+tagId, '', 'wait_progress', false);    return true; } 
function showResponse(data)  { 	closeOverlay();
	if(isBlank(data))	{		displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;	}
	if(data.state == STATE_GETRECORDINFO)	{		setCurrentState(STATE_UPDATE);		setRecordInfo(data);		closePromt('#'+tagId);			}
	if(data.state == STATE_SAVE)	{		if(data.answer == 'fail')		{
		}		else if(data.answer = 'correct')		{			setCurrentState(STATE_SAVE);			closeModal();			flexReload();
		}		displayPrompt('#'+tagId, data.msg, data.answer, false);	}
	if(data.state == STATE_UPDATE)	{		if(data.answer == 'fail')		{
		}		else if(data.answer = 'correct')		{			setCurrentState(STATE_UPDATE);			closeModal();			flexReload();
		}		displayPrompt('#'+tagId, data.msg, data.answer, false);	}	if(data.state == STATE_DELETE)
	{		setCurrentState(STATE_SAVE);		flexReload();		displayPrompt('#'+tagId, data.msg, data.answer, false);	}
}function errorResponse(data){	closeOverlay();	displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
}
