<?php

/*
 * JimberLibs v 1.0 - Part of Jimber framework.
 * (c) Jonas Delrue 2012 - Refer to the license file in the RBF primary directory.
 *
 * This file should be included from each single file of the project initializing all
 * needed variables and having functions to load other libs. Other libs should
 * have an Require.php file containing the require statements for all
 * needed files. This Require.php file will be loaded by JimberLibs.
 */
/*
 * Since this file is included anywhere it is a nice place to start a session. Comment out if not needed.
 */
session_start();

/*
 * Add vars that will be globally used in your project here. Or extend
 * the class in an included file.
 * JimberLibs manager is part of Jimber framework
 */

class GlobalVars {

    static public $STARTPATH = "/jimber/";
    static public $DRIVEPATH = "/var/www/jimber/";
    static public $JPFPATH = "lib/Jimber/";
    static public $SITEKEY = 'lskdfhsfiohsafioh3';
    static public $DATEFORMAT = 'd/m/Y';
    
    private static $debug;

    public static function getDebug() {
        return self::$debug;
    }
    public static function setDebug($debug){
         self::$debug = $debug;
    }

}
/*
* Connect to the database here
*/
    require_once $_SERVER['DOCUMENT_ROOT'].GlobalVars::$STARTPATH."lib/jimber/Data/MySQL/SQL_Connector.php";
    $dbname = "";
    $sqlconfig = new SQL_Connector("hostname","login","password", "database");

    $mysqli =$sqlconfig->Connect();



/*
 * If the debug var is put before smartlibs is loaded, all errors and notices are shown.
 */
if (isset($debug)) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    GlobalVars::setDebug($debug);
}

/*
 * This function will include the Require.php file for each module.
 * Use like: "libadd("lib.Jimber.Data.MySQL"); to include the data module.
 */

function libadd($module) {
    $includeFile = $_SERVER['DOCUMENT_ROOT'] . GlobalVars::$STARTPATH . str_replace(".", "/", $module) . "/Require.php";
    $includePath = $_SERVER['DOCUMENT_ROOT'] . GlobalVars::$STARTPATH . str_replace(".", "/", $module);
    require_once ($includeFile);
}

function requireLogin($level) {
    if ($level == 0) {
        if (isset($_COOKIE["user"]) && $_COOKIE["user"] != "") {
            $_SESSION["user"] = $_COOKIE["user"];
        }

        if (!isset($_SESSION["user"])) {
            header("Location: login.php");
        }
    }
}
/*
 * this can be removed in PHP 5.4 enviroment. 
 */
 function hex2bin($hexstr)
    {
        $n = strlen($hexstr);
        $sbin="";  
        $i=0;
        while($i<$n)
        {      
            $a =substr($hexstr,$i,2);          
            $c = pack("H*",$a);
            if ($i==0){$sbin=$c;}
            else {$sbin.=$c;}
            $i+=2;
        }
        return $sbin;
    }

?>
