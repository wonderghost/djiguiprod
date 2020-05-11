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
Route::get('/','HomeController@index');
Route::get('/news','NewsController@index');

Route::prefix('admin')->group(function () {
    Route::get('/users','UserController@index');
});

Route::prefix('news')->group(function () {
    
    Route::get('/articles/add','NewsController@articleGetForm')->middleware('auth');
    Route::post('/articles/add-category','NewsController@postCategory')->middleware('auth');
    Route::post('/articles/add-sub-category','NewsController@postSubCategory')->middleware('auth');
    Route::post('/articles/add','NewsController@addArticle')->middleware('auth');
    Route::get('/articles/get-category','NewsController@getCategoryList')->middleware('auth');
    Route::get('/articles/get-list','NewsController@getList'); 
    Route::get('/{slug}','NewsController@getDetails');
    Route::post('/{slug}/get-infos','NewsController@getInfoDetails');
});

Auth::routes();
