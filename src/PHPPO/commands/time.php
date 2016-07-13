<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("time","secret","コンピューターに設定されている時刻を表示。","");
//////////////////////
/**
 *
 */
class time_command extends systemProcessing{

	function __construct()
	{
		# code...
	}
	public function onCommand(){
		date_default_timezone_set('Asia/Tokyo');
		$ampm = "";
		// echo date('a');
		if (date("a") == "am") {
			$ampm = "午前";
		}else {
			if (date("a") == "pm") {
				$ampm = "午後";
			}
		}
		$this->sendMessage($ampm . date("H時i分s秒"));
		$this->sendMessage(date(""));
	}
}

?>
