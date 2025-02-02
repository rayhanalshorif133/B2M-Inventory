<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;

class WebController extends Controller
{
    public function account(Request $request)
    {

        if(Auth::check()){
            $profile_image = Auth::user()->image;
            $user_id = Auth::user()->id;
        }
        if($request->method() == 'GET'){
            return view('web.account', compact('profile_image'));
        }


        if(!$user_id){
            return redirect()->route('login');
        }

        $user = User::find($user_id);

        if ($request->image) {
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image)); // Delete the old image
            }
            
            $image = $request->file('image');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('/images/user'), $image_name);
            $user->image = '/images/user/' . $image_name;
        }
        
        $user->name = $request->name;
        $user->save();
        
        Session::flash('success', 'Profile updated successfully');
        return redirect()->route('account');



        
    }

    public function category()
    {

        $campaigns = Campaign::select()->get();
        $games = Game::select()->where('status', 1)->get();
        return view('web.category', compact('campaigns', 'games'));
    }

    public function notAllow()
    {

        return view('errors.403');
    }
}
