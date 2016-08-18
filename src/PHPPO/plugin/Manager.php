<?php

namespace phppo\plugin;
use phppo\system\systemProcessing as systemProcessing;
include_once 'Loader.php';
/**
 * プラグイン処理
 */
class Manager extends systemProcessing{

	function __construct(){
	}

	public function install($type = ''){
		global $poPath;
		@$fileplugins = scandir($poPath . '/root/plugins');
		$i = 0;
		$j = 0;
		if (isset($fileplugins)) {
			foreach ($fileplugins as $key => $value) {
				// var_dump($fileplugins[$i]);
				if ($fileplugins[$i] == "." || $fileplugins[$i] == ".." ) {
				}else {
					if (is_file($poPath . "/root/bin/installedplugin.ini")) {
						$installedplugin = parse_ini_file($poPath . "/root/bin/installedplugin.ini");
						if (!in_array($poPath . '/root/plugins/' . $fileplugins[$i],$installedplugin)) {
							$dirplugins[$j] = $poPath . '/root/plugins/' . $fileplugins[$i];
							$j++;
						}
					}else{
						$dirplugins[$j] = $poPath . '/root/plugins/' . $fileplugins[$i];
						$j++;
					}
				}
				$i++;
			}
		}

		if (isset($dirplugins)) {
			$this->info("未インストールのプラグインを確認しました。");
			$i = 2;
			foreach ($dirplugins as $key => $value) {
				$this->info("確認をしています...");
				$mappername = "plugin-mapper-" . $key . ".phar";
				unset($phar);
				try {
					$phar = new \Phar($value);
					$phar->setAlias($mappername);
					\Phar::loadPhar($value,$mappername);
					$pluginYamlPath = "phar://{$mappername}/plugin.yml";
					if (!file_exists($pluginYamlPath)) {
						$this->throwError("PHP Prompt OS専用のプラグインパッケージとして認識できませんでした。");
					}else {
						$plugindata = \Spyc::YAMLLoad($pluginYamlPath);
						$plugin_version = $plugindata["version"];
						$plugin_name = $plugindata["name"];
						$a = $this->input("インストールを行いますか？(Y/n):");
						if ($a == "y"||$a == "Y") {
							try {
								$topath = dirname($poPath . '\root\bin\plugins\\' . $fileplugins[$i]);
								$phar->extractTo($topath, null, true);
								$i++;
								$this->info("インストールが完了しました。再起動します。");
								if (!is_file($poPath . "/root/bin/installedplugin.ini")) {
									touch($poPath . "/root/bin/installedplugin.ini");
								}
								$txt = "{$plugin_name} = {$value}" . PHP_EOL;
								file_put_contents($poPath . "/root/bin/installedplugin.ini",$txt,FILE_APPEND);
								$reboot = new \phppo\command\defaults\reboot_command;
								$reboot->onCommand();
								// $phar = new Phar();
							} catch (Exception $e) {
								$this->throwError("アーカイブの解凍に失敗しました:\n{$e}");
							}
						}
					}
				} catch (PharException $e) {
					$this->throwError($e,"critical");
				}
			}
		}
	}
}
