<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');
Route::get('top','AnimeController@index' );
Route::get('animation/{name}+{type}+{part}',['as'=>'anime','uses'=>'AnimeController@animation'] );
Route::post('vote','AnimeController@vote');
Route::post('addcomment',['as'=>'addcom','uses'=>'AnimeController@addComment']);
Route::post('addtobook',['as'=>'addbook','uses'=>'AnimeController@addToBookmarks']);
Route::get('profile/{id}',['as'=>'prof','uses'=>'AnimeController@profile']);
Route::post('deleteitem',['as'=>'del','uses'=>'AnimeController@deleteItem']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
