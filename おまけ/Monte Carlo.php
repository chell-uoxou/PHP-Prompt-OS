<?php
echo "回数指定:";
$samples = trim(fgets(STDIN)); // 試行回数を設定
new Sample($samples);

class Sample {
    protected $test = 0; // 試行回数
    protected $j = 0;
    protected $in_circle = 0; // 円の内部だった回数
    function __construct($num) {
        $this->test = $num;
        for ($j=0;$j<$num;$j++) {
            $this->getRandomPoint();
        }
    echo $this->in_circle/$this->test*4; // 円の内側÷全体×4
    echo PHP_EOL;
    }

    // randomFloatは、
    // http://php.net/manual/ja/function.mt-getrandmax.php より引用
    protected function randomFloat($min = 0, $max = 1) {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }

    // x座標、y座標を0から1の範囲でランダムに設定し、円の内部かどうかを判定する
    protected function getRandomPoint() {
        $x = $this->randomFloat();
        $y = $this->randomFloat();
        $distance = $x*$x + $y*$y ;
        echo "($this->j)x=$x, y=$y, distance=$distance";
        // (0,0)からの距離が1未満 -> 円の内部
        if ( $distance < 1*1 ) {
            $this->in_circle++;
            echo ", True";
        }
        echo PHP_EOL;
    }
}
$a = trim(fgets(STDIN));
