<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // userLogs
    public function userLogs(Request $request){
        return view('user.logs');
    }
}
