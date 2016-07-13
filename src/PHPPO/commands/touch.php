<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("touch","default","ファイルを生成します。","<path>");
//////////////////////
class touch_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $raw_input;
		global $currentdirectory;
		$path = $currentdirectory . "\\" . substr($raw_input,6);
		touch($path);
		// $this->sendMessage("");
	}
}


?>
