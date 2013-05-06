<?php

/**
 * Description of Image
 *
 * @author jonas
 */
class Image extends GridElement {

    public function DefineBlock($tpl) {
        $tpl->AddFile("lib/Jimber/Elements/Image/Image.tpl");
        $tpl->DefineBlock("IMAGEFIELD");
        $tpl->DefineBlock("LINKIMAGEFIELD");
        $tpl->DefineBlock("POPUPIMAGEFIELD");
    }

    public function Build($tpl, $name, $value, $field, $element, $values) {
        
        if($value == "" || !file_exists(GlobalVars::$DRIVEPATH . $field->folder . $value)) { 
            $value = $field->defaultImage;
        }
        if (isset($field->popup)) {
            $tpl->setVars("POPUPIMAGEFIELD", "VALUE", GlobalVars::$STARTPATH . $field->folder . $value);
            $tpl->setVars("POPUPIMAGEFIELD", "URL", $field->preURL . $field->folder . $value);
            return $tpl->ParseBlock("POPUPIMAGEFIELD");
        } else if (isset($field->preURL)) {
            echo "preurl";
            $tpl->setVars("LINKIMAGEFIELD", "VALUE", GlobalVars::$STARTPATH . $field->folder . $value);
            $tpl->setVars("LINKIMAGEFIELD", "URL", $field->preURL . $field->folder . $value);
            return $tpl->ParseBlock("LINKIMAGEFIELD");
        } else {
            $tpl->setVars("IMAGEFIELD", "VALUE", GlobalVars::$STARTPATH . $field->folder . $value);
            return $tpl->ParseBlock("IMAGEFIELD");
        }
    }

}

?>
