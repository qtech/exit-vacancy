<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hoteldata extends Model
{
    public $table = "hotel_data";
    protected $primaryKey = "hotel_data_id";

    // protected $fillable = ['user_id','hotel_name','number','building','street','landmark','city','state','country','zipcode','terms_status','latitude','longitude'];
}
