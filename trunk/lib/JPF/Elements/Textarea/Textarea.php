<?php
/**
 * Description of Textbox
 *
 * @author jonas
 */
class Textarea extends GridElement{
   var $updatable = true;
  
    public function DefineBlock($tpl){
        $tpl->AddFile("lib/Jimber/Elements/Textarea/Textarea.tpl");
        $tpl->DefineBlock("TEXTAREA");
    }
    public function Build($tpl, $name,$value, $field, $element, $values){

        $tpl->setVars("TEXTAREA","NAME", $name);
        $tpl->setVars("TEXTAREA","VALUE", $value);

        return $tpl->ParseBlock("TEXTAREA");

    }

}
?>
