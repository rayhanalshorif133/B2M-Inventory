<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Otp;
use App\Models\TransactionType;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Mail\ForgotPasswordMail;
use App\Mail\TestMail;
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
            $request->session()->put('company_id', $user->company_id);
            return $this->respondWithSuccess("success", 'Successfully logged in');
        } else {
            return $this->respondWithSuccess("error", 'Credentials is invalid or not found');
        }
    }









    // otpVerify 
    public function otpSend(Request $request)
    {

        if ($request->method() == 'GET') {
            return view('auth.otp-send');
        }

        if ($request->msisdn) {


            $msisdn = $request->msisdn;
            if (substr($msisdn, 0, 2) !== "88") {
                $msisdn = "88" . $msisdn;
            }
            $otp = random_int(1111, 9999);
            $user = User::where('msisdn', $request->msisdn)
                ->orWhere('msisdn', $msisdn)
                ->first();

            if (!$user) {
                $user = new User();
            }

            $user->name = $request->name;
            $user->msisdn = $msisdn;
            $user->otp = $otp;
            $user->otp_verify = 0;
            $user->save();



            // Send OTP Using SMS API
            $apiUrl = "https://bulk.b2m-tech.com/api/sendsms";
            $apiKey = "af8c56f8d14b04bb2e4f";
            $mobileNumber = $msisdn;
            $message =  $otp . " is your one time password (OTP) for baisbd.com. This OTP is valid for 5 minutes.";

            $response = Http::get($apiUrl, [
                'api_key' => $apiKey,
                'mobile_number' => $mobileNumber,
                'message' => $message
            ]);


            $new_otp = new Otp();
            $new_otp->msisdn = $mobileNumber;
            $new_otp->otp = $otp;
            $new_otp->text = $message;
            $new_otp->response = $response;
            $new_otp->save();
            // After sending
            Session::flash('success', 'Successfully sent OTP, please verify your OTP');
            return redirect()->route('auth.otp-verify', ['msisdn' => $user->msisdn]);
        } else {
            Session::flash('error', 'Please enter your phone number');
            return redirect()->back();
        }
    }

    public function otpVerify(Request $request, $msisdn)
    {

        if ($request->method() == 'GET') {
            return view('auth.otp-verify', compact('msisdn'));
        }

        if ($msisdn) {
            $user = User::where('msisdn', $request->msisdn)->first();

            if (!$user) {
                Session::flash('error', 'User not found, please try again');
                return redirect()->route('auth.otp-send');
            }

            if ($user && $user->otp != $request->otp) {
                $user->delete();
                Session::flash('error', 'Otp does not match, please try again');
                return redirect()->route('auth.otp-send');
            }



            $user->otp = null;
            $user->otp_verify = 1;


            // make a default company
            $company = new Company();
            $company->name = $user->name;
            $company->logo = url('logo.png');
            $company->email = null;
            $company->phone = $user->msisdn;
            $company->other_info = 'Default Company';
            $company->save();

            $user->company_id = $company->id;
            $user->save();

            $user->assignRole('super-admin');

            Auth::login($user);
            $request->session()->put('loginId', $user->id);
            $request->session()->put('company_id', $user->company_id);


            Session::flash('success', 'Successfully logged in');
            return redirect()->route('home');
        } else {
            Session::flash('error', 'Please enter your phone number');
            return redirect()->back();
        }
    }


    // Registers

    public function register(Request $request, $msisdn)
    {


        if ($request->method() == 'GET') {
            if ($msisdn) {
                return view('auth.register', ['msisdn' => $msisdn]);
            } else {
                return redirect()->route('auth.otp-send');
            }
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
                $fileExtension = $file->getClientOriginalExtension();  // Get the file extension
                $fileName = uniqid() . '.' . $fileExtension;

                // Move the file to the destination path
                $file->move($destinationPath, $fileName);

                // Store the file path to save in the database
                $logoPath = 'images/user/' . $fileName;

                // Example of saving it to a model
                $company->logo = $logoPath;
            } else {
                $company->logo = '/images/inventory_logo.png';
            }
            $company->address = $request->company_address;
            $company->other_info = $request->other_info;
            $company->save();




            $user = User::select()->where('msisdn', '=', $msisdn)->where('otp_verify', '=', 1)->first();

            if (!$user) {
                DB::rollBack();
                Session::flash('error', 'Phone number registration is required. Please complete it now.');
                return redirect()->route('auth.otp-send');
            }


            $user->name = $request->user_name;
            $user->email = $request->user_email;
            $user->password = Hash::make($request->user_password);
            $user->company_id = $company->id;
            $user->save();
            $user->assignRole('super-admin');

            $transactionType = new TransactionType();
            $transactionType->name = 'cash';
            $transactionType->company_id = $company->id;
            $transactionType->added_by = $user->id;
            $transactionType->save();

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
        return redirect()->route('auth.login');
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
