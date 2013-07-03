<?php
/**
 * Description of Textbox
 *
 * @author jonas
 */
class Textpre extends GridElement{

    public function DefineBlock($tpl){
        $tpl->AddFile("lib/JPF/Elements/Textpre/Textpre.tpl");
        $tpl->DefineBlock("PRE");
    }
    public function Build($tpl, $name,$value, $field, $element, $values){

        $tpl->setVars("PRE","CONTENT", $value);

        return $tpl->ParseBlock("PRE");
    }
}
?>
