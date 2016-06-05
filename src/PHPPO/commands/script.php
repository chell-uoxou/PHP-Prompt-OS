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
		global $commands;
		global $currentdirectory;
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
				// $path = "scripts\\" . $name;
				////////////////////////////////script処理////////////////////////////////
				////////////仕分け作業///////////////
				$file = "";
				$current_path = trim($currentdirectory) . "\\" . $name;
				if (file_exists($current_path)) {
					$file = file_get_contents($current_path, true);
				}else {
					if (file_exists($name)) {
						$r_path = $name;
						$file = file_get_contents($r_path, true);
					}else{
						$path = trim($name,"\"");
						if (file_exists($path)) {
							$r_path = $path;
							$file = file_get_contents($r_path, true);
						}else{
							$this->sendMessage("スクリプトの読み込みに失敗しました。指定したスクリプトは存在しない可能性があります。:{$current_path}","error");
						}
					}
				}
				$array = explode("\n", $file);
				$array = array_map('trim', $array);
				$array = array_filter($array, 'strlen');
				$array = array_values($array);
				$line = 0;
				$conf =true;
				// var_dump($array);
				foreach ($array as $key => $value) {
					// var_dump($commands);
					// var_dump($value);
					$line++;
					$aryTipeTxt = explode(" ", trim($value));
					$conf = array_key_exists($aryTipeTxt[0], $commands);
					if ($conf === false) {
						$this->sendMessage("Script error:確認されない命令\"{$value}\"が見つかりました。 in {$name} -> line{$line}","error");
						break;
					}
				}
				if ($conf === true) {
					foreach ($array as $tipe_text) {
						runCommand();
					}
				}
		}
	}
}


?>
