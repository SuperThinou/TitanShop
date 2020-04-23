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

/**
 * INSTALLATION ROUTES
 */
Route::middleware('shopIsNotInstalled')->group(function() {
    Route::get('/install', 'Main\InstallController@index')->name('install');
    Route::get('/install/database', 'Main\InstallController@databaseStep')->name('install.database');
    Route::post('/install/database', 'Main\InstallController@databaseUpdate')->name('settings.database.update');
    Route::get('/install/informations', 'Main\InstallController@informationsStep')->name('install.informations');
    Route::post('/install/informations', 'Main\InstallController@informationsUpdate')->name('settings.updateOrCreate');
    Route::get('/install/admin', 'Main\InstallController@adminStep')->name('install.admin');
    Route::post('/install/admin', 'Users\AdminController@store')->name('install.admin.post');
    Route::get('/install/success', 'Main\InstallController@success')->name('install.success');
});
/** --------------------- */


Route::middleware('shopIsInstalled')->group(function() {
    Route::get('/', 'Main\MainController@index')->name('index');
    Route::get('/product/{product}', 'Products\ProductBaseController@show')->name('product.show');
    Route::get('/category/{category}', 'Categories\CategoryBaseController@show')->name('category.show');

    /**
     * CUSTOMER AREA
     */
    Route::middleware('guest')->group(function() {
        Route::get('/customer-area/login', 'Auth\LoginController@show')->name('customer_area.login');
        Route::post('/customer-area/login', 'Auth\LoginController@login')->name('customer_area.login.post');
        Route::get('/customer-area/register', 'Auth\RegisterController@show')->name('customer_area.register');
        Route::post('/customer-area/register', 'Auth\RegisterController@register')->name('customer_area.register.post');
    });

    Route::middleware('auth')->group(function() {
        Route::get('/customer-area', 'Auth\CustomerAreaController@show')->name('customer_area.index');
    });
     /** --------------------- */

    /**
     * ADMIN BACKOFFICE
     */
    Route::middleware('notAdmin')->group(function() {
        Route::get('/admin/login', 'Admin\Auth\LoginController@showLoginPage')->name('admin.login');
        Route::post('/admin/login', 'Admin\Auth\LoginController@login')->name('admin.login.post');
    });

    Route::middleware('admin')->group(function() {
        Route::get('/admin', 'Admin\AdminController@index')->name('admin');
        Route::any('/admin/logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');
    });
     /** --------------------- */
});
