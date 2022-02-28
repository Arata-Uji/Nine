<?php
namespace App\Calendar;
use Carbon\Carbon;
use App\Calendar\CalendarWeekDay;

class CalendarFormWeekDay extends CalendarWeekDay {

	public $practice = null;

	/**
	 * @return 
	 */
	function render(){
		
		//HTMLの組み立て
		$html = [];
		
		//日付
        $html[] = '<label class="form-check-label" for="' . $this->carbon->format("j") . '">' . $this->carbon->format("j") . '</label><br>';

        //練習日程設定
        if ($this->getClassName() == "day-sun" || $this->getClassName() == "day-sat") {
            $html[] = '<input type="checkbox" class="form-check-input" id="' . $this->carbon->format("j") . '" value="' . $this->carbon->format("Y-m-d") . '" name="practices[' . $this->carbon->format("Y-m-d") . ']">';

        } else {
            $html[] = '<input type="checkbox" class="form-check-input" id="' . $this->carbon->format("j") . '" value="' . $this->carbon->format("Y-m-d") . '" name="practices[' . $this->carbon->format("Y-m-d") . ']" checked>';

        }
            
        /*
		//練習場所設定
        $html[] = '<input type="hidden" name="practice">';
        $html[] = '<select name="location" class="form-control form-control-sm">';

        if ($this->getClassName() == "day-sun" || $this->getClassName() == "day-sat") {
            $html[] = '<option value="" selected>なし</option>';
            $html[] = '<option value="tamagawa">多摩川緑地広場</option>';

        } else {
            $html[] = '<option value="">なし</option>';
            $html[] = '<option value="tamagawa" selected>多摩川緑地広場</option>';
        }

		$html[] = '<option value="kawasaki">川崎マリエン</option>';
		$html[] = '<option value="akatsuka">赤塚公園</option>';
        $html[] = '<option value="shinozaki">篠崎公園</option>';
		$html[] = '<option value="ayase">東綾瀬公園</option>';
		$html[] = '</select>';
        */

        return implode("", $html);
	}
}
