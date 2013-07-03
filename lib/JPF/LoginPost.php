<?php

$root = $_SERVER['DOCUMENT_ROOT'];

/*
 * Imports trough SmartLibs
 */
$debug = 1;
require_once '../JPFLibs.php';

libadd("lib.JPF.Data.MySQL");

$table = $_SESSION["table"];
$loginField = $_SESSION["loginf"];
$passwordField = $_SESSION["paswf"];
$MD5 = $_SESSION["MD5"];
$sql = mysql_query("select $passwordField, ID from $table where $loginField='" . $_POST["login"] . "'") or die(mysql_error());
$passwd = "";
$userid = "";
$i = 0;
while ($record = mysql_fetch_object($sql)) {
    $passwd = $record -> $passwordField;
    $userid = $record -> ID;
}
if ($MD5 && $passwd == md5($_POST["password"])) {

    $_SESSION["user"] = $_POST["login"];
        $_SESSION["userid"] = $record -> ID;
    $expire = time() + 60 * 60 * 24 * 30;
    setcookie("user", $_SESSION["user"], $expire, GlobalVars::$STARTPATH);
    header("Location:" . $_SESSION["pb"]);

} else if (!$MD5 && $passwd == $_POST["password"]) {
    $_SESSION["user"] = $_POST["login"];
    $_SESSION["userid"] = $userid;

   header("Location:" . $_SESSION["pb"]);
} else {
    echo "test";
    header("Location: " . $_SESSION["pb"]);
}
?>
