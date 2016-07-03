<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("exec","default","コマンド及び外部プロセスの実行。","");
//////////////////////
/**
 *
 */
class myExec extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $tipe_text;
		global $baseCommand;
		global $aryTipeTxt;
		global $pr_disp;
		$messageCount = count($aryTipeTxt);
		if ($messageCount <= 1) {
			$this->sendMessage("パラメーターが不足しています。");
			}else{
				$exec_command = '';
				for ($i=1; $i < $messageCount; $i++) {
				$exec_command .= $aryTipeTxt[$i] . " ";
				}
			$exec_command = trim($exec_command);
			// if (!$exececho == "") {
			// 	$this->sendMessage("コンソールによる記述:" . PHP_EOL);
			// 	print_r($exececho);
			// }
			printf(exec($exec_command));
			$this->sendMessage("=============コンソールによる記述===============" . PHP_EOL);
			$this->sendMessage($exec_command . "コマンドの実行を試みました。");
		}
	}
}


?>
