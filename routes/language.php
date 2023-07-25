<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Addons\LanguagesController;


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


Route::group(['middleware' =>'AuthMiddleware'],function(){

    Route::group(['middleware' =>'AdminMiddleware' , 'prefix' => 'admin'],function(){
        // Language-settings
		Route::get('language-settings', [LanguagesController::class,'index']);
		Route::get('language-settings/add', [LanguagesController::class,'add']);
		Route::post('language-settings/store', [LanguagesController::class,'store']);
		Route::get('language-settings/{code}', [LanguagesController::class,'index']);
		Route::post('language-settings/layout/update', [LanguagesController::class,'layout']);
		Route::post('language-settings/layout/status', [LanguagesController::class,'status']);
        Route::post('language-settings/update', [LanguagesController::class,'storeLanguageData']);
    });

});