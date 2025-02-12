<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{

    public function home()
    {


        if (Auth::check() && Auth::user()->roles[0]->name == "admin") {
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('login');
        }
    }




    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
