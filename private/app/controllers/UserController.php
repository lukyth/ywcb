<?php

class UserController extends BaseController {
	public function profile($uid){
		try{
			$user = User::findOrFail($uid);
			return View::make('user', array(
				'user' => $user,
				'tracks' => $user->tracks->sortBy('created_at', SORT_REGULAR, true)
			));
		}catch(Illuminate\Database\Eloquent\ModelNotFoundException $e){
			App::abort(404);
		}
	}

	public function feed(){
		if(!Auth::check()){
			return Redirect::intended('/');	
		}
		return View::make('myfeed', array(
			'tracks' => Track::orderBy('created_at', 'desc')->get(),
		));
	}
}