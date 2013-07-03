<?php

/*
 * RFB Calendar is a quick way to build a calendar that can be used for many things
 * 
 */

class CalendarEvent {

   var $eventID;
    var $eventName;
    var $eventDate;
    var $eventCSSClass;
    var $preURL;

    function CalendarEvent($eventID, $eventName, $eventDate, $eventCSSClass) {
        $this->eventName = $eventName;
        $this->eventDate = $eventDate;
        $this->eventCSSClass = $eventCSSClass;
    }

}

class Calendar {

    var $days;
    var $tpl; //template
    var $month;
    var $year;
    var $ID;
    var $browseable; //If flag is not set 
    var $preURL; //Will make an URL of each day, having this in front
    var $extraURL;
    var $FUID;
    var $eventsArray; //date, event, cssclass of each event

    function Calendar($month, $year, $ID = "") {
        $this->browseable = true;
        $this->ID = $ID;
        $this->days = DateTools::getMonth($month, $year);
        $this->month = $month;
        $this->year = $year;
        $this->eventsArray = Array();

        $this->tpl = new Template("lib/Jimber/templates/Calendar.tpl");

        $this->DefineBlocks($this->tpl);
    }

    /*
     * This function will add events to the calendar, an array is passed containing the events,
     * the events are added in the right column and the CSS class is used for layout purposes
     */

    function AddEvents($eventsArray, $datecolumn, $eventcolumn, $cssClass = "event") {

        $count = count($eventsArray);

        for ($i = 0; $i < $count; $i++) {
            $calendarEvent = new CalendarEvent($eventsArray[$eventcolumn], $eventsArray[$datecolumn], $eventsArray[$cssClass]);

            array_push($this->eventsArray, $calendarEvent);
        }
    }

    function AddCalendarEvents($eventsArray) {

        $count = count($eventsArray);

        for ($i = 0; $i < $count; $i++) {

            array_push($this->eventsArray, $eventsArray[$i]);
        }
    }

    private function BuildEventsForDay($day) {

        $count = count($this->eventsArray);
        $dayHtm = "";

        for ($i = 0; $i < $count; $i++) {
           //  
                 $date = new DateTime($day);
            $date = $date->format('d/m/Y');
       // echo $date."==".$this->eventsArray[$i]->eventDate."<br>";
            if ($date == $this->eventsArray[$i]->eventDate) {
                if (isset($this->eventsArray[$i]->preURL)) {
                    $this->tpl->setVars("LINKEDEVENTBLOCK", "EVENT", $this->eventsArray[$i]->eventName);
                    $this->tpl->setVars("LINKEDEVENTBLOCK", "CLASS", $this->eventsArray[$i]->eventCSSClass);

                    $this->tpl->setVars("LINKEDEVENTBLOCK", "LINK", $this->eventsArray[$i]->preURL . "?eventname=" . $this->eventsArray[$i]->eventName); //should be some sort of ID
                    $dayHtm .= $this->tpl->ParseBlock("LINKEDEVENTBLOCK");
                } else {
                    $this->tpl->setVars("EVENTBLOCK", "EVENT", $this->eventsArray[$i]->eventName);
                    $this->tpl->setVars("EVENTBLOCK", "CLASS", $this->eventsArray[$i]->eventCSSClass);
                    $dayHtm .= $this->tpl->ParseBlock("EVENTBLOCK");
                }
            }
        }

        return $dayHtm;
    }

    function BuildStandardCalendar() {

        $tpl = $this->tpl;
        $firstDayOfWeek = $this->days[1];
        $row = "";
        $allRows = "";

        for ($i = 1; $i < $firstDayOfWeek; $i++) {
            $tpl->setVars("CALENDARCOL", "DAY", "");
            $row .= $tpl->ParseBlock("CALENDARCOL");
        }
        $dayTD = "";
        foreach ($this->days as $dayOfMonth => $dayOfWeek) {
            if (isset($this->preURL)) {
                $tpl->setVars("LINK", "LINK", $this->preURL);
                $tpl->setVars("LINK", "TEXT", $dayOfMonth);
                if (isset($this->extraURL)) {
                    $tpl->setVars("LINK", "EXTRA", $this->extraURL);

                    $tpl->setVars("LINK", "DATE", $dayOfMonth . "/" . $this->month . "/" . $this->year); //Anywhere in the link, DATE var is replaced
                    $tpl->setVars("LINK", "FUID", $this->FUID); //Anywhere in the link, DATE var is replaced
                }
                $dayTD = $tpl->parseBlock("LINK");
            } else {
                $dayTD = $dayOfMonth;
            }
            if (DateTools::isToday($this->month . "/" . $dayOfMonth . "/" . $this->year)) {
                $tpl->setVars("TODAY", "DAY", $dayTD);
                $tpl->setVars("TODAY", "EVENTS", $this->BuildEventsForDay($this->month . "/" . $dayOfMonth . "/" . $this->year));

                $row .= $tpl->ParseBlock("TODAY");
            } else {
                $tpl->setVars("CALENDARCOL", "DAY", $dayTD);
                $tpl->setVars("CALENDARCOL", "EVENTS", $this->BuildEventsForDay($this->month . "/" . $dayOfMonth . "/" . $this->year));
                $row .= $tpl->ParseBlock("CALENDARCOL");
            }

            if ($dayOfWeek == 7 || $dayOfMonth == count($this->days)) {
                $tpl->setVars("CALENDARROW", "ROW", $row);
                $allRows .= $tpl->ParseBlock("CALENDARROW");
                $row = "";
            }
        }
        $this->addBrowseButtons($tpl);
        $tpl->setVars("CALENDAR", "ALLROWS", $allRows);
        return $tpl->ParseBlock("CALENDAR");
    }

    protected function addBrowseButtons($tpl) {

        $curPage = Tools::curPageURL();
        if ($this->browseable) {
            if ($this->month > 1) {
                $tpl->setVars("BROWSEBUTTONS", "PREV", Tools::addParam(Tools::curPageURL(), "calmonth" . $this->ID, $this->month - 1));
            }
            if ($this->month < 12) {
                $tpl->setVars("BROWSEBUTTONS", "NEXT", Tools::addParam(Tools::curPageURL(), "calmonth" . $this->ID, $this->month + 1));
            }
            if ($this->month == 1) {
                $lastMonthLastYear = Tools::addParam($curPage, "calmonth" . $this->ID, 12);
                $lastMonthLastYear = Tools::addParam($lastMonthLastYear, "year" . $this->ID, $this->year - 1);
                $tpl->setVars("BROWSEBUTTONS", "PREV", $lastMonthLastYear);
            }
            if ($this->month == 12) {
                $lastMonthLastYear = Tools::addParam($curPage, "calmonth" . $this->ID, 1);
                $lastMonthLastYear = Tools::addParam($lastMonthLastYear, "year" . $this->ID, $this->year + 1);
                $tpl->setVars("BROWSEBUTTONS", "NEXT", $lastMonthLastYear);
            }

            $tpl->setVars("BROWSEBUTTONS", "MONTH", date("F", mktime(0, 0, 0, $this->month, 1, 2000)));
            $tpl->setVars("BROWSEBUTTONS", "YEAR", $this->year);

            $tpl->setVars("CALENDAR", "BROWSEBUTTONS", $tpl->ParseBlock("BROWSEBUTTONS"));
        } else {

            $tpl->setVars("CALENDAR", "YEAR", $this->year);
            $tpl->setVars("CALENDAR", "MONTH", date("F", mktime(0, 0, 0, $this->month, 1, 2000)));
        }
    }

    protected function DefineBlocks($tpl) {
        $tpl->DefineBlock("CALENDAR");
        $tpl->DefineBlock("LINK");
        $tpl->DefineBlock("TODAY");
        $tpl->DefineBlock("CALENDARCOL");
        $tpl->DefineBlock("CALENDARROW");
        $tpl->DefineBlock("BROWSEBUTTONS");
        $tpl->DefineBlock("EVENTBLOCK");
        $tpl->DefineBlock("LINKEDEVENTBLOCK");
    }

}

?>
