<?php
echo "�񐔎w��:";
$samples = trim(fgets(STDIN)); // ���s�񐔂�ݒ�
new Sample($samples);

class Sample {
    protected $test = 0; // ���s��
    protected $j = 0;
    protected $in_circle = 0; // �~�̓�����������
    function __construct($num) {
        $this->test = $num;
        for ($j=0;$j<$num;$j++) {
            $this->getRandomPoint();
        }
    echo $this->in_circle/$this->test*4; // �~�̓������S�́~4
    echo PHP_EOL;
    }

    // randomFloat�́A
    // http://php.net/manual/ja/function.mt-getrandmax.php �����p
    protected function randomFloat($min = 0, $max = 1) {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }

    // x���W�Ay���W��0����1�͈̔͂Ń����_���ɐݒ肵�A�~�̓������ǂ����𔻒肷��
    protected function getRandomPoint() {
        $x = $this->randomFloat();
        $y = $this->randomFloat();
        $distance = $x*$x + $y*$y ;
        echo "($this->j)x=$x, y=$y, distance=$distance";
        // (0,0)����̋�����1���� -> �~�̓���
        if ( $distance < 1*1 ) {
            $this->in_circle++;
            echo ", True";
        }
        echo PHP_EOL;
    }
}
$a = trim(fgets(STDIN));
