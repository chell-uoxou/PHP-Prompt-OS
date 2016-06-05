@echo off
TITLE PHP Prompt OS launcher
cd /d %~dp0
start "" bin\mintty.exe -o Columns=88 -o Rows=32 -o AllowBlinking=0 -o FontQuality=10 -o Font="Lucida Sans Typewriter" -o FontHeight=11 -o CursorType=0 -o CursorBlinks=1 -h error -t "PHP Prompt OS" -w max /bin/php7/php.exe src/PHPPO/PHPPO.php --enable-ansi %*

