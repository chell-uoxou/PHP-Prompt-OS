<?php
namespace ppm;

class searchCommand extends main{
	public function onCommand(){
		global $aryTipeTxt;
		if (!isset($aryTipeTxt[2])) {
			$this->mySendInfo("Please enter the keywords to the second argument.");
			goto breakout;
		}
		switch (true) {
			case preg_match('!-t=.*!', $aryTipeTxt[2]):
				$search_package_type = preg_replace("!-t=(.*)!","$1",$aryTipeTxt[2]);
				if (isset($aryTipeTxt[3])) {
					$search_word = $aryTipeTxt[3];
				}else{
					$search_word = "";
				}
				break;

			default:
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
			$this->mySendInfo("\x1b[38;5;83mSuccess. \x1b[38;5;214mGetting infomations of packages...");
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
				if (strtolower($repository_name) == strtolower("phppo-plugin-{$search_word}")) {
					$this->mySendInfo("\x1b[38;5;83mPackage was found.");
					$this->mySendInfo("\x1b[38;5;59m===============================");
					$this->mySendInfo("\x1b[38;5;203mpackage name ：\x1b[38;5;83m " . $repository_name);
					$this->mySendInfo("\x1b[38;5;203mauther ：\x1b[38;5;87m " . $owner);
					$this->mySendInfo("\x1b[38;5;203mdescription ：\x1b[38;5;231m " . $description);
					$this->mySendInfo("\x1b[38;5;59m===============================");
				}else{
					$item_number = $result["total_count"];
					$this->mySendInfo("\x1b[38;5;83mPackages that match the keyword were found {$item_number} packages. \x1b[38;5;145m:");
					$this->mySendInfo("---------------------------------");
					foreach ($datas as $key => $value) {
						$repository_name = $value["full_name"];
						$html_url = $value["html_url"];
						$pluginsOnGitHub[] = $value["name"];
						$this->mySendInfo("[\x1b[38;5;87m$repository_name\x1b[38;5;231m]");
						$this->mySendInfo(" \x1b[38;5;59m($html_url)");
						$this->mySendInfo("---------------------------------");
					}
				}
			}else{
				$item_number = $result["total_count"];
				if ($item_number != 0) {
					$this->mySendInfo("\x1b[38;5;83mPackages that match the keyword were found {$item_number} packages.\x1b[38;5;145m :");
					$this->mySendInfo("---------------------------------");
					foreach ($datas as $key => $value) {
						$repository_name = $value["full_name"];
						$html_url = $value["html_url"];
						$pluginsOnGitHub[] = $value["name"];
						$this->mySendInfo("[\x1b[38;5;87m$repository_name\x1b[38;5;231m]");
						$this->mySendInfo(" \x1b[38;5;59m($html_url)");
						$this->mySendInfo("---------------------------------");
					}
				}else{
					$this->mySendInfo("Packages were not found.");
				}
			}
		} else {
			$this->mySendInfo("\x1b[38;5;83mFailed to connect to the GitHub server.","error");
		}
		breakout:
	}
}
