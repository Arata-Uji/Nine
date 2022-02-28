<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Practice;
use PhpOffice\PhpWord\TemplateProcessor;
use DB;

class ListController extends Controller
{
    function list(){
        $lists = Practice::getPracticeByMonth();
        return view('list.list', ['lists' => $lists]);
    }

    function detail($ym){
        $practices = Practice::getPracticeJoinLocations($ym);

        if ($practices->isEmpty()) {
            return redirect()->action([ListController::class, 'list']);
        }

        return view('list.detail', ['practices' => $practices]);
    }

    function update(Request $request){

        // バリデーション
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
            return redirect()->action([ListController::class, 'list']);
        }

		//データベース登録処理
		$ym = Practice::updatePracticeWithId($input);

        return redirect()->action([ListController::class, 'detail'], ['ym' => $ym]);
	}

    function delete($id){

        // 練習idチェック
        if (empty($id) || DB::table('practices')->where('id', $id)->doesntExist()) {
            //セッションに書き込む
            $request->session()->flash('err_msg', '練習データが存在しません。');
            return redirect()->action([ListController::class, 'list']);
        }

		$ym = Practice::deletePracticeWithId($id);
        return redirect()->action([ListController::class, 'detail'], ['ym' => $ym]);
	}

    function reason(Request $request){
        $input = $request->only('date');
        $ym = substr($input['date'], 0, -3);

        // チェック
        if (empty($ym) || DB::table('practices')->where('date', 'like', $ym . '%')->doesntExist()) {
            //セッションに書き込む
            $request->session()->flash('err_msg', '正常なダウンロードができませんでした。');
            return redirect()->action([ListController::class, 'list']);
        }

        $template = new TemplateProcessor(base_path('public/documents/reason.docx'));

        /* ファイルに書き込む */
        $info = Practice::getDateWithYm($ym);
        $template->setValue('name', $info['name']); //練習名
        $template->setValue('start_date', $info['min']); //開始日
        $template->setValue('end_date', $info['max']); //終了日

        /* Wordファイルのダウンロード */
        $file_name = '13_活動理由書(九球テニスクラブ).docx'; //ダウンロード時のファイル名
        $template->saveAs($file_name);
        return response()->download($file_name)->deleteFileAfterSend(true);
    }
}