<?php

class Track extends Eloquent{
	public function user(){
        return $this->belongsTo('User', 'user');
    }

    public function parents(){
        return $this->belongsToMany('Track', 'track_rel', 'track_1', 'track_2');
    }

    public function get_player_data(){
		$out = array();
		foreach($this->parents() as $item){
			$out[] = array(
				$item->file,
				$item->shift
			);
		}
		$out[] = array(
			$this->file,
			$this->shift
		);
		return $out;
    }
}