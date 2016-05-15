<?php
//////////////ルール/////////////
//・$aryTipeTxt[1]改行バグ解消方法....$aryTipeTxt[1] = trim($aryTipeTxt[1]);
//・既にある関数と被る名前のユーザー定義関数を作る際は「p_」を頭につける（例:p_mkdir）
////////////////////////////////
$systemconf_ini_array = parse_ini_file("config.ini", true);
$a = fopen("config.ini", "w");
$data = file_get_contents("config.ini");
$data = explode( "\n", $data );
$data[1] = "; PHP Prompt OS system config file" . PHP_EOL;
$data[2] = "; The final reading Date:" . date('l jS \of F Y h:i:s A') . PHP_EOL;
$data = implode($data);
fwrite($a, $data);
fclose($a);
var_dump($data);

include_once "system/System.php";
$system = new systemProcessing;
$display = new display;
$system->sendMessage("Loading command Prosessing files...");
include_once 'command/Command.php';
$system->sendMessage("log mode enabled.");
$logMode = "on";
$exit = new myExit;
// register_shutdown_function("onCommand");
$version = "1.4.5_Beta";
$versiontype = "Beta";//{Release}->{Alpha}->{Beta}->{Dev}
$system->sendMessage("Starting environment variables system...");
$valuepros = new environmentVariables;
$valuepros->setvalue("version",$version);
$boottipe = count($argv);
function exception_handler($exception) {
	global $display;
	global $system;
	global $systemconf_ini_array;
	$display->setInfo("ERROR");
	$system->sendMessage($exception->getMessage());
	$display->setInfo("INFO");
	$system->sendMessage("エラーが発生したためPHP Prompt OSを終了しています..." . PHP_EOL);
	echo "続行するにはエンターキーを押してください。";
	$a = fgets(STDIN);
}

// set_exception_handler('exception_handler');

if ($boottipe <= 2) {
	$system->sendMessage("Starting PHP Prompt OS...");
	$system->sendMessage("booting in Default mode.");
	bootSystem(false);
	readySetup("default");
}else{
	switch ($argv[2]) {
		case 'safemode':
			bootSystem("safemode");
			break;
		default:
			bootSystem("script");
			break;
	}
}

//ここから本体
date_default_timezone_set('Asia/Tokyo');
$startBootTime = microtime(true);

function bootSystem($tipe){
	global $poPath;
	global $systemconf_ini_array;
	$poPath = rtrim(trim(dirname(__FILE__)),"\PHPPO\src");
	$fp = $poPath . "\src\buildlog.log";
	// $buildnumber = substr_count($file, PHP_EOL);
	$data = file_get_contents($fp);
	$data = explode( "\n", $data );
	$buildnumber = count( $data );
	// echo $buildnumber;
	global $version;
	global $system;
	global $display;
	global $argv;
	global $versiontype;
	global $versioncolor;
	$system->sendMessage("here is :\x1b[38;5;145m" . $poPath);
	switch ($versiontype) {
		case 'Release':
			$versioncolor = "\x1b[38;5;83m";
			echo $versioncolor;
			break;
		case 'Alpha':
			$versioncolor = "\x1b[38;5;87m";
			break;
		case 'Beta':
			$versioncolor = "\x1b[38;5;214m";
			break;
		case 'Dev':
			$versioncolor = "\x1b[38;5;203m";
			break;
		default:
			# code...
			break;
	}
	if ($tipe != "script") {
		usleep(rand(0,500000));
		$system->sysCls(100);
		$display->setThread("welcome");
		$display->setInfo("INFO");
		$system->sendMessage("\x1b[38;5;214m╋┓　　　　　　　　　　　　　　　　　　　　　　   　　　┏╋");
		$system->sendMessage("\x1b[38;5;214m┗╋‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━━╋┛");
		$system->sendMessage("");
		$system->sendMessage("\x1b[38;5;227m  :::::::::  :::    ::: :::::::::  :::::::::   ::::::::  ");
		$system->sendMessage("\x1b[38;5;227m  :+:    :+: :+:    :+: :+:    :+: :+:    :+: :+:    :+:  \x1b[38;5;231mPHP Prompt OS");
		$system->sendMessage("\x1b[38;5;227m  +:+    +:+ +:+    +:+ +:+    +:+ +:+    +:+ +:+    +:+     \x1b[38;5;231mmade by chell rui.");
		$system->sendMessage("\x1b[38;5;227m  +#++:++#+  +#++:++#++ +#++:++#+  +#++:++#+  +#+    +:+        \x1b[38;5;231mversion {$versioncolor}{$version}");
		$system->sendMessage("\x1b[38;5;227m  +#+        +#+    +#+ +#+        +#+        +#+    +#+             \x1b[38;5;231mbuild no.\x1b[38;5;83m#{$buildnumber}");
		$system->sendMessage("\x1b[38;5;227m  #+#        #+#    #+# #+#        #+#        #+#    #+#                \x1b[38;5;231mCurrent PHP version: \x1b[38;5;83mPHP" . phpversion());
		$system->sendMessage("\x1b[38;5;227m  ###        ###    ### ###        ###         ########  ");
		$system->sendMessage("");
		$system->sendMessage("\x1b[38;5;214m┏╋‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━━╋┓");
		$system->sendMessage("\x1b[38;5;214m╋┛　　　　　　　　　　　　　　　　　　　　　 　　  　　┗╋\x1b[38;5;231m");
		// $system->sendMessage("	██████╗ ██╗  ██╗██████╗ ██████╗  ██████╗ ");
		// $system->sendMessage("	██╔══██╗██║  ██║██╔══██╗██╔══██╗██╔═══██╗ PHP Prompt OS");
		// $system->sendMessage("	██████╔╝███████║██████╔╝██████╔╝██║   ██║    made by chell rui.");
		// $system->sendMessage("	██╔═══╝ ██╔══██║██╔═══╝ ██╔═══╝ ██║   ██║       version $version");
		// $system->sendMessage("	██║     ██║  ██║██║     ██║     ╚██████╔╝");
		// $system->sendMessage("	╚═╝     ╚═╝  ╚═╝╚═╝     ╚═╝      ╚═════╝");
		// $system->sendMessage("");
		if ($tipe == "logout") {
			$system->sendMessage("初期化処理を行っています..." . PHP_EOL);
		}
		$system->sendMessage("PHP Prompt OS Copyright (C) 2016 chell rui");
		// $system->sendMessage("This program comes with ABSOLUTELY NO WARRANTY; for details type `show w'. ");
		// $system->sendMessage("This is free software, and you are welcome to redistribute it under certain conditions; type `show c' for details.");
		// $mainConfig = parse_ini_file('config.ini');
		// $divmode = $mainConfig["divmode"];s




		// var_dump($divmode);//////////////////////////////
		// echo $divmode;//////////////////////////////////




		date_default_timezone_set('Asia/Tokyo');
		$startBootTime = microtime(true);
	  	//変数の初期化・宣言
		global $divmode;
	  	global $pr_time;
	  	global $pr_info;
	  	global $pr_thread;
	  	global $prompt;
	  	global $user;
	  	global $file_name;
	  	global $Language_setup;
	  	global $LICENSE_agree;
		global $divmode;
		global $tipe_text;
		$script = new script;
	  	date_default_timezone_set('Asia/Tokyo');
	  	$GLOBALS['pr_thread'] = "Boot";//スレッド-プロンプトに表示
	  	$GLOBALS['pr_info'] = "INFO";//情報-プロンプトに表示
	  	$system->sendMessage("\x1b[38;5;227mPHP Prompt OS\x1b[38;5;145m version {$versioncolor}{$version}");
	  	$system->sendMessage("\x1b[38;5;87mCreated by chell rui.");
		$pr_thread = "LOGIN";
		if ($tipe == "logout") {
			$system->sendMessage("初期化処理が完了しました。" . PHP_EOL);
		}
	}else{
		if ($tipe = "script") {
			$tipe_text = "script " . trim($argv[2]);
			$script->onCommand();
		}
}


function readySetup($tipe){
		global $system;
		global $display;
		global $systemconf_ini_array;
		if ($tipe == "logout") {
			$system->sendMessage("終了する場合は\"exit\"を入力:");
			$ask_exit = trim(fgets(STDIN));
			if ($ask_exit == "exit") {
				$exit = new myExit;
				$exit->onCommand();
				exit;
			}
		}
		global $pr_time;
		global $divmode;
		global $pr_info;
		global $pr_thread;
		global $prompt;
		global $user;
		global $file_name;
		global $Language_setup;
		global $LICENSE_agree;
		global $pr_info, $pr_thread;
		global $setup_password;
		global $version;
		$userfilepath = rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . "user.json";
		if (!file_exists($userfilepath)) {
			touch($userfilepath);
			$system->sendMessage("ユーザー設定用ファイルを出力しました。:" . $userfilepath);
		}
		chmod( $userfilepath, 0666 );

		$file_name = 'LICENSE.txt';
		if( !file_exists($file_name) ){
			touch( $file_name );
		}
		chmod( $file_name, 0666 );

		$file_name = rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . "README.txt";
		if( !file_exists($file_name) ){
			touch( $file_name );
		}
		chmod( $file_name, 0666 );

		$logfilepath = rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . "logs";
		if (!file_exists($logfilepath)) {
			mkdir($logfilepath);
			$system->sendMessage("ログ出力用フォルダを生成しました。:[" . $logfilepath .  "]");
		 }

		 $scriptsfilepath = rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . "scripts";
		 if (!file_exists($scriptsfilepath)) {
			 mkdir($scriptsfilepath);
			 $system->sendMessage("スクリプト、ユーザー定義コマンド保存用フォルダを生成しました。:[" . $scriptsfilepath .  "]");
		 }

		$logfilepath = rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . "logs" . "/" . date('Y_m_d') . ".log";
	 	if (!file_exists($logfilepath)) {
	 	touch($logfilepath);
	    $system->sendMessage("ログ出力用ファイルを生成しました。:" . $logfilepath . PHP_EOL);
		}
		chmod( $logfilepath, 0666 );

	 	$system->systemFileOpen(rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . "logs" . "/" . date('Y_m_d') . ".log");
		global $writeData;
		$writeData = fopen(rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . "logs" . "/" . date('Y_m_d') . ".log",'a');
		$pr_info = "INFO";
	 	$pr_thread = "File";
	 	$LICENSE = fopen(rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . 'LICENSE.txt', "w");
		$system->sendMessage("\x1b[38;5;145mライセンスファイルの更新を行っています...");
	 	fwrite($LICENSE, "		┿━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┿
		│　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　│
		│			   PHP Prompt OS			  │
		│　　　　　　　   new style cli console system　　 　　  　　　　│
		│　　　　　        Copyright (C) 2016 chell rui　　  　　　　　　│
		│　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　│
		┿━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━◇◆┿

This program is free software; you can redistribute it andor modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see httpwww.gnu.orglicenses.");
	 	fclose($LICENSE);
		$system->sendMessage("\x1b[38;5;145m更新が終了しました。");
		$LICENSE = fopen(rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . 'README.txt', "w");
		$system->sendMessage("\x1b[38;5;145mREADMEファイルの更新を行っています...");
		fwrite($LICENSE, "	■□━━━━━━━━━━━━━━━━━━━━━━━━━━□■
	□■　　　　　　     　PHP Prompt OS 1　 　　　　 　　　■□
	■□━━━━━━━━━━━━━━━━━━━━━━━━━━□■

	このたびは、PHP Prompt OS をダウンロードしていただき誠にありがとうございます！
	当プロジェクトは、chell ruiによるものです。（contact :@chell_uoxou）
	今もなお、様々な言語で開発が進められております。そして、正式なversion、1.0.0として公開することになりました！

	■■■ＲＥＬＥＡＳＥ　ＮＯＴＥ──────────────────────────────

		version 1.0.0 :
			・システム構成のオブジェクト化
			　┣ コマンド、システムにおいてのそれぞれの処理をクラスに分解し、整理。
			　┣ コマンド処理を\"commands\"ディレクトリ内のそれぞれPHPファイルに格納。
			　┗ 文字を表示する処理における設定を追加。
			　　　　┗displayクラスのsetThread()メソッド、setInfo()メソッド。

			・pharシステムの形成。
			　┗実用化はできていない（windows)。

			・開発向けコマンドの追加。
			　┣vardumpコマンド　:　システム処理が継承した'vardump'クラス内から呼び出せるパブリック変数、
			　┃			及びメイン処理におけるグローバル変数の内容を表示します。
			　┗makepharコマンド　：指定したアプリケーション、ディレクトリパス、または実行しているPHPPOの
						pharアーカイブ作成を行います。※未完成
			・起動方法を改変
			　┣　インストールと同時にphpバイナリーが同梱されたフォルダを展開し、起動時にパソコンに
			　┃インストールされているものではないPHPで動かす。
			　┃	┗それぞれの環境において同じような実行結果が得られるため、error対処がスムーズ。
			　┗起動時にsrcに格納されているベースのプロセスを呼び出し、mintty.exeに結果を出力。");
		fclose($LICENSE);
		$system->sendMessage("\x1b[38;5;145m更新が終了しました。");

	 	//echo PHP_EOL . "Language(en):\n  English -> \"en\"\n  Japanese -> \"ja\"\n";
		$file_name = rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . 'config.ini';
		readScripts();
		if(!file_exists($file_name)){
			touch($file_name);
			$system->sendMessage("システム設定用ファイルを出力しました。:" . $file_name . PHP_EOL);
			chmod( $file_name, 0666 );
			askLicense();
		 	}else{
				if ($divmode == 0) {
					standbyTipe();
				}
				$pr_thread = "LOGIN";
				$system->sendMessage("ユーザー名を入力してください。:");
				$username = trim(fgets(STDIN));
				$user = $username;
				$filename = rtrim(dirname(__FILE__),"\src\PHPPO") . "\\" . "user.json";
				$json = file_get_contents($filename);
				$config = json_decode($json,true);
				if(empty($config[$username])){
					setUserPassword();
					endUserSetup($username,$setup_password);
					loginSystem($username);
				}else{
					loginSystem($username);
			}
		}
		file_get_contents();
	}

	function askLicense(){
		global $system;global $display;
		global $systemconf_ini_array;
		$Language_setup = "ja";
		switch($Language_setup){
			case 'ja':
			// echo "言語を日本語に決定いたしました。\n";
			echo file_get_contents("LICENSE.txt") . "\n";
			echo "ライセンスに同意しますか？(y/n):";
			$LICENSE_agree = trim(fgets(STDIN));
			if($LICENSE_agree == "y"){
				startSetup();
			}else{
				echo "\nライセンスに同意してください\n";
				$system->sendMessage("PHP Prompt OS is stopping now...");
			exit;
			}
			break;
		default:
			echo "";
			break;
		}
	}

	function readScripts(){
		global $system;global $display;
		global $systemconf_ini_array;
		global $aryScriptCommands;
		global $aryScripts;
		global $version;
		$aryScriptFiles = array();
		$aryScripts = array();
		// ディレクトリのパスを記述
		$dir = rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . "scripts" ;

		// ディレクトリの存在を確認し、ハンドルを取得
		$i = 0;
		$handle = opendir(rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . "scripts" . "/");
		while (false !== ($file = readdir($handle))) {
			if(strpos($file,'.') == false){
				array_push($aryScriptFiles,$file);
			}
			//print_r($aryScriptFiles);
		}
		$cnt = count($aryScriptFiles);
		for ($i=0; $i <= $cnt; $i++) {
			// $aryScriptCommands = explode( "\n", $aryScripts );
			// array_push($aryScripts,file_get_contents($aryScriptFiles[$i]));
			// $system->sendMessage($aryScriptFiles[$i] . "のスクリプトを確認しました。");
	}

	}
}

function startSetup(){
	global $system;
	global $display;
	global $user;
	global $file_name;
	global $Language_setup;
	global $LICENSE_agree;
	global $pr_disp;
	global $setup_password;
	global $version;
	global $systemconf_ini_array;
	$display->setInfo("INFO");
	$display->setThread("SETUP");
	$system->sendMessage("====セットアップを開始します====");
	$system->sendMessage("使用するユーザー名を入力してください:");
	$setup_user = trim(fgets(STDIN));
	setUserPassword($setup_user);
	endUserSetup($setup_user,$setup_password);
}

function setUserPassword($setup_user){
	global $system;global $display;
  	global $setup_password;
	global $user;
	global $version;
	global $systemconf_ini_array;
	$user = $setup_user;
	do {
		$setup_password = "";
		$setup_password_req = "";
		do {
			$system->sendMessage('パスワードを設定してください。(八文字以上)');
			$setup_password = trim(fgets(STDIN));
			$system->sysCls(50);
			$flag = true;
			if (8 > strlen($setup_password)) {
				$display->setInfo("ERROR");
				$system->sendMessage("設定したパスワードは八文字に満たしていません！");
			}else {
				$flag = false;
			}
		} while ($flag);
		$display->setInfo("INFO");
		$system->sendMessage("設定したパスワードをもう一度入力してください。:");
		$setup_password_req = trim(fgets(STDIN));
		$system->sysCls(50);
		if ($setup_password_req != $setup_password) {
			$display->setInfo("ERROR");
			$system->sendMessage("二回目に入力したパスワードがはじめと一致していません！");
		}
	} while ($setup_password_req != $setup_password);
}


// function setPromptTime(){
//   global $pr_time;
//   global $pr_info;
//   global $pr_thread;
//   global $prompt;
//   global $user;
//   global $file_name;
//   global $Language_setup;
//   global $LICENSE_agree;
//   $GLOBALS['pr_time'] = date('A-H:i:s',time());
//   $GLOBALS['prompt'] = "[{$pr_time}] [{$pr_thread} Thread/{$pr_info}]";
//  }


$display->setThread("Boot");
$display->setInfo("INFO");
$system->sendMessage("ようこそ" . $user . "さん！PHP Prompt OS version $version");
$system->sendMessage("画面の更新を行います...");
sleep(2);
$system->sysCls(500);
$endBootTime = microtime(true);
$resBootTime = $endBootTime - $startBootTime;
$display->setThread("PHPPO");
$system->sendMessage("起動完了！(" . round($resBootTime, 2) . " s.) helpコマンドでコマンド一覧を表示。");
$display->setThread("PHPPO");
standbyTipe();


function endUserSetup($user, $password){
	global $system;global $display;
	global $systemconf_ini_array;
	$filename = rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . "user.json";
	$json = file_get_contents($filename);
	$config = json_decode($json,true);

	if(empty($config[$user])){
		$config[$user] = sha1($password);
	}else{
		loginSystem($user);
	}
	$json = json_encode($config);
	file_put_contents($filename,$json);
}

function loginSystem($user){
	global $system;global $display;
	global $systemconf_ini_array;
	$filename = rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . "user.json";
	$json = file_get_contents($filename);
	$password_data = json_decode($json,true);
	$system->sendMessage($user . "のパスワードを入力してください。:");
	$askPassword = trim(fgets(STDIN));
	$hash_Password = sha1($askPassword);
	if ($hash_Password != $password_data[$user]) {
		do {
			$display->setInfo("ERROR");
			$system->sendMessage("パスワードが合致しません！");
			$system->sendMessage($user . "のパスワードを入力してください。:");
			$askPassword = trim(fgets(STDIN));
			$hash_Password = sha1($askPassword);
		} while ($hash_Password != $password_data[$user]);
	}
}


function standbyTipe(){
	global $system;global $display;
	global $systemconf_ini_array;
  	global $pr_disp;
  	global $tipe_text;
  	global $stanby;
	global $writeData;
	global $pr_thread;
	global $pr_info;
	global $pr_time;
	global $echoFunc;
	while (True) {
		$stanby = True;
		$display->setThread("PHPPO");
		$pr_time = date('A-H:i:s');
		$pr_time = date('A-H:i:s');
		if ($echoFunc != "off") {
			echo "\x1b[38;5;83m" . "[{$pr_time}]" . "\x1b[38;5;87m" . " [{$pr_thread} Thread/{$pr_info}]" . "\x1b[38;5;227m>";
		}else {
			echo "\x1b[38;5;227m";
		}
		$stanby = false;
		$tipe_text = trim(fgets(fopen("php://stdin", "r")));
		fwrite($writeData,PHP_EOL . $tipe_text);
		runCommand();
	}
}



/////////////////スクリプト処理系/////////////////////

function buildScripts($data){
	global $system;global $display;
	global $systemconf_ini_array;

}
