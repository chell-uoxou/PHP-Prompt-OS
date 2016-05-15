<?php
/*
echo "Boot now?(pless return or tipe\"exit\")";
$nowboot = trim(fgets(STDIN));
if($nowboot == ""){
    bootSystem();
}else{
  echo "PHPPO: Segmentation fault";
  exit();
}
*/
//////////////ルール/////////////
//・$aryTipeTxt[1]改行バグ解消方法....$aryTipeTxt[1] = trim($aryTipeTxt[1]);
//・既にある関数と被る名前のユーザー定義関数を作る際は「p_」を頭につける（例:p_mkdir）
////////////////////////////////
$logMode = "on";//ログを吐くデフォルトの設定
bootSystem();
//ここから本体

date_default_timezone_set('Asia/Tokyo');
$startBootTime = microtime(true);
function bootSystem(){
	date_default_timezone_set('Asia/Tokyo');
	$startBootTime = microtime(true);
  	//変数の初期化・宣言
  	global $pr_time;
  	global $pr_info;
  	global $pr_thread;
  	global $prompt;
  	global $user;
  	global $file_name;
  	global $Language_setup;
  	global $LICENSE_agree;
  	$pr_info = "";
  	$pr_time = "";
  	$pr_thread = "";
  	$prompt = "";
  	$user = "";
  	$file_name = "";
  	$Language_setup = "";
  	$LICENSE_agree = "";
  	/*コピペ用
  	global $;
  	$pr_info = "";
  	$pr_info = "";
  	$pr_info = "";
  	$pr_info = "";
  	$pr_info = "";
  	$pr_info = "";*/
  	date_default_timezone_set('Asia/Tokyo');
  	$GLOBALS['pr_thread'] = "Boot";//スレッド-プロンプトに表示
  	$GLOBALS['pr_info'] = "INFO";//情報-プロンプトに表示
  	echo $prompt . "PHP Prompt OS v_0.21_Beta\n";
  	echo $prompt . "Build by chell rui.\n";
  	@readfile($Sys_data) or readySetup();
  	/*$prompt = "[{$pr_thread} Thread/{$pr_info}:{$pr_time}]";
  	$pr_time = date$('$A$-H:i:s',time());
  	echo $prompt . "test\n";*/
	$pr_thread = "LOGIN";
  	echo $prompt . "Welcome to PHPPO! User:" . $user;
  		$prompt = "\n[$pr_time] [{$pr_thread} Thread/{$pr_info}]";
  		echo $prompt . "test\n";

}

/*function standby(){
  global $pr_TipeTxt;
  $pr_TipeTxt = trim(fgets(STDIN));
}*/

function readySetup(){
  global $pr_time;
  global $pr_info;
  global $pr_thread;
  global $prompt;
  global $user;
  global $file_name;
  global $Language_setup;
  global $LICENSE_agree;
  global $pr_info, $pr_thread;
  $user = 'Guest';
  // 作成するファイル名の指定
 $file_name = 'LICENSE.txt';

 // ファイルの存在確認
 if( !file_exists($file_name) ){
   // ファイル作成
   touch( $file_name );
 }else{
   // すでにファイルが存在する為エラーとする
   //$pr_info = "ERROR";
   //$pr_thread = "File";
   //sendMessage("ファイルが存在しています。 file name:[" . $file_name . "]");
 }
 // ファイルのパーティションの変更
 chmod( $file_name, 0666 );
 $file_name = 'config.ini';

 // ファイルの存在確認
 if(!file_exists($file_name)){//?
   // ファイル作成
   touch($file_name);
 }else{
   // すでにファイルが存在する為エラーとする
   //$pr_info = "ERROR";
   //$pr_thread = "File";
   //sendMessage("ファイルが存在しています。 file name:[" . $file_name . "]");
 }
 // ファイルのパーティションの変更
 chmod( $file_name, 0666 );
	$logfilepath = dirname(__FILE__) . "\\" . "logs";
	if (!file_exists($logfilepath)) {
	mkdir($logfilepath);
   sendMessage("ログ出力用フォルダを生成しました。:[" . $logfilepath .  "]");
 }

	$logfilepath = dirname(__FILE__) . "\\" . "logs" . "\\" . date('Y_m_d') . ".log";
 	if (!file_exists($logfilepath)) {
 	touch($logfilepath);
    sendMessage("ログ出力用ファイルを生成しました。:" . $logfilepath . PHP_EOL);
	}
 	systemFileOpen(dirname(__FILE__) . "\\" . "logs" . "\\" . date('Y_m_d') . ".log");
 	$pr_info = "INFO";
 	$pr_thread = "File";
 	$LICENSE = fopen("LICENSE.txt", "w");
 	fwrite($LICENSE, "      当phpアプリケーション「PHP Prompt OS」(以後はPHPPO)の著作権は、chell rui及びchell_uoxouにあるものとしまーす。\n      著作権表示のないまま別の場所に公開したり、二次配布したらだめだよー\n     オープンソースで配布してますが、中身  ぐっちゃぐちゃなんでその辺気にしないでくださーい。\n     今後いろいろ機能追加しますので、まあ、楽しんでいってねー(=^・・^=)");
 	fclose($LICENSE);
 	//echo PHP_EOL . "Language(en):\n  English -> \"en\"\n  Japanese -> \"ja\"\n";
  	$Language_setup = "ja";
  	switch($Language_setup){
    	case 'ja':
      	echo "言語を日本語に決定いたしました。\n";
      	echo file_get_contents("LICENSE.txt") . "\n";
      	echo "ライセンスに同意しますか？(y/n):";
      	$LICENSE_agree = trim(fgets(STDIN));
      	if($LICENSE_agree == "y"){
        	startSetup();
      	}else{
        	echo "\nライセンスに同意してください\n";
        	sendMessage("PHP Prompt OS is stopping now...");
        exit;
      	}
      break;
    default:
      echo "";
      break;
  }

  }

function startSetup(){
  global $pr_time;
  global $pr_info;
  global $pr_thread;
  global $prompt;
  global $user;
  global $file_name;
  global $Language_setup;
  global $LICENSE_agree;
  global $pr_disp;
  global $setup_password;
  sendMessage("====セットアップを開始します====");
  sendMessage("使用するユーザー名を入力してください:");
  $setup_user = trim(fgets(STDIN));
  setUserPassword();
  endUserSetup($setup_user,$setup_password);
}

function setUserPassword(){
  	global $setup_password;
	do {
		$setup_password = "";
		$setup_password_req = "";
		do {
			sendMessage('パスワードを設定してください。(八文字以上)');
			$setup_password = trim(fgets(STDIN));
			sysCls(50);
			$flag = true;
			if (8 > strlen($setup_password)) {
				sendMessage("設定したパスワードは八文字に満たしていません！");
			}else {
				$flag = false;
			}
		} while ($flag);
		sendMessage("設定したパスワードをもう一度入力してください。:");
		$setup_password_req = trim(fgets(STDIN));
		sysCls(50);
		if ($setup_password_req != $setup_password) {
			sendMessage("二回目に入力したパスワードがはじめと一致していません！");
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
$pr_thread = "BOOT";
sendMessage("ようこそ！PHP Prompt OS v_0.21_Beta");
sendMessage("画面の更新を行います...");
sleep(2);
sysCls(500);
$endBootTime = microtime(true);
$resBootTime = $endBootTime - $startBootTime;
sendMessage("起動完了！(" . round($resBootTime, 2) . " s.) helpコマンドでコマンド一覧を表示。");
$pr_thread = "PHPPO";
standbyTipe();


function endUserSetup($user, $password){

}

function standbyTipe(){
  	global $pr_disp;
  	global $tipe_text;
  	global $stanby;
	global $writeData;
  	$stanby = True;
  	sendMessage(">");
  	$stanby = false;
	$tipe_text = trim(fgets(STDIN));
	fwrite($writeData,PHP_EOL . $tipe_text);
  	runCommand();
  	standbyTipe();
  }



function runCommand() {
  global $tipe_text;
  global $baseCommand;
  global $aryTipeTxt;
  global $pr_disp;
  global $pr_info;
  global $exec_command;
  $aryTipeTxt = explode(" ", $tipe_text);
  $baseCommand = trim($aryTipeTxt[0]);
  if (!$baseCommand == "") {
	  switch ($baseCommand) {
        case "help":
          	onHelpCommad();
          	break;
        case "echo":
          	onEchoCommand();
          	break;
        case "exit":
        	onExitCommand();
        	break;
        case "exec":
          	onExecCommand();
          	break;
        case "cls":
          	onClsCommand();
          	break;
        case 'time':
          	onTimeCommand();
          	break;
        case 'log':
          	onLogCommand();
          	break;
     	case "download":
    		onDownloadCommand();
        	break;
        case "info":
    		onInfoCommand();
          	break;
        default:
          	sendMessage("\"" . $baseCommand . "\"コマンドが見つかりませんでした。helpコマンドで確認してください。");
          	break;
      }
  }

}
function onHelpCommad(){
  global $tipe_text;
  global $baseCommand;
  global $aryTipeTxt;
  global $pr_disp;
  sendMessage("======コマンド一覧=======");
  sendMessage("help:使用できるコマンドを表示。");
  sendMessage("echo:メッセージを表示。");
  sendMessage("exit:PHP Prompt OSを終了。");
  sendMessage("*exec:コマンド及び外部プロセスの実行");
  sendMessage("time:コンピューターに設定されている時刻を表示。");
  sendMessage("log:ログを出力する設定。");
  sendMessage("*info <logo|auther|des|help|url|>:当プログラムに関しての情報を表示。");
  sendMessage("=========================");
  sendMessage("アスタリスク(*)マークは、互換性がない可能性があります。");
}


function onEchoCommand() {
  global $pr_disp;
  global $pr_TipeTxt;
  global $pr_thread;
  global $pr_info;
  global $prompt;
  global $aryTipeTxt;
  $messageCount = count($aryTipeTxt);
  if ($messageCount <= 1) {
  	sendMessage("パラメーターが不足しています。");
	}else{
	$aryTipeTxt[1] = trim($aryTipeTxt[1]);
	$message = '';
	for ($i=1; $i < $messageCount; $i++) {
		$message .= $aryTipeTxt[$i] . " ";
	}
	sendMessage($message);
  }
}

function onExitCommand() {
	global $pr_disp;
	global $aryTipeTxt;
	if (!isset($aryTipeTxt[1])){
 	sendMessage("PHP Prompt OS by chell ruiを終了します...");
		}else{
			$aryTipeTxt[1] = trim($aryTipeTxt[1]);
  			sendMessage($aryTipeTxt[1] . "秒後にPHP Prompt OS by chell ruiを終了します...");
			$waitSec = (int)$aryTipeTxt[1];
  			sleep($waitSec);
	}
	sendMessage("(@^^)/~~~！");
	exit();
}

function onExecCommand() {
  global $tipe_text;
  global $baseCommand;
  global $aryTipeTxt;
  global $pr_disp;
  $messageCount = count($aryTipeTxt);
	if ($messageCount <= 1) {
  	sendMessage("パラメーターが不足しています。");
  	}else{
  		$exec_command = '';
  		for ($i=1; $i < $messageCount; $i++) {
	  	$exec_command .= $aryTipeTxt[$i] . " ";
			}
		$exec_command = trim($exec_command);
  		exec($exec_command);
		sendMessage($exec_command . "コマンドの実行を試みました。");
	}
}

function onInfoCommand(){
	global $aryTipeTxt;
	$messageCount = count($aryTipeTxt);
    if ($messageCount <= 1) {
		sendMessage("PHP Prompt OS (PHPPO) version 0.2.5");
		sendMessage("Copyright by chell rui @2015");
  	}else{
  		$aryTipeTxt[1] = trim($aryTipeTxt[1]);
  		$message = '';
  		for ($i=1; $i < $messageCount; $i++) {
  			$message .= $aryTipeTxt[$i] . "";
  		}
	}

	switch ($aryTipeTxt[1]) {
		case 'logo':
			exec(dirname(__FILE__) . "\\" . "logo.jpg");
			break;
		case 'auther':
			sendMessage("PHP Prompt OS、およびPHPPOの作成者はchell ruiです。");
			sendMessage("Twitter:@chell_uoxou");
			break;
		case 'help':
			sendMessage("infoコマンドの使用方法:");
			sendMessage("info <logo|auther|des|help|url>");
			sendMessage("logo:PHP Prompt OS のロゴを既定の画像ビューアーで表示します。");
			sendMessage("auther:PHP Prompt OS の作成者の情報を表示します。");
			sendMessage("des:PHP Prompt OSの情報を表示します。");
			sendMessage("help:コマンドの使用方法を表示します。");
			sendMessage("url:PHP Prompt OSのページのURLを表示します。アップデートの確認はこちらでお願いします。");
			break;
		case 'url':
			sendMessage("PHP Prompt OSのページです。アップデートの確認はこちらでお願いします。");
			sendMessage("https://chellruibox.wordpress.com/php-prompt-os/");
			break;
		case 'des':
			sendMessage(" PHP Prompt OSは、chell ruiによって作られたコンソール風のPHPスクリプトです。");
			sendMessage(" カイヌシ(chell rui)がPHPの勉強をするために作られました。");
			sendMessage(" 今後機能を追加していく予定なのですが、一般、または企業に対して利益のある活動ではありません。");
			sendMessage(" PHP Prompt OS は、現段階でPHP版のカイヌシを中心としたプロジェクトとして進行しており、現段階ではプログラミング言語のHot Soop Processor 3、Javaを利用した互換プログラムも同時に開発が進められています。");
			sendMessage(" 開発者は、現在三名です。PHP版は主にchell ruiが担当しております。その他の担当は、公式Google Plusコミュニティーをご確認ください。また、開発者を募集しておりますので、興味がわいた方はぜひコミュニティにて参加の希望を表明してください。但し、当プロジェクトは現段階では非営利で活動しているため、開発者に利益はございません。");
			sendMessage(" ロゴは、chell ruiによるものです。");
			break;
		default:
			break;
	}
}


function onClsCommand() {
    exec(cls);
}

function onTimeCommand(){
  global $tipe_text;
  global $baseCommand;
  global $aryTipeTxt;
  global $pr_disp;
  global $pr_time;
  $pr_time = date('H時i分秒',time());
  $d = getdate();
  sendMessage($d['year'] . "年" . $d['mon'] . '月' . $d['mday'] . "日");
  sendMessage($d['hours'] . '時' . $d['minutes'] . '分' . $d['seconds'] . "秒");
}

function onLogCommand(){
	global $tipe_text;
	global $baseCommand;
	global $aryTipeTxt;
	global $pr_disp;
	global $pr_time;
	global $logMode;
	$messageCount = count($aryTipeTxt);
	if ($messageCount <= 1) {
	  sendMessage("Log modeは " . $logMode . " です。");
	  sendMessage("ログモードを変更する際は、第一引数に<on>か<off>の値を記入してください。");
	  }else{
		$aryTipeTxt[1] = trim($aryTipeTxt[1]);
	  	if ($aryTipeTxt[1] == "on") {
	  	$logMode = "on";
		sendMessage("ログファイルにログを書き出します。");
				}else{
				if ($aryTipeTxt[1] == "off") {
			  	$logMode = "off";
			  	sendMessage("ログファイルにログを書き出しません。");
		  			}else{
			  		sendMessage("パラメーターの記法に誤りがあります。");
			  		sendMessage("第一引数(" . $aryTipeTxt[1] . ")に<on>か<off>の値を記入してください。");

		  }
		}
	  }
}

function onDownloadCommand(){
	global $tipe_text;
	global $baseCommand;
	global $aryTipeTxt;
	$url = $aryTipeTxt[1];
	$save_base_name = $aryTipeTxt[3];
	$aryTipeTxt[1] = trim($aryTipeTxt[1]);
	if ($path == "") {
		file_download($url, dirname(__FILE__), $save_base_name);
	}else {
		$path = $aryTipeTxt[2];
		file_download($url, $path, $save_base_name);
	}
}

function file_download($url, $dir='.', $save_base_name='' ){//http://logic.moo.jp/data/archives/825.htmlより引用しました。
    if ( ! is_dir($dir) ){
		 sendMessage("ディレクトリ({$dir})が存在しません。");
	 }
    $dir = preg_replace("{/$}","",$dir);
    $p = pathinfo($url);
    $local_filename = '';
    if ( $save_base_name ){
		 $local_filename = "{$dir}/{$save_base_name}.{$p['extension']}";
	 }else{
		  $local_filename = "{$dir}/{$p['filename']}.{$p['extension']}"; }
    if ( is_file( $local_filename ) ){
		 sendMessage("すでにファイル({$local_filename})が存在します<br>\n");
	 }
    $tmp = file_get_contents($url);
    if (! $tmp){
		sendMessage("URL({$url})からダウンロードできませんでした。");
	}
    $fp = fopen($local_filename, 'w');
    fwrite($fp, $tmp);
    fclose($fp);
}
/////////////////////////////////////////////システム処理集/////////////////////////////////////////////
function showCsv($fname){
  $f = @fopen($fname,'rb') or sendMessage("※ファイルを開く際にエラーが発生しました。");
  while(!feof($f)) $GLOBALS['/*ここ*/'] = something;fgetcsv($f,1024);
  fclose($f);
}

function systemFileOpen($path)
{
	global $writeData;
	$writeData = fopen($path,'a');
}

function systemFileClose()
{
	global $writeData;
	fclose($writeData);
}

function sysCls($res){
  for($i = 0; $i < $res;$i++){
    echo "\n";
  }
}

function sendMessage($pr_disp){
  global $pr_TipeTxt;
  global $pr_thread;
  global $pr_info;
  global $pr_time;
  global $prompt;
  global $writeData;
  global $stanby;
  global $logMode;
  global $tipe_text;
  date_default_timezone_set('Asia/Tokyo');
  $pr_time = date('A-H:i:s');
  $prompt = PHP_EOL . "[{$pr_time}] [{$pr_thread} Thread/{$pr_info}]";
  echo "{$prompt} {$pr_disp}";
  if ($logMode == "on") {
	  if (isset($writeData)){
		if ($stanby) {

		}else{
			fwrite($writeData,"{$prompt} {$pr_disp}");
		}
	  }
  }
}
