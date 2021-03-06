<?php

/*
 * This file will handle anything after a grid has been updated
 * Steps to perform:
 * 1. Require elements from the elements folder
 * 2. Unserialize posted gridelement
 * 3. Create update array if validator is ok
 * 4. Create update statements for each row
 * 5. execute update statements
 */

$root = $_SERVER['DOCUMENT_ROOT'];
/*
 * Imports trough SmartLibs
 */
require_once '../JPFLibs.php';

libadd("lib.JPF.Data.MySQL");
libadd("lib.JPF");
requireLogin(0);

if ($handle = opendir('Elements')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != ".svn") {
            require_once("Elements/$file/$file.php");
        }
    }
}
if (isset($_POST["printbutton"])) {
    
}

// Find out how many updates should be performed (one per value)
//$updateCount =  $_POST["toUpdateCount"];
// Find out the type for the update (datatable)

$varchar = isset($_POST["varcharID"]);

$UpdateArr = Array();
$i = 0;


foreach ($_POST as $post => $value) {
    $uidUsed = strpos($post, "UID"); //This is bad! Checkboxes are only sent when checked so accompanied by a hidden field that has the samen name but UID added the difference can be made. Find better solution


    $post = str_replace("UID", "", $post);

    if (substr($post, 0, 3) == "b64") {
        $base64String = substr($post, 3);
        $Arr = URLEncrypter::Decrypt($base64String);

        $pass = unserialize($Arr);

        $gridElement = $pass->GridElement;
        if (!$uidUsed) {
            $value = $gridElement->preUpdate($value);
        }


        $UpdateArr[$pass->tableType][$pass->ID][$pass->dbname] = array($value, $gridElement);
    }
}

/* * ******* EXTRACT METHOD ************ */
$statements = Array();
$string = "";
$i = 0;
foreach ($UpdateArr as $Type => $IDArr) {
    //Type will contain the current table, IDArr the array for the ID with values


    foreach ($IDArr as $ID => $ValArr) {
        //ID will contain the current ID, ValArr the values


        foreach ($ValArr as $dbname => $val) {
            if ($val[1]->updatable) {
                $val[0] = $val[1]->Update($val[0]);
                if ($val[0] == "" || $val[0] == "''") {
                    $string .= $dbname . "=null,";
                } else if ($val[0] != "false") {
                   
                    $statements[$dbname]=$val[0];

                }
            }
        }
   //     $statements[$i] = $string;
        $i++;
    }
}

  $mysqli = SQL_Connector::getMysqliInstance();
       
        
foreach($statements as $key => $val){
        $sqlstr = "select ".$val;
        $result = $mysqli->query($sqlstr);
        $arr = $result->fetch_array();
        $statements[$key] = $arr[0];
}

$_SESSION['linktroughresult'] = $statements;

header("Location: " . $_POST["PB"].$string);
?>
