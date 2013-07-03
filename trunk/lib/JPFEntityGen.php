<?php

$debug=1;
//ini_set('display_errors', 'On');

require_once "JPFLibs.php";

libadd("lib.JPF");
libadd("lib.JPF.Data.MySQL");

echo "Hello admin. <a href=\"JPF/Entitygen/Fetcher.php\" > Do you want to generate some entities? </a>";

?>
