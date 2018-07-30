<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AppusersController extends Controller
{
    public function view()
    {
        $users = User::with('customer')->where(['role' => 2])->get();
        return view('appusers.main')->with('users', $users);
    }

    public function delete($id)
    {
        $delete = User::find($id)->delete();
        return redirect()->route('appusers')->with('success', 'User deleted successfully');
    }
}
