<?php

session_start();
require_once("../../../JPFLibs.php");
libadd("lib.JPF");
libadd("lib.JPF.Data.MySQL");

 $month = DateTools::getCurrentoMnth();
if (isset($_GET['calmonthCal2'])) {
    $month = $_GET['calmonthCal2'];
}

 $year =  date("Y");
 
if (isset($_GET['yearCal2'])) {
    $year = $_GET['yearCal2'];
} 


$cal2 = new Calendar($month, $year, "Cal2");
$cal2->preURL = "javascript:void(0);";
$cal2->FUID= $_GET['FUID'];
$cal2->extraURL = "onclick=\"opener.addDate{{FUID}}('{{DATE}}');window.close();\"";
//$cal2->browseable=false;
echo $cal2->BuildStandardCalendar(); //@todo template
?>
