<?php
include_once dirname(__FILE__) . '/../display/display.php';
include_once(dirname(__FILE__) . "/../system/System.php");
$system = new systemProcessing;
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
function runCommand() {
	global $system;global $display;
	global $tipe_text;
	global $baseCommand;
	global $aryTipeTxt;
	global $pr_disp;
	global $pr_info;
	global $exec_command;
	$valuepros = new environmentVariables;
	$valuepros->setvalue("time", date('A-H:i:s'));
	$aryTipeTxt = explode(" ", $tipe_text);
	$baseCommand = trim($aryTipeTxt[0]);
	if (!$baseCommand == "") {
	  switch ($baseCommand) {
	    case "help":
	      	$help = new help;
			$help->onCommand();
	      	break;
	    case "echo":
			$echo = new myEcho;
			$echo->onCommand();
	      	break;
	    case "exit":
			$exit = new myExit;
			$exit->onCommand();
	    	break;
	    case "exec":
			$exec = new myExec;
			$exec->onCommand();
	    	break;
	    case 'time':
			$time = new time;
			$time->onCommand();
	      	break;
	    case 'log':
			$log = new log;
			$log->onCommand();
	      	break;
	 	case "download":
			$download = new download;
			$download->onCommand();
	    	break;
	    case "info":
			$info = new info;
			$info->onCommand();
	    	break;
		case 'title':
			$title = new title;
			$title->onCommand();
			break;
		case 'logout':
			$logout = new logout;
			$logout->onCommand();
			break;
		case 'mkdir':
			$mkdir = new myMkdir;
			$mkdir->onCommand();
			break;
		case 'vardump':
			$vardump = new vardump;
			$vardump->onCommand();
			break;
		case 'makephar':
			$makephar = new makephar;
			$makephar->onCommand();
			break;
		case 'script':
			$script = new script;
			$script->onCommand();
			break;
		case 'wait':
			$wait = new wait;
			$wait->onCommand();
			break;
		case 'set':
			$set = new set;
			$set->onCommand();
			break;
		case 'setvalue':
			$set = new set;
			$set->onCommand();
			break;
		case 'clear':
			$clear = new clear;
			$clear->onCommand();
			break;
		case 'revc':
			$revc = new revc;
			$revc->onCommand();
			break;
		case 'extract':
			$extract = new extract;
			$extract->onCommand();
			break;
		case 'vars':
			$vars = new vars;
			$vars->onCommand();
			break;
		case 'cls':
			$clear = new clear;
			$clear->onCommand();
			break;
		case 'install':
			$install = new install;
			$install->onCommand();
			break;
		case 'cat':
			$cat = new cat;
			$cat->onCommand();
			break;
		case 'cd':
			$cd = new cd;
			$cd->onCommand();
			break;
		case 'ls':
			$ls = new myLs;
			$ls->onCommand();
			break;
		case 'pwd':
			$pwd = new pwd;
			$pwd->onCommand();
			break;
		case 'delvar':
			$delvar = new delvar;
			$delvar->onCommand();
			break;
		case 'reboot':
			$reboot = new reboot;
			$reboot->onCommand();
			break;
		case 'wget':
			$wget = new wget;
			$wget->onCommand();
			break;
	    default:
			$filename = rtrim(dirname(__FILE__),"/src/PHPPO") . "/" . "scripts" . "/";
	      	$system->sendMessage("\x1b[38;5;203m\"" . $baseCommand . "\"コマンドが見つかりませんでした。helpコマンドで確認してください。");
	      	break;
		}
	}

}
