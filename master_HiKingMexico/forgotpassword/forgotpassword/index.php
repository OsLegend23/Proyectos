<?php
/*
/main/index.php
*/
if (!isset($COMMON)) {
    echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";
    die();
}

?>

<br/>

<div id="templatemo_main" class="container section no-pad-bot">
    <div class="row">
        <div class="card col l12 s12 white">
            <?php $gForm->show(); ?>
        </div>
    </div>

    <!-- end of templatemo_middle -->

</div> <!-- end of main -->