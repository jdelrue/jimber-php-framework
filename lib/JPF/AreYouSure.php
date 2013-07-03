<?php
$debug=1;
require_once '../JPFLibs.php';


libadd("lib.JPF");


$redirect = URLEncrypter::Decrypt($_GET['redirect']);

$tpl = new Template("lib/JPF/templates/AreYouSure.tpl");

$tpl->DefineBlock("SUREBLOCK");
$tpl->SetVars("SUREBLOCK", "REDIRECT", $redirect);

$htm = $tpl->ParseBlock("SUREBLOCK");
$tpl->Show($htm);

?>
