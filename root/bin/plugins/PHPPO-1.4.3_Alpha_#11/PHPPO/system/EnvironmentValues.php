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
	}
	public function getvalue($name){
		global $environmentVariables;
		return $environmentVariables[$name];
	}
}

?>
