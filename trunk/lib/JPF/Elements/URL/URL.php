<?php

/**
 * Description of Textbox
 *
 * @author jonas
 */
class URL extends GridElement {
    
    public function DefineBlock($tpl) {
        $tpl->AddFile("lib/Jimber/Elements/URL/URL.tpl");
        $tpl->DefineBlock("URL");
        $tpl->DefineBlock("POPURL");
    }

    public function Build($tpl, $name, $value, $field, $element, $values) {
        $showname = $field->showname;
        while (strpos($field->preURL, "{{")) {

            $start = strpos($field->preURL, "{{") + 2;
            $stop = strpos($field->preURL, "}}");
            $substr = substr($field->preURL, $start, $stop - $start);
            $field->preURL = str_replace("{{" . $substr . "}}", $values->$substr, $field->preURL);
            break;
        }
        
        $valued = $field->preURL . $value;
        if(isset($field->areYouSure)){
           $valued = Tools::AreYouSure(GlobalVars::$STARTPATH.$valued);
        }
        $tpl->setVars("URL", "URL", $valued);
        $tpl->setVars("URL", "SHOWNAME", $showname);
        $extra = "";

        if (isset($field->URLdbname)) {
            $urldbname = $field->URLdbname;
            $tpl->setVars("URL", "SHOWNAME", $element->$urldbname);
        }else if(isset($field->showValue)){
		           $tpl->setVars("URL", "SHOWNAME", $value);
	}
	//This is not so good. The URL has 2 datas. One to show, one to link to. Find a better way!	
	if (isset($field->URLname)) {

            $URLname = $field->URLname;
            $tpl->setVars("URL", "URL", $field->preURL.$element->$URLname);
        }
        $tpl->setVars("URL", "EXTRA", "");
        if (isset($field->target)) {
            $extra = "target=" . $field->target;
        }
        if (isset($field->confirmation)) {
            $extra .= " onclick=\"return confirm('Bent u zeker?');\"";
        }

        $tpl->setVars("URL", "EXTRA", $extra);
        if (isset($field->popup)) {

            $popup = $field->popup;
            $tpl->setVars("POPURL", "URL", $field->preURL . $value);
            $tpl->setVars("POPURL", "SHOWNAME", $showname);
            $tpl->setVars("POPURL", "WIDTH", $popup->width);
            $tpl->setVars("POPURL", "HEIGHT", $popup->height);
            $tpl->setVars("POPURL", "SCROLLBARS", $popup->scrollbars);
            $tpl->setVars('POPURL', "LOCATION", $popup->location);
            $tpl->setVars('POPURL', "TOOLBAR", $popup->toolbar);
            $pop = $tpl->ParseBlock("POPURL");
            $tpl->setVars("URL", "EXTRA", $pop);
        }

        return $tpl->ParseBlock("URL");
    }

}

?>
