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

Route::get('/', function()
{
	return Twig::render('hello', array(
		'group' => 'B'
	));
});

Route::match(array('GET', 'POST'), '/login', array('as' => 'login', 'uses' => 'LoginController@login'));

Route::match(array('GET', 'POST'), '/register', array('as' => 'register', 'uses' => 'LoginController@register'));

Route::match(array('GET', 'POST'), '/track/create', array('as' => 'create_track', 'uses' => 'TrackController@create'));
Route::get('/t/{id}', array('as' => 'track', 'uses' => 'TrackController@show'));

Route::match(array('GET', 'POST', 'PUT'), '/t/{id}/jam', array('as' => 'jam_track', 'uses' => 'TrackController@create'));

Route::get('/{name}', function($name)
{
	return Twig::render($name);
});
