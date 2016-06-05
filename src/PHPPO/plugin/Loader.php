<?php
include_once dirname(__FILE__) . '/../display/display.php';
include_once(dirname(__FILE__) . "/../system/System.php");
$commands = array();
$dirplugins = scandir(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\plugins');
$i = 0;
foreach ($dirplugins as $key => $value) {
	$dirplugins[$i] = dirname(dirname(dirname(dirname(__FILE__)))) . '\root\plugins\\' . $dirplugins[$i];
	$i++;
}
// var_dump($dirplugins);
