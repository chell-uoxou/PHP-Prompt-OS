<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("help","default","使用できるコマンド、コマンドの使用法を表示。","<all|dev>/<コマンド>");
//////////////////////
/**
*
*/
class help extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $aryTipeTxt;
		global $commands;
		global $extensionCommands;
		$messageCount = count($aryTipeTxt);
		ksort($commands);
		if ($messageCount <= 1) {
			$this->sendMessage("\x1b[38;5;59m===================\x1b[38;5;231mコマンド一覧\x1b[38;5;59m===================\x1b[38;5;145m");
			$a = 0;
			// $longest_command_default = 0;
			// foreach ($commands as $basecommand => $info) {
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
				if ($info["type"] == "default") {
					$a++;
					// $longest = strlen(trim($longest_command_default)) - strlen($basecommand);
					// echo $longest . PHP_EOL;
					// $space = str_repeat(" ",$longest);
					$space = str_repeat(" ",0);
					if ($info["enadis"] != "desable") {
						$this->sendMessage("\x1b[38;5;34m{$basecommand} \x1b[38;5;83m{$info["usage"]}\x1b[38;5;145m{$space}:{$info["des"]}\x1b[38;5;145m");
					}
					// usleep(10000);
				}
			}
			$this->sendMessage("\x1b[38;5;59m===================================================\x1b[38;5;145m");
		}else{
			switch ($aryTipeTxt[1]) {
				case 'all':
				$this->sendMessage("\x1b[38;5;59m===================\x1b[38;5;87m実装コマンド一覧\x1b[38;5;59m===================\x1b[38;5;145m");
				foreach ($commands as $basecommand => $info) {
					if ($info["enadis"] != "desable") {
						$this->sendMessage("\x1b[38;5;59m[{$info["type"]}]-\x1b[38;5;34m{$basecommand} \x1b[38;5;83m{$info["usage"]}\x1b[38;5;145m:{$info["des"]}\x1b[38;5;145m");
					}else {
						$this->sendMessage("\x1b[38;5;59m[{$info["type"]}]-\x1b[38;5;203m{$basecommand} \x1b[38;5;83m{$info["usage"]}\x1b[38;5;145m:{$info["des"]}\x1b[38;5;145m");
					}
					// ksort($info["type"]);

				}
				$this->sendMessage("\x1b[38;5;59m=======================================================\x1b[38;5;145m");
				break;
				case 'dev':
				$this->sendMessage("\x1b[38;5;59m#######\x1b[38;5;127m開発者向けコマンド一覧\x1b[38;5;59m########");
				foreach ($commands as $basecommand => $info) {
					if ($info["type"] == "dev") {
						$this->sendMessage("\x1b[38;5;34m{$basecommand} \x1b[38;5;83m{$info["usage"]}\x1b[38;5;145m:{$info["des"]}\x1b[38;5;145m");
					}
				}
				break;

				case 'ex':
				$this->sendMessage("\x1b[38;5;59m================\x1b[38;5;214mスクリプト拡張コマンド一覧\x1b[38;5;59m================\x1b[38;5;145m");
				foreach ($extensionCommands as $basecommand => $path){
					$this->sendMessage("\x1b[38;5;207m{$basecommand} \x1b[38;5;59m({$path})");
				}
				$this->sendMessage("\x1b[38;5;59m==========================================================\x1b[38;5;145m");
					break;
				default:
				// foreach ($info["type"] as $key => $value) {
				// 	foreach ($commands as $basecommand => $info) {
				// 		if ($info["type"] == $value) {
				// 			$this->sendMessage("\x1b[38;5;34m{$basecommand} \x1b[38;5;83m{$info["usage"]}\x1b[38;5;145m:{$info["des"]}\x1b[38;5;145m");
				// 		}
				// 	}
				// }
				$conf = false;
				foreach ($commands as $key => $value) {
					if ($key == $aryTipeTxt[1]) {
						$this->sendMessage("\x1b[38;5;87m[{$key}]\x1b[38;5;231mコマンド");
						$this->sendMessage("使用方法:\x1b[38;5;227m{$key} \x1b[38;5;83m{$value["usage"]}");
						$this->sendMessage("\x1b[38;5;63m{$value["des"]}\x1b[38;5;145m");
						$conf = true;
					}
				}
				if ($conf != true) {
					$this->sendMessage("helpコマンドの使用法:");
					$this->sendMessage("help <all|dev|ex>/<コマンド> :第一引数に表示するコマンドの種類、またはコマンドの使用法を表示します。");
					$this->sendMessage("all :実装されているコマンドをすべて表示します。");
					$this->sendMessage("dev : 開発向けのコマンドを表示します。");
					$this->sendMessage("ex : 登録されたスクリプトによる拡張コマンドを表示します。");
					$this->sendMessage("コマンド名を入力した場合は、そのコマンドの使用法が表示されます。");
					break;
				}
			}
		}
	}
}


?>
