<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var aAnnualPlan 		= new ArrayCollection();var tagId 				= 'formID_waitdialog';
var STATE_GETREQUESTRECORDINFO 		= 'getRequestRecordInfo';var STATE_GETASSIGNEDRECORDINFO 	= 'getAssignedRecordInfo';var STATE_PROCESSREQUESTPLAN		= 'processRequestPlan';var STATE_PROCESSASSIGNEDPLAN		= 'processAssignedPlan';
<?php  	$COMMON->fillArrayCollection('aAnnualPlan' 		, $QUERY->getAnnualPlan("WHERE a.id != '6' ")		, array('id','tx_name','tx_cost', 'nm_posts')		, array('-1',$STR['SelectPlan'])
		, true); ?>$(document.body).ready(function(){	  		 fillCombobox('#plan', aAnnualPlan, {'value':'0', 'label':'1'});
	 $('#plan').live("change", function(e){		if($(this).val() > 0)		{					 $('#annualPosts').val(aAnnualPlan.getItemAt($(this).val())[3]);
			 $('#postsCost').val(aAnnualPlan.getItemAt($(this).val())[2]);		}		return false;	});	$("#tblRequest").flexigrid({
			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',						params:[{name:'opt', value: 'getRequestList'}, {name:'companyId', value: '<?php   echo  $companyId ?>'}],			singleSelect:true,			colModel : [							{display: '<?php   echo  $STR['GiveInterviewTracking'];  ?>', name : 'tracking', width : 80, sortable : false, align: 'center'},				
				{display: '<?php   echo  $STR['CreationDate'];  ?>', name : 'creationdate', width : 150, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['AnnualPlanName'];  ?>', name : 'planname', width : 180, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['AnnualPosts'];  ?>', name : 'posts', width : 100, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['PostsCost'];  ?>', name : 'cost', width : 100, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Description'];  ?>', name : 'description', width : 150, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Status'];  ?>', name : 'status', width : 100, sortable : false, align: 'center'}						
				],			sortname: "",			sortorder: "",			usepager: false,			title: '<?php   echo  $STR['RequestAnnualPlan'];  ?>',
			useRp: false,			rp: 15,			showTableToggleBtn: false,						height: 100	});
	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',						params:[{name:'opt', value: 'getAssignedList'}, {name:'companyId', value: '<?php   echo  $companyId ?>'}],			singleSelect:true,			colModel : [			
				{display: '<?php   echo  $STR['Edit'];  ?>', name : 'edit', width : 80, sortable : false, align: 'center'},								{display: '<?php   echo  $STR['CreationDate'];  ?>', name : 'creationdate', width : 150, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['AnnualPlanName'];  ?>', name : 'planname', width : 180, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['AnnualPosts'];  ?>', name : 'posts', width : 100, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['DateIn'];  ?>', name : 'initialperiod', width : 120, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['DateOut'];  ?>', name : 'periodended', width : 120, sortable : false, align: 'center'},
				{display: '<?php   echo  $STR['Status'];  ?>', name : 'status', width : 100, sortable : false, align: 'center'}										],			sortname: "",			sortorder: "",			usepager: false,
			title: '<?php   echo  $STR['AnnualPlansAssigned'];  ?>',			useRp: false,			rp: 15,			showTableToggleBtn: false,						height: 150	});
	$('#tblRecorded, #tblRequest').on('click', 'tr[id*="row"]', function()	{		id = $(this).attr('id').substr(3);		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);
	});	$('img[id^="tracking_"]').live("click", function(e)	{		if(getSelectedRow()!= -1)
	    {			openDialogPlan('tracking');			return false;  				    }	});
	$('img[id^="edit_"]').live("click", function(e)	{		if(getSelectedRow()!= -1)	    {			openDialogPlan('edit');			return false;  			
	    }	});	$( "#DateIn" ).datepicker({		showButtonPanel: true,		changeMonth: true,
		changeYear: true,        onClose: function( selectedDate )         {        	        $( "#DateOut" ).datepicker( "option", "minDate", selectedDate );			$( "#DateOut" ).datepicker( "option", "yearRange", '<?php   echo  $GLOBAL['date_currentYear'];  ?>:<?php   echo  $GLOBAL['date_currentYear']+3;  ?>' );			$( "#DateOut" ).datepicker( "option", "dateFormat", 'yy-mm-dd' );
      	},      	onSelect: function( selectedDate )         {        	      	}    });
    $("#btnSubmit").live("click", function(e)    {  		    	processAnnualPlan();    });
});function openDialogPlan(dialogMode){	enableDatepicker();
	if(dialogMode == 'edit')	{		$('#requestPlan').hide();
		$('#assignedPlan').show();		$("#legend_formID").html("<h2 style='display: inline-block; margin: 0px 0px 0px 10px;'><?php   echo  $STR['AnnualPlansAssigned'];  ?></h2>");				openModal('dialog_plan', 780, 610);
		getAssignedRecordInfo();		$('#formrow_plan').hide();		$('#formrow_annualPosts').hide();		$('#formrow_postsCost').hide();		$('#formrow_DateIn').hide();
		$('#formrow_DateOut').hide();				$('#formrow_Comment').show();				enableBasicTinyMCE('textarea', 750);	}	else
	{			$('#requestPlan').show();		$('#assignedPlan').hide();		$("#legend_formID").html("<h2 style='display: inline-block; margin: 0px 0px 0px 10px;'><?php   echo  $STR['RequestAnnualPlan'];  ?></h2>");		
		openModal('dialog_plan', 780, 680);		getRequestRecordInfo();		$('#formrow_plan').show();		$('#formrow_annualPosts').show();
		$('#formrow_postsCost').show();		$('#formrow_DateIn').show();		$('#formrow_DateOut').show();		$('#formrow_Comment').hide();	}
}function confirmationYes(){
	if(getCurrentState() == STATE_DELETE)	{		deleteRecord();		closeModal();	}}
function confirmationNo(){	closeModal();	setCurrentState(getPrevCurrentState());}
function flexReload(){	$('#tblRecorded').flexOptions({params:[{name:'opt', value: 'getList'}], newp: 1 });	$('#tblRecorded').flexReload();}
function processAnnualPlan(){	var planTextSelected = '';	if($("#plan").is(":visible"))
		planTextSelected = $("#plan option:selected").text();	var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',        beforeSubmit:  	showRequest,
        success:       	showResponse, 		error:   		errorResponse, 		type: 			'post', 		dataType:      	'json',        data: 			{ 'opt': getCurrentState(), 'selectedRowID':getSelectedRow(), 'companyId': '<?php   echo  $companyId;  ?>', 'planTextSelected': planTextSelected }    };
	setRemoteRequest('#formID', params);}function getRequestRecordInfo(){	
	var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',	    data: 			{ 'opt': STATE_GETREQUESTRECORDINFO, 'selectedRowID':getSelectedRow()}
	};		setAjaxRemoteRequest(params);}function getAssignedRecordInfo()
{		var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',
	    data: 			{ 'opt': STATE_GETASSIGNEDRECORDINFO, 'selectedRowID':getSelectedRow()}	};		setAjaxRemoteRequest(params);}
function setRequestRecordInfo(data){	$('#requestCode,#requestStatus, #requestCreationDate, #requestPlanName, #postsCost, #annualPosts, #requestComment').html('');	$('#requestCode').html(data.id);
	$('#requestStatus').html(data.chstatus);	$('#requestCreationDate').html(data.dtregistry);	$('#requestPlanName').html(data.txname);	$('#cpostsCost').html(data.txcost);	$('#cannualPosts').html(data.txdescription);	$('#requestComment').html(data.txcomment);
	$('#status').val(data.status);	$('#plan').val(data.idplan);	$('#plan').trigger('change');	$('#DateIn').val('<?php   echo  $STR['CurrentDate'];  ?>');	$( "#DateIn" ).datepicker( "option", "minDate", '<?php   echo  $STR['CurrentDate'];  ?>' );
	$( "#DateOut" ).datepicker( "option", "yearRange", '<?php   echo  $GLOBAL['date_currentYear'];  ?>:<?php   echo  $GLOBAL['date_currentYear']+1;  ?>' );	$('#DateOut').val('<?php   echo  date($datefmt,strtotime(date($datefmt, strtotime($GLOBAL['date_currentYear'])) . " +1 year"));  ?>');}function setAssignedRecordInfo(data)
{	$('#assignedCode, #assignedStatus, #assignedCreationDate, #assignedPlanName, #assignedCost, #assignedPosts, #assignedDateIn, #assignedDateOut').html('');	$('#assignedCode').html(data.id);	$('#assignedStatus').html(data.chstatus);	$('#assignedCreationDate').html(data.dtregistry);
	$('#assignedPlanName').html(data.txname);	$('#assignedCost').html(data.txcost);	$('#assignedPosts').html(data.nmposts);	$('#assignedDateIn').html(data.datein);	$('#assignedDateOut').html(data.dateout);
	$('#status').val(data.status);	if(!isBlank(data.admincomment))		$('#Comment').val(data.admincomment);	if(data.status == '<?php   echo  $GLOBAL['plan_outrange']['value'] ?>')	{
		disableFormField('#formID','#status', true);		disableFormField('#formID','#Comment', true);	}}
function showRequest(formData, jqForm, options) {   		openOverlay();	displayPrompt('#'+tagId, '', 'wait_progress', false);    return true; 
} function showResponse(data)  { 	closeOverlay();
	if(isBlank(data))	{		displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;	}
	if(data.state == STATE_GETREQUESTRECORDINFO)	{		setCurrentState(STATE_PROCESSREQUESTPLAN);		setRequestRecordInfo(data);		closePromt('#'+tagId);
	}	if(data.state == STATE_GETASSIGNEDRECORDINFO)	{		setCurrentState(STATE_PROCESSASSIGNEDPLAN);		setAssignedRecordInfo(data);
		closePromt('#'+tagId);	}	if(data.state == STATE_PROCESSASSIGNEDPLAN || data.state == STATE_PROCESSREQUESTPLAN)	{		closeModal();
		$('#tblRequest, #tblRecorded').flexReload();	}	}function errorResponse(data)
{	closeOverlay();	displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);}
