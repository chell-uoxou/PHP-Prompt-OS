<?php
namespace phppo;

include_once 'ScriptCommand.php';
include_once 'DefaultCommands.php';
include_once 'PluginCommands.php';
use phppo\system\systemProcessing as systemProcessing;
use phppo\command\scriptCommand as scriptCommand;
use phppo\command\defaults\script_command as script_command;
$commandpros = new command;
$system = new systemProcessing;
$commandpros = new command;
$scriptcommandpros = new scriptCommand;
// $addcom = new addcommand;
//////////////////////
$defaultcommands = array();
$system->info("Command loaded:");
$re_dircommands = scandir(dirname(__FILE__) . '/../commands');
$i = 0;
foreach ($re_dircommands as $key => $value) {
	if ($value != "." && $value != "..") {
		$dircommands[] = dirname(dirname(__FILE__)) . '\commands\\' . $value;
		// $system->info($dircommands[$i]);
		$i++;
	}
}
// var_dump($dircommands);
foreach ($dircommands as $key => $value) {
	// echo $key . "|" . $value . ":" . PHP_EOL;
	include_once $value;
}
echo PHP_EOL;
// var_dump($defaultcommands);
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
		global $extensioncommands;
		global $defaultcommands;
		global $lastTipeTxt;
		global $raw_input;
		global $plugincommands;
		global $plugindata;
		global $commands;
		global $title_pros;
		$commands = array_merge($defaultcommands,$plugincommands,$extensioncommands);
		ksort($commands);
		$valuepros->setvalue("time", date('A-H:i:s'));
		$aryTipeTxt = explode(" ", $tipe_text);
		$baseCommand = trim($aryTipeTxt[0]);
		if (!$baseCommand == "") {
			if (array_key_exists($baseCommand,$defaultcommands)) {
				$instname = "\phppo\command\defaults\\" . $baseCommand . "_command";
				$com_inst = new $instname;
				$system->setSystemStatusMessage("running [{$raw_input}]");
				$title_pros->terminal_set_title();
				$onerror = $com_inst->onCommand();
				$runned = true;
			}else {
				if (array_key_exists($baseCommand,$plugincommands)) {
					$plugin_name = $plugincommands[$baseCommand]["pluginname"];
					$instname = $plugindata[$plugin_name]["main"];
					$com_inst = new $instname;
					$system->setSystemStatusMessage("running [{$raw_input}]");
					$title_pros->terminal_set_title();
					$onerror = $com_inst->onCommand();
					$runned = true;
				}else{
					if (array_key_exists($baseCommand,$extensioncommands)) {
						$aryTipeTxt = array("script",$extensioncommands[$baseCommand]["path"]);
						$script = new \phppo\command\defaults\script_command;
						$system->setSystemStatusMessage("running [{$raw_input}]");
						$title_pros->terminal_set_title();
						$onerror = $script->onCommand();
						$runned = true;
					}else{
						$returns = $this->generateEvent("onCommand");
						// var_dump($returns);////////////////////////////
						if (in_array(true,$returns)) {
							$runned = true;
						}else {
							$runned = false;
						}
					}
				}
			}
			if (!$runned) {
				$system->info("\x1b[38;5;203m\"" . $baseCommand . "\"コマンドが見つかりませんでした。helpコマンドで確認してください。");
				$onerror = false;
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
