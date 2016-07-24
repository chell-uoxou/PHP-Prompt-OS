<?php

namespace phppo\plugin;



include_once dirname(__FILE__) . '/../display/display.php';
include_once(dirname(__FILE__) . "/../system/System.php");
use phppo\system\systemProcessing as systemProcessing;
include_once 'Loader.php';
/**
 * プラグイン処理
 */
class Manager extends systemProcessing{

	function __construct(){
	}

	public function install($type = ''){
		@$fileplugins = scandir(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\plugins');
		$i = 0;
		$j = 0;
		if (isset($fileplugins)) {
			foreach ($fileplugins as $key => $value) {
				// var_dump($fileplugins[$i]);
				if ($fileplugins[$i] == "." || $fileplugins[$i] == ".." ) {
				}else {
					$dirplugins[$j] = dirname(dirname(dirname(dirname(__FILE__)))) . '\root\plugins\\' . $fileplugins[$i];
					$j++;
				}
				$i++;
			}
		}
		if (isset($dirplugins)) {
			$a = $this->sendMessage("未インストールのプラグインを確認しました。インストールしますか？(Y/n):","input");
			if ($a == "y"||$a == "Y") {
				$i = 2;
				foreach ($dirplugins as $key => $value) {
					$this->sendMessage("確認をしています...");
					$mappername = "plugin-mapper-" . $key . ".phar";
					try {
						$phar = new Phar($value);
						$phar->setAlias($mappername);
						Phar::loadPhar($value,$mappername);
						$pluginYamlPath = "phar://{$mappername}/plugin.yml";
						if (!file_exists($pluginYamlPath)) {
							$this->sendMessage("PHP Prompt OS専用のプラグインパッケージとして認識できませんでした。","error");
						}else {
							// echo file_get_contents($pluginYamlPath);
						}
					} catch (PharException $e) {
						echo $e;
					}

					try {
						$topath =  rtrim(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\plugins\\' . $fileplugins[$i],".phar");
						$phar->extractTo($topath, null, true);
						$i++;
						$this->sendMessage("解凍が完了しました。");
						// $phar = new Phar();
					} catch (Exception $e) {
						$this->sendMessage("アーカイブの解凍に失敗しました:\n{$e}","error");
					}
				}
			}
		}
	}
}
