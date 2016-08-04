<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("plugins","default","有効化されているプラグインを表示します。","");
//////////////////////
class plugins_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $plugindata;
		$veawplugindata = ksort($plugindata);
		foreach ($plugindata as $key => $value) {
			$plugin_version = $value["version"];
			$plugin_name = $value["name"];
			// var_dump($value);////////////////////
			if (isset($value["status"])) {
				if ($value["status"] == "disable") {
					$this->info("\x1b[38;5;203m{$plugin_name}\x1b[38;5;214m version {$plugin_version} : disabled");
				}
			}else{
				$this->info("\x1b[38;5;83m{$plugin_name}\x1b[38;5;214m version {$plugin_version}");
			}
		}
	}
}


?>
