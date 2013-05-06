<?php

/*
 * An SQLSelector uses a MYSQL Database as source.
 */

class SQLSelector extends Selector {

    var $type;
    var $args;
    var $order;

    function SQLSelector($type, $args = "", $order = NULL) {
        $this->type = $type;
        $this->args = $args;
        $this->order = $order;
    }

    function getValues($start, $stop) {
        $type = $this->type;
        $function = "Select";
        if(isset($this->order)){
        $this->order->startLimit = $start;
        $this->order->stopLimit = $stop;     
        }
   
        return $type::$function($this->args, $this->order,"LIMIT $start, $stop"); //Will call something like selectDataType

    }

    function getAllValues() {
        $type = $this->type;
        $function = "Select";

        return $type::$function($this->args, $this->order); //Will call something like selectDataType
    }

    function getCount() {
        $type = $this->type;
        $args = $this->args;
        $sqlstr = "Select * from `$type` $args";
        if (isset($this->order)) {
            $orderstr = $this->order->BuildOrder();
            $sqlstr = "select * from ($sqlstr) as t ORDER BY" . $orderstr;
        }
        $sql = mysql_query("select count(*) as count from ($sqlstr) test") or die(mysql_error());
        while ($record = mysql_fetch_object($sql)) {
            return $record->count;
        }
        return false;
    }

}

?>
