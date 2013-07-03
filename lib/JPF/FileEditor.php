<?php
/**
 * Description of FileEditor
 *
 * @author jonas
 * @todo UNN totally unfinished & unused
 * 2009 Excentis NV
 */
class FileEditor {
    
    var $file;

    public function FileEditor($file){
        $this->file = $file;

    }
    public function BuildStandardFileEditor(){
        $tpl = new Template("Lib/Jimber/templates/FileEditor.tpl");
        $tpl->DefineBlock("FORMBLOCK");
        $tpl->DefineBlock("TXTAREA");
        $content = file_get_contents($this->file);

        $tpl->setVars("TXTAREA", "CONTENT", $content);
        $txtarea = $tpl->ParseBlock("TXTAREA");
        $tpl->setVars("FORMBLOCK", "CONTENT", $txtarea);
        return $tpl->ParseBlock("FORMBLOCK");

    }

}
?>
