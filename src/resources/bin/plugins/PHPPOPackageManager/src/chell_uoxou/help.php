<?php
namespace ppm;

use ppm\ascii_art;

class helpCommand extends main{

	public function display(){
		$ascii_art = new ascii_art;
		$this->info($ascii_art->getData("title_color"));
		$this->info("\n");
		$this->info("
\x1b[38;5;227mUsage:
	ppm [command] [option] [arguments]");
	$this->info("\n");
		$this->info("
\x1b[38;5;227mOptions:
	\x1b[38;5;34m-t=\x1b[38;5;214m<package type>    \x1b[38;5;145m: Set package type
	\x1b[38;5;34m-h      -?           \x1b[38;5;145m: Display this help message
");
	$this->info("\n");
		$this->info("
\x1b[38;5;227mAvailable commands:
	\x1b[38;5;34mabout         \x1b[38;5;145mShort information about PHPPO Package Manager
	\x1b[38;5;34mhelp          \x1b[38;5;145mDisplays help for a command
	\x1b[38;5;34minstall       \x1b[38;5;145mStart install a package
	\x1b[38;5;34msearch        \x1b[38;5;145mSearch packages from keywords
");
	}
	function about(){
		$this->info("
	 \x1b[38;5;59m/\x1b[38;5;214m$$$$$$$  \x1b[38;5;59m/\x1b[38;5;214m$$$$$$$\x1b[38;5;59m  /\x1b[38;5;214m$$     \x1b[38;5;59m /\x1b[38;5;214m$$
	\x1b[38;5;59m| \x1b[38;5;214m$\$\x1b[38;5;59m__  \x1b[38;5;214m$$\x1b[38;5;59m|\x1b[38;5;214m $\$\x1b[38;5;59m__ \x1b[38;5;214m $$\x1b[38;5;59m| \x1b[38;5;214m$$$   \x1b[38;5;59m /\x1b[38;5;214m$$$\x1b[38;5;34m PHP Prompt OS
	\x1b[38;5;59m| \x1b[38;5;214m$$ \x1b[38;5;59m \ \x1b[38;5;214m$$\x1b[38;5;59m| \x1b[38;5;214m$$ \x1b[38;5;59m \ \x1b[38;5;214m$$\x1b[38;5;59m| \x1b[38;5;214m$$$$ \x1b[38;5;59m /\x1b[38;5;214m$$$$  \x1b[38;5;34m   Package
	\x1b[38;5;59m| \x1b[38;5;214m$$$$$$$/\x1b[38;5;59m| \x1b[38;5;214m$$$$$$$\x1b[38;5;59m/| \x1b[38;5;214m$$ $$\x1b[38;5;59m/\x1b[38;5;214m$$ $$ \x1b[38;5;34m        Manager \x1b[38;5;87mversion $this->ppmversion
	\x1b[38;5;59m| \x1b[38;5;214m$$\x1b[38;5;59m____/ \x1b[38;5;59m| \x1b[38;5;214m$\$\x1b[38;5;59m____/ \x1b[38;5;214m\x1b[38;5;59m| \x1b[38;5;214m$$  $$$\x1b[38;5;59m|\x1b[38;5;214m $$\x1b[38;5;145m Made by chell-uoxou
	\x1b[38;5;59m|\x1b[38;5;214m $$      \x1b[38;5;59m| \x1b[38;5;214m$$      \x1b[38;5;59m|\x1b[38;5;214m $$\x1b[38;5;59m\  \x1b[38;5;214m$ \x1b[38;5;59m| \x1b[38;5;214m$$\x1b[38;5;145m
	\x1b[38;5;59m|\x1b[38;5;214m $$      \x1b[38;5;59m| \x1b[38;5;214m$$      \x1b[38;5;59m|\x1b[38;5;214m $$\x1b[38;5;59m \/  \x1b[38;5;59m| \x1b[38;5;214m$$\x1b[38;5;145m To automate the installation of the package.
	\x1b[38;5;59m|__/      |__/      |__/     |__/
			");
		$this->info("		PHPPO Plugin Manager is a system to automate
		the installation of the package,such as
		plugins and applications of PHPPO.");
	}
	function onCommand(){
		$this->info("
\x1b[38;5;227mUsage:
	ppm [command] [option] [arguments]");
	$this->info("\n");
		$this->info("
\x1b[38;5;227mOptions:
	\x1b[38;5;34m-t=\x1b[38;5;214m<package type>    \x1b[38;5;145m: Set package type
	\x1b[38;5;34m-h      -?           \x1b[38;5;145m: Display this help message
");
	$this->info("\n");
		$this->info("\x1b[38;5;227m
Available commands:
	\x1b[38;5;34mabout         \x1b[38;5;145mShort information about PHPPO Package Manager
	\x1b[38;5;34mhelp          \x1b[38;5;145mDisplays help for a command
	\x1b[38;5;34minstall       \x1b[38;5;145mStart install a package
	\x1b[38;5;34msearch        \x1b[38;5;145mSearch packages from keywords
");
	}
}
