<?php

namespace App\Http\Controllers;

use App\Models\Bkash;
use App\Models\BkashLog;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class BkashController extends Controller
{
    public function auth(Request $request)
    {
        try {


            if ($request->username != 'bkash' || $request->password != 'b2mbkash' || $request->mobile_number == null) {
                return response()->json([
                    'message' => 'Invalid User Data',
                ]);
            }


            // find by mobile number
            $bkash = Bkash::where('mobile_number', $request->mobile_number)->first();

            if ($bkash) {
                $bkash->status = 'active';
            } else {
                $bkash = Bkash::create([
                    'mobile_number' => $request->mobile_number,
                    'status' => 'active',
                ]);
            }

            $bkash->id_token = $bkash->generateToken(40);
            $bkash->save();

            $response = [
                'id_token' => $bkash->id_token,
                'update_time' => $bkash->updated_at,
            ];

            $bkash->response = $response;
            $bkash->save();



            if ($bkash) {
                BkashLog::create([
                    'mobile_number' => $request->mobile_number,
                    'id_token' => $bkash->id_token,
                    'created_date' => now(),
                    'created_time' => now(),
                    'exp_time' => now()->addHour(),
                ]);
                return response()->json($response);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ]);
        }
    }


    public function login(Request $request, $id_token)
    {
        try {
            $bkash = Bkash::where('id_token', 'LIKE', '%' . $id_token . '%')->first();

            if ($bkash) {

                $bkashLog = BkashLog::where('id_token', 'LIKE', '%' . $id_token . '%')->first();

                if ($bkashLog && Carbon::parse($bkashLog->exp_time)->isPast()) {
                    return response()->json([
                        'message' => 'Token Expired',
                    ]);
                }

                if(Auth::check()){
                    Auth::logout();
                }

                $user = User::where('phone', $bkash->mobile_number)->first();
                if ($user) {
                    Auth::login($user);
                } else {
                    $player = User::create([
                        'phone' => $bkash->mobile_number,
                        'password' => Hash::make($bkash->password),
                    ]);
                    $player->assignRole('player');
                    Auth::login($player);
                }
                $request->session()->regenerate();
                Session::flash('success', 'Login successful!');
                return redirect()->route('home');
            } else {
                Session::flash('error', 'Invalid credentials. Please try again.');
                return redirect()->route('home');
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ]);
        }
    }
}
