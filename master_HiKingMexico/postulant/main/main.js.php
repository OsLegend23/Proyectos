<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var STATE_UPLOADPHOTO 			= 'uploadphoto';var STATE_UPLOADCVFILE 			= 'uploadCVFile';var STATE_DELETECVFILE 			= 'deleteCVFile';
var STATE_GETSTATUS 			= 'getstatus';var tagId = '';$(document.body).ready(function(){
	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',						params:[{name:'opt', value: 'getList'}],			singleSelect:true,			colModel : [							
				{display: '<?php   echo  $STR['ViewInfo'];  ?>', name : 'postulation', width : 100, sortable : false, align: 'center'},																{display: '<?php   echo  $STR['PublicationDate'];  ?>', name : 'date', width :200, sortable : false, align: 'center'},								{display: '<?php   echo  $STR['VacancyName'];  ?>', name : 'name', width : 400, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['VacancyType'];  ?>', name : 'type', width : 190, sortable : false, align: 'center'}				],						sortname: "",
			sortorder: "",			usepager: true,			title: '<?php   echo  $STR['VacancyListProfile'];  ?>',			useRp: false,			rp: 25,			showTableToggleBtn: false,			
			height: 300	});	$("#tblCVFiles").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',			
			params:[{name:'opt', value: 'getCVList'}],			singleSelect:true,			colModel : [											{display: '<?php   echo  $STR['Delete'];  ?>', name : 'delete', width : 150, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Download'];  ?>', name : 'download', width : 150, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['PublicationDate'];  ?>', name : 'date', width :200, sortable : false, align: 'center'},
				{display: '<?php   echo  $STR['DocumentName'];  ?>', name : 'name', width :340, sortable : false, align: 'center'}				],						sortname: "",			sortorder: "",			usepager: false,						useRp: false,
			rp: 1,			showTableToggleBtn: false,						height: 35	});	$('#tblRecorded, #tblCVFiles').on('click', 'tr[id*="row"]', function()
	{		id = $(this).attr('id').substr(3);		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);	});
	$('img[id^="delete"]').live("click", function(e)	{				if(getSelectedRow()!= -1)	    {			$('#confirmation_question').html('<div class="cleaner h10"></div><?php   echo  $STR['Msg_Delete_Dialog']; ?><div class="cleaner h30"></div>');
			 openModal('confirmation_dialog', 360, 150);	    }	});	$('img[id^="download"]').live("click", function(e)	{			
		if(getSelectedRow()!= -1)	    {						mWindow = window.open("<?php   echo  $php_self.'view/?'.$accountId ?>");	     	mWindow.moveTo(0, 0);	    }	});
	$('img[id^="postulation"]').live("click", function(e)	{					if(getSelectedRow()!= -1)	    {			top.location.href="<?php   echo  $COMMON->getRoot().'vacancy/?vcn='; ?>"+getSelectedRow();
	    }	});	$('#btnAccountData').live("click", function(e){top.location.href="<?php   echo  $php_self.'?page=personal'; ?>";});	$('#btnAcademic').live("click", function(e){top.location.href="<?php   echo  $php_self.'?page=academicstudies'; ?>";});
	$('#btnInformatic').live("click", function(e){top.location.href="<?php   echo  $php_self.'?page=informatic'; ?>";});	$('#btnKnowledge').live("click", function(e){top.location.href="<?php   echo  $php_self.'?page=knowledge'; ?>";});	$('#btnLanguages').live("click", function(e){top.location.href="<?php   echo  $php_self.'?page=languages'; ?>";});	$('#btnJobExperience').live("click", function(e){top.location.href="<?php   echo  $php_self.'?page=laborexperience'; ?>";});	$('#btnExpectatives').live("click", function(e){top.location.href="<?php   echo  $php_self.'?page=expectatives'; ?>";});
	$("#btnUploadPhoto").live("click", function(e)	{					tagId = 'formID_waitdialog';			var filename = $('#formID .archivo').html();
			if( filename.indexOf('Examinar...') == 0)			{				displayPrompt('#'+tagId, '<?php   echo  $STR['NeedSelectFile']; ?>', 'error', false);				return false;			}
			if (filename.indexOf(".exe") >= 0)			{				displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_UploadImageFail_format']; ?>', 'error', false);				return false;			}	
			var params = 			{				url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		        beforeSubmit:  	showRequest,		        success:       	showResponse,		 		error:   		errorResponse,
		 		type: 			'post',		 		dataType:      	'json',		        data: 			{ 'opt': STATE_UPLOADPHOTO}		    };
			setRemoteRequest('#formID', params);	});	$("#btnUploadCVFile").live("click", function(e)	{		
			tagId = 'formCVFilesID_waitdialog';				var filename = $('#formCVFilesID .archivo').html();			if( filename.indexOf('Examinar...') == 0)			{
				displayPrompt('#'+tagId, '<?php   echo  $STR['NeedSelectFile']; ?>', 'error', false);				return false;			}			if (filename.indexOf(".exe") >= 0)			{
				displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_UploadFailFail_format']; ?>', 'error', false);				return false;			}			var params = 			{
				url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		        beforeSubmit:  	showRequest,		        success:       	showResponse,		 		error:   		errorResponse,		 		type: 			'post',		 		dataType:      	'json',
		        data: 			{ 'opt': STATE_UPLOADCVFILE}		    };			setRemoteRequest('#formCVFilesID', params);	});
		getStatus();});
function confirmationYes(){	deleteRecord();	closeModal();}
function confirmationNo(){	closeModal();	}
function deleteRecord(){	var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',
		dataType:      	'json',	    data: 			{ 'opt': STATE_DELETECVFILE, 'selectedRowID':getSelectedRow()}	};	tagId = 'formCVFilesID_waitdialog';	setAjaxRemoteRequest(params);}
function flexReload(tableId, mValue){	$(tableId).flexOptions({params:[{name:'opt', value: mValue}], newp: 1 });	$(tableId).flexReload();}
function getStatus(){	var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',
		type: 			'post',		dataType:      	'json',	    data: 			{ 'opt': STATE_GETSTATUS}	};	tagId = 'btnAccountData';
	setAjaxRemoteRequest(params);}function showRequest(formData, jqForm, options) {   
	if(tagId != 'btnAccountData')	{		openOverlay();			displayPrompt('#'+tagId, '', 'wait_progress', false);	}
    return true; } function showResponse(data)  {	closeOverlay();
	if(isBlank(data))	{		displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;	}
	if(data.state==STATE_UPLOADPHOTO)	{		if(data.answer == 'fail')		{			
			displayPrompt('#'+tagId, data.msg, data.answer, false);		}	    else if(data.answer == 'correct')	    {	    	$('#displayImage').attr('src','<?php   echo  $COMMON->getRoot().$GLOBAL['linkPhotoPostulant'].$accountId.'/'; ?>'+data.photo);	    	$('#formID .archivo').html('Examinar...');
	    	closePromt('#'+tagId);	    		    }		}	if(data.state==STATE_UPLOADCVFILE)	{		
		displayPrompt('#'+tagId, data.msg, data.answer, false);		    if(data.answer == 'correct')	    {	    	$('#formCVFilesID .archivo').html('Examinar...');
			flexReload('#tblCVFiles', 'getCVList');	    }	}	if(data.state==STATE_DELETECVFILE)	{		
		displayPrompt('#'+tagId, data.msg, data.answer, false);			flexReload('#tblCVFiles', 'getCVList');	}
	if(data.state==STATE_GETSTATUS)	{				$('#status_AccountData').html(data.status.AccountData);		$('#status_Academic').html(data.status.Academic);		$('#status_Informatic').html(data.status.Informatic);		$('#status_Knowledge').html(data.status.Knowledge);
		$('#status_Languages').html(data.status.Languages);		$('#status_JobExperience').html(data.status.JobExperience);		$('#status_Expectatives').html(data.status.Expectatives);	}}
function errorResponse(data){	closeOverlay();	closePromt('#'+tagId);} 
