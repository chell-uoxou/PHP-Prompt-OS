@echo off
TITLE PHP Prompt OS launcher
cd /d %~dp04
if exist bin\php7\php.exe (
	start bin\mintty.exe -o Columns=88 -o Rows=32 -o AllowBlinking=0 -o FontQuality=10 -o Font="Lucida Sans Typewriter" -o FontHeight=11 -o CursorType=0 -o CursorBlinks=1 -h error -t "PHP Prompt OS" -w max /bin/php7/php.exe src/PHPPO/PHPPO.php --with-readline %*
) else (
	echo Did you install "PHP-binary"?
	echo You must download it from https://github.com/chell-uoxou/PHP-Binaries and put on "bin" directory it.
	pause
)
