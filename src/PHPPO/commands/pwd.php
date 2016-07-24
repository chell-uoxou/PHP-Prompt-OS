<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("pwd","default","カレントディレクトリのパスを表示します。","");
//////////////////////
class pwd_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $currentdirectory;
		$this->sendMessage("\x1b[38;5;145m" . $currentdirectory);
	}
}


?>
