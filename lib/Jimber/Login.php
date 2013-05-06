<?php
class Login {
    
    var $passwordField;
    var $loginField;
    var $table;
    var $MD5;
    var $pb;
    function Login($table,$loginField, $passwordField,$pb, $MD5 = false){
        $this->loginField = $loginField;
        $this->passwordField = $passwordField;
        $this->table = $table;
        $this->MD5 = $MD5;
        $this->pb = $pb;
    }

    function BuildStandardLogin(){
        $tpl = new Template("lib/Jimber/templates/Login.tpl");
        $tpl->DefineBlock("LOGINBLOCK");
        $tpl->setVars("LOGINBLOCK", "POSTPAGE", GlobalVars::$STARTPATH."lib/Jimber/LoginPost.php");
        $hiddenHTM = $this->BuildSessionVars();
        $parsed = $tpl->ParseBlock("LOGINBLOCK");
        $parsed = $parsed.$hiddenHTM;
        return $parsed;
    }
    
    private function BuildSessionVars(){

        $_SESSION["table"] = $this->table;
        $_SESSION["loginf"] = $this->loginField;
        $_SESSION["paswf"] = $this->passwordField;
        $_SESSION["MD5"] = $this->MD5;
        $_SESSION["pb"] = $this->pb;
      }
}
?>
