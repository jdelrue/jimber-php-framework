<?php

 require_once($includePath."/Entity.php");
if ($handle = opendir($includePath)) {

    while (false !== ($file = readdir($handle))) {

        if (!is_dir($file) && $file != "." && $file != ".." && $file != ".svn" && substr($file, -4) == ".php" && $file != "generate.php") {
            require_once($includePath."/".$file);
        }
    }
}

?>
