<?php
include_once dirname(__FILE__) . '/../display/display.php';
include_once(dirname(__FILE__) . "/../system/System.php");
include_once 'ScriptCommand.php';
$system = new systemProcessing;
$commandpros = new command;
$scriptcommandpros = new scriptCommand;
// $addcom = new addcommand;
//////////////////////
$commands = array();
$system->sendMessage("Command loaded:");
$dircommands = scandir(dirname(__FILE__) . '/../commands');
$i = 0;
foreach ($dircommands as $key => $value) {
	$dircommands[$i] = dirname(dirname(__FILE__)) . '\commands\\' . $dircommands[$i];
	// $system->sendMessage($dircommands[$i]);
	$i++;
}
// var_dump($dircommands);
foreach ($dircommands as $key => $value) {
	@include_once $value;
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
		$valuepros->setvalue("time", date('A-H:i:s'));
		$aryTipeTxt = explode(" ", $tipe_text);
		$baseCommand = trim($aryTipeTxt[0]);
		if (!$baseCommand == "") {
			if (array_key_exists($baseCommand,$commands)) {
				$instname = $baseCommand . "_command";
				$com_inst = new $instname;
				$com_inst->onCommand();
			}else {
				if (array_key_exists($baseCommand,$extensionCommands)) {
					$aryTipeTxt = array("script",$extensionCommands[$baseCommand]);
					$script = new script_command;
					$script->onCommand();
				}else {
					$system->sendMessage("\x1b[38;5;203m\"" . $baseCommand . "\"コマンドが見つかりませんでした。helpコマンドで確認してください。");
				}
			}
		}
	}
}
