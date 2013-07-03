<?php

/*
 * JPFLibs v 1.0 - Part of JPF framework.
 * (c) Jonas Delrue 2012 - Refer to the license file in the RBF primary directory.
 *
 * This file should be included from each single file of the project initializing all
 * needed variables and having functions to load other libs. Other libs should
 * have an Require.php file containing the require statements for all
 * needed files. This Require.php file will be loaded by JPFLibs.
 */
/*
 * Since this file is included anywhere it is a nice place to start a session. Comment out if not needed.
 */
session_start();

/*
 * Add vars that will be globally used in your project here. Or extend
 * the class in an included file.
 * JPFLibs manager is part of JPF framework
 */

class GlobalVars {

    static public $STARTPATH = "/jimbertestWebsite/";
    static public $DRIVEPATH = "/var/www/jimbertestWebsite/";
    static public $DATAPATH = "lib/JPF/Data/MySQL"; //where the data files are*
    static public $JPFPATH = "lib/JPF/";
    static public $SITEKEY = 'justakeythatnooneknows';
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
    require_once $_SERVER['DOCUMENT_ROOT'].GlobalVars::$STARTPATH."lib/JPF/Data/MySQL/SQL_Connector.php";

    $sqlconfig = new SQL_Connector("localhost","root","root", "jpftest");

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
 * Use like: "libadd("lib.JPF.Data.MySQL"); to include the data module.
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


?>
