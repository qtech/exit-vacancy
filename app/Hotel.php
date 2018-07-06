<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    public $table = "hotel";
    protected $primaryKey = "hotel_id";

    protected $fillable = ['user_id','hotel_name','number','building','street','landmark','city','state','country','zipcode','terms_status'];
}
