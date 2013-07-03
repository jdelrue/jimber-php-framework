<?php

/**
 * Description of Textbox
 *
 * @author jonas
 */
class Upload extends GridElement {

    var $updatable = true;
    var $name;

    public function DefineBlock($tpl) {
        $tpl->AddFile("lib/JPF/Elements/Upload/Upload.tpl");
        $tpl->DefineBlock("UPLOADBLOCK");
        $tpl->DefineBlock("UPLOADBLOCKMULTI");
    }

    public function Build($tpl, $name, $value, $field, $element, $values) {

        if ($field->multi) {
      
            $tpl->setVars("UPLOADBLOCKMULTI", "VALUE", $value);
            $tpl->setVars("UPLOADBLOCKMULTI", "FILENAME", $name);
            $tpl->setVars("UPLOADBLOCKMULTI", "NAME", $name);
             return $tpl->ParseBlock("UPLOADBLOCKMULTI");
        } else {
            $tpl->setVars("UPLOADBLOCK", "VALUE", $value);
            $tpl->setVars("UPLOADBLOCK", "FILENAME", $name);
            $tpl->setVars("UPLOADBLOCK", "NAME", $name);
             return $tpl->ParseBlock("UPLOADBLOCK");
        }
       
    }

    public function preUpdate($value) {

        $return = Array();
        
 
        
  
        $i = 0;
        echo $_FILES[$value]["name"];
     echo $extension."test";
   if(is_array($_FILES[$value]["tmp_name"])){
       
         foreach ($_FILES[$value]["tmp_name"] as $filename) 
            {
 $name = $_FILES[$value]["name"][$i];
            $tmp=$_FILES[$value]['tmp_name'];
            $extension = substr($name, -4, 4);
             $newfn = Tools::random_string();
             move_uploaded_file($filename, GlobalVars::$DRIVEPATH . "upload/" . $newfn.$extension);
             array_push($return, $newfn.$extension);
             $i++;
         }
   }else{
        $tmp=$_FILES[$value]['tmp_name'];
            
             $newfn = Tools::random_string();
             move_uploaded_file($tmp, GlobalVars::$DRIVEPATH . "upload/" . $newfn.$extension);
          // echo "**".$newfn.$extension."<br>";
             if($tmp == ""){
                 return false;
             }
          return $newfn.$extension;
   }
       return $return;
    }

}

?>
