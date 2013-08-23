<?php

$root = $_SERVER['DOCUMENT_ROOT'];
/*
 * Imports trough SmartLibs
 */
$debug=1;
require_once '../../JPFLibs.php';

libadd("lib.JPF.Data.MySQL");
libadd("lib.JPF");


if ($handle = opendir('Elements')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != ".svn") {
            require_once("Elements/$file/$file.php");
        }
    }
}

// Find out how many updates should be performed (one per value)
$updateCount = $_POST["toUpdateCount"];
// Find out the type for the update (datatable)

$varchar = isset($_POST["varcharID"]);

$UpdateArr = Array();
$go = true;
foreach ($_POST as $post => $value) {

    if (substr($post, 0, 3) == "b64") {
        $base64String = substr($post, 3);
        $Arr = URLEncrypter::Decrypt($base64String);
        $pass = unserialize($Arr);

        if (isset($pass->validator)) {

            if ($pass->value = "") {
                echo "test";
            }
            if (!eregi($pass->validator, $value)) {
                echo "validator:" . $pass->validator;
                echo "\t value:" . $value . "<br>";

                $go = false;
            }
        }

        $gridElement = $pass->GridElement;
        $value = $gridElement->preUpdate($value);
        if ($value != "NO_UPDATE") {
        
            if (is_array($value)) {
                $i = 0;
                foreach ($value as $val) {
               
                    // echo count($UpdateArr[$pass->tableType][$i][$pass->dbname]) . "<br>";

                    $UpdateArr[$pass->tableType][$i][$pass->dbname] = array($val, $gridElement);
                    $i++;
                }
            } else {
                $UpdateArr[$pass->tableType][0][$pass->dbname] = array($value, $gridElement);
            }
        }
    }
}
if (!$go) {
    $_SESSION["griderror"] = $UpdateArr;
//echo "<script type=\"text/javascript\"> window.history.back() </script>";
} else {
    $_SESSION["griderror"] = "";
    /*     * ******* EXTRACT METHOD ************ */
    $string = "";


$mysqlQrs = Array();
    foreach ($UpdateArr as $Type => $uniVals) {
//Type will contain the current table, IDArr the array for the ID with values
     //   echo "handling $Type: <br>";

        $string = "";
//
    
        foreach ($uniVals as $counter => $ValArr) {
            $fields = "";
            $values = "";
            $string .= "insert into `$Type`";
          //  echo "IN $counter";
            foreach ($ValArr as $dbname => $val) {



              //  echo " $counter in here $dbname: " . $val[0] . "**<br>";
                if ($counter > 0) {
                    foreach ($UpdateArr[$Type][0] as $otherdbname => $otherval) {
                        if ($otherdbname != $dbname) {
                            if ($otherval[1]->updatable) {

                                $otherval[0] = $otherval[1]->Update($otherval[0]);
                                if ($otherval[0] != "false") {
                                    $fields .= $otherdbname . ",";

                                    $values .= "" . $otherval[0] . ",";
                                }
                            }
                        }
                    }
                }
                if ($val[1]->updatable) {

                    $val[0] = $val[1]->Update($val[0]);
                    if ($val[0] != "false") {
                        $fields .= $dbname . ",";

                        $values .= "" . $val[0] . ",";
                    }
                }
            }
            $fields = substr($fields, 0, -1); //remove last
            $values = substr($values, 0, -1);

            $string .= $start . "(" . $fields . ")" . " VALUES(" . $values . ");";
           array_push($mysqlQrs, $string);
           $string = "";
            # }
        }
    }
}
//echo "**" . $string;

$mysqli = SQL_Connector::getMysqliInstance();

foreach($mysqlQrs as $query){
    echo "<br>**".$query."**<br>";

	if (!$mysqli -> query($query)  && GlobalVars::getDebug()) { //
			echo $mysqli -> error;
		}

}
$id = mysql_insert_id();
$pb = str_replace("[ID]", $id, $_POST["PB"]); //last id for step stuff
header("Location: ".$pb);
?>
