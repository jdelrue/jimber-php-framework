<?php
class Exceldownload {
    var $fields;
    var $sqlstr; //array of vars
    function Exceldownload($fields, $sqlstr){
        $this->fields = $fields;
        $this->sqlstr = $sqlstr;
    }
    function GetExceldownload(){
        return URLEncrypter::Encrypt(serialize($this));
    }
    function getGrid(){
        //first make devices!
        return new Grid($fields, $sqlstr);
    }
}
?>
