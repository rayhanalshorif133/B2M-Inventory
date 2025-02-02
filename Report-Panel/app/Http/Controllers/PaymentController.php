<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\ChargeLog;
use App\Models\Game;
use App\Models\PaymentCreate;
use App\Models\PaymentExecute;
use App\Models\Subscription;
use App\Models\SubUnsubsLog;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function getToken()
    {
        session()->forget('bkash_token');

        $request_data = array(
            'app_key'        => '2l6u3m4i01ed69foin29vp42m',
            'app_secret'    => '1d2qur3hm323h26h6a0m5pqucka8qkaae5drfimo4vejabo032qi'
        );
        $header = array(
            'Content-Type:application/json',
            'username:BDGAMERS',
            'password:B@1PtexcaQMvb'
        );
        /* production */
        $url = curl_init('https://checkout.pay.bka.sh/v1.2.0-beta/checkout/token/grant');
        $request_data_json = json_encode($request_data);

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($url, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($url);
        curl_close($url);

        $response = json_decode($response, true);

        session()->put('bkash_token', $response['id_token']);

        return $response['id_token'];
    }


    public function createPayment(Request $request, $msisdn)
    {
        $this->getToken();

        $id_token = session()->get('bkash_token');


        // get Cam
        $campaign = Campaign::select()->where('id', $request->campaign_id)->first();
        $invoice_no = $this->getInvoiceNo();
        $payCreate = new PaymentCreate();
        $payCreate->token = $id_token;
        $payCreate->invoice_no = $invoice_no;
        $payCreate->user_msisdn = $msisdn;
        $payCreate->keyword = $campaign->game_keyword;
        $payCreate->campaign_id = $request->campaign_id;
        $payCreate->save();

        $request_data = array(
            'amount'                => $campaign->amount,
            'currency'                => 'BDT',
            'intent'                => 'sale',
            'merchantInvoiceNumber'    => $invoice_no
        );



        $url = curl_init('https://checkout.pay.bka.sh/v1.2.0-beta/checkout/payment/create');
        $request_data_json = json_encode($request_data);
        $header = array(
            'Content-Type:application/json',
            "authorization: $id_token",
            'x-app-key:2l6u3m4i01ed69foin29vp42m'
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($url, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($url);
        curl_close($url);

        $response = json_decode($response, true);

        $payCreate->payment_id = $response['paymentID'];
        $payCreate->amount = $response['amount'];
        $payCreate->response = $response;
        $payCreate->save();

        return $response;
    }

    public function executePayment(Request $request, $msisdn, $paymentID)
    {
        sleep(10);
        $payCreate = PaymentCreate::select()->where('payment_id', $paymentID)->first();
        $campaign = Campaign::select()->where('id', $payCreate->campaign_id)->first();

        // Subscription
        $redirectURL  = "";

        $date = date("Y-m-d");
        $subs = "";
        $hasSubs = Subscription::where('msisdn', $payCreate->user_msisdn)
            ->where('campaign_id', $payCreate->campaign_id)
            ->whereDate('subs_date', $date)
            ->first();
        $subsUnsubs = new SubUnsubsLog();

        if ($hasSubs) {
            $subs = $hasSubs;
            $subsUnsubs->message = 'Duplicate Try';
            $redirectURL = '/?payment=duplicate_try&campaign_id=' . $payCreate->campaign_id;
        } else {
            $subs = new Subscription();
            $id_token = session()->get('bkash_token');

            $payment_url = 'https://checkout.pay.bka.sh/v1.2.0-beta/checkout/payment/execute/' . $paymentID;
            $url = curl_init($payment_url);
            $header = array(
                'Content-Type:application/json',
                "authorization: $id_token",
                'x-app-key:2l6u3m4i01ed69foin29vp42m'
            );
            curl_setopt($url, CURLOPT_HTTPHEADER, $header);
            curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($url, CURLOPT_TIMEOUT, 30);
            $response = curl_exec($url);
            curl_close($url);
            $payExe = new PaymentExecute();
            $payExe->campaign_id = $payCreate->campaign_id;
            $payExe->payment_create_id = $payCreate->id;
            $payExe->keyword = $payCreate->keyword;
            $payExe->user_msisdn = $payCreate->user_msisdn;
            $payExe->response = $response;

            $response = json_decode($response, true);


            if (isset($response['errorCode'])) {
                $payExe->error_code = $response['errorCode'];
                $payExe->error_message = $response['errorMessage'];
                $payExe->amount = $payCreate->amount;
                $payExe->invoice_no = $payCreate->invoice_no;
                $payExe->payment_id = $payCreate->payment_id;
                $payExe->transaction_status = 'failed';
                $redirectURL = '/?payment=failed&campaign_id=' . $payCreate->campaign_id;
                $payExe->save();
                return redirect($redirectURL);
            } else {
                $payExe->invoice_no = $response['merchantInvoiceNumber'];
                $payExe->payment_id = $response['paymentID'];
                $payExe->bkash_msisdn = $response['customerMsisdn'];
                $payExe->amount = $response['amount'];
                $payExe->trxID = $response['trxID'];
                $payExe->transaction_status = $response['transactionStatus'];
                $payExe->error_message = "";
                $redirectURL = '/?payment=success&campaign_id=' . $payCreate->campaign_id;
                $payExe->save();
            }
            // charge log
            $charge = new ChargeLog();
            $charge->payment_id = $paymentID;
            $charge->campaign_id = $payCreate->campaign_id;
            $charge->msisdn = $payCreate->user_msisdn;
            $charge->keyword = $payCreate->keyword;
            $charge->amount = $payExe->amount;
            $charge->type = 'subs';
            $charge->charge_date = $date;
            $charge->save();

            $subsUnsubs->message = 'success';

            $campaign->incrementParticipation();
        }

        $subs->campaign_id = $payCreate->campaign_id;
        $subs->msisdn = $payCreate->user_msisdn;
        $subs->payment_id = $paymentID;
        $subs->keyword = $payCreate->keyword;
        $subs->subs_date = $date;
        $subs->status = 1;
        $subs->save();



        // subs unsubs log
        $subsUnsubs->msisdn = $payCreate->user_msisdn;
        $subsUnsubs->subscription_id = $subs->id;
        $subsUnsubs->payment_id = $paymentID;
        $subsUnsubs->type = 'subs';
        $subsUnsubs->keyword = $payCreate->keyword;
        $subsUnsubs->status = 1;

        $subsUnsubs->date = $date;
        $subsUnsubs->save();


        return redirect($redirectURL);
    }

    // public function queryPayment(Request $request)
    // {
    //     $token = session()->get('bkash_token');
    //     $paymentID = $request->payment_info['payment_id'];

    //     $url = curl_init("$this->base_url/checkout/payment/query/" . $paymentID);
    //     $header = array(
    //         'Content-Type:application/json',
    //         "authorization:$token",
    //         "x-app-key:$this->app_key"
    //     );

    //     curl_setopt($url, CURLOPT_HTTPHEADER, $header);
    //     curl_setopt($url, CURLOPT_CUSTOMREQUEST, "GET");
    //     curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
    //     $resultdata = curl_exec($url);
    //     curl_close($url);
    //     return json_decode($resultdata, true);
    // }


    public function getInvoiceNo()
    {

        $invoice_no = rand(111111, 999999);

        $findIsExist = PaymentCreate::select()->where('invoice_no', $invoice_no)->first();

        if ($findIsExist) {
            $this->getInvoiceNo();
        }
        return $invoice_no;
    }
}
