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
	Route::get('/password/reset/{token}', 'App\Http\Controllers\Api\Auth\AuthController@showResetForm')->middleware('web')->name('password.reset.form');
	Route::post('/password/reset', 'App\Http\Controllers\Api\Auth\AuthController@resetPassword')->name('password.reset');

	//change password of admin 
	Route::post('/password/change/{id}', 'App\Http\Controllers\Api\Auth\AuthController@changePassword')->name('password.change');

	Route::get('account/verify/{token}')->middleware('is_verify_email');
	Route::get('account/verified/{msg}', 'App\Http\Controllers\Api\Auth\AuthController@verifiedEmail')->name('account.verified');
});

Route::prefix('profile')->group(function(){
	Route::get('/mylistings/{id}', 'App\Http\Controllers\Api\Auth\AuthController@mylistings')->name('profile.mylistings');
	Route::get('/myprofile/{id]', 'App\Http\Controllers\Api\Auth\AuthController@myprofile')->name('profile.myprofile');
});

Route::prefix('category')->group(function () {
	Route::post('create', 'App\Http\Controllers\Api\CategoriesController@create')->name('category.create');
	Route::get('list', 'App\Http\Controllers\Api\CategoriesController@show')->name('category.list');
	Route::get('edit/{id}', 'App\Http\Controllers\Api\CategoriesController@edit')->name('category.edit');
	Route::put('update/{id}', 'App\Http\Controllers\Api\CategoriesController@update')->name('category.update');
	Route::delete('delete/{id}', 'App\Http\Controllers\Api\CategoriesController@destroy')->name('category.delete');
});

Route::prefix('ad')->group(function () {
	Route::post('store', 'App\Http\Controllers\Api\AddProductsController@store')->name('ad.store');
	Route::get('showAll', 'App\Http\Controllers\Api\AddProductsController@showAll')->name('ad.showAll');
	Route::get('approved', 'App\Http\Controllers\Api\AddProductsController@approved')->name('ad.approved');
	Route::get('declined', 'App\Http\Controllers\Api\AddProductsController@declined')->name('ad.declined');
	Route::post('approve/{id}', 'App\Http\Controllers\Api\AddProductsController@approveAd')->name('ad.approve');
	Route::post('decline/{id}', 'App\Http\Controllers\Api\AddProductsController@declineAd')->name('ad.decline');
	Route::get('search/{id}', 'App\Http\Controllers\Api\AddProductsController@search')->name('ad.search');
	Route::get('latest', 'App\Http\Controllers\Api\AddProductsController@latestAds')->name('ad.latest');
	Route::get('searchbycat/{id}', 'App\Http\Controllers\Api\AddProductsController@searchbycat')->name('ad.searchbycat');
});

// property 
Route::prefix('property')->group(function () {
	Route::post('store', 'App\Http\Controllers\Api\PropertiesController@create')->name('property.store');
	Route::get('showAll', 'App\Http\Controllers\Api\PropertiesController@showAll')->name('property.showAll');
	Route::get('approved', 'App\Http\Controllers\Api\PropertiesController@approved')->name('property.approved');
	Route::get('declined', 'App\Http\Controllers\Api\PropertiesController@declined')->name('property.declined');
	Route::post('approve/{id}', 'App\Http\Controllers\Api\PropertiesController@approveAd')->name('property.approve');
	Route::post('decline/{id}', 'App\Http\Controllers\Api\PropertiesController@decline')->name('property.decline');
	Route::get('latest', 'App\Http\Controllers\Api\PropertiesController@latestProperties')->name('property.latest');
	Route::get('search/{id}', 'App\Http\Controllers\Api\PropertiesController@search')->name('property.search');
	Route::post('update/{id}', 'App\Http\Controllers\Api\PropertiesController@update')->name('property.update');
	Route::delete('delete/{id}', 'App\Http\Controllers\Api\PropertiesController@destroy')->name('property.delete');
});


// auction 
Route::prefix('auction')->group(function () {
	Route::post('create', 'App\Http\Controllers\Api\AuctionController@create')->name('auction.store');
	Route::get('list', 'App\Http\Controllers\Api\AuctionController@showAllActive')->name('auction.list');
	Route::get('filter/{status}', 'App\Http\Controllers\Api\AuctionController@filterAuctions')->name('auction.listFilter');
	Route::get('search/{id}', 'App\Http\Controllers\Api\AuctionController@search')->name('auction.search');
	Route::post('update/{id}', 'App\Http\Controllers\Api\AuctionController@update')->name('auction.update');
	Route::post('winner/{auction_id}', 'App\Http\Controllers\Api\AuctionController@addWinner')->name('auction.winner');
	// Route::delete('delete/{id}', 'App\Http\Controllers\Api\AuctionController@destroy')->name('auction.delete');
});


// negotiation 
Route::prefix('negotiation')->group(function () {
	Route::post('create', 'App\Http\Controllers\Api\NegotiationController@create')->name('negotiation.store');
	Route::get('list/{auction_id}', 'App\Http\Controllers\Api\NegotiationController@auctionNegotiations')->name('negotiation.list');
	Route::post('update/{id}', 'App\Http\Controllers\Api\NegotiationController@update')->name('negotiation.update');
	// Route::delete('delete/{id}', 'App\Http\Controllers\Api\NegotiationController@destroy')->name('negotiation.delete');
});

