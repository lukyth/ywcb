<?php

class SearchController extends BaseController{
	public function search(){
		$q = Input::get('q');
		$result = Track::orderBy('created_at', 'desc');

		if($q){
			$result = $result->where('name', 'LIKE', '%' . $q . '%');
		}

		if(Input::has('instrument')){
			$result = $result->where('instrument', '=', Input::get('instrument'));
		}

		$result = $result->paginate(15);

		return View::make('search', array(
			'tracks' => $result,
			'search' => $q
		));
	}
}