<?

require_once ("../../../JPFLibs.php");

$entities = Array();
$handle = @fopen(GlobalVars::$DRIVEPATH.GlobalVars::$DATAPATH . "/DB.SQL", "r");

$entityfile = "<?\n";

if ($handle) {
	$currentClass = "";
	$first = true;
	$regex = "";
	while (($line = fgets($handle, 4096)) !== false) {
		$matches = Array();

		if (preg_match("/^\s+`+(\w+)`+ \w+/", $line, $matches)) {
			$entityfile .= "\t var $" . $matches[1] . ";";
			$entityfile .= "\n";	
	}
		if (preg_match("/^\s+PRIMARY KEY \((.+)\).*/", $line, $matches)) {
			$entityfile .= "\t var \$primaryKeys = array(" . str_replace("`", "\"", $matches[1]) . ");\n";
		}
		if (preg_match("/^.+AUTO_INCREMENT,$/", $line, $matches)) {

			if (preg_match("/^\s+`+(\w+)`+ \w+/", $line, $matches)) {
				echo $matches[1];
				$regex .= "\"" . $matches[1] . "\",";

			}

		}
		if (preg_match("/^create table `+(\w+)/i", $line, $matches)) {
			if ($first) {
				$first = false;
			} else {
				if($regex != ""){
				$regex = "\tvar \$auto_increment = array(".substr_replace($regex, "", -1).");\n";
								$entityfile .= $regex;
				}
	
				$entityfile .= "function getClass() { return __CLASS__; }\n";
				$entityfile .= "}\n";
				$regex = "";
			}
			$entityfile .= "class " . $matches[1] . " extends Entity {";
			$entityfile .= "\n";
			$entities[$currentClass] = Array();
			$currentClass = $matches[1];
		}

	}
	$entityfile .= "public static function getClass() { return __CLASS__; }\n";
	$entityfile .= "}\n?>";
	if (!feof($handle)) {
		echo "Error: unexpected fgets() fail\n";
	}
	fclose($handle);

	$myFile = GlobalVars::$DRIVEPATH.GlobalVars::$DATAPATH . "/SQL_Entities-ng.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	//echo $stringData;
	fwrite($fh, $entityfile);
	echo " Done !";
}
?>
