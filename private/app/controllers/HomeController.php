<?php

class HomeController extends BaseController {

	public function home(){
		if(Auth::check()){
			return Redirect::intended('/home');
		}
		return View::make('index', array(
			'tracks' => Track::limit(4)->orderBy('created_at', 'desc')->get(),
			'users' => User::limit(24)->orderByRaw("RAND()")->get(),
			'users_count' => User::count()
		));
	}

}