<?php

/**
 * Description of Textbox
 *
 * @author jonas
 */
class Datebox extends GridElement {

    var $updatable = true;
    var $minDate;
    var $maxDate;

    public function DefineBlock($tpl) {
        $tpl->AddFile("lib/JPF/Elements/Datebox/Datebox.tpl");
        $tpl->DefineBlock("DATEBOX");
    }

    public function Build($tpl, $name, $value, $field, $element, $values) {
        $FUID = Tools::random_string();
        $tpl->DefineBlock("ADDTODAY");

        $tpl->setVars("ADDTODAY", "DBNAME", $field->dbname);
        $tpl->setVars("DATEBOX", "DBNAME", $field->dbname);
        $tpl->setVars("ADDTODAY", "DATEPICKER", GlobalVars::$STARTPATH . "lib/JPF/Elements/Datebox/DatePicker.php?FUID=" . $FUID);
        $tpl->setVars("ADDTODAY", "FUID", $FUID);
        $tpl->setVars("DATEBOX", "UID", $field->UID);
        $tpl->setVars("DATEBOX", "FUID", $FUID);

        if ($field->required) {
            $tpl->setVars("DATEBOX", "STAR", "*");
        } else {
            $tpl->setVars("DATEBOX", "STAR", "");
        }

        if (strpos($value, "/") > 0) {
            $arr = split("/", $value);
            $value = $arr[2] . "-" . $arr[1] . "-" . $arr[0];
        }
        try {
            $date = new DateTime($value);
            $date = $date->format('d/m/Y');
        } catch (Exception $e) {
            $value = "";
        }
        if ($value == "") {
            $date = "dd/mm/yyyy";
        }
        if (isset($field->default) && $date == "") {
            $date = $field->default;
            //$date = $date->format('d/m/Y');
        }

        $tpl->setVars("DATEBOX", "NAME", $name);
        $tpl->setVars("DATEBOX", "VALUE", $date);
        //if($field->today){
        //}
        return $tpl->ParseBlock("DATEBOX") . $tpl->ParseBlock("ADDTODAY");
    }

    public function preUpdate($value) {
        if ($value == "dd/mm/yyyy") {
            return "";
        } else {
            return $value;
        }
    }

    public function Update($postback) {
        if ($postback == "dd/mm/yyyy") {
            return "";
        }
        return "STR_TO_DATE('$postback', '%d/%m/%Y')";
    }

}

?>
