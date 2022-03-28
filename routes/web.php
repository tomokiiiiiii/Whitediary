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
   Route::get('/listfollowing','UserController@listfollowing');
   Route::get('/listfollowed','UserController@listfollowed');
   Route::delete('/listfollowing/{user}','UserController@following_delete');
   Route::delete('/listfollowed/{user}','UserController@followed_delete');
   Route::get('/select','UserController@select_user');
   Route::post('/select_user','UserController@store');
   Route::get('/select/{diary}','DiaryController@show');
   Route::delete('/select_user', 'UserController@cancel');
   Route::get('/diary/like/{id}', 'DiaryController@like')->name('diary.like');
   Route::get('/diary/unlike/{id}', 'DiaryController@unlike')->name('diary.unlike');
   Route::get('/likelist/{diary}','DiaryController@likelist');
   });


