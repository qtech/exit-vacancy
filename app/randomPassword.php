<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class randomPassword extends Model
{
    public static function randomPassword($chars) 
	{
        $data = 'ABCDEFGH12389IRSTUVWXYZ4567JKLMNOPQ';
        $pass = substr(str_shuffle($data), 0, $chars);
        return $pass;
    }
    
    public static function randomFloat($min, $max, $decimals = 0) 
    {
        $scale = pow(10, $decimals);
        return mt_rand($min * $scale, $max * $scale) / $scale;
    }
}
