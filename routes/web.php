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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['as'=>'products.','prefix'=>'products'],function(){
    Route::get('/','ProductController@show')->name('all');
});

Route::group(['as'=>'admin.', 'middleware' => ['auth','admin'],'prefix'=> 'admin'], function(){
    Route::get('/dashboard','AdminController@dashboard')->name('dashboard');
    Route::view('product/extras', 'admin.partials.extras')->name('product.extras');
    Route::get('profile/states/{id?}', 'ProfileController@getStates')->name('profile.states');
    Route::get('profile/cities/{id?}', 'ProfileController@getcities')->name('profile.cities');
    Route::resource('product','ProductController');
    Route::resource('category', 'CategoryController');
    Route::resource('profile' , 'ProfileController');

});
