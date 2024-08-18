<?php

use App\Models\PaymentList;
use App\Models\PurchasePayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;

// Type 1 for Purchase Payment, 2 = Purchase Payment Returns
// Type 3 for Sales Payment, 4 = Sales Payment Returns
function paymentLogSend($transaction_type_id,$type,$amount,$ref_id)
{
    $curl = curl_init();
    $url = url('/api/log/transection?transaction_type_id=' . $transaction_type_id
        . '&type=' . $type .'&amount=' . $amount . '&ref_id=' . $ref_id);
    // Set cURL options
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response as a string instead of outputting it
    curl_setopt($curl, CURLOPT_TIMEOUT, 1); // Set a timeout for the request (in seconds)
    curl_exec($curl);
    curl_close($curl);

}


function purchasePaymentReceiptNo(){
    $purchasePayment = PurchasePayment::where('company_id', Auth::user()->company_id)->orderBy('id', 'desc')->first();
    if ($purchasePayment && $purchasePayment->receipt_no) {
        $last__code = intval(explode("-", $purchasePayment->receipt_no)[1]);
        $last__code++;
        $receipt_no = 'PS-' . str_pad($last__code, 6, '0', STR_PAD_LEFT);
    } else {
        $receipt_no = 'PS-000001';
    }
    return $receipt_no;
}




