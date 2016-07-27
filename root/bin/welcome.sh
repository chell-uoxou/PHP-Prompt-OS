# reboot
set welcome.defvalue.currentdirectory %currentdirectory%
cd .
set yeah %currentdirectory%
echo Welcome to PHPPO! Type "help" for help.
# echo %currentdirectory%
# echo %welcome.defvalue.currentdirectory%
cd %welcome.defvalue.currentdirectory%
delvar welcome.defvalue.currentdirectory
# echo コメントアウトを外さない限りこの文章は表示されません。
