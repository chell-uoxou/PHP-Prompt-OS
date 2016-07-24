<?php
namespace phppo\system;

use phppo\system\systemProcessing as systemProcessing;
/**
*
*/
class currentdirectory extends systemProcessing{
	function __construct(){
		global $currentdirectory;
		global $poPath;
		$currentdirectory = $poPath;
	}

	public function setCurrentDirectory($path){
		global $currentdirectory;
		global $poPath;
		global $all_path;
		global $po_cd;
		$currentdirectory = trim($currentdirectory);
		if ($path != "") {
			$all_path = $currentdirectory . "\\" . $path;
		}else {
			$all_path = $currentdirectory;
		}
		$path = trim($path,"\\");
		$path = trim($path,"/");
		if (file_exists(realpath($all_path))) {
			if (is_dir($all_path)) {
				$currentdirectory = realpath($all_path);
			}else {
				$this->sendMessage("指定したパスはディレクトリではありません。","error");
			}
		}else{
			if (substr_count($path,'../') !== 0) {
				for ($i=0; $i < substr_count($path,'../'); $i++) {
					$currentdirectory = trim(dirname($currentdirectory));
				}
			}else{
				if (file_exists($all_path)){
					if (is_dir($all_path)) {
						$currentdirectory = $all_path;
					}else {
						$this->sendMessage("指定したパスはディレクトリではありません。","error");
					}
				}else{
					if (file_exists(realpath($path))) {
						if (is_dir(realpath($path))) {
							$currentdirectory = realpath($path);
						}else {
							$this->sendMessage("指定したパスはディレクトリではありません。","error");
						}
					} else {
						if (file_exists($path)) {
							if (is_dir($path)) {
								$currentdirectory = $path;
							}else {
								$this->sendMessage("指定したパスはディレクトリではありません。","error");
							}
						} else {
							$this->sendMessage("No such file or directory:{$all_path}","error");
						}
					}
				}
			}
		}
	}
}
