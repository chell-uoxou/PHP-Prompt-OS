<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("cat","default","指定されたファイルを表示","<パス>");
//////////////////////
class cat extends systemProcessing{
	function __construct(){
	}
	public function onCommand(){
		global $aryTipeTxt;
		global $environmentVariables;
		global $currentdirectory;
		global $all_path;
		// echo $currentdirectory;
		$pathCount = count($aryTipeTxt);
		if ($pathCount == 0) {
			$this->sendMessage("パラメーターが不足しています。");
		}else {
			$path = trim($currentdirectory) . "\\";
			for ($i=1; $i < $pathCount; $i++) {
				$path .= $aryTipeTxt[$i] . " ";
			}
			if (is_file($path)) {
				$this->sendMessage($path . "のデータを表示します。");
				$data = file_get_contents($path);
				$data = explode( "\n", $data );
				foreach ($data as $key => $value) {
					$space = str_repeat(" ",4 - strlen($key + 1));
					$a = $key + 1 . $space;
					$this->sendMessage("\x1b[38;5;145m" . $a ."\x1b[38;5;59m|\x1b[38;5;231m". $value);
				}
			}else{
				$this->sendMessage("ファイルの読み込みに失敗しました！:" . $path,"error");
			}
		}
	}
}


?>
