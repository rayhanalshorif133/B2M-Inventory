<?php

use App\Models\PurchasePayment;
use App\Models\SalesPayment;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnPayment;
use App\Models\SalesReturn;
use App\Models\SalesReturnPayment;
use Illuminate\Support\Facades\Auth;






function purchasePaymentReceiptNo()
{
    $purchasePayment = PurchasePayment::where('company_id', Auth::user()->company_id)->orderBy('id', 'desc')->first();
    if ($purchasePayment && $purchasePayment->receipt_no) {
        $last__code = intval(explode("-", $purchasePayment->receipt_no)[1]);
        $last__code++;
        $receipt_no = 'PR-' . str_pad($last__code, 6, '0', STR_PAD_LEFT);
    } else {
        $receipt_no = 'PR-000001';
    }
    return $receipt_no;
}

// Type 1 for Purchase Payment, 2 = Purchase Payment Returns
// Type 3 for Sales Payment, 4 = Sales Payment Returns.
function paymentLogSend($transaction_type_id, $type, $amount, $ref_id)
{
    $curl = curl_init();
    $url = url('/api/log/transection?transaction_type_id=' . $transaction_type_id
        . '&type=' . $type . '&amount=' . $amount . '&ref_id=' . $ref_id);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response as a string instead of outputting it
    curl_setopt($curl, CURLOPT_TIMEOUT, 1); // Set a timeout for the request (in seconds)
    curl_exec($curl);
    curl_close($curl);
}

function productLogSend($productAttribute_id, $type, $qty, $ref_id)
{
    /* <- Product log send ->*/
    $curl = curl_init();
    $url = url('/api/log/product?product_attribute_id=' . $productAttribute_id
        . '&type=' . $type . '&qty=' . $qty . '&ref_id=' . $ref_id);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 3);
    curl_exec($curl);
    curl_close($curl);
}

function salesPaymentReceiptNo()
{
    $purchasePayment = SalesPayment::where('company_id', Auth::user()->company_id)->orderBy('id', 'desc')->first();
    if ($purchasePayment && $purchasePayment->receipt_no) {
        $last__code = intval(explode("-", $purchasePayment->receipt_no)[1]);
        $last__code++;
        $receipt_no = 'MR-' . str_pad($last__code, 6, '0', STR_PAD_LEFT);
    } else {
        $receipt_no = 'MR-000001';
    }
    return $receipt_no;
}

function purchasePaymentReturnReceiptNo()
{
    $purchasePaymentReturnRec = PurchaseReturnPayment::where('company_id', Auth::user()->company_id)->orderBy('id', 'desc')->first();
    if ($purchasePaymentReturnRec && $purchasePaymentReturnRec->receipt_no) {
        $last__code = intval(explode("-", $purchasePaymentReturnRec->receipt_no)[1]);
        $last__code++;
        $receipt_no = 'PRR-' . str_pad($last__code, 6, '0', STR_PAD_LEFT);
    } else {
        $receipt_no = 'PRR-000001';
    }
    return $receipt_no;
}


function salesPaymentReturnReceiptNo()
{
    $salesPaymentReturnRec = SalesReturnPayment::where('company_id', Auth::user()->company_id)->orderBy('id', 'desc')->first();
    if ($salesPaymentReturnRec && $salesPaymentReturnRec->receipt_no) {
        $last__code = intval(explode("-", $salesPaymentReturnRec->receipt_no)[1]);
        $last__code++;
        $receipt_no = 'MRR-' . str_pad($last__code, 6, '0', STR_PAD_LEFT);
    } else {
        $receipt_no = 'MRR-000001';
    }
    return $receipt_no;
}

function getPurchaseReturnCode()
{
    $purchaseReturn = PurchaseReturn::where('company_id', Auth::user()->company_id)->orderBy('id', 'desc')->first();

    if ($purchaseReturn && $purchaseReturn->code) {
        $last__code = intval(explode("-", $purchaseReturn->code)[1]);
        $last__code++;
        $code = 'PURR-' . str_pad($last__code, 6, '0', STR_PAD_LEFT);
    } else {
        $code = 'PURR-000001';
    }
    return $code;
}

function getSalesReturnCode()
{
    $salesReturn = SalesReturn::where('company_id', Auth::user()->company_id)->orderBy('id', 'desc')->first();

    if ($salesReturn && $salesReturn->code) {
        $last__code = intval(explode("-", $salesReturn->code)[1]);
        $last__code++;
        $code = 'SRR-' . str_pad($last__code, 6, '0', STR_PAD_LEFT);
    } else {
        $code = 'SRR-000001';
    }
    return $code;
}
