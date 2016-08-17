<?php
namespace phppo\event\system;
use phppo\event\event;

class sendMessage extends event{

	function __construct(){
		# code...
	}

	function sendMessage_event(){
		global $title_pros;
		global $valuepros;
		echo "string";////////////////////////////////////////////////////////////////////
		$valuepros->setvalue("time",date('A-H:i:s'));
		$title_pros->terminal_set_title();
	}
}
