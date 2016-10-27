<?php
echo "Welcome to PHP Prompt OS." . PHP_EOL;
echo "Installing..." . PHP_EOL;
$poPath = dirname(dirname(dirname(dirname(__FILE__))));
echo "Configure the root..." . PHP_EOL;
echo "Preparing..." . PHP_EOL;
sleep(1);
$Install_dir_path_array = array(
	"/root",
	'/root/$Trash',
	"/root/bin",
	"/root/bin/addcommands",
	"/root/bin/interchangeable",
	"/root/bin/plugins",
	"/root/bin/plugins/PHPPOPackageManager",
	"/root/bin/plugins/PHPPOPackageManager/src",
	"/root/bin/plugins/PHPPOPackageManager/src/chell_uoxou",
	"/root/home",
	"/root/home/logs",
	"/root/plugins",
	"/root/scripts",
	"/root/scripts/samples",
);

$Install_file_path_array = array(
	"/root/bin/addcommands/re.sh" => "/src/resources/bin/addcommands/re.sh",
	"/root/bin/interchangeable/cls.sh" => "/src/resources/bin/interchangeable/cls.sh",
	"/root/bin/interchangeable/setvalue.sh" => "/src/resources/bin/interchangeable/setvalue.sh",
	"/root/bin/interchangeable/stop.sh" => "/src/resources/bin/interchangeable/stop.sh",
	"/root/bin/extension_description.ini" => "/src/resources/bin/extension_description.ini",
	"/root/bin/extensions.ini" => "/src/resources/bin/extensions.ini",
	"/root/bin/user.json" => "/src/resources/bin/user.json",
	"/root/bin/welcome.sh" => "/src/resources/bin/welcome.sh",
	"/root/bin/environmentVariables.dat" => "",
	"/root/bin/systemconfig.dat" => "",
	"/root/onigiri.sh" => "/src/resources/onigiri.sh",
	"/root/bin/plugins/PHPPOPackageManager/plugin.yml" => "/src/resources/bin/plugins/PHPPOPackageManager/plugin.yml",
	"/root/bin/plugins/PHPPOPackageManager/README.md" => "/src/resources/bin/plugins/PHPPOPackageManager/README.md",
	"/root/bin/plugins/PHPPOPackageManager/src/chell_uoxou/AA.php" => "/src/resources/bin/plugins/PHPPOPackageManager/src/chell_uoxou/AA.php",
	"/root/bin/plugins/PHPPOPackageManager/src/chell_uoxou/help.php" => "/src/resources/bin/plugins/PHPPOPackageManager/src/chell_uoxou/help.php",
	"/root/bin/plugins/PHPPOPackageManager/src/chell_uoxou/install.php" => "/src/resources/bin/plugins/PHPPOPackageManager/src/chell_uoxou/install.php",
	"/root/bin/plugins/PHPPOPackageManager/src/chell_uoxou/main.php" => "/src/resources/bin/plugins/PHPPOPackageManager/src/chell_uoxou/main.php",
	"/root/bin/plugins/PHPPOPackageManager/src/chell_uoxou/search.php" => "/src/resources/bin/plugins/PHPPOPackageManager/src/chell_uoxou/search.php",
	"/root/bin/plugins/PHPPOPackageManager/src/chell_uoxou/setuper.php" => "/src/resources/bin/plugins/PHPPOPackageManager/src/chell_uoxou/setuper.php",
);

foreach ($Install_dir_path_array as $value) {
	$installPath = $poPath . $value;
	if( !is_dir($installPath) ){
		mkdir( $installPath );
		echo "Created directory : {$installPath}" . PHP_EOL;
	}else{
		echo "Directory exists : {$installPath}" . PHP_EOL;
	}
	usleep(10000);
}

foreach ($Install_file_path_array as $key => $value) {
	$installPath = $poPath . $key;
	$resourcePath = $poPath . $value;
	if( !is_file($installPath) ){
		touch($installPath);
		echo "Created File : {$installPath}" . PHP_EOL;
		if ($value != "") {
			$contents = file_get_contents($resourcePath);
			file_put_contents($installPath,$contents);
			echo "Contents copied." . PHP_EOL;
		}
	}else{
		echo "File exists : {$installPath}" . PHP_EOL;
	}
}
echo "Setup finished." . PHP_EOL;
fgets(STDIN);
