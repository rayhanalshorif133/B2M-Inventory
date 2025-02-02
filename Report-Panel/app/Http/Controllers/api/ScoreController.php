<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\Campaign;
use App\Models\User;
use App\Models\Subscription;
use Carbon\Carbon;
use Symfony\Component\Process\Process;

class ScoreController extends Controller
{
    // score
    function getCurrentUrl()
    {
        // Check if HTTPS is used
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
            ? "https://"
            : "http://";

        // Construct the full URL
        $currentUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        return $currentUrl;
    }


    public function score(Request $request)
    {


        try {



            $pengenal = $request->pengenal;
            $puntaje = $request->puntaje;
            $macAddress = $request->mac;






            if ($pengenal == null || $puntaje == null) {
                return response()->json('Invalid Request, required pengenal and puntaje');
            }



            $pengenal = json_decode($pengenal, true);
            $puntaje = json_decode($puntaje, true);

            $pengenal = $this->decryptData($pengenal['key'], $pengenal['salt'], $pengenal['iv'], $pengenal['ciphertext']);
            $puntaje = $this->decryptData($puntaje['key'], $puntaje['salt'], $puntaje['iv'], $puntaje['ciphertext']);

            $parts = explode('_', $pengenal);
            $msisdn = $parts[0] ?? "0";
            $keyword = $parts[1] ?? "0";
            $campaign_id = $parts[2] ?? "0";
            $get_score = $puntaje;



            // FIND SUBSCRIPTION
            $subscription_id = null;
            if ($campaign_id != 'free') {
                $subscription = Subscription::where('msisdn', '=',  $msisdn)
                    ->where('campaign_id', '=', $campaign_id)
                    ->where('status', '=', 1)
                    ->first();
                if ($subscription) {
                    $subscription_id = $subscription->id;
                }
            }


            $score = new Score();
            $score->status = 1;
            $score->message = 'Score achieved!';
            $score->subscription_id = $subscription_id;

            if ($campaign_id == 'free') {
                $campaign_id = null;
                $score->status = 0;
                $score->message = 'Free Score';
            }

            if ($score->subscription_id == null) {
                $score->status = 0;
                // Has Campaign But Not Subscriber yet
                $score->message = 'Has Campaign But Not Subscriber yet';
            }

            $score->campaign_id = $campaign_id;

            $score->msisdn = $msisdn;
            $score->score = $get_score;
            $score->encrypted_score = null;
            $score->game_keyword = $keyword;
            $score->device_type = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
            $score->user_mac = null;
            $score->mac = $request->mac ? $request->mac : "Unknown";
            $score->date_time = date('Y-m-d H:i:s');
            $score->hit_url = $this->getCurrentUrl();
            $score->save();

            return response()->json([
                'type' => 'success',
                'score' => $score,
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }




    function decryptData($key, $salt, $iv, $ciphertext)
    {

        $key = str_replace(" ", "+", $key);
        $salt = str_replace(" ", "+", $salt);
        $iv = str_replace(" ", "+", $iv);
        $ciphertext = str_replace(" ", "+", $ciphertext);

        $method = "AES-256-CBC"; // Ensure this matches the encryption method used
        $key = base64_decode($key);
        $iv = base64_decode($iv);
        $ciphertext = base64_decode($ciphertext);

        // Decrypt
        $decrypted = openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);

        return $decrypted;
    }





    function xorEncryptDecrypt($data, $key)
    {
        $outText = '';
        for ($i = 0; $i < strlen($data); $i++) {
            $outText .= chr(ord($data[$i]) ^ ord($key[$i % strlen($key)]));
        }
        return $outText;
    }







    public function score_back(Request $request)
    {



        $pengenal = $request->pengenal;
        $puntaje = $request->puntaje;
        $macAddress = $request->mac;




        if ($pengenal == null || $puntaje == null) {
            return response()->json('Invalid Request, required pengenal and puntaje');
        }



        $hasAlready = Score::where('encrypted_score', 'LIKE', "%$puntaje%")->first();


        // $key = "B2M_T3chN0l0g!@$";
        $key = "t>B&Z:_NZm33k61k";
        $modifiedString = str_replace(' ', '+', $pengenal);
        $modifiedStringPuntaje = str_replace(' ', '+', $puntaje);
        $pengenals = $this->decrypt($modifiedString, $key);
        $parts = explode('_', $pengenals);
        $game_keyword = $parts[1] ?? "0";
        $msisdn = $parts[0] ?? "0";
        $get_score = $this->decrypt($modifiedStringPuntaje, $key);


        try {






            $campaign = $this->getCurrentCampaign();

            $date = date('Y-m-d');
            $time = date('H:i:s');


            $isInactiveUser = User::select()->where('msisdn', '=',  $msisdn)->where('status', '=', 0)->first();

            if ($isInactiveUser) {
                return response()->json('Inactive User');
            }


            $isMatchingMacAddress = User::select()->where('msisdn', '=', $msisdn)->where('mac', '=', $macAddress)->first();



            $subscription = Subscription::where('msisdn', '=',  $msisdn)
                ->where('campaign_id', '=', $campaign->id)
                ->where('status', '=', 1)
                ->whereDate('subs_date', $date)
                ->first();



            $getUserMac = User::select()->where('msisdn', '=',  $msisdn)->where('status', '=', 1)->first();


            // check same time set score


            $currentTime = Carbon::now();
            $formattedTime = $currentTime->subSeconds(5)->format('Y-m-d H:i:s');

            $getTTTTTscores = Score::where('msisdn', $msisdn)
                ->where('date_time', '>=', $formattedTime)
                ->first();

            if ($getTTTTTscores) {
                return response()->json('Success');
            }



            $score = new Score();
            $score->msisdn = $msisdn;
            $score->encrypted_score = $puntaje;
            $score->campaign_id = $campaign->id;
            $score->device_type = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
            $score->score = $get_score;
            $score->game_keyword = $game_keyword;
            $score->user_mac = $getUserMac->mac;
            $score->mac = $request->mac ? $request->mac : "Unknown";
            $score->save();

            if ($subscription && $time >= '10:00:00' && $time <= '23:59:59') {
                $score->status = 1;
                $score->subscription_id = $subscription->id;
                $score->message = 'success';
            } else {
                $score->status = 0;
                $score->message = 'Matching';
            }

            if ($hasAlready) {
                $score->status = 0;
                $score->subscription_id = null;
                $score->message = 'duplicate score';
            }


            if (!$isMatchingMacAddress) {
                $score->status = 0;
                $score->message = 'Not Matching Mac Address';
                $score->subscription_id = null;
            }

            // message

            $score->date_time = date('Y-m-d H:i:s');
            $score->hit_url = $this->getCurrentUrl();
            $score->save();


            // update mac
            $getUser = User::select()->where('msisdn', '=',  $msisdn)->where('status', '=', 1)->first();
            $getUser->mac = $this->getMacAddress(20);
            $getUser->save();




            return response()->json([
                'type' => 'success',
                'mac' => $getUser->mac,
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
