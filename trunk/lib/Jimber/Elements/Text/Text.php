<?php
/**
 * Description of Textbox
 *
 * @author jonas
 */
class Text extends GridElement{

    public function DefineBlock($tpl){
        $tpl->AddFile("lib/Jimber/Elements/Text/Text.tpl");
        $tpl->DefineBlock("TEXTONLYFIELD");
    }
    public function Build($tpl, $name,$value, $field, $element,$values){
        $tpl->setVars("TEXTONLYFIELD", "VALUE",  $value);
        return $tpl->ParseBlock("TEXTONLYFIELD");
    }


}
?>
