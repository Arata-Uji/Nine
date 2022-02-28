<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("locations")->insert([
            [
                'name' => '多摩川緑地広場',
                'postal_code' => '158-0087',
                'adress' => '東京都世田谷区玉堤1-5-1',
                'price' => '650',
                'light_up' => '0',
                'url' => 'http://www.tm15137025317.sakura.ne.jp/',
            ],
            [
                'name' => '川崎マリエン',
                'postal_code' => '210-0869',
                'adress' => '神奈川県川崎市川崎区東扇島38-1',
                'price' => '600',
                'light_up' => '800',
                'url' => 'https://www.kawasakiport.or.jp/',
            ],
            [
                'name' => '篠崎公園',
                'postal_code' => '133-0054',
                'adress' => '東京都江戸川区上篠崎1丁目25-1',
                'price' => '1300',
                'light_up' => '500',
                'url' => 'https://www.tokyo-park.or.jp/park/format/index025.html',
            ],
            [
                'name' => '赤塚公園',
                'postal_code' => '158-0087',
                'adress' => '東京都板橋区高島平3丁目',
                'price' => '1300',
                'light_up' => '0',
                'url' => 'https://www.tokyo-park.or.jp/park/format/index005.html',
            ],
            [
                'name' => '東綾瀬公園',
                'postal_code' => '120-0004',
                'adress' => '東京都足立区東綾瀬3-4',
                'price' => '1300',
                'light_up' => '500',
                'url' => 'https://tokyo-eastpark.com/higashiayase/',
            ],
        ]);
    }
}
