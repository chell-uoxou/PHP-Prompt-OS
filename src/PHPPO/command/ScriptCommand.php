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
		global $extensionCommandsDescription;
		if (!file_exists($poPath . "/root/bin/extensions.ini")) {
			touch($poPath . "/root/bin/extensions.ini");
			file_put_contents($poPath . "/root/bin/extensions.ini",'
;This file allows you to append the command you want to add in the script.
;Usage : <command name>=<The path of the appropriate script>
;example : "hoge=bin/scriptcommands/hoge.sh"
;In this case, the "bin/scriptcommands/hoge.sh" will be executed when the "hoge" is entered in PHPPO.
;Please enter the "/root" following the path.
;
;===================================CAUTION!===================================
;	In the case of overlapping with commands that have already been
;	implemented,PHPPO throws an error at the time of start-up, preferentially
;	already mounted command is executed.
;==============================================================================
hello=hello.sh
welcome = bin\welcome.sh
cls = bin\interchangeable\cls.sh
onigiri = onigiri.sh
');
		}
		$aryfile = explode(PHP_EOL,file_get_contents($poPath . "/root/bin/extensions.ini"));
		$plsdel = array();
		$extensionCommands = parse_ini_file($poPath . "/root/bin/extensions.ini");
		$extensionCommandsDescription = parse_ini_file($poPath . "/root/bin/extension_description.ini");
		// var_dump($commands);
		foreach ($extensionCommands as $key => $value) {
			// $this->sendMessage("{$key}:拡張コマンド");
			$path = $poPath . "\\root\\" . $value;
			// echo $path . PHP_EOL;
			if (array_key_exists($key,$commands)) {
				$plsdel[] = $key;
				// var_dump($aryfile);///////////////////////////////////////////////////////////
				// var_dump($key);///////////////////////////////////////////////////////////
				// $line = array_search($key,$aryfile);
				foreach ($aryfile as $line_1 => $value) {
					if(strpos($value,$key) !== false){
						$line = $line_1 + 1;
					}
				}
				// var_dump($line);///////////////////////////////////////////////////////////
				$this->sendMessage("拡張コマンドの読み込み時に競合が発生したため、実装済みコマンドが優先されます。コマンド:\"" . $key . "\" on \"{$poPath}/root/bin/extensions.ini\" -> line {$line}","error");
			}else{
				if (!file_exists($path)) {
					$plsdel[] = $key;
					$this->sendMessage("記述された拡張コマンドにあたるパスは無効です。","error");
					$this->sendMessage("Desabled [" . $key . "] Command :File not found --{$path}","error");
				}else {
					// if (isset($extensionCommandsDescription[$key])) {
					// 	$extensionCommands[$key]["des"] = $extensionCommandsDescription[$key];
					// }
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
