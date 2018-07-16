<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likedhotels extends Model
{
    public $table = "liked_hotels";
    protected $primaryKey = "like_id";

    public function hotels()
    {
        return $this->belongsTo('App\Hoteldata', 'hotel_id');
    }
}
