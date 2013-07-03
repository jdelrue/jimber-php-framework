<?php
/**
 * WikiText will convert the text from Wiki coding to html using 
 * an opensource script from 
 * http://www.ffnn.nl/pages/projects/wiki-text-to-html.php
 * 
 * @author jonas
 */

//fileadd("wikitexttohtml.php");

class WikiText extends GridElement{

    public function DefineBlock($tpl){
        $tpl->AddFile("lib/JPF/Elements/Text/WikiText.tpl");
        $tpl->DefineBlock("TEXTONLYFIELD");
    }
    public function Build($tpl, $name,$value, $field, $element,$values){
        $tpl->setVars("TEXTONLYFIELD", "VALUE", implode(WikiTextToHTML::convertWikiTextToHTML($input)));
        return $tpl->ParseBlock("TEXTONLYFIELD");
    }


}
?>
