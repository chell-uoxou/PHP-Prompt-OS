echo 変数「a」を作ります。
wait 2000
echo コマンドは、「set a 20」です。
wait 2000
echo この場合は変数「a」に値「20」が代入されます。
wait 2000
echo 実行します。
echo -
set a 20
echo -
wait 1000
echo 実行しました。次に、変数が代入されたことを確認します。
wait 2000
echo 変数の内容を確認するには、「echo」コマンドの永続引数に小文字のパーセントマーク（％）で変数名を囲い、記入します。
wait 3000
echo コマンドは、「echo 変数[a]は、％a％です。」です。
wait 2000
echo この場合、echo 引数内の「％a％」が代入されている値に置換されます。
wait 2000
echo 実行します。
echo -
echo 変数[a]は、%a%です。
echo -
wait 1000
echo 実行しました。
wait 1000
echo 現在実装されている環境変数として、[time]変数があります。
wait 2000
echo これを記入することで、システムの時刻が置換されます。
wait 2000
echo コマンドは、「echo ただ今の時刻は、％time％です。」です。
wait 2000
echo この場合、echo引数上の％time％部がシステム内部時刻に置換されます。
wait 2000
echo 実行します。
echo -
echo ただ今の時刻は、%time%です。
echo -
wait 1000
echo 実行しました。
wait 1000
echo 定義された変数手動で見る場合は、「vars」コマンドを入力してご確認ください。
