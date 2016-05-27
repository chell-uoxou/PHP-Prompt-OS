<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("install","secret","PHPPO専用パッケージをインストールします","<src>");
//////////////////////
class install extends systemProcessing{
	function __construct(){
	}
	public function onCommand(){
		global $aryTipeTxt;
		global $poPath;
		$messageCount = count($aryTipeTxt);
		if ($messageCount <= 1) {
			$this->sendMessage("パラメーターが不足しています。");
			}else{
				$aryTipeTxt[1] = trim($aryTipeTxt[1]);
				if ($aryTipeTxt[1] = "src") {
					// try {
					rename($poPath . "\src", $poPath . "\src_old");
						// $oldsrcpath = trim($poPath . "\src");
						// $oldsrcpath_ = trim($oldsrcpath . "_old");
						// $dir_name = "{$poPath}\src_old";
						// if( !file_exists($dir_name) ){
						// 	mkdir( $dir_name );
						// }
						// touch($oldsrcpath_ . ".zip");
						// $this->all_zip($oldsrcpath_ . ".zip", $oldsrcpath_);
						// echo $oldsrcpath . PHP_EOL;
						// echo $oldsrcpath_ . PHP_EOL;
						// $zip = new ZipArchive();
						//
						// $res = $zip->open($oldsrcpath_ . ".zip", ZipArchive::CREATE);
						// if ($res === true) {
						// 	$zip->extractTo($oldsrcpath);
						// 	$zip->close();
						// }

						// rename($oldsrcpath, $oldsrcpath_);
						// $phar = new Phar(dirname(__FILE__) . "/../../../PHPPO.phar");
						// $phar->extractTo(dirname(__FILE__) . "/../../../src", null, true);
						// すべてのファイルを展開し、上書きします
					// } catch (Exception $e) {
						// $this->sendMessage("アップデートを行う際は、表面ディレクトリに新しいバージョンのpharを置き、\"PHPPO.phar\"にリネームしてください。");
					// }
				}
			}
	}
}


?>
