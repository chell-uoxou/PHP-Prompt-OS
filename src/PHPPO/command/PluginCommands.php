<?php
namespace phppo\command\plugincommand;
use phppo\system\systemProcessing as systemProcessing;
$plugincommands = array();
/**
 *
 */
 class addcommand extends systemProcessing{

 	function __construct(){
 	}

 	public function addcommand($plugin,$basecommand,$type='plugin',$des='',$usage='',$enadis='enable'){
 		global $plugincommands;
		global $plugindata;
		global $translators;
		global $plugindata;
		$translator = $translators->get('PO.System.Plugin.Package');
		$enabled_message = $translator->translate('commandEnabled');
		$plugin_name = $plugindata[$plugin]["name"];
		global $defaultcommands;
		$obj = new $plugindata[$plugin]["main"];
		if (method_exists($obj,"onCommand")) {
			$plugincommands[$basecommand] = array('pluginname'=>$plugin_name,'basecommand'=>$basecommand,'type' => $type, 'des' => $des, 'usage' => $usage, 'enadis'=> $enadis);
			$this->info("\x1b[38;5;227m[{$plugin}] \x1b[38;5;83m{$enabled_message}\x1b[38;5;231m:\x1b[38;5;145m{$basecommand}");
		}else{
			$this->throwError('Couldn\'t add to the command (' . $basecommand . '). Because "onCommand" method not found in the plugin processing.' , "critical");
 	}
 }
}
