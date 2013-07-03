<?php
/**
 * The GridElement class should be inherited by each element in the Grid.
 *
 * @author jonas
 */
abstract class GridElement {
    var $updatable = false;
    abstract function DefineBlock($tpl);

    abstract function Build($tpl, $name,$value, $field, $element, $values);

    /*
     * This can be modified (override) for checkbox etc
     */
    public function Update($postBackElement){

        return "'".htmlentities($postBackElement,ENT_QUOTES)."'";
      /* Will by default just return the param? */
    }
     public function preUpdate($value){
        return $value;
     }
    /*
     * This can be modified (override) for childclasses. If there is need to add
     * any value to a field it should be done in PreBuild, not in Build. Doing it in Build will not
     * take the result to the update method and therefore changes will be lost.
     */
    public function preBuild($field,$tpl){
        return;
    }

   public function addStyles($field,$tpl, $styleBlock){
	
	 $tpl->setVars($styleBlock, "STYLES", " style=\"".$field->getStyles()."\"");
    }

}
?>
