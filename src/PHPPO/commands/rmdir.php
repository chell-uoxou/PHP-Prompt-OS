<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("rmdir","default","パスで指定したディレクトリを削除します。","<パス>");
//////////////////////
class rmdir_command extends systemProcessing{
	function __construct(){
	}
	public function onCommand(){
		global $aryTipeTxt;
		global $currentdirectory;
		$strCount = count($aryTipeTxt);
		if ($strCount <= 1) {
			$this->info("パラメーターが不足しています。");
			return false;
			}else{
				$path = '';
				for ($i=1; $i < $strCount; $i++) {
					$path .= $aryTipeTxt[$i] . " ";
				}
				$path = trim($currentdirectory . '\\' . $path);
				if (file_exists($path)) {
					if (is_dir($path)) {
						try {
							rmdir($path);
							$this->info("ディレクトリを削除しました。:\x1b[38;5;145m" . $path);
						} catch (Exception $e) {
							$this->throwError("ディレクトリの削除に失敗しました。");
							$this->info("指定したディレクトリは空ではない可能性があります。");
							return false;
						}
					}else {
						$this->throwError("指定したファイルはディレクトリではありません。");
						return false;
					}
				}else{
					$this->throwError("指定したファイルまたはディレクトリは存在しません。");
					return false;
				}
			}
	}
}


?>
