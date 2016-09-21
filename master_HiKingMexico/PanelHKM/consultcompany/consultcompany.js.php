<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>$(document.body).ready(function(){	  
	$("#tblRecorded").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',						params:[{name:'opt', value: 'getList'}],			singleSelect:true,
			colModel : [											{display: '<?php   echo  $STR['SignIn'];  ?>', name : 'signin', width : 70, sortable : false, align: 'center'},								{display: '<?php   echo  $STR['ApplyRegistry'];  ?>', name : 'date', width : 120, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['TradeName'];  ?>', name : 'tradename', width :250, sortable : false, align: 'left'},								{display: '<?php   echo  $STR['Status'];  ?>', name : 'status', width : 170, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['AnnualPlanName'];  ?>', name : 'plan', width : 250, sortable : false, align: 'left'}
				],						sortname: "",			sortorder: "",			usepager: true,			title: '<?php   echo  $STR['CompanyAdmin'];  ?>',			useRp: false,
			rp: 25,			showTableToggleBtn: false,						height: 500	});
	$('#tblRecorded').on('click', 'tr[id*="row"]', function()	{		id = $(this).attr('id').substr(3);		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);
	});	$('img[id^="revert_"]').hide();	$('img[id^="revert_"]').live("click", function(e)	{		$('#search').val('');
		flexReload();		$(this).hide();	    	});	$('#btnFindValue').live("click", function(e)	{
		$('img[id^="revert_"]').show();		flexReload();		return false;	});
	$('img[id^="signin_"]').live("click", function(e)	{			if(getSelectedRow()!= -1)	    {			top.location.href="<?php   echo  $php_self; ?>?page=company&companyId="+getSelectedRow();	    }
	});});function flexReload(){
	var findValue = $('#search').val();			$('#tblRecorded').flexOptions({params:[{name:'opt', value: 'getList'}, {name:'findValue', value: findValue }], newp: 1 }).flexReload();	}
