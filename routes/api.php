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
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@authenticate');
Route::delete('/logout', 'App\Http\Controllers\Auth\LoginController@logout');
Route::get('/check', 'App\Http\Controllers\Auth\LoginController@checkSession');

//password resets routes
$this->post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.reset');

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth:api'], function () {

    Route::group(['prefix' => 'users'], function() {
        Route::get('/', '\App\Domains\Users\Http\UserController@index');
        Route::get('/edit/{user}', '\App\Domains\Users\Http\UserController@edit');
        Route::post('/store', '\App\Domains\Users\Http\UserController@store');
        Route::put('/update/{user}', '\App\Domains\Users\Http\UserController@update');
        Route::delete('/delete', '\App\Domains\Users\Http\UserController@destroyMany');
    });

    Route::group(['prefix' => 'clients'], function() {
        Route::get('/', '\App\Domains\Clients\Http\ClientController@index');
        Route::get('/edit/{client}', '\App\Domains\Clients\Http\ClientController@edit');
        Route::post('/store', '\App\Domains\Clients\Http\ClientController@store');
        Route::put('/update/{client}', '\App\Domains\Clients\Http\ClientController@update');
        Route::delete('/delete', '\App\Domains\Clients\Http\ClientController@destroyMany');
    });

    Route::group(['prefix' => 'contas'], function() {
        Route::group(['prefix' => 'tipos'], function() {
            Route::get('/', '\App\Domains\BillTypes\Http\BillTypeController@index');
            Route::get('/edit/{bill_type}', '\App\Domains\BillTypes\Http\BillTypeController@edit');
            Route::post('/store', '\App\Domains\BillTypes\Http\BillTypeController@store');
            Route::put('/update/{bill_type}', '\App\Domains\BillTypes\Http\BillTypeController@update');
            Route::delete('/delete', '\App\Domains\BillTypes\Http\BillTypeController@destroyMany');
        });

        Route::group(['prefix' => '/'], function() {
            //Route::get('/', '\App\Domains\BillTypes\Http\BillTypeController@index');
            //Route::get('/edit/{bill_type}', '\App\Domains\BillTypes\Http\BillTypeController@edit');
            Route::post('/store', '\App\Domains\Bills\Http\BillController@store');
            //Route::put('/update/{bill_type}', '\App\Domains\BillTypes\Http\BillTypeController@update');
            //Route::delete('/delete', '\App\Domains\BillTypes\Http\BillTypeController@destroyMany');

            Route::get('/expireds', '\App\Domains\Bills\Http\BillController@getExpireds');
            Route::get('/notexpireds', '\App\Domains\Bills\Http\BillController@getNotExpireds');
        });

        Route::group(['prefix' => 'conta'], function() {
            Route::get('/view/{bill}', '\App\Domains\Bills\Http\BillController@getBill');
            Route::delete('/delete/{bill}', '\App\Domains\Bills\Http\BillController@destroy');
            Route::post('/pay/{bill}', '\App\Domains\Bills\Http\BillController@payBill');
        });
    });
});


