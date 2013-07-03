<?php
class LoginIDM {
    
    function LoginIDM(){

    }

    function BuildStandardLogin(){
        $tpl = new Template("Lib/Jimber/templates/Login.tpl");
        $tpl->DefineBlock("LOGINBLOCK");
        $tpl->setVars("LOGINBLOCK", "POSTPAGE", "LoginPost.php");
        $hiddenHTM = $this->BuildSessionVars();
        $parsed = $tpl->ParseBlock("LOGINBLOCK");
        $parsed = $parsed.$hiddenHTM;
        return $parsed;
    }
    
    private function BuildSessionVars(){
      }
}
?>
