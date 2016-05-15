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
		// array_push($commands,$basecommand);
		$commands[$basecommand] = array('type' => $type, 'des' => $des, 'usage' => $usage);
		usleep(rand(1000,10000));///演出()
		$this->sendMessage("\x1b[38;5;87m{$type} command \x1b[38;5;83menabled. \x1b[38;5;145m:\x1b[38;5;214m{$basecommand}");
	}
}


?>
