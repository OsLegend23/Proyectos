<?php
/*
/main/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

?>
<br/>
        
<div class="container section no-pad-bot">
    
    <div class="row">
        <div id="" class="card col l12 s12 white">
            <?php $gForm->show();?>
            <br/>
        </div>
    </div>
		
    <div class="card col l12 s12 white" style="width:100%; height:40px; text-align: center; padding:7px 0px 5px 0px; margin-top: -20px;">
		<a id="prev" class="prev_paginator" href="#"></a>
		<div class="list_paginator" style="display:inline-block;"></div>
		<a id="next" class="next_paginator" href="#"></a>
	</div>
	
    <div class="cleaner h30"></div>
    <div class="row">
        <div class="" id="vacancyRequestList"></div> 
    </div>
    <div class="cleaner h30"></div>
    
    <div class="card col l12 s12 white" style="width:100%; height:40px; text-align: center; padding:7px 0px 5px 0px; margin-top: -20px;">
		<a id="prev2" class="prev_paginator" href="#"></a>
		<div class="list_paginator" style="display:inline-block;"></div>
		<a id="next2" class="next_paginator" href="#"></a>
	</div>
    
</div> <!-- end of main -->
<div class="cleaner h40"></div>