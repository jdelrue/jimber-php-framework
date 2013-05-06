<?php
/**
 * Description of Textbox
 *
 * @author jonas
 */
class URL extends GridElement{

    public function DefineBlock($tpl){
        $tpl->AddFile("Lib/Jimber/Elements/URL/URL.tpl");
        $tpl->DefineBlock("URL");
         $tpl->DefineBlock("POPURL");
    }
    public function Build($tpl, $name,$value, $field, $element){
        $showname = $field->showname;
        $tpl->setVars("URL","URL", $field->preURL.$value);
        $tpl->setVars("URL","SHOWNAME",$showname);

        if(isset($field->URLdbname)){
            $urldbname = $field->URLdbname;
            $tpl->setVars("URL","SHOWNAME",$element->$urldbname);
        }
        $tpl->setVars("URL","EXTRA","");
        if(isset($field->target)){
            $extra = "target=".$field->target;
        }
        if(isset($field->confirmation)){
            $extra .= " onclick=\"return confirm('Bent u zeker?');\"";
        }

          $tpl->setVars("URL","EXTRA",$extra);
        if(isset($field->popup)){
            
            $popup = $field->popup;
            $tpl->setVars("POPURL","URL", $field->preURL.$value);
            $tpl->setVars("POPURL","SHOWNAME",$showname);
            $tpl->setVars("POPURL","WIDTH",$popup->width);
            $tpl->setVars("POPURL","HEIGHT",$popup->height);
            $tpl->setVars("POPURL", "SCROLLBARS", $popup->scrollbars);
            $tpl->setVars('POPURL', "LOCATION", $popup->location);
            $tpl->setVars('POPURL', "TOOLBAR", $popup->toolbar);
            $pop = $tpl->ParseBlock("POPURL");
            $tpl->setVars("URL","EXTRA",$pop);
        }

        return $tpl->ParseBlock("URL");
    }
}
?>
