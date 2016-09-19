<?php
use Aura\Intl\TranslatorLocatorFactory;
use Aura\Intl\Package;
if (class_exists("Aura\Intl\TranslatorLocatorFactory")) {
	$factory = new TranslatorLocatorFactory();
}else{
	$system->throwError("Composer didn't load \"Aura\Intl\TranslatorLocatorFactory\" library!","critical");
	$system->info("Aborting...");
	exit(1);
}
$translators = $factory->newInstance();

// get the package locator
$packages = $translators->getPackages();

// $files = array(
// 	'en_US/PO.System.Plugin.Package.php',
// 	'ja_JP/PO.System.Plugin.Package.php'
// );
//
// foreach ($files as $value) {
// 	echo $poPath . "/src/PHPPO/languages/" . $value . PHP_EOL;
// 	include($poPath . "/src/PHPPO/languages/" . $value);
// }

// place into the locator for Vendor.Package
$packages->set('PO.System.Plugin.Package', 'en_US', function() {
    // create a US English message set
    $package = new Package;
    $package->setMessages([
        'loading' => 'loading...',
        'classNotFound' => 'Class Not Found.',
		'CantLoad' => 'Failed to load plugin',
		'commandEnabled' => 'Command enabled',
    ]);
    return $package;
});

// place into the locator for a Vendor.Package
$packages->set('PO.System.Plugin.Package', 'ja_JP', function() {
    // a Brazilian Portuguese message set
    $package = new Package;
    $package->setMessages([
        'loading' => 'を読み込み中...',
        'classNotFound' => 'クラスが見つかりません。',
		'CantLoad' => 'プラグインの読み込みに失敗しました。',
		'commandEnabled' => '有効化されたコマンド',
    ]);
    return $package;
});
$let_lang = trim($systemconf_ini_array["lang"]["sysLang"]);
$translators->setLocale($let_lang);
?>
