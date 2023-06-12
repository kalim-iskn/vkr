<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController
{
    public function logOut()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
}
