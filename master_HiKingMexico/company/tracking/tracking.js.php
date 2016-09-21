<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>$(document.body).ready(function(){	  
	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',						params:[{name:'opt', value: 'getList'}, {name:'vcn', value: '<?php   echo  $vacancyId; ?>'}],			singleSelect:true,
			colModel : [											{display: '<?php   echo  $STR['GiveInterviewTracking'];  ?>', name : 'view', width : 115, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['PostulationDate'];  ?>', name : 'date', width : 180, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['PostulantName'];  ?>', name : 'postulantname', width :370, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['Status'];  ?>', name : 'status', width : 230, sortable : false, align: 'left'}				],			
			sortname: "",			sortorder: "",			usepager: true,			title: '<?php   echo  $STR['PostulantList'];  ?>',			useRp: false,			rp: 25,
			showTableToggleBtn: false,						height: 500	});	$('#tblRecorded').on('click', 'tr[id*="row"]', function()
	{		id = $(this).attr('id').substr(3);		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);	});
	$('img[id^="view"]').live("click", function(e)	{		if(getSelectedRow()!= -1)	    {			top.location.href="<?php   echo  $php_self; ?>?page=tracking&vcn="+getSelectedRow();
	    }	});});
