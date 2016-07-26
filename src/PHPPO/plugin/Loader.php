<?php
namespace phppo\plugin\loader;
// include_once(dirname(__FILE__) . "/../system/System.php");
use phppo\system\systemProcessing as systemProcessing;
$system = new systemProcessing;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . "\lib\spyc-0.5\spyc.php";

/**
 *
 */
class ClassName extends systemProcessing{

	function __construct(argument)
	{
		# code...
	}

	public function pluginLoad(){
		global $fileplugins;
		@$fileplugins = scandir(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\plugins');
		$i = 0;
		$j = 0;
		if (isset($fileplugins)) {
			foreach ($fileplugins as $key => $value) {
				// var_dump($fileplugins[$i]);
				if ($fileplugins[$i] != "." && $fileplugins[$i] != ".." ) {
					$dirplugins[$j] = dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\plugins\\' . $fileplugins[$i];
					$j++;
				}
				$i++;
			}

			foreach ($dirplugins as $key => $value) {
				if (is_file($value . "/plugin.yml")) {
					$replugindata[$key] = \Spyc::YAMLLoad($value . "/plugin.yml");
					$replugindata[$key]["sys-bin-path"] = $value;
				}
			}

			if (isset($replugindata)) {
				foreach ($replugindata as $key => $value) {
					$pluginname = $value["name"];
					$plugindata[$pluginname]= $value;
				}
			}
			// var_dump($replugindata);///////////////////////
			// echo "skjdhsdfolakjsdhflaksjdhflaksdjfhlaskdfjhasldkfjhasdlkfjhsadlfkjhasdlkfjhasdlfkjahsdflkasjhdf\n";
			var_dump($plugindata);
			// var_dump($dirplugins);//////////////////////////////////////////////
			// ここからプラグイン読み込み
			foreach ($plugindata as $key => $value) {
				$plugin_bin_path = $value["sys-bin-path"];
				$plugin_src_path = $plugin_bin_path . "/" . $value["path"];
				$plugin_version = $value["version"];
				$plugin_main = $value["main"];
				if (is_file($plugin_src_path)) {
					$system->sendMessage("{$key} V.{$plugin_version}を読み込み中...");
					include_once($plugin_src_path);
					$system->generateEvent("onLoad",$plugin_main);
				}
			}
		}
	}
}
