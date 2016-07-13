<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("echo","default","文字列を出力。","<メッセージ>/<on|off>");
//////////////////////
/**
 *
 */
class myEcho extends systemProcessing{
	function __construct(){
	}
	public function onCommand(){
		global $aryTipeTxt;
		global $environmentVariables;
		global $echoFunc;
		global $savevaluesmode;
		global $valuepros;
		global $raw_input;
		$valuepros = new environmentVariables;
		$messageCount = count($aryTipeTxt);
		$varname = "";
		if ($messageCount <= 1) {
			// $this->sendMessage("パラメーターが不足しています。");
			}else{
				$aryTipeTxt[1] = trim($aryTipeTxt[1]);
				switch ($aryTipeTxt[1]) {
					case 'off':
						$echoFunc = "off";
						break;
					case 'on':
						$echoFunc = "on";
						break;
					default:

						$message = substr($raw_input,5);
						// for ($i=1; $i < $messageCount; $i++) {
						// 	$message .= $aryTipeTxt[$i] . " ";
						// }
						if ($savevaluesmode == "on") {
							$environmentVariables = unserialize(file_get_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "environmentVariables.dat"));
						}
						$input = $message;
						foreach ($environmentVariables as $key => $value){
							// echo "key:" . $key . PHP_EOL;
							// echo "value:" . $value . PHP_EOL;
							$s_input = str_replace("\"%{$key}%\"","%{$key}%",$input);
							// echo $key . ":" . str_replace("\"%{$key}%\"","%{$key}%",$input) . PHP_EOL;
							// echo $key . ":" . str_replace("%{$key}%",$value,$input) . PHP_EOL;
							if ($s_input == $input) {
								$input = str_replace("%{$key}%",$value,$input);
							}else {
								$input = $s_input;
							}
						}
						$message = $input;
						$this->sendMessage($message);
						break;
				}

		}
	}
}


?>
