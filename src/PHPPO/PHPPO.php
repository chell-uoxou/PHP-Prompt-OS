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
echo "Library loaded!\nPHP Prompt OS booting...\n";

$first_time_boot = !file_exists(rtrim(dirname(__FILE__),"\PHPPO\src") . "\\root\bin\\" . 'systemdefinedvars.dat');
include_once "system/System.php";
include_once 'event/event.php';
$display = new display;
$system = new systemProcessing;
$system->setSystemStatusMessage("Booting...");
include_once 'display/display.php';
include_once 'command/Command.php';
include_once 'plugin/Manager.php';
include_once 'system/environmentValues.php';
include_once 'system/currentdirectory.php';
include_once 'system/Boot.php';
