<?php
/**
 *
 */
class addcommand extends systemProcessing{

	function __construct(){
		# code...
	}
	public function addcommand($basecommand,$type,$des,$usage){
		global $commands;
		var_dump($basecommand);
		// array_push($commands,$basecommand);
		$commands[$basecommand] = array('type' => $type, 'des' => $des, 'usage' => $usage);
		
	}
}


?>
