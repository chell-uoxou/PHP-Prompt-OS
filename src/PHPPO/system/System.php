<?php
include_once dirname(__FILE__) . '/../display/display.php';
include_once dirname(__FILE__) . '/../plugin/Manager.php';
include_once 'environmentValues.php';
include_once 'currentdirectory.php';
// include_once 'Boot.php';
$valuepros = new environmentVariables;
$pluginpros = new pluginManager;
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
	//   $f = @fopen($fname,'rb') or $this->sendMessage("※ファイルを開く際にエラーが発生しました。");
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
			$this->sendMessage("ディレクトリ({$dir})が存在しません。");}
		$dir = preg_replace("{/$}","",$dir);
		$p = pathinfo($url);
		$local_filename = '';
		if ( $save_base_name ){ $local_filename = "{$dir}/{$save_base_name}.{$p['extension']}"; }
		else{ @$local_filename = "{$dir}/{$p['filename']}.{$p['extension']}"; }
		if ( is_file( $local_filename ) ){$this->sendMessage("すでにファイル({$local_filename})が存在します。","error");}else {
			$this->sendMessage("URL({$url})からファイルを取得しています...");
			@$tmp = file_get_contents($url);
			if (! $tmp){ $this->sendMessage("URL({$url})からファイルの取得ができませんでした。","error");}else {
				$this->sendMessage("ファイルに情報を書き込んでいます...");
				$fp = fopen($local_filename, 'w');
				fwrite($fp, $tmp);
				fclose($fp);
				$this->sendMessage("\x1b[38;5;83m完了\x1b[38;5;59m:{$local_filename}");
			}
		}
	}




	public function sendMessage($pr_disp,$type = "info"){
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
		$display = new display;
		date_default_timezone_set('Asia/Tokyo');
		// echo "string";
		// var_dump($display);
		$pr_time = date('A-H:i:s');

		if ($echoFunc != "off") {
			switch ($type) {
				case 'error':
					$display->setInfo("ERROR");
					$prompt = "\x1b[38;5;83m" . "[{$pr_time}]" . "\x1b[38;5;87m " . "[{$pr_thread}/{$pr_info}]" . "\x1b[38;5;203m";
					$display->setInfo("INFO");
				break;
				case 'warn':
					$display->setInfo("WARN");
					$prompt = "\x1b[38;5;83m" . "[{$pr_time}]" . "\x1b[38;5;87m " . "[{$pr_thread}/{$pr_info}]" . "\x1b[38;5;214m";
					$display->setInfo("INFO");
					break;
				case 'critical':
					$display->setInfo("CRITICAL");
					$prompt = "\x1b[38;5;83m" . "[{$pr_time}]" . "\x1b[38;5;87m " . "[{$pr_thread}/{$pr_info}]" . "\x1b[38;5;124m";
					$display->setInfo("INFO");
					break;
				default:
					$prompt = "\x1b[38;5;83m" . "[{$pr_time}]" . "\x1b[38;5;87m " . "[{$pr_thread}/{$pr_info}]" . "\x1b[38;5;231m";
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
		$array = explode("\n", $pr_disp);
		// $array = array_map('trim', $array);
		$array = array_filter($array, 'strlen');
		$array = array_values($array);
		if ($type == "input") {
			echo "{$prompt}{$pr_disp}";
			$input = trim(fgets(fopen("php://stdin", "r")));
			return $input;
		}else {
			foreach ($array as $key => $value) {
				echo "{$prompt}{$value}\n";
				///ログを吐く
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
}//てってってれってー by @KOKKOKOKOKOOKO

/**
*
*/
class myPhar extends systemProcessing{

	function __construct(){
		# code...
	}
	public function compose($dir,$phar_name){

		$fileclass = new fileProcessing;
		$result = $fileclass->list_files($dir);
		var_dump($result);
		foreach ($result as $path) {
			$this->sendMessage("ファイルをスキャン中... : $path");
		}
		$pharfilepath = rtrim(dirname(__FILE__),"commands\src\PHPPO") . "\\" . "$phar_name.phar";
		$phar = new Phar($pharfilepath, 0);
		if (!file_exists($pharfilepath)) {
			$this->sendMessage("pharファイルを生成しています。:" . $pharfilepath);
			touch($pharfilepath);
			$this->sendMessage("pharファイルを生成しました。:" . $pharfilepath);
		}
		chmod( $pharfilepath, 0666 );
		foreach ($result as $path) {
			$this->sendMessage("ファイルを追加しています... : $path");
			$phar->addFile($path);
		}
		$this->sendMessage("pharを作成しました。 : $pharfilepath");
	}

}



/**
*
*/
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
