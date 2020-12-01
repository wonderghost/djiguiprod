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
Route::get('/get-banner','CarousselController@getBanner');
Route::get('/news','NewsController@index');

Route::get('/news/add-article','NewsController@articleGetForm');
// Route  de la recuperation des artticles
Route::get('/news/edit-article{slug}','NewsController@articleEditForm');
Route::post('/news/update-article','NewsController@articleUpdate');
Route::post('/news/wave-article','NewsController@articleWave');
Route::post('/news/delete-article','NewsController@articleDelete');
Route::post('/news/restore-article','NewsController@articleRestore');

Route::get('/news/all-article','NewsController@allArticles');
// fin

// recuperation, modification et suppression des pages
Route::post('/admin/delete-page','PageController@deletePage');
Route::post('/admin/update-page','PageController@pageUpdate');
Route::get('/admin/edit-page{slug}','PageController@EditPage');
// fin

 // Les pur le traitement des banieres

    Route::get('/admin/bannieres','CarousselController@index');
    Route::post('/admin/save-caroussel','CarousselController@store');
    Route::get('/admin/allBanner','CarousselController@create');
    
    Route::post('/admin/active-banner','CarousselController@activeBanner');
    Route::post('/admin/block-banner','CarousselController@blockBanner');

// fin


Route::prefix('prestations')->group(function () {
    Route::get('/','PageController@prestationIndex');
    Route::post('/get-prestation-details','PageController@getPrestationDetails');
    Route::get('/{slug}','PageController@prestationDetails');
});
Route::get('/about-us','PageController@aboutUs');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['admin'])->group(function () {

        Route::prefix('admin')->group(function () {

            Route::get('/manage-pages','PageController@index'); //
            Route::get('/manage-users','UserController@index');
            Route::get('/page','PageController@getListPage');        
            Route::post('/page/add','PageController@addPage');
            Route::post('/users/add','UserController@addUsers');
        });

        Route::prefix('news')->group(function () {
            Route::post('/articles/add-category','NewsController@postCategory');
            Route::post('/articles/add-sub-category','NewsController@postSubCategory');
        });
    });

    Route::prefix('news')->group(function () {
            
        Route::get('/articles/add','NewsController@articleGetForm');
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
