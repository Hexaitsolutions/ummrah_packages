<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
     protected $with=['option'];
     public function option()
    {
    	return $this->belongsTo('App\Option');
    }

     public function question() {
		return $this->hasMany('App\Question');
	}
     public function comment() {
		return $this->hasMany('App\Comment');
	}
     public function review() {
		return $this->hasMany('App\Review');
	}
     public function agency() {
		return $this->belongsTo('App\Agency');
	}

	public function user()
    {
        return $this->belongsToMany('App\User', 'favorite_packages', 'user_id','package_id');
    }
}
