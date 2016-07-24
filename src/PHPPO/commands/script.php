<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("script","default","テキスト上のコマンドを改行ごとに実行します。","<ファイルネーム（拡張子を含む）>");
include_once(dirname(__FILE__) . "/../command/command.php");
//////////////////////
class script_command extends systemProcessing{
	function __construct(){
	}
	public function onCommand(){
		global $aryTipeTxt;
		global $tipe_text;
		global $commands;
		global $currentdirectory;
		global $commandpros;
		global $raw_input;
		global $extensionCommands;
		global $running;
		global $runScriptPath;
		global $lastTipeTxt;
		global $display;;
		$pathCount = count($aryTipeTxt);
		if ($pathCount <= 1) {
			$this->sendMessage("パラメーターが不足しています。");
return false;
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
					$r_path = $current_path;
					$file = file_get_contents($r_path, true);
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
							return false;
						}
					}
				}
				$array = explode("\n", $file);
				$array = array_map('trim', $array);
				// $array = array_filter($array, 'strlen');
				$array = array_values($array);
				$array = array_merge($array);
				$delfor = array();
				foreach($array as $key => $value){
					// echo $key;
					// var_dump($array);
					if ($value != "") {
						if($value[0] == "#"){
							// echo "うっひょわ";
							$delfor[] = $key;
							$array = array_values($array);
							$array = array_merge($array);
							// echo $value . PHP_EOL;
						}
					}
				}
				foreach ($delfor as $key => $value) {
					unset($array[$value]);
				}
				$array = array_values($array);
				for ($i=0; $i < $pathCount + 2; $i++) {

				}
				// var_dump($array);
				$line = 0;
				$conf =true;
				// var_dump($array);
				foreach ($array as $key => $value) {
					// var_dump($commands);
					// var_dump($value);
					$line++;
					if ($value != "") {
						$aryTipeTxt = explode(" ", trim($value));
						$conf = array_key_exists($aryTipeTxt[0], $commands);
						if ($conf === false) {
							$conf = array_key_exists($aryTipeTxt[0], $extensionCommands);
							if ($conf === false) {
								$this->sendMessage("Script error:確認されない命令\"{$value}\"が見つかりました。 in {$name} -> line{$line}","error");
								return false;
								break;
							}
						}
					}
				}
				$running = "script";
				$runScriptPath = $r_path;//スクリプト実行中にcdでパスが指定できるようにする作業

				$repl1 = array("%__FILE__%","%sys.last.command%");//を
				$repl2 = array(dirname($runScriptPath),$lastTipeTxt);//に
				if ($conf === true) {
					foreach ($array as $tipe_text) {
						if ($running == "script") {
							$tipe_text = $this->inputProcessor($tipe_text);
							$tipe_text = str_replace($repl1,$repl2,$tipe_text);
							$raw_input = $tipe_text;
							$commandpros->runCommand();
						}elseif ($running === false) {
							break;
						}
					}
				}
		}
		$running = false;
	}
}


?>
