<?php

use Illuminate\Support\Facades\Route;

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
Auth::routes();
Route::group(['middleware' => ['auth']], function(){
   Route::get('/', 'DiaryController@index');
   Route::get('/diaries/create', 'DiaryController@create');
   Route::get('/diaries/{diary}', 'DiaryController@show')->name('show');
   Route::post('/diaries', 'DiaryController@store');
   Route::get('/home', 'HomeController@index')->name('home');
   Route::get('/mypage/{user_id}', 'UserController@index');
   Route::delete('/mypage/{diary_id}', 'UserController@delete');
   Route::get('/seach','UserController@seach');
   Route::post('/seach','UserController@follow');
   
});


