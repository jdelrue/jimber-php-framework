<?php
/**
 * Description of Textbox
 *
 * @author jonas
 */
class TextboxPassword extends GridElement{
    var $updatable = true;
    var $md;
    public function DefineBlock($tpl){
        $tpl->AddFile("lib/Jimber/Elements/TextboxPassword/TextboxPassword.tpl");
        $tpl->DefineBlock("PASSWORD");
    }
    public function preBuild($field,$tpl){

         if($field->MD5){
     
            $this->md = "true";
             $tpl->setVars("PASSWORD","VALUE", "");
        }
    }
    public function Build($tpl, $name,$value, $field, $element, $values){
        $tpl->setVars("PASSWORD","NAME", $name);
        $type = "txt";
        if(!$field->MD5){
            $tpl->setVars("PASSWORD","VALUE", $value);
        }
        $tpl->setVars("PASSWORD", "TYPE", $type);
        return $tpl->ParseBlock("PASSWORD");
    }
        public function Update($input){

        if($input == ""){
            return "false";
        }
        if($this->md){
            return "'".md5($input)."'";
        }
        return $input;
    }
}
?>
