<?php
/**
 * Description of HiddenFieldPass
 *
 * @author jonas
 */
class HiddenFieldPass {
    var $ID;
    var $dbname;
    var $type; //Type of the control!
    var $inputname;
    var $tableType;
    var $GridElement;
    var $validator;
    var $currentValue;
    
    function HiddenFieldPass($ID,$dbname,$type, $currentValue, $tableType, $GridElement, $validator = NULL){
        $this->ID = $ID;
        $this->dbname = $dbname;
        $this->type = $type;
        $this->currentValue = $currentValue;
        $this->tableType = $tableType;
        $this->GridElement = $GridElement;
        $this->validator = $validator;
    }
}
?>
