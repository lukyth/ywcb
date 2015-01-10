<?php

class TrackController extends BaseController {

	public function create($id=null){
		if(!Auth::check()){
			Session::flash('error', 'Please login');
			return Redirect::to('login');
		}
		$model = null;
		if($id){
			$model = Track::findOrFail($id);
			if($model->permission != 0 && $model->user != Auth::id()){
				Session::flash('error', 'This track does not allow jamming');
				return Redirect::to('t/'.$model->id.'/jam');
			}
		}
		if(Request::isMethod('post') || Request::isMethod('put')){
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

				$target = '/t/' . $track->id;

				// copy parent tree
				if($model){
					foreach($model->parents() as $item){
						$track->parents()->save($item);
					}
					$track->parents()->save($model);
					$target = '/t/'.$track->id.'/edit';
				}

				return Redirect::intended($target);
			}else{
				if($model){
					$target = 't/'.$model->id.'/jam';
				}else{
					$target = 'track/create';
				}
				return Redirect::to($target)->withErrors($validator);
			}
		}
		return View::make('track_create', array(
			'model' => $model,
			'jam' => !!$id
		));
	}

	public function show($id){
		try{
			return View::make('track', array(
				'track' => Track::findOrFail($id),
				'rel' => TrackRel::where('track_2', $id)->get(),
			));
		}catch(Illuminate\Database\Eloquent\ModelNotFoundException $e){
			App::abort(404);
		}
	}

	public function rec($id=null){
		return View::make('rec', array(
			'track' => Track::find($id),
		));
	}

	public function mix($id=null){
		return View::make('mix', array(
			'track' => Track::find($id),
		));
	}

	public function edit($id){
		if(!Auth::check()){
			Session::flash('error', 'Please login');
			return Redirect::to('login');
		}
		$model = Track::findOrFail($id);
		if($model->user != Auth::id()){
			Session::flash('error', 'You does not own this track');
			return Redirect::to('t/'.$model->id.'/jam');
		}

		if(Request::isMethod('post') || Request::isMethod('put')){
			$validator = Validator::make(
				Input::all(),
			    array(
			    	'shift' => 'required|numeric'
			    )
			);
			if($validator->passes()){
				$model->shift = Input::get('shift');
				$model->save();

				return Redirect::intended('/t/' . $model->id);
			}else{
				return Redirect::to('t/'.$model->id.'/edit')->withErrors($validator);
			}
		}

		return View::make('track_edit', array(
			'track' => $model,
		));
	}

}