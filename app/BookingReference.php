<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingReference extends Model
{
    public $table = "booking_reference";
    protected $primaryKey = "booking_ref_id";
}
