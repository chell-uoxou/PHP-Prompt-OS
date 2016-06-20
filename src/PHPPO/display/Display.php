<?php
include_once(dirname(__FILE__) . "/../system/System.php");
class display extends systemProcessing{

	function __construct(){
		
	}
	public function setInfo($str){
		$str = trim($str);
		global $pr_info;
		$pr_info = $str;
	}

	public function setThread($str){
		$str = trim($str);
		global $pr_thread;
		$pr_thread = $str;
	}

	public function reverseColor($auth){
		if ($auth) {
			echo "\033[7m";
		}else {
			echo "\x1b[m";
		}
	}
}
