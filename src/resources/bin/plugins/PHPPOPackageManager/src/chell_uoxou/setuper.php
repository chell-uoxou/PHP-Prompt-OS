<?php
namespace ppm;

class setuper extends main{

	function __construct(){
	}

	public function startSetup(){
		$makepathes = array(
			"ppm/",
			"ppm/cache/",
			"ppm/tmp"
		);
		foreach ($makepathes as $key => $value) {
			$fullpath = $GLOBALS['poPath'] . "/root/bin/" . $value;
			if (!is_dir($fullpath)) {
				$this->mySendInfo("{$value} directory does not exist. Makeing...");
				mkdir($fullpath);
			}
		}
	}
}
