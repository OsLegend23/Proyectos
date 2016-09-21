<?php
/*
/main/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

?>        
<div class="cleaner h10"></div>
        
<div id="templatemo_main">
	<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnAddPublicity" style='display: inline-block; cursor: pointer; width:200px; height:35px; text-align:center; margin:3px 5px 3px 3px; float:right;'><?php echo $STR['AddPublicity'];?></button>
	
	<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnShowEnablePublicity" style='display: inline-block; cursor: pointer; width:200px; height:35px; text-align:center; margin:3px 5px 3px 3px; float:left;'><?php echo $STR['ShowEnablePublicity'];?></button>
	<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnShowFinishedPublicity" style='display: inline-block; cursor: pointer; width:200px; height:35px; text-align:center; margin:3px 5px 3px 3px; float:left;'><?php echo $STR['ShowFinishedPublicity'];?></button>
	<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnSortEnablePublicity" style='display: inline-block; cursor: pointer; width:240px; height:35px; text-align:center; margin:3px 5px 3px 3px; float:left;'><?php echo $STR['SortEnablePublicity'];?></button>	

    <div class="cleaner h10"></div>	
	<table id="tblRecorded"></table>
</div> <!-- end of main -->
<div class="cleaner h40"></div>

<div id="dialog_sort" style="display: none;">
		<h4><?php echo $STR['SortEnablePublicity'];?></h4>
		<div class="vcn_iframe ui-widget-content  ui-corner-all"  style="height:400px;">
		
			<ul id="sortable">
				  		
			</ul>

		</div>
	    <div class="ui-corner-all" style="text-align:right; padding: 5px;">
            <fieldset class='formActionButtons ui-widget ui-corner-all'>
                <div id='msessage_share' style='width:50%; float:left; display:inline-block;'></div>
                <button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnSaveSort" style='display: inline-block; cursor: pointer; width:150px; height:45px; text-align:center;'><?php echo $STR['Save'].' '.$STR['Order'];?></button>
            </filedset>                
        </div>
</div>