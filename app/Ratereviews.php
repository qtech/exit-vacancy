<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ratereviews extends Model
{
    public $table = "rate_reviews";
    protected $primaryKey = "review_id";

    protected $fillable = ['user_id', 'hotel_id', 'ratings', 'review_comment'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function hotel()
    {
        return $this->belongsTo('App\Hoteldata', 'hotel_id');
    }
}
