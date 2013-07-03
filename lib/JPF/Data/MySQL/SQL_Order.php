<?php

/*
 * The SQL Order class will creaty an order string for a SQL query ("order by... ")
 * 
 * The order will use the :: notation to search deeper in tables ( "order by houseID:roomID:tableID" )
 */
class SQL_Order {

    var $field;
    var $orderway;
    var $startLimit;
    var $stopLimit;

    function SQL_Order($field, $orderway = "DESC", $startLimit = "", $stopLimit = "") {
        $this->field = $field;
        $this->orderway = $orderway;
        if ($startLimit != "") {
            $this->startLimit = $startLimit;
            $this->stopLimit = $stopLimit;
        }
    }

    function BuildOrder() {

        $filter = $this->field;
        $arr = explode(":", $filter);

        $sql = "";
        $numberOfLevels = count($arr);

        if ($numberOfLevels == 1) {
            $sql =  " " . $this->field . " " . $this->orderway;
            if (isset($this->startLimit)) {
                //$sql .= " LIMIT " . $this->startLimit . "," . $this->stopLimit;
            }
            return $sql;
        }

        for ($i = 0; $i < $numberOfLevels - 1; $i++) { //untested with limit! 9/5/12

            $lastsql = $sql;
            $levelname = $arr[$i];
            $first = substr($levelname, 0, 1);
            $tableName = strtoupper($first) . substr(str_replace("ID", "", $levelname), 1);

            $sql = "(select " . $arr[$i + 1] . " from `$tableName` where ID=";
            if ($i == 0) {

                $sql .= $levelname;
                if (isset($this->startLimit)) {
               //     $sql .= " LIMIT " .  $this->startLimit . "," . $this->stopLimit;
                }
                $sql .= ")";
            } else {
                $sql .= $lastsql;
                if (isset($this->startLimit)) {
                 //   $sql .= " LIMIT " .  $this->startLimit . "," .  $this->stopLimit;
                }
                $sql .= ")";
            }
        }
        return $sql . " " . $this->orderway;
    }

}

?>
