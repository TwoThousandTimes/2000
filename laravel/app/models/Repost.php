<?php 
class Repost extends Eloquent {
		
	//Just to be sure!
	protected $table = 'reposts';

	public function posts()
    {
        return $this->hasMany('Post', 'post_id');
    }	
	
}
