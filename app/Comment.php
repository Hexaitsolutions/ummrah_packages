<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function package() {
		return $this->belongsTo('App\Package');
	}
    public function user() {
		return $this->belongsTo('App\User');
	}
}
