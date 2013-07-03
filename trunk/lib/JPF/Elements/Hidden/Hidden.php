<?php
/**
 * Description of Textbox
 *
 * @author jonas
 */
class Hidden extends GridElement{
   var $updatable = true;
  var $value;
    public function DefineBlock($tpl){
        $tpl->AddFile("lib/JPF/Elements/Hidden/Hidden.tpl");
        $tpl->DefineBlock("HIDDEN");
    }
    public function PreBuild($field,$tpl){

    }
    public function Build($tpl, $name,$value, $field, $element, $values){

        $tpl->setVars("HIDDEN","NAME", $name);
        $tpl->setVars("HIDDEN","VALUE", $field->hiddenValue);

        return $tpl->ParseBlock("HIDDEN");

    }

}
?>
