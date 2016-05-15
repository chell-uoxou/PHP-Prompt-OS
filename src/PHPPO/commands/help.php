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
		$messageCount = count($aryTipeTxt);
		ksort($commands);
		if ($messageCount <= 1) {
			$this->sendMessage("\x1b[38;5;59m===================\x1b[38;5;231mコマンド一覧\x1b[38;5;59m===================\x1b[38;5;145m");
			foreach ($commands as $basecommand => $info) {
				if ($info["type"] == "default") {
					$this->sendMessage("\x1b[38;5;34m{$basecommand} \x1b[38;5;83m{$info["usage"]}\x1b[38;5;145m:{$info["des"]}\x1b[38;5;145m");
					// usleep(10000);
				}
			}
			$this->sendMessage("\x1b[38;5;59m===================================================\x1b[38;5;145m");
			}else{
				switch ($aryTipeTxt[1]) {
					case 'all':
						$this->sendMessage("\x1b[38;5;59m===================\x1b[38;5;87m実装コマンド一覧\x1b[38;5;59m===================\x1b[38;5;145m");
						foreach ($commands as $basecommand => $info) {
							// ksort($info["type"]);
							$this->sendMessage("\x1b[38;5;59m[{$info["type"]}]-\x1b[38;5;34m{$basecommand} \x1b[38;5;83m{$info["usage"]}\x1b[38;5;145m:{$info["des"]}\x1b[38;5;145m");
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
						$this->sendMessage("help <all|dev>/<コマンド> :第一引数に表示するコマンドの種類、またはコマンドの使用法を表示します。");
						$this->sendMessage("all :実装されているコマンドをすべて表示します。");
						$this->sendMessage("dev : 開発向けのコマンドを表示します。");
						break;
						}
					}
				}
		}
}


?>
