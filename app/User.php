<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\VerifyApiEmail;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;
    protected $guard_name = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password',
        'ip',
        'country',
        'city',
        'continent',
        'latitude',
        'longitude',
        'currency_symbol',
        'currency_code',
        'timezone',
        'status',
        'phone',
        'subject',
        'messege',
        'reset_token',
        'token_expiry',
        'verified_at',
        'google_id',
        'fb_id',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

//    public function sendApiEmailVerificationNotification()
//    {
//       $this->notify(new VerifyApiEmail); // my notification
//    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function comment() {
		return $this->hasMany('App\Comment');
	}
    public function review() {
		return $this->hasMany('App\Review');
	}

    public function favoritePackages()
    {
        return $this->belongsToMany('App\Package', 'favorite_packages', 'user_id','package_id');
    }
}
