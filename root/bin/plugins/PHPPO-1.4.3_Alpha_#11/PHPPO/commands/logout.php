<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("logout","secret","ログアウトします。","");
//////////////////////
/**
 *
 */
class logout extends systemProcessing{

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
