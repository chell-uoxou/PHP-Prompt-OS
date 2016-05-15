<?php
//検索するフォルダ
$dir = dirname(__FILE__);
print_r($dir);
$result = list_files($dir);
print_r($result);

function list_files($dir){
    $list = array();
    $files = scandir($dir);
	print_r($files);
    foreach($files as $file){
        if($file == '.' || $file == '..'){
            continue;
        } else if (is_file($dir . $file)){
            $list[] = $dir . $file;
        } else if( is_dir($dir . $file) ) {
            //$list[] = $dir;
            $list = array_merge($list, list_files($dir . $file . DIRECTORY_SEPARATOR));
        }
    }
	return $list;
}
