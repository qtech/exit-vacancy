<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    public $table = "bookings";
    protected $primaryKey = "booking_id";

    public function customer()
    {
        return $this->hasOne('App\Customer','user_id','user_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
