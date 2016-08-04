<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("help","default","使用できるコマンド、コマンドの使用法を表示。","<all|dev>/<コマンド>");
//////////////////////
/**
*
*/
class help_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $aryTipeTxt;
		global $defaultcommands;
		global $extensioncommands;
		global $extensioncommandsDescription;
		global $commands;
		global $plugincommands;
		// var_dump($plugincommands);/////////////////////////////////////////////
		$messageCount = count($aryTipeTxt);
		// var_dump($commands);//////////////////////////
		if ($messageCount <= 1) {
			$this->info("\x1b[38;5;59m===================\x1b[38;5;231mコマンド一覧\x1b[38;5;59m===================\x1b[38;5;145m");
			$a = 0;
			// $longest_command_default = 0;
			// foreach ($defaultcommands as $basecommand => $info) {
			// 	if ($info["type"] == "default") {
			// 		// echo strlen($basecommand);
			// 		$complonger = strlen("{$basecommand} {$info["usage"]}");
			// 		if (strlen($longest_command_default) < $complonger) {
			// 			$longest_command_default = $basecommand;
			// 		}
			// 	}
			// }
			// echo $longest_command_default;
			foreach ($commands as $basecommand => $info) {
				if ($info["type"] == "default" || $info["type"] == "plugin") {
					$a++;
					// $longest = strlen(trim($longest_command_default)) - strlen($basecommand);
					// echo $longest . PHP_EOL;
					// $space = str_repeat(" ",$longest);
					$space = str_repeat(" ",0);
					if ($info["enadis"] != "desable") {
						$this->info("\x1b[38;5;34m{$basecommand} \x1b[38;5;83m{$info["usage"]}\x1b[38;5;145m{$space}:{$info["des"]}\x1b[38;5;145m");
					}
					// usleep(10000);
				}
			}
			$this->info("\x1b[38;5;59m===================================================\x1b[38;5;145m");
		}else{
			switch ($aryTipeTxt[1]) {
				case 'all':
				$this->info("\x1b[38;5;59m===================\x1b[38;5;87m実装コマンド一覧\x1b[38;5;59m===================\x1b[38;5;145m");
				foreach ($defaultcommands as $basecommand => $info) {
					if ($info["enadis"] != "desable") {
						$this->info("\x1b[38;5;59m[{$info["type"]}]-\x1b[38;5;34m{$basecommand} \x1b[38;5;83m{$info["usage"]}\x1b[38;5;145m:{$info["des"]}\x1b[38;5;145m");
					}else {
						$this->info("\x1b[38;5;59m[{$info["type"]}]-\x1b[38;5;203m{$basecommand} \x1b[38;5;83m{$info["usage"]}\x1b[38;5;145m:{$info["des"]}\x1b[38;5;145m");
					}
					// ksort($info["type"]);

				}
				$this->info("\x1b[38;5;59m=======================================================\x1b[38;5;145m");
				break;
				case 'dev':
				$this->info("\x1b[38;5;59m#######\x1b[38;5;127m開発者向けコマンド一覧\x1b[38;5;59m########");
				foreach ($defaultcommands as $basecommand => $info) {
					if ($info["type"] == "dev") {
						$this->info("\x1b[38;5;34m{$basecommand} \x1b[38;5;83m{$info["usage"]}\x1b[38;5;145m:{$info["des"]}\x1b[38;5;145m");
					}
				}
				break;

				case 'ex':
				$this->info("\x1b[38;5;59m================\x1b[38;5;214mスクリプト拡張コマンド一覧\x1b[38;5;59m================\x1b[38;5;145m");
				foreach ($extensioncommands as $basecommand => $data){
					$path = $data["path"]
;					if (isset($extensioncommandsDescription[$basecommand])) {
						$des = $extensioncommandsDescription[$basecommand];
						$this->info("\x1b[38;5;207m{$basecommand}\x1b[38;5;145m:{$des} \x1b[38;5;59m({$path})");
					}else{
						$this->info("\x1b[38;5;207m{$basecommand} \x1b[38;5;59m({$path})");
					}
				}
				$this->info("\x1b[38;5;59m==========================================================\x1b[38;5;145m");
					break;
				default:
				// foreach ($info["type"] as $key => $value) {
				// 	foreach ($defaultcommands as $basecommand => $info) {
				// 		if ($info["type"] == $value) {
				// 			$this->info("\x1b[38;5;34m{$basecommand} \x1b[38;5;83m{$info["usage"]}\x1b[38;5;145m:{$info["des"]}\x1b[38;5;145m");
				// 		}
				// 	}
				// }
				$conf = false;
				foreach ($defaultcommands as $key => $value) {
					if ($key == $aryTipeTxt[1]) {
						$this->info("\x1b[38;5;87m[{$key}]\x1b[38;5;231mコマンド");
						$this->info("使用方法:\x1b[38;5;227m{$key} \x1b[38;5;83m{$value["usage"]}");
						$this->info("\x1b[38;5;63m{$value["des"]}\x1b[38;5;145m");
						$conf = true;
					}
				}
				if ($conf != true) {
					$this->info("helpコマンドの使用法:");
					$this->info("help <all|dev|ex>/<コマンド> :第一引数に表示するコマンドの種類、またはコマンドの使用法を表示します。");
					$this->info("all :実装されているコマンドをすべて表示します。");
					$this->info("dev : 開発向けのコマンドを表示します。");
					$this->info("ex : 登録されたスクリプトによる拡張コマンドを表示します。");
					$this->info("コマンド名を入力した場合は、そのコマンドの使用法が表示されます。");
					break;
				}
			}
		}
	}
}


?>
