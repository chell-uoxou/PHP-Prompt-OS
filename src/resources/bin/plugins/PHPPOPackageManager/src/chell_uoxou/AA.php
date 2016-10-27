<?php
namespace ppm;

use ppm\main;

class ascii_art extends main{

	function __construct(){
		$this->create_datas();
	}

	public function create_datas(){
		$this->title_color = "
	\x1b[38;5;59m /\x1b[38;5;214m$$$$$$$  \x1b[38;5;59m/\x1b[38;5;214m$$$$$$$\x1b[38;5;59m  /\x1b[38;5;214m$$     \x1b[38;5;59m /\x1b[38;5;214m$$
	\x1b[38;5;59m| \x1b[38;5;214m$\$\x1b[38;5;59m__  \x1b[38;5;214m$$\x1b[38;5;59m|\x1b[38;5;214m $\$\x1b[38;5;59m__ \x1b[38;5;214m $$\x1b[38;5;59m| \x1b[38;5;214m$$$   \x1b[38;5;59m /\x1b[38;5;214m$$$\x1b[38;5;34m PHP Prompt OS
	\x1b[38;5;59m| \x1b[38;5;214m$$ \x1b[38;5;59m \ \x1b[38;5;214m$$\x1b[38;5;59m| \x1b[38;5;214m$$ \x1b[38;5;59m \ \x1b[38;5;214m$$\x1b[38;5;59m| \x1b[38;5;214m$$$$ \x1b[38;5;59m /\x1b[38;5;214m$$$$  \x1b[38;5;34m   Package
	\x1b[38;5;59m| \x1b[38;5;214m$$$$$$$/\x1b[38;5;59m| \x1b[38;5;214m$$$$$$$\x1b[38;5;59m/| \x1b[38;5;214m$$ $$\x1b[38;5;59m/\x1b[38;5;214m$$ $$ \x1b[38;5;34m        Manager \x1b[38;5;87mversion $this->ppmversion
	\x1b[38;5;59m| \x1b[38;5;214m$$\x1b[38;5;59m____/ \x1b[38;5;59m| \x1b[38;5;214m$\$\x1b[38;5;59m____/ \x1b[38;5;214m\x1b[38;5;59m| \x1b[38;5;214m$$  $$$\x1b[38;5;59m|\x1b[38;5;214m $$\x1b[38;5;145m Made by chell-uoxou
	\x1b[38;5;59m|\x1b[38;5;214m $$      \x1b[38;5;59m| \x1b[38;5;214m$$      \x1b[38;5;59m|\x1b[38;5;214m $$\x1b[38;5;59m\  \x1b[38;5;214m$ \x1b[38;5;59m| \x1b[38;5;214m$$\x1b[38;5;145m
	\x1b[38;5;59m|\x1b[38;5;214m $$      \x1b[38;5;59m| \x1b[38;5;214m$$      \x1b[38;5;59m|\x1b[38;5;214m $$\x1b[38;5;59m \/  \x1b[38;5;59m| \x1b[38;5;214m$$\x1b[38;5;145m To automate the installation of the package.
	\x1b[38;5;59m|__/      |__/      |__/     |__/";
	}

	public function getData($name=''){
		if(isset($this->$name)){
			return $this->$name;
		}
	}
}
