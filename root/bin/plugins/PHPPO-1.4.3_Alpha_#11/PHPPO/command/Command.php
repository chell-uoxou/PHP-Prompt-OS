<?php
//////////////////////
$commands = array();
include_once dirname(__FILE__) . "/../commands/clear.php";
include_once dirname(__FILE__) . "/../commands/download.php";
include_once dirname(__FILE__) . "/../commands/echo.php";
include_once dirname(__FILE__) . "/../commands/exec.php";
include_once dirname(__FILE__) . "/../commands/exit.php";
include_once dirname(__FILE__) . "/../commands/help.php";
include_once dirname(__FILE__) . "/../commands/info.php";
include_once dirname(__FILE__) . "/../commands/log.php";
include_once dirname(__FILE__) . "/../commands/logout.php";
include_once dirname(__FILE__) . "/../commands/mkdir.php";
include_once dirname(__FILE__) . "/../commands/time.php";
include_once dirname(__FILE__) . "/../commands/title.php";
include_once dirname(__FILE__) . "/../commands/vardump.php";
include_once dirname(__FILE__) . "/../commands/makephar.php";
include_once dirname(__FILE__) . '/../commands/script.php';
include_once dirname(__FILE__) . '/../commands/wait.php';
include_once dirname(__FILE__) . '/../commands/set.php';
include_once dirname(__FILE__) . '/../commands/revc.php';
include_once dirname(__FILE__) . '/../commands/extract.php';
include_once dirname(__FILE__) . '/../commands/vars.php';
var_dump($commands);
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
	    case "cls":
			$cls = new cls;
			$cls->onCommand();
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
	    default:
			$filename = rtrim(dirname(__FILE__),"/src/PHPPO") . "/" . "scripts" . "/";
	      	$system->sendMessage("\x1b[38;5;203m\"" . $baseCommand . "\"コマンドが見つかりませんでした。helpコマンドで確認してください。");
	      	break;
		}
	}

}
