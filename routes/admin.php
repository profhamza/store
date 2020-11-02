<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

define('COUNT_PAGINATION', 10);

Route::group(['namespace' => 'App\Http\Controllers\Admin\Auth'], function () {
    Route::get('login', 'LoginController@showLogin')->name('admin.login');
    Route::post('login', 'LoginController@checkAuthentication')->name('admin.authenticate');
});

Route::group(['namespace' => 'App\Http\Controllers\Admin'], function () {
    Route::get('/', 'HomeController@showDashboard')->name('admin.dashboard');
    Route::get('logout', 'HomeController@logout')->name('admin.logout');

    /*************** Start Language Controller Group ***************/
    Route::resource('languages', 'LanguageController');
    /*************** End Language Controller Group ****************/

    /*************** Start Main Category Controller Group ***************/
    Route::resource('main-categories', 'MainCatController');
    Route::get('main-categories/{id}/create-languages', 'MainCatController@createAnotherLanguages')->name("main-categories.create-another-languages");
    Route::post('main-categories/store-languages', 'MainCatController@storeAnotherLanguages')->name("main-categories.store-another-languages");
    Route::post('main-categories/{id}', 'MainCatController@activate')->name("main-categories.activate");
    /*************** End Main Category Controller Group *****************/

    /*************** Start Vendor Controller Group ***************/
    Route::resource('vendors', 'VendorController');
    Route::post('vendors/{id}', 'VendorController@activate')->name("vendors.activate");
    /*************** End Vendor Controller Group *****************/
});

