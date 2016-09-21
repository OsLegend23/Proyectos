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

<div class="container section no-pad-bot">
    <div class="row">
        <fieldset>
            <legend><h3><?php echo $STR['FrequentlyQuestions']; ?></h3></legend>

            <fieldset>
                <legend><h4><?php echo $STR['FrequentlyQuestions_Generals']; ?></h4></legend>

                <ul class="collapsible" data-collapsible="accordion">
                    <li class="active">
                        <div class="collapsible-header"><i class="mdi-action-help"></i><?php echo $STR['Support_Q1']; ?>
                        </div>
                        <div class="collapsible-body"><?php echo $STR['Support_A1']; ?></div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="mdi-action-help"></i><?php echo $STR['Support_Q2']; ?>
                        </div>
                        <div class="collapsible-body"><?php echo $STR['Support_A2']; ?></div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="mdi-action-help"></i><?php echo $STR['Support_Q3']; ?>
                        </div>
                        <div class="collapsible-body"><?php echo $STR['Support_A3']; ?></div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="mdi-action-help"></i><?php echo $STR['Support_Q4']; ?>
                        </div>
                        <div class="collapsible-body"><?php echo $STR['Support_A4']; ?></div>
                    </li>
                </ul>
            </fieldset>

            <fieldset>
                <legend><h4><?php echo $STR['FrequentlyQuestions_Postulant']; ?></h4></legend>
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><i class="mdi-action-help"></i><?php echo $STR['Support_Q5']; ?>
                        </div>
                        <div class="collapsible-body"><?php echo $STR['Support_A5']; ?></div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="mdi-action-help"></i><?php echo $STR['Support_Q6']; ?>
                        </div>
                        <div class="collapsible-body"><?php echo $STR['Support_A6']; ?></div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="mdi-action-help"></i><?php echo $STR['Support_Q7']; ?>
                        </div>
                        <div class="collapsible-body"><?php echo $STR['Support_A7']; ?></div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="mdi-action-help"></i><?php echo $STR['Support_Q8']; ?>
                        </div>
                        <div class="collapsible-body"><?php echo $STR['Support_A8']; ?></div>
                    </li>
                </ul>
            </fieldset>

            <fieldset>
                <legend><h4><?php echo $STR['FrequentlyQuestions_Company']; ?></h4></legend>
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><i class="mdi-action-help"></i><?php echo $STR['Support_Q9']; ?>
                        </div>
                        <div class="collapsible-body"><?php echo $STR['Support_A9']; ?></div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i
                                class="mdi-action-help"></i><?php echo $STR['Support_Q10']; ?></div>
                        <div class="collapsible-body"><?php echo $STR['Support_A10']; ?></div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i
                                class="mdi-action-help"></i><?php echo $STR['Support_Q11']; ?></div>
                        <div class="collapsible-body"><?php echo $STR['Support_A11']; ?></div>
                    </li>
                </ul>
            </fieldset>
            <br>

            <div style="float: right; margin-bottom: -25px;">
                <a href="#dialog_contact" class="modal-trigger btn-large waves-effect waves-light deep-purple darken-4"
                   id='btnContact' style='display: inline-block; height:45px; line-height: 45px;'>
                    <?php echo $STR['SendYourComments']; ?>
                </a>
            </div>
        </fieldset>
    </div>
</div> <!-- end of main -->

<div id="dialog_contact" class="modal modal-fixed-footer">
    <div class="modal-content">
        <div class="card" id="modalOverlay">
            <?php
            $gForm->show();
            ?>
        </div>
    </div>
    <div class="modal-footer">
        <i class="modal-action modal-close small mdi-navigation-cancel" style="cursor: pointer;"></i>
    </div>
</div>
