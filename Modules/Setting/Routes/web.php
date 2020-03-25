<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::prefix('backend/setting/settings')->group(function() {
    Route::get('/',[
        'as' => 'admin.setting.settings.index',
        'uses' => 'Admin\SettingController@index'
    ]);
    Route::post('/',[
        'as' => 'admin.setting.settings.update',
        'uses' => 'Admin\SettingController@update'
    ]);

});
