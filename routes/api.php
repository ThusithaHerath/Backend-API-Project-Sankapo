<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
	Route::post('signup', 'App\Http\Controllers\Api\Auth\AuthController@signup')->name('auth.signup');
	Route::post('login', 'App\Http\Controllers\Api\Auth\AuthController@login')->name('auth.login');
	Route::post('logout', 'App\Http\Controllers\Api\Auth\AuthController@logout')->middleware('auth:sanctum')->name('auth.logout');
	Route::get('user', 'App\Http\Controllers\Api\Auth\AuthController@getAuthenticatedUser')->middleware('auth:sanctum')->name('auth.user');

	Route::post('/password/email', 'App\Http\Controllers\Api\Auth\AuthController@sendPasswordResetLinkEmail')->middleware('throttle:5,1')->name('password.email');
	Route::post('/password/reset', 'App\Http\Controllers\Api\Auth\AuthController@resetPassword')->name('password.reset');


	Route::get('account/verify/{token}')->middleware('is_verify_email');
});

Route::prefix('category')->group(function () {
	Route::post('create', 'App\Http\Controllers\Api\CategoriesController@create')->name('category.store');
	Route::get('list', 'App\Http\Controllers\Api\CategoriesController@show')->middleware('isAdmin')->name('category.list');
	Route::get('edit/{id}', 'App\Http\Controllers\Api\CategoriesController@edit')->name('category.edit');
	Route::put('update/{id}', 'App\Http\Controllers\Api\CategoriesController@update')->name('category.update');
	Route::delete('delete/{id}', 'App\Http\Controllers\Api\CategoriesController@destroy')->name('category.delete');
});

Route::prefix('add')->group(function () {
	Route::post('create', 'App\Http\Controllers\Api\AddProductsController@create')->name('add.store');
	Route::get('show', 'App\Http\Controllers\Api\AddProductsController@show')->name('add.show');
});

// property 
Route::prefix('property')->group(function () {
	Route::post('create', 'App\Http\Controllers\Api\PropertiesController@create')->name('property.store');
	Route::get('list', 'App\Http\Controllers\Api\PropertiesController@showAll')->name('property.list');
	Route::get('list/{status}', 'App\Http\Controllers\Api\PropertiesController@showPropertyAds')->name('property.listFilter');
	Route::get('search/{id}', 'App\Http\Controllers\Api\PropertiesController@search')->name('property.search');
	Route::post('update/{id}', 'App\Http\Controllers\Api\PropertiesController@update')->name('property.update');
	Route::delete('delete/{id}', 'App\Http\Controllers\Api\PropertiesController@destroy')->name('property.delete');

	//not completed
	Route::post('approve/{id}', 'App\Http\Controllers\Api\PropertiesController@approveAd')->name('property.approve');
});