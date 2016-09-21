<?php

/*
  Released:	feb-2013
  version: 	3.0.2
  Created by:	david.montijo20@gmail.com
 */

class gForm {

    private $inputs = array();
    private $inputSelected;
    private $nameForm;
    private $methodForm;
    private $actionForm;
    private $alignForm;
    private $status;
    private $buttons = array();
    private $legendForm;
    private $root;
    private $formWidth;
    private $enctype;

    function __construct() {
        $this->alignForm = 'left';
        $this->formWidth = '100%';
        $this->enctype = "application/x-www-form-urlencoded";
    }

    /* Getters***************************************************************************************** */

    public function getField() {
        
    }

    public function getNameForm() {
        return $this->nameForm;
    }

    public function getWidth() {
        return $this->formWidth;
    }

    public function getAlignForm() {
        return $this->alignForm;
    }

    public function getRoot() {
        return $this->root;
    }

    /*public function getWaitLoading($loadingLabel) {
        echo "<div id='div_wait' style='border: 1px dashed #ccc; color: #2f5e9e; background-color: #fff; text-align: center;'><img src='" . $this->getRoot() . "media/icon/wait.gif'> $loadingLabel</div>";
    }*/

    public function getImage($input) {
        $id = $input['ID'];
        $value = $input['VALUE']['0'];
        echo "<div style='border: 1px dashed #ccc; color: #2f5e9e; background-color: #fff; text-align: center;' id='uploadedImage' class='ui-corner-all'><img src='$value' id='$id'></div>";
    }

    public function getHelpBtn($id, $helptxt) {
        if (isset($helptxt))
            return "<img src='" . $this->getRoot() . "media/icon/help.png' id='helpbtn_$id' style='cursor: pointer; '>";
        else
            return "";
    }

    public function getHelpText($id, $helptxt) {

        if (isset($helptxt))
            return "<div id='helptxt_$id' style='display: none; float:left;'>$helptxt</div>";
        else
            return "";
    }

    public function getLoadingIcon($id, $loadingLabel) {
        echo "<div id='div_$id' style='display: inline'> <img src='" . $this->getRoot() . "media/icon/wait.gif'> $loadingLabel </div>";
    }

    public function getTable($input) {
        $id = $input['ID'];
        $label = $input['LABEL'];
        echo "<div id='div_$id' ><table id='$id'></table></div>";
    }

    public function getTextField($input) {
        $id = $input['ID'];
        $label = $input['LABEL'];
        $value = $input['VALUE']['0'];
        $features = $input['FEATURE'];

        echo "<div class='row'><div class='input-field col s12'>
        <label for='$id' id='lbl_$id' class=''>" . $this->getHelpBtn($id, $input['FEATURE']['HELP']) . "$label</label>
        <input type='text' id='$id' name='$id' value='$value' " .
        $this->getFeatures($features) . " data-prompt-position='topRight:-100'/></div></div>" .
        $this->getHelpText($id, $input['FEATURE']['HELP']);
    }

    public function getPassword($input) {
        $id = $input['ID'];
        $label = $input['LABEL'];
        $value = $input['VALUE']['0'];
        $features = $input['FEATURE'];

        echo "<label for='$id' id='lbl_$id' class=''>" . $this->getHelpBtn($id, $input['FEATURE']['HELP']) . "$label</label>"
                . "<input type='password' id='$id' name='$id' value='$value' " .
        $this->getFeatures($features) . " data-prompt-position='topRight:-100' />" .
        $this->getHelpText($id, $input['FEATURE']['HELP']);
    }

    public function getFile($input) {
        $id = $input['ID'];
        $label = $input['LABEL'];
        $value = $input['VALUE']['0'];
        $features = $input['FEATURE'];

        echo "<label for='$id' id='lbl_$id' class=''>" . $this->getHelpBtn($id, $input['FEATURE']['HELP']) . "$label</label>	
			<div class='custom-input-file'>				
				<input type='file' class='input-file' id='$id' name='$id' value='$value'/>			
			    <div class='archivo'>Examinar...</div>
			</div>
		" .
        $this->getHelpText($id, $input['FEATURE']['HELP']);
    }

    public function getTextArea($input) {
        $id = $input['ID'];
        $label = $input['LABEL'];
        $value = $input['VALUE']['0'];
        $features = $input['FEATURE'];
        echo "<label for='$id' id='lbl_$id' class=''>" . $this->getHelpBtn($id, $input['FEATURE']['HELP']) . "$label</label><textarea id='$id' name='$id'" .
        $this->getFeatures($features) . ">" . $value . "</textarea>" .
        $this->getHelpText($id, $input['FEATURE']['HELP']);
    }

    public function getComboBox($input) {
        $id = $input['ID'];
        $label = $input['LABEL'];
        $selected = isset($input['FEATURE']['SELECTED']) ? $input['FEATURE']['SELECTED'] : 0;
        //print_r($input);

        echo "<label for='$id' id='lbl_$id' class=''>" . $this->getHelpBtn($id, $input['FEATURE']['HELP']) . "$label</label>
        <select id='$id' name='$id' class='$input[MCLASS] browser-default'/>";
        foreach ($input['VALUE'] as $key => $value) {
            echo "<option value='$key'";

            if ($selected == $key){
                echo " selected='selected' ";
            }
            echo ">$value</option>\n";
        }
        echo "</select>" . $this->getHelpText($id, $input['FEATURE']['HELP']);
    }

    public function getRadioButton($input) {
        $id = $input['ID'];
        $label = $input['LABEL'];
        $features = $input['FEATURE'];
        $checked = isset($input['FEATURE']['CHECKED']) ? $input['FEATURE']['CHECKED'] : "";

        echo "<label for='$id' id='lbl_$id' class=''>" . $this->getHelpBtn($id, $input['FEATURE']['HELP']) . "$label</label>";
        foreach ($input['VALUE'] as $key => $value) {
            echo "<input type='radio' id='$value' name='$id' value='$key' " . $this->getFeatures($features);

            if ($checked == $key)
                echo " checked='checked'";

            echo "><label class='radiolabel' for='$value'>$value</label>";
        }
        echo $this->getHelpText($id, $input['FEATURE']['HELP']);
    }

    public function getCheckBox($input) {
        $id = $input['ID'];
        $label = $input['LABEL'];
        $features = $input['FEATURE'];
        $opChecked = isset($input['FEATURE']['CHECKED']) ? $input['FEATURE']['CHECKED'] : "";

        echo "<label for='$id' id='lbl_$id' class=''>" . $this->getHelpBtn($id, $input['FEATURE']['HELP']) . "$label</label>";
        foreach ($input['VALUE'] as $key => $value) {
            echo "<input type='checkbox' id='$id' name='$id'" . $this->getFeatures($features) . "><label for='$id'>$value"."</label>";
        }

        echo $this->getHelpText($id, $input['FEATURE']['HELP']);
    }

    /**
     * @param $input
     */
    public function getBenefitsCheckBox($input) {
        $id = $input['ID'];
        //$label = $input['LABEL'];
        $features = $input['FEATURE'];
        $checked = isset($input['FEATURE']['CHECKED']) ? $input['FEATURE']['CHECKED'] : false;
        
        echo "<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>";
        $num = 0;
        for ($r = 0; $r < (count($input['VALUE']) / 3); $r++) {
            echo "<tr>";
            for ($c = 0; $c < 3; $c++) {
                $value = $input['VALUE'][$num];
                $checkBoxId = $id . '_' . $num;

                if (!empty($checked)) {
                    echo "<input type='checkbox' name='$checkBoxId' id='$checkBoxId' ";
                    foreach ($checked as $checkedKey => $checkedValue) {
                        if ($checkBoxId == $checkedValue)
                            echo " checked='checked'";
                    }

                    echo " /><label for='$checkBoxId'>$value</label>";
                } else
                    echo "<input type='checkbox' name='$checkBoxId' id='$checkBoxId' class='$features[MCLASS]'/><label for='$checkBoxId'>$value</label>";

                $num++;
            }

            echo "</tr>";
        }
        echo "</table>";
    }

    public function getHideField($input) {
        $id =    $input['ID'];
        $value = $input['VALUE']['0'];
        echo "<input type='hidden' id='$id' name='$id' value='$value'>";
    }

    public function getLegend() {
        return $this->legendForm;
    }

    public function getEnctype() {
        return $this->enctype;
    }

    public function getButton() {

        echo '<fieldset class="formActionButtons">';
        //echo "<div id='" . $this->getNameForm() . "_waitdialog' style='width:50%; float:left; display:inline-block;'></div>";
        echo '<div class="formButtons row" style="display:inline-block">';
        foreach ($this->buttons as $key => $button) {

            $id =    $button['ID'];
            $label = $button['LABEL'];
            $icon =  $button['ICON'];
            $type =  $button['TYPE'];

            if (isset($button['REVERT']))
                echo "<img src='" . $this->getRoot() . "media/icon/_refresh.png' alt='' id='revert_$id' name='revert_$id' style='display: inline-block; position:absolute; cursor: pointer; left:77%;' class='ui-corner-all' />";

            echo "<button class='btn-large waves-effect waves-light deep-purple darken-4 formButton'id='$id'>$label</button>";
            // echo "<i class='mdi-action-pageview prefix'></i>";
        }
        echo "</div>";
        echo "</fieldset>";
    }

    public function getSeparator() {
        echo "<div style='border-bottom: 1px dashed #ccc; color: #2f5e9e; margin: 5px 0px 5px 0px;' >";
    }

    public function getComment($input) {
        $id =       $input['ID'];
        $label =    $input['LABEL'];
        $features = $input['FEATURE'];

        if (strlen($input['LABEL']) > 0)
            echo "<label id='lbl_$id' class='commentLbl ui-widget ui-corner-all '>$label</label>";
        else
            echo "<label id='lbl_$id' class='commentLbl ui-widget ui-corner-all '><p></p></label>";
    }

    public function getCaptcha($input) {
        $id =       $input['ID'];
        $label =    $input['LABEL'];
        $features = $input['FEATURE'];

        /*echo "<label for='wrap' id='lbl_$id' class=''>" . $this->getHelpBtn($id, $input['FEATURE']['HELP']) . "$label </label>
			<input id='$id' name='$id' type='text' " . $this->getFeatures($features) . ">
			<div id='wrap' style='display: inline-block; margin-left:5px;'>
			<img src='" . $this->getRoot() . "inc/tool/captcha/get_captcha.php' alt='' id='captcha_$id' name='captcha_$id' style='position:absolute;' class='ui-corner-all' />
			<img src='" . $this->getRoot() . "inc/tool/captcha/refresh.png' width='25' alt='$id' id='refresh_$id' name='refresh_$id' style='cursor: pointer; display: inline-block; margin-left:145px; position:relative; float: right;'/>
			</div>" . $this->getHelpText($id, $input['FEATURE']['HELP']);*/
        echo "<label for='wrap' id='lbl_$id' class=''>" . $this->getHelpBtn($id, $input['FEATURE']['HELP']) . "$label </label>
			<div id='wrap' style='display: inline-block; margin-left:5px;'>
			    <img src='" . $this->getRoot() . "inc/tool/captcha/get_captcha.php' alt='Captcha' id='captcha_$id' name='captcha_$id' style='position:absolute;' />
			    <img src='" . $this->getRoot() . "inc/tool/captcha/refresh.png' width='25' alt='$id' id='refresh_$id' name='refresh_$id' style='cursor: pointer; display: inline-block; margin-left:145px; position:relative; float: right;'/>
			</div>";
    }

    public function getIconButton($input) {
        $id =       $input['ID'];
        $icon =     $input['FEATURE']['ICON'];
        $title =    $input['FEATURE']['TITLE'];
        $width =    $input['FEATURE']['WIDTH'];

        echo "<button class='btn-large waves-effect waves-light deep-purple darken-4' id='$id' style='display: inline-block; cursor:pointer; height:45px; width:$width; text-align:center; margin: 5px 5px; 5px 0px;'><img src='" . $this->getRoot() . "media/icon/$icon'>$title</button>";
    }

    public function getActionForm() {
        return $this->actionForm;
    }

    public function getMethodForm() {
        return $this->methodForm;
    }

    public function getFlanges($input) {
        $id = $input['ID'];

        echo "<div id='flanges_menu' class='col l11 s11' style='margin-left: 25px;'>";
        foreach ($input['VALUE'] as $key => $value) {
            echo "<button class='flanges btn-large waves-effect waves-light deep-purple darken-4' id='$id-$key' style='height:45px; text-align:center;'>" . $value . "</button>&nbsp;";
        }

        echo "<div style='border-bottom: 1px dashed #ccc; color: #2f5e9e; margin: 10px 0px 5px 0px;' >";
    }

    public function getFeatures($features) {

        $feature = '';

        foreach ($features as $feat => $value) {
            switch ($feat) {

                case "MSTYLE":          $feature.= " style='" . $value . "' ";
                    break;
                case "MCLASS":          $feature.= " class='" . $value . "' ";
                    break;
                case "DEFAULTVALUE":    $feature.= " value='" . $value . "' ";
                    break;
                case "SIZE":            $feature.= " size='" . $value . "' ";
                    break;
                case "ROWS":            $feature.= " rows='" . $value . "' ";
                    break;
                case "COLS":            $feature.= " cols='" . $value . "' ";
                    break;
                case "MULTIPLE":        $feature.= " multiple='" . $value . "' ";
                    break;
                case "TITLE":           $feature.= " title='" . $value . "' ";
                    break;
                case "MAXLENGTH":       $feature.= " maxlength='" . $value . "' ";
                    break;
                case "DISABLED":        $feature.= " disabled='disabled' ";
                    break;
            }
        }

        return $feature;
    }

    /* Setters******************************************************************************** */

    public function setRoot($root) {
        $this->root = $root;
    }

    public function hasFeatures($type, $feature) {

        $features               = array();
        $features['MCLASS']     = isset($feature['MCLASS']) ? $feature['MCLASS'] : "";
        $features['MSTYLE']     = isset($feature['MSTYLE']) ? $feature['MSTYLE'] : "";
        $features['SELECTED']   = isset($feature['SELECTED']) ? $feature['SELECTED'] : "";
        $features['CHECKED']    = isset($feature['CHECKED']) ? $feature['CHECKED'] : "";
        $features['HEADERS']    = isset($feature['HEADERS']) ? $feature['HEADERS'] : "";
        $features['WIDTH']      = isset($feature['WIDTH']) ? $feature['WIDTH'] : "";
        $features['ICON']       = isset($feature['ICON']) ? $feature['ICON'] : "";
        $features['TITLE']      = isset($feature['TITLE']) ? $feature['TITLE'] : "";
        $features['MAXLENGTH']  = isset($feature['MAXLENGTH']) ? $feature['MAXLENGTH'] : "";
        $features['COMMENT']    = isset($feature['COMMENT']) ? $feature['COMMENT'] : "";

        if (isset($feature['DISABLED']))
            $features['DISABLED'] = $feature['DISABLED'];

        if (isset($feature['HELP']))
            $features['HELP'] = $feature['HELP'];

        return $features;
    }

    public function setField($type, $id, $label, $value, $feature) {

        $feature = $this->hasFeatures($type, $feature);

        $this->inputs[] = array (
            'TYPE'      => $type,//CAPTCHA
            'ID'        => $id,//Chars
            'LABEL'     => $label,//$STR['ValidateChars']
            'VALUE'     => $value,//array()
            'FEATURE'   => $feature //array('MCLASS' => $GLOBAL['vld_ch_req_max3'], 'HELP' => $STR['TypeCharsComment'], 'MSTYLE' => "width:170px;")
        );
    }

    public function setNameForm($nameForm) {
        $this->nameForm = $nameForm;
    }

    public function setMethodForm($method) {
        $this->methodForm = $method;
    }

    public function setEnctype($enctype) {
        $this->enctype = $enctype;
    }

    public function setActionForm($action) {
        $this->actionForm = $action;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setAlignForm($align) {
        $this->alignForm = $align;
    }

    public function setWidth($formWidth) {
        $this->formWidth = $formWidth;
    }

    public function setPASSWORD() {
        
    }

    public function setFile() {
        
    }

    public function setTextField() {
        
    }

    public function setTextArea() {
        
    }

    public function setComboBox() {
        
    }

    public function setRadioButton() {
        
    }

    public function setCheckBox() {
        
    }

    public function setButton($button) {

        $this->buttons[] = $button;
    }

    public function setHideField() {
        
    }

    public function setLegend($legend) {
        $this->legendForm = $legend;
    }

    /* Show form ******************************************************************************** */

    public function show() {
        echo "<div id='divForm_" . $this->getNameForm() . "'>" .
        "<form id='" . $this->getNameForm() . "' name='" . $this->getNameForm() . "' class=''  method='" . $this->getMethodForm() .
        "' enctype='" . $this->getEnctype() . "' action='" . $this->getActionForm() . "'>
		<fieldset>
		<legend id='legend_" . $this->getNameForm() . "'><h5>" . $this->getLegend() . "</h5></legend>";
        foreach ($this->inputs as &$input) {

            echo "<div id='formrow_" . $input['ID'] . "'>";
            switch ($input['TYPE']) {
                case "FLEXIGRID":   $this->getFlexiGridTable($input);
                    break;
                case "INFOFIELD":   $this->getInfoField($input);
                    break;
                case "TEXTFIELD":   $this->getTextField($input);
                    break;
                case "PASSWORD":    $this->getPassword($input);
                    break;
                case "FILE":        $this->getFile($input);
                    break;
                case "TEXTAREA":    $this->getTextArea($input);
                    break;
                case "COMBOBOX":    $this->getComboBox($input);
                    break;
                case "RADIOBUTTON": $this->getRadioButton($input);
                    break;
                case "CHECKBOX":    $this->getCheckBox($input);
                    break;
                case "BNFCHECKBOX": $this->getBenefitsCheckBox($input);
                    break;
                case "HIDEFIELD":   $this->getHideField($input);
                    break;
                case "SEPARATOR":   $this->getSeparator();
                    break;
                case "WAITLOADING": $this->getWaitLoading();
                    break;
                case "UPLOADEDFILE":$this->getUploadedFile();
                    break;
                case "IMAGE":       $this->getImage($input);
                    break;
                case "COMMENT":     $this->getComment($input);
                    break;
                case "CAPTCHA":     $this->getCaptcha($input);
                    break;
                case "TABLE":       $this->getTable($input);
                    break;
                case "ICONBUTTON":  $this->getIconButton($input);
                    break;
                case "FLANGES":     $this->getFlanges($input);
                    break;
            }
            echo "</div>";
        }
        echo "</fieldset>";
        $this->getButton();
        echo '</form>';
        echo "</div>";
    }

    function __destruct() {
        
    }

}

//End Class
//$gForm = new gForm();
?>
