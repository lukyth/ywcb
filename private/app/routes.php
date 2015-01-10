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

Route::get('/login', 'LoginController@login');
Route::post('/login', 'LoginController@login');

Route::get('/register', 'LoginController@register');
Route::post('/register', 'LoginController@register');

Route::get('/{name}', function($name)
{
	return Twig::render($name);
});
