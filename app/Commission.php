<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    public $table = "commission";
    protected $primaryKey = "id";

    protected $fillable = ['commission_type','commission'];
}
