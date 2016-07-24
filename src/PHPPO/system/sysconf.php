<?php

namespace phppo\system;
/**
 *
 */
use phppo\system\systemProcessing as systemProcessing;
class systemConfig extends systemProcessing{

	function __construct($type){
		global $systemConfigAry;
		if ($type == "read") {
			if (!file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "systemconfig.dat")) {
				touch(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "systemconfig.dat");
				$systemConfigAry = array();//初期化
				file_put_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "systemconfig.dat", serialize($systemConfigAry));
			}
			$systemConfigAry = unserialize(file_get_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "systemconfig.dat"));
		}
	}

	public function setConfig($key,$value){
		global $systemConfigAry;
		$systemConfigAry[$key] = $value;
	}

	public function getConfig($key){
		global $systemConfigAry;
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
