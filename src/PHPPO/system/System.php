<?php


namespace phppo\system;


include_once dirname(__FILE__) . '/../display/display.php';
include_once 'environmentValues.php';
include_once dirname(__FILE__) . '/../plugin/Manager.php';
include_once 'currentdirectory.php';
include_once 'sysconf.php';
include_once dirname(__FILE__) . '/../event/event.php';

use phppo\plugin\Manager as pluginManager;
use phppo\display as display;
$pluginpros = new pluginManager;
$sysconfpros = new systemConfig("read");


class systemProcessing {
	private static function add_zip( $zip, $dir_path, $new_dir ){
		if( ! is_dir( $new_dir ) ){
			$zip->addEmptyDir( $new_dir );
		}

		foreach( self::get_inner_path_of_directory( $dir_path ) as $file ){
			if( is_dir( $dir_path . "/" . $file ) ){
				self::add_zip( $zip, $dir_path . "/" . $file, $new_dir . "/" . $file );
			}
			else{
				$zip->addFile( $dir_path . "/" . $file, $new_dir . "/" . $file );
			}
		}
	}
	public static function all_zip( $dir_path, $new_dir ){
		$zip = new ZipArchive();
		if( $zip->open( $new_dir, ZipArchive::OVERWRITE ) === true ){
			self::add_zip( $zip, $dir_path, "" );
			$zip->close();
		}
		else{
			throw new Exception('It does not make a zip file');
		}
	}
	// public function showCsv($fname){
	//   $f = @fopen($fname,'rb') or $this->info("※ファイルを開く際にエラーが発生しました。");
	//   while(!feof($f)) $GLOBALS['/*ここ*/'] = something;fgetcsv($f,1024);
	//   fclose($f);
	// }

	public function systemFileOpen($path){
		global $writeData;
		$writeData = fopen($path,'a');
	}

	public function systemFileClose(){
		global $writeData;
		fclose($writeData);
	}

	public function sysCls($res){
		global $revcFunc;
		for($i = 0; $i < $res;$i++){
			if ($revcFunc == true) {
				echo "                                                                                                                                                     ";
				echo PHP_EOL;
			}else {
				echo PHP_EOL;
			}
		}
	}

	public function file_download($url, $dir='.', $save_base_name='' ){
		$url = trim($url);
		if ( ! is_dir($dir) ){
			$this->throwError("ディレクトリ({$dir})が存在しません。");
			return false;
		}
		$dir = preg_replace("{/$}","",$dir);
		$p = pathinfo($url);
		$local_filename = '';
		if ( $save_base_name ){
			$local_filename = "{$dir}/{$save_base_name}.{$p['extension']}";
		}else{
			@$local_filename = "{$dir}/{$p['filename']}.{$p['extension']}";
		}
		$a = 1;

		while (file_exists($local_filename)) {
			@$local_filename = "{$dir}/{$p['filename']}" . "({$a}).{$p['extension']}";
			$a++;
		}
		$this->info("URL({$url})からファイルを取得しています...");
		@$tmp = file_get_contents($url);;
		if (!$tmp){
			$this->throwError("URL({$url})からファイルの取得ができませんでした。");
			return false;
		}else{
			$this->info("ファイルに情報を書き込んでいます...");
			$fp = fopen($local_filename, 'w');
			fwrite($fp, $tmp);
			fclose($fp);
			$this->info("\x1b[38;5;83m完了\x1b[38;5;59m:{$local_filename}");
			return true;
		}
	}

	public function generateEvent($name,$to = NULL){
		// $arg_list = func_get_args();
		$f_name = $name . "_event";
		$returns = array();
		if (isset($to)) {
			$class = $to;
			if (method_exists($class,$name)) {
				$obj = new $class;
				$obj->$name();
			}
		}else{
			$declared_classes = get_declared_classes();
			foreach ($declared_classes as $key => $class) {
				// echo $class . "\n";/////////////////////////////////////
				if (method_exists($class,$f_name)) {
					$obj[$key] = new $class;
					// var_dump($obj[$key]);////////////////////////////////
					$returns[] = $obj[$key]->$f_name();
				}
			}
		}
		return $returns;
	}

	public function throwError($txt,$type = "error"){
		$this->sendMessage($txt,$type);
	}

	public function info($pr_disp,$type = "info",$thre = "PHPPO"){
		$this->sendMessage($pr_disp,$type,$thre);
	}

	public function input($pr_disp){
		$input = $this->sendMessage("{$pr_disp}","input");
		return $input;
	}

	public function addlog($pr_disp,$type = "info"){
		global $plugindata;
		$dbg = debug_backtrace();
		// var_dump($dbg);//////////////////////////////
		$obj = get_class($dbg[0]["object"]);
		foreach ($plugindata as $value) {
			if (isset($value["class-object"])) {
				$class = get_class($value["class-object"]);
				if ($class == $obj) {
					$plugin_name = $value["name"];
				}
			}
		}
		$this->sendMessage("\x1b[38;5;227m[{$plugin_name}]\x1b[38;5;231m" . $pr_disp,$type);
	}

	public function sendMessage($pr_disp,$type = "info",$thre = "PHPPO"){
		global $pr_TipeTxt;
		global $pr_thread;
		global $pr_info;
		global $pr_time;
		global $prompt;
		global $writeData;
		global $stanby;
		global $logmode;
		global $tipe_text;
		global $echoFunc;
		global $environmentVariables;
		global $display;
		global $currentdirectory;
		global $poPath;
		global $po_cd;
		global $textformat;
		global $to_textformat;
		global $valuepros;
		global $outprompt;
		global $raw_input;
		$display->setThread($thre);
		$this->generateEvent("sendMessage");
		$prompt = $valuepros->getvalue("prompt");
		date_default_timezone_set('Asia/Tokyo');
		// echo "string";
		// var_dump($display);
		// echo "$repl,$repl2,$prompt";
		// var_dump($repl);
		// var_dump($repl2);

		if ($echoFunc != "off") {
			switch ($type) {
				case 'error':
					$display->setInfo("ERROR");
					$prompt = $valuepros->getvalue("prompt") . "\x1b[38;5;203m";
				break;
				case 'warn':
					$display->setInfo("WARN");
					$prompt = $valuepros->getvalue("prompt") . "\x1b[38;5;214m";
					break;
				case 'notice':
					$display->setInfo("WARN");
					$prompt = $valuepros->getvalue("prompt") . "\x1b[38;5;214m";
					break;
				case 'critical':
					$display->setInfo("CRITICAL");
					$prompt = $valuepros->getvalue("prompt") . "\x1b[38;5;124m";
					break;
				default:
					// $prompt = "\x1b[38;5;83m" . "[{$pr_time}]" . "\x1b[38;5;87m " . "[{$pr_thread}/{$pr_info}]" . "\x1b[38;5;231m";
					$prompt = $valuepros->getvalue("prompt") . "\x1b[38;5;231m";
				break;
			}
		}else{
			switch ($type) {
				case 'error':
					$prompt = "\x1b[38;5;203m";
					break;
				case 'warn':
					$prompt = "\x1b[38;5;214m";
					break;
				case 'critical':
					$prompt = "\x1b[38;5;124m";
					break;
				default:
				$prompt = "\x1b[38;5;231m";
				break;
			}
		}
		$pr_time = date('A-H:i:s');
		$repl = array("%time","%thread","%info","%cd");
		$repl2 = array($pr_time,$pr_thread,$pr_info,$po_cd);
		$repl3 = array($pr_time,$pr_thread,$pr_info,"");
		$inprompt = str_ireplace($repl,$repl2,$prompt);
		$outprompt = str_ireplace($repl,$repl3,$prompt);
		$display->setInfo("INFO");
		$array = explode("\n", $pr_disp);
		// $array = array_map('trim', $array);
		$array = array_filter($array, 'strlen');
		$array = array_values($array);
		if ($type == "input") {
			echo "\x1b[38;5;231m{$inprompt}{$pr_disp}";
			$this->generateEvent("sentMessage");
			$raw_input = trim(fgets(fopen("php://stdin", "r")));
			$input = $this->inputProcessor($raw_input);
			$GLOBALS['sender'] = "phppo.sys.input.default";
			$GLOBALS['sendto'] = "phppo.sys.output.internal";
			return $input;
		}else {
			foreach ($array as $key => $value) {
				echo "\x1b[38;5;231m{$outprompt}{$value}\x1b[38;5;231m\n";
				$this->generateEvent("sentMessage");
				// /ログを吐く
				if ($logmode == "on") {
					if (isset($writeData)){
						if ($stanby) {
						}else{
							@fwrite($writeData,"{$prompt} {$pr_disp}" . PHP_EOL);
						}//てってってれってー
					}//んーでってれってー
				}//てってってれってー
			}//んーでってれってー
		}//てってってれってー
	}//んーでってれってー

	public function inputProcessor($raw_input){
		global $environmentVariables;
		global $savevaluesmode;
		$ary_input = $this->commandProcessor($raw_input);
		$input = "";
		foreach ($ary_input as $key => $value) {
			$input = $input . "{$value} ";
		}
		$input = trim($input);
		if ($savevaluesmode == "on") {
			$environmentVariables = unserialize(file_get_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "environmentVariables.dat"));
		}
		// echo "input :" . $input . PHP_EOL;///////////////////////////////////////////////////
		if (strstr($input, '%')) {
			foreach ($environmentVariables as $key => $value){
				// echo "key:" . $key . PHP_EOL;
				// echo "value:" . $value . PHP_EOL;
				$s_input = str_replace("\"%{$key}%\"","%{$key}%",$input);
				// echo $key . ":" . str_replace("\"%{$key}%\"","%{$key}%",$input) . PHP_EOL;
				// echo $key . ":" . str_replace("%{$key}%",$value,$input) . PHP_EOL;
				if ($s_input == $input) {
					$input = str_replace("%{$key}%",$value,$input);
				}else {
					$input = $s_input;
				}
			}
		}
		return $input;
	}

	public function setSystemStatusMessage($value=""){
		global $system_status_text;
		$system_status_text = $value;
	}

	public function commandProcessor($com){
        $commandarr=array();
        $spaced=false;
        $tokenbegin=0;
        $spacedbegin=0;
        $cuated=false;
        $cuatedbegin=0;
        $ignoreSpace=false;
        $com=trim($com) . " []";
        for ($i = 0; $i < strlen($com); $i++) {
            if (substr($com,$i,1) == "\"") {//走査文字列に"がきたぞ
                if ($cuated == false){
                    $cuatedbegin=$i;
                    $cuated=true;
                    $ignoreSpace=true;
                }else{
                    $cuated = false;//もう"には囲まれてないぞ！
					$ignoreSpace= false;//スペース無視すんなよ！
                }
            }
            if (substr($com,$i,1)==" ") {
                if ($spaced==false){ //すなはちスペースの一回目である
					$spacedbegin=$i;//スペースはじめのインデックス
				}
				$spaced=true;
				if ($ignoreSpace==true){  // スペース無視していいかな？
					$spaced=false;  // このスペースは無視だ！
				}
			}else{
				if ($spaced==true){  //さっきまですぺーすだったよ！
				// 	com1.add(command.substring(tokenbegin,spacedbegin));//トークン始まりからスペース始まりまでをListにぶっこむ
					$addstr = substr($com,$tokenbegin,$spacedbegin-$tokenbegin);
					$addstr = ltrim($addstr,'"');
					$addstr = rtrim($addstr,'"');
				    array_push($commandarr,$addstr);
					$tokenbegin=$i;//ここからトークンがはじまるぞ！
				}
				$spaced=false;//すぺーすではないぞ！
            }
        }
		return $commandarr;
    }

	public function standbyTipe(){
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
		global $title_pros;
		global $term_base_title;
		$scriptcommandpros->readExtension();
		$pluginpros->install();
		$title_pros->setBaseTitle("PHP Prompt OS : %status - %cd");
		// $system->info("\x1b[38;5;63m起動完了！helpコマンドでコマンド一覧を表示。");
		// file_put_contents(dirname(dirname(dirname(__FILE__))) . '\root\bin\\' . "systemdefinedvars.dat", serialize($defined_vars));
		if (isset($systemconf_ini_array["system"]["bootexec"])) {
			if ($systemconf_ini_array["system"]["bootexec"] != "") {
				$bootexec = $systemconf_ini_array["system"]["bootexec"];
				// echo "$poPath\\root\\$bootexec";
				$aryTipeTxt = array("script","$poPath\\root\\$bootexec");
				// var_dump($aryTipeTxt);
				$script = new \phppo\command\defaults\script_command;
				$script->onCommand();
			}
		}

		while (True) {
			$this->generateEvent("readyInputEvent");
			$this->setSystemStatusMessage("ready.");
			// var_dump($defined_vars);
			file_put_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '\root\bin\\' . "systemdefinedvars.dat", serialize($defined_vars));
			$po_cd = str_replace(trim($poPath),"",trim($currentdirectory));
			$stanby = True;
			$display->setThread("PHPPO");

			// $prompt = "\x1b[38;5;83m[{$pr_time}] \x1b[38;5;87m[{$pr_thread}/{$pr_info}]\x1b[38;5;207m{$po_cd}\x1b[38;5;227m>";
			// if ($echoFunc != "off") {
			// 	echo "\x1b[38;5;83m" . $prompt . "\x1b[38;5;227m";
			// }else {
			// 	echo "\x1b[38;5;227m";
			// }

			$tipe_text = $system->input("\x1b[38;5;227m>");
			$stanby = false;
			if ($logmode == 1) {
				fwrite($writeData,PHP_EOL . $tipe_text);
			}
			if(strpos($tipe_text,';') !== false){
				$arytipetxts = explode(";",$tipe_text);
				foreach ($arytipetxts as $key => $value) {
					$tipe_text = trim($value);
					$onerror = $commandpros->runCommand();
				}
			}else {
				if(strpos($tipe_text,'&&') !== false){
					$arytipetxts = explode("&&",$tipe_text);
					foreach ($arytipetxts as $key => $value) {
						$tipe_text = trim($value);
						$onerror = $commandpros->runCommand();
						if (!$onerror) {
							break;
						}
					}
				}else {
					$onerror = $commandpros->runCommand();
				}
			}
			// echo $onerror;
		}
	}


}//てってってれってー by @KOKKOKOKOKOOKO

class myPhar extends systemProcessing{

	function __construct(){
		# code...
	}
	public function compose($dir,$phar_name){

		$fileclass = new fileProcessing;
		$result = $fileclass->list_files($dir);
		var_dump($result);
		foreach ($result as $path) {
			$this->info("ファイルをスキャン中... : $path");
		}
		$pharfilepath = rtrim(dirname(__FILE__),"commands\src\PHPPO") . "\\" . "$phar_name.phar";
		$phar = new Phar($pharfilepath, 0);
		if (!file_exists($pharfilepath)) {
			$this->info("pharファイルを生成しています。:" . $pharfilepath);
			touch($pharfilepath);
			$this->info("pharファイルを生成しました。:" . $pharfilepath);
		}
		chmod( $pharfilepath, 0666 );
		foreach ($result as $path) {
			$this->info("ファイルを追加しています... : $path");
			$phar->addFile($path);
		}
		$this->info("pharを作成しました。 : $pharfilepath");
	}

}

class fileProcessing extends systemProcessing{

	function __construct()
	{
		# code...
	}
	public function list_files($dir){
		$list = array();
		$files = scandir($dir);
		foreach($files as $file){
			if($file == '.' || $file == '..'){
				continue;
			} else if (is_file($dir . $file)){
				$list[] = $dir . $file;
			} else if( is_dir($dir . $file) ) {
				//$list[] = $dir;
				$list = array_merge($list, list_files($dir . $file . DIRECTORY_SEPARATOR));
			}
		}
		return $list;
	}
}
