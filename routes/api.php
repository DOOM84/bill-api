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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::get('index', 'FrontController@index');
Route::get('menu', 'FrontController@menu');
Route::get('contacts', 'FrontController@contacts');
Route::post('getPass', 'SendController@getPass');
//Route::post('uploadImage', 'UploadController@uploadImg');
//Route::post('uploadMenu', 'UploadController@uploadMenu');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth:api']], function (){
    Route::apiResource('gallery', 'GalleryController');
    Route::apiResource('dish', 'DishController');
    Route::apiResource('info', 'InfoController');
    Route::apiResource('price', 'PriceController');
    Route::apiResource('contact', 'ContactController');
    Route::apiResource('review', 'ReviewController');
    Route::apiResource('user', 'UserController');
});

Route::group(['prefix' => 'auth'], function (){
    Route::post('register', 'Auth\RegisterController@action');
    Route::post('login', 'Auth\LoginController@action');
    Route::post('refresh', 'Auth\AuthController@refresh');
    Route::post('logout', 'Auth\LogoutController@action');
    Route::get('me', 'Auth\MeController@action');
});
