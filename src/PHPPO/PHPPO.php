<?php


/*
*   :::::::::  :::    ::: :::::::::  :::::::::   ::::::::
*   :+:    :+: :+:    :+: :+:    :+: :+:    :+: :+:    :+:  PHP Prompt OS
*   +:+    +:+ +:+    +:+ +:+    +:+ +:+    +:+ +:+    +:+     made by chell rui.
*   +#++:++#+  +#++:++#++ +#++:++#+  +#++:++#+  +#+    +:+
*   +#+        +#+    +#+ +#+        +#+        +#+    +#+
*   #+#        #+#    #+# #+#        #+#        #+#    #+#
*   ###        ###    ### ###        ###         ########
* @author chell rui
*/



echo "Library loaded!\nPHP Prompt OS booting...\n";


$first_time_boot = !file_exists(rtrim(dirname(__FILE__),"\PHPPO\src") . "\\root\bin\\" . 'systemdefinedvars.dat');
include_once "system/System.php";
include_once 'display/display.php';
include_once 'command/Command.php';
$system = new systemProcessing;
$display = new display;
include_once 'plugin/Manager.php';
include_once 'system\environmentValues.php';
include_once 'system\currentdirectory.php';
include_once 'system\Boot.php';






function readySetup($tipe){
	global $system;
	global $display;
	global $systemconf_ini_array;
	global $first_time_boot;
	if ($tipe == "logout") {
		$system->sendMessage("終了する場合は\"exit\"を入力:");
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
	$dir_name = "{$poPath}/root";
	if( !file_exists($dir_name) ){
		$system->sendMessage("rootディレクトリが見つかりませんでした！\n新規作成します...");
		mkdir( $dir_name );
	}

	$dir_name = "{$poPath}/root/home";
	if( !file_exists($dir_name) ){
		$system->sendMessage("root/homeディレクトリが見つかりませんでした！\n新規作成します...");
		mkdir( $dir_name );
	}

	$dir_name = "{$poPath}/root/bin";
	if( !file_exists($dir_name) ){
		$system->sendMessage("root/binディレクトリが見つかりませんでした！\n新規作成します...");
		mkdir( $dir_name );
	}

	$dir_name = "{$poPath}/root/plugins";
	if( !file_exists($dir_name) ){
		$system->sendMessage("root/pluginsディレクトリが見つかりませんでした！\n新規作成します...");
		mkdir( $dir_name );
	}

	$dir_name = $poPath . '/root/$Trash';
	if( !file_exists($dir_name) ){
		$system->sendMessage("ゴミ箱用ディレクトリが見つかりませんでした！\n新規作成します...");
		mkdir( $dir_name );
	}

	$userfilepath = rtrim(dirname(__FILE__),"\PHPPO\src") ."\\root\bin\user.json";
	if (!file_exists($userfilepath)) {
		touch($userfilepath);
		$system->sendMessage("ユーザー設定用ファイルを出力しました。:" . $userfilepath);
	}
	chmod( $userfilepath, 0666 );

	$userfilepath = rtrim(dirname(__FILE__),"\PHPPO\src") ."\\root\bin\\environmentVariables.dat";
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

	$logfilepath = rtrim(dirname(__FILE__),"\PHPPO\src") . "\\root\home\logs";
	if (!file_exists($logfilepath)) {
		mkdir($logfilepath);
		$system->sendMessage("ログ出力用フォルダを生成しました。:" . $logfilepath);
	}

	$scriptsfilepath = rtrim(dirname(__FILE__),"\PHPPO\src") . "\\root\scripts";
	if (!file_exists($scriptsfilepath)) {
		mkdir($scriptsfilepath);
		$system->sendMessage("スクリプト、ユーザー定義コマンド保存用フォルダを生成しました。:" . $scriptsfilepath);
	}

	$logfilepath = rtrim(dirname(__FILE__),"\PHPPO\src") . "\\root\home\logs\\" . date('Y_m_d') . ".log";
	if (!file_exists($logfilepath)) {
		touch($logfilepath);
		$system->sendMessage("ログ出力用ファイルを生成しました。:" . $logfilepath . PHP_EOL);
	}
	chmod( $logfilepath, 0666 );

	$system->systemFileOpen($logfilepath);
	global $writeData;
	$writeData = fopen($logfilepath,'a');
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
	fwrite($LICENSE,   '	■□━━━━━━━━━━━━━━━━━━━━━━━━━━□■
	□■　　　　　　     　PHP Prompt OS 1　 　　　　 　　　■□
	■□━━━━━━━━━━━━━━━━━━━━━━━━━━□■

	このたびは、PHP Prompt OS をダウンロードしていただき誠にありがとうございます！
	当プロジェクトは、chell ruiによるものです。（contact :@chell_uoxou）
	今もなお、様々な言語で開発が進められております。そして、正式なversion、1.0.0として公開することになりました！

	■■■ＲＥＬＥＡＳＥ　ＮＯＴＥ──────────────────────────────

	version 1.0.0 :
	・システム構成のオブジェクト化
	┣ コマンド、システムにおいてのそれぞれの処理をクラスに分解し、整理。
	┣ コマンド処理を"commands"ディレクトリ内のそれぞれPHPファイルに格納。
	┗ 文字を表示する処理における設定を追加。
	┗displayクラスのsetThread()メソッド、setInfo()メソッド。

	・pharシステムの形成。
	┗実用化はできていない（windows)。

	・開発向けコマンドの追加。
	┣vardumpコマンド　:　システム処理が継承した"vardump"クラス内から呼び出せるパブリック変数、
	┃			及びメイン処理におけるグローバル変数の内容を表示します。
	┗makepharコマンド　：指定したアプリケーション、ディレクトリパス、または実行しているPHPPOの
	pharアーカイブ作成を行います。※未完成
	・起動方法を改変
	┣　インストールと同時にphpバイナリーが同梱されたフォルダを展開し、起動時にパソコンに
	┃インストールされているものではないPHPで動かす。
	┃	┗それぞれの環境において同じような実行結果が得られるため、error対処がスムーズ。
	┗起動時にsrcに格納されているベースのプロセスを呼び出し、mintty.exeに結果を出力。');
	fclose($LICENSE);
	$system->sendMessage("\x1b[38;5;145m更新が終了しました。");
	$file_name = rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . 'config.ini';
	if (!file_exists($file_name)) {
		touch($file_name);
		$system->sendMessage("システム設定用ファイルを出力しました。:" . $file_name . PHP_EOL);
		chmod( $file_name, 0666 );
		file_put_contents($file_name,"
		[dev]
		devmode=on
		currentdirectory=on
		[system]
		logmode=on
		saveenvironmentvalues=on
		bootexec=\bin\welcome.sh
		[display]
		in_prompt=[%time] [%thread/%info]%cd>
		out_prompt=[38;5;83m[%time][38;5;87m[%therad/%info]

		");
	}
	if($first_time_boot){
		$savevaluesmode = "off";
		askLicense();
	}else{
		if ($divmode == 0) {
			standbyTipe();
		}
		$pr_thread = "LOGIN";
		$username = $system->sendMessage("ユーザー名を入力してください。:","input");
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
		$LICENSE_agree = $system->sendMessage("ライセンスに同意しますか？(y/n):","input");
		if($LICENSE_agree == "y"){
			file_put_contents(dirname(dirname(dirname(__FILE__))) . '\root\bin\\' . "systemdefinedvars.dat", serialize($defined_vars));
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
	$setup_user = $system->sendMessage("使用するユーザー名を入力してください:","input");
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
			$setup_password = $system->sendMessage('パスワードを設定してください。(八文字以上)',"input");
			$system->sysCls(50);
			$flag = true;
			if (8 > strlen($setup_password)) {
				$system->sendMessage("設定したパスワードは八文字に満たしていません！","error");
			}else {
				$flag = false;
			}
		} while ($flag);
		$display->setInfo("INFO");
		$setup_password_req = $system->sendMessage("設定したパスワードをもう一度入力してください。:","input");
		$system->sysCls(50);
		if ($setup_password_req != $setup_password) {
			$system->sendMessage("二回目に入力したパスワードがはじめと一致していません！","error");
		}
	} while ($setup_password_req != $setup_password);
}

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
	exec("start.cmd");
	exit;
}

function loginSystem($user){
	global $system;global $display;
	global $systemconf_ini_array;
	$filename = rtrim(dirname(__FILE__),"\PHPPO\src") . "/" . "user.json";
	$json = file_get_contents($filename);
	$password_data = json_decode($json,true);
	$askPassword = $system->sendMessage($user . "のパスワードを入力してください。:","input");
	$hash_Password = sha1($askPassword);
	if ($hash_Password != $password_data[$user]) {
		do {
			$system->sendMessage("パスワードが合致しません！","error");
			$askPassword = $system->sendMessage($user . "のパスワードを入力してください。:","input");
			$hash_Password = sha1($askPassword);
		} while ($hash_Password != $password_data[$user]);
	}
}


function standbyTipe(){
	global $system;
	global $poPath;
	global $display;
	global $aryTipeTxt;
	global $systemconf_ini_array;
	global $pr_disp;
	global $tipe_text;
	global $stanby;
	global $writeData;
	global $pr_thread;
	global $pr_info;
	global $pr_time;
	global $echoFunc;
	global $currentdirectory;
	global $po_cd;
	global $poPath;
	global $logmode;
	global $defined_vars;
	global $inPrompt;
	global $outPrompt;
	global $commandpros;
	global $valuepros;
	global $pluginpros;
	global $scriptcommandpros;
	$scriptcommandpros->readExtension();
	$commandpros = new command;
	$pluginpros->install();
	// $system->sendMessage("\x1b[38;5;63m起動完了！helpコマンドでコマンド一覧を表示。");
	// file_put_contents(dirname(dirname(dirname(__FILE__))) . '\root\bin\\' . "systemdefinedvars.dat", serialize($defined_vars));
	if (isset($systemconf_ini_array["system"]["bootexec"])) {
		if ($systemconf_ini_array["system"]["bootexec"] != "") {
			$bootexec = $systemconf_ini_array["system"]["bootexec"];
			// echo "$poPath\\root\\$bootexec";
			$aryTipeTxt = array("script","$poPath\\root\\$bootexec");
			// var_dump($aryTipeTxt);
			$script = new script_command;
			$script->onCommand();
		}
	}

	while (True) {
		$system->readyInputEvent();
		// var_dump($defined_vars);
		file_put_contents(dirname(dirname(dirname(__FILE__))) . '\root\bin\\' . "systemdefinedvars.dat", serialize($defined_vars));
		$po_cd = str_replace(trim($poPath),"",trim($currentdirectory));
		$stanby = True;
		$display->setThread("PHPPO");

		// $prompt = "\x1b[38;5;83m[{$pr_time}] \x1b[38;5;87m[{$pr_thread}/{$pr_info}]\x1b[38;5;207m{$po_cd}\x1b[38;5;227m>";
		// if ($echoFunc != "off") {
		// 	echo "\x1b[38;5;83m" . $prompt . "\x1b[38;5;227m";
		// }else {
		// 	echo "\x1b[38;5;227m";
		// }

		$tipe_text = $system->sendMessage("\x1b[38;5;227m>","input");
		$stanby = false;
		if ($logmode == 1) {
			fwrite($writeData,PHP_EOL . $tipe_text);
		}
		$commandpros->runCommand();
	}
}



/////////////////スクリプト処理系/////////////////////

function buildScripts($data){
	global $system;
	global $display;
	global $systemconf_ini_array;

}
