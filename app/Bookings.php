<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    public $table = "bookings";
    protected $primaryKey = "booking_id";

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'user_id');
    }
}
