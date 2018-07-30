<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = "users";
    protected $primaryKey = "user_id";

    protected $fillable = ['fname','lname','email','password','role'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function customer()
    {
        return $this->hasOne('App\Customer', 'user_id');
    }

    public function hotel()
    {
        return $this->hasOne('App\Hoteldata', 'user_id');
    }
}
