<?php

/**
 * Description of Textbox
 *
 * @author jonas
 */
class SQLBox extends GridElement {

    public function DefineBlock($tpl) {
        $tpl->AddFile("lib/Jimber/Elements/Text/Text.tpl");
        $tpl->DefineBlock("TEXTONLYFIELD");
    }

    public function Build($tpl, $name, $value, $field, $element, $values) {
        $arr = Array();
        $mysqli = SQL_Connector::getMysqliInstance();
        $sqlstr = str_replace("{VAL}", $value, $field->SQLstring);
        $result = $mysqli->query($sqlstr);
        $arr = $result->fetch_array();
        $value = $arr[0];

        return $value;
    }

    public function Update($postback) {
        return $postback;
    }

}

?>
