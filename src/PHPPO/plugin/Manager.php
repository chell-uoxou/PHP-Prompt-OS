<?php
include_once dirname(__FILE__) . '/../display/display.php';
include_once(dirname(__FILE__) . "/../system/System.php");
include_once 'Loader.php';
/**
 * プラグイン処理
 */
class pluginManager extends systemProcessing{

	function __construct(){
	}

	public function install($type = ''){
		global $dirplugins;
		global $fileplugins;
		if (isset($dirplugins)) {
			$a = $this->sendMessage("未インストールのプラグインを確認しました。インストールしますか？(Y/n):","input");
			if ($a == "y"||$a == "Y") {
				$this->sendMessage("確認をしています...");
				$i = 2;
				foreach ($dirplugins as $key => $value) {
					try {
						$topath =  rtrim(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\plugins\\' . $fileplugins[$i],".phar");
						$phar = new Phar($value);
						$phar->extractTo($topath, null, true);
						$i++;
						$this->sendMessage("解凍が完了しました。");
						// $phar = new Phar();
					} catch (Exception $e) {
						$this->sendMessage("アーカイブの解凍に失敗しました:\n{$e}","error");
					}
				}
			}
			// var_dump($a);
		}
	}
}
