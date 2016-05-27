<?php
include_once dirname(__FILE__) . '/../display/display.php';
include_once(dirname(__FILE__) . "/../system/System.php");
$system = new systemProcessing;
//////////////////////
$commands = array();
//$system->sendMessage("\x1b[38;5;83mdefault command process\"clear.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . "/../commands/clear.php";
//$system->sendMessage("\x1b[38;5;83mdefault command process\"download.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . "/../commands/download.php";
//$system->sendMessage("\x1b[38;5;83mdefault command process\"echo.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . "/../commands/echo.php";
//$system->sendMessage("\x1b[38;5;83mdefault command process\"exec.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . "/../commands/exec.php";
//$system->sendMessage("\x1b[38;5;83mdefault command process\"exit.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . "/../commands/exit.php";
//$system->sendMessage("\x1b[38;5;83mdefault command process\"help.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . "/../commands/help.php";
//$system->sendMessage("\x1b[38;5;83mdefault command process\"info.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . "/../commands/info.php";
//$system->sendMessage("\x1b[38;5;83mdefault command process\"log.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . "/../commands/log.php";
//$system->sendMessage("\x1b[38;5;83mdefault command process\"log.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . "/../commands/logout.php";
//$system->sendMessage("\x1b[38;5;83mdefault command process\"mkdir.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . "/../commands/mkdir.php";
//$system->sendMessage("\x1b[38;5;83mdefault command process\"time.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . "/../commands/time.php";
//$system->sendMessage("\x1b[38;5;83mdefault command process\"title.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . "/../commands/title.php";
//$system->sendMessage("\x1b[38;5;83mdefault command process\"vardump.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . "/../commands/vardump.php";
//$system->sendMessage("\x1b[38;5;83mdefault command process\"makephar.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . "/../commands/makephar.php";
//$system->sendMessage("\x1b[38;5;83mdefault command process\"script.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . '/../commands/script.php';
//$system->sendMessage("\x1b[38;5;83mdefault command process\"wait.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . '/../commands/wait.php';
//$system->sendMessage("\x1b[38;5;83mdefault command process\"set.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . '/../commands/set.php';
//$system->sendMessage("\x1b[38;5;83mdefault command process\"revc.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . '/../commands/revc.php';
//$system->sendMessage("\x1b[38;5;83mdefault command process\"extract.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . '/../commands/extract.php';
//$system->sendMessage("\x1b[38;5;83mdefault command process\"vars.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . '/../commands/vars.php';
//$system->sendMessage("\x1b[38;5;83mdefault command process\"install.php\" \x1b[38;5;227mloading...");
include_once dirname(__FILE__) . '/../commands/install.php';
include_once dirname(__FILE__) . '/../commands/cat.php';

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
		case 'Mkdir':
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
	    default:
			$filename = rtrim(dirname(__FILE__),"/src/PHPPO") . "/" . "scripts" . "/";
	      	$system->sendMessage("\x1b[38;5;203m\"" . $baseCommand . "\"コマンドが見つかりませんでした。helpコマンドで確認してください。");
	      	break;
		}
	}

}
