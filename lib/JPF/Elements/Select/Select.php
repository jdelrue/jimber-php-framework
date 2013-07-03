<?php
/**
 * Description of Textbox
 *
 * @author jonas
 */
class Select extends GridElement{
var $updatable = true;
var $null = false;
    public function DefineBlock($tpl){
        $tpl->AddFile("lib/JPF/Elements/Select/Select.tpl");
        $tpl->DefineBlock("SELECT");	
        $tpl->DefineBlock("OPTIONBLOCK");
    }
    public function Build($tpl, $name,$value, $field, $element,$values){
        if(!isset($field->textfield)){
            die ("Fatal Error select is used but textfield is not set");
        }
        //Select block
        $tpl->setVars("SELECT", "ID", $element->ID);
        $tpl->setVars("SELECT","NAME", $name);
        //Options block
        $collectionCount = count($field->collection);
        $options = "";
        
        if(($field->default == "") && isset($field->default)){ //When the default value is nothing. @todo check if this adds "" or dbnull in dbase
            $tpl->setVars("OPTIONBLOCK","ID","");
            $textfield = $field->textfield;
            $tpl->setVars("OPTIONBLOCK","NAME","");
               $tpl->setVars("OPTIONBLOCK","DEFAULT","selected");
                  $options = $options.$tpl->ParseBlock("OPTIONBLOCK");
        }
        for($k=0;$k<$collectionCount;$k++){
            $tpl->setVars("OPTIONBLOCK","ID",$field->collection[$k]->ID);

            $textfield = $field->textfield;
            
            $tpl->setVars("OPTIONBLOCK","NAME",$field->collection[$k]->$textfield);
            $tpl->setVars("OPTIONBLOCK","DEFAULT","");

            if($value == $field->collection[$k]->ID || ($field->collection[$k]->$textfield == $field->default && isset($field->default))){
              
                $tpl->setVars("OPTIONBLOCK","DEFAULT","selected");

            }
            $options = $options.$tpl->ParseBlock("OPTIONBLOCK");
        }
        $tpl->setVars("SELECT", "CONTENT", $options);
        $tpl->setVars("SELECT","DISABLED","");
        if($field->disabled){
            $tpl->setVars("SELECT","DISABLED","disabled");
        }
	$this-> addStyles($field,$tpl, "SELECT");
        return $tpl->ParseBlock("SELECT");
    }

}
?>
