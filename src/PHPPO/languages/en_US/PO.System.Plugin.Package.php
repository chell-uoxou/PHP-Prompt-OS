<?php
use Aura\Intl\Package;
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
?>
