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

Route::get('/', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Admin'], function() {
    Route::group(['as' => 'file.'], function() {
        Route::get('/file-download/{id}', 'FileUploadController@download')->name('download');
    });
    Route::group(['as' => 'post.'], function() {
        Route::get('/post/{id}', 'PostController@show')->name('show');
    });
    Route::get('/sigout', 'ContentController@logout')->name('sigout');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth', 'as' => 'admin.'], function() {
    Route::group(['as' => 'file.'], function() {
        Route::post('/file-upload', 'FileUploadController@store')->name('store');
        Route::get('/file', 'FileUploadController@index')->name('index');
        Route::post('/file-delete/{id}', 'FileUploadController@delete')->name('delete');
        Route::post('/file/upload', 'FileUploadController@uploadImage')->name('upload');

    });
    Route::group(['as' => 'content.'], function() {
        Route::put('/update-banner/{id}', 'ContentController@updateBanner')->name('banner');
        Route::put('/update-summary/{id}', 'ContentController@updateSummary')->name('summary');
        Route::put('/update-description/{id}', 'ContentController@updateDescription')->name('description');
        Route::put('/update-progress/{id}', 'ContentController@updateProgress')->name('progress');
        Route::put('/update-outcome/{id}', 'ContentController@updateOutcome')->name('outcome');
        Route::put('/update-impact/{id}', 'ContentController@updateImpact')->name('impact');
        Route::get('/dashboard', 'ContentController@index')->name('dashboard');
    });
    Route::group(['prefix' => 'post', 'as' => 'post.'], function() {
        Route::get('/', 'PostController@index')->name('index');
        Route::get('/create', 'PostController@create')->name('create');
        Route::get('/edit/{id}', 'PostController@edit')->name('edit');
        Route::post('/update/{id}', 'PostController@update')->name('update');
        Route::post('/store', 'PostController@store')->name('store');
        Route::post('/delete/{id}', 'PostController@delete')->name('delete');
    });
});

Route::get('/test', 'HomeController@test');

Route::get('/news', function() {
    return view('news');
});