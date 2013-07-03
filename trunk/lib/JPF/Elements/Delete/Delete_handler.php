<?php
/*
 * Imports trough SmartLibs
 */

require_once '../../../JimberLibs.php';

libadd("lib.Jimber.Data.MySQL");
libadd("lib.Jimber");

if(isset($_GET["type"]) && isset($_GET["ID"])){

    $class = $_GET["type"];
    $element = new $class($_GET["ID"]);
    $element->Delete();
   header("Location: ". GlobalVars::$STARTPATH.base64_decode($_GET["pb"]));
}
?>
