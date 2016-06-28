<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("rmdir","default","パスで指定したディレクトリを削除します。","<パス>");
//////////////////////
class rmdir extends systemProcessing{
	function __construct(){
	}
	public function onCommand(){
		global $aryTipeTxt;
		global $currentdirectory;
		$strCount = count($aryTipeTxt);
		if ($strCount <= 1) {
			$this->sendMessage("パラメーターが不足しています。");
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
							$this->sendMessage("ディレクトリを削除しました。:\x1b[38;5;145m" . $path);
						} catch (Exception $e) {
							$this->sendMessage("ディレクトリの削除に失敗しました。","error");
							$this->sendMessage("指定したディレクトリは空ではない可能性があります。");
						}
					}else {
						$this->sendMessage("指定したファイルはディレクトリではありません。");
					}
				}else{
					$this->sendMessage("指定したファイルまたはディレクトリは存在しません。");
				}
			}
	}
}


?>
