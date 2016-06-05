<?php
/**
 *
 */
class environmentVariables extends systemProcessing{
	function __construct(){
		# code...
	}
	public function setvalue($name,$value){
		global $environmentVariables;
		global $savevaluesmode;
		if ($savevaluesmode == "on") {
			$environmentVariables = unserialize(file_get_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "environmentVariables.dat"));
		}
		$environmentVariables[$name] = $value;
		// print_r($environmentVariables);
		if ($savevaluesmode == "on") {
			file_put_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "environmentVariables.dat", serialize($environmentVariables));
		}
	}

	public function delvalue($name){
		global $environmentVariables;
		global $savevaluesmode;
		if ($savevaluesmode == "on") {
			$environmentVariables = unserialize(file_get_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "environmentVariables.dat"));
		}
		unset($environmentVariables[$name]);
		// print_r($environmentVariables);
		if ($savevaluesmode == "on") {
			file_put_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "environmentVariables.dat", serialize($environmentVariables));
		}
	}

	public function getvalue($name){
		global $environmentVariables;
		if ($savevaluesmode == "on") {
			$environmentVariables = unserialize(file_get_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "environmentVariables.dat"));
		}
		// print_r($environmentVariables);
		return $environmentVariables[$name];
	}
}

?>
