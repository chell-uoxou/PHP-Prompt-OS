<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("touch","default","ファイルを生成します。","<path>");
//////////////////////
class touch extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		
	}
}


?>
