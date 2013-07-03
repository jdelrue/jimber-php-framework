<?php
$debug=1;
require_once("../../JimberLibs.php");

libadd("lib.Jimber.Data.MySQL");

$myFile = GlobalVars::$DRIVEPATH.GlobalVars::$DATAPATH."/DB.SQL";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData =  get_structure();

fwrite($fh, $stringData);
header("Location: Generator.php");

?>
<?
function get_structure()
{

$tables = mysql_list_tables(SQL_Connector::getDBName());
     $SQL = Array();

while ($td = mysql_fetch_array($tables))
{

    if(substr($td[0],0,2) != "mw"){



        $table = $td[0];
        $r = mysql_query("SHOW CREATE TABLE `$table`");
        if ($r)
        {
        $insert_sql = "";
        $d = mysql_fetch_array($r);
        $d[1] .= ";";
   
       $SQL[] = str_replace("CREATE TABLE", "create table", $d[1]);
        $table_query = mysql_query("SELECT * FROM `$table`");
        $num_fields = mysql_num_fields($table_query);
//
//
//
//        while ($fetch_row = mysql_fetch_array($table_query))
//        {
//        $insert_sql .= "INSERT INTO $table VALUES(";
//        for ($n=1;$n<=$num_fields;$n++)
//        {
//        $m = $n - 1;
//        $insert_sql .= "'".mysql_real_escape_string($fetch_row[$m])."', ";
//        }
//        $insert_sql = substr($insert_sql,0,-2);
//        $insert_sql .= ");";
       }
        if ($insert_sql!= "")
        {
        $SQL[] = $insert_sql;
        }
//        }
    }
}
return  implode("\r\n", $SQL);
}
?>
