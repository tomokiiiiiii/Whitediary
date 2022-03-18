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
   Route::get('/diaries/{diary}', 'DiaryController@select_user');
   Route::post('/diaries', 'DiaryController@store');
   Route::get('/home', 'HomeController@index')->name('home');
   Route::get('/mypage/{user}', 'UserController@mypage');
   Route::delete('/mypage/{diary_id}', 'UserController@delete');
   Route::get('/search','UserController@search');
   Route::post('/search','UserController@follow');
   Route::get('/list','UserController@list');
   Route::delete('/list/{user}','UserController@follows_delete');
   Route::get('/select','UserController@select_user');
   Route::post('/select_user','UserController@store');
   Route::get('/select/{diary}','DiaryController@show');
   Route::delete('/select_user', 'UserController@cancel');
   });


