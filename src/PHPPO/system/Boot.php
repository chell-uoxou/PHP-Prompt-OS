<?php
namespace phppo;

use phppo\system\systemProcessing as systemProcessing;
use phppo\system\environmentVariables as environmentVariables;
use phppo\plugin\Manager as pluginManager;
$systemconf_ini_array = parse_ini_file($poPath . "/config.ini", true);
//異常終了check
$echoFunc = "on";
$valuepros = new environmentVariables;
if ($systemconf_ini_array["dev"]["devmode"] != 1) {
	@$files = scandir($poPath . "/root/home/logs/",1);
	// var_dump($files);
	if ($files != false) {
		$lines = file($poPath . "/root/home/logs/" . $files[0], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$line = end($lines);
		if ($line != "PHPPO was completed successfully."){
			$system->info("システムが異常終了していた可能性があります！！","critical");
			$system->info("前回のセッションの復元を試みますか？(Y/n):");
			$revses = trim(fgets(fopen("php://stdin", "r")));
			if($revses == "Y"||$revses == "y"){
				$system->info("前回起動時のセッションダンプを検索しています...");
				$path = dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "systemdefinedvars.dat";
				$system->info("ダンプファイルを読み込んでいます...");
				$defined_vars = unserialize(file_get_contents($path));
				$system->info("システム変数の復元を行っています...(この作業には時間がかかる可能性があります。)");
				$a = 0;
				$b = count($defined_vars);
				echo "進行度:";
				foreach ($defined_vars as $key => $value) {
					$a++;
					$$key = $value;
					if (($a / $b * 100) % 1 == 0) {
						echo "\x1b[38;5;83m■";
					}
				}
				echo PHP_EOL;
				$system->info("システムの復旧を行いました。起動します。\n次回終了時はexitコマンドで終了してください。");
				sleep(2);
			}else{
				$system->info("起動します。\n次回終了時はexitコマンドで終了してください。");
			}
		}
	}
}

$valuepros = new environmentVariables;
$system->info("Loading command Prosessing files...");
if ($systemconf_ini_array["system"]["logmode"] == 1) {
	$logmode = "on";
	$system->info("log mode \x1b[38;5;87menabled.");
}else {
	$logmode = "off";
}

if ($systemconf_ini_array["dev"]["currentdirectory"] == 1) {
	$currentdirectorymode = "on";
	$system->info("Current directory mode:\x1b[38;5;87menabled.");
	$system->info("There are a lot of bugs in the current directory mode!","warn");
}else {
	$currentdirectorymode = "off";
}

if ($systemconf_ini_array["system"]["saveenvironmentvalues"] == 1) {
	$savevaluesmode = "on";
	$valuepros->setvalue("prompt","\x1b[38;5;83m[%time] \x1b[38;5;87m[%thread/%info]\x1b[38;5;207m%cd\x1b[38;5;227m");
	$system->info("Save Environment Values Mode:\x1b[38;5;87menabled.");
}else {
	$savevaluesmode = "off";
}

$inPrompt = $systemconf_ini_array["display"]["in_prompt"];
// <<<<<<< HEAD


////////////////////////////////////Version////////////////////////////////////////

$version = "1.6.10_Beta";
$versiontype = "Beta";//{Release}->{Alpha}->{Beta}->{Dev}

////////////////////////////////////////////////////////////////////////////////////


// >>>>>>> master
$system->info("Starting environment variables system...");
$valuepros = new environmentVariables;
$valuepros->setvalue("version",$version);

$title = "PHP Prompt OS $version";
$pid = getmypid(); // これを使えば、プロセスのタイトルを ps で確認できます

if (!cli_set_process_title($title)) {
    $system->info("Unable to set process title for PID $pid...");
    exit(1);
} else {
    $system->info("The process title '$title' for PID $pid has been set for your process!");
}




$boottipe = count($argv);
function exception_handler($exception) {
	global $display;
	global $system;
	global $systemconf_ini_array;
	$system->throwError($exception->getMessage());
	$system->info("システム内部に致命的なエラーが発生したためPHP Prompt OSを終了します..." . PHP_EOL,"critical");
	echo "\x1b[38;5;231m続行するにはエンターキーを押してください。";
	$a = fgets(STDIN);
}

// var_dump($systemconf_ini_array);////////////////////////////////////////////////////

if ($systemconf_ini_array["dev"]["devmode"] == 1) {
	$system->info("exception handler:\x1b[38;5;203mdisable");
}else {
	set_exception_handler('exception_handler');
	$system->info("Error handler:\x1b[38;5;87menable");
	set_error_handler("myErrorHandler");
	$system->info("Error handler:\x1b[38;5;87menable");
}


if (true) {
	$system->info("Starting PHP Prompt OS...");
	$system->info("booting in Default mode.");
	bootSystem(false);
	$system->standbyTipe();
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
function myErrorHandler($errno, $errstr, $errfile, $errline){
	global $system;
	if (!(error_reporting() & $errno)) {
		// error_reporting 設定に含まれていないエラーコードです
		return;
	}

	switch ($errno) {
		case E_USER_ERROR:
			$system->info("My ERROR [$errno] $errstr");
			$system->info("  Fatal error on line $errline in file $errfile");
			$system->info(", PHP " . PHP_VERSION . " (" . PHP_OS . ")");
			$system->info("Aborting...");
			exit(1);
			break;

		case E_USER_WARNING:
			$system->info("[$errno] $errstr","warn","PHP");
			break;

		case E_USER_NOTICE:
			$system->info("[$errno] $errstr","notice","PHP");
			break;

		default:
			$system->info("Unknown error type: [$errno] $errstr");
			break;
	}

	/* PHP の内部エラーハンドラを実行しません */
	return true;
}
function bootSystem($tipe){
	global $currentdirectory;
	global $currentdirectorymode;
	global $defaultcurrentdirectory;
	global $poPath;
	global $systemconf_ini_array;
	global $system;
	global $valuepros;
	// $url = "https://github.com/chell-uoxou/PHP-Prompt-OS/releases.atom";
	// $ch = curl_init();
	// curl_setopt ($ch, CURLOPT_URL, $url);
	// curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	// curl_setopt($ch, CURLOPT_HEADER, false);
	// $xml = curl_exec($ch);
	// print_r($xml);
	if ($currentdirectorymode == "on") {
		$currentdirectory = $poPath . "\\root";
		$defaultcurrentdirectory = $currentdirectory;
		$system->info("Set current directory:{$currentdirectory}\n");
		$valuepros->setvalue("currentdirectory",$currentdirectory);
	}
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
	global $pluginLoadPros;
	$system->info("here is :\x1b[38;5;145m" . $poPath);
	$pluginLoadPros->pluginLoad();
	switch ($versiontype) {
		case 'Release':
			$versioncolor = "\x1b[38;5;83m";
			// echo $versioncolor;
			break;
		case 'Alpha':
			$versioncolor = "\x1b[38;5;87m";
			break;
		case 'Beta':
			$versioncolor = "\x1b[38;5;214m";
			break;
		case 'Dev':
			$versioncolor = "\x1b[38;5;203m";
			$system->info("\x1b[38;5;214mOops You are running the \"\x1b[38;5;203mdevelopment build \x1b[38;5;214m\"! There may be a bug !");
			break;
		default:
			# code...
			break;
	}

	if ($tipe != "script") {
		// usleep(rand(0,500000));//演出
		$system->sysCls(100);
		$display->setThread("welcome");
		$display->setInfo("INFO");
		$system->info("		\x1b[38;5;214m╋┓　　　　　　　　　　　　　　　　　　　　　　   　　　┏╋");
		$system->info("		\x1b[38;5;214m┗╋‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━━╋┛");
		$system->info("");
		$system->info("		\x1b[38;5;227m  :::::::::  :::    ::: :::::::::  :::::::::   ::::::::  ");
		$system->info("		\x1b[38;5;227m  :+:    :+: :+:    :+: :+:    :+: :+:    :+: :+:    :+:  \x1b[38;5;231mPHP Prompt OS");
		$system->info("		\x1b[38;5;227m  +:+    +:+ +:+    +:+ +:+    +:+ +:+    +:+ +:+    +:+     \x1b[38;5;231mmade by chell rui.");
		$system->info("		\x1b[38;5;227m  +#++:++#+  +#++:++#++ +#++:++#+  +#++:++#+  +#+    +:+        \x1b[38;5;231mversion {$versioncolor}{$version}");
		$system->info("		\x1b[38;5;227m  +#+        +#+    +#+ +#+        +#+        +#+    +#+             \x1b[38;5;231mbuild no.\x1b[38;5;83m#{$buildnumber}");
		$system->info("		\x1b[38;5;227m  #+#        #+#    #+# #+#        #+#        #+#    #+#                \x1b[38;5;231mCurrent PHP version: \x1b[38;5;83mPHP" . phpversion());
		$system->info("		\x1b[38;5;227m  ###        ###    ### ###        ###         ########  ");
		$system->info("");
		$system->info("		\x1b[38;5;214m┏╋‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━━╋┓");
		$system->info("		\x1b[38;5;214m╋┛　　　　　　　　　　　　　　　　　　　　　 　　  　　┗╋\x1b[38;5;231m");
		if ($tipe == "logout") {
			$system->info("初期化処理を行っています..." . PHP_EOL);
		}
		$system->info("PHP Prompt OS Copyright (C) 2016 chell rui");
		// $system->info("This program comes with ABSOLUTELY NO WARRANTY; for details type `show w'. ");
		// $system->info("This is free software, and you are welcome to redistribute it under certain conditions; type `show c' for details.");
		// readline_completion_function("onigiri");
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
	  	date_default_timezone_set('Asia/Tokyo');
	  	$GLOBALS['pr_thread'] = "Boot";//スレッド-プロンプトに表示
	  	$GLOBALS['pr_info'] = "INFO";//情報-プロンプトに表示
	  	$system->info("\x1b[38;5;227mPHP Prompt OS\x1b[38;5;145m version {$versioncolor}{$version}");
	  	$system->info("\x1b[38;5;87mCreated by chell rui.");
		$pr_thread = "LOGIN";
		if ($tipe == "logout") {
			$system->info("初期化処理が完了しました。" . PHP_EOL);
		}
	}else{
		if ($tipe = "script") {
		}
	}
}

function readySetup($tipe){
	global $system;
	global $display;
	global $systemconf_ini_array;
	global $first_time_boot;
	if ($tipe == "logout") {
		$system->info("終了する場合は\"exit\"を入力:");
		$ask_exit = trim(fgets(fopen("php://stdin", "r")));
		if ($ask_exit == "exit") {
			$exit = new myExit;
			$exit->onCommand();
			exit;
		}
	}
	$pluginpros = new pluginManager;
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
	global $poPath;
	global $savevaluesmode;
	global $defined_vars;
	global $writeData;
	global $poPath;
	if($first_time_boot){
		$savevaluesmode = "off";
		// askLicense();
	}else{
		if ($divmode == 0) {
			$system->standbyTipe();
		}
		$pr_thread = "LOGIN";
		$username = $system->input("ユーザー名を入力してください。:");
		$user = $username;
		$filename = $poPath . "\\" . "user.json";
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
}

function askLicense(){
	global $system;
	global $display;
	global $systemconf_ini_array;
	global $savevaluesmode;
	global $defined_vars;
	$savevaluesmode = "off";
	$Language_setup = "ja";
	switch($Language_setup){
		case 'ja':
		// echo "言語を日本語に決定いたしました。\n";
		echo file_get_contents("LICENSE.txt") . "\n";
		$LICENSE_agree = $system->input("ライセンスに同意しますか？(y/n):");
		if($LICENSE_agree == "y"){
			file_put_contents(dirname(dirname(dirname(__FILE__))) . '\root\bin\\' . "systemdefinedvars.dat", serialize($defined_vars));
			startSetup();
		}else{
			echo "\nライセンスに同意してください\n";
			$system->info("PHP Prompt OS is stopping now...");
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
	global $poPath;
	$aryScriptFiles = array();
	$aryScripts = array();
	// ディレクトリのパスを記述
	$dir = $poPath . "/" . "scripts" ;

	// ディレクトリの存在を確認し、ハンドルを取得
	$i = 0;
	$handle = opendir(rtrim(dirname(__FILE__),"system\PHPPO\src") . "/" . "scripts" . "/");
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
		// $system->info($aryScriptFiles[$i] . "のスクリプトを確認しました。");
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
	$system->info("====セットアップを開始します====");
	$setup_user = $system->input("使用するユーザー名を入力してください:");
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
			$setup_password = $system->input('パスワードを設定してください。(八文字以上)');
			$system->sysCls(50);
			$flag = true;
			if (8 > strlen($setup_password)) {
				$system->throwError("設定したパスワードは八文字に満たしていません！");
			}else {
				$flag = false;
			}
		} while ($flag);
		$display->setInfo("INFO");
		$setup_password_req = $system->input("設定したパスワードをもう一度入力してください。:");
		$system->sysCls(50);
		if ($setup_password_req != $setup_password) {
			$system->throwError("二回目に入力したパスワードがはじめと一致していません！");
		}
	} while ($setup_password_req != $setup_password);
}

// standbyTipe();


function endUserSetup($user, $password){
	global $system;global $display;
	global $systemconf_ini_array;
	$filename = rtrim(dirname(__FILE__),"system\PHPPO\src") . "/" . "user.json";
	$json = file_get_contents($filename);
	$config = json_decode($json,true);

	if(empty($config[$user])){
		$config[$user] = sha1($password);
	}else{
		loginSystem($user);
	}
	$json = json_encode($config);
	file_put_contents($filename,$json);
	exec("start.cmd");
	exit;
}

function loginSystem($user){
	global $system;
	global $display;
	global $systemconf_ini_array;
	global $poPath;
	$filename = $poPath . "/" . "user.json";
	$json = file_get_contents($filename);
	$password_data = json_decode($json,true);
	$askPassword = $system->input($user . "のパスワードを入力してください。:");
	$hash_Password = sha1($askPassword);
	if ($hash_Password != $password_data[$user]) {
		do {
			$system->throwError("パスワードが合致しません！");
			$askPassword = $system->input($user . "のパスワードを入力してください。:");
			$hash_Password = sha1($askPassword);
		} while ($hash_Password != $password_data[$user]);
	}
}
