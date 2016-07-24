<?php
namespace phppo\system;

use phppo\system\systemProcessing as systemProcessing;
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
		if ($savevaluesmode == "on") {
			file_put_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "environmentVariables.dat", serialize($environmentVariables));
		}
		return true;
	}

	public function delvalue($name){
		global $environmentVariables;
		global $savevaluesmode;
		if ($savevaluesmode == "on") {
			$environmentVariables = unserialize(file_get_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "environmentVariables.dat"));
		}
		if (isset($environmentVariables["name"])) {
			unset($environmentVariables[$name]);
			return true;
		}else{
			return false;
		}
		// print_r($environmentVariables);
		if ($savevaluesmode == "on") {
			file_put_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "environmentVariables.dat", serialize($environmentVariables));
		}
	}

	public function getvalue($name){
		global $environmentVariables;
		global $savevaluesmode;
		if ($savevaluesmode == "on") {
			$environmentVariables = unserialize(file_get_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "environmentVariables.dat"));
		}
		// print_r($environmentVariables);
		if(isset($environmentVariables[$name])){
			return $environmentVariables[$name];
		}else{
			return false;
		}
	}
}

?>
