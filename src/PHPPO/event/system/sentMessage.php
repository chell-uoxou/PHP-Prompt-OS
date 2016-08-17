<?php
namespace phppo\event\system;
use phppo\event\event;

class sentMessage extends event{

	function __construct(){
		# code...
	}

	function sentMessage_event(){
		global $title_pros;
		global $valuepros;
		$valuepros->setvalue("time",date('A-H:i:s'));
		$title_pros->terminal_set_title();
	}
}
