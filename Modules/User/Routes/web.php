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
Route::get('/backend', function () {
    if (Auth::user()) {
        return redirect()->route('admin.app.index');
    }
    return redirect()->route('auth.login');
});
Route::prefix('backend/auth')->group(function () {
    Route::get('/login', [
        'as' => 'auth.loginForm',
        'uses' => 'Auth\LoginController@showLoginForm'
    ]);
    Route::post('/login', [
        'as' => 'auth.login',
        'uses' => 'Auth\LoginController@login'
    ]);
    Route::get('/register', [
        'as' => 'auth.registerForm',
        'uses' => 'Auth\RegisterController@showRegistrationForm'
    ]);
    Route::post('/register', [
        'as' => 'auth.register',
        'uses' => 'Auth\RegisterController@register'
    ]);
    Route::get('/reset', [
        'as' => 'auth.password.request',
        'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
    ]);
    Route::post('/reset', [
        'as' => 'auth.password.email',
        'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
    ]);
    Route::get('/update-password', [
        'as' => 'password.reset',
        'uses' => 'Auth\ResetPasswordController@showResetForm'
    ]);
    Route::post('/update-password', [
        'as' => 'auth.password.update',
        'uses' => 'Auth\ResetPasswordController@reset'
    ]);
    Route::post('/logout', [
        'as' => 'auth.logout',
        'uses' => 'Auth\LoginController@logout',
        'middleware' => 'auth'
    ]);

});
