<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("mkdir","default","ディレクトリを作成します","");
//////////////////////
/**
 *
 */
class mkdir_command extends systemProcessing{

	function __construct()
	{
		# code...
	}
	public function onCommand(){
		global $aryTipeTxt;
		global $environmentVariables;
		global $currentdirectory;
		global $raw_input;
		$nameCount = count($aryTipeTxt);
		$name = "";
		// for ($i=1; $i < $nameCount; $i++) {
		// 	$name .= $aryTipeTxt[$i] . " ";
		// }
		$name = substr($raw_input,6);
		if (!file_exists($currentdirectory . "\\" . $name)) {
			mkdir($currentdirectory . "\\" . $name);
		}else {
			$this->sendMessage("そのディレクトリは既に存在します！");
		}
	}
}

?>
