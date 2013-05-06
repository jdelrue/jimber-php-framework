<?php

/**
 * The Grid class will build a standard, fully updatable datagrid of the data that is passed to it.
 *
 * @author jonasc
 */
class Form extends DataElement {

    var $type;
    var $postback;
    //These 2 should be merged in future versions to formType
    var $linktrough;
    var $insert;

    
    function Form($fields, $values, $updatable = false, $insert = false, $subGridRow = -1, $pageSize = 15, $page = 0, $pagevar="page") {
        $this->fields = $fields;
        $this->values = $values;
        $this->updateable = $updatable;
        $this->subGridRow = $subGridRow;
        $this->pageSize = $pageSize;
        $this->page = $page;
        $this->insert = $insert;
      //  $this->linktrough = false;
        if ($values == null) { //If there are no values there is an insert array so cheat the system
            $this->values = Array();
            $this->values[0]->entityType = $this->type;
            $this->values[0]->ID = 0;
        }
        $this->pageVar= $pagevar;
        
        //   if(isset($_GET["page"])){ // Not working with multiple forms/grids on one page!
        //     $this->page = $_GET["page"];
        //}
    }

    protected function DefineBlocks($tpl) {
        parent::DefineBlocks($tpl);
        $tpl->DefineBlock("VALIDATION");
                $tpl->DefineBlock("UNITBLOCK");
    }

    function BuildStandardForm($addPageNavigator = false, $sub = false) {

        $UniqueFormID=Tools::random_string(5);
        $tpl = new Template("lib/Jimber/templates/StandardForm.tpl");
     
        $this->DefineBlocks($tpl);
        $this->AddElements($tpl);
        $numberOfFields = count($this->fields);

        $fields = "";

        $tpl->setVars("ROWBLOCK", "CONTENT", $fields);
        $headerRow = $tpl->ParseBlock("ROWBLOCK");

        $hiddenFieldsForHandling = Array();
        $hiddenFieldsCount = 0;
        $numberOfValues = count($this->values);



        $dataRows = $this->BuildDataRow($tpl, $numberOfFields, $numberOfValues, $UniqueFormID);


        $tpl->setVars("TABLEBLOCK", "CONTENT", $headerRow . $dataRows);

        if ($this->varcharID) {
            $tpl->setVars("HIDDENFIELD", "NAME", "varcharID"); //@TODO add it back!!
            $tpl->setVars("HIDDENFIELD", "VALUE", "YES");
            $hiddenFieldsForHandling[$hiddenFieldsCount] = $tpl->ParseBlock("HIDDENFIELD");
            $hiddenFieldsCount++;
        }


        $tpl->setVars("HIDDENFIELD", "NAME", "PB");
        if (!isset($this->postback)) {
            $tpl->setVars("HIDDENFIELD", "VALUE", $this->curPageURL());
        } else {
            $tpl->setVars("HIDDENFIELD", "VALUE", GlobalVars::$STARTPATH . $this->postback);
        }
        $hiddenFieldsForHandling[$hiddenFieldsCount] = $tpl->ParseBlock("HIDDENFIELD");
        // $hiddenFieldsCount++;
        $hiddenFields = "";
        for ($i = 0; $i <= $hiddenFieldsCount; $i++) {
            $hiddenFields = $hiddenFields . $hiddenFieldsForHandling[$i];
        }
        $table = $tpl->ParseBlock("TABLEBLOCK");

        $extra = "";
        if ($addPageNavigator) { //@todo be sure to not add it anymore add the end
     $extra .= $this->getPageNav($tpl);
        }
        if ($this->updateable && !$sub) {
            $extra .= $hiddenFields . $tpl->ParseBlock("BUTTONBLOCK");
        }
        $_SESSION["griderror"] = "";

        if (!$sub) {
               
            if (isset($validators)) {
                $tpl->setVars("FORMBLOCK", "CODE", $validators); //Add validator code
            }
            $tpl->setVars("FORMBLOCK", "CONTENT", $table . $extra);
            $tpl->setVars("FORMBLOCK", "POSTPAGE", GlobalVars::$STARTPATH."lib/Jimber/GridPost.php");
            $tpl->setVars("FORMBLOCK", "UID", $UniqueFormID);
            if(isset($this->class)){
                        $tpl->setVars("FORMBLOCK", "CLASS", $this->class);
            }
            if ($this->insert || isset($this->linktrough)) {
                if (isset($this->linktrough)) { // A linktrough form will POST to another page
                    $tpl->setVars("FORMBLOCK", "POSTPAGE", GlobalVars::$STARTPATH."lib/Jimber/GridPostLinkTrough.php");
                } else {
                    $tpl->setVars("FORMBLOCK", "POSTPAGE", GlobalVars::$STARTPATH."lib/Jimber/GridPostAdd.php");
                }
            }
            return $tpl->ParseBlock("FORMBLOCK");
        } else {

            return $table . $extra;
        }
    }

    private function BuildDataRow($tpl, $numberOfFields, $numberOfValues, $uid) {
        $start = ($this->page * $this->pageSize);
        $stop = $numberOfValues > $start + $this->pageSize ? $start + $this->pageSize : $numberOfValues; // If there are more values than the pagesize, add as many as the pagesize. Otherwise just show all values

        $dataRows = "";
        $validators = "";
        
        $this->processSelectorValues($start, $stop);
        
        for ($i = $start; $i < $stop; $i++) {
          $unitdataRows = "";
            for ($j = 0; $j < $numberOfFields; $j++) {

                $dataRow = "";
                $dbname = $this->fields[$j]->dbname;
                $field = $this->fields[$j];
                $field->UID=$uid;
                $currentvalue = $this->values[$i];

                $element = $this->elements[$field->type];
                $element->PreBuild($field, $tpl);
               
                $value = $this->FindValue($dbname, $currentvalue);
 
                if (isset($field->datatype)) {
                    $type = $field->datatype;
                } else if ($currentvalue->entityType == "") {
                    $type = $this->type;
                } else {
                    $type = $currentvalue->entityType;
                }

                $name = new HiddenFieldPass($currentvalue->ID, $dbname, $type, $value, $type, $element, $field->validator);
                $ser = serialize($name);
                $base = URLEncrypter::Encrypt($ser);
                //VALIDATION
                if ($field->validator != "") {
                    $tpl->setVars("VALIDATION", "FORMNAME", "StandardForm");
                    $tpl->setVars("VALIDATION", "CONTROLNAME", $base);
                    $tpl->setVars("VALIDATION", "REGEX", $field->validator);
                    $tpl->setVars("VALIDATION", "FIELDNAME", $field->showname);
                    $validators = $tpl->ParseBlock("VALIDATION");
                }

                $text = $element->Build($tpl, "b64" . $base, $value, $field, $currentvalue, $this->values);
                $dataRow .= $text;

                $dbname = $this->fields[$j]->dbname;
                $tpl->setVars("FIELDS", "FIELDNAME", $this->fields[$j]->showname);
                $fields = $tpl->ParseBlock("FIELDS");

                $tpl->setVars("ROWBLOCK", "CONTENT", $fields . $dataRow);
                if(isset( $this->fields[$j]->class)){
                          $tpl->setVars("ROWBLOCK", "CLASS", $this->fields[$j]->class);
                }
               
                $unitdataRows.=$tpl->ParseBlock("ROWBLOCK");
               
            }
          $tpl->setVars("UNITBLOCK","CONTENT", $unitdataRows);
      //    $unitdataRows = "";
                $dataRows = $dataRows . $tpl->ParseBlock("UNITBLOCK");
        }
        return $dataRows;
    }

 




}

?>
