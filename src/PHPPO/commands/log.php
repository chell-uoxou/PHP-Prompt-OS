<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("log","default","ログファイルにログを出力するかの設定です。","<on/off>");
//////////////////////
/**
 *
 */
class log_command extends systemProcessing{

	function __construct()
	{
		# code...
	}
	public function onCommand()
	{
		global $tipe_text;
		global $baseCommand;
		global $aryTipeTxt;
		global $pr_disp;
		global $pr_time;
		global $logMode;
		$messageCount = count($aryTipeTxt);
		if ($messageCount <= 1) {
		  $this->sendMessage("Log modeは " . $logMode . " です。");
		  $this->sendMessage("ログモードを変更する際は、第一引数に<on>か<off>の値を記入してください。");
		  }else{
			$aryTipeTxt[1] = trim($aryTipeTxt[1]);
		  	if ($aryTipeTxt[1] == "on") {
		  	$logMode = "on";
			$this->sendMessage("ログファイルにログを書き出します。");
					}else{
					if ($aryTipeTxt[1] == "off") {
				  	$logMode = "off";
				  	$this->sendMessage("ログファイルにログを書き出しません。");
			  			}else{
				  		$this->sendMessage("パラメーターの記法に誤りがあります。");
				  		$this->sendMessage("第一引数(" . $aryTipeTxt[1] . ")に<on>か<off>の値を記入してください。");
			  }
		  }
		}
	}
}

?>
