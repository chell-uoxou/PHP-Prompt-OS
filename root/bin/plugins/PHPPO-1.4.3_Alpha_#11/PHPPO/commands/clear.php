<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("clear","default","画面上から履歴が消えるように改行を繰り返します。","");
//////////////////////
/**
 *
 */
class clear extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		$this->sysCls(100);
	}
}


?>
