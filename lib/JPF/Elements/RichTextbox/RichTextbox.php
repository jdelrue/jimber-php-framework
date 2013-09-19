<?php
/**
 * Description of Textbox
 *
 * @author jonas
 */
class RichTextbox extends GridElement{
   var $updatable = true;
  
    public function DefineBlock($tpl){
        $tpl->AddFile("lib/Jimber/Elements/RichTextbox/RichTextbox.tpl");
        $tpl->DefineBlock("RICHTEXTAREA");
    }
    public function Build($tpl, $name,$value, $field, $element, $values){
        $tpl->setVars("RICHTEXTAREA","NAME", $name);
        $tpl->setVars("RICHTEXTAREA","VALUE", $value);

        return $tpl->ParseBlock("RICHTEXTAREA");

    }

}
?>
