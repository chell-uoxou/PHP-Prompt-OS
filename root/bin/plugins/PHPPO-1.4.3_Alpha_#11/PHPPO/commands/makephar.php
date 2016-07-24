<?php
/**
 *
 */
 //////////////////////
 include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("makephar","dev","指定したアプリケーション、ディレクトリパス、または実行しているPHPPOのpharアーカイブ作成を行います。","<アプリケーション名|ディレクトリパス|system>");
 //////////////////////
class makephar extends systemProcessing{
	function __construct(){
		# code...
	}
	public function onCommand(){
		global $aryTipeTxt;
		global $version;
		global $buildnumber;
		$myPhar = new myPhar;
		$messageCount = count($aryTipeTxt);
		if ($messageCount <= 1) {
			$this->sendMessage("パラメーターが不足しています。");
			}else{
				$aryTipeTxt[1] = trim($aryTipeTxt[1]);
				if ($aryTipeTxt[1] == "system") {
					$this->sendMessage("\x1b[38;5;203mAre you sure you want to compose the source of PHPPO that are currently running to the phar archive ?(y):");
					$Confirm = trim(fgets(STDIN));
					if ($Confirm == "y") {
						// $myPhar->compose(rtrim(dirname(__FILE__),"commands\\"),"PHPPO");
						$fp = rtrim(trim(dirname(__FILE__)),"\commands\PHPPO") . "c\buildlog.log";
						if (!file_exists($fp)) {
							touch($fp);
							$this->sendMessage("\x1b[38;5;83mBuild log file created.\x1b[38;5;145m:" . $fp);
							$buildnumber = "1";
						}else {
							// $buildnumber = substr_count($file, PHP_EOL);
							$data = file_get_contents($fp);
							$data = explode( "\n", $data );
							$buildnumber = count( $data );
							echo $buildnumber;
						}
						$fp = fopen($fp, "a");
						fwrite($fp, "[" . date("\'y.m.d h:i:s") . "] PHP Prompt OS " . $version . " built. No. #" . $buildnumber . PHP_EOL);
						fclose($fp);
						$this->sendMessage("\x1b[38;5;231m" .  "[" . date("\'y.m.d h:i:s") . "] PHP Prompt OS " . $version . " built. No. #" . $buildnumber);
						$pharpath = rtrim(dirname(__FILE__),"commands\src\PHPPO") . "\PHPPO-{$version}_#{$buildnumber}.phar";
						$phar = new Phar($pharpath, 0, 'PHPPO.phar');
						$phar->buildFromDirectory(rtrim(dirname(__FILE__),"commands\src\PHPPO") . "\src");
						$this->sendMessage("\x1b[38;5;83mSuccess. \x1b[38;5;145m:" . $pharpath);
					}
					} else {
					// $dir = '';
					// $dirCount = "";
					// for ($i=1; $i < $dirCount; $i++) {
					// 	$dir .= $aryTipeTxt[$i] . " ";
					// }
					// $myPhar->compose($dir,"");
				}
			}
	}
}
