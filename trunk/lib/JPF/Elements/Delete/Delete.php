<?php

/**
 * Description of Textbox
 *
 * @author jonas
 * @Todo: Seperate parameters for the Build method are NOT a good idea. This is not extendable!! Change to one object so you dont have to
 * rewrite each function when adding a parameter.
 */
class Delete { // extends GridElement

    public function DefineBlock($tpl){
        $tpl->AddFile("lib/JPF/Elements/Delete/Delete.tpl");
        $tpl->DefineBlock("DELETE");

    }
    public function Build($tpl, $name,$value, $field, $element, $values){
       
        $tpl->setVars("DELETE","TYPE", $element->entityType);
        $tpl->setVars("DELETE","ID",$element->ID);
                $tpl->setVars("DELETE","DELETEHANDLER",GlobalVars::$STARTPATH."lib/JPF/Elements/Delete/Delete_handler.php");
        if(strpos($field->postback,"http")>0){
        $tpl->setVars("DELETE","PB",  base64_encode(GlobalVars::$STARTPATH.$field->postback));
        }else{
            $tpl->setVars("DELETE","PB",  base64_encode($field->postback));
        }
        return $tpl->ParseBlock("DELETE");
    }
    public function PreBuild(){
    
    }


}

?>
