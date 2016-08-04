<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("exec","default","コマンド及び外部プロセスの実行。","");
//////////////////////
/**
 *
 */
class exec_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $tipe_text;
		global $baseCommand;
		global $aryTipeTxt;
		global $pr_disp;
		$messageCount = count($aryTipeTxt);
		if ($messageCount <= 1) {
			$this->info("パラメーターが不足しています。");
return false;
			}else{
				$exec_command = '';
				for ($i=1; $i < $messageCount; $i++) {
				$exec_command .= $aryTipeTxt[$i] . " ";
				}
			$exec_command = trim($exec_command);
			// if (!$exececho == "") {
			// 	$this->info("コンソールによる記述:" . PHP_EOL);
			// 	print_r($exececho);
			// }
			printf(exec($exec_command));
			$this->info("=============コンソールによる記述===============" . PHP_EOL);
			$this->info($exec_command . "コマンドの実行を試みました。");
		}
	}
}


?>
