<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//Route::middleware('guest:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//
Route::get('me', 'User\MeController@getMe');
Route::get('products', 'ProductController@index');
Route::get('users', 'UserController@index');
Route::get('orders', 'ProductController@orders');
Route::get('product/{id}', 'ProductController@find');
Route::post('create', 'ProductController@create');
Route::post('create/order', 'ProductController@createOrder');
Route::get('user/{id}', 'UserController@find');
//Route::put('product/{id}', 'ProductController@update');
Route::put('product/{id}', 'ProductController@update');
Route::post('upload', 'UploadController@byIdUpload');
Route::delete('product/{id}', 'ProductController@destroy');
Route::delete('order/{id}', 'ProductController@orederDestroy');
Route::get('product-by-id/{id}', 'ProductController@productsById');
Route::get('user-by-id/{id}', 'ProductController@usersById');


Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout', 'Auth\LoginController@logout');
    Route::delete('user/{id}', 'UserController@destroy');
});

Route::group(['middleware' => ['guest:api']], function () {

    Route::post('register', 'Auth\RegisterController@register');
    Route::post('verification/resend', function () {
        dd('frf');
    });
    Route::post('verification/verify', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('login', 'Auth\LoginController@login');


});

Route::group(['middleware' => ['auth.admin', 'auth:api']], function() {
    $groupData = [
        'namespace' => 'Admin',
        'prefix' => 'admin',
    ];

});
