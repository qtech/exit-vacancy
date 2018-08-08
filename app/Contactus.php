<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    public $table = "contactus";
    protected $primaryKey = "id";

    protected $fillable = ['email','address','number'];
}
