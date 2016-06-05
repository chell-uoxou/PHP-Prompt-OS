<?php
include_once(dirname(__FILE__) . "/../system/System.php");
class display extends systemProcessing{

	function __construct(){
		global $textformat;
		global $to_textformat;
		$textformat = array("FORMAT_BOLD","FORMAT_OBFUSCATED","FORMAT_ITALIC","FORMAT_UNDERLINE","FORMAT_STRIKETHROUGH","FORMAT_RESET","COLOR_BLACK","COLOR_DARK_BLUE","COLOR_DARK_GREEN","COLOR_DARK_AQUA","COLOR_DARK_RED","COLOR_PURPLE","COLOR_GOLD","COLOR_GRAY","COLOR_DARK_GRAY","COLOR_BLUE","COLOR_GREEN","COLOR_AQUA","COLOR_RED","COLOR_LIGHT_PURPLE","COLOR_YELLOW","COLOR_WHITE");
		$to_textformat = array("\x1b[1m","","\x1b[3m","\x1b[4m","\x1b[9m","\x1b[m","\x1b[38;5;16m","\x1b[38;5;19m","\x1b[38;5;34m","\x1b[38;5;37m","\x1b[38;5;124m","\x1b[38;5;127m","\x1b[38;5;214m","\x1b[38;5;145m","\x1b[38;5;59m","\x1b[38;5;63m","\x1b[38;5;83m","\x1b[38;5;87m","\x1b[38;5;203m","\x1b[38;5;207m","\x1b[38;5;227m","\x1b[38;5;231m");
	}
	public function txt_form_replace($value=''){
		# code...
	}

	public function setInfo($str){
		$str = trim($str);
		global $pr_info;
		$pr_info = $str;
	}

	public function getInfo(){
		global $pr_info;
		return $pr_info;
	}

	public function setThread($str){
		$str = trim($str);
		global $pr_thread;
		$pr_thread = $str;
	}

	public function getThread(){
		global $pr_thread;
		return $pr_thread;
	}

	public function reverseColor($auth){
		if ($auth) {
			echo "\033[7m";
		}else {
			echo "\x1b[m";
		}
	}
}
