<?php
namespace App\Calendar;
use Carbon\Carbon;
use App\Calendar\CalendarWeek;

class CalendarFormWeek extends CalendarWeek {
	/**
	 * @return CalendarFormWeekDay
	 */
	function getDay(Carbon $date){
		$day = new CalendarFormWeekDay($date);
		return $day;
	}
}