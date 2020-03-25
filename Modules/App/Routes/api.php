<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->get('/list-app', [
        'as' => 'api.app.list',
        'uses' => 'Modules\App\Http\Controllers\Api\v1\AppController@listApp'
    ]);
    $api->get('/app-detail/{id}', [
        'as' => 'api.app.detail',
        'uses' => 'Modules\App\Http\Controllers\Api\v1\AppController@appDetail'
    ]);
});