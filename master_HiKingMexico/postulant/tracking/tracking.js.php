<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>$(document.body).ready(function(){	  
	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',						params:[{name:'opt', value: 'getList'}],			singleSelect:true,
			colModel : [											{display: '<?php   echo  $STR['ViewInterviewTracking'];  ?>', name : 'view', width : 100, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['PostulationDate'];  ?>', name : 'postulationDate', width : 180, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Status'];  ?>', name : 'status', width : 150, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['TradeName'];  ?>', name : 'companyName', width : 230, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['VacancyName'];  ?>', name : 'vacancyName', width : 230, sortable : false, align: 'center'}
				],									sortname: "",			sortorder: "",			usepager: true,						useRp: false,			rp: 15,
			showTableToggleBtn: false,						height: 500	});	$('#tblRecorded').on('click', 'tr[id*="row"]', function()
	{		id = $(this).attr('id').substr(3);		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);	});
	$('img[id^="view"]').live("click", function(e)	{		if(getSelectedRow()!= -1)	    {
	    }	});});

