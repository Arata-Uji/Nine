<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calendar\CalendarFormView;
use App\Models\Practice;
use Carbon\Carbon;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;

class PracticeController extends Controller
{
	private $formItems = 'practices';

    function practice(Request $request){

		//クエリーのdateを受け取る
		$date = $request->input('date');

		//dateがYYYY-MMの形式かどうか判定する
		if ($date && preg_match('/^[0-9]{4}-[0-9]{2}$/', $date)) {
			$date .= '-01';

		} else {
			$date = null;
		}

		//取得出来ない時は来月を指定する
		if (!$date) {
            $date = Carbon::now('Asia/Tokyo')->addMonthsNoOverflow()->format('Y-m-d');
        }

		$calendar = new CalendarFormView($date);
		return view('practice.practice', ['calendar' => $calendar]);
	}

	function post(Request $request){
		$input = $request->only($this->formItems, 'ym');

		if(!array_key_exists($this->formItems, $input)) {
			$request->session()->flash('err_msg', '練習日が選択されていません。');
			return redirect()->action([PracticeController::class, 'practice']);
		}

		//セッションに書き込む
		$request->session()->flash('form_input', $input);
		return redirect()->action([PracticeController::class, 'location']);
	}

	function location(Request $request){
		//セッションから値を取り出す
		$input = $request->session()->get('form_input');

		if(empty($input)) {
			$request->session()->flash('err_msg', 'セッションの情報が破棄されました。');
			return redirect()->action([PracticeController::class, 'practice']);
		}

		return view('practice.location',
		[
			'input' => $input['practices'],
			'ym' => $input['ym']
		]);
	}

	function send(Request $request){
		//セッションから値を取り出す
		$input = $request->only($this->formItems);
		$ym = $request->input('ym');

		//戻るボタンが押された時、またはセッションに値が無い時はフォームに戻る
		if($request->has('back') || !$input){
			$request->session()->forget('form_input');
			return redirect()->action([PracticeController::class, 'practice']);
		}

		//データベース登録処理
		Practice::updatePracticeWithMonth($ym, $input['practices']);

		//セッションを空にする
		$request->session()->forget('form_input');
		return redirect()->action([PracticeController::class, 'complete'], ['ym' => $ym]);
	}

	function complete($ym){
		return view('practice.complete', ['ym' => $ym]);
	}
}
