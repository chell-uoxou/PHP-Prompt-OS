<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
//$addcom->addcommand("command name","command type","command description","command usage(Argument only)");
//////////////////////
class commandName_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		##code...
	}
}


?>
