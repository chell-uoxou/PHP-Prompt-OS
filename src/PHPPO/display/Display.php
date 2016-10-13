<?php
// include_once(dirname(__FILE__) . "/../system/System.php");

namespace phppo;

use phppo\system\systemProcessing as systemProcessing;
include_once 'title.php';
$display = new display;
class display extends systemProcessing{

	function __construct(){

	}
	public function setInfo($str){
		$str = trim($str);
		global $pr_info;
		$pr_info = $str;
	}

	public function setThread($str){
		$str = trim($str);
		global $pr_thread;
		$pr_thread = $str;
	}

	public function reverseColor($auth){
		if ($auth) {
			echo "\033[7m";
		}else {
			echo "\x1b[m";
		}
	}

	public function create_progress ($all_count, $progress_chars = [], $format = null) {
		// @author:http://qiita.com/ProjectICKX/items/05e343fc762a93cda94a
		//======================================================
		//関数作成前の初期化
		//======================================================
		//プログレスバー文字の確定
		$finished_str   = isset($progress_chars['finished']) ? $progress_chars['finished'] : (isset($progress_chars[0]) ? $progress_chars[0] : '|');
		$current_str    = isset($progress_chars['current']) ? $progress_chars['current'] : (isset($progress_chars[1]) ? $progress_chars[1] : '|');
		$unfinished_str = isset($progress_chars['unfinished']) ? $progress_chars['unfinished'] : (isset($progress_chars[2]) ? $progress_chars[2] : ' ');

		//プログレスバーフォーマットの確定
		if ($format === null) {
			$format = sprintf(' %% 3s%%%% [%%s%%s%%s] ETA %%s %% %ss/%s', strlen($all_count), $all_count);
		}

		//======================================================
		//関数構築
		//======================================================
		return function ($current = null) use ($all_count, $finished_str, $current_str, $unfinished_str, $format) {
			//======================================================
			//初期処理
			//======================================================
			//プログレスバー実行開始時点の時間保持用変数
			static $start_ts;

			//直前に表示されたプログレスバーの文字列長
			static $before_width;

			//最後に実行した位置
			static $position;

			//現在の時間を取得
			$current_ts = microtime(true);

			//======================================================
			//検証
			//======================================================
			if ($current !== null && $current < 1) {
				throw new \Exception(sprintf('現在位置は1以上の数値のみ使用できます。$current:%s', $current));
			}

			//======================================================
			//クロージャ―変数の初期化
			//======================================================
			if ($current === null) {
				if ($position === null) {
					$position = 0;
				}
				$position++;
			} else {
				$position = $current;
			}

			//プログレスバー初期化処理
			if ($position === 1) {
				$start_ts = $current_ts;
			}

			//======================================================
			//実処理
			//======================================================
			//プログレスバー実行開始からの経過時間
			$elapsed_ts = ($current_ts - $start_ts) / $position * ($all_count - $position);

			//予想終了時間の算出
			$eta = sprintf('%02.2s:%02s:%02s.%0-3.3s', $elapsed_ts / 60 / 60 % 60, $elapsed_ts / 60 % 60, $elapsed_ts % 60, round(($elapsed_ts - floor($elapsed_ts)) * 1000));

			//進捗状況の算出
			$percent = $position / $all_count * 100;
			$progress = round($percent / 2);

			//プログレスバーの構築
			$progress_bar = sprintf($format, round($percent), str_repeat($finished_str, $progress), $current_str, str_repeat($unfinished_str, 50 - $progress), $eta, $position);

			//直前に表示したプログレスバーの文字列長が現在よりも長い場合、消しこみ処理を追加する。
			$current_width = mb_strwidth($progress_bar);
			$sol = '';
			if ($before_width > $current_width) {
				$diff_width = $before_width - $current_width;
				$sol = sprintf('%s%s', str_repeat(' ', $diff_width), str_repeat("\x08", $diff_width));
			}
			$before_width = $current_width;

			//現在位置が$all_countと同一になった場合、初期化して終わる。
			if ($all_count == $position) {
				$start_ts       = null;
				$before_width   = null;
				$position       = null;
				$eol            = '';
			} else {
				//末尾につける "\r" が全ての答えだった。"\n"に変えると良く判る。
				$eol            = "\r";
			}

			//処理の終了
			return sprintf('%s%s%s', $sol, $progress_bar, $eol);
		};
	}

}
