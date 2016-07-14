<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("wget","default","ファイルをダウンロードします。","<URL>");
//////////////////////
class wget_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $aryTipeTxt;
		global $currentdirectory;
		$pathCount = count($aryTipeTxt);
		$path = "";
		if ($pathCount == 0) {
			$this->sendMessage("パラメーターが不足しています。");
			return false;
		}else {
			for ($i=1; $i < $pathCount; $i++) {
				$path .= $aryTipeTxt[$i] . " ";
			}
			$path;
			$onerror = $this->file_download($path,$currentdirectory);
			return $onerror;
		}
	}
}


?>
