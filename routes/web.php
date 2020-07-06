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

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('/manage-pages','PageController@index')->middleware('admin'); //
        Route::get('/manage-users','UserController@index')->middleware('admin');
        Route::get('/page','PageController@getListPage')->middleware('admin');
    
        Route::post('/page/add','PageController@addPage')->middleware('admin');
        Route::post('/users/add','UserController@addUsers')->middleware('admin');
    });

    Route::prefix('news')->group(function () {
        
        Route::get('/articles/add','NewsController@articleGetForm')->middleware('redacteur');
        Route::post('/articles/add-category','NewsController@postCategory')->middleware('admin');
        Route::post('/articles/add-sub-category','NewsController@postSubCategory')->middleware('admin');

        Route::post('/articles/add','NewsController@addArticle');    
        
    });
});

Route::prefix('news')->group(function () {
    Route::get('/articles/get-category','NewsController@getCategoryList');
    Route::get('/articles/get-list','NewsController@getList'); 
    
    Route::get('/{slug}','NewsController@getDetails');
    Route::get('/category/{slug}','NewsController@getNewsCategoryDetails');
    
    Route::post('/category/get-subcategory','NewsController@getSubCat');
    Route::post('/{slug}/get-infos','NewsController@getInfoDetails');

});

// Auth routes
Route::post('/connexion','Auth\LoginController@connexion');

Auth::routes();
