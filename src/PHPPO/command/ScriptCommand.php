<?php
/**
 *
 */
class scriptCommand extends systemProcessing{
	function __construct(){
		# code...
	}
	public function readExtension($value=''){
		global $poPath;
		global $commands;
		global $extensionCommands;
		$plsdel = array();
		$extensionCommands = parse_ini_file($poPath . "/root/bin/extensions.ini");
		// var_dump($commands);
		foreach ($extensionCommands as $key => $value) {
			// $this->sendMessage("{$key}:拡張コマンド");
			$path = $poPath . "\\root\\" . $value;
			// echo $path . PHP_EOL;
			if (array_key_exists($key,$commands)) {
				$plsdel[] = $key;
				$this->sendMessage("拡張コマンドの読み込み時に競合が発生したため、実装済みコマンドが優先されます。コマンド:" . $key,"error");
			}else{
				if (!file_exists($path)) {
					$plsdel[] = $key;
					$this->sendMessage("記述された拡張コマンドにあたるパスは無効です。","error");
					$this->sendMessage("Desabled [" . $key . "] Command :File not found --{$path}","error");
				}else {
					$extensionCommands[$key] = $path;
				}
			}
		}
		foreach ($plsdel as $key => $value) {
			unset($extensionCommands[$value]);
		}
		// var_dump($extensionCommands);
	}
}
