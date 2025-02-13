<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function login(Request $request)
    {

        if ($request->method() == 'POST') {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }

            return back()->withErrors([
                'email' => 'Invalid credentials. Please try again.',
            ]);
        }

        return view('auth.login');
    }

    public function profile(Request $request)
    {
        if ($request->method() == 'POST') {
            $user = Auth::user();
            if (Hash::check($request->current_password, $user->password)) {
                if ($request->new_password == $request->confrim_password) {
                    $user = User::find(Auth::user()->id);
                    $user->name = $request->name;
                    $user->password = Hash::make($request->new_password);
                    $user->save();
                    Session::flash('success', 'Profile has been successfully updated.');
                    return redirect()->back(); // this keeps the input values in the form
                } else {
                    Session::flash('error', 'Password confirmation is not match');
                    return redirect()->back()->withInput(); // this keeps the input values in the form
                }
            } else {
                Session::flash('error', 'Current password is incorrect');
                return redirect()->back()->withInput(); // this keeps the input values in the form

            }
        }

        return view('auth.profile');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logs out the user

        $request->session()->invalidate(); // Invalidates the session
        $request->session()->regenerateToken(); // Regenerates the CSRF token

        return redirect()->route('login');
    }
}
