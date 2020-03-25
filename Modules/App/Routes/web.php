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

Route::prefix('backend/app')->group(function () {
    Route::get('/', [
        'as' => 'admin.app.index',
        'uses' => 'Admin\AppController@index',
        'middleware' => 'auth'
    ]);
    Route::get('/create', [
        'as' => 'admin.app.create',
        'uses' => 'Admin\AppController@create',
        'middleware' => 'auth'
    ]);
    Route::post('/store', [
        'as' => 'admin.app.store',
        'uses' => 'Admin\AppController@store',
        'middleware' => 'auth'
    ]);
    Route::get('/edit/{id}', [
        'as' => 'admin.app.edit',
        'uses' => 'Admin\AppController@edit',
        'middleware' => 'auth'
    ]);
    Route::post('/update/{id}', [
        'as' => 'admin.app.update',
        'uses' => 'Admin\AppController@update',
        'middleware' => ['auth', 'user']
    ]);
    Route::post('/search', [
        'as' => 'admin.app.search',
        'uses' => 'Admin\AppController@search',
        'middleware' => 'auth'
    ]);
    Route::get('/upload', [
        'as' => 'admin.app.upload',
        'uses' => 'Admin\AppController@getFileDownloadIOS',
        'middleware' => 'auth'
    ]);
    Route::get('/test', function () {
        return phpinfo();
    })->name('test');

});


