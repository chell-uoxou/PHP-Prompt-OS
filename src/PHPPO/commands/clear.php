<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("clear","default","画面上から履歴が消えるように改行を繰り返します。","");
//////////////////////
/**
 *
 */
class clear_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		$this->sysCls(100);
		for ($i=0; $i < 40; $i++) {
			// echo('^[[A');
		}

	}
}


?>
