<?php
namespace phppo\command\plugincommand;
use phppo\system\systemProcessing as systemProcessing;
/**
 *
 */
 class addcommand extends systemProcessing{

 	function __construct(){
 		# code...
 	}

 	public function addcommand($plugin,$basecommand,$type,$des,$usage,$enadis='enable'){
 		global $plugincommands;
 		$commands[$basecommand] = array('type' => $type, 'des' => $des, 'usage' => $usage, 'enadis'=> $enadis);
		$this->sendMessage("[{$type}] Command enabled:");
 	}
 }
