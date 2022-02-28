<?php

namespace App\Calendar;

use Carbon\Carbon;

class CalendarView {

	protected $carbon;

	function __construct($date){
		$this->carbon = new Carbon($date, 'Asia/Tokyo');
	}

	/**
	 * タイトル
	 */
	public function getTitle(){
		return $this->carbon->format('Y年n月');
	}

    protected function getWeeks(){
		$weeks = [];

		//週の最初を日曜日に設定
		Carbon::setWeekStartsAt(Carbon::SUNDAY);

		//初日
		$firstDay = $this->carbon->copy()->firstOfMonth();

		//月末まで
		$lastDay = $this->carbon->copy()->lastOfMonth();

		//1週目
		$weeks[] = $this->getWeek($firstDay->copy());

		//作業用の日
		$tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();

		//月末までループさせる
		while($tmpDay->lte($lastDay)){

			//週カレンダーViewを作成する
			$weeks[] = $this->getWeek($tmpDay->copy(), count($weeks));

            //次の週=+7日する
			$tmpDay->addDay(7);
		}

		return $weeks;
	}

	/**
	 * @return CalendarWeek
	 */
	protected function getWeek(Carbon $date, $index = 0){
		return new CalendarWeek($date, $index);
	}

	/**
	 * カレンダーを出力する
	 */
	function render(){
		$html = [];
		$html[] = '<div class="calendar">';
		$html[] = '<table class="table table-bordered">';
		$html[] = '<thead>';
		$html[] = '<tr>';
        $html[] = '<th>日</th>';
        $html[] = '<th>月</th>';
		$html[] = '<th>火</th>';
		$html[] = '<th>水</th>';
		$html[] = '<th>木</th>';
		$html[] = '<th>金</th>';
		$html[] = '<th>土</th>';
		$html[] = '</tr>';
		$html[] = '</thead>';
        $html[] = '<tbody>';
		$weeks = $this->getWeeks();

		foreach($weeks as $week){

			$html[] = '<tr class="'.$week->getClassName().'">';
			$days = $week->getDays();

			foreach($days as $day){
				$html[] = $this->renderDay($day);
			}
		}
		
		$html[] = '</tbody>';
		$html[] = '</table>';
		$html[] = '</div>';
		return implode("", $html);
	}

	/**
	 * 日を描画する
	 */
	protected function renderDay(CalendarWeekDay $day){
		$html = [];

		if($day->isToday() && $day->getClassName() != "day-blank"){
			$html[] = '<td class="'.$day->getClassName().' today">';
			
		} else {
			$html[] = '<td class="'.$day->getClassName().'">';
			
		}

		$html[] = $day->render();
		$html[] = '</td>';
		return implode("", $html);
	}

	/**
	 * 次の月
	 */
	public function getNextMonth(){
		return $this->carbon->copy()->addMonthsNoOverflow()->format('Y-m');
	}
	
	/**
	 * 前の月
	 */
	public function getPreviousMonth(){
		return $this->carbon->copy()->subMonthsNoOverflow()->format('Y-m');
	}
}