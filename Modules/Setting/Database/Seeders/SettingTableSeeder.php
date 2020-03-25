<?php
/**
 * Created by PhpStorm.
 * User: VPA
 * Date: 5/3/2019
 * Time: 2:37 PM
 */

namespace Modules\Setting\Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('settings')->insert(['key' => 'setting_logo_path', 'value' => null]);
        DB::table('settings')->insert(['key' => 'setting_site_name', 'value' => null]);
        DB::table('settings')->insert(['key' => 'setting_site_name_small', 'value' => null]);
    }
}