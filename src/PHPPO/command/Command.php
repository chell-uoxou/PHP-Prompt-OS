<?php
namespace phppo;

include_once 'ScriptCommand.php';
include_once 'DefaultCommands.php';
use phppo\system\systemProcessing as systemProcessing;
use phppo\command\scriptCommand as scriptCommand;
use phppo\command\defaults\script_command as script_command;
$commandpros = new command;
$system = new systemProcessing;
$commandpros = new command;
$scriptcommandpros = new scriptCommand;
// $addcom = new addcommand;
//////////////////////
$commands = array();
$system->sendMessage("Command loaded:");
$re_dircommands = scandir(dirname(__FILE__) . '/../commands');
$i = 0;
foreach ($re_dircommands as $key => $value) {
	if ($value != "." && $value != "..") {
		$dircommands[] = dirname(dirname(__FILE__)) . '\commands\\' . $value;
		// $system->sendMessage($dircommands[$i]);
		$i++;
	}
}
// var_dump($dircommands);
foreach ($dircommands as $key => $value) {
	// echo $key . "|" . $value . ":" . PHP_EOL;
	include_once $value;
}
echo PHP_EOL;
// var_dump($commands);
//////////////////////
/**
 *
 */
class command extends systemProcessing{

	function __construct(){
		# code...
	}
	public function runCommand() {
		global $system;
		global $display;
		global $tipe_text;
		global $baseCommand;
		global $aryTipeTxt;
		global $pr_disp;
		global $pr_info;
		global $exec_command;
		global $valuepros;
		global $extensionCommands;
		global $commands;
		global $lastTipeTxt;
		global $raw_input;
		$valuepros->setvalue("time", date('A-H:i:s'));
		$aryTipeTxt = explode(" ", $tipe_text);
		$baseCommand = trim($aryTipeTxt[0]);
		if (!$baseCommand == "") {
			if (array_key_exists($baseCommand,$commands)) {
				$instname = "\phppo\command\defaults\\" . $baseCommand . "_command";
				$com_inst = new $instname;
				$onerror = $com_inst->onCommand();
			}else {
				if (array_key_exists($baseCommand,$extensionCommands)) {
					$aryTipeTxt = array("script",$extensionCommands[$baseCommand]);
					$script = new \phppo\command\defaults\script_command;
					$onerror = $script->onCommand();
				}else {
					$system->sendMessage("\x1b[38;5;203m\"" . $baseCommand . "\"コマンドが見つかりませんでした。helpコマンドで確認してください。");
					$onerror = false;
				}
			}
			$lastTipeTxt = $tipe_text;
			if (!isset($onerror)) {
				$onerror = true;
			}
			return $onerror;
		}else{
			$onerror = false;
		}
	}
}
