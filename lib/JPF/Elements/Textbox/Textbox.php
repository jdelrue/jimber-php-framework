<?php
/**
 * Description of Textbox
 *
 * @author jonas
 */
class Textbox extends GridElement{
   var $updatable = true;
  
    public function DefineBlock($tpl){
        $tpl->AddFile("lib/JPF/Elements/Textbox/Textbox.tpl");
        $tpl->DefineBlock("TEXTBOX");
    }
    public function Build($tpl, $name,$value, $field, $element, $values){

        if($field->required){
            $tpl->setVars("TEXTBOX","STAR", "*");
        }else{
            $tpl->setVars("TEXTBOX","STAR","");
        }
        $tpl->setVars("TEXTBOX","NAME", $name);
        $tpl->setVars("TEXTBOX","VALUE", $value);

        return $tpl->ParseBlock("TEXTBOX");

    }


}
?>
