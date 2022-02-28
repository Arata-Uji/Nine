<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;
use DB;

class Practice extends Model
{
    //テーブル名
    protected $table = 'practices';

    //可変項目
    protected $fillable =
    [
        'name',
        'date',
        'usage_time',
        'coat',
        'light_up_time',
        'cost',
        'user_id',
        'location_id'
    ];

    public function updatePracticeWithMonth($ym, $input) {
        $practices = self::getPracticeWithMonth($ym);
        $name = date('Y年n月度練習', strtotime($ym));
        $user_id = Auth::id();

		foreach($input as $date_key => $location_id){

			if(isset($practices[$date_key])){ //既に作成済の場合
				continue;
			}

			$practice = new Practice();
			$practice->fill([
                'name' => $name,
                'date' => $date_key,
                'user_id' => $user_id,
                'location_id' => $location_id
            ]);

			$practice->save();
		}
    }

    public function updatePracticeWithId($input) {
        $practice = Practice::find($input['id']);
        $location = Location::find($practice->location_id);

        // コート料金計算
        // コート料金(1時間) * 全体利用時間 * コート面数 + 照明料金(1時間) * 照明利用時間
        $cost = $input['usage_time'] * $location->price * $input['coat'] + $location->light_up * $input['light_up_time'];
        $practice->fill([
            'usage_time' => $input['usage_time'],
            'coat' => $input['coat'],
            'light_up_time' => $input['light_up_time'],
            'cost' => $cost,
        ]);

		$practice->save();
        return substr($practice->date, 0, -3);
    }

    public function getPracticeWithMonth($ym) {
        return Practice::Join('locations', 'location_id', '=', 'locations.id')
                        ->where('date', 'like', $ym . '%')
                        ->get()
                        ->keyBy('date');
    }

    public function getDateWithYm($ym) {

        try {
            $info['name'] = Practice::where('date', 'like', $ym . '%')->value('name');
            $info['min'] = Practice::where('date', 'like', $ym . '%')->min('date');
            $info['max'] = Practice::where('date', 'like', $ym . '%')->max('date');
            return $info;

        } catch (Throwrable $e) {
            abort(500);
        }
    }

    public function getPracticeJoinLocations($ym) {
        return DB::table('practices')
                    ->join('users', 'user_id', '=', 'users.id')
                    ->join('locations', 'location_id', '=', 'locations.id')
                    ->select('practices.id',
                            'practices.name as practice_name',
                            'practices.date',
                            'practices.usage_time',
                            'practices.coat',
                            'practices.light_up_time',
                            'practices.cost',
                            'users.name as user_name',
                            'locations.name as location_name')
                    ->where('practices.date', 'like', $ym . '%')
                    ->get();
    }

    public function getPracticeByMonth() {
        return DB::select('SELECT name, MIN(date) AS minDate, MAX(date) AS maxDate, COUNT(*) AS count, SUM(cost) AS costSum
                            FROM practices 
                            GROUP BY name 
                            ORDER BY MIN(date) DESC 
                            LIMIT 7');
    }

    public function deletePracticeWithId($id) {

        try {
            $practice = Practice::find($id);
            $ym = substr($practice->date, 0, -3);
            $practice->delete();
            return $ym;

        } catch (Throwrable $e) {
            abort(500);
        }
    }
};
