<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("vars","default","定義済みの環境変数を表示します。","");
//////////////////////
class vars extends systemProcessing{
	function __construct(){
	}
	public function onCommand(){
		global $environmentVariables;
		global $savevaluesmode;
		if ($savevaluesmode == "on") {
			$environmentVariables = unserialize(file_get_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "environmentVariables.dat"));
		}
		foreach ($environmentVariables as $key => $value){
			$this->sendMessage("\x1b[38;5;34m[" . $key . "]\x1b[38;5;207m:" . "\x1b[38;5;87m" . $value . "\x1b[38;5;145m-\x1b[38;5;59m(" . gettype($value) . ")");
		}
	}
}
