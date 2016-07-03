<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("vardump","dev","システム処理が継承した'vardump'クラス内から呼び出せるパブリック変数、及びメイン処理におけるグローバル変数の内容を表示します。","<変数名>");
//////////////////////
/**
 *
 */
class vardump extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $aryTipeTxt;
		$messageCount = count($aryTipeTxt);
		if ($messageCount <= 1) {
			$this->sendMessage("パラメーターが不足しています。");
			$this->sendMessage("vardumpコマンドの使用法:");
			$this->sendMessage("vardump <変数名> / <指定したクラス内の変数名> <変数を表示するクラス>:システム処理が継承した'vardump'クラス内から呼び出せるパブリック変数、及びメイン処理におけるグローバル変数の内容を表示します。");
			$this->sendMessage("第二引数を指定していない場合はメイン処理におけるグローバル変数の内容を表示します。");
			}else{
				if ($messageCount <= 2) {
					$var_name = trim($aryTipeTxt[1]);
					global $$var_name;
					$this->sendMessage("メイン処理におけるグローバル化変数'" . $var_name . "'の内容を表示します。" . PHP_EOL);
					var_dump($$var_name);
				}else{
					$var_name = trim($aryTipeTxt[1]);
					$var_inclass = trim($aryTipeTxt[2]);
					if ($var_inclass == "this") {
						$this->sendMessage("");
					}
					$this->sendMessage("'$var_inclass'クラス内のパブリック変数'$var_name'の内容を表示します。");
					$var_inclass = new $var_inclass;
					var_dump($var_inclass->$var_name);
				}
			}
	}
}


?>
