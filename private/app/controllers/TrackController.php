<?php

class TrackController extends BaseController {

	public function create($id=null){
		if(!Auth::check()){
			Session::flash('error', 'Please login');
			return Redirect::to('login');
		}
		$model = null;
		if($id){
			$model = Track::find($id);
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

				// copy parent tree
				if($model){
					foreach($model->parents() as $item){
						$track->parents()->save($item);
					}
					$track->parents()->save($model);
				}

				return Redirect::intended('/t/' . $track->id);
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

}