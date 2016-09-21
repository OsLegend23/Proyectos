<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var consult 				= 'poorInfo';var tagId 					= 'formID_waitdialog';
var STATE_SENDNOTIFICATION 	= 'sendNotification';var STATE_DELETE 			= 'deletePostulant';var aArea 		= new ArrayCollection();var aStudyArea 	= new ArrayCollection();
<?php 	$COMMON->fillArrayCollection('aArea' 		, $QUERY->getWorkArea('ORDER BY a.tx_description')		, array('id', 'workarea_tx_description')
		, null		, true );	$COMMON->fillArrayCollection('aStudyArea' 		, $QUERY->getStudyArea('WHERE id_studylevel != "9999" ORDER BY tx_description')
		, array('id_studylevel','id','tx_description')		, null		, true); ?>
$(document.body).ready(function(){	  		fillCombobox('#workArea', aArea, {'value':'0', 'label':'1'});	fillCombobox('#studyArea', aStudyArea, {'comboTrigger': '1','value':'1', 'label':'2'});
	$('#studyLevel').live("change", function(e){ 	    		fillCombobox('#studyArea', aStudyArea, {'comboTrigger': $(this).val(),'value':'1', 'label':'2'});	});	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',
			dataType: 'json',						params:[{name:'opt', value: 'getList'}],			singleSelect:true,			colModel : [											{display: '<?php   echo  $STR['SendNotification'];  ?>', name : 'sendNotification', width : 120, sortable : false, align: 'center'},												{display: '<?php   echo  $STR['Delete'];  ?>', name : 'delete', width : 90, sortable : false, align: 'center'},
				{display: '<?php   echo  $STR['PreviewCV'];  ?>', name : 'viewcv', width : 70, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Download'];  ?>', name : 'downloadcv', width : 70, sortable : false, align: 'center'},								{display: '<?php   echo  $STR['PostulantName'];  ?>', name : 'postulantname', width :200, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['User'];  ?>', name : 'email', width :200, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['Status'];  ?>', name : 'status', width : 100, sortable : false, align: 'left'}				],
			sortname: "",			sortorder: "",			usepager: true,			title: '<?php   echo  $STR['PostulantAdmin'];  ?>',			useRp: false,			rp: 25,
			showTableToggleBtn: false,						height: 500	});	$('#poorInfo, #pendingToDelete').live("click", function(e)	{		
		consult = $(this).attr('id');		$('#keyword').val('');		getMenuSelected(consult);		flexReload();				return false;	});
	$('#tblRecorded').on('click', 'tr[id*="row"]', function()	{		id = $(this).attr('id').substr(3);		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);
	});	$('#btnReturn').live("click", function(e)	{		top.location.href="<?php   echo  $php_self; ?>?page=listvacancy";
	});	$('img[id^="tracking_"]').live("click", function(e)	{		if(getSelectedRow()!= -1)	    {
			top.location.href="<?php   echo  $php_self; ?>?page=tracking&ptl="+getSelectedRow();	    }	});	$('img[id^="revert_"]').hide();	$('img[id^="revert_"]').live("click", function(e)
	{		$('#keyword').val('');		$('#'+consult).trigger('click');		flexReload();
		$(this).hide();	    	});	$('#btnFindValue').live("click", function(e)	{		$('img[id^="revert_"]').show();
		flexReload();		return false;	});	$('img[id^="viewcv_"]').live("click", function(e)
	{			if(getSelectedRow()!= -1)	    {						window.open("<?php   echo  $php_self; ?>?page=cvitae&print=yes&ptl="+getSelectedRow());	    }	});
	$('img[id^="notification_"]').live("click", function(e)	{			if(getSelectedRow()!= -1)	    {						setCurrentState(STATE_SENDNOTIFICATION);
	    	$('#confirmation_question').html('<div class="cleaner h10"></div><?php   echo  $STR['SendNotification_Dialog']; ?><div class="cleaner h30"></div>');			 			 openModal('confirmation_dialog', 360, 150);	    }	});
	$('img[id^="download_"]').live("click", function(e)	{					if(getSelectedRow()!= -1)	    {						mWindow = window.open("<?php   echo  $php_self.'view/?ptl='; ?>"+getSelectedRow());	     	mWindow.moveTo(0, 0);
	    }	});	$('img[id^="delete"]').live("click", function(e)	{				if(getSelectedRow()!= -1)
	    {	    	setCurrentState(STATE_DELETE);	    	$('#confirmation_question').html('<div class="cleaner h10"></div><?php   echo  $STR['PostulantScrap_Dialog']; ?><div class="cleaner h30"></div>');			 			 openModal('confirmation_dialog', 360, 150);		    }
	});});function sendNotification(){
	var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',	    data: 			{ 'opt': STATE_SENDNOTIFICATION, 'selectedRowID':getSelectedRow()}
	};	setAjaxRemoteRequest(params);}
function deleteRecord(){	var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',
		dataType:      	'json',	    data: 			{ 'opt': STATE_DELETE, 'selectedRowID':getSelectedRow()}	};	setAjaxRemoteRequest(params);}
function flexReload(){		var keyword 	= $('#keyword').val();				$('#tblRecorded').flexOptions({params:[{name:'opt', value: 'getList'}, 
			{name:'keyword', value: keyword }, 			{name:'consult', value: consult }], newp: 1 }			).flexReload();		}function confirmationYes()
{	if(getCurrentState() == STATE_DELETE)	{		deleteRecord();		closeModal();	}
	if(getCurrentState() == STATE_SENDNOTIFICATION)	{		sendNotification();		closeModal();	}}
function confirmationNo(){	closeModal();	setCurrentState(getPrevCurrentState());}
function showRequest(formData, jqForm, options) {   		openOverlay();	displayPrompt('#'+tagId, '', 'wait_progress', false);
    return true; } function showResponse(data)  { 
	closeOverlay();	if(isBlank(data))	{		displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
		return false;	}	if(data.state == STATE_SENDNOTIFICATION)	{
		flexReload();		displayPrompt('#'+tagId, data.msg, data.answer, false);	}	if(data.state == STATE_DELETE)	{		
		flexReload();				displayPrompt('#'+tagId, data.msg, data.answer, false);	}}
function errorResponse(data){	closeOverlay();	displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);}

