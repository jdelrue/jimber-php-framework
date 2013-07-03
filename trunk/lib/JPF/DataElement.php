<?php

class ProcessedValue {

    var $dbname;
    var $currentvalue;
    var $value;

    function ProcessedValue($dbname, $currentvalue, $value) {
        $this->dbname = $dbname;
        $this->currentvalue = $currentvalue;
        $this->value = $value;
    }

}

class DataElement {

    var $fields;
    var $values;
    var $updateable;
    var $subGridRow;
    var $subGridHTM;
    var $varcharID;
    var $hiddenField;
    var $pageSize;
    var $page;
    var $sub;
    var $elements;
    var $totalCollectionSize;
    var $pageVar;
    var $search;
    var $processedValues; //Values for each field, already processed

    protected function DefineBlocks($tpl) {
        $tpl->DefineBlock("FORMBLOCK");
        $tpl->DefineBlock("FIELDS");
        $tpl->DefineBlock("ROWBLOCK");
        $tpl->DefineBlock("TABLEBLOCK");
        $tpl->DefineBlock("HIDDENFIELD");
        $tpl->DefineBlock("BUTTONBLOCK");
        $tpl->DefineBlock("SUBGRID");
        $tpl->DefineBlock("PRE");
        $tpl->DefineBlock("POPURL");
        $tpl->DefineBlock("PAGELINK");
        $tpl->DefineBlock("PAGELIST");
        $tpl->DefineBlock("PAGETEXT");
    }

    function AddElements($tpl) {
        if ($handle = opendir(GlobalVars::$DRIVEPATH . 'lib/JPF/Elements')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && $file != ".svn") {
                    require_once(GlobalVars::$DRIVEPATH . "lib/JPF/Elements/$file/$file.php");
                    if (file_exists(GlobalVars::$DRIVEPATH . "lib/JPF/Elements/$file/Field.php")) {
                        require_once(GlobalVars::$DRIVEPATH . "lib/JPF/Elements/$file/Field.php");
                    }
                    $element = new $file;
                    $element->DefineBlock($tpl);
                    $this->elements[$file] = $element;
                }
            }
        }
    }

    /*
     * Using the old way of passing all values to the Grid (slower) the total size
     * of the collection equals the count of the values. Using the new system, only the 
     * needed values are selected from the database using an SQLSelector class.
     * The count is then asked to the selector.
     */

    protected function processSelectorValues(&$start, &$stop) {
        /*
         * If search is set, the selector cannot be used. This would cause very small or
         * no amount of rows since not searched rows are deleted
         */
        if($this->search == ""){
            unset($this->search);
        }
        if (is_object($this->values) && get_class($this->values) == "SQLSelector" && isset($this->search)) {
            $selector = $this->values;
            $this->values = $selector->getAllValues();
        }
        if (is_object($this->values) && get_class($this->values) == "SQLSelector" && !isset($this->search)) {  // This is true if the new way is used
            $selector = $this->values;
            $this->totalCollectionSize = $selector->getCount();
        } else {
            $this->totalCollectionSize = count($this->values);
        }

        $start = ($this->page * $this->pageSize);
        $stop = $this->totalCollectionSize > $start + $this->pageSize ? $start + $this->pageSize : $this->totalCollectionSize; // If there are more values than the pagesize, add as many as the pagesize. Otherwise just show all values

        if (is_object($this->values) && get_class($this->values) == "SQLSelector" && !isset($this->search)) { // This is true if the new way is used
            $this->values = $selector->getValues($start, $this->pageSize);
            $stop = $stop - $start;

            $start = 0;
        }


        if (isset($this->search)) {
            $this->ApplySearch($start, $stop);
        }
    }

    protected function ApplySearch(&$start, &$stop) {
        $this->processedValues = Array();
        $numberOfFields = count($this->fields);
        $collectionCounter = 0;
        for ($i = 0; $i < $this->totalCollectionSize; $i++) {


            $rowSearchOccured = false;
            $this->processedValues[$collectionCounter] = Array();
            $rowArr = Array();

            for ($j = 0; $j < $numberOfFields; $j++) {

                $dbname = $this->fields[$j]->dbname;
                $currentvalue = $this->values[$i];
                $value = $this->FindValue($dbname, $currentvalue);
                $pcval = new ProcessedValue($dbname, $currentvalue, $value);
                $rowArr[$j] = $pcval;
                if (strpos(strtolower($value), strtolower($this->search)) !== false) {
                    $rowSearchOccured = true;
                }
            }

            if ($rowSearchOccured) {
                $this->processedValues[$collectionCounter] = Tools::ArrayCopy($rowArr);
                $collectionCounter++;
            }
        }
        $this->totalCollectionSize = $collectionCounter;
        $start = ($this->page * $this->pageSize);
        $stop = $this->totalCollectionSize > $start + $this->pageSize ? $start + $this->pageSize : $this->totalCollectionSize; // If there are more values than the pagesize, add as many as the pagesize. Otherwise just show all values
    }

    /*
     * The values can be used with a colon as seperator to find values
     * in linked tables. 
     * Example:
     *  songID:albumID:artistID:name
     * This function will loop trough the colons, selecting the right 
     * value at the end.
     * A single select is executed for each relation
     */

    protected function FindValue($dbname, $currentvalue) {

        $arr = explode(":", $dbname);
        if (count($arr) == 1) {
            if (isset($currentvalue->$dbname)) {
                return $currentvalue->$dbname;
            }
        }
        $ID = 0;
        for ($i = 0; $i < count($arr) - 1; $i++) {
            $identifStr = substr($arr[$i], -2);
            $first = substr($arr[$i], 0, 1);
            $tableName = strtoupper($first) . substr(str_replace($identifStr, "", $arr[$i]), 1);
            $ID = $currentvalue->$arr[$i];

            $var = new $tableName("'" . $ID . "'");
            $currentvalue = $var;
            if (isset($var->$arr[count($arr) - 1])) {
                $value = $var->$arr[count($arr) - 1];
            }
        }
        
        if (isset($value)) {

            return $value;
        } else {
            return "";
        }
    }

    function curPageURL() {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    protected function addNextPage($tpl) {

        if (isset($_GET[$this->pageVar])) {
            $curPagenumb = $_GET[$this->pageVar];
        } else {
            $curPagenumb = 0;
        }

        $urlNextPage = Tools::addParam(Tools::curPageURL(), $this->pageVar, $this->page + 1);

        $numberOfPages = ceil($this->totalCollectionSize / $this->pageSize);
        if ($numberOfPages > 1) {
            if ($this->page != $numberOfPages - 1 && ceil($this->totalCollectionSize) > $this->pageSize) {
                $tpl->setVars("PAGELINK", "TEXT", "Next &#187;");

                $tpl->setVars("PAGELINK", "LINK", $urlNextPage);

                return $tpl->ParseBlock("PAGELINK");
            } else {
                $tpl->setVars("PAGETEXT", "TEXT", "Next &#187;");
                $tpl->setVars("PAGETEXT", "CLASS", "next-off");

                return $tpl->ParseBlock("PAGETEXT");
            }
        } else {
            return false;
        }
    }

    /* Not Finished */

    protected function lastThreePages($tpl) {
        $linkstring = "";
        $numberOfPages = ceil($this->totalCollectionSize / $this->pageSize);
        if ($numberOfPages > 6) {


            for ($i = 0; $i < 3; $i++) {
                $curPage = $this->curPageURL();
                if (isset($_GET[$this->pageVar])) {
                    $curPagenumb = $_GET[$this->pageVar];
                } else {
                    $curPagenumb = 0;
                }
                $urlNextPage = Tools::addParam(Tools::curPageURL(), $this->pageVar, $this->page + 1);

                $showNum = ($numberOfPages - $i) + 1;
                $tpl->setVars("LINK", "TEXT", $showNum);
                $tpl->setVars("LINK", "LINK", $urlNextPage);
                $linkstring = $tpl->ParseBlock("LINK") . $linkstring;
            }
        }
        return " ... " . $linkstring;
    }

    /* Not Finished (shows all pages) */

    protected function firstThreePages($tpl) {
        $numberOfPages = ceil($this->totalCollectionSize / $this->pageSize);
        $linkstring = "";

        if ($numberOfPages > 2) {

            for ($i = 0; $i < $numberOfPages; $i++) {
                if (isset($_GET[$this->pageVar])) {
                    $curPagenumb = $_GET[$this->pageVar];
                } else {
                    $curPagenumb = 0;
                }
                $showNum = $i + 1;
                $urlNextPage = Tools::addParam(Tools::curPageURL(), $this->pageVar, $i);
                if ($i == $this->page) {
                    $tpl->setVars("PAGELINK", "CLASS", "active");
                } else {
                    $tpl->setVars("PAGELINK", "CLASS", "nactive");
                }
                $tpl->setVars("PAGELINK", "TEXT", ($showNum));
                $tpl->setVars("PAGELINK", "LINK", $urlNextPage);
                $linkstring .= $tpl->ParseBlock("PAGELINK");
            }
        }
        return $linkstring;
    }

    protected function addSort($dbname) {

        if (isset($_GET["sort"]) && $_GET["sort"] == $dbname) {
            if (isset($_GET["sortorder"]) && $_GET["sortorder"] == "ASC") {
                $sortURL = Tools::addParam(Tools::curPageURL(), "sort", $dbname);
                $sortURL = Tools::addParam($sortURL, "sortorder", "DESC");
            } else {
                $sortURL = Tools::addParam(Tools::curPageURL(), "sort", $dbname);
                $sortURL = Tools::addParam($sortURL, "sortorder", "ASC");
            }
        } else {
            $sortURL = Tools::addParam(Tools::curPageURL(), "sort", $dbname);
            $sortURL = Tools::addParam($sortURL, "sortorder", "DESC");
        }

        return $sortURL;
    }

    protected function addPrevPage($tpl) {
        if (isset($_GET[$this->pageVar])) {
            $curPagenumb = $_GET[$this->pageVar];
        } else {
            $curPagenumb = 0;
        }

        $urlNextPage = Tools::addParam(Tools::curPageURL(), $this->pageVar, $this->page - 1);

        $numberOfPages = ceil($this->totalCollectionSize / $this->pageSize);
        if ($numberOfPages > 1) {
            if ($this->page != 0) {
                $tpl->setVars("PAGELINK", "TEXT", "&#171; "."Previous");
                $tpl->setVars("PAGELINK", "LINK", $urlNextPage);

                return $tpl->ParseBlock("PAGELINK");
            } else {

                $tpl->setVars("PAGETEXT", "CLASS", "previous-off");
                $tpl->setVars("PAGETEXT", "TEXT", "&#171; "."Previous");

                return $tpl->ParseBlock("PAGETEXT");
            }
        } else {
            return false;
        }
    }

    protected function getPageNav($tpl) {
        $pagelist = $this->addPrevPage($tpl);

        $pagelist .= $this->firstThreePages($tpl); // For now this will show all pages
        $pagelist .=$this->addNextPage($tpl);
        $tpl->setVars("PAGELIST", "LIST", $pagelist);
        $pagelist = $tpl->ParseBlock("PAGELIST");
        return $pagelist;
    }
    
    /*
     * This gets the result of a non databinded form for use outside database. @todo multiple forms not supported yet
     */
    public static function getResult(){
        $result = $_SESSION['linktroughresult'];
        //unset($_SESSION['linktroughresult']);
        return $result;
    }

}

?>
