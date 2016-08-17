<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
use phppo\display;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("revc","accessibility","画面上の文字の色の反転を切り替えます。","");
//////////////////////
class revc_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $revcFunc;
		$display = new display;
		if ($revcFunc == false) {
			$revcFunc = true;
			$display->reverseColor(true);
			$this->sysCls(100);
			$this->info("色を反転して表示します。");
		}else {
			$revcFunc = false;
			$display->reverseColor(false);
			$this->sysCls(100);
			$this->info("反転表示を終了します。");
		}

	}
}


?>
