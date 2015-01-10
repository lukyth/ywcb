<?php

class HomeController extends BaseController {

	public function home(){
		return View::make('index', array(
			'tracks' => Track::limit(4)->get(),
			'users' => User::limit(24)->get(),
			'users_count' => User::count()
		));
	}

}