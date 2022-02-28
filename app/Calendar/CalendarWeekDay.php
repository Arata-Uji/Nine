<?php

namespace App\Calendar;

use Carbon\Carbon;

class CalendarWeekDay {

	protected $carbon;

	function __construct($date) {
		$this->carbon = new Carbon($date, 'Asia/Tokyo');
	}

	function getClassName() {
		return "day-" . strtolower($this->carbon->format("D"));
	}

	/**
	 * @return 
	 */
	function render() {
        return '<p class="day">' . $this->carbon->format("j"). '</p>';
	}


    function isToday() {
        if ($this->carbon->isToday()) {
            return true;

        } else {
            return false;
        }
    }

	function getDateKey() {
		return $this->carbon->format('Y-m-d');
	}
}
