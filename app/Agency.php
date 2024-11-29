<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    public function package() {
		return $this->hasMany('App\Package');
	}

	public function agent()
    {
        return $this->belongsTo('App\Admin','user_id', 'id');
    }
}
