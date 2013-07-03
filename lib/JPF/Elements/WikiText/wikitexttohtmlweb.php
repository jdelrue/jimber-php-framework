<html>
	<head>
		<title>Wiki Text to HTML sample</title>
	</head>
	
	<body>
<?
	/**
	 * Online Wiki text to HTML script.
	 * (c) 2007, Frank Schoep
	 *
	 * This script will convert the POST variable 'wikitext' to
	 * minimally formatted HTML using the WikiTextToHTML class.
	 */

	// include the Wiki text to HTML class
	require_once 'wikitexttohtml.php';
		 
	// check for input
	$wikitext = trim(stripslashes($_POST['wikitext']));
	if('' == $wikitext) {
		$wikitext = 'No input was given.\n';	
	}
	 
	// parse and display input
	$input = explode("\n", $wikitext);

	// convert input to HTML output array
	$output = WikiTextToHTML::convertWikiTextToHTML($input);
	
	// output to stream with newlines
	foreach($output as $line) {
		echo "${line}\n";
	}	 
?>
	</body>
</html>