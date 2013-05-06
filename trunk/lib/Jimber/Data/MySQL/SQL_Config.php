<?php
/**
 * Description of SQL_Config
 *
 * @author jonas
 */

    require_once("SQL_Connector.php");

    $dbname = "mng";
    $sqlconfig = new SQL_Connector("hostname","login","password", "database");

    
    $mysqli =$sqlconfig->Connect();
?>
