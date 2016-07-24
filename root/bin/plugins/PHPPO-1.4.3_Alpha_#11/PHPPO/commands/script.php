<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("script","default","テキスト上のコマンドを改行ごとに実行します。","<ファイルネーム（拡張子を含む）>");
include_once(dirname(__FILE__) . "/../command/command.php");
//////////////////////
class script extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $aryTipeTxt;
		global $tipe_text;
		$display = new display;
		$pathCount = count($aryTipeTxt);
		if ($pathCount <= 1) {
			$this->sendMessage("パラメーターが不足しています。");
			}else{
				$aryTipeTxt[1] = trim($aryTipeTxt[1]);
				$name = '';
				for ($i=1; $i < $pathCount; $i++) {
					$name .= $aryTipeTxt[$i] . " ";
				}
				$path = "scripts/" . $name;
				////////////////////////////////script処理////////////////////////////////
				////////////仕分け作業///////////////
				$file = "";
				if (file_exists($path)) {
					$file = file_get_contents($path, true);
				}else{
					$path = rtrim($path,"scripts/");
					if (file_exists($path)) {
						$file = file_get_contents($path, true);
					}else{
						$display->setInfo("ERROR");
						$this->sendMessage("スクリプトの読み込みに失敗しました。指定したスクリプトは存在しない可能性があります。");
						$display->setInfo("INFO");
					}
				}
				$array = explode("\n", $file);
				$array = array_map('trim', $array);
				$array = array_filter($array, 'strlen');
				$array = array_values($array);
				foreach ($array as $tipe_text) {
					runCommand();
				}
		}
	}
}


?>
