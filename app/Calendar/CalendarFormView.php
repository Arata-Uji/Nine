<?php
namespace App\Calendar;
use Carbon\Carbon;
use App\Calendar\CalendarView;

/**
* 表示用
*/
class CalendarFormView extends CalendarView {

	function render(){
		return parent::render() . 
			 "<input type='hidden' name='ym' value='".$this->carbon->format("Y-m")."' />";
	}

	/**
	 * @return CalendarFormWeek
	 */
	protected function getWeek(Carbon $date, $index = 0){
		$week = new CalendarFormWeek($date, $index);
		return $week;
	}
}