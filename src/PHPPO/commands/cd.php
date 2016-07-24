<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
use phppo\system\currentdirectory as currentdirectory;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$cdpros = new currentdirectory;
$systemconf_ini_array = parse_ini_file(dirname(dirname(dirname(dirname(__FILE__)))) . "\\config.ini", true);
if ($systemconf_ini_array["dev"]["currentdirectory"] == 1) {
	$addcom->addcommand("cd","default","カレントディレクトリを指定します。","<絶対/相対パス>");
}else {
	$addcom->addcommand("cd","default","カレントディレクトリを指定します。","<絶対/相対パス>","disable");
	// echo ":desable  ";////////////////////////////////
}
//////////////////////
class cd_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $aryTipeTxt;
		global $environmentVariables;
		global $currentdirectory;
		global $cdpros;
		global $running;
		global $runScriptPath;
		// echo dirname($runScriptPath);
		// echo $currentdirectory;
		$pathCount = count($aryTipeTxt);
		$path = "";////////////////////
		for ($i=1; $i < $pathCount; $i++) {
			$path .= $aryTipeTxt[$i] . " ";
		}
		$path = trim($path);
		if ($path == ".") {
			// echo $running;///////////////////////////////
			if ($running == "script") {
				$path = dirname($runScriptPath);
			}
		}
		// echo $currentdirectory . "\n:{$path}\n";
		$cdpros->setCurrentDirectory($path);
		$currentdirectory = trim($currentdirectory);
	}
}


?>
