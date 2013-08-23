<?php
/*
 * Imports trough SmartLibs
 @TODO: SECURITY????
 */

require_once '../../../../JPFLibs.php';

libadd("lib.JPF.Data.MySQL");
libadd("lib.JPF");

if(isset($_GET["type"]) && isset($_GET["ID"])){

    $class = $_GET["type"];
    $element = new $class($_GET["ID"]);
    $element->Delete();
   header("Location: ". GlobalVars::$STARTPATH.base64_decode($_GET["pb"]));
}
?>
