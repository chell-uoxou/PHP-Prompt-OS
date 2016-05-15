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
						$message = '';
						for ($i=1; $i < $messageCount; $i++) {
							$message .= $aryTipeTxt[$i] . " ";
						}
						if (strstr($message, '%')) {
								foreach ($environmentVariables as $key => $value){
									// echo "key:" . $key . PHP_EOL;
									// echo "value:" . $value . PHP_EOL;
								$message = str_replace("%{$key}%",$value,$message);
							}
						}
						$this->sendMessage($message);
						break;
				}

		}
	}
}


?>
