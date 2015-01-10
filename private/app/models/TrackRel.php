<?php

class TrackRel extends Eloquent{
	public $table = 'track_rel';

	public function track_1(){
        return $this->belongsTo('Track', 'track_1');
    }

    public function track_2(){
        return $this->belongsTo('Track', 'track_2');
    }
}