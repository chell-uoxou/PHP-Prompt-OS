<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$cdpros = new currentdirectory;
if ($currentdirectorymode == "on") {
	$addcom->addcommand("cd","default","カレントディレクトリを指定します。","<絶対/相対パス>");
}else {
	$addcom->addcommand("cd","default","カレントディレクトリを指定します。","<絶対/相対パス>","disable");
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
