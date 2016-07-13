<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("ls","default","カレントディレクトリ上のファイルとディレクトリのリストを表示します。","");
//////////////////////
class ls_command extends systemProcessing{
	function __construct(){

	}

	public function onCommand(){
		global $aryTipeTxt;
		global $currentdirectory;
		$filelist = scandir($currentdirectory, 1);
		$this->sendMessage("\x1b[38;5;59m=====\x1b[38;5;37mDirectories\x1b[38;5;59m===== \x1b[38;5;59m:" . $currentdirectory);
		foreach ($filelist as $key => $value) {
			$alp = $currentdirectory . "\\" . $value;
			if (is_dir($alp)) {
				$this->sendMessage($value);
			}
		}

		$this->sendMessage("\x1b[38;5;59m========\x1b[38;5;37mFiles\x1b[38;5;59m======== \x1b[38;5;59m:" . $currentdirectory);
		foreach ($filelist as $key => $value) {
			$alp = trim($currentdirectory) . "\\" . $value;
			if (is_file($alp)) {
				$this->sendMessage($value);
			}
		}
	}
}

?>
