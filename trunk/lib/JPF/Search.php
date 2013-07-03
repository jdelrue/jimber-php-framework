<?php

class Search {
	
 public static  function BuildStandardSearch($page, $list =1){
		$tpl = new Template("lib/Jimber/templates/Search.tpl");
	        $tpl->DefineBlock("SEARCHBLOCK");
                $tpl->setVars("SEARCHBLOCK", "SEARCHPAGE", $page);
                           $tpl->setVars("SEARCHBLOCK", "LIST", $list);
		$parsed = $tpl->ParseBlock("SEARCHBLOCK");
		return $parsed;
	}
}

?>
