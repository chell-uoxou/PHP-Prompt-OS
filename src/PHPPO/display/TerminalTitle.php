<?php
namespace phppo\display;

use phppo\system\systemProcessing;

class TerminalTitle extends systemProcessing{

	public $term_title;
	public $term_base_title;
	public $title_pros;
	function __construct(){
		# code...
	}
	public function setBaseTitle($value){
		global $term_base_title;
		$term_base_title = $value;
	}

	public function terminal_set_title($value = NULL){
		global $term_title;
		global $term_base_title;
		global $system_status_text;
		global $pr_time;
		global $pr_thread;
		global $pr_info;
		global $po_cd;
		global $environmentVariables;
		if ($value == NULL) {
			$pr_time = date('A-H:i:s');
			$repl = array("%time","%cd","%thread","%info","%status");
			$repl2 = array($pr_time,$po_cd,$pr_thread,$pr_info,$system_status_text);
			// echo ":$term_base_title";
			$value = str_ireplace($repl,$repl2,$term_base_title);
			$input = $value;
			foreach ($environmentVariables as $key => $value){
				// echo "key:" . $key . PHP_EOL;
				// echo "value:" . $value . PHP_EOL;
				$s_input = str_replace("\"%{$key}%\"","%{$key}%",$input);
				// echo $key . ":" . str_replace("\"%{$key}%\"","%{$key}%",$input) . PHP_EOL;
				// echo $key . ":" . str_replace("%{$key}%",$value,$input) . PHP_EOL;
				if ($s_input == $input) {
					$input = str_replace("%{$key}%",$value,$input);
				}else {
					$input = $s_input;
				}
			}
			$value = $input;
			$term_title = $value;
		}

		echo "\x1b]0;" . $value . "\x07";
	}

	public function terminal_get_title($type=''){
		global $term_title;
		return $term_title;
	}
}
