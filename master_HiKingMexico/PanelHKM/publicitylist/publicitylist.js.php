<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var aSortPublicityList 			= new ArrayCollection();var tagId 						= 'formID_waitdialog';
var STATE_GETSORTABLELIST 		= 'getsortablelist';var STATE_SAVESORTABLELIST		= 'savesortablelist';
$(document.body).ready(function(){	  	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',			
			params:[{name:'opt', value: 'getList'}, {name:'status', value: 'A'}],			singleSelect:true,			colModel : [							{display: '<?php   echo  $STR['Edit'];  ?>', name : 'edit', width : 100, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Order'];  ?>', name : 'order', width : 50, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Publicity'];  ?>', name : 'publicity', width : 290, sortable : false, align: 'center'},
				{display: '<?php   echo  $STR['Name'];  ?>', name : 'name', width : 220, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Period'];  ?>', name : 'Period', width : 120, sortable : false, align: 'center'},								{display: '<?php   echo  $STR['Status'];  ?>', name : 'status', width : 100, sortable : false, align: 'center'}				],			sortname: "",
			sortorder: "",			usepager: false,			title: '<?php   echo  $STR['ListPublicity'];  ?>',			useRp: false,			rp: 15,			showTableToggleBtn: false,			
			height: 550	});	$('#tblRecorded').on('click', 'tr[id*="row"]', function()	{		id = $(this).attr('id').substr(3);
		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);	});	$('img[id^="edit_"]').live("click", function(e)
	{		if(getSelectedRow()!= -1)	    {			top.location.href="<?php   echo  $php_self; ?>?page=publicity&publicityid="+getSelectedRow();        		    }	});
	$('#btnAddPublicity').live("click", function(e)	{		top.location.href="<?php   echo  $php_self.'?page=publicity'; ?>";	    	   	});
	$('#btnShowEnablePublicity').live("click", function(e)	{		flexReload('<?php   echo  $GLOBAL['status_enable']['value']; ?>');			});	$('#btnShowFinishedPublicity').live("click", function(e)
	{		flexReload('<?php   echo  $GLOBAL['status_finished']['value']; ?>');	});	$('#btnSortEnablePublicity').live("click", function(e)	{
		openModal('dialog_sort', 600, 540);		getSortableList();	});	$('#btnSaveSort').live("click", function(e)	{		
		saveSortableList();	});});function flexReload(status){
	$('#tblRecorded').flexOptions({params:[{name:'opt', value: 'getList'}, {name:'status', value: status }], newp: 1 }).flexReload();	}function getSortableList(){		$('#sortable').html('<img src="<?php   echo  $COMMON->getMedia('icon', 'wait.gif'); ?>">');
	var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',
	    data: 			{ 'opt': STATE_GETSORTABLELIST}	};		setAjaxRemoteRequest(params);}
function setSortableList(data){	$( "#sortable" ).sortable();    $( "#sortable" ).disableSelection();
	$('#sortable').html('');		aSortPublicityList.removeAll();	$.each(data, function(index, array)	{		if(array != 'getsortablelist')
		{				aSortPublicityList.addItem(array['id']);				$('#sortable').append('<li class="ui-state-default" id="'+array['id']+'"><span class="ui-icon ui-icon-arrowthick-2-n-s" ></span>'+array['publicity']+'</li>');		}	});
}function saveSortableList(){	var params = 	{
		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',	    data: 			{ 'opt': STATE_SAVESORTABLELIST, 'sort':$( "#sortable" ).sortable( "toArray" ).join(', ')}	};	
	setAjaxRemoteRequest(params);}function showRequest(formData, jqForm, options) {   	
	displayPrompt('#'+tagId, '', 'wait_progress', false);    return true; } 
function showResponse(data)  { 	closeOverlay();	if(isBlank(data))	{
		displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;	}	if(data.state == STATE_GETSORTABLELIST)	{
		setSortableList(data);	}	if(data.state == STATE_SAVESORTABLELIST)	{		closeModal();
		flexReload('<?php   echo  $GLOBAL['status_enable']['value']; ?>');	}}function errorResponse(data)
{		displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);}
