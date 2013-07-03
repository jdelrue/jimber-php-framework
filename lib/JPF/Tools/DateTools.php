<?php

class DateTools {

    public static function getMonth($month, $year) {
        $lastday = date('t', strtotime($year . "/" . $month . "/1"));
        $dayArr = Array();
        for ($i = 1; $i <= $lastday; $i++) {
            $dayArr[$i] = date('N', strtotime($year . "/" . $month . "/" . $i)); //get day of week
        }
        return $dayArr;
    }

    public static function getCurrentoMnth() {
        return date("m");
    }

    public static function isToday($date) { //check if it's today
        $date = date("l, F d", strtotime($date));
        if ($date == date("l, F d"))
            return true;
        else
            return false;
    }

    public static function getToday() {
        return date(GlobalVars::$DATEFORMAT);
    }

    public static function getDate($date) {
        return date(GlobalVars::$DATEFORMAT, $date);
    }

    public static function getWeekFromDate($date) {
        $week = date("W", strtotime($date));
        return $week;
    }

    public static function isYesterday($date) { //check if it's yesterday
        $date = date("l, F d", strtotime($date));
        if ($date == date("l, F d") - 1)
            return true;
        else
            return false;
    }

}

?>
