<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    public $table = "query";
    protected $primaryKey = "id";

    protected $fillable = ['subject', 'email', 'message', 'number'];
}
