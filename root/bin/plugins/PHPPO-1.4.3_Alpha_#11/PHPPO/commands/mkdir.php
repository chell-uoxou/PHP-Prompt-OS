<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("mkdir","secret","ディレクトリを作成します","");
//////////////////////
/**
 *
 */
class myMkdir extends systemProcessing{

	function __construct()
	{
		# code...
	}
	public function onCommand()
	{
		# code...
	}
}

?>
