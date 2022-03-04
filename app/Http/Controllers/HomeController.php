<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calendar\CalendarOutputView;
use Carbon\Carbon;
use App\Models\Practice;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use DB;
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home(Request $request){

        //クエリーのdateを受け取る
		$date = $request->input('date');

		//dateがYYYY-MMの形式かどうか判定する
		if ($date && preg_match('/^[0-9]{4}-[0-9]{2}$/', $date)) {
			$date .= '-01';

		} else {
			$date = null;
		}

		//取得出来ない時は現在(=今月)を指定する
		if (!$date) {
            $date = Carbon::now('Asia/Tokyo')->format('Y-m-d');
        }

		//カレンダーに渡す、当月の練習を取得
		$calendar = new CalendarOutputView($date);
        $practices = Practice::getPracticeJoinLocations(substr($date, 0, -3));

        return view('home', ['calendar' => $calendar, 'practices' => $practices]);
    }

    public function mypage(){
        $today = new DateTime('today');
        $enrolled_at = new DateTime(Auth::user()->enrolled_at);
        $diff = $enrolled_at->diff($today);
        $grade =  $diff->format('%Y') + 1 . '年';

        if ($grade > 4) {
            $grade = '';
        }

        return view('mypage', ['grade' => $grade]);
    }

    function update(Request $request){
        $this->validate($request,
        [
            'usage_time' => ['required', 'integer', 'between:0,10'],
            'coat' => ['required', 'integer', 'between:0,10'],
            'light_up_time' => ['required', 'integer', 'between:0,10'],
        ]);

        //値を取り出す
		$input = $request->all();

        // 練習idチェック
        if (empty($input['id']) || DB::table('practices')->where('id', $input['id'])->doesntExist()) {
            //セッションに書き込む
            $request->session()->flash('err_msg', '練習データが存在しません。');
            return redirect()->action([HomeController::class, 'home']);
        }

		//データベース登録処理
		$ym = Practice::updatePracticeWithId($input);
        return redirect()->action([HomeController::class, 'home'], ['date' => $ym]);
	}

    function locationList() {
        $locations = Location::getAllLocations();
        return view('location_list', ['locations' => $locations]);
    }
}
