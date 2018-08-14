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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//Route::resource('login', 'loginController');
//Route::resource('class', 'NtqClassController');
//Route::resource('content', 'ClassContentController');


//http://localhost/learning_social_network/public/api/auth/login
Route::group([
    //'middleware' => 'jwt',
    'middleware' => 'cors',
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('payload','AuthController@payload');
    Route::get('list','AuthController@listUser');

});

//http://localhost/learning_social_network/public/api/content/list  'middleware' => 'jwt'
Route::group(['prefix'=>'content'],function(){
    Route::get('/list', 'ClassContentController@index');
    Route::get('/{id}','ClassContentController@show');
    Route::post('/post','ClassContentController@store');
    Route::get('/delete/{id}','ClassContentController@destroy');
});

Route::group(['prefix'=>'ntqclass'],function(){
    Route::get('/list', 'NtqClassController@index');
    Route::get('/{id}','NtqClassController@show');
    Route::post('/post','NtqClassController@store');
    Route::get('/delete/{id}','NtqClassController@destroy');
});

Route::group([
    'middleware' => 'cors',
    'prefix'=>'member'
],function(){
    Route::get('/list', 'ClassMemberController@index');
    Route::get('/{id}','ClassMemberController@show');
    Route::post('/post','ClassMemberController@store');
    Route::post('/delete','ClassMemberController@destroy');
});

Route::group(['prefix' => 'user'],function(){
    //Route::get('/list',);

});