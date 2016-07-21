<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("conf","default","PHPPOの内部環境設定の表示・変更","<set|edit|reset|veaw|help>");
//////////////////////
class conf_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $systemConfigAry;
		global $aryTipeTxt;
		global $sysconfpros;
		if (count($aryTipeTxt) < 2) {
			$this->sendMessage("パラメーターが不足しています。");
			return false;
		}else{
			$do = $aryTipeTxt[1];
			switch ($do) {
				case 'set':
					if (count($aryTipeTxt) < 4) {
						$this->sendMessage("パラメーターが不足しています。");
						return false;
					}else{
						$setkey = $aryTipeTxt[2];
						$setvalue = $aryTipeTxt[3];
						$sysconfpros->setConfig($setkey,$setvalue);
					}
					break;
				case 'edit':
					if (count($aryTipeTxt) < 4) {
						$this->sendMessage("パラメーターが不足しています。");
						return false;
					}else {
						$setkey = $aryTipeTxt[2];
						$setvalue = $aryTipeTxt[3];
						if (isset($systemConfigAry[$setkey])) {
							$nowvalue = $systemConfigAry[$setkey];
						}else{
							$nowvalue = "NULL";
						}
						$this->sendMessage("\"{$setkey}\"の値は\"{$nowvalue}\"です。");
						$okay = $this->sendMessage("\"{$setvalue}\"に変更しますか？(y)","input");
						if ($okay == "y" || $okay == "Y") {
							$sysconfpros->setConfig($setkey,$setvalue);
							$this->sendMessage("変更しました。");
						}
					}
					break;

				case 'reset':
					# code...
					break;

				case 'veaw':
					if (count($aryTipeTxt) < 3) {
						$this->sendMessage("パラメーターが不足しています。");
						return false;
					}else {
						$setkey = $aryTipeTxt[2];
						if (isset($systemConfigAry[$setkey])) {
							$nowvalue = $systemConfigAry[$setkey];
							$this->sendMessage("\"{$setkey}\"の値は\"{$nowvalue}\"です。");
						}else{
							$nowvalue = "NULL";
							$this->sendMessage("設定値\"{$setkey}\"に値は存在しません。");
						}
					}
					break;

				case 'help':
					$this->sendMessage("////////confコマンド////////");
					$this->sendMessage("PHPPOの内部環境設定の表示と変更を行います。");
					$this->sendMessage("第一引数にサブコマンド、第二引数以降にそれぞれの値が入ります。");
					$this->sendMessage("========使用方法========");
					$this->sendMessage("conf set <設定値名> <値> : 設定値名に値を強制的に代入します。スクリプト実行時などで用いられます。");
					$this->sendMessage("conf edit <設定値名> <値> : 設定値名に値をユーザーへの確認の上代入します。画面上の実行の場合setよりもこちらを推奨します。");
					$this->sendMessage("conf reset <設定値名>     : 指定された設定値名の値を既定の設定に戻します。");
					$this->sendMessage("conf veaw <設定値名>      :指定された設定値名の値を表示します。");
					$this->sendMessage("conf help              　  :confコマンドの使用法を表示します。");
					break;
				default:

					break;
			}
		}
	}
}


?>
