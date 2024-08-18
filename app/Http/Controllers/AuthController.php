<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordMail;
use Exception;

class AuthController extends Controller
{


    public function __construct()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
    }



    public function login(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('auth.login');
        }

        if (!$request->email || !$request->password) {
            return $this->respondWithError('error', 'Email or password required');
        }




        $user = User::select()->where('email', $request->email)->first();
        if (!$user) {
            return $this->respondWithError('error', 'User not found');
        }


        if (Hash::check($request->password, $user->password)) {

            Auth::login($user);
            $request->session()->put('loginId', $user->id);
            return $this->respondWithSuccess("success", 'Successfully logged in');
        } else {
            return $this->respondWithSuccess("error", 'Credentials is invalid or not found');
        }
    }









    // Registers

    public function register(Request $request)
    {


        if ($request->method() == 'GET') {
            return view('auth.register');
        }


        try {

            if ($request->user_info && $request->company_info) {
                $GET_User = $request->user_info;
                $GET_Company = $request->company_info;

                $find_user_email = User::findByEmail($GET_User);

                if ($find_user_email) {
                    return $this->respondWithError("error", 'Duplicate email address');
                }

                DB::beginTransaction();




                $company = new Company();
                $company->name = $GET_Company['name'];
                $company->email = $GET_Company['email'];



                $img = $GET_Company['logo'];
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $file_name = 'images/' . uniqid() . '.png';
                Storage::disk('public')->put($file_name, $data);
                $company->logo = $file_name;

                $company->address = $GET_Company['address'];
                $company->other_info = $GET_Company['other_info'];
                $company->save();


                $user = new User();
                $user->name = $GET_User['name'];
                $user->name = $GET_User['name'];
                $user->email = $GET_User['email'];
                $user->password = Hash::make($GET_User['password']);
                $user->company_id = $company->id;
                $user->save();
                $user->assignRole('super-admin');

                DB::commit();

                return $this->respondWithSuccess('success', 'Registration successful');
            }
        } catch (Exception $th) {
            DB::rollBack();
            return $this->respondWithError("error", $th->getMessage());
        }
    }


    // forgotPassword
    public function forgotPassword(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('auth.forgot-password');
        }


        try {

            $user = User::select()->where('email', $request->email)->first();


            if ($user) {


                $passwordReset = new PasswordReset();
                $passwordReset->user_id = $user->id;
                $passwordReset->email = $user->email;
                $passwordReset->token = $this->getToken();



                $details = [
                    'user_name' => $user->name,
                    'url' => url('reset-password?email=' . $user->email . '&token=' . $passwordReset->token)
                ];


                Mail::to($request->email)
                    ->send(new ForgotPasswordMail($details));


                $passwordReset->email_send = 'send';
                $passwordReset->verify_status = 'pending';
                $passwordReset->save();



                return $this->respondWithSuccess("success", 'Please check your email');
            } else {
                return $this->respondWithError("error", 'User not found');
            }
        } catch (\Throwable $th) {
            return $this->respondWithError("error", $th->getMessage());
        }
    }

    public function resetPassword(Request $request)
    {
        if ($request->method() == 'GET') {

            $email = $request->get('email');
            $token = $request->get('token');
            $findPasswordReset = PasswordReset::select()->where('email', $email)->where('token', $token)->first();
            if ($findPasswordReset) {
                $findPasswordReset->verify_status = 'verified';
                $findPasswordReset->save();
                return view('auth.reset-password');
            } else {
                dd('no password reset');
            }
        }

        try {
            $user = User::select()->where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            return $this->respondWithSuccess('success', 'Password reset successful');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong!');
        }
    }


    // logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('loginId');
        return $this->respondWithSuccess('success', 'logout successful');
    }


    protected function getToken()
    {
        $token = Str::random(20);
        $token = Hash::make($token);
        $is_used = PasswordReset::select('id')->where('token', $token)->first();

        if ($is_used) {
            $this->getToken();
        }

        return $token;
    }
}
