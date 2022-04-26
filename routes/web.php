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

Route::get('/', 'HomeController@index');
Route::post('/short-url', 'HomeController@short_url')->name("short-url");
Route::get('/short-url/{str}', 'HomeController@redirect_from_short_url');
Route::get('/shortened-url', 'HomeController@shortened_url')->name("shortened-url");


###################### Auth Routes ##########################

Auth::routes();


###################### Frontend Routes ##########################

Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::get('/dashboard', 'UserController@index');

###################### Admin Routes ##########################

Route::get('/admin', 'AdminController@login')->name('admin.login');
Route::post('/admin/login', 'AdminController@admin_login');

Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/unauthorize-access', 'AdminController@unauthorize_access');
    Route::get('/logout', 'AdminController@logout');
    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::post('/update-profile', 'AdminController@update_profile')->name('admin.update.profile');
    Route::get('/profile', 'AdminController@profile')->name('admin.profile');

    Route::get('/urls', 'AdminController@urls')->name('admin.urls');
    Route::get('/get-all-urls', 'AdminController@get_urls');
    Route::get('/get-url/{id}', 'AdminController@get_url');
    Route::post('/activate-deactivate-url', 'AdminController@activate_deactivate_urls');
    Route::post('/update-url', 'AdminController@update_url');
    Route::get('/delete-url/{id}', 'AdminController@delete_urls');

});
