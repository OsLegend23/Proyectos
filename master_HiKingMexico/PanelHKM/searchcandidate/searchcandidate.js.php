<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var consult 				= 'simplequery';var tagId 					= 'formIDLinkToVacancy_waitdialog';
var aArea 					= new ArrayCollection();var aStudyArea 				= new ArrayCollection();var aVacancy 				= new ArrayCollection();var STATE_LINKPOSTULANTTOVACANCY 	= 'linkPostulantToVacancy';
<?php 	$COMMON->fillArrayCollection('aArea' 		, $QUERY->getWorkArea('ORDER BY a.tx_description')		, array('id', 'workarea_tx_description')		, null
		, true );	$COMMON->fillArrayCollection('aStudyArea' 		, $QUERY->getStudyArea('WHERE id_studylevel != "9999" ORDER BY tx_description')		, array('id_studylevel','id','tx_description')
		, null		, true);	$COMMON->fillArrayCollection('aVacancy' 		, $QUERY->searchVacancy("WHERE a.ch_status = '".$GLOBAL['vacancy_enable']['value']."' AND k.nm_status = '".$GLOBAL['user_enable']['value']."' GROUP BY a.id ORDER BY a.dt_update DESC, a.tx_hour DESC")		, array('id', 'tx_name', 'mergeName', 'tx_trademark')
		, array('-1','-1',$STR['SelectVacancy'])		, true); ?>$(document.body).ready(function(){	  
	consultType(consult);	fillCombobox('#workArea', aArea, {'value':'0', 'label':'1'});		fillCombobox('#studyArea', aStudyArea, {'comboTrigger': '1','value':'1', 'label':'2'});
	fillCombobox('#vacancy', aVacancy, {'value':'0', 'label':'2'});	$('#studyLevel').live("change", function(e){ 	    		fillCombobox('#studyArea', aStudyArea, {'comboTrigger': $(this).val(),'value':'1', 'label':'2'});	});
	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',						params:[{name:'opt', value: 'getList'}],			singleSelect:true,			colModel : [							
				{display: '<?php   echo  $STR['Enlace'];  ?>', name : 'enlace', width : 70, sortable : false, align: 'center'},								{display: '<?php   echo  $STR['PreviewCV'];  ?>', name : 'viewcv', width : 70, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Download'];  ?>', name : 'downloadcv', width : 70, sortable : false, align: 'center'},								{display: '<?php   echo  $STR['PostulantName'];  ?>', name : 'postulantname', width :300, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['User'];  ?>', name : 'email', width :235, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['Status'];  ?>', name : 'status', width : 120, sortable : false, align: 'left'}
				],			sortname: "",			sortorder: "",			usepager: true,			title: '<?php   echo  $STR['PostulantAdmin'];  ?>',			useRp: false,
			rp: 25,			showTableToggleBtn: false,						height: 500	});	$('img[id^="postulation_"]').live("click", function(e)
	{		if(getSelectedRow()!= -1)	    {			openModal('linkPostulantToVacancy', '700', '260');		}	});
	$('#vacancy').live("change", function(e)	{ 	    		$value = $(this).val();
		if($value > 0)		{			for (var i = 0; i < aVacancy.size(); i++) 			{							if(aVacancy.getItemAt(i)[0] == $value)					$('#tradename').val(aVacancy.getItemAt(i)[3]);
			};		}		else		{			$('#tradename').val('');		}
		return false;	});
	$('#btnLinkPostulantToVacancy').live("click", function(e)	{		linkPostulantToVacancy();	});
	$('button[class^="flanges"]').live("click", function(e)	{				consult = $(this).attr('id');		getMenuSelected(consult);		consultType(consult);
		return false;	});	$('#tblRecorded').on('click', 'tr[id*="row"]', function()	{		id = $(this).attr('id').substr(3);
		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);	});	$('#btnReturn').live("click", function(e)
	{		top.location.href="<?php   echo  $php_self; ?>?page=listvacancy";	});	$('img[id^="tracking_"]').live("click", function(e)	{
		if(getSelectedRow()!= -1)	    {			top.location.href="<?php   echo  $php_self; ?>?page=tracking&ptl="+getSelectedRow();	    }	});
	$('img[id^="revert_"]').hide();	$('img[id^="revert_"]').live("click", function(e)	{		$('#keyword').val('');		consult = 'simplequery';
		$('#'+consult).trigger('click');		flexReload();		$(this).hide();	    	});
	$('#btnFindValue').live("click", function(e)	{		$('img[id^="revert_"]').show();		flexReload();
		return false;	});	$('img[id^="viewcv_"]').live("click", function(e)	{			if(getSelectedRow()!= -1)
	    {						window.open("<?php   echo  $php_self; ?>?page=cvitae&print=yes&ptl="+getSelectedRow());	    }	});	$('img[id^="signin_"]').live("click", function(e)
	{			if(getSelectedRow()!= -1)	    {						window.open("<?php   echo  $COMMON->getRoot().'postulant/'; ?>?page=main&ptl="+getSelectedRow());	    }	});
	$('img[id^="download_"]').live("click", function(e)	{					if(getSelectedRow()!= -1)	    {						mWindow = window.open("<?php   echo  $php_self.'view/?ptl='; ?>"+getSelectedRow());
	     	mWindow.moveTo(0, 0);	    }	});});
function flexReload(){		var keyword 	= $('#keyword').val();		var workArea 	= $('#workArea').val();		var studyLevel 	= $('#studyLevel').val();		var studyArea 	= $('#studyArea').val();
		$('#tblRecorded').flexOptions({params:[{name:'opt', value: 'getList'}, 			{name:'keyword', value: keyword }, 			{name:'consult', value: consult },			{name:'workArea', value: workArea },			{name:'studyLevel', value: studyLevel },
			{name:'studyArea', value: studyArea }], newp: 1 }			).flexReload();		}function consultType(consult)
{	$('#formrow_keyword').hide();	$('#formrow_workArea').hide();	$('#formrow_studyLevel').hide();	$('#formrow_studyArea').hide();
	if(consult == 'simplequery')	{				$('#formrow_keyword').show();	}	else if(consult == 'experience')
	{			$('#formrow_workArea').show();	}	else if(consult == 'educative')	{				$('#formrow_studyLevel').show();
		$('#formrow_studyArea').show();	}}function linkPostulantToVacancy(){
	var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',        beforeSubmit:  	showRequest,        success:       	showResponse, 		error:   		errorResponse,
 		type: 			'post', 		dataType:      	'json',        data: 			{ 'opt': STATE_LINKPOSTULANTTOVACANCY, 'getSelectedRow':getSelectedRow() }    };	setRemoteRequest('#formIDLinkToVacancy', params);
}function showRequest(formData, jqForm, options) {   		openOverlay();
	displayPrompt('#'+tagId, '', 'wait_progress', false);    return true; } function showResponse(data)  
{ 	closeOverlay();	if(isBlank(data))	{
		displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;	}	if(data.state == STATE_LINKPOSTULANTTOVACANCY)	{
		clearForm("formIDLinkToVacancy");		displayPrompt('#'+tagId, data.msg, data.answer, false);		$('#companyPlanStatus').html(data.msg);	}}
function errorResponse(data){	closeOverlay();	displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);}

