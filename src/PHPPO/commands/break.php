<?php
//////////////////////
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
					$this->sendMessage("端末との切断によるスクリプトの実行停止。");
					break;
				case 2:
					$this->sendMessage("キーボード割り込みによるスクリプトの実行停止。");
					break;
				case 3:
					$this->sendMessage("キーボードからのスクリプトの実行停止。");
					break;
				case 4:
					$this->sendMessage("不正な命令（Illegal instruction）によるスクリプトの実行停止。","critical");
					break;
				case 5:
					$this->sendMessage("トレース（Trace），ブレーク・ポイント・トラップ（breakpoint trap）によるスクリプトの実行停止。","critical");
					break;
				case 6:
					$this->sendMessage("breakコマンドによるスクリプトの実行停止。");
					break;
				case 8:
					$this->sendMessage("浮動少数点例外（Arithematic exception）によるスクリプトの実行停止。","critical");
					break;
				case 9:
					$this->sendMessage("killシグナルによるスクリプトの実行停止。");
					break;
				case 11:
					$this->sendMessage("Segmentation fault.","critical");
					break;
				case 13:
					$this->sendMessage("パイプ破壊によるスクリプトの実行停止。","critical");
					break;
				case 15:
					$this->sendMessage("終了（Termination）シグナルによるプロセスの終了");
					break;
				default:
					$this->sendMessage("スクリプトの実行停止。");
					break;
			}
		}else {
			$this->sendMessage("不正参照","error");
			return false;
		}
	}
}


?>
