<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("logout","secret","ログアウトします。","","desable");
//////////////////////
/**
 *
 */
class logout_command extends systemProcessing{

	function __construct()
	{
		# code...
	}
	public function onCommand()
	{

		global $user;
		$this->sendMessage($user . "さんのアカウントからログアウトします。");
		$this->sendMessage("再起動を行います...");
		bootSystem("logout");
	}
}

?>
