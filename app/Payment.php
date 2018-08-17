<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $table = "payment_details";
    protected $primaryKey = "payment_id";

    protected $fillable = ['hotel_owner_id', 'account_name', 'account_type', 'routing_number', 'account_number', 'email', 'day', 'month', 'year', 'fname', 'lname'];
}
