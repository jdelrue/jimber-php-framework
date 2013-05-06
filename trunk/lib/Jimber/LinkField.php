<?php
/**
 * Description of LinkField
 *
 * @author jonas
 * 2009 Excentis NV
 */
class LinkField {

    var $checked;
    var $dbname;
    var $showname;

    function LinkField($checked, $dbname, $showname){
        $this->checked = $checked;
        $this->dbname = $dbname;
        $this->showname = $showname;
    }

}
?>
