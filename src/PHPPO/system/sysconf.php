<?php
/**
 *
 */
class systemConfig extends systemProcessing{

	function __construct($type){
		global $systemConfigAry;
		if ($type == "read") {
			$systemConfigAry = unserialize(file_get_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "systemconfig.dat"));
		}
	}

	public function setConfig($key,$value){
		global $systemConfigAry;
		$systemConfigAry[$key] = $value;
		file_put_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "systemconfig.dat", serialize($systemConfigAry));
	}

	public function getConfig($key){
		global $systemConfigAry;
		$systemConfigAry = unserialize(file_get_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "systemconfig.dat"));
		if (isset($systemConfigAry[$key])) {
			$value = $systemConfigAry[$key];
		}else{
			$value = NULL;
		}
		return $value;
	}

	public function reload(){
		global $systemConfigAry;
		file_put_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "systemconfig.dat", serialize($systemConfigAry));
		$systemConfigAry = unserialize(file_get_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "systemconfig.dat"));
	}
}
