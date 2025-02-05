<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerify;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{

    public function getToken($length) {
        return bin2hex(random_bytes($length));
    }
    public function sendEmailVarify()
    {
    

        $user = Auth::user();
        $user->remember_token = $this->getToken(15);
        $user->save();

        $data = [
            'name' => $user->name,
            'token' => $user->remember_token,
        ];

        Mail::to($user->email)->send(new EmailVerify($data));

        return "Email has been sent!";
    } 
    
    public function verify($token)
    {
        // email_verified_at
        $user = User::select()->where('remember_token', $token)->first();
        if($user && $user->email_verified_at == null){
            $user->email_verified_at = now();
            $user->save();
            $type = 'success';
            return view('emails.verify-message', compact('type'));
        }else if($user && $user->email_verified_at){
            $type = 'already_verified';
            return view('emails.verify-message', compact('type'));
        }else{
            $type = 'error';
            $user->email = null;
            $user->save();
            return view('emails.verify-message', compact('type'));
        }
    } 
    
}
