<?php
namespace phppo\event\system;
use phppo\event\event;

class readyInput extends event{

	function __construct(){
		# code...
	}

	function readyInput_event(){
		// echo "a";///////////////
		global $defined_vars;
		global $currentdirectory;
		global $valuepros;
		global $defaultcurrentdirectory;
		// $setcd = $valuepros->getvalue("currentdirectory");
		// if ($defaultcurrentdirectory != $currentdirectory) {
		// 	$currentdirectory = $setcd;
		// }else {
		//
		// }
		// $defaultcurrentdirectory = $currentdirectory;
		$valuepros->setvalue("currentdirectory",$currentdirectory);
		$valuepros->setvalue("time",date('A-H:i:s'));
		$defined_vars = get_defined_vars();
		global $title_pros;
		$title_pros->terminal_set_title();
	}
}
