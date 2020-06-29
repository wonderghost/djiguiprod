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
Route::get('/get-prestation','PageController@getListPage');
Route::get('/news','NewsController@index');

Route::prefix('prestations')->group(function () {
    Route::get('/','PageController@prestationIndex');
    Route::post('/get-prestation-details','PageController@getPrestationDetails');
    Route::get('/{slug}','PageController@prestationDetails');
});

Route::prefix('admin')->group(function () {
    Route::get('/users','UserController@index')->middleware('auth');
    Route::get('/manage-pages','PageController@index')->middleware('auth'); //
    Route::post('/page/add','PageController@addPage')->middleware('auth');
    Route::get('/page','PageController@getListPage')->middleware('auth');
});

Route::prefix('news')->group(function () {
    
    Route::get('/articles/add','NewsController@articleGetForm')->middleware('auth');
    Route::post('/articles/add-category','NewsController@postCategory')->middleware('auth');
    Route::post('/articles/add-sub-category','NewsController@postSubCategory')->middleware('auth');
    Route::post('/articles/add','NewsController@addArticle')->middleware('auth');
    Route::get('/articles/get-category','NewsController@getCategoryList');
    Route::get('/articles/get-list','NewsController@getList'); 
    

    Route::get('/{slug}','NewsController@getDetails');
    Route::get('/category/{slug}','NewsController@getNewsCategoryDetails');
    Route::post('/category/get-subcategory','NewsController@getSubCat');
    Route::post('/{slug}/get-infos','NewsController@getInfoDetails');

});

Auth::routes();
