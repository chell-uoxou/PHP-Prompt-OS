<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("conf","default","PHPPOの内部環境設定の表示・変更","<set|edit|reload|veaw|help>");
//////////////////////
class conf_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $systemConfigAry;
		global $aryTipeTxt;
		global $sysconfpros;
		if (count($aryTipeTxt) < 2) {
			$this->info("パラメーターが不足しています。");
			return false;
		}else{
			$do = $aryTipeTxt[1];
			switch ($do) {
				case 'set':
					if (count($aryTipeTxt) < 4) {
						$this->info("パラメーターが不足しています。");
						return false;
					}else{
						$setkey = $aryTipeTxt[2];
						$setvalue = $aryTipeTxt[3];
						$this->setConvValue($setkey,$setvalue);
					}
					break;
				case 'edit':
					if (count($aryTipeTxt) < 4) {
						$this->info("パラメーターが不足しています。");
						return false;
					}else {
						$setkey = $aryTipeTxt[2];
						$setvalue = $aryTipeTxt[3];
						$nowvalue = $this->getConvValue($setkey);
						if (isset($nowvalue)) {
							if (is_array($nowvalue)) {
								$this->info("\"{$setkey}\"の値は配列です。\n=======================");
								foreach ($nowvalue as $key => $value) {
									$var = var_export($value,true);
									$this->info("\x1b[38;5;203m{$key} \x1b[38;5;145m:\x1b[38;5;227m {$var}");
									$this->info("\x1b[38;5;59m-----------------------");
								}
								break;
							}else{
								$this->info("\"{$setkey}\"の値は\"{$nowvalue}\"です。");
							}
						}else{
							$nowvalue = "NULL";
							$this->info("設定値\"{$setkey}\"に値は存在しません。");
						}
						$okay = $this->input("\"{$setvalue}\"に変更しますか？(y)");
						if ($okay == "y" || $okay == "Y") {
							// $sysconfpros->setConfig($setkey,$setvalue);
							$this->setConvValue($setkey,$setvalue);
							$this->info("変更しました。");
						}
					}
					break;

				case 'reset':
					if (count($aryTipeTxt) < 3) {
						$this->info("パラメーターが不足しています。");
						return false;
					}else {
						$delkey = $aryTipeTxt[2];
						// $this->delConvValue($delkey);
					}
				break;

				case 'reload':
					$this->info("システム内部環境設定ファイルの再読み込みを行っています...");
					$sysconfpros->reload();
					$this->info("完了しました！");
					break;

				case 'veaw':
					if (count($aryTipeTxt) < 3) {
						$this->info("パラメーターが不足しています。");
						return false;
					}else {
						$setkey = $aryTipeTxt[2];
						$nowvalue = $this->getConvValue($setkey);
						if (isset($nowvalue)) {
							if (is_array($nowvalue)) {
								$this->info("\"{$setkey}\"の値は配列です。\n=======================");
								foreach ($nowvalue as $key => $value) {
									$var = var_export($value,true);
									$this->info("\x1b[38;5;203m{$key} \x1b[38;5;145m:\x1b[38;5;227m {$var}");
									$this->info("\x1b[38;5;59m-----------------------");
								}
							}else{
								$this->info("\"{$setkey}\"の値は\"{$nowvalue}\"です。");
							}
						}else{
							$nowvalue = "NULL";
							$this->info("設定値\"{$setkey}\"に値は存在しません。");
						}
					}
					break;

				case 'help':
					$this->info("////////confコマンド////////");
					$this->info("PHPPOの内部環境設定の表示と変更を行います。");
					$this->info("第一引数にサブコマンド、第二引数以降にそれぞれの値が入ります。");
					$this->info("========使用方法========");
					$this->info("conf set <設定値名> <値> : 設定値名に値を強制的に代入します。スクリプト実行時などで用いられます。");
					$this->info("conf edit <設定値名> <値> : 設定値名に値をユーザーへの確認の上代入します。画面上の実行の場合setよりもこちらを推奨します。");
					// $this->info("conf reset <設定値名>     : 指定された設定値名の値を既定の設定に戻します。");
					$this->info("conf reload              :システム設定用ファイルの再読み込みを行います。");
					$this->info("conf veaw <設定値名>      :指定された設定値名の値を表示します。");
					$this->info("conf help              　  :confコマンドの使用法を表示します。");
					break;
				default:

					break;
			}
		}
	}

	private function getConvValue($int){////abc.de.fg
		global $systemConfigAry;
		global $sysconfpros;
		$aryint = explode(".",$int);///array=>{[0]=>"abc",[1]=>"de",[2]=>"fg"}
		$a = count($aryint);//3
		// $result = array('abc' => array('de'=>array('fg'=>array('ij'=>"おにぎり")),array('kl'=>"ぎんなん")));;///result = array=>{"abc"=>array("de"=>array("fg"=>"おにぎり"))}
		$result = $systemConfigAry;
		for ($i=0; $i < $a; $i++) {///repeat 3 times
			// echo $i;////////////////////////
			$repkey = $aryint[$i];////repkey = abc : de : fg
			if (!isset($result[$repkey])) {
				return NULL;
				break;
			}else{
				$result = $result[$repkey];//result = array("de"=>array("fg"=>"おにぎり")) : array("fg"=>"おにぎり") : "おにぎり"
			}
			// var_dump($result);/////////////////////////////
		}
		return $result;
	}

	private function setConvValue($key,$value){////abc.de.fg , "おむすび"
		global $systemConfigAry;
		global $sysconfpros;
		$arykey = explode(".",$key);//arykey = array([0]=>"abc",[1]=>"de",[2]=>"fg")
		// var_dump($arykey);///////////////////////////////////////////
		$a = count($arykey);//3
		$b = $arykey[($a - 1)];//b = "fg"
		$result[$b] = $value;//result = array("fg"=>"おむすび")
		for ($i = $a - 1; $i > 0; $i--) {//repeat 2times
			$repkey = $arykey[($i - 1)];//[1]:repkey = "de" : [0]:repkey = "abc"
			$result[$repkey] = $result;//result = array("de"=>array("fg"=>"おむすび")) : array("abc"=>array("de"=>array("fg"=>"おむすび")))
			unset($result[$arykey[$i]]);
			// var_dump($result);//////////////////////////////////////
		}
		$systemConfigAry = array_merge_recursive($systemConfigAry,$result);
		file_put_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "systemconfig.dat", serialize($systemConfigAry));
	}

	private function delConvValue($key){////abc.de.fg
		global $systemConfigAry;
		global $sysconfpros;
		$arykey = explode(".",$key);//arykey = array([0]=>"abc",[1]=>"de",[2]=>"fg")
		// var_dump($arykey);//////////////////////////////////////////////////
		$a = count($arykey);//3
		$b = $arykey[($a - 1)];//b = "fg"
		$result[$b] = NULL;//result = array("fg"=>"おむすび")
		for ($i = $a - 1; $i > 0; $i--) {//repeat 2times
			$repkey = $arykey[($i - 1)];//[1]:repkey = "de" : [0]:repkey = "abc"
			$result[$repkey] = $result;//result = array("de"=>array("fg"=>"おむすび")) : array("abc"=>array("de"=>array("fg"=>"おむすび")))
			unset($result[$arykey[$i]]);
			// var_dump($result);//////////////////////////////////////
		}
		$systemConfigAry = $result;
		file_put_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "systemconfig.dat", serialize($systemConfigAry));
	}



}


?>
