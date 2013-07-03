<?php
//voorloping manueel auto-prepend
#require_once('../../Lib/CMCMTAUTH/IDM_proginit.php');
session_start();
require_once 'Lib/Jimber/Error.php';
require_once('Lib/CMCMT/etc/IDM.conf.php');
require_once('Lib/CMCMT/etc/CMCMT.conf.php');
require_once('Lib/CMCMTAUTH/Idm.class.php');

require_once 'Lib/CMCMT/Global.php';

$idm = new IDM();

try {
    $user = $idm->Authenticate($_POST['login'], $_POST['password']);

    if ($user) {
        $_SESSION['user'] = $user;
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['authenticated'] = 1;

        if ($user->surname == "Delrue") {
            $_SESSION['accesslevel'] = "ae";
        }
        if ($user->surname == "Ghyselinck") {
            $_SESSION['accesslevel'] = "ct";
            $_SESSION['country'] = "NL";
        }
        unset($_SESSION['authenticating']);
        header('Location:' . "index.php");
        exit(0);
    }
} catch (Exception $e) {
    $error = new Error($e->getMessage(), "Login.php");
    $_SESSION['error'] = $error;
    GlobalFunctions::Redirect("Show_error.php");
}
$error = new Error("Invalid Username/Password combination", "Login.php");
$_SESSION['error'] = $error;
GlobalFunctions::Redirect("Show_error.php");

/*
  $root = $_SERVER['DOCUMENT_ROOT'];

  require_once("$root/Data/SQL_Config.php");


  $table =   $_SESSION["table"];
  $loginField  =  $_SESSION["loginf"];
  $passwordField = $_SESSION["paswf"];
  $MD5 = $_SESSION["MD5"];
  $sql = mysql_query("select $passwordField from $table where $loginField='".$_POST["login"]."'") or die ( mysql_error( ) );
  $passwd = "";
  $i=0;
  while($record = mysql_fetch_object($sql)){
  $passwd = $record->$passwordField;
  }
  if($MD5 && $passwd == md5($_POST["password"])){
  $_SESSION["user"] = $_POST["login"];
  header("Location:"."/". "index.php");
  }else{
  header("Location: "."/".$_SESSION["pb"]);
  }
 */
?>
