<?php

/**
 *
 */
class currentdirectory extends AnotherClass{
	function __construct(){
		global $currentdirectory;
		global $poPath;
		$currentdirectory = $poPath;
	}
}
