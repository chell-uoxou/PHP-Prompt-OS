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

 	public function addcommand($plugin,$basecommand,$type='plugin',$des='',$usage='',$enadis='enable'){
 		global $plugincommands;
		global $plugindata;
		$plugin_name = $plugindata[$plugin]["name"];
		global $defaultcommands;
 		$plugincommands[$basecommand] = array('pluginname'=>$plugin_name,'basecommand'=>$basecommand,'type' => $type, 'des' => $des, 'usage' => $usage, 'enadis'=> $enadis);
		$this->info("\x1b[38;5;227m[{$plugin}] \x1b[38;5;83mCommand enabled\x1b[38;5;231m:\x1b[38;5;145m{$basecommand}");
 	}
 }
