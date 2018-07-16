<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AppusersController extends Controller
{
    public function view()
    {
        $users = User::where(['role' => 2])->get();
        return view('appusers.main')->with('users', $users);
    }
}
