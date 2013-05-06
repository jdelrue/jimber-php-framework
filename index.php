<?php

/*
 * Imports trough JimberLibs
 */
$debug = 1;
require_once 'lib/JimberLibs.php';

libadd("lib.Jimber");
libadd("lib.Jimber.Data.MySQL");
//requireLogin(0);

/*
 * Start of page specific stuff
 */

$tpl = new Template("templates/page.tpl");

$tpl->DefineBlock("PAGEBLOCK");
$tpl->DefineBlock("CONTENTBLOCK");

$tpl->setVars("PAGEBLOCK", "CONTENT",$tpl->ParseBlock("CONTENTBLOCK"));
$page = $tpl->ParseBlock("PAGEBLOCK");
$tpl->Show($page);
?>
