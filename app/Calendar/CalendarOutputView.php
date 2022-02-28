<?php
namespace App\Calendar;

use Carbon\Carbon;
use App\Calendar\CalendarView;
use App\Models\Practice;

/**
* 表示用
*/
class CalendarOutputView extends CalendarView {

    protected $practices;

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

        //練習日の読み込み
		$this->practices = Practice::getPracticeJoinLocations($this->carbon->format("Y-m"));

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

		//練習日をボタンとして表示する
		$practice = $this->checkDate($day->getDateKey());
		$location_name = '';
		
        if($practice !== false){
			$location_name = $this->showLocation($practice->location_name);
            $html[] = "<button type='button' class='btn btn-outline-success btn-sm' data-toggle='modal' data-target='#modal$practice->id'>" . $location_name . "</button>";
        }

		$html[] = '</td>';
		return implode("", $html);
	}

    protected function showLocation($location_name){

        if ($location_name === '多摩川緑地広場') {
            return '多摩川';
    
        } elseif ($location_name === '川崎マリエン') {
            return '川崎';
    
        } elseif ($location_name === '赤塚公園') {
            return '赤塚';
    
        } elseif ($location_name === '篠崎公園') {
            return '篠崎';

        } elseif ($location_name === '東綾瀬公園') {
            return '東綾瀬';
        }
    }

	protected function checkDate(string $date){
		
		foreach ($this->practices as $practice) {

			if ($practice->date == $date) {
				return $practice;
			}
		}

		return false;
	}
}