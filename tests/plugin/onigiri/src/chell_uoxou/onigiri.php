<?php
namespace onigiri;
use phppo\system\systemProcessing as systemProcessing;
use phppo\command\plugincommand\addcommand as addcommand;
$pluginAddCommand = new addcommand;
$pluginAddCommand -> addcommand("OnigiriPlugin","onigiri","plugin","ｵﾆｷﾞﾘﾜｯｼｮｲ");
/**
 *
 */
class onigiri extends systemProcessing{

	function __construct(){
		# code...
	}

	function onLoad(){
		$this->addlog("ｵﾆｷﾞﾘﾜｯｼｮｲ!!!!!!!!!!!!!!!!!!!!!!!!!");
	}

	function onCommand(){
		global $aryTipeTxt;
		if (!isset($aryTipeTxt[1])) {
			$this->addlog("おいしいおにぎり");
		}else {
			$to_onigiri = $aryTipeTxt[1];
			$this->addlog("{$to_onigiri}においしいおにぎり");
		}
	}
}
