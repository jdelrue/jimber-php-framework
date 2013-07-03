<?php
/**
 * Description of Textbox
 *
 * @author jonas
 */
class LinkedText extends GridElement{
var $updatable = true;
var $null = false;
    public function DefineBlock($tpl){
        $tpl->AddFile("lib/Jimber/Elements/LinkedText/LinkedText.tpl");

        $tpl->DefineBlock("OPTIONBLOCKL");
    }
    public function Build($tpl, $name,$value, $field, $element , $values){
        $tpl->setVars("OPTIONBLOCKL","NAME","");
        //echo $value;
        //Select block
   
        //Options block
        $collectionCount = count($field->collection);
        $options = "";

        if($this->default == "" && isset($this->default)){ //When the default value is nothing. @todo check if this adds "" or dbnull in dbase
            $tpl->setVars("OPTIONBLOCKL","ID","");
            $textfield = $field->textfield;
            $tpl->setVars("OPTIONBLOCKL","NAME","");
               $tpl->setVars("OPTIONBLOCKL","DEFAULT","selected");
                  $options = $options.$tpl->ParseBlock("OPTIONBLOCKL");
        }
        for($k=0;$k<$collectionCount;$k++){

            $textfield = $field->textfield;
            if($value == $field->collection[$k]->ID){

                $tpl->setVars("OPTIONBLOCKL","NAME",$field->collection[$k]->$textfield);
                $options = $options.$tpl->ParseBlock("OPTIONBLOCKL");
                $done=1;
            }
            
        }
   
        return $tpl->ParseBlock("OPTIONBLOCKL");
    }

}
?>
