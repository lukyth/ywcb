<?php

class TrackController extends BaseController {

	public function create(){
		if(!Auth::check()){
			Session::flash('error', 'Please login');
			return Redirect::to('login');
		}
		if(Request::isMethod('post')){
			$validator = Validator::make(
				Input::all(),
			    array(
			    	'name' => 'required|max:255',
			    	'file' => 'required',
			    	'instrument' => 'required|in:Bass,Guitar,Drum,Vocal,Synth,Other',
			    	'permission' => 'required|in:0,1,2'
			    )
			);
			if($validator->passes()){
				$track = new Track;
				$track->name = Input::get('name');
				$track->description = Input::get('description');
				$track->instrument = Input::get('instrument');
				$track->permission = Input::get('permission');
				$track->user = Auth::id();

				$file = Input::file('file');
				$uid = uniqid().'.mp3';
				$file->move('../public_html/sound/', $uid);
				$track->file = '/sound/'.$uid;

				$track->save();
				return Redirect::intended('/t/' . $track->id);
			}else{
				return Redirect::to('track/create')->withErrors($validator);
			}
		}
		return View::make('track_create');
	}

	public function show($id){
		Track::findOrFail($id);
	}

}