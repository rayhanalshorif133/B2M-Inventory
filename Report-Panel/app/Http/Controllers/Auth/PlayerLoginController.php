<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PlayerLoginController extends Controller
{

    public function login(Request $request)
    {
        // Validate input data
        $request->validate([
            'phone' => 'required|string|min:10|max:15',
            'password' => 'required|string|min:4',
        ]);

        // Attempt authentication
        $credentials = $request->only('phone', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Session::flash('success', 'Login successful!');
        }else{
            Session::flash('error', 'Invalid credentials. Please try again.');
        }
        return redirect()->back();
    }

    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'string|min:2|max:15',
            'phone' => 'required|string|min:10|max:15|unique:users', // Ensure phone is unique
            'password' => 'required|string|min:4', // Confirm password field
        ]);

        if ($validator->fails()) {
            // Return validation errors as JSON if the request expects JSON
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create a new user
        $player = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);


        $player->assignRole('player');
        // Attempt authentication

        $credentials = $request->only('phone', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Session::flash('success', 'Login successful!');
        }else{
            Session::flash('error', 'Invalid credentials. Please try again.');
        }
        return redirect()->back();
    }
}
