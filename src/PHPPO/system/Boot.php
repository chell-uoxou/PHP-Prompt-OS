<?php
$systemconf_ini_array = parse_ini_file(dirname(dirname(dirname(dirname(__FILE__)))) . "\\config.ini", true);
//異常終了check
$echoFunc = "on";
$valuepros = new environmentVariables;
if ($systemconf_ini_array["dev"]["devmode"] != 1) {
	@$files = scandir(rtrim(trim(dirname(__FILE__)),"\PHPPO\src") . "/root/home/logs/",1);
	// var_dump($files);
	if ($files != false) {
		$lines = file(rtrim(trim(dirname(__FILE__)),"\PHPPO\src") . "/root/home/logs/" . $files[0], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$line = end($lines);
		if ($line != "PHPPO was completed successfully."){
			$system->sendMessage("システムが異常終了していた可能性があります！！","critical");
			$system->sendMessage("前回のセッションの復元を試みますか？(Y/n):");
			$revses = trim(fgets(fopen("php://stdin", "r")));
			if($revses == "Y"||$revses == "y"){
				$system->sendMessage("前回起動時のセッションダンプを検索しています...");
				$path = dirname(dirname(dirname(__FILE__))) . '\root\bin\\' . "systemdefinedvars.dat";
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
$version = "1.5.0_Beta";
$versiontype = "Beta";//{Release}->{Alpha}->{Beta}->{Dev}
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
