<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{

    public function login()
    {
       return view('auth.login');
    }
}
