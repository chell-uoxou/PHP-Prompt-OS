<?php
namespace ppm;

use phppo\plugin\Loader;
class installCommand extends main{
	public function onCommand(){
		global $aryTipeTxt;
		if (!isset($aryTipeTxt[2])) {
			$this->mySendInfo("Please enter the name of the package to the second argument.");
			goto breakout;
		}
		switch (true) {
			case preg_match('/-t=.*/', $aryTipeTxt[2]):
				$search_package_type = preg_replace("/-t=(.*)/","$1",$aryTipeTxt[2]);
				if (isset($aryTipeTxt[3])) {
					$search_word = $aryTipeTxt[3];
				}else{
					$search_word = "";
				}
				break;
			case $aryTipeTxt[2] == "-?" || $aryTipeTxt[2] == "-h":
				$this->showInstallHelp();
				goto breakout;
				break;
			default:
				if (preg_match('/-.*/', $aryTipeTxt[2])) {
					$this->throwerror("Option not found :" . $aryTipeTxt[2]);
					goto breakout;
				}
				$search_package_type = "";
				$search_word = $aryTipeTxt[2];
				break;
		}
		$this->mySendInfo("\x1b[38;5;214mConnecting...");
		$baseurl = 'https://api.github.com/';
		$search_keys = 'search/repositories?q=phppo-' . $search_package_type . "-" . $search_word;
		$search_full_url = $baseurl . $search_keys .'&sort=stars&order=desc';
		$url = 'https://api.github.com/';
		$context = stream_context_create(array('http' => array(
			'method' => 'GET',
			'header' => 'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
		)));
		$response = @file_get_contents($url, false, $context, 0, 1);
		if ($response !== false) {
			$this->mySendInfo("\x1b[38;5;83mSuccess. \x1b[38;5;214mGetting infomations of package...");
			$response = file_get_contents($search_full_url,false,$context);
			$result = json_decode($response, true);
			$datas = $result["items"];
			if ($result["total_count"] == 1) {
				foreach ($datas as $key => $value) {
					$repository_full_name = $value["full_name"];
					$repository_name = $value["name"];
					$html_url = $value["html_url"];
					$pluginsOnGitHub[] = $value["name"];
					$owner = $value["owner"]["login"];
					$description = $value["description"];
					$zip_url = $html_url . "/archive/master.zip";
				}
				if (strtolower($repository_name) == strtolower("phppo-plugin-{$search_word}") ||
					strtolower($repository_name) == strtolower("phppo-{$search_package_type}-{$search_word}") ||
					strtolower($repository_name) == strtolower("phppo-app-{$search_word}")) {
					$this->mySendInfo("\x1b[38;5;83mPackage was found.");
					$this->mySendInfo("\x1b[38;5;214mGetting the size of the remote file...");
					$size = $this->remote_filesize($zip_url);
					$mb = round($size / 1024, 2);
					if (substr($mb, -1) == 0) {
						$display_size = $size . "byte";
					}else{
						$display_size = $mb . "MB";
					}
					$this->mySendInfo("\x1b[38;5;59m===============================");
					$this->mySendInfo("\x1b[38;5;203mpackage name ：\x1b[38;5;83m " . $repository_name);
					$this->mySendInfo("\x1b[38;5;203mauther ：\x1b[38;5;87m " . $owner);
					$this->mySendInfo("\x1b[38;5;203mdescription ：\x1b[38;5;231m " . $description);
					$this->mySendInfo("\x1b[38;5;59m===============================");
					$this->mySendInfo("The size of the download archive is {$display_size}.");
					$answer = trim($this->input("Are you sure to start install?(Y):"));
					if (strtolower($answer) == "y") {
						$this->startInstall($value,$display_size);
					}else{
						$this->mySendInfo("Canceled.");
					}
				}else{
					$this->mySendInfo("The package was not found.");
					$item_number = $result["total_count"];
					$this->mySendInfo("\x1b[38;5;83mPackages that match the keyword were found {$item_number} packages. \x1b[38;5;145m:");
					foreach ($datas as $key => $value) {
						$repository_name = $value["full_name"];
						$html_url = $value["html_url"];
						$pluginsOnGitHub[] = $value["name"];
						$this->mySendInfo("[\x1b[38;5;87m$repository_name\x1b[38;5;231m] \x1b[38;5;59m($html_url)");
					}
				}
			}else{
				$item_number = $result["total_count"];
				$this->mySendInfo("The package was not found.");
				if ($item_number != 0) {
					$this->mySendInfo("\x1b[38;5;83mPackages that match the keyword were found {$item_number} packages. \x1b[38;5;145m:");
					foreach ($datas as $key => $value) {
						$repository_name = $value["full_name"];
						$html_url = $value["html_url"];
						$pluginsOnGitHub[] = $value["name"];
						$this->mySendInfo("[\x1b[38;5;87m$repository_name\x1b[38;5;231m] \x1b[38;5;59m($html_url)");
					}
				}
			}
		} else {
			$this->mySendInfo("\x1b[38;5;83mFailed to connect to the GitHub server.","error");
		}
		breakout:
	}

	public function startInstall($data,$display_size){
		$this->mySendInfo("\x1b[38;5;214mConnecting...");
		$url = 'https://api.github.com/';
		$context = stream_context_create(array('http' => array(
			'method' => 'GET',
			'header' => 'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
		)));
		$response = @file_get_contents($url, false, $context, 0, 1);
		if ($response !== false) {
			$html_url = $data["html_url"];
			$zip_url = $html_url . "/archive/master.zip";
			$name = $data["name"];
			$full_name = $data["full_name"];
			$plugin_name = substr($name,13);
			$app_name = substr($name,10);
			$full_name_forpath = str_replace('/','-',$full_name);
			$toPath = $GLOBALS['poPath'] . "/root/bin/ppm/cache/{$full_name_forpath}";
			if (!is_dir($toPath)) {
				mkdir($toPath);
			}
			$this->mySendInfo("\x1b[38;5;83mSuccess. \x1b[38;5;214mTo start the download of the package archive ({$display_size})...");
			$onerror = $this->file_download($zip_url,$toPath);
			if ($onerror != false) {
				$this->mySendInfo("\x1b[38;5;83mIt succeeded to the acquisition of the archive.");
				$this->mySendInfo("\x1b[38;5;214mUnpacking the archive...");
				$preparePath = $GLOBALS['poPath'] . "/root/bin/ppm/tmp/{$full_name_forpath}";
				$this->unZip($onerror,$preparePath);
				$this->mySendInfo("\x1b[38;5;214mExtracting the package datas...");
				$files = scandir($preparePath,1);
				$from_copy = $preparePath . "/" . $files[0];
				$to_copy = $GLOBALS['poPath'] . "/root/bin/plugins/" . $name;
				if (!is_dir($to_copy)) {
					mkdir($to_copy);
				}
				$this->mySendInfo("\x1b[38;5;214mCopying datas to the system folder...");
				$this->inst_dir_cop($from_copy,$to_copy);
				$this->mySendInfo("\x1b[38;5;214mCreaning temporary datas...");
				$this->remove_directory($preparePath);
				unlink($onerror);
				$this->mySendInfo("\x1b[38;5;83mThe installation is complete. ");
				$this->mySendInfo("\x1b[38;5;214mReloading packages...");

				$loader = new Loader;
				$loader->pluginPathLoad($to_copy);
			}else{
				$this->mySendInfo("\x1b[38;5;83mFailed to get the archive.");
			}
		}
	}

	function showInstallHelp(){
		$this->mySendInfo("[install] Start install a package");
		$this->mySendInfo("\x1b[38;5;34mppm install [t=< package type >] <package name>");
	}
}
