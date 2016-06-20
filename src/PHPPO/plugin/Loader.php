<?php
include_once(dirname(__FILE__) . "/../system/System.php");
$system = new systemProcessing;
$commands = array();
@$fileplugins = scandir(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\plugins');
$i = 0;
$j = 0;
if (isset($fileplugins)) {
	foreach ($fileplugins as $key => $value) {
		// var_dump($fileplugins[$i]);
		if ($fileplugins[$i] == "." || $fileplugins[$i] == ".." ) {
		}else {
			$dirplugins[$j] = dirname(dirname(dirname(dirname(__FILE__)))) . '\root\plugins\\' . $fileplugins[$i];
			$j++;
		}
		$i++;
	}
}
