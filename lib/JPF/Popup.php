<?php
/**
 * Description of Popup
 *
 */
class Popup {
    var $width;
    var $height;
    var $scrollbars;
    var $toolbar;
    var $location;

    function Popup($width, $height, $scrollbars = "yes", $toolbar = "yes", $location =  "yes"){
        $this->width = $width;
        $this->height = $height;
        $this->scrollbars = $scrollbars;
        $this->location = $location;
    }
    
}
?>
