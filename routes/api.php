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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//auth routes
Route::post('/login', 'Auth\LoginController@authenticate');
Route::delete('/logout', 'Auth\LoginController@logout');
Route::get('/check', 'Auth\LoginController@checkSession');

//password resets routes
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth:api'], function () {

    Route::group(['prefix' => 'users'], function() {
        Route::get('/', 'UserController@index');
        Route::get('/edit/{user}', 'UserController@edit');
        Route::post('/store', 'UserController@store');
        Route::put('/update/{user}', 'UserController@update');
        Route::delete('/delete', 'UserController@destroyMany');
    });

    Route::group(['prefix' => 'clients'], function() {
        Route::get('/', 'ClientController@index');
        Route::get('/edit/{client}', 'ClientController@edit');
        Route::post('/store', 'ClientController@store');
        Route::put('/update/{client}', 'ClientController@update');
        Route::delete('/delete', 'ClientController@destroyMany');
    });
    //Route::get('/clients', 'ClientController@index');
});
