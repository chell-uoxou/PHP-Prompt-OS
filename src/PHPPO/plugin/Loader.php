<?php
namespace phppo\plugin;
// include_once(dirname(__FILE__) . "/../system/System.php");
use phppo\system\systemProcessing as systemProcessing;
$system = new systemProcessing;
$pluginLoadPros = new Loader;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . "\lib\spyc-0.5\spyc.php";

/**
 *
 */
class Loader extends systemProcessing{

	function __construct(){
		# code...
	}

	public function pluginLoad(){
		global $fileplugins;
		global $system;
		global $plugindata;
		global $dirplugins;
		global $commands;
		global $translators;
		global $desabledplugindatas;
		$desabledplugindatas = array();
		$translator = $translators->get('PO.System.Plugin.Package');
		@$fileplugins = scandir(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\plugins');
		$i = 0;
		$j = 0;
		$dirplugins = array();
		$plugindata = array();
		if (isset($fileplugins)) {
			foreach ($fileplugins as $key => $value) {
				// var_dump($fileplugins[$i]);
				if ($fileplugins[$i] != "." && $fileplugins[$i] != ".." ) {
					$dirplugins[$j] = dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\plugins\\' . $fileplugins[$i];
					$j++;
				}
				$i++;
			}

			foreach ($dirplugins as $key => $value) {
				if (is_file($value . "/plugin.yml")) {
					$replugindata[$key] = \Spyc::YAMLLoad($value . "/plugin.yml");
					$replugindata[$key]["sys-bin-path"] = $value;
				}
			}

			if (isset($replugindata)) {
				foreach ($replugindata as $key => $value) {
					$pluginname = $value["name"];
					$plugindata[$pluginname]= $value;
				}
			}
			// var_dump($replugindata);///////////////////////
			// echo "skjdhsdfolakjsdhflaksjdhflaksdjfhlaskdfjhasldkfjhasdlkfjhsadlfkjhasdlkfjhasdlfkjahsdflkasjhdf\n";
			// var_dump($plugindata);//////////////////////////////////////////////
			// var_dump($dirplugins);//////////////////////////////////////////////
			// ここからプラグイン読み込み
			foreach ($plugindata as $key => $value) {
				$plugin_bin_path = $value["sys-bin-path"];
				$plugin_src_path = $plugin_bin_path . "/" . $value["path"];
				$plugin_version = $value["version"];
				$plugin_main = $value["main"];
				$plugin_name = $value["name"];
				if (is_file($plugin_src_path)) {
					$system->info("{$key} V.{$plugin_version} " . $translator->translate('loading'));
					if (!class_exists($plugin_main)) {
						include($plugin_src_path);
						if (!class_exists($plugin_main)) {
							$this->plugin_cantload($key,$translator->translate('classNotFound'));
						}else{
							$plugindata[$plugin_name]["class-object"] = new $plugin_main;
							// var_dump($plugindata[$plugin_name]["class-object"]);///////////////////////////////////////
							$system->generateEvent("onLoad",$plugin_main);
						}
					}else{
						$this->plugin_cantload($key,"クラス定義の重複");
					}
				}else {
					$this->plugin_cantload($key,"定義されたファイルが存在しない");
				}
			}
		}
	}

	public function pluginPathLoad($path=''){
		if (!is_dir($path)) {
			if ($path != "plugin.yml") {
				$this->throwError("File was not found.");
			}
		}else{
			if (is_file($path . "/plugin.yml")) {
				$replugindata[$key] = \Spyc::YAMLLoad($value . "/plugin.yml");
				$replugindata[$key]["sys-bin-path"] = $value;
			}else{
				$this->throwError('"plugin.yml" was not found.');
			}
			if (isset($replugindata)) {
				foreach ($replugindata as $key => $value) {
					$pluginname = $value["name"];
					$plugindata[$pluginname]= $value;
				}
			}
			foreach ($plugindata as $key => $value) {
				$plugin_bin_path = $value["sys-bin-path"];
				$plugin_src_path = $plugin_bin_path . "/" . $value["path"];
				$plugin_version = $value["version"];
				$plugin_main = $value["main"];
				$plugin_name = $value["name"];
				if (is_file($plugin_src_path)) {
					$system->info("{$key} V.{$plugin_version} " . $translator->translate('loading'));
					if (!class_exists($plugin_main)) {
						include($plugin_src_path);
						if (!class_exists($plugin_main)) {
							$this->plugin_cantload($key,$translator->translate('classNotFound'));
						}else{
							$plugindata[$plugin_name]["class-object"] = new $plugin_main;
							// var_dump($plugindata[$plugin_name]["class-object"]);///////////////////////////////////////
							$system->generateEvent("onLoad",$plugin_main);
						}
					}else{
						$this->plugin_cantload($key,"クラス定義の重複");
					}
				}else {
					$this->plugin_cantload($key,"定義されたファイルが存在しない");
				}
			}
		}
	}

	protected function plugin_cantload($name,$reason="原因未定義"){
		global $plugindata;
		global $desabledplugindatas;
		global $plugincommands;
		global $commands;
		global $translators;
		// $desabledplugindata[] = $name;
		// var_dump($desabledplugindatas);
		$translator = $translators->get('PO.System.Plugin.Package');
		$this->info($translator->translate('CantLoad') . " : {$reason}","critical");
		foreach ($plugincommands as $key => $value) {
			if (isset($value["pluginname"])) {
				if ($value["pluginname"] == $name) {
					$delcommand = $key;
					unset($plugincommands[$delcommand]);
					unset($commands[$delcommand]);
				}
			}
		}
		$desabledplugindatas[$name] = $plugindata[$name];
		unset($plugindata[$name]);
		$desabledplugindatas[$name]["status"] = "disable";
	}
}
