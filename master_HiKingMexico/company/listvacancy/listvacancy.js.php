<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var STATE_RENEW					= 'renewpublication';var tagId = '';
$(document.body).ready(function(){	  	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',			
			params:[{name:'opt', value: 'getList'}],			singleSelect:true,			colModel : [							{display: '<?php   echo  $STR['Edit'];  ?>', name : 'edit', width : 90, sortable : false, align: 'center'},								{display: '<?php   echo  $STR['ViewPostulations'];  ?>', name : 'view', width : 100, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Renew'];  ?>', name : 'renew', width : 100, sortable : false, align: 'center'},
				{display: '<?php   echo  $STR['Status'];  ?>', name : 'status', width : 100, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['PublicationDate'];  ?>', name : 'date', width :120, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['VacancyName'];  ?>', name : 'name', width : 280, sortable : false, align: 'left'},								{display: '<?php   echo  $STR['ShowPostulations'];  ?>', name : 'postulations', width : 60, sortable : false, align: 'left'}				],						sortname: "",
			sortorder: "",			usepager: true,			title: '<?php   echo  $STR['PublicatedVacancies'];  ?>',			useRp: false,			rp: 25,			showTableToggleBtn: false,			
			height: 500	});	$('#tblRecorded').on('click', 'tr[id*="row"]', function()	{
		id = $(this).attr('id').substr(3);		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);	});
	$('img[id^="edit"]').live("click", function(e)	{				if(getSelectedRow()!= -1)	    {			top.location.href="<?php   echo  $php_self; ?>?page=updvacancy&vcn="+getSelectedRow();	    }
	});	$('img[id^="renew"]').live("click", function(e)	{				if(getSelectedRow()!= -1)	    {
	    	tagId = $(this).attr('id');			renewPublication();	    }	});
	$('img[id^="view"]').live("click", function(e)	{		if(getSelectedRow()!= -1)	    {			top.location.href="<?php   echo  $php_self; ?>?page=postulation&vcn="+getSelectedRow();	    }
	});	$('img[id^="revert_"]').hide();	$('img[id^="revert_"]').live("click", function(e)	{
		$('#search').val('');		flexReload();		$(this).hide();	    	});	$('#btnFindValue').live("click", function(e)
	{		$('img[id^="revert_"]').show();		flexReload();		return false;	});
});function renewPublication(){	var params = 
	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',	    data: 			{ 'opt': STATE_RENEW, 'selectedRowID':getSelectedRow()}	};	
	setAjaxRemoteRequest(params);}function flexReload(){
		var findValue = $('#search').val();				$('#tblRecorded').flexOptions({params:[{name:'opt', value: 'getList'}, {name:'findValue', value: findValue }], newp: 1 }).flexReload();		}function showRequest(formData, jqForm, options) {   
		openOverlay();			displayPrompt('#'+tagId, '', 'wait_progress', false);    return true; } 
function showResponse(data)  {	closeOverlay();	if(isBlank(data))
	{		displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;	}	if(data.state == STATE_RENEW)
	{		displayPrompt('#'+tagId, data.msg, data.answer, true);		$('#tblRecorded').flexReload();	}
}function errorResponse(data){	closeOverlay();	closePromt('#'+tagId);
} 
