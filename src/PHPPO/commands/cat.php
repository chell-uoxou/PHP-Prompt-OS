<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("cat","default","指定されたファイルを表示","<パス>");
//////////////////////
class cat extends systemProcessing{
	function __construct(){
	}
	public function onCommand(){
		global $aryTipeTxt;
		global $environmentVariables;
		global $currentdirectory;
		// echo $currentdirectory;
		$pathCount = count($aryTipeTxt);
		$path = $currentdirectory . "/";
		for ($i=1; $i < $pathCount; $i++) {
			$path .= $aryTipeTxt[$i] . " ";
		}
		$this->sendMessage(file_get_contents($path));
	}
}


?>
