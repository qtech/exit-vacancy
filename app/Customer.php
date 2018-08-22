<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $table = "customer";
    protected $primaryKey = "customer_id";

    protected $fillable = ['user_id','number','terms_status'];
}
