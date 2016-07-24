<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("run","script","スクリプト内で定義されていない命令を呼び出します。","<文字列>");
//////////////////////
class run_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $commandpros;
		global $raw_input;
		global $tipe_text;
		global $lastTipeTxt;
		global $latestTipeTxt;
		global $sender;
		global $sendto;
		$int = substr($raw_input,4);
		$this->sendMessage("\x1b[38;5;37m{$sender}\x1b[m\x1b[38;5;59mから\x1b[38;5;37m{$sendto}\x1b[m\x1b[38;5;59mへの文字列送信:\x1b[38;5;34m{$int}");
		$tipe_text = $int;
		// echo $int;///////////////////////////
		$raw_input = $int;
		$commandpros->runCommand();
		$lastTipeTxt = $tipe_text;
	}
}


?>
