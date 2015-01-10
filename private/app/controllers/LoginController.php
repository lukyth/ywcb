<?php

class LoginController extends BaseController {

	public function login()
	{
		if(Request::isMethod('post')){
			if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')))){
				return Redirect::intended('/');
			}else{
				Session::flash('error', 'Login fail');
			}
		}
		return View::make('login');
	}

	public function register(){
		if(Request::isMethod('post')){
			$validator = Validator::make(
				Input::all(),
			    array(
			    	'email' => 'required|max:255|email|unique:users',
			    	'password' => 'required|confirmed',
			    )
			);
			if($validator->passes()){
				$user = new User;
				$user->email = Input::get('email');
				$user->password = Hash::make(Input::get('password'));
				$user->save();
				Session::flash('message', 'Registered successfully');
				return Redirect::intended('/login');
			}else{
				return Redirect::to('register')->withErrors($validator);
			}
		}
		return View::make('register');
	}

}
