<?php
/**
 * This can be used to show arrays of all sorts? Including MySQL views
 *
 */
class GridView {
    var $page;
    var $view;
    var $sorting;
    function GridView($view, $page=0){
        $this->view = $view;
    }

    private function DefineBlocks($tpl){
        $tpl->DefineBlock("FORMBLOCK");
        $tpl->DefineBlock("FIELDS");
        $tpl->DefineBlock("ROWBLOCK");
        $tpl->DefineBlock("TABLEBLOCK");
        $tpl->DefineBlock("HIDDENFIELD");
        $tpl->DefineBlock("BUTTONBLOCK");
        $tpl->DefineBlock("SUBGRID");
        $tpl->DefineBlock("PRE");
        $tpl->DefineBlock("POPURL");
        $tpl->DefineBlock("COLUMNBLOCK");
        $tpl->DefineBlock("FIELDSLINKED");
        $tpl->DefineBlock("LINKBR");
        $tpl->DefineBlock("LINK");
    }

    public function BuildStandardGridView($addPageNavigator = false,$sub=false){

        $tpl = new Template("lib/Jimber/templates/StandardGrid.tpl");
        $this->DefineBlocks($tpl);
        $sorting = false;

        $record = "";

        $sql = mysql_query("select * from ".$this->view) or die ( mysql_error( ) );
        $Orders = Array();
        $first = true;
        $i = 0;
            $rows = "";
        while($record = mysql_fetch_object($sql)){
            $c = 0;
            $row = "";
            $fields = "";
            foreach ($record as $value => $name) {

                if($first){
                    $tpl->setVars("FIELDSLINKED", "FIELDNAME",$value);
                    //  $tpl->setVars("FIELDSLINKED", "PAGE",$this->addSort());
                    if($this->sorting){
                        $tpl->setVars("FIELDS", "FIELDNAME",$tpl->ParseBlock("FIELDSLINKED") );
                    }else{
                        $tpl->setVars("FIELDS", "FIELDNAME",$value);
                    }
                    $fields = $fields.$tpl->ParseBlock("FIELDS");
                    $c++;


                }
                $tpl->setVars("COLUMNBLOCK","CONTENT", $name);
                $row .= $tpl->ParseBlock("COLUMNBLOCK");
   

            }
            $i++;
            if($i%2==0){
                $tpl->setVars("ROWBLOCK","ROWCLASS", "odd");
            }else{
                 $tpl->setVars("ROWBLOCK","ROWCLASS", "even");
            }
             $tpl->setVars("ROWBLOCK","CONTENT", $row);
                $rows .= $tpl->ParseBlock("ROWBLOCK");
            $first = false;
        }




        $headerRow = $tpl->ParseBlock("ROWBLOCK");
/*
        $start = ($this->page*$this->pageSize);

        $stop = $numberOfValues > $start+$this->pageSize ? $start+$this->pageSize : $numberOfValues; // If there are more values than the pagesize, add as many as the pagesize. Otherwise just show all values
*/
        $tpl->setVars("TABLEBLOCK", "CONTENT", $fields.$rows);
        return $tpl->ParseBlock("TABLEBLOCK");

    }

    private function addNextPage($tpl){
        $curPage = $this->curPageURL();
        $curPagenumb = $_GET["page"];

        $indexOfPage = strpos($curPage,"page=");
        $indexOfQM = strpos($curPage,"?");

        if($indexOfPage == false){
            if($indexOfQM == false){
                $curPage .= "?page=".($this->page+1);
            }else{
                $curPage .= "&amp;page=".($this->page+1);
            }
        }else{
            $curPage = str_replace("page=".$curPagenumb,"amp;page=".($curPagenumb+1),$this->curPageURL());
        }

        $tpl->setVars( "LINKBR","TEXT","Next page >>");
        $tpl->setVars("LINKBR", "LINK", $curPage);
        return  $tpl->ParseBlock("LINKBR");
    }
    private function addSort($dbname){
        $sortURL = $this->curPageURL();

        $indexOfSort = strpos($sortURL,"sort=");
        $indexOfQM = strpos($sortURL,"?");

        if($indexOfSort == false){
            if($indexOfQM == false){
                $sortURL .= "?sort=".$dbname."&sortorder=ASC";
            }else{
                $sortURL .= "&amp;sort=".$dbname."&sortorder=ASC";
            }
        }else{
            if($_GET["sort"] == $dbname){
                if($_GET["sortorder"] == "ASC"){
                    $sortURL=  str_replace("sort=".$_GET["sort"]."&sortorder=ASC","sort=".$dbname."&sortorder=DESC",$this->curPageURL());
                }else{
                    $sortURL=  str_replace("sort=".$_GET["sort"]."&sortorder=DESC","sort=".$dbname."&sortorder=ASC",$this->curPageURL());
                }
            }else{
                $sortURL = str_replace("sort=".$_GET["sort"]."&sortorder=".$_GET["sortorder"],"sort=".$dbname."&sortorder=DESC",$this->curPageURL());
            }
        }

        return  $sortURL;
    }
    private function addPrevPage($tpl){
        $curPage = $this->curPageURL();
        $curPagenumb = $_GET["page"];

        $indexOfPage = strpos($curPage,"page=");
        $indexOfQM = strpos($curPage,"?");

        if($indexOfPage == false){
            if($indexOfQM == false){
                $curPage .= "?page=".($this->page-1);
            }else{
                $curPage .= "&amp;page=".($this->page-1);
            }
        }else{
            $curPage = str_replace("page=".$curPagenumb,"amp;page=".($curPagenumb-1),$this->curPageURL());
        }

        $tpl->setVars("LINK", "TEXT", "<< Previous page");
        $tpl->setVars("LINK", "LINK", $curPage);

        return  $tpl->ParseBlock("LINK");
    }
}

?>
