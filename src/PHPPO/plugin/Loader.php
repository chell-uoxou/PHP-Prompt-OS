<?php
namespace phppo\plugin\loader;
// include_once(dirname(__FILE__) . "/../system/System.php");
use phppo\system\systemProcessing as systemProcessing;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . "\lib\spyc-0.5\spyc.php";
@$fileplugins = scandir(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\plugins');
$i = 0;
$j = 0;
if (isset($fileplugins)) {
	foreach ($fileplugins as $key => $value) {
		// var_dump($fileplugins[$i]);
		if ($fileplugins[$i] == "." || $fileplugins[$i] == ".." ) {
		}else {
			$dirplugins[$j] = dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\plugins\\' . $fileplugins[$i];
			$j++;
		}
		$i++;
	}

	foreach ($dirplugins as $key => $value) {
		if ($value . "/plugin.yml") {
			$replugindata[$key] = \Spyc::YAMLLoad($value . "/plugin.yml");
		}
	}

	if (isset($replugindata)) {
		foreach ($replugindata as $key => $value) {
			// var_dump($value);///////////////////////////////////
		}
	}
	// var_dump($dirplugins);//////////////////////////////////////////////
}
