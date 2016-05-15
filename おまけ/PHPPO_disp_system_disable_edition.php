<?php
/*echo "Boot now?(pless return or tipe\"exit\")";
$nowboot =trim(fgets(STDIN));
if($nowboot == exit){
  exit('PHPPO: Segmentation fault');
}else{
  bootSystem();
}*/
bootSystem();
//ここから本体
global $startBootTime;
date_default_timezone_set('Asia/Tokyo');
$startBootTime = date('s',time()) + date('i',time()) * 60;
function bootSystem(){
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
  setPromptTime();//現在時刻-プロンプトに表示
  $GLOBALS['pr_thread'] = "Boot";//スレッド-プロンプトに表示
  $GLOBALS['pr_info'] = "INFO";//情報-プロンプトに表示
  setPromptTime();
  echo $prompt . "PHP Prompt OS v_0.10_Beta\n";
  echo $prompt . "Build by chell rui.\n";
  @readfile($Sys_data) or readySetup();
  /*$prompt = "[{$pr_thread} Thread/{$pr_info}:{$pr_time}]";
  $pr_time = date$('$A$-H:i:s',time());
  echo $prompt . "test\n";*/
  echo $prompt . "Welcome to PHPPO! User:" . $user;
    setPromptTime();
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
   $pr_info = "ERROR";
   $pr_thread = "File";
   $pr_disp = "ファイルが存在しています。 file name:[" . $file_name . "]";
   sendMessage();
 }
 // ファイルのパーティションの変更
 chmod( $file_name, 0666 );
 $pr_info = "INFO";
 $pr_thread = "File";
 setPromptTime();
 $pr_disp = $prompt . 'ファイル作成完了。 file name:[' . $file_name . ']' . "\n";
 $LICENSE = fopen("LICENSE.txt", "w");
  fwrite($LICENSE, "      当phpアプリケーション「PHP Prompt OS」(以後はPHPPO)の著作権は、chell rui及びchell_uoxouにあるものとしまーす。\n      著作権表示のないまま別の場所に公開したり、二次配布したらだめだよー\n     オープンソースで配布してますが、中身  ぐっちゃぐちゃなんでその辺気にしないでくださーい。\n     今後いろいろ機能追加しますので、まあ、楽しんでいってねー(=^・・^=)");
  fclose($LICENSE);
  echo "Language(en):\n  English -> \"en\"\n  Japanese -> \"ja\"\n";
  $Language_setup = trim(fgets(STDIN));
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
        $pr_disp = "PHP Prompt OS is stopping now...";
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
  $pr_disp = "====セットアップを開始します====";
  sendMessage();
  $pr_disp = "使用するユーザー名を入力してください:";
  sendMessage();
  $setup_user = trim(fgets(STDIN));
  setUserPassword();
}
function setUserPassword(){
  global $pr_disp;
  $pr_disp = "パスワードを設定してください。(八文字以上)";
  sendMessage();
  $setup_password = trim(fgets(STDIN));
  $pr_disp = "設定したパスワードをもう一度入力してください。:";
  sendMessage();
  $setup_password_req = trim(fgets(STDIN));
  if ($setup_password_req != $setup_password) {

    $pr_disp = "二回目に入力したパスワードがはじめと一致していません！";
    sendMessage();
    setUserPassword();
  }
}
function setPromptTime(){
  global $pr_time;
  global $pr_info;
  global $pr_thread;
  global $prompt;
  global $user;
  global $file_name;
  global $Language_setup;
  global $LICENSE_agree;
  $GLOBALS['pr_time'] = date('A-H:i:s',time());
  $GLOBALS['prompt'] = "[{$pr_time}] [{$pr_thread} Thread/{$pr_info}]";
  }
$pr_disp = "ようこそ！PHP Prompt OS v_0.10_Beta";
sendMessage();
$pr_disp = "画面の更新を行います...";
sendMessage();
sleep(2);
for($i = 0; $i < 100;$i++){
  echo "\n";
}
$endBootTime = date('s',time()) + date('i',time()) * 60;
echo $endBootTime;
echo $startBootTime;
$resBootTime = $startBootTime - $endBootTime;
$pr_disp = "起動完了！({$resBootTime} s.) helpコマンドでコマンド一覧を表示。";
sendMessage();
standbyTipe();
function standbyTipe(){
  global $pr_disp;
  global $tipe_text;
  $pr_disp = ">";
  sendMessage();
  $tipe_text = fgets(STDIN);
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
    case "":
      break;
    default:
      $pr_disp = "\"" . $baseCommand . "\"コマンドが見つかりませんでした。helpコマンドで確認してください。";
      sendMessage();
      break;
  }
}
function onHelpCommad(){
  global $tipe_text;
  global $baseCommand;
  global $aryTipeTxt;
  global $pr_disp;
  $pr_disp = "======コマンド一覧=======";
  sendMessage();
  $pr_disp = "help:使用できるコマンドを表示。";
  sendMessage();
  $pr_disp = "echo:メッセージを表示。";
  sendMessage();
  $pr_disp = "exit:PHP Prompt OSをシャットダウン。";
  sendMessage();
  $pr_disp = "exec:コマンド及び外部プロセスの実行";
  sendMessage();
  $pr_disp = "time:コンピューターに設定されている時刻を表示。";
  sendMessage();
}

function sendMessage(){
  global $pr_disp;
  global $pr_TipeTxt;
  global $pr_thread;
  global $pr_info;
  global $pr_time;
  global $prompt;
  date_default_timezone_set('Asia/Tokyo');
  $pr_time = date('A-H:i:s',time());
  $prompt = "\n[{$pr_time}] [{$pr_thread} Thread/{$pr_info}]";
  echo "{$prompt} {$pr_disp}";
}
function onEchoCommand() {
  global $pr_disp;
  global $pr_TipeTxt;
  global $pr_thread;
  global $pr_info;
  global $prompt;
  global $aryTipeTxt;
  @$pr_disp = /*$aryTipeTxt[1] or $pr_disp = "パラメーターが不足しています。";*/"{$aryTipeTxt[1]} {$aryTipeTxt[2]} {$aryTipeTxt[3]} {$aryTipeTxt[4]} {$aryTipeTxt[5]} {$aryTipeTxt[6]} {$aryTipeTxt[7]} {$aryTipeTxt[8]} {$aryTipeTxt[9]}"or $pr_disp = "パラメーターが不足しています。";
  sendMessage();
}
function onExitCommand() {
global $pr_disp;
$pr_disp = "PHP Prompt OS by chell ruiを終了しています...";
sendMessage();
$pr_disp = "(@^^)/~~~！";
sendMessage();
exit();
}

function onExecCommand() {
  global $tipe_text;
  global $baseCommand;
  global $aryTipeTxt;
  global $pr_disp;
  @$exec_command = "{$aryTipeTxt[1]} {$aryTipeTxt[2]} {$aryTipeTxt[3]} {$aryTipeTxt[4]} {$aryTipeTxt[5]} {$aryTipeTxt[6]}"or $pr_disp = "パラメーターが不足しています。";
  exec($exec_command);
  @$pr_disp = "プロセスの実行に成功しました。" or $pr_disp = "プロセスの実行に失敗しました。";
  sendMessage();

function onClsCommand() {
    exec(cls);
  }
}

function onTimeCommand(){
  global $tipe_text;
  global $baseCommand;
  global $aryTipeTxt;
  global $pr_disp;
  global $pr_time;
  $pr_time = date('H時i分秒',time());
  $d = getdate();
  $pr_disp = $d['year'] . "年" . $d['mon'] . '月' . $d['mday'] . "日";
  sendMessage();
  $pr_disp = $d['hours'] . '時' . $d['minutes'] . '分' . $d['seconds'] . "秒";
  sendMessage();
}
?>
