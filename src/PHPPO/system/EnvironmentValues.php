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
		$environmentVariables[$name] = $value;
		// print_r($environmentVariables);
		file_put_contents("environmentVariables.dat", serialize($environmentVariables));
	}
	public function getvalue($name){
		global $environmentVariables;
		$environmentVariables = unserialize(file_get_contents("environmentVariables.dat"));
		// print_r($environmentVariables);
		return $environmentVariables[$name];
	}
}

?>
