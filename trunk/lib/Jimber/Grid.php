<?php

/**
 * The Grid class will build a standard, fully updatable datagrid of the data that is passed to it.
 *
 * @author jonas
 */
class Grid extends DataElement {

    var $sorting;
    var $customID; // Custom table ID for css styles

    function Grid($fields, $values, $updatable = false, $subGridRow = -1, $pageSize = 20, $page = 0, $pageVar = "page") {
        $this->fields = $fields;
        $this->values = $values;
        $this->updateable = $updatable;
        $this->subGridRow = $subGridRow;
        $this->pageSize = $pageSize;
        $this->page = $page;
        $this->pageVar = $pageVar;
    }

    protected function DefineBlocks($tpl) {
        parent::DefineBlocks($tpl);
        $tpl->DefineBlock("COLUMNBLOCK");
        $tpl->DefineBlock("FIELDSLINKED");
        $tpl->DefineBlock("LINKBR");
        $tpl->DefineBlock("LINK");
        $tpl->DefineBlock("TEXT");
        $tpl->DefineBlock("PAGELINK");
        $tpl->DefineBlock("PAGELIST");
        $tpl->DefineBlock("PAGETEXT");
    }

    function BuildSubGrid() {

        return $this->PrivateBuildStandardGrid(false, true);
    }

    function BuildStandardGrid($addPageNavigator = false) {

        return $this->PrivateBuildStandardGrid($addPageNavigator, false);
    }

    private function PrivateBuildStandardGrid($addPageNavigator = false, $sub = false) {
        $UniqueFormID = Tools::random_string(5);
        $tpl = new Template("lib/Jimber/templates/StandardGrid.tpl");

        $this->DefineBlocks($tpl);
        $this->AddElements($tpl);
        $numberOfFields = count($this->fields);

        $fields = $this->BuildFields($tpl, $numberOfFields);



        $tpl->setVars("ROWBLOCK", "CONTENT", $fields);
        $headerRow = $tpl->ParseBlock("ROWBLOCK");

        $hiddenFieldsForHandling = Array();
        $hiddenFieldsCount = 0;


        $tpl->setVars("FORMBLOCK", "UID", $UniqueFormID);
        $tpl->setVars("FORMBLOCK", "ACTION", GlobalVars::$STARTPATH . "lib/Jimber/GridPost.php");

        $dataRows = $this->BuildDataRows($tpl, $numberOfFields, $UniqueFormID);
        $numberOfValues = $this->totalCollectionSize;

        if (isset($this->customID)) {
            $tpl->setVars("TABLEBLOCK", "ID", $this->customID);
        } else {
            $tpl->setVars("TABLEBLOCK", "ID", Tools::random_string(5));
        }
        $tpl->setVars("TABLEBLOCK", "CONTENT", $headerRow . $dataRows);
        //This is when a varchar is used instead of INT as ID. Check it out!
        /*  if($this->varcharID){
          $tpl->setVars("HIDDENFIELD", "NAME", "varcharID"); //@TODO add it back!!
          $tpl->setVars("HIDDENFIELD", "VALUE", "YES");
          $hiddenFieldsForHandling[$hiddenFieldsCount] =$tpl->ParseBlock("HIDDENFIELD");
          $hiddenFieldsCount++;
          } */


        $tpl->setVars("HIDDENFIELD", "NAME", "PB");
        $tpl->setVars("HIDDENFIELD", "VALUE", $this->curPageURL());

        $hiddenFieldsForHandling[$hiddenFieldsCount] = $tpl->ParseBlock("HIDDENFIELD");
        $hiddenFieldsCount++;
        $hiddenFields = "";

        for ($i = 0; $i <= $hiddenFieldsCount; $i++) {
            if (isset($hiddenFieldsForHandling[$i])) {
                $hiddenFields = $hiddenFields . $hiddenFieldsForHandling[$i];
            }
        }
        if (isset($this->subtitle)) {
            $tpl->setVars("TABLEBLOCK", "TITLE", $this->subtitle); //@todo empty span possible
        }
        $table = $tpl->ParseBlock("TABLEBLOCK");
        $extra = "";

        if ($addPageNavigator) {
            $extra .= $this->getPageNav($tpl);
        }

        $_SESSION["griderror"] = "";
        if ($this->updateable && !$sub) {
            $extra .= $hiddenFields . $tpl->ParseBlock("BUTTONBLOCK");
        }

        if (!$sub) {
            $tpl->setVars("FORMBLOCK", "CONTENT", $table . $extra);
            return $tpl->ParseBlock("FORMBLOCK");
        } else {

            return $table . $extra;
        }
    }

    /*
     * Function will build the labels (table headers) for the fields 
     * using the dbname and the displayname. When sorting is enabled
     * the field is linked to sort to the right column.
     * 
     */

    private function BuildFields($tpl, $numberOfFields) {
        $fields = "";
        for ($i = 0; $i < $numberOfFields; $i++) {
            $tpl->setVars("FIELDSLINKED", "FIELDNAME", $this->fields[$i]->showname);
            $tpl->setVars("FIELDSLINKED", "PAGE", $this->addSort($this->fields[$i]->dbname));
            if ($this->sorting) {
                $tpl->setVars("FIELDS", "FIELDNAME", $tpl->ParseBlock("FIELDSLINKED"));
            } else {
                $tpl->setVars("FIELDS", "FIELDNAME", $this->fields[$i]->showname);
            }
            $fields = $fields . $tpl->ParseBlock("FIELDS");
        }
        return $fields;
    }

    /*
     * Function will build the datarows 
     */

    protected function BuildDataRows($tpl, $numberOfFields, $uid) {

        $start = 0;
        $stop = 0;

        $this->processSelectorValues($start, $stop);

        $dataRows = "";
        for ($i = $start; $i < $stop; $i++) {
            $dataRow = "";
            for ($j = 0; $j < $numberOfFields; $j++) {
                $dbname = $this->fields[$j]->dbname;
                $field = $this->fields[$j];
                $field->UID = $uid;
                $currentvalue= "";
                $value = "";
               // echo $this->processedValues[$i];
                if (isset($this->processedValues)) {
    
                   $currentvalue = $this->processedValues[$i][$j]->currentvalue;
                    $value = $this->processedValues[$i][$j]->value;
                }else{
             
                    $currentvalue = $this->values[$i];
                    $value = $this->FindValue($dbname, $currentvalue);
               }
               

                $element = $this->elements[$field->type];
                $element->PreBuild($field, $tpl);

               
                $ID = isset($currentvalue->ID) ? $currentvalue->ID : "";
                // A hiddenfieldpass is created and serialized. This becomes the name of the input. Contains all data to insert in table.
                $name = new HiddenFieldPass($ID, $dbname, $field->type, $value, $currentvalue->entityType, $element, $field->validator);

                //  $value = $currentvalue->$dbname; @todo include validation for grid, in method not here
                //                if (isset($_SESSION["griderror"])){
                //                    echo $UpdateArr[$currentvalue->entityType][$currentvalue->ID][$dbname][0];
                //VALIDATION:
                if (isset($field->validator)) {
                    $tpl->DefineBlock("VALIDATION");
                    $tpl->setVars("VALIDATION", "FORMNAME", "StandardForm");
                    $tpl->setVars("VALIDATION", "CONTROLNAME", $name);
                    $tpl->setVars("VALIDATION", "REGEX", $field->validator);
                    $tpl->setVars("GRIDBLOCK", "SCRIPT", $tpl->ParseBlock("VALIDATION"));
                }
                $ser = serialize($name);
                $base = URLEncrypter::Encrypt($ser);
                $text = $element->Build($tpl, "b64" . $base, $value, $field, $currentvalue, $this->values[$i]);
                $tpl->setVars("COLUMNBLOCK", "CONTENT", $text);
                if (isset($this->fields[$j]->class)) {
                    $tpl->setVars("COLUMNBLOCK", "CLASS", $this->fields[$j]->class);
                } else {
                    $tpl->setVars("COLUMNBLOCK", "CLASS", "default");
                }
                $text = $tpl->ParseBlock("COLUMNBLOCK", "CONTENT");
                $dataRow .= $text;
                // $hiddenFieldsCount++;
            }
            $subRow = "";

            if ($i % 2 == 1) {
                $tpl->setVars("SUBGRID", "SUBCLASS", "odd");
                $tpl->setVars("ROWBLOCK", "ROWCLASS", "odd");
            } else {
                $tpl->setVars("SUBGRID", "SUBCLASS", "even");
                $tpl->setVars("ROWBLOCK", "ROWCLASS", "even");
            }

            if (isset($currentvalue->ID) && ($currentvalue->ID === $this->subGridRow)) {
                $tpl->setVars("SUBGRID", "FIELDS", $numberOfFields);
                $tpl->setVars("SUBGRID", "CONTENT", $this->subGridHTM);
                $subRow = $tpl->ParseBlock("SUBGRID");
                $dataRow .= $subRow;
            }

            $tpl->setVars("ROWBLOCK", "CONTENT", $dataRow);
            $dataRows = $dataRows . $tpl->ParseBlock("ROWBLOCK");
        }
        return $dataRows;
    }

}

?>
