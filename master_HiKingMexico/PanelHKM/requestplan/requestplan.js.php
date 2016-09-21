<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>$(document.body).ready(function(){	  
	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',						params:[{name:'opt', value: 'getList'}],			singleSelect:true,
			colModel : [							{display: '<?php   echo  $STR['GiveInterviewTracking'];  ?>', name : 'tracking', width : 80, sortable : false, align: 'center'},								{display: '<?php   echo  $STR['CreationDate'];  ?>', name : 'creationdate', width : 150, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['TradeName'];  ?>', name : 'tradename', width : 300, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['AnnualPlanName'];  ?>', name : 'planname', width : 250, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Status'];  ?>', name : 'status', width : 100, sortable : false, align: 'center'}						
				],			sortname: "",			sortorder: "",			usepager: false,			title: '<?php   echo  $STR['RequestAnnualPlan'];  ?>',
			useRp: false,			rp: 15,			showTableToggleBtn: false,						height: 550	});
	$('#tblRecorded').on('click', 'tr[id*="row"]', function()	{		id = $(this).attr('id').substr(3);		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);
	});	$('img[id^="tracking_"]').live("click", function(e)	{		if(getSelectedRow()!= -1)	    {
			top.location.href="<?php   echo  $php_self; ?>?page=companyplan&companyId="+getSelectedRow();        		    }	});});
