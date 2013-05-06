<?php

/**
 * Description of Field
 *
 * @author jonas
 * 2012
 */
class Field {

     
    /**
     * @var <showname> The name as showed in the grid.
     */
    var $showname;
    
    /**
     * @var <type> Type of the field. This should be the name of a GridElement.
     */
    var $type;

    /**
     * @var <dbname> The name as  found in the database.
     */
    var $dbname;

 /**
     * @var <disabled> Disabled or not
     */
    var $disabled;
    /*
     * UID contains the unique identifier for a grid, form, ... This can be used from the build methods in the
     * dataelements to locate itself
     */
    var $UID;

    /*
     * Contains UID for field
     */
    var $FUID;
    
    
    
    /**** ALL THESE MUST BE MOVED ****/

  



    /**
     * @var <hiddenValue> @todo check wth
     */
    var $hiddenValue;

   
   
    /**
     * @var <md5> Field is using MD5 encryption
     */
    var $MD5;

    /**
     * @var <validator> The validator for the field (regex). @todo use
     */
    var $validator;



 
    var $IDfield;
    var $default;
    
    /*
     * If required is set the star is added
     */
    var $required;

    /*
     * Should replace width, height etc to enable css styles. Array of styles eg "width: 200px"
     */
    var $styles = Array();


    function field($type, $dbname, $showname, $disabled = false) {
        $this->type = $type;
        $this->dbname = $dbname;
        $this->showname = $showname;
        $this->disabled = $disabled;
        $this->required = 0;
       
    }
    function generateUID(){
         $this->FUID = Tools::random_string();
    }
    function setTextValidator() {
        $this->validator = "[a-zA-Z]*$";
    }

    function addStyles($style) {
        array_push($this->styles, $style);
    }

    function getStyles() {
        $arrOfStyles = $this->styles;
        $stylesString = "";
        foreach ($arrOfStyles as $singleStyle) {
            $stylesString .= $singleStyle;
        }
        return $stylesString;
    }

}

?>
