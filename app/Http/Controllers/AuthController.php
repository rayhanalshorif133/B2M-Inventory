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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
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

            $find_user_email = User::findByEmail($request->user_email);

            if ($find_user_email) {
                Session::flash('error', 'Duplicate email address');
                return redirect()->back()->withInput();
            }

            DB::beginTransaction();



            $company = new Company();
            $company->name = $request->company_name;
            $company->email = $request->company_email;
            if ($request->hasFile('logo')) {
                // $logoPath = $request->file('logo')->store('logos', 'public');
                $file = $request->file('logo');

                // Define the custom directory path
                $destinationPath = public_path('images/user');

                // Generate a unique file name
                $fileName = uniqid() . '_' . $file->getClientOriginalName();

                // Move the file to the destination path
                $file->move($destinationPath, $fileName);

                // Store the file path to save in the database
                $logoPath = 'images/user/' . $fileName;

                // Example of saving it to a model
                $company->logo = $logoPath;
            }
            $company->address = $request->company_address;
            $company->other_info = $request->other_info;
            $company->save();




            $user = new User();
            $user->name = $request->user_name;
            $user->email = $request->user_email;
            $user->password = Hash::make($request->user_password);
            $user->company_id = $company->id;
            $user->save();
            $user->assignRole('super-admin');

            DB::commit();

            Session::flash('success', 'User created successfully!');
            return redirect()->route('auth.login');
        } catch (Exception $th) {
            DB::rollBack();
            Session::flash('error', 'Something went wrong.');
            return redirect()->back()->withInput();
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
