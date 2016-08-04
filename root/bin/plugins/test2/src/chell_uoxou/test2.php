<?php
namespace test2;
use phppo\system\systemProcessing as systemProcessing;
/**
 *
 */
class Test2Command extends systemProcessing{

	function __construct(){
		# code...
	}
	function onload(){
		$this->info("二つ目のテストのプラグインが読み込まれたよ！？\n[onLoad]っていうイベントの取得だよ！？");
	}
	function onCommand(){
		$this->info("[Test2plugin]二つ目のテストプラグインでコマンドが実行されたみたいだよ！？[onCommand]っていうイベントの取得だよ！？");
	}
}
