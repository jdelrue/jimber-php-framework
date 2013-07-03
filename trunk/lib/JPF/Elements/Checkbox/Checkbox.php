<?php
/**
 * Description of Textbox
 *
 * @author jonas
 */
class Checkbox extends GridElement{
   var $updatable = true;
    public function DefineBlock($tpl){
        $tpl->AddFile("lib/Jimber/Elements/Checkbox/Checkbox.tpl");
        $tpl->DefineBlock("CHECKBOX");
        $tpl->DefineBlock("TEXTFIELD");
               $tpl->DefineBlock("READONLY");

    }
    public function Build($tpl, $name,$value, $field, $element, $values){
            $tpl->setVars("CHECKBOX","CHECKED","");
         
            if($value == 1){
         
                $tpl->setVars("CHECKBOX","CHECKED","CHECKED");
            }
            $tpl->setVars("CHECKBOX","DISABLED","");
            if($field->disabled){
                $tpl->setVars("CHECKBOX","DISABLED","disabled");
            }
            if($field->readonly){
                  $tpl->setVars("CHECKBOX","READONLY",$tpl->parseBlock("READONLY"));
            }
                $tpl->setVars("CHECKBOX","NAME", $name);
            $tpl->setVars("CHECKBOX","VALUE", $value);
            return $tpl->ParseBlock("CHECKBOX");
    }
        public function Update($postBackElement){
       

          return $postBackElement;
          
       // return 1; //Checkbox update method is only called when checked

    }
      public function preUpdate($value){
          
        return 1;
     }
}
?>
