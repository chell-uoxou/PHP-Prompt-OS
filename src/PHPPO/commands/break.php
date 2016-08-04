<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("break","script","スクリプトの実行を停止","<終了信号>");
//////////////////////
class break_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $running;
		global $aryTipeTxt;
		if (isset($aryTipeTxt[1])) {
			$sign = (int) ($aryTipeTxt[1]);
		}else {
			$sign = false;
		}
		if ($running == "script") {
			$running = false;
			switch ($sign) {
				case 1:
					$this->info("端末との切断によるスクリプトの実行停止。");
					break;
				case 2:
					$this->info("キーボード割り込みによるスクリプトの実行停止。");
					break;
				case 3:
					$this->info("キーボードからのスクリプトの実行停止。");
					break;
				case 4:
					$this->info("不正な命令（Illegal instruction）によるスクリプトの実行停止。","critical");
					break;
				case 5:
					$this->info("トレース（Trace），ブレーク・ポイント・トラップ（breakpoint trap）によるスクリプトの実行停止。","critical");
					break;
				case 6:
					$this->info("breakコマンドによるスクリプトの実行停止。");
					break;
				case 8:
					$this->info("浮動少数点例外（Arithematic exception）によるスクリプトの実行停止。","critical");
					break;
				case 9:
					$this->info("killシグナルによるスクリプトの実行停止。");
					break;
				case 11:
					$this->info("Segmentation fault.","critical");
					break;
				case 13:
					$this->info("パイプ破壊によるスクリプトの実行停止。","critical");
					break;
				case 15:
					$this->info("終了（Termination）シグナルによるプロセスの終了");
					break;
				default:
					$this->info("スクリプトの実行停止。");
					break;
			}
		}else {
			$this->throwError("不正参照");
			return false;
		}
	}
}


?>
