<?php


/*
*   :::::::::  :::    ::: :::::::::  :::::::::   ::::::::
*   :+:    :+: :+:    :+: :+:    :+: :+:    :+: :+:    :+:  PHP Prompt OS
*   +:+    +:+ +:+    +:+ +:+    +:+ +:+    +:+ +:+    +:+     made by chell rui.
*   +#++:++#+  +#++:++#++ +#++:++#+  +#++:++#+  +#+    +:+
*   +#+        +#+    +#+ +#+        +#+        +#+    +#+
*   #+#        #+#    #+# #+#        #+#        #+#    #+#
*   ###        ###    ### ###        ###         ########
* @author chell rui
*/
namespace phppo;

use phppo\system\systemProcessing as systemProcessing;
use phppo\display\title\terminal_title;
use phppo;
define(THIS_PATH, dirname(dirname(dirname(__FILE__))));


echo THIS_PATH;
include_once THIS_PATH . "/src/AutoLoader/AutoLoader.php";

$autoLoader = new \AutoLoader\AutoLoader();
$autoLoader->registerDir(THIS_PATH.'/src/PHPPO');
$autoLoader->register();

$s = new PHPPromptOS();

echo "Library loaded!\nPHP Prompt OS booting...\n";
include_once "system/System.php";
include_once 'event/event.php';
$system->setSystemStatusMessage("Booting...");
include_once 'display/display.php';
include_once 'command/Command.php';
include_once 'plugin/Manager.php';
include_once 'system/environmentValues.php';
include_once 'system/currentdirectory.php';
include_once 'system/Boot.php';
