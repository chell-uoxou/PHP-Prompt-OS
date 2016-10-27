<?php
namespace ppm;
use phppo\system\systemProcessing;
use phppo\command\plugincommand\addcommand as addcommand;
include_once 'AA.php';
include_once 'help.php';
include_once 'install.php';
include_once 'search.php';
include_once 'setuper.php';
$pluginAddCommand = new addcommand;
$pluginAddCommand -> addcommand("PHPPOPackageManager","ppm","plugin","PHPPOPackageManager commands.","");
/**
 *
 */
class main extends systemProcessing{
	protected $help;
	protected $ppmversion = "0.1.0";

	function __construct(){
	}

	public function onload(){
		$this->addlog("PHPPO Package Manager was loaded.");
		$this->addlog("made by chell-uoxou");
		$this->setup = new setuper;
		// var_dump($this->help);
		$this->setup->startSetup();
	}

	public function onCommand(){
		$this->help = new helpCommand;
		$this->install = new installCommand;
		$this->search = new searchCommand;
		$types = $GLOBALS['aryTipeTxt'];
		if (!isset($types[1])) {
			$types[1] = "";
		}
		switch ($types[1]) {
			case 'help':
				$this->help->onCommand();
				break;
			case 'about':
				$this->help->about();
				break;
			case 'install':
				$this->install->onCommand();
				break;
			case 'search':
				$this->search->onCommand();
				break;
			default:
				$this->help->display();
				break;
		}
	}

	public function mySendInfo($texts,$args = NULL){
		if (isset($args)) {
			$this->info("\x1b[38;5;227m[PPM]\x1b[38;5;231m" . $texts,$args);
		}else{
			$this->info("\x1b[38;5;227m[PPM]\x1b[38;5;231m" . $texts);
		}
	}

	public function url_exists($url) {
		// Version 4.x supported
		$handle   = curl_init($url);
		if (false === $handle)
		{
			return false;
		}
		curl_setopt($handle, CURLOPT_HEADER, false);
		curl_setopt($handle, CURLOPT_FAILONERROR, true);  // this works
		curl_setopt($handle, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") ); // request as if Firefox
		curl_setopt($handle, CURLOPT_NOBODY, true);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
		$connectable = curl_exec($handle);
		curl_close($handle);
		return $connectable;
	}

	public function remote_filesize($url) {
		static $regex = '/^Content-Length: *+\K\d++$/im';
		if (!$fp = @fopen($url, 'rb')) {
			return false;
		}
		if (
		isset($http_response_header) &&
		preg_match($regex, implode("\n", $http_response_header), $matches)
		) {
			return (int)$matches[0];
		}
		return strlen(stream_get_contents($fp));
	}

	public function remove_directory($dir) {
		if ($handle = opendir("$dir")) {
			while (false !== ($item = readdir($handle))) {
				if ($item != "." && $item != "..") {
					if (is_dir("$dir/$item")) {
						$this->remove_directory("$dir/$item");
					} else {
						unlink("$dir/$item");
					}
				}
			}
			closedir($handle);
			@rmdir($dir);
		}
	}

	public function inst_dir_cop($dir_name, $new_dir){
		if (!is_dir($new_dir)) {
			mkdir($new_dir);
		}
		if (is_dir($dir_name)) {
			if ($dh = opendir($dir_name)) {
				while (($file = readdir($dh)) !== false) {
					if ($file == "." || $file == "..") {
						continue;
					}
					if (is_dir($dir_name . "/" . $file)) {
						$this->inst_dir_cop($dir_name . "/" . $file, $new_dir . "/" . $file);
					}
					else {
						copy($dir_name . "/" . $file, $new_dir . "/" . $file);
					}
				}
				closedir($dh);
			}
		}
		return true;
	}

	public function unZip($zip_path,$toPath){
		$zip = new \ZipArchive();
		$res = $zip->open($zip_path);
		if ($res === true) {
			$zip->extractTo($toPath);
			$zip->close();
		}
	}
}
