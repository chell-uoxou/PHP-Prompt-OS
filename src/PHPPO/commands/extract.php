<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("extract","secret","指定したpharファイルをソースディレクトリに展開します。","<system>");
//////////////////////
class extract extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $aryTipeTxt;
		switch ($aryTipeTxt[1]) {
			case 'system':
				$this->sendMessage("現在実行しているpharアーカイブを展開しますか？");
				$Confirm = trim(fgets(STDIN));
				try {
					$this->sendMessage("\x1b[38;5;231m解凍しています...");
				    $phar = new Phar('PHPPO.phar');
				    $phar->extractTo('src_new', null, true); // すべてのファイルを展開し、上書きします
					$this->sendMessage("\x1b[38;5;83m完了しました。\x1b[38;5;145m:" . dirname(__FILE__) . "src");
				} catch (Exception $e) {

				}
				$this->sendMessage();
				break;

			default:
				$this->sendMessage("記法が誤っています。");
				break;
		}
	}
}


?>
