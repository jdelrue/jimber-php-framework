<?php

$debug=1;
//ini_set('display_errors', 'On');

require_once "JimberLibs.php";

libadd("lib.Jimber");
libadd("lib.Jimber.Data.MySQL");

echo "Hello admin. <a href=\"Jimber/Entitygen/Fetcher.php\" > Do you want to generate some entities? </a>";

?>
