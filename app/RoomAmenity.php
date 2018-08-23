<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomAmenity extends Model
{
    public $table = "room_amenities";
    protected $primaryKey = "room_amenity_id";

    protected $fillable = ['name', 'status'];
}
