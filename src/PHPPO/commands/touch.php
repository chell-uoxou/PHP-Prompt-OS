<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("touch","default","ファイルを生成します。","<path>");
//////////////////////
class touch_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $raw_input;
		global $currentdirectory;
		$path = $currentdirectory . "\\" . substr($raw_input,6);
		$badstr = array('\\','/','?','<','>','"','|',':');
		$cant = false;
		foreach ($badstr as $key => $value) {
			if(strpos($path,$value) !== false){
				$this->throwError("ファイル名に使用できない文字列(\ / : * ? \" < > |)が含まれています。");
				$cant = true;
				break;
			}
		}
		if (!$cant) {
					touch($path);
		}
		// $this->info("");
	}
}


?>
