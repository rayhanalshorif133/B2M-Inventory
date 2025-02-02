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

        if(!Auth::check()){
            $user = User::select()->where('id', '!=', 1)->first();
            Auth::login($user);
        }

    
        $campaigns = Campaign::select()
            ->get()
            ->each(function ($campaign) {
                $campaign = $campaign->calculateTimeForCampaign($campaign);
            });
        return view('home', compact('campaigns'));
    }




    public function admin()
    {
        if (Auth::check()) {
            if (Auth::user()->roles[0]->name == "admin") {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
