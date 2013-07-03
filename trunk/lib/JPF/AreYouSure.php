<?php
$debug=1;
require_once '../JimberLibs.php';


libadd("lib.Jimber");


$redirect = URLEncrypter::Decrypt($_GET['redirect']);

$tpl = new Template("lib/Jimber/templates/AreYouSure.tpl");

$tpl->DefineBlock("SUREBLOCK");
$tpl->SetVars("SUREBLOCK", "REDIRECT", $redirect);

$htm = $tpl->ParseBlock("SUREBLOCK");
$tpl->Show($htm);

?>
