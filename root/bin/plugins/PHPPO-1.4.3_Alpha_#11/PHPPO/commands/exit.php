<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("exit","default","PHP Prompt OSを終了。","<ミリ秒数>");
//////////////////////
/**
 *
 */
class myExit extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){

		global $pr_disp;
		global $aryTipeTxt;
		if (!isset($aryTipeTxt[1])){
		$this->sendMessage("PHP Prompt OS by chell ruiを終了します...");
			}else{
				$aryTipeTxt[1] = trim($aryTipeTxt[1]);
				$this->sendMessage($aryTipeTxt[1] . "/1000 秒後にPHP Prompt OS by chell ruiを終了します...");
				$waitSec = (int)$aryTipeTxt[1];
				usleep($waitSec * 1000);
		}
		$this->sendMessage("(@^^)/~~~!");
		exit(0);
	}
}


?>
