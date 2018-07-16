<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    public $table = "bookings";
    protected $primaryKey = "booking_id";
}
