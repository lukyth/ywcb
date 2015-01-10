<?php

class Track extends Eloquent{
	public function user(){
        return $this->belongsTo('User', 'user');
    }

    public function parents(){
        return $this->belongsToMany('Track', 'track_rel', 'track_1', 'track_2');
    }
}