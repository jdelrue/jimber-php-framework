<?php

abstract class Selector {
    
    /*
     * getValues selects every value in a specific range.
     */
    abstract function getValues($start, $stop);

    /*
     * getCount 
     */
    abstract function getCount();
}

?>
