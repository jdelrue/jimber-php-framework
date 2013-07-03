<?php

/**
 * Description of Textbox
 *
 * @author jonas
 */
class TextboxSuggest extends GridElement {

    var $updatable = true;

    public function DefineBlock($tpl) {
        $tpl->AddFile("lib/Jimber/Elements/TextboxSuggest/TextboxSuggest.tpl");
        $tpl->DefineBlock("TEXTBOXSUGGEST");
        $tpl->DefineBlock("SUGGESTSCRIPT");
    }

    public function Build($tpl, $name, $value, $field, $element, $values) {

        $name =  str_replace("=", "", $name);

        if ($field->required) {
            $tpl->setVars("TEXTBOXSUGGEST", "STAR", "*");
        } else {
            $tpl->setVars("TEXTBOXSUGGEST", "STAR", "");
        }
        $tpl->setVars("TEXTBOXSUGGEST", "NAME", $name);
        $tpl->setVars("TEXTBOXSUGGEST", "VALUE", $value);

        $tpl->setVars("TEXTBOXSUGGEST", "SCRIPT", $this->BuildSuggestList($name, $tpl, $field));
        return $tpl->ParseBlock("TEXTBOXSUGGEST");
    }

    private function BuildSuggestList($name, $tpl, $field) {
        $selector = $field->sqlSelector;
        $field = $field->suggestField;
        $arrayOfValues = $selector->getAllValues();
        $scriptString = "";
        foreach ($arrayOfValues as $key => $value) {
            $valueToAdd = $value->$field;
            $scriptString .= "\"$valueToAdd\",";
        }
        $scriptString = substr_replace($scriptString, "", -1);

        $tpl->setVars("SUGGESTSCRIPT", "VALUES", $scriptString);
        $tpl->setVars("SUGGESTSCRIPT", "NAME", $name);
        return $tpl->ParseBlock("SUGGESTSCRIPT");
    }

}

?>
