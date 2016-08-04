<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("wait","script","表示されているコンソール上での処理を指定時間中断します。","<ミリ秒>");
//////////////////////
class wait_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $aryTipeTxt;
		$waitSecCount = count($aryTipeTxt);
		if ($waitSecCount <= 1) {
			$this->info("パラメーターが不足しています。");
return false;
			}else{
				$aryTipeTxt[1] = trim($aryTipeTxt[1]);
				$waitSec = '';
				for ($i=1; $i < $waitSecCount; $i++) {
					$waitSec .= $aryTipeTxt[$i] . " ";
				}
				usleep($waitSec * 1000);
		}
	}
}


?>
