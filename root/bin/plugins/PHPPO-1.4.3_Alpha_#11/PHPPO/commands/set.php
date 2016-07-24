<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("set","default","変数へ代入します","<変数名> <値>");
//////////////////////
class set extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $aryTipeTxt;
		global $environmentVariables;
		$valuepros = new environmentVariables;
		$strCount = count($aryTipeTxt);
		if ($strCount <= 2) {
			$this->sendMessage("パラメーターが不足しています。");
			}else{
				$name = $aryTipeTxt[1];
				$aryTipeTxt[2] = trim($aryTipeTxt[2]);
				$str = '';
				for ($i=2; $i < $strCount; $i++) {
					$str .= $aryTipeTxt[$i] . " ";
				}
				// if (strstr($str, '%')) {
				// 	foreach ($environmentVariables as $key => $value){
				// 		// echo "key:" . $key . PHP_EOL;
				// 		// echo "value:" . $value . PHP_EOL;
				// 	$str = str_replace("%{$key}%",$value,$str);
				// 	}
				// }
				$valuepros->setvalue($name,trim($str));
				}
		}
}


?>
