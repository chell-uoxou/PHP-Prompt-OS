<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("info","default","当プログラムに関しての情報を表示。","<logo|auther|des|help|url|>");
//////////////////////
/**
 *
 */
class info extends systemProcessing{

	function __construct()
	{
		# code...
	}
	public function onCommand()
	{
		global $aryTipeTxt;
		$messageCount = count($aryTipeTxt);
	    if ($messageCount <= 1) {
			$this->sendMessage("PHP Prompt OS (PHPPO) version 1.0.0");
			$this->sendMessage("Copyright by chell rui @2015");
	  	}else{
	  		$aryTipeTxt[1] = trim($aryTipeTxt[1]);
	  		$message = '';
	  		for ($i=1; $i < $messageCount; $i++) {
	  			$message .= $aryTipeTxt[$i] . "";
	  		}
			switch ($aryTipeTxt[1]) {
				case 'logo':
					exec(rtrim(dirname(__FILE__),"\src\PHPPO") . "\\" . "logo.jpg");
					break;
				case 'auther':
					$this->sendMessage("PHP Prompt OS、およびPHPPOの作成者はchell ruiです。");
					$this->sendMessage("Twitter:@chell_uoxou");
					break;
				case 'help':
					$this->sendMessage("infoコマンドの使用方法:");
					$this->sendMessage("info <logo|auther|des|help|url>");
					$this->sendMessage("logo:PHP Prompt OS のロゴを既定の画像ビューアーで表示します。");
					$this->sendMessage("auther:PHP Prompt OS の作成者の情報を表示します。");
					$this->sendMessage("des:PHP Prompt OSの情報を表示します。");
					$this->sendMessage("help:コマンドの使用方法を表示します。");
					$this->sendMessage("url:PHP Prompt OSのページのURLを表示します。アップデートの確認はこちらでお願いします。");
					break;
				case 'url':
					$this->sendMessage("PHP Prompt OSのページです。アップデートの確認はこちらでお願いします。");
					$this->sendMessage("https://chellruibox.wordpress.com/php-prompt-os/");
					break;
				case 'des':
					$this->sendMessage(" PHP Prompt OSは、chell ruiによって作られたコンソール風のPHPスクリプトです。");
					$this->sendMessage(" カイヌシ(chell rui)がPHPの勉強をするために作られました。");
					$this->sendMessage(" 今後機能を追加していく予定なのですが、一般、または企業に対して利益のある活動ではありません。");
					$this->sendMessage(" PHP Prompt OS は、現段階でPHP版のカイヌシを中心としたプロジェクトとして進行しており、現段階ではプログラミング言語のHot Soop Processor 3、Javaを利用した互換プログラムも同時に開発が進められています。");
					$this->sendMessage(" 開発者は、現在三名です。PHP版は主にchell ruiが担当しております。その他の担当は、公式Google Plusコミュニティーをご確認ください。また、開発者を募集しておりますので、興味がわいた方はぜひコミュニティにて参加の希望を表明してください。但し、当プロジェクトは現段階では非営利で活動しているため、開発者に利益はございません。");
					$this->sendMessage(" ロゴは、chell ruiによるものです。");
					break;
				default:
					break;
			}
		}
	}
}

?>
