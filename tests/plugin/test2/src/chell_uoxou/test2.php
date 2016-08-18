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
		$this->addlog("二つ目のテストのプラグインが読み込まれたよ！？");
		$this->addlog("[onLoad]っていうイベントの取得だよ！？");
	}
	function onCommand(){
		$this->addlog("二つ目のテストプラグインでコマンドが実行されたみたいだよ！？[onCommand]っていうイベントの取得だよ！？");
	}
}
