@echo off
TITLE PHP Prompt OS launcher
cd /d %~dp0
if exist bin\php7\php.exe (
	set PHP_BINARY=bin\php7\php.exe
) else (
	set PHP_BINARY=php
)

if exist PHPPO.pha (
	set PHPPO_FILE=PHPPO.phar
) else (
		if exist src\PHPPO\PHPPO.php (
		set PHPPO_FILE=src\PHPPO\PHPPO.php
	) else (
		echo "Couldn't find a valid PHP Prompt OS installation"
		pause
		exit 1
	)
)


if exist bin\php\php_wxwidgets.dll (
	%PHP_BINARY% %PHPPO_FILE% --enable-gui %*
) else (
	if exist bin\mintty.exe (
		start "" bin\mintty.exe -o Columns=88 -o Rows=32 -o AllowBlinking=0 -o FontQuality=3 -o Font="Lucida Sans Typewriter" -o FontHeight=11 -o CursorType=0 -o CursorBlinks=1 -h error -t "PHP Prompt OS" -w max %PHP_BINARY% %PHPPO_FILE% --enable-ansi %*
	) else (
		%PHP_BINARY% -c bin\php %PHPPO_FILE% %1%
		pause
		thank you for using PHP Prompt OS!
		pause
		exit
	)
)
