<?php

//include($startPath."CheckLogin.php");
require_once($includePath . "/DataElement.php");
require_once($includePath . "/Grid.php");
require_once($includePath . "/Field.php");
require_once($includePath . "/Form.php");
//        require_once($startPath."Linker.php");
require_once($includePath . "/Template.php");
require_once($includePath . "/LinkField.php");
require_once($includePath . "/Login.php");
require_once($includePath . "/Loader.php");
require_once($includePath . "/Popup.php");
require_once($includePath . "/FileEditor.php");
require_once($includePath . "/HiddenFieldPass.php");
require_once($includePath . "/GridElement.php");
require_once($includePath . "/Search.php");
require_once($includePath . "/OutputMethods/Exceldownload.php");
require_once($includePath . "/GridView.php");
require_once($includePath . "/Calendar.php");
require_once($includePath . "/Tools/Tools.php");
require_once($includePath . "/Tools/DateTools.php");

require_once($includePath . "/DataSelectors/Selector.php");
require_once($includePath . "/DataSelectors/SQLSelector.php");
require_once($includePath . "/DataSelectors/SQLSelector.php");
require_once($includePath . "/Security/URLEncrypter.php");
//require_once($includePath . "/Entitygen/Entity.php");

/*
 * This will load all custom element fields, they all MUST be named Field.php
 */
if ($handle = opendir(GlobalVars::$DRIVEPATH . 'lib/JPF/Elements')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != ".svn") {

            if (file_exists(GlobalVars::$DRIVEPATH . "lib/JPF/Elements/$file/Field.php")) {
                require_once(GlobalVars::$DRIVEPATH . "lib/JPF/Elements/$file/Field.php");
            }
        }
    }
}
?>
