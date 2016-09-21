<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var STATE_RENEW					= 'renewpublication';var STATE_AUTENTICATE			= 'autenticate';var STATE_VERIFIEDACCOUNT		= 'verifyaccount';
var STATE_CHANGEACCOUNTSTATUS	= 'changeaccountstatus';var tagId 						= 'formID_waitdialog';$(document.body).ready(function(){	  	
	<?php 		if($autenticated)	 echo  'disableButton("#btnEmailAutenticate", true);';		if($verified)		 echo  'disableButton("#btnInfoVerified", true);';	 ?>
	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',						params:[{name:'opt', value: 'getList'}, {name:'companyId', value: '<?php   echo  $companyId;  ?>'}],			singleSelect:true,			colModel : [			
				{display: '<?php   echo  $STR['Edit'];  ?>', name : 'edit', width : 90, sortable : false, align: 'center'},								{display: '<?php   echo  $STR['ViewPostulations'];  ?>', name : 'view', width : 100, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Renew'];  ?>', name : 'renew', width : 100, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Status'];  ?>', name : 'status', width : 100, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['PublicationDate'];  ?>', name : 'date', width :120, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['VacancyName'];  ?>', name : 'name', width : 280, sortable : false, align: 'left'},				
				{display: '<?php   echo  $STR['ShowPostulations'];  ?>', name : 'postulations', width : 60, sortable : false, align: 'left'}				],						sortname: "",			sortorder: "",			usepager: true,			title: '<?php   echo  $STR['PublicatedVacancies'];  ?>',
			useRp: false,			rp: 25,			showTableToggleBtn: false,						height: 500	});
	$('#tblRecorded, #tblRequest').on('click', 'tr[id*="row"]', function()	{		id = $(this).attr('id').substr(3);		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);
	});	$('img[id^="revert_"]').hide();	$('img[id^="revert_"]').live("click", function(e)	{		$('#search').val('');
		flexReload();		$(this).hide();	    	});	$('#btnFindValue').live("click", function(e)	{
		$('img[id^="revert_"]').show();		flexReload();		return false;	});
	$('#btnEmailAutenticate').live("click", function(e)	{		setCurrentState(STATE_AUTENTICATE);		getAccountAction();		$('#divEmailAutenticate').html('<img src="<?php   echo  $COMMON->getRoot(); ?>media/icon/wait.gif">');		return false;
	});	$('#btnInfoVerified').live("click", function(e)	{		setCurrentState(STATE_VERIFIEDACCOUNT);		getAccountAction();
		$('#divInfoVerified').html('<img src="<?php   echo  $COMMON->getRoot(); ?>media/icon/wait.gif">');		return false;	});	$('#btnChangeStatus').live("click", function(e)	{
		setCurrentState(STATE_CHANGEACCOUNTSTATUS);		getAccountAction();		$('#divChangeStatus').html('<img src="<?php   echo  $COMMON->getRoot(); ?>media/icon/wait.gif">');		return false;	});
	$('img[id^="edit"]').live("click", function(e)	{		
		if(getSelectedRow()!= -1)	    {			top.location.href="<?php   echo  $php_self; ?>?page=updvacancy&vcn="+getSelectedRow()+"&companyId=<?php   echo  $companyId;  ?>";	    }	});
	$('img[id^="view"]').live("click", function(e)	{		if(getSelectedRow()!= -1)	    {			top.location.href="<?php   echo  $php_self; ?>?page=postulation&vcn="+getSelectedRow()+"&companyId=<?php   echo  $companyId;  ?>";	    }
	});	$('#btnAddVacancy').live("click", function(e)	{		top.location.href="<?php   echo  $php_self.'?page=addvacancy&companyId='.$companyId; ?>";	    	   	});
	$('#btnCompanyActualPlan').live("click", function(e)	{		top.location.href="<?php   echo  $php_self.'?page=companyplan&companyId='.$companyId; ?>";	    	    	});
	$('img[id^="renew"]').live("click", function(e)	{				if(getSelectedRow()!= -1)	    {	    	tagId = $(this).attr('id');
			renewPublication();	    }	});});
function flexReload(){	var findValue = $('#search').val();		$('#tblRecorded').flexOptions({params:[{name:'opt', value: 'getList'}, {name:'companyId', value: '<?php   echo  $companyId;  ?>'}, {name:'findValue', value: findValue }], newp: 1 }).flexReload();		}
function renewPublication(){	setCurrentState(STATE_RENEW);	var params = 	{
		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',	    data: 			{ 'opt': getCurrentState(), 'selectedRowID':getSelectedRow(), 'companyId':'<?php   echo  $companyId;  ?>'}	};
	setAjaxRemoteRequest(params);}function getAccountAction()
{	var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',
	    data: 			{ 'opt': getCurrentState(), 'selectedRowID':getSelectedRow(), 'companyId':'<?php   echo  $companyId;  ?>'}	};		setAjaxRemoteRequest(params);}
function showRequest(formData, jqForm, options) {   	if(getCurrentState() == STATE_RENEW)		{
		openOverlay();		displayPrompt('#'+tagId, '', 'wait_progress', false);	}    return true; } 
function showResponse(data)  {	closeOverlay();	if(isBlank(data))
	{		displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;	}	if(data.state == STATE_RENEW)
	{		displayPrompt('#'+tagId, data.msg, data.answer, true);		$('#tblRecorded').flexReload();	}	if(data.state == STATE_AUTENTICATE)
	{		$('#divEmailAutenticate').html('<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnEmailAutenticate" style="display: inline-block; cursor: pointer; width:240px; height:35px; text-align:center; margin:3px 5px 3px 3px; float:left;"><?php   echo  $STR['Autentication_success']; ?></button>');		disableButton("#btnEmailAutenticate", true);		$( ".btn-large waves-effect waves-light deep-purple darken-4" ).button();	}
	if(data.state == STATE_VERIFIEDACCOUNT)	{		$('#divInfoVerified').html('<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnInfoVerified" style="display: inline-block; cursor: pointer; width:240px; height:35px; text-align:center; margin:3px 5px 3px 3px; float:left;"><?php   echo  $STR['Verificated_success']; ?></button>');		disableButton("#btnInfoVerified", true);		$( ".btn-large waves-effect waves-light deep-purple darken-4" ).button();
	}	if(data.state == STATE_CHANGEACCOUNTSTATUS)	{		$('#divChangeStatus').html('<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnChangeStatus" style="display: inline-block; cursor: pointer; width:240px; height:35px; text-align:center; margin:3px 5px 3px 3px; float:left;">'+data.msg+'</button>');		$( ".btn-large waves-effect waves-light deep-purple darken-4" ).button();
	}
}function errorResponse(data){	closeOverlay();	closePromt('#'+tagId);
} 
