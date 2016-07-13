<?php

$systemconf_ini_array = parse_ini_file(dirname(dirname(dirname(dirname(__FILE__)))) . "\\config.ini", true);
//異常終了check
$echoFunc = "on";
$valuepros = new environmentVariables;
if ($systemconf_ini_array["dev"]["devmode"] != 1) {
	@$files = scandir(rtrim(trim(dirname(dirname(dirname(__FILE__)))),"\PHPPO\src") . "/root/home/logs/",1);
	// var_dump($files);
	if ($files != false) {
		$lines = file(rtrim(trim(dirname(dirname(__FILE__))),"\PHPPO\src") . "/root/home/logs/" . $files[0], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$line = end($lines);
		if ($line != "PHPPO was completed successfully."){
			$system->sendMessage("システムが異常終了していた可能性があります！！","critical");
			$system->sendMessage("前回のセッションの復元を試みますか？(Y/n):");
			$revses = trim(fgets(fopen("php://stdin", "r")));
			if($revses == "Y"||$revses == "y"){
				$system->sendMessage("前回起動時のセッションダンプを検索しています...");
				$path = dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "systemdefinedvars.dat";
				$system->sendMessage("ダンプファイルを読み込んでいます...");
				$defined_vars = unserialize(file_get_contents($path));
				$system->sendMessage("システム変数の復元を行っています...(この作業には時間がかかる可能性があります。)");
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
				$system->sendMessage("システムの復旧を行いました。起動します。\n次回終了時はexitコマンドで終了してください。");
				sleep(2);
			}else{
				$system->sendMessage("起動します。\n次回終了時はexitコマンドで終了してください。");
			}
		}
	}
}

$valuepros = new environmentVariables;




$system->sendMessage("Loading command Prosessing files...");
if ($systemconf_ini_array["system"]["logmode"] == 1) {
	$logmode = "on";
	$system->sendMessage("log mode \x1b[38;5;87menabled.");
}else {
	$logmode = "off";
}

if ($systemconf_ini_array["dev"]["currentdirectory"] == 1) {
	$currentdirectorymode = "on";
	$system->sendMessage("Current directory mode:\x1b[38;5;87menabled.");
	$system->sendMessage("There are a lot of bugs in the current directory mode!","warn");
}else {
	$currentdirectorymode = "off";
}

if ($systemconf_ini_array["system"]["saveenvironmentvalues"] == 1) {
	$savevaluesmode = "on";
	$valuepros->setvalue("prompt","\x1b[38;5;83m[%time] \x1b[38;5;87m[%thread/%info]\x1b[38;5;207m%cd\x1b[38;5;227m");
	$system->sendMessage("Save Environment Values Mode:\x1b[38;5;87menabled.");
}else {
	$savevaluesmode = "off";
}

$inPrompt = $systemconf_ini_array["display"]["in_prompt"];
// <<<<<<< HEAD


////////////////////////////////////Version////////////////////////////////////////

$version = "1.5.4_Alpha";
$versiontype = "Alpha";//{Release}->{Alpha}->{Beta}->{Dev}

////////////////////////////////////////////////////////////////////////////////////


// >>>>>>> master
$system->sendMessage("Starting environment variables system...");
$valuepros = new environmentVariables;
$valuepros->setvalue("version",$version);
$boottipe = count($argv);
function exception_handler($exception) {
	global $display;
	global $system;
	global $systemconf_ini_array;
	$system->sendMessage($exception->getMessage(),"error");
	$system->sendMessage("システム内部に致命的なエラーが発生したためPHP Prompt OSを終了します..." . PHP_EOL,"critical");
	echo "\x1b[38;5;231m続行するにはエンターキーを押してください。";
	$a = fgets(STDIN);
}

// var_dump($systemconf_ini_array);////////////////////////////////////////////////////

if ($systemconf_ini_array["dev"]["devmode"] == 1) {
	$system->sendMessage("exception handler:\x1b[38;5;203mdisable");
}else {
	set_exception_handler('exception_handler');
	$system->sendMessage("Error handler:\x1b[38;5;87menable");
	set_error_handler("myErrorHandler");
	$system->sendMessage("Error handler:\x1b[38;5;87menable");
}


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
function myErrorHandler($errno, $errstr, $errfile, $errline){
	global $system;
	if (!(error_reporting() & $errno)) {
		// error_reporting 設定に含まれていないエラーコードです
		return;
	}

	switch ($errno) {
		case E_USER_ERROR:
			$system->sendMessage("My ERROR [$errno] $errstr");
			$system->sendMessage("  Fatal error on line $errline in file $errfile");
			$system->sendMessage(", PHP " . PHP_VERSION . " (" . PHP_OS . ")");
			$system->sendMessage("Aborting...");
			exit(1);
			break;

		case E_USER_WARNING:
			$system->sendMessage("[$errno] $errstr","warn","PHP");
			break;

		case E_USER_NOTICE:
			$system->sendMessage("[$errno] $errstr","notice","PHP");
			break;

		default:
			$system->sendMessage("Unknown error type: [$errno] $errstr");
			break;
	}

	/* PHP の内部エラーハンドラを実行しません */
	return true;
}
function bootSystem($tipe){
	global $currentdirectory;
	global $currentdirectorymode;
	global $poPath;
	global $systemconf_ini_array;
	global $system;
	// $url = "https://github.com/chell-uoxou/PHP-Prompt-OS/releases.atom";
	// $ch = curl_init();
	// curl_setopt ($ch, CURLOPT_URL, $url);
	// curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	// curl_setopt($ch, CURLOPT_HEADER, false);
	// $xml = curl_exec($ch);
	// print_r($xml);
	$poPath = rtrim(trim(dirname(dirname(__FILE__))),"\PHPPO\src");
	if ($currentdirectorymode == "on") {
		$currentdirectory = $poPath . "\\root";
		$system->sendMessage("Set current directory:{$currentdirectory}\n");
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
	$system->sendMessage("here is :\x1b[38;5;145m" . $poPath);
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
			$system->sendMessage("\x1b[38;5;214mOops You are running the \"\x1b[38;5;203mdevelopment build \x1b[38;5;214m\"! There may be a bug !");
			break;
		default:
			# code...
			break;
	}

	if ($tipe != "script") {
		usleep(rand(0,500000));//演出
		$system->sysCls(100);
		$display->setThread("welcome");
		$display->setInfo("INFO");
		$system->sendMessage("		\x1b[38;5;214m╋┓　　　　　　　　　　　　　　　　　　　　　　   　　　┏╋");
		$system->sendMessage("		\x1b[38;5;214m┗╋‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━━╋┛");
		$system->sendMessage("");
		$system->sendMessage("		\x1b[38;5;227m  :::::::::  :::    ::: :::::::::  :::::::::   ::::::::  ");
		$system->sendMessage("		\x1b[38;5;227m  :+:    :+: :+:    :+: :+:    :+: :+:    :+: :+:    :+:  \x1b[38;5;231mPHP Prompt OS");
		$system->sendMessage("		\x1b[38;5;227m  +:+    +:+ +:+    +:+ +:+    +:+ +:+    +:+ +:+    +:+     \x1b[38;5;231mmade by chell rui.");
		$system->sendMessage("		\x1b[38;5;227m  +#++:++#+  +#++:++#++ +#++:++#+  +#++:++#+  +#+    +:+        \x1b[38;5;231mversion {$versioncolor}{$version}");
		$system->sendMessage("		\x1b[38;5;227m  +#+        +#+    +#+ +#+        +#+        +#+    +#+             \x1b[38;5;231mbuild no.\x1b[38;5;83m#{$buildnumber}");
		$system->sendMessage("		\x1b[38;5;227m  #+#        #+#    #+# #+#        #+#        #+#    #+#                \x1b[38;5;231mCurrent PHP version: \x1b[38;5;83mPHP" . phpversion());
		$system->sendMessage("		\x1b[38;5;227m  ###        ###    ### ###        ###         ########  ");
		$system->sendMessage("");
		$system->sendMessage("		\x1b[38;5;214m┏╋‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━‥━━╋┓");
		$system->sendMessage("		\x1b[38;5;214m╋┛　　　　　　　　　　　　　　　　　　　　　 　　  　　┗╋\x1b[38;5;231m");
		if ($tipe == "logout") {
			$system->sendMessage("初期化処理を行っています..." . PHP_EOL);
		}
		$system->sendMessage("PHP Prompt OS Copyright (C) 2016 chell rui");
		// $system->sendMessage("This program comes with ABSOLUTELY NO WARRANTY; for details type `show w'. ");
		// $system->sendMessage("This is free software, and you are welcome to redistribute it under certain conditions; type `show c' for details.");






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
	  	$system->sendMessage("\x1b[38;5;227mPHP Prompt OS\x1b[38;5;145m version {$versioncolor}{$version}");
	  	$system->sendMessage("\x1b[38;5;87mCreated by chell rui.");
		$pr_thread = "LOGIN";
		if ($tipe == "logout") {
			$system->sendMessage("初期化処理が完了しました。" . PHP_EOL);
		}
	}else{
		if ($tipe = "script") {
			// echo $argv[2];
			$tipe_text = "script home/scripts" . trim($argv[2]);
			$script = new script_command;
			$script->onCommand();
		}
	}
}
