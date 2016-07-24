<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
 include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("makephar","dev","指定したパス、または実行しているPHPPOのpharアーカイブ作成を行います。","<絶対パス|system>");
 //////////////////////
class makephar_command extends systemProcessing{
	function __construct(){
		# code...
	}
	public function onCommand(){
		global $aryTipeTxt;
		global $version;
		global $buildnumber;
		global $raw_input;
		global $currentdirectory;
		$myPhar = new myPhar;
		$messageCount = count($aryTipeTxt);
		if ($messageCount <= 1) {
			$this->sendMessage("パラメーターが不足しています。");
			return false;
			}else{
				$aryTipeTxt[1] = trim($aryTipeTxt[1]);
				if ($aryTipeTxt[1] == "system") {
					$Confirm = $this->sendMessage("\x1b[38;5;203mAre you sure you want to compose the source of PHPPO that are currently running to the phar archive ?(y):","input");
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
							// echo $buildnumber;
						}
						$fp = fopen($fp, "a");
						fwrite($fp, "[" . date("\'y.m.d h:i:s") . "] PHP Prompt OS " . $version . " built. No. #" . $buildnumber . PHP_EOL);
						fclose($fp);
						$this->sendMessage("\x1b[38;5;231m" .  "[" . date("\'y.m.d h:i:s") . "] PHP Prompt OS " . $version . " built. No. #" . $buildnumber);
						$this->sendMessage("\x1b[38;5;227mCreateing...");
						$pharpath = rtrim(dirname(__FILE__),"commands\src\PHPPO") . "\PHPPO-{$version}_#{$buildnumber}.phar";
						$phar = new Phar($pharpath, 0, 'PHPPO.phar');
						$phar->buildFromDirectory(rtrim(dirname(__FILE__),"commands\src\PHPPO") . "\src");
						$pharstat = stat($pharpath);
						$this->sendMessage("\x1b[38;5;83mSuccess. \x1b[38;5;145m:" . $pharpath);
						$this->sendMessage("File size:" . $pharstat["size"] . "byte");
					}
					} else {
						$allpath = substr($raw_input,9);
						$allpath = rtrim($allpath,"\"");
						$allpath = ltrim($allpath,"\"");
						if (file_exists($allpath)) {
							$Confirm = $this->sendMessage("\x1b[38;5;203m指定されたパス\x1b[38;5;145m({$allpath})\x1b[38;5;203mからのPharアーカイブの作成を行いますか？(y):","input");
							if ($Confirm == "y"|| $Confirm == "Y") {
								// $this->sendMessage("");
								if (is_dir($allpath)) {
									$filename = basename($allpath);
									$this->sendMessage("\x1b[38;5;227mCreateing...");
									$pharpath = $currentdirectory . "\\{$filename}.phar";
									$phar = new Phar($pharpath, 0, "{$filename}.phar");
									$phar->buildFromDirectory($allpath);
									$pharstat = stat($pharpath);
									$this->sendMessage("\x1b[38;5;83mSuccess. \x1b[38;5;145m:" . $pharpath);
									$this->sendMessage("File size:" . $pharstat["size"] . "byte");
								}else {
									$this->sendMessage("指定したパスはディレクトリではありません。","error");
									return false;
								}
							}
						}else{
							$this->sendMessage("指定されたパスにディレクトリやファイルは存在しません。","error");
							return false;
						}
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
