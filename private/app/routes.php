<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => 'index', 'uses' => 'HomeController@home'));

Route::match(array('GET', 'POST'), '/login', array('as' => 'login', 'uses' => 'LoginController@login'));
Route::get('/logout', array('as' => 'logout', 'uses' => 'LoginController@logout'));

Route::match(array('GET', 'POST'), '/register', array('as' => 'register', 'uses' => 'LoginController@register'));

Route::get('/track/rec', array('as' => 'rec_track', 'uses' => 'TrackController@rec'));
Route::get('/track/mix', array('as' => 'mix_track', 'uses' => 'TrackController@mix'));
Route::match(array('GET', 'POST'), '/track/create', array('as' => 'create_track', 'uses' => 'TrackController@create'));
Route::get('/t/{id}', array('as' => 'track', 'uses' => 'TrackController@show'));

Route::match(array('GET', 'POST', 'PUT'), '/t/{id}/metadata', array('as' => 'jam_track', 'uses' => 'TrackController@create'));
Route::match(array('GET', 'POST', 'PUT'), '/t/{id}/edit', array('as' => 'edit_track', 'uses' => 'TrackController@edit'));
Route::match(array('GET', 'POST', 'PUT'), '/t/{id}/jam', array('as' => 'rec_track', 'uses' => 'TrackController@rec'));
Route::match(array('GET', 'POST', 'PUT'), '/t/{id}/mix', array('as' => 'mix_track', 'uses' => 'TrackController@mix'));

Route::get('/search', array('as' => 'search', 'uses' => 'SearchController@search'));
Route::get('/u/{user}', array('as' => 'user', 'uses' => 'UserController@profile'));
Route::get('/home', array('as' => 'search', 'uses' => 'UserController@feed'));

Route::get('/{name}', function($name)
{
	return Twig::render($name);
});
