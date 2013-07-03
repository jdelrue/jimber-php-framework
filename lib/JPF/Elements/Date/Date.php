<?php

/**
 * Description of Textbox
 *
 * @author jonas
 */
class Date extends GridElement {

    public function DefineBlock($tpl) {
        $tpl->AddFile("lib/Jimber/Elements/Text/Text.tpl");
        $tpl->DefineBlock("TEXTONLYFIELD");
    }

    public function Build($tpl, $name, $value, $field, $element, $values) {

        if ($value != "" && $value != "NULL") {
        
            $date = new DateTime($value);

            $date = $date->format('d/m/Y');
        } else {
            $date = "";
        }
        $tpl->setVars("TEXTONLYFIELD", "VALUE", $date);
        return $tpl->ParseBlock("TEXTONLYFIELD");
    }

}

?>
