<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
//$addcom->addcommand("command name","command type","command description","command usage(Argument only)");
//////////////////////
class commandName extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		##code...
	}
}


?>
